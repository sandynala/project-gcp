<?php
namespace KwsElementorKit\Modules\MercurySlider;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'mercury-slider';
	}

	public function get_widgets() {

		$widgets = [
			'Mercury_Slider',
		];
		
		return $widgets;
	}
}
