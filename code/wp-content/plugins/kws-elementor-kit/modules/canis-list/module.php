<?php
namespace KwsElementorKit\Modules\CanisList;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'canis-list';
	}

	public function get_widgets() {

		$widgets = [
			'Canis_List',
		];
		
		return $widgets;
	}
}
