<?php

namespace TotalSurvey\Models;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Exceptions\Surveys\SurveyNotFound;
use TotalSurvey\Exceptions\Surveys\SurveySectionNotFound;
use TotalSurvey\Filters\Surveys\SurveyLinkFilter;
use TotalSurvey\Models\Concerns\SurveySettings;
use TotalSurvey\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\Database\TableModel;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Strings;

/**
 * Class Survey
 *
 * @property int $id
 * @property int $user_id
 * @property string $uid
 * @property string $name
 * @property string $description
 * @property Collection<Section>|Section[] $sections
 * @property array $settings
 * @property string $created_at
 * @property string $updated_at
 * @property string $reset_at
 * @property string $deleted_at
 * @property string $status
 * @property bool $enabled
 *
 * @package TotalSurvey\Models
 */
class Survey extends TableModel
{
    use SurveySettings;

    const STATUS_OPEN    = 'open';
    const STATUS_CLOSED  = 'closed';
    const STATUS_DELETED = 'deleted';

    const ACTION_NEXT       = 'next';
    const ACTION_SECTION    = 'section';
    const ACTION_CONDITIONS = 'conditions';
    const ACTION_SUBMIT     = 'submit';

    /**
     * @var string
     */
    protected $table = 'totalsurvey_surveys';

    /**
     * @var array
     */
    protected $types = [
        'sections' => 'sections',
        'settings' => 'settings',
        'enabled'  => 'bool',
    ];

    /**
     * @var array
     */
    protected $fillable = ['id', 'uid', 'user_id', 'name', 'description', 'status', 'sections', 'settings'];

    /**
     * @return $this
     */
    public function withStatistics(): self
    {
        $entries = Entry::query()
                        ->where('survey_uid', $this->uid)
                        ->get();

        $statistics = [
            'total' => 0,
            'today' => 0,
        ];

        if ($entries !== null) {
            $statistics = [
                'total' => $entries->count(),
                'today' => $entries->where(
                    static function (Entry $entry) {
                        $date = date('d-m-Y', strtotime($entry->created_at));

                        return $date === date('d-m-Y');
                    }
                )
                                   ->count(),
            ];
        }

        $this->setAttribute('statistics', $statistics);

        return $this;
    }


    /**
     * @param  string  $data
     *
     * @return Collection
     * @noinspection PhpUnused
     */
    public function castToSections($data): Collection
    {
        $sections = [];
        $previous = null;

        if (!empty($data)) {
            $data = is_string($data) ? json_decode($data, true) : $data;

            foreach ($data as $index => $section) {
                $section['blocks'] = $section['questions'] ?? $section['blocks'];
                unset($section['questions']);
                $current        = new Section($this, $section);
                $current->index = $index;

                if ($previous instanceof Section) {
                    $current->setPreviousSection($previous);
                    $previous->setNextSection($current);
                }

                $sections[] = $previous = $current;
            }
        }

        return Collection::create($sections);
    }

    public function castToSettings($data)
    {
        $settings = [];
        if (!empty($data)) {
            $settings = is_string($data) ? json_decode($data, true) : $data;

            if (!empty($settings['contents']['welcome']['content'])) {
                $settings['contents']['welcome'] = [
                    'enabled' => $settings['contents']['welcome']['enabled'],
                    'title'   => '',
                    'blocks'  => [
                        [
                            'type'    => 'content',
                            'typeId'  => 'content:paragraph',
                            'uid'     => Strings::uid(),
                            'content' => [
                                'value'   => $settings['contents']['welcome']['content'],
                                'options' => [
                                    'size'      => 'h2',
                                    'alignment' => 'start',
                                ],
                                'type'    => 'paragraph',
                            ],
                        ],
                    ],
                ];
            }

            if (!empty($settings['contents']['thankyou']['content'])) {
                $settings['contents']['thankyou'] = [
                    'enabled' => $settings['contents']['thankyou']['enabled'],
                    'title'   => '',
                    'blocks'  => [
                        [
                            'type'    => 'content',
                            'typeId'  => 'content:paragraph',
                            'uid'     => Strings::uid(),
                            'content' => [
                                'value'   => $settings['contents']['thankyou']['content'],
                                'options' => [
                                    'alignment' => 'start',
                                ],
                                'type'    => 'paragraph',
                            ],
                        ],
                    ],
                ];
            }

            if (empty($settings['contents']['thankyou']['blocks'])) {
                $settings['contents']['thankyou']['blocks'] = [
                    [
                        'type'    => 'content',
                        'typeId'  => 'content:title',
                        'uid'     => Strings::uid(),
                        'content' => [
                            'value'   => __('Thank you!'),
                            'options' => [
                                'size'      => 'h2',
                                'alignment' => 'start',
                            ],
                            'type'    => 'title',
                        ],
                    ],
                    [
                        'type'    => 'content',
                        'typeId'  => 'content:paragraph',
                        'uid'     => Strings::uid(),
                        'content' => [
                            'value'   => __('Entry received. Thank you for participating in this survey!'),
                            'options' => [
                                'alignment' => 'start',
                            ],
                            'type'    => 'paragraph',
                        ],
                    ],
                ];
            }

            $settings['contents']['welcome']  = new Section($this, $settings['contents']['welcome']);
            $settings['contents']['thankyou'] = new Section($this, $settings['contents']['thankyou']);
        }

        return Collection::create($settings);
    }

    /**
     * @param $uid
     *
     * @return Section
     * @throws Exception
     */
    public function getSection($uid): Section
    {
        $section = $this->sections->where(['uid' => $uid])->first();
        SurveySectionNotFound::throwUnless($section, __('Section not found', 'totalsurvey'));

        return $section;
    }

    /**
     * @param  string  $surveyUid
     *
     * @return Survey
     * @throws Exception
     */
    public static function byUid($surveyUid): Survey
    {
        $survey = static::query()->where('uid', $surveyUid)->first();
        SurveyNotFound::throwUnless($survey, __('Survey not found', 'totalsurvey'));

        return $survey;
    }

    /**
     * @param $uid
     *
     * @return Survey
     * @throws Exception
     */
    public static function byUidAndActive($uid): Survey
    {
        $survey = static::query()
                        ->where('uid', $uid)
                        ->where('enabled', true)
                        ->first();

        SurveyNotFound::throwUnless($survey, __('Survey not found', 'totalsurvey'));

        return $survey;
    }

    /**
     * @param $id
     *
     * @return Survey
     * @throws Exception
     */
    public static function byIdAndActive($id): Survey
    {
        $survey = static::query()
                        ->where('id', $id)
                        ->where('enabled', true)
                        ->first();

        SurveyNotFound::throwUnless($survey, __('Survey not found', 'totalsurvey'));

        return $survey;
    }

    /**
     * @return Collection
     */
    public function getEntries()
    {
        return Entry::query()
                    ->where('survey_uid', $this->uid)
                    ->where('status', Entry::STATUS_OPEN)
                    ->get();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $survey        = parent::toArray();
        $survey['url'] = $this->getUrl();


        return $survey;
    }

    /**
     * @param  array  $arguments
     *
     * @return string
     */
    public function getUrl($arguments = [])
    {
        $baseUrl                 = site_url();
        $arguments['survey_uid'] = $this->uid;

        if (Plugin::env()->isPrettyPermalinks()) {
            $base = SurveyLinkFilter::apply('survey');

            $baseUrl = site_url("{$base}/{$this->uid}/");
            unset($arguments['survey_uid']);
        }

        return add_query_arg($arguments, $baseUrl);
    }

    /**
     * @return $this
     */
    public function toPublic(): Survey
    {
        $this->deleteAttribute('settings.limitations');
        $this->deleteAttribute('id');
        $this->deleteAttribute('created_at');
        $this->deleteAttribute('updated_at');
        $this->deleteAttribute('deleted_at');
        $this->deleteAttribute('enabled');
        $this->deleteAttribute('status');

        return $this;
    }
}
