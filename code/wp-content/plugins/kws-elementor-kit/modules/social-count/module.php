<?php

namespace KwsElementorKit\Modules\SocialCount;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'social-count';
	}

	public function get_widgets() {

		$widgets = [
			'Social_Count',
		];

		return $widgets;
	}
}
