<?php
namespace KwsElementorKit\Modules\NeptuneGrid;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'neptune-grid';
	}

	public function get_widgets() {

		$widgets = [
			'Neptune_Grid',
		];
		
		return $widgets;
	}
}
