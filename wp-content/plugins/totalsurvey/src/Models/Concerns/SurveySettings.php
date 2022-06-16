<?php

namespace TotalSurvey\Models\Concerns;
! defined( 'ABSPATH' ) && exit();


use TotalSurvey\Models\Content;
use TotalSurvey\Models\WorkflowRule;
use TotalSurvey\Tasks\Surveys\RenderSurvey;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\Exception;
use TotalSurveyVendors\TotalSuite\Foundation\Exceptions\ModuleException;
use TotalSurveyVendors\TotalSuite\Foundation\Support\Collection;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Modules\Manager;

/**
 * Trait SurveySettings
 *
 * @package TotalSurvey\Models\Concerns
 */
trait SurveySettings
{
    /**
     * @param  string  $key
     * @param  null  $default
     *
     * @return mixed
     */
    public function getSettings($key, $default = null)
    {
        return $this->getAttribute("settings.{$key}", $default);
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->getAttribute('settings.design.template', 'default-template');
    }

    /**
     * @param            $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function getDesignSettings($key, $default = null)
    {
        return $this->getSettings("design.{$key}", $default);
    }

    /**
     * @return mixed
     */
    public function getWelcomeBlocks()
    {
        return $this->getAttribute('settings.contents.welcome')->blocks;
    }

    /**
     * @return mixed
     */
    public function getThankYouBlocks()
    {
        return $this->getAttribute('settings.contents.thankyou')->blocks;
    }

    /**
     * @param $name
     * @param  string  $default
     *
     * @return string|Content[]
     */
    public function getContent($name, $default = '')
    {
        $path = "settings.contents.{$name}";

        if ($this->getAttribute(sprintf("%s.enabled", $path), false)) {
            if ($this->hasAttribute($path.'.blocks')) {
                $contents = [];

                foreach ($this->getAttribute("{$path}.blocks", []) as $block) {
                    $contents[] = new Content(null, $block);
                }

                return $contents;
            }

            return trim($this->getAttribute("{$path}.content", ''));
        }

        return $default;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function isLimitationEnabled($name): bool
    {
        return $this->getSettings("limitations.{$name}.enabled", false) === true;
    }

    /**
     * @param  string  $name
     * @param  string  $param
     * @param  null  $default
     *
     * @return mixed
     */
    public function getLimitationParams($name, $param, $default = null)
    {
        return $this->getSettings("limitations.{$name}.{$param}", $default);
    }

    public function isPreview()
    {
        return $this->getAttribute('preview', false) === true;
    }

    /**
     * @throws Exception
     * @throws ModuleException
     */
    public function render()
    {
        $template = Manager::instance()->loadTemplate($this->getTemplate());

        return RenderSurvey::invoke($template, $this);
    }

    /**
     * @return Collection<WorkflowRule>|WorkflowRule[]
     */
    public function getWorkflowRules()
    {
        return Collection::create($this->getSettings('workflow.rules', []))
                         ->transform(
                             function ($rule) {
                                 return new WorkflowRule($this, $rule);
                             }
                         );
    }

    /**
     * @return string
     */
    public function getCustomCss()
    {
        return $this->getDesignSettings('customCss', '');
    }
}
