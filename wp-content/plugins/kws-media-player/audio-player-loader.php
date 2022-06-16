<?php
namespace KwsMediaPlayer;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class AudioPlayerLoader {

  private static $_instance = null;

  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }

    return self::$_instance;
  }

  public function widget_scripts() {
    // the player css
    wp_enqueue_style('kmpaudio-html5_site_css', plugins_url('kws_audio/kws_audio.css', __FILE__));

    // the player js
    wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script('jquery-ui-progressbar');
    wp_enqueue_script('jquery-effects-core');

    wp_register_script('mousewheel', plugins_url('kws_audio/js/jquery.mousewheel.min.js', __FILE__));
		wp_enqueue_script('mousewheel');

		wp_register_script('touchSwipe', plugins_url('kws_audio/js/jquery.touchSwipe.min.js', __FILE__));
		wp_enqueue_script('touchSwipe');

		wp_register_script('kmp-kws_audio', plugins_url('kws_audio/js/kws_audio.js', __FILE__));
		wp_enqueue_script('kmp-kws_audio');


    wp_register_style( 'cf-audio-player', KMP_ASSETS_URL . '/css/kmp-audio-player.css' );
    wp_register_script( 'cf-audio-player', KMP_ASSETS_URL . '/js/kmp-audio-player.js');
  }

  private function include_widgets_files() {
    require_once( __DIR__ . '/modules/widgets/audio-player.php' );

    require_once( __DIR__ . '/modules/helper-function.php' );
    require_once( __DIR__ . '/modules/widgets/kmp_audio_player.php' );
  }

  
  public function register_widgets() {
    // Its is now safe to include Widgets files
    $this->include_widgets_files();

    // Register Widgets
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\AudioPlayer() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CF_Audio_Player() );
  }


  public function register_categories( $elements_manager ) {
    $elements_manager->add_category(
      'kws-widgets',
      [
        'title' => esc_html__( 'KWS Widgets', 'kws-media-player' ),
        'icon' => 'far fa-play-circle',
      ]
    );
  }


  public function __construct() {
    // Register widget scripts
    add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

    // Register widgets
    add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );


    //kmp - new categ
    add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );

  }
}

// Instantiate Plugin Class
AudioPlayerLoader::instance();
