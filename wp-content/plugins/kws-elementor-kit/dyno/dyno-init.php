<?php
/*
 * Initialize Dyno
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//define( 'CFTKEK_PATH', plugin_dir_path( __FILE__ ));
//define( 'CFTKEK_PBNAME', plugin_basename( __FILE__ ));
//define( 'CFTKEK_URL', plugin_dir_url( __FILE__ ));
//define ('CFTKEK_VER','3.1.4');

include_once CFTKEK_PATH.'dyno/csx-dependencies.php';
include_once CFTKEK_PATH.'dyno/enqueue-styles.php';

include_once CFTKEK_PATH.'dyno/ajax-pagination.php';

add_action( 'elementor_pro/init', 'kekcsx_elementor_init' );
function kekcsx_elementor_init(){

  include_once CFTKEK_PATH.'dyno/admin-bar-menu.php';
  require_once CFTKEK_PATH.'theme-builder/init.php';
  require_once CFTKEK_PATH.'modules/dyno-item/module.php';

}

add_action('elementor/widgets/widgets_registered','kekcsx_add_skins');
function kekcsx_add_skins(){
  require_once CFTKEK_PATH.'skins/skin-custom.php';
}

// dynamic background fix
require_once CFTKEK_PATH.'dyno/dynamic-style.php';
