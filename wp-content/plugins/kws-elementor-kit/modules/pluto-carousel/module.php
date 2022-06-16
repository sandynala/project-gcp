<?php
namespace KwsElementorKit\Modules\PlutoCarousel;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'pluto-carousel';
	}

	public function get_widgets() {

		$widgets = ['Pluto_Carousel'];
		
		return $widgets;
	}
}
