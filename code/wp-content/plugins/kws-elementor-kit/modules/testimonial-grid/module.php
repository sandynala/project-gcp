<?php
namespace KwsElementorKit\Modules\TestimonialGrid;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'testimonial-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Testimonial_Grid',
		];
		
		return $widgets;
	}
}
