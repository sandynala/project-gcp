<?php

namespace KwsAdminKit;

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}


class AdminTheme
{
    public function __construct()
    {
        // Enqueue admin scripts for both admin and login view
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        add_action( 'login_enqueue_scripts', [ $this, 'enqueue_styles' ] );

        // Add editor styles if any
        add_action( 'login_enqueue_scripts', [ $this, 'add_editor_styles' ] );

        // Hook footer text
        add_filter('admin_footer_text', [ $this, 'get_admin_footer_text' ] );

        // Add dynamically generated styles
        add_action( 'admin_head', [ $this, 'get_theme_colors' ] );
        add_action( 'login_head', [ $this, 'get_theme_colors' ] );

        if ( is_admin() ) {
            add_filter( 'display_post_states', [ $this, 'clean_post_state' ], 11 );
        }
    }

    public function enqueue_styles()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );

        wp_enqueue_style(
            'kws-admin-theme',
            KWSADM_THEME_URL . 'css/theme' . '.css',
            [],
            KWSADM_VER
        );

        wp_enqueue_script(
            'kws-admin-theme',
            KWSADM_THEME_URL . 'js/theme' . '.js',
            [ 'jquery' ],
            KWSADM_VER
        );
    }

    public function add_editor_styles() {
        add_editor_style( KWSADM_THEME_PATH . 'css/editor-style.css' );
    }

    public function get_admin_footer_text($text)
    {
        $text = 'KWS Admin';
        return $text;
    }

    public function get_theme_colors() {
        include( KWSADM_THEME_PATH . 'css/color-scheme.php' );
    }

    public function clean_post_state( $post_states ) {
        if ( ! empty( $post_states && ! is_customize_preview() && 'Menus' !== get_admin_page_title() ) ) {
            $state_count = count($post_states);
            $i = 0;
            foreach ( $post_states as $state ) {
                ++$i;
                ( $i == $state_count ) ? $sep = '' : $sep = '';
                echo "<span class='post-state'>$state$sep</span>";
            }
        }
    }
}

// Load admin class for admin related content process
new AdminTheme();
