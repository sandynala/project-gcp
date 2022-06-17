<?php

namespace TotalSurveyVendors\TotalSuite\Foundation\WordPress\Admin;
! defined( 'ABSPATH' ) && exit();


use TotalSurveyVendors\TotalSuite\Foundation\View\Engine;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Options;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Plugin;
use TotalSurveyVendors\TotalSuite\Foundation\WordPress\Tasks\Marketing\StoreUninstallFeedback;

class UninstallFeedback
{
    public function __construct()
    {
        add_action('pre_current_active_plugins', [$this, 'row']);
        add_action('wp_ajax_uninstall_feedback_for_' . Plugin::env('product.id'), [$this, 'collect']);
    }

    public function row()
    {
        echo Engine::instance()->render('marketing::uninstall-feedback', ['product' => Plugin::env('product.id'),]);
    }

    public function collect()
    {
        if (current_user_can('manage_options')) {
            StoreUninstallFeedback::invoke(Options::instance()->withKey('marketing'), Plugin::request('feedback'));
        }

        wp_send_json_success();
    }
}
