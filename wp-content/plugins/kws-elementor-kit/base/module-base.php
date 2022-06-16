<?php

namespace KwsElementorKit\Base;

use Elementor\Widget_Base;
use KwsElementorKit\Kws_Elementor_Kit_Loader;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

abstract class Module_Base extends Widget_Base {

    protected function kek_is_edit_mode(){

        if(Kws_Elementor_Kit_Loader::elementor()->preview->is_preview_mode() || Kws_Elementor_Kit_Loader::elementor()->editor->is_edit_mode() ){
            return true;
        }

        return false;
    }
}