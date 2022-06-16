<?php
/**
 * This code is a modified version of - Extended Search
 * 
 * Extend search functionality to search in selected post meta, taxonomies, post types, and all authors.
 *
 */

defined( 'ABSPATH' ) || exit();

// Define plugin constants.

// Include directory path.
if ( ! defined( 'KWSES_INCLUDES_PATH' ) ) {
	define( 'KWSES_INCLUDES_PATH', BIZMO_KWSES_DIR . 'includes/' );
}

// Admin directory path.
if ( ! defined( 'KWSES_ADMIN_PATH' ) ) {
	define( 'KWSES_ADMIN_PATH', KWSES_INCLUDES_PATH . 'admin/' );
}

// Integration directory path.
if ( ! defined( 'KWSES_INTEGRATIONS_PATH' ) ) {
	define( 'KWSES_INTEGRATIONS_PATH', KWSES_INCLUDES_PATH . 'integrations/' );
}

// Assets directory URL.
if ( ! defined( 'KWSES_ASSETS_URL' ) ) {
	define( 'KWSES_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/' );
}

// Plugin main file name.
if ( ! defined( 'KWSES_FILENAME' ) ) {
	define( 'KWSES_FILENAME', plugin_basename( __FILE__ ) );
}

// Includes library files.
require_once KWSES_INCLUDES_PATH . '/class-kwses-core.php';
require_once KWSES_INCLUDES_PATH . '/class-kwses-search-form.php';
require_once KWSES_INCLUDES_PATH . '/class-kwses-search-widget.php';

// Includes admin files.
if ( is_admin() ) {
	require_once KWSES_ADMIN_PATH . '/class-kwses-admin.php';
	require_once KWSES_ADMIN_PATH . '/class-kwses-settings-cpt.php';
}

// Public functions.

/**
 * KWSES functions.
 *
 * @since 2.0
 * @return KWSES_Core returns KWSES_Core instance.
 */
function KWSES() {
	return KWSES_Core::instance();
}

/**
 * Print or return KWSES search form.
 *
 * @since 2.0
 * @param array $args Search form arguments.
 * @param bool  $print true for print false to return. Default true.
 * @return string Search form HTML.
 */
function kwses_search_form( $args, $print = true ) {
	if ( true == $print ) {
		echo KWSES()->kwses_search_form->get_search_form( $args );
		return;
	}

	return KWSES()->kwses_search_form->get_search_form( $args );
}

// Start the show <3
KWSES();
