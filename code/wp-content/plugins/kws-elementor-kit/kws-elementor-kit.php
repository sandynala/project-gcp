<?php

/**
 * Plugin Name: KWS Elementor Kit
 * Plugin URI: https://kwstech.in/kws-elementor-kit/
 * Description: KWS Elementor Kit is a packed of post related elementor widgets. This plugin gives you post related widget features for elementor page builder plugin.
 * Version: 1.5.1
 * Author: KWS Tech
 * Author URI: https://kwstech.in/
 * Text Domain: kws-elementor-kit
 * Domain Path: /languages
 * License: GPL3
 * Elementor requires at least: 3.0.0
 * Elementor tested up to: 3.5.1
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Some pre define value for easy use
define( 'CFTKEK_VER', '1.5.1' );
define( 'CFTKEK__FILE__', __FILE__ );
define( 'CFTKEK_PNAME', basename( dirname( CFTKEK__FILE__ ) ) );
define( 'CFTKEK_PBNAME', plugin_basename( CFTKEK__FILE__ ) );
define( 'CFTKEK_PATH', plugin_dir_path( CFTKEK__FILE__ ) );
define( 'CFTKEK_MODULES_PATH', CFTKEK_PATH . 'modules/' );
define( 'CFTKEK_INC_PATH', CFTKEK_PATH . 'includes/' );
define( 'CFTKEK_URL', plugins_url( '/', CFTKEK__FILE__ ) );
define( 'CFTKEK_ASSETS_URL', CFTKEK_URL . 'assets/' );
define( 'CFTKEK_ASSETS_PATH', CFTKEK_PATH . 'assets/' );
define( 'CFTKEK_MODULES_URL', CFTKEK_URL . 'modules/' );
define( 'CFTKEK_ADM_PATH', CFTKEK_PATH . 'admin/' );
define( 'CFTKEK_ADM_ASSETS_URL', CFTKEK_URL . 'admin/assets/' );
define( 'CFTKEK_DYNO_PATH', CFTKEK_PATH . 'dyno/' );



// Notice class
require CFTKEK_ADM_PATH . 'admin-notice.php';
// Widgets filters here
require CFTKEK_INC_PATH . 'kws-elementor-kit-filters.php';
if ( !class_exists( 'KwsElementorKit\\Admin' ) ) {
    require CFTKEK_ADM_PATH . 'admin.php';
}
// Helper function here
require dirname( __FILE__ ) . '/includes/helper.php';
require dirname( __FILE__ ) . '/includes/utils.php';
/**
 * Plugin load here correctly
 * Also loaded the language file from here
 */
function kws_elementor_kit_load_plugin()
{
    load_plugin_textdomain( 'kws-elementor-kit', false, basename( dirname( __FILE__ ) ) . '/languages' );
    
    if ( !did_action( 'elementor/loaded' ) ) {
        add_action( 'admin_notices', 'kws_elementor_kit_fail_load' );
        return;
    }
    
    // Element pack widget and assets loader
    require CFTKEK_PATH . 'loader.php';
}

add_action( 'plugins_loaded', 'kws_elementor_kit_load_plugin' );
/**
 * Check Elementor installed and activated correctly
 */
function kws_elementor_kit_fail_load()
{
    $screen = get_current_screen();
    if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
        return;
    }
    $plugin = 'elementor/elementor.php';
    
    if ( _is_elementor_installed() ) {
        if ( !current_user_can( 'activate_plugins' ) ) {
            return;
        }
        $activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin );
        $admin_message = '<p>' . esc_html__( 'Ops! KWS Elementor Kit not working because you need to activate the Elementor plugin first.', 'kws-elementor-kit' ) . '</p>';
        $admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, esc_html__( 'Activate Elementor Now', 'kws-elementor-kit' ) ) . '</p>';
    } else {
        if ( !current_user_can( 'install_plugins' ) ) {
            return;
        }
        $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
        $admin_message = '<p>' . esc_html__( 'Ops! KWS Elementor Kit not working because you need to install the Elementor plugin', 'kws-elementor-kit' ) . '</p>';
        $admin_message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, esc_html__( 'Install Elementor Now', 'kws-elementor-kit' ) ) . '</p>';
    }
    
    echo  '<div class="error">' . $admin_message . '</div>' ;
}

/**
 * Check the elementor installed or not
 */
if ( !function_exists( '_is_elementor_installed' ) ) {
    function _is_elementor_installed()
    {
        $file_path = 'elementor/elementor.php';
        $installed_plugins = get_plugins();
        return isset( $installed_plugins[$file_path] );
    }

}


