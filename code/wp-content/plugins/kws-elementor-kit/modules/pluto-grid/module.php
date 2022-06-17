<?php
namespace KwsElementorKit\Modules\PlutoGrid;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'pluto-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Pluto_Grid',
		];
		
		return $widgets;
	}
}
