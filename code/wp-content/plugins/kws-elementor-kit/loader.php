<?php

namespace KwsElementorKit;

use  Elementor\Plugin ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
/**
 * Main class for element pack
 */
class Kws_Elementor_Kit_Loader
{
    /**
     * @var Kws_Elementor_Kit_Loader
     */
    private static  $_instance ;
    /**
     * @var Manager
     */
    private  $_modules_manager ;
    private  $classes_aliases = array(
        'KwsElementorKit\\Modules\\PanelPostsControl\\Module'                        => 'KwsElementorKit\\Modules\\QueryControl\\Module',
        'KwsElementorKit\\Modules\\PanelPostsControl\\Controls\\Group_Control_Posts' => 'KwsElementorKit\\Modules\\QueryControl\\Controls\\Group_Control_Posts',
        'KwsElementorKit\\Modules\\PanelPostsControl\\Controls\\Query'               => 'KwsElementorKit\\Modules\\QueryControl\\Controls\\Query',
    ) ;
    public  $elements_data = array(
        'sections' => array(),
        'columns'  => array(),
        'widgets'  => array(),
    ) ;
    /**
     * @return string
     * @deprecated
     *
     */
    public function get_version()
    {
        return CFTKEK_VER;
    }
    
    /**
     * return active theme
     */
    public function get_theme()
    {
        return wp_get_theme();
    }
    
    /**
     * Throw error on object clone
     *
     * The whole idea of the singleton design pattern is that there is a single
     * object therefore, we don't want the object to be cloned.
     *
     * @return void
     * @since 1.0.0
     */
    public function __clone()
    {
        // Cloning instances of the class is forbidden
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'kws-elementor-kit' ), '1.6.0' );
    }
    
    /**
     * Disable unserializing of the class
     *
     * @return void
     * @since 1.0.0
     */
    public function __wakeup()
    {
        // Unserializing instances of the class is forbidden
        _doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'kws-elementor-kit' ), '1.6.0' );
    }
    
    /**
     * @return Plugin
     */
    public static function elementor()
    {
        return Plugin::$instance;
    }
    
    /**
     * @return Kws_Elementor_Kit_Loader
     */
    public static function instance()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * we loaded module manager + admin php from here
     * @return [type] [description]
     */
    private function _includes()
    {
        $category_image = kws_elementor_kit_option( 'category_image', 'kws_elementor_kit_other_settings', 'on' );
        // Dynamic Select control
        require CFTKEK_INC_PATH . 'controls/select-input/dynamic-select-input-module.php';
        require CFTKEK_INC_PATH . 'controls/select-input/dynamic-select.php';
        // all widgets control from here
        require_once CFTKEK_PATH . 'traits/global-widget-controls.php';
        require_once CFTKEK_PATH . 'traits/global-swiper-functions.php';
        require_once CFTKEK_INC_PATH . 'modules-manager.php';
        if ( $category_image == 'on' ) {
            require CFTKEK_INC_PATH . 'kws-elementor-kit-category-image.php';
        }
        // if ($category_image == 'on') {
        require CFTKEK_INC_PATH . 'kws-elementor-kit-metabox.php';
        // }
        if ( is_admin() ) {
            
            if ( !defined( 'BDTEP_CH' ) ) {
                //require CFTKEK_INC_PATH . 'admin-feeds.php';
                //new Kws_Elementor_Kit_Admin_Feeds();
            }
        
        }

        // Other modules
        require CFTKEK_DYNO_PATH . 'dyno-init.php';
        require CFTKEK_DYNO_PATH . 'dyno-extend-init.php';
    }
    
    /**
     * Autoloader function for all classes files
     *
     * @param  [type] class [description]
     *
     * @return [type]        [description]
     */
    public function autoload( $class )
    {
        if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
            return;
        }
        $has_class_alias = isset( $this->classes_aliases[$class] );
        // Backward Compatibility: Save old class name for set an alias after the new class is loaded
        
        if ( $has_class_alias ) {
            $class_alias_name = $this->classes_aliases[$class];
            $class_to_load = $class_alias_name;
        } else {
            $class_to_load = $class;
        }
        
        
        if ( !class_exists( $class_to_load ) ) {
            $filename = strtolower( preg_replace( [
                '/^' . __NAMESPACE__ . '\\\\/',
                '/([a-z])([A-Z])/',
                '/_/',
                '/\\\\/'
            ], [
                '',
                '$1-$2',
                '-',
                DIRECTORY_SEPARATOR
            ], $class_to_load ) );
            $filename = CFTKEK_PATH . $filename . '.php';
            if ( is_readable( $filename ) ) {
                include $filename;
            }
        }
        
        if ( $has_class_alias ) {
            class_alias( $class_alias_name, $class );
        }
    }
    
    public function register_site_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        wp_register_style(
            'kek-all-styles',
            CFTKEK_ASSETS_URL . 'css/kek-all-styles' . $direction_suffix . '.css',
            [],
            CFTKEK_VER
        );
        wp_register_style(
            'kws-elementor-kit-font',
            CFTKEK_ASSETS_URL . 'css/kws-elementor-kit-font' . $direction_suffix . '.css',
            [],
            CFTKEK_VER
        );
    }
    
    public function register_site_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_register_script(
            'goodshare',
            CFTKEK_ASSETS_URL . 'vendor/js/goodshare' . $suffix . '.js',
            [ 'jquery' ],
            '4.1.2',
            true
        );
        wp_register_script(
            'scrolline',
            CFTKEK_ASSETS_URL . 'vendor/js/jquery.scrolline' . $suffix . '.js',
            [ 'jquery' ],
            '4.1.2',
            true
        );
        wp_register_script(
            'news-ticker-js',
            CFTKEK_ASSETS_URL . 'vendor/js/newsticker' . $suffix . '.js',
            [ 'jquery' ],
            '',
            true
        );
        wp_register_script(
            'kek-animations',
            CFTKEK_ASSETS_URL . 'js/extensions/kek-animations' . $suffix . '.js',
            [ 'jquery' ],
            '',
            true
        );
        wp_register_script(
            'kek-all-scripts',
            CFTKEK_ASSETS_URL . 'js/kek-all-scripts' . $suffix . '.js',
            [ 'jquery', 'elementor-frontend', 'scrolline' ],
            CFTKEK_VER,
            true
        );
    }
    
    /**
     * Loading site related style from here.
     * @return [type] [description]
     */
    public function enqueue_site_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        wp_enqueue_style(
            'kws-elementor-kit-site',
            CFTKEK_ASSETS_URL . 'css/kws-elementor-kit-site' . $direction_suffix . '.css',
            [],
            CFTKEK_VER
        );
    }
    
    /**
     * Loading site related script that needs all time such as uikit.
     * @return [type] [description]
     */
    public function enqueue_site_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_enqueue_script(
            'kws-elementor-kit-site',
            CFTKEK_ASSETS_URL . 'js/kws-elementor-kit-site' . $suffix . '.js',
            [ 'jquery', 'elementor-frontend' ],
            CFTKEK_VER,
            true
        );
        // tooltip file should be separate
        $script_config = [
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
            'nonce'         => wp_create_nonce( 'kws-elementor-kit-site' ),
            'mailchimp'     => [
            'subscribing' => esc_html_x( 'Subscribing you please wait...', 'Mailchimp String', 'kws-elementor-kit' ),
        ],
            'elements_data' => $this->elements_data,
        ];
        $script_config = apply_filters( 'kws_elementor_kit/frontend/localize_settings', $script_config );
        // TODO for editor script
        wp_localize_script( 'kws-elementor-kit-site', 'KwsElementorKitConfig', $script_config );
    }
    
    public function enqueue_editor_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_enqueue_script(
            'kws-elementor-kit',
            CFTKEK_ASSETS_URL . 'js/kws-elementor-kit-editor' . $suffix . '.js',
            [ 'backbone-marionette', 'elementor-common-modules', 'elementor-editor-modules' ],
            CFTKEK_VER,
            true
        );
    }
    
    public function enqueue_admin_scripts()
    {
        $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min' );
        wp_enqueue_script(
            'kws-elementor-kit-admin',
            CFTKEK_ASSETS_URL . 'js/kws-elementor-kit-admin' . $suffix . '.js',
            [ 'jquery' ],
            CFTKEK_VER,
            true
        );
    }
    
    /**
     * Load editor editor related style from here
     * @return [type] [description]
     */
    public function enqueue_preview_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        wp_enqueue_style(
            'kws-elementor-kit-preview',
            CFTKEK_ASSETS_URL . 'css/kws-elementor-kit-preview' . $direction_suffix . '.css',
            '',
            CFTKEK_VER
        );
    }
    
    public function enqueue_editor_styles()
    {
        $direction_suffix = ( is_rtl() ? '.rtl' : '' );
        wp_enqueue_style(
            'kws-elementor-kit-editor',
            CFTKEK_ASSETS_URL . 'css/kws-elementor-kit-editor' . $direction_suffix . '.css',
            '',
            CFTKEK_VER
        );
        wp_enqueue_style(
            'kws-elementor-kit-font',
            CFTKEK_URL . 'assets/css/kws-elementor-kit-font' . $direction_suffix . '.css',
            [],
            CFTKEK_VER
        );
    }
    
    /**
     * initialize the category
     * @return [type] [description]
     */
    public function kws_elementor_kit_init()
    {
        $this->_modules_manager = new Manager();
        do_action( 'kwstech_kws_elementor_kit/init' );
    }
    
    /**
     * initialize the category
     * @return [type] [description]
     */
    public function kws_elementor_kit_category_register()
    {
        $elementor = Plugin::$instance;
        // Add element category in panel
        $elementor->elements_manager->add_category( 'kws-elementor-kit', [
            'title' => esc_html__( 'KWS Elementor Kit', 'kws-elementor-kit' ),
            'icon'  => 'font',
        ] );
        //		if (kek_fs()->is__premium_only()) {
        //			$elementor->elements_manager->add_category('kws-elementor-kit-single', [
        //				'title' => esc_html__('KWS Elementor Kit (Single)', 'kws-elementor-kit'),
        //				'icon'  => 'font'
        //			]);
        //		}
    }
    
    private function setup_hooks()
    {
        add_action( 'elementor/elements/categories_registered', [ $this, 'kws_elementor_kit_category_register' ] );
        add_action( 'elementor/init', [ $this, 'kws_elementor_kit_init' ] );
        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );
        add_action( 'elementor/frontend/before_register_styles', [ $this, 'register_site_styles' ] );
        add_action( 'elementor/frontend/before_register_scripts', [ $this, 'register_site_scripts' ] );
        add_action( 'elementor/preview/enqueue_styles', [ $this, 'enqueue_preview_styles' ] );
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );
        add_action( 'elementor/frontend/after_register_styles', [ $this, 'enqueue_site_styles' ] );
        add_action( 'elementor/frontend/before_enqueue_scripts', [ $this, 'enqueue_site_scripts' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
    }
    
    /**
     * Kws_Elementor_Kit_Loader constructor.
     */
    private function __construct()
    {
        // Register class automatically
        spl_autoload_register( [ $this, 'autoload' ] );
        // Include some backend files
        $this->_includes();
        // Finally hooked up all things here
        $this->setup_hooks();
    }

}
if ( !defined( 'CFTKEK_TESTS' ) ) {
    // In tests we run the instance manually.
    Kws_Elementor_Kit_Loader::instance();
}
// handy fundtion for push data
function kws_elementor_kit_config()
{
    return Kws_Elementor_Kit_Loader::instance();
}
