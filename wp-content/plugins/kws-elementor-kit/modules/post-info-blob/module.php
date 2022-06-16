<?php

namespace KwsElementorKit\Modules\PostInfoBlob;

use KwsElementorKit\Base\Kws_Elementor_Kit_Module_Base;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Module extends Kws_Elementor_Kit_Module_Base {

	public function get_name() {
		return 'post-info-blob';
	}

	public function get_widgets() {

		$widgets = [
			'Post_Info_Blob',
		];

		return $widgets;
	}
}
