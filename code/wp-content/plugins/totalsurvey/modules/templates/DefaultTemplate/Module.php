<?php

namespace TotalSurvey\Templates\DefaultTemplate;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Survey;
use TotalSurvey\Plugin;
use TotalSurvey\Views\Template;

class Module extends Template
{

    protected function registerScripts()
    {
        wp_enqueue_script(
            'totalsurvey-default-template',
            Plugin::env()->isDebug() ? $this->getUrl('assets/js/app.js') : $this->getUrl('assets/js/app.min.js'),
            ['totalsurvey-vue-js'],
            Plugin::env('version'),
            true
        );
    }

    /**
     * @param Survey $survey
     *
     * @param string $template
     *
     * @return string
     */
    public function render(Survey $survey, $template = 'survey'): string
    {
        $this->registerScripts();

        return parent::render($survey, $template);
    }
}
