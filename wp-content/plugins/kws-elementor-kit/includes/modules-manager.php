<?php

namespace KwsElementorKit;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
if ( !function_exists( 'is_plugin_active' ) ) {
    include_once ABSPATH . 'wp-admin/includes/plugin.php';
}
final class Manager
{
    private  $_modules = array() ;
    private function is_module_active( $module_id )
    {
        $module_data = $this->get_module_data( $module_id );
        $options = get_option( 'kws_elementor_kit_active_modules', [] );
        
        if ( !isset( $options[$module_id] ) ) {
            return $module_data['default_activation'];
        } else {
            
            if ( $options[$module_id] == "on" ) {
                return true;
            } else {
                return false;
            }
        
        }
    
    }
    
    private function has_module_style( $module_id )
    {
        $module_data = $this->get_module_data( $module_id );
        
        if ( isset( $module_data['has_style'] ) ) {
            return $module_data['has_style'];
        } else {
            return false;
        }
    
    }
    
    private function has_module_script( $module_id )
    {
        $module_data = $this->get_module_data( $module_id );
        
        if ( isset( $module_data['has_script'] ) ) {
            return $module_data['has_script'];
        } else {
            return false;
        }
    
    }
    
    private function get_module_data( $module_id )
    {
        return ( isset( $this->_modules[$module_id] ) ? $this->_modules[$module_id] : false );
    }
    
    public function __construct()
    {
        $modules = [];
        $modules[] = 'query-control';
        
        // WIDGETS - START
        if ( kek_is_pluto_carousel_enabled() ) {
            $modules[] = 'pluto-carousel';
        }
        if ( kek_is_mercury_slider_enabled() ) {
            $modules[] = 'mercury-slider';
        }
        if ( kek_is_news_ticker_enabled() ) {
            $modules[] = 'news-ticker';
        }
        if ( kek_is_post_category_enabled() ) {
            $modules[] = 'post-category';
        }
        if ( kek_is_testimonial_grid_enabled() ) {
            $modules[] = 'testimonial-grid';
        }
        // WIDGETS - END

        /*
        // TODO
        // Selected - Start
        if ( kek_is_dyno_carousel_enabled() ) {
            $modules[] = 'dyno-carousel';
        }
        // Selected - End

        if ( kek_is_mercury_slider_enabled() ) {
            $modules[] = 'mercury-slider';
        }

        // Grid and Carousel
        if ( kek_is_pluto_grid_enabled() ) {
            $modules[] = 'pluto-grid';
        }
        if ( kek_is_pluto_carousel_enabled() ) {
            $modules[] = 'pluto-carousel';
        }
        if ( kek_is_neptune_grid_enabled() ) {
            $modules[] = 'neptune-grid';
        }
        if ( kek_is_neptune_carousel_enabled() ) {
            $modules[] = 'neptune-carousel';
        }
        if ( kek_is_venus_grid_enabled() ) {
            $modules[] = 'venus-grid';
        }
        if ( kek_is_venus_carousel_enabled() ) {
            $modules[] = 'venus-carousel';
        }
        if ( kek_is_jupiter_grid_enabled() ) {
            $modules[] = 'jupiter-grid';
        }
        if ( kek_is_jupiter_carousel_enabled() ) {
            $modules[] = 'jupiter-carousel';
        }

        // Lists
        if ( kek_is_cygnus_list_enabled() ) {
            $modules[] = 'cygnus-list';
        }
        if ( kek_is_andromeda_list_enabled() ) {
            $modules[] = 'andromeda-list';
        }
        if ( kek_is_canis_list_enabled() ) {
            $modules[] = 'canis-list';
        }

        // Others
        if ( kek_is_news_ticker_enabled() ) {
            $modules[] = 'news-ticker';
        }
        if ( kek_is_post_category_enabled() ) {
            $modules[] = 'post-category';
        }
        if ( kek_is_social_share_enabled() ) {
            $modules[] = 'social-share';
        }
        if ( kek_is_social_count_enabled() ) {
            $modules[] = 'social-count';
        }
        if ( kek_is_post_info_blob_enabled() ) {
            $modules[] = 'post-info-blob';
        }
        */


        // Fetch all modules data
        foreach ( $modules as $module ) {
            $this->_modules[$module] = (require CFTKEK_MODULES_PATH . $module . '/module.info.php');
        }
        $direction = ( is_rtl() ? '.rtl' : '' );
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        foreach ( $this->_modules as $module_id => $module_data ) {
            if ( !$this->is_module_active( $module_id ) ) {
                continue;
            }
            $class_name = str_replace( '-', ' ', $module_id );
            $class_name = str_replace( ' ', '', ucwords( $class_name ) );
            $class_name = __NAMESPACE__ . '\\Modules\\' . $class_name . '\\Module';
            // register widgets css
            if ( $this->has_module_style( $module_id ) ) {
                wp_register_style(
                    'kek-' . $module_id,
                    CFTKEK_URL . 'assets/css/kek-' . $module_id . $direction . '.css',
                    [],
                    CFTKEK_VER
                );
            }
            if ( $this->has_module_script( $module_id ) ) {
                wp_register_script(
                    'kek-' . $module_id,
                    CFTKEK_URL . 'assets/js/widgets/kek-' . $module_id . $suffix . '.js',
                    [ 'jquery' ],
                    CFTKEK_VER
                );
            }
            $class_name::instance();
            // error_log( $class_name );
            // error_log( ep_memory_usage_check() );
        }
    }

}