<?php
/*
 * Plugin Name: Dyno Skin Dyno Item
 * Version: 1.0.1
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Xcs_Dyno_Item{


	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {

		$this->init();

	}

	public function init() {
		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'elementor/controls/controls_registered', [ $this, 'init_controls' ] );
    $this->init_includes();
 
	}

	
	public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/dyno-item.php' );

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Xcs_Dyno_Item_Widget() );

	}

	public function init_includes() {
	}

	public function init_controls() {
		// Nothing for now
	}

}

\Xcs_Dyno_Item::instance();