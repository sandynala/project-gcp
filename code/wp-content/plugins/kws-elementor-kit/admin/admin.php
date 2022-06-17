<?php

namespace KwsElementorKit;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class Admin
{
    public function __construct()
    {
        // Admin settings controller
        require CFTKEK_ADM_PATH . 'class-settings-api.php';
        // element pack admin settings here
        require CFTKEK_ADM_PATH . 'admin-settings.php';
        // Embed the Script on our Plugin's Option Page Only
        
        if ( isset( $_GET['page'] ) && $_GET['page'] == 'kws_elementor_kit_options' ) {
            add_action( 'admin_init', [ $this, 'admin_script' ] );
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );
        }
        
        add_filter(
            'plugin_row_meta',
            [ $this, 'plugin_row_meta' ],
            10,
            2
        );
        add_filter( 'plugin_action_links_' . CFTKEK_PBNAME, [ $this, 'plugin_action_meta' ] );
    }
    
    public function enqueue_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_enqueue_style(
            'cft-uikit',
            CFTKEK_ADM_ASSETS_URL . 'css/cft-uikit' . $direction_suffix . '.css',
            [],
            CFTKEK_VER
        );
        wp_enqueue_script(
            'cft-uikit',
            CFTKEK_ADM_ASSETS_URL . 'js/cft-uikit' . $suffix . '.js',
            [ 'jquery' ],
            CFTKEK_VER
        );
        wp_enqueue_style(
            'kws-elementor-kit-font',
            CFTKEK_ASSETS_URL . 'css/kws-elementor-kit-font' . $direction_suffix . '.css',
            [],
            CFTKEK_VER
        );
        wp_enqueue_style(
            'kws-elementor-kit-editor',
            CFTKEK_ASSETS_URL . 'css/kws-elementor-kit-editor' . $direction_suffix . '.css',
            [],
            CFTKEK_VER
        );
        wp_enqueue_style(
            'kws-elementor-kit-admin',
            CFTKEK_ADM_ASSETS_URL . 'css/admin' . $direction_suffix . '.css',
            [],
            CFTKEK_VER
        );
    }
    
    public function plugin_row_meta( $plugin_meta, $plugin_file )
    {
        return $plugin_meta;
    }
    
    public function plugin_action_meta( $links )
    {
        $links = array_merge( [ sprintf( '<a href="%s">%s</a>', kws_elementor_kit_dashboard_link( '#kws_elementor_kit_welcome' ), esc_html__( 'Settings', 'kws-elementor-kit' ) ) ], $links );
        return $links;
    }
    
    public function rate_the_kws_elementor_kit()
    {
        if ( class_exists( 'Notices' ) ) {
            Notices::add_notice( [
                'id'               => 'rate-the-kws-elementor-kit',
                'type'             => 'success',
                'dismissible'      => true,
                'dismissible-time' => 0,
                'message'          => __( '<b>KWS Elementor Kit</b>.', 'kws-elementor-kit' ),
            ] );
        }
    }
    
    /**
     * register admin script
     */
    public function admin_script()
    {
        
        if ( is_admin() ) {
            // for Admin Dashboard Only
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-form' );
        }
    
    }

}
// Load admin class for admin related content process
if ( is_admin() ) {
    if ( !defined( 'CFTKEK_CH' ) ) {
        new Admin();
    }
}