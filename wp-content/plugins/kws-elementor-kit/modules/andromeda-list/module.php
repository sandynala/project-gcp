<?php
namespace KwsElementorKit\Modules\AndromedaList;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'andromeda-list';
	}

	public function get_widgets() {

		$widgets = [
			'Andromeda_List',
		];
		
		return $widgets;
	}
}
