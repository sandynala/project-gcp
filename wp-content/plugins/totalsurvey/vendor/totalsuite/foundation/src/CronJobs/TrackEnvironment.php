<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\CronJobs;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Contracts\TrackingStorage;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Definition;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Scheduler\CronJob;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Tracking\SendTrackingRequest;

class TrackEnvironment extends CronJob
{
    /**
     * @throws Exception
     */
    public function execute()
    {
        $url = Plugin::env('url.tracking.environment');

        SendTrackingRequest::invoke($url, $this->getData());
    }

    /**
     * @return string
     */
    public function getRecurrence()
    {
        return Scheduler::SCHEDULE_WEEKLY;
    }

    /**
     * @return int
     */
    public function getStartTime()
    {
        return time();
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getData()
    {
        global $wpdb;

        // Env
        $data = array_map(
            static function ($item) {
                return substr(str_replace('.', '', $item), 0, 3);
            },
            [
                'php' => phpversion(),
                'mysql' => $wpdb->db_version(),
                'wordpress' => get_bloginfo('version'),
                'product' => Plugin::env('version')
            ]);

        $data['locale'] = get_locale();

        // Usage
        /**
         * @var Options $options
         */
        $options = Plugin::get(TrackingStorage::class);

        $events = Collection::create($options->get('features', []))
                            ->map(
                                static function ($event) {
                                    return $event['date'];
                                }
                            )
                            ->all();

        $data['firstUsage'] = Plugin::firstUsage();

        if (!empty($events)) {
            $data['lastUsage'] = max($events);
        } else {
            $data['lastUsage'] = $data['firstUsage'];
        }

        $options->set('screens', []);
        $options->set('features', []);

        $options->save();

        // Modules
        $manager = Manager::instance();
        $modules = $manager->fetchLocal()->map(function (Definition $definition) {
            return [
                'id' => $definition->get('id'),
                'version' => $definition->get('version'),
                'activated' => (bool)$definition->get('activated', false)
            ];
        });

        $data['modules'] = $modules->values()->all();

        // Objects
        $data['objects'] = Plugin::instance()->objectsCount();

        // Options
        $data['options'] = [
            'showCredits' => Plugin::env('general.showCredits', false),
            'wipeOnUninstall' => Plugin::env('uninstall.wipeOnUninstall', false),
            'hashIP' => Plugin::env('privacy.hashIP', false),
            'hashAgent' => Plugin::env('privacy.hashAgent', false),
            'honorDNT' => Plugin::env('privacy.honorDNT', false)
        ];

        return $data;
    }
}