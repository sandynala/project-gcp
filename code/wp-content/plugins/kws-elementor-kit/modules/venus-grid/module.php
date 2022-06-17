<?php
namespace KwsElementorKit\Modules\VenusGrid;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'venus-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Venus_Grid',
		];
		
		return $widgets;
	}
}
