<?php
namespace KwsElementorKit\Modules\CygnusList;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'cygnus-list';
	}

	public function get_widgets() {

		$widgets = [
			'Cygnus_List',
		];
		
		return $widgets;
	}
}
