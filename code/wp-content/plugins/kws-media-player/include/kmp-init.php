<?php 

namespace KwsMediaPlayer;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


add_action( 'elementor/frontend/after_register_scripts', function() {
    wp_register_script( 'cf-audio-player', KMP_ASSETS_URL . '/js/kmp-audio-player.js');

    wp_enqueue_script( 'jquery-ui-slider' );//Audio Player	

});


add_action( 'elementor/frontend/after_register_styles', function() {
    wp_register_style( 'cf-audio-player', KMP_ASSETS_URL . '/css/kmp-audio-player.css' );

    //wp_enqueue_style( 'frontend-style-1' );
});


add_action( 'elementor/preview/enqueue_styles', function() {
	wp_enqueue_style( 'cf-audio-player' );
});
