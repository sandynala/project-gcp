<?php

/**
 * Plugin Name: KWS Admin Kit
 * Plugin URI: https://kwstech.in/
 * Description: WordPress administration front end toolkit plugin for KWSTech Projects
 * Version: 1.0.0
 * Author: KWS Tech
 * Author URI: https://kwstech.in/
 * Text Domain: kws-admin-kit
 * Domain Path: /languages
 * Elementor requires at least: 3.0.0
 * Elementor tested up to: 3.9
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// Some pre define value for easy use
define( 'KWSADM_VER', '1.0.0' );
define( 'KWSADM__FILE__', __FILE__ );
define( 'KWSADM_PNAME', basename( dirname( KWSADM__FILE__ ) ) );
define( 'KWSADM_PBNAME', plugin_basename( KWSADM__FILE__ ) );
define( 'KWSADM_PATH', plugin_dir_path( KWSADM__FILE__ ) );
define( 'KWSADM_MODULES_PATH', KWSADM_PATH . 'modules/' );
define( 'KWSADM_INC_PATH', KWSADM_PATH . 'includes/' );
define( 'KWSADM_URL', plugins_url( '/', KWSADM__FILE__ ) );
define( 'KWSADM_ASSETS_URL', KWSADM_URL . 'assets/' );
define( 'KWSADM_ASSETS_PATH', KWSADM_PATH . 'assets/' );
define( 'KWSADM_MODULES_URL', KWSADM_URL . 'modules/' );
define( 'KWSADM_ADM_PATH', KWSADM_PATH . 'admin/' );
define( 'KWSADM_ADM_ASSETS_URL', KWSADM_URL . 'admin/assets/' );

define( 'KWSADM_THEME_PATH', KWSADM_PATH . 'theme/' );
define( 'KWSADM_THEME_URL', KWSADM_URL . 'theme/' );

define( 'KWSADM_UTILS_DIR', KWSADM_MODULES_PATH . 'utils');
define( 'KWSADM_UTILS_URL', KWSADM_ADM_ASSETS_URL );

function kws_get_user_admin_color() {
	$user_id = get_current_user_id();
	$user_info = get_userdata($user_id);
	if ( !( $user_info instanceof WP_User ) ) {
		return;
	}
	$user_admin_color = $user_info->admin_color;
	return $user_admin_color;
}

require KWSADM_THEME_PATH . 'admin-theme.php';

require KWSADM_MODULES_PATH . 'post-types/post-type-changer.php';
require KWSADM_MODULES_PATH . 'utils/validate-require.php';
require KWSADM_MODULES_PATH . 'utils/misc-additions.php';
require KWSADM_MODULES_PATH . 'utils/customize-admin.php';