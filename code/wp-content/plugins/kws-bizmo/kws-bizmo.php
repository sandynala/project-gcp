<?php
/**
 * Plugin Name: KWS Bizmo
 * Description: Business Module Plugin for KWS Projects
 * Plugin URI: https://kwstech.in/wordpress/BIZMOmo
 * Author: KWSTech.in
 * Version: 1.0.0
 * Author URI: https://kwstech.in
 *
 * Text Domain: kwstech
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'BIZMO_VERSION', '1.0.0' );

define( 'BIZMO__FILE__', __FILE__ );
define( 'BIZMO_PLUGIN_BASE', plugin_basename( BIZMO__FILE__ ) );
define( 'BIZMO_PATH', plugin_dir_path( BIZMO__FILE__ ) );

define( 'BIZMO_QUERY_PATH', BIZMO_PATH . 'queries/' );
define( 'BIZMO_UTILS_PATH', BIZMO_PATH . 'utils/' );
define( 'BIZMO_KWSES_DIR', BIZMO_PATH . 'search/' );
define( 'BIZMO_POSTSYNERGY_PATH', BIZMO_PATH . 'post-synergy/' );

if ( defined( 'BIZMO_TESTS' ) && BIZMO_TESTS ) {
	define( 'BIZMO_URL', 'file://' . BIZMO_PATH );
} else {
	define( 'BIZMO_URL', plugins_url( '/', BIZMO__FILE__ ) );
}

define( 'BIZMO_BASENAME', plugin_dir_path( BIZMO__FILE__ ) );
define( 'BIZMO_DIR_BASENAME', basename( dirname( BIZMO__FILE__ ) ) );


require BIZMO_QUERY_PATH . 'queries-init.php';
require BIZMO_UTILS_PATH . 'utils-init.php';
require BIZMO_UTILS_PATH . 'acf-tools.php';
require BIZMO_UTILS_PATH . 'missed-schedules.php';

require BIZMO_KWSES_DIR . 'extended-search.php';

require_once BIZMO_POSTSYNERGY_PATH . 'module.php';

require_once BIZMO_UTILS_PATH. 'comment-handler.php';

require_once BIZMO_UTILS_PATH. 'custom_mailpoet.php';

require_once BIZMO_UTILS_PATH. 'export-costom-post-type.php';