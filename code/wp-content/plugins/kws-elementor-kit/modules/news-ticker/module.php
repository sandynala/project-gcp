<?php
namespace KwsElementorKit\Modules\NewsTicker;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'news-ticker';
	}

	public function get_widgets() {

		$widgets = [
			'News_Ticker',
		];
		
		return $widgets;
	}
}
