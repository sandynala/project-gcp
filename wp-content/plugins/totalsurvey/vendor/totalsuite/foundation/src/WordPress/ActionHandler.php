<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\Listener;

abstract class ActionHandler extends Listener
{
    /**
     * Shorthand to add the handler to an event.
     *
     * @param $event
     */
    public static function on($event)
    {
        Plugin::listen($event, static::class);
    }
}