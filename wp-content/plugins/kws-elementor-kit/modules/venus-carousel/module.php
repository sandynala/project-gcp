<?php
namespace KwsElementorKit\Modules\VenusCarousel;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'venus-carousel';
	}

	public function get_widgets() {

		$widgets = ['Venus_Carousel'];
		
		return $widgets;
	}
}
