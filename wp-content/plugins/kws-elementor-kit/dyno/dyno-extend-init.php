<?php

if ( ! defined( 'ABSPATH' ) ) 
    exit;


add_action('elementor/widgets/widgets_registered','kekcsx_add_skin_extension');
function kekcsx_add_skin_extension(){
	require_once CFTKEK_PATH . 'skins/skin-custom-extend.php';
}

add_action( 'elementor/frontend/before_enqueue_scripts', 'enqueue_skin_extend_scripts' );
function enqueue_skin_extend_scripts() {
    wp_enqueue_script(
        'dyno-extend',
        CFTKEK_ASSETS_URL . 'js/csx_extend.js',
        [ 'jquery', 'elementor-frontend' ],
        CFTKEK_VER,
        true
    );
}

include_once CFTKEK_PATH . 'modules/dyno-extend/display-conditions.php';
include_once CFTKEK_PATH . 'modules/dyno-extend/dynamic-fields.php';
