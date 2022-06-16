<?php

use  KwsElementorKit\Base\Kws_Elementor_Kit_Base ;
use  KwsElementorKit\Notices ;
use  KwsElementorKit\Utils ;
/**
 * KWS Elementor Kit Admin Settings Class
 */
class KwsElementorKit_Admin_Settings
{
    const  PAGE_ID = 'kws_elementor_kit_options' ;
    private  $settings_api ;
    public  $responseObj ;
    public  $showMessage = false ;
    private  $is_activated = false ;
    function __construct()
    {
        $this->settings_api = new KwsElementorKit_Settings_API();
        
        if ( !defined( 'CFTKEK_HIDE' ) ) {
            add_action( 'admin_init', [ $this, 'admin_init' ] );
            add_action( 'admin_menu', [ $this, 'admin_menu' ], 201 );
        }
    
    }
    
    public static function get_url()
    {
        return admin_url( 'admin.php?page=' . self::PAGE_ID );
    }
    
    function admin_init()
    {
        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->kws_elementor_kit_admin_settings() );
        //initialize settings
        $this->settings_api->admin_init();
    }
    
    function admin_menu()
    {
        add_menu_page(
            CFTKEK_TITLE . ' ' . esc_html__( 'Dashboard', 'kws-elementor-kit' ),
            CFTKEK_TITLE,
            'manage_options',
            self::PAGE_ID,
            [ $this, 'plugin_page' ],
            $this->kws_elementor_kit_icon(),
            58.5
        );
        add_submenu_page(
            self::PAGE_ID,
            CFTKEK_TITLE,
            esc_html__( 'Core Widgets', 'kws-elementor-kit' ),
            'manage_options',
            self::PAGE_ID . '#kws_elementor_kit_active_modules',
            [ $this, 'display_page' ]
        );
        add_submenu_page(
            self::PAGE_ID,
            CFTKEK_TITLE,
            esc_html__( 'Extensions', 'kws-elementor-kit' ),
            'manage_options',
            self::PAGE_ID . '#kws_elementor_kit_elementor_extend',
            [ $this, 'display_page' ]
        );
        add_submenu_page(
            self::PAGE_ID,
            CFTKEK_TITLE,
            esc_html__( 'Other Settings', 'kws-elementor-kit' ),
            'manage_options',
            self::PAGE_ID . '#kws_elementor_kit_other_settings',
            [ $this, 'display_page' ]
        );
    }
    
    function kws_elementor_kit_icon()
    {
        return 'data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgZGF0YS1uYW1lPSJMYXllciAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMjIuODggMTIyLjQ5Ij48ZGVmcz48c3R5bGU+LmNscy0xe2ZpbGw6IzM5YjU0YTt9PC9zdHlsZT48L2RlZnM+PHRpdGxlPmN1c3RvbWl6YWJsZTwvdGl0bGU+PHBhdGggZD0iTTgyLjI1LDE5Yy0xLS41LTIuMDYtMS0zLjE2LTEuNC0yLS43OS0zLjg4LTEuNDYtNS45LTJsLS4zOC05Ljg4QTYsNiwwLDAsMCw3MSwxLjUzLDUuNTksNS41OSwwLDAsMCw2Ni42OCwwTDU0LjI5LjU3YTYuMTEsNi4xMSwwLDAsMC00LjExLDEuODgsNS42NCw1LjY0LDAsMCwwLTEuNjIsNC4yN2wuMzgsOUEzOC4zLDM4LjMsMCwwLDAsNDMsMTcuODhhNDguOCw0OC44LDAsMCwwLTUuNDksMi44MUwzMC4wNiwxNGE1LjUxLDUuNTEsMCwwLDAtNC4xNy0xLjYxLDYsNiwwLDAsMC00LjEyLDJsLTguMzIsOWE1Ljc4LDUuNzgsMCwwLDAsLjM1LDguMzlMMjAuNDgsMzhhMzYuMzUsMzYuMzUsMCwwLDAtMi43NCw1LjZjLS43OSwyLTEuNDYsMy44OC0yLDUuOTFsLTkuODcuMzdDLTIuNTcsNTAuMy41LDYyLjY1Ljc2LDY4LjM3YTYuMTgsNi4xOCwwLDAsMCwxLjg0LDQuMSw1LjY0LDUuNjQsMCwwLDAsNC4yOCwxLjYybDktLjM3QTQwLjUsNDAuNSwwLDAsMCwxOCw3OS42NWMuODEsMS44OSwxLjgyLDMuNzgsMi44LDUuNkwxNC4xLDkyLjZhNS40Nyw1LjQ3LDAsMCwwLTEuNiw0LjE3LDYsNiwwLDAsMCwxLjk0LDQuMTJsOS4xMyw4LjRhNS43LDUuNywwLDAsMCw0LjI5LDEuNTIsNi4zNyw2LjM3LDAsMCwwLDQuMi0xLjgzbDYuMjQtNi43OGEzNS45MSwzNS45MSwwLDAsMCw1LjYsMi43NGMyLC43OSwzLjg3LDEuNDYsNS45LDJsLjM3LDkuODdBNi4xMSw2LjExLDAsMCwwLDUyLDEyMWE1LjU4LDUuNTgsMCwwLDAsNC4yOSwxLjUxbDEyLjM5LS41NmE2LjE2LDYuMTYsMCwwLDAsNC4xLTEuODQsNS42NCw1LjY0LDAsMCwwLDEuNjItNC4yOGwtLjM4LTlBMzguNTksMzguNTksMCwwLDAsODAsMTA0LjY1YTU2LjIzLDU2LjIzLDAsMCwwLDUuNi0yLjhsNy4zNSw2LjczYTUuNjQsNS42NCwwLDAsMCw0LjI4LDEuNjIsNS44Miw1LjgyLDAsMCwwLDQuMTItMS45NGw4LjQtOS4xM2E1LjcsNS43LDAsMCwwLDEuNTItNC4yOSw2LjMzLDYuMzMsMCwwLDAtMS44Ni00LjIxbC02LjgtNi4xNGEzNS45MSwzNS45MSwwLDAsMCwyLjc0LTUuNmMuNzktMiwxLjQ2LTMuODcsMi4wNS01LjlsOS44Ny0uMzdhNS45NCw1Ljk0LDAsMCwwLDQuMTEtMS44OCw1LjU5LDUuNTksMCwwLDAsMS41Mi00LjI5bC0uNTctMTIuMzlhNi4xMSw2LjExLDAsMCwwLTEuODQtNC4xLDUuNjQsNS42NCwwLDAsMC00LjI3LTEuNjJsLTksLjM4QTUzLDUzLDAsMCwwLDEwNSw0Mi43OWwtMS4zLTIuNTYtMi4yMywyLjkxYy0yLjA2LDIuNzItNCw1LjM5LTUuODcsOGEzNS4xMywzNS4xMywwLDAsMSwuODksNCwzNy4wNiwzNy4wNiwwLDAsMS0uMzEsMTQuMjdBMzcuODMsMzcuODMsMCwwLDEsOTAuNyw4MS45NGEzNy42MywzNy42MywwLDAsMS0xMCw5LjUzLDMzLjQyLDMzLjQyLDAsMCwxLTEzLjE5LDUsMzcuMDYsMzcuMDYsMCwwLDEtMTQuMjctLjMxQTM3LjgzLDM3LjgzLDAsMCwxLDQwLjY3LDkwLjdhMzcuNjMsMzcuNjMsMCwwLDEtOS41My0xMCwzMy4zNiwzMy4zNiwwLDAsMS01LjA1LTEzLjE5LDM3LjA2LDM3LjA2LDAsMCwxLC4zMS0xNC4yNywzNy42MiwzNy42MiwwLDAsMSw1LjUxLTEyLjU3LDM3LjYzLDM3LjYzLDAsMCwxLDEwLTkuNTMsMzQuNCwzNC40LDAsMCwxLDEzLjE4LTUuMDVoMGEzNy4xMiwzNy4xMiwwLDAsMSwxNC4yOC4zMSwzOC4yMywzOC4yMywwLDAsMSw0LjUzLDEuMzdjMi40OC0yLjcxLDUuNDYtNS44OSw4LjM1LTguODJaIi8+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNMzguMjIsNDkuODZsMTItLjE2LjkuMjRBNDYuMDYsNDYuMDYsMCwwLDEsNjIuNDIsNTksMTczLjMxLDE3My4zMSwwLDAsMSw3Ni4yLDM5LjgzYzMuMzUtNCwxOS4wOC0yMS4yNCwyMi45My0yMi43M2w5LjUyLDIuMkwxMDYsMjIuMjRjLTguMTQsOS4wNS0xNi43NSwyMC44OC0yMy40MiwzMC41MmEyNzMsMjczLDAsMCwwLTE4LDI5Ljg2TDYzLDg1LjgxbC0xLjUyLTMuMjVBNzguNDQsNzguNDQsMCwwLDAsNTEuMzEsNjYuMTFhNjYuMzIsNjYuMzIsMCwwLDAtMTQuMDgtMTNsMS0zLjIyWiIvPjwvc3ZnPg==';
    }
    
    function get_settings_sections()
    {
        $sections = [
            [
                'id'    => 'kws_elementor_kit_active_modules',
                'title' => esc_html__( 'Core Widgets', 'kws-elementor-kit' ),
            ],
                [
                'id'    => 'kws_elementor_kit_elementor_extend',
                'title' => esc_html__( 'Extensions', 'kws-elementor-kit' ),
            ],
                [
                'id'    => 'kws_elementor_kit_other_settings',
                'title' => esc_html__( 'Other Settings', 'kws-elementor-kit' ),
            ]
        ];
        return $sections;
    }
    
    protected function kws_elementor_kit_admin_settings()
    {
        // WIDGETS - START
        if ( kek_is_pluto_carousel_enabled() ) {
            $settings_fields['kws_elementor_kit_active_modules'][] = [
                'name'         => 'pluto-carousel',
                'label'        => esc_html__( 'Pluto Carousel', 'kws-elementor-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'basic',
                'content_type' => 'carousel',
                'demo_url'     => '',
                'video_url'    => '',
            ];
        }
        if ( kek_is_mercury_slider_enabled() ) {
            $settings_fields['kws_elementor_kit_active_modules'][] = [
                'name'         => 'mercury-slider',
                'label'        => esc_html__( 'Mercury Slider', 'kws-elementor-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'basic',
                'content_type' => 'slider',
                'demo_url'     => '',
                'video_url'    => '',
            ];
        }
        if ( kek_is_news_ticker_enabled() ) {
            $settings_fields['kws_elementor_kit_active_modules'][] = [
                'name'         => 'news-ticker',
                'label'        => esc_html__( 'News Ticker', 'kws-elementor-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'basic',
                'content_type' => 'others',
                'demo_url'     => '',
                'video_url'    => '',
            ];
        }
        if ( kek_is_post_category_enabled() ) {
            $settings_fields['kws_elementor_kit_active_modules'][] = [
                'name'         => 'post-category',
                'label'        => esc_html__( 'Category', 'kws-elementor-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'basic',
                'content_type' => 'others',
                'demo_url'     => '',
                'video_url'    => '',
            ];
        }
        if ( kek_is_testimonial_grid_enabled() ) {
            $settings_fields['kws_elementor_kit_active_modules'][] = [
                'name'         => 'testimonial-grid',
                'label'        => esc_html__( 'Testimonial Grid', 'kws-elementor-kit' ),
                'type'         => 'checkbox',
                'default'      => "on",
                'widget_type'  => 'basic',
                'content_type' => 'others',
                'demo_url'     => '',
                'video_url'    => '',
            ];
        }
        // WIDGETS - END


        
        $settings_fields['kws_elementor_kit_elementor_extend'][] = [
            'name'         => 'animations',
            'label'        => esc_html__( 'Animations', 'kws-elementor-kit' ),
            'type'         => 'checkbox',
            'default'      => "on",
            'widget_type'  => 'basic',
            'demo_url'     => '',
            'video_url'    => '',
        ];
        $settings_fields['kws_elementor_kit_api_settings'][] = [
            'name'  => 'mailchimp_group_start',
            'label' => esc_html__( 'Mailchimp Access', 'kws-elementor-kit' ),
            'desc'  => __( 'Go to your Mailchimp > Website > Domains > Extras > API Keys (<a href="http://prntscr.com/xqo78x" target="_blank">http://prntscr.com/xqo78x</a>) then create a key and paste here. You will get the audience ID here: <a href="http://prntscr.com/xqnt5z" target="_blank">http://prntscr.com/xqnt5z</a>', 'kws-elementor-kit' ),
            'type'  => 'start_group',
        ];
        $settings_fields['kws_elementor_kit_api_settings'][] = [
            'name'              => 'mailchimp_api_key',
            'label'             => esc_html__( 'Mailchimp API Key', 'kws-elementor-kit' ),
            'placeholder'       => '',
            'type'              => 'text',
            'sanitize_callback' => 'sanitize_text_field',
        ];
        $settings_fields['kws_elementor_kit_api_settings'][] = [
            'name'              => 'mailchimp_list_id',
            'label'             => esc_html__( 'Audience ID', 'kws-elementor-kit' ),
            'placeholder'       => '',
            'type'              => 'text',
            'sanitize_callback' => 'sanitize_text_field',
        ];
        $settings_fields['kws_elementor_kit_api_settings'][] = [
            'name' => 'mailchimp_group_end',
            'type' => 'end_group',
        ];
        $settings_fields['kws_elementor_kit_other_settings'][] = [
            'name'  => 'enable_category_image_group_start',
            'label' => esc_html__( 'Category Image', 'kws-elementor-kit' ),
            'desc'  => __( 'If you need to show category image in your editor so please enable this option.', 'kws-elementor-kit' ),
            'type'  => 'start_group',
        ];
        $settings_fields['kws_elementor_kit_other_settings'][] = [
            'name'    => 'category_image',
            'label'   => esc_html__( 'Category Image', 'kws-elementor-kit' ),
            'type'    => 'checkbox',
            'default' => "on",
        ];
        $settings_fields['kws_elementor_kit_other_settings'][] = [
            'name' => 'category_image_group_end',
            'type' => 'end_group',
        ];
        $settings_fields['kws_elementor_kit_other_settings'][] = [
            'name'         => 'enable_video_link_group_start',
            'label'        => esc_html__( 'Video Link Meta', 'kws-elementor-kit' ),
            'desc'         => __( 'If you need to display video features in your website so please enable this option.', 'kws-elementor-kit' ),
            'type'         => 'start_group',
        ];
        $settings_fields['kws_elementor_kit_other_settings'][] = [
            'name'    => 'video_link',
            'label'   => esc_html__( 'Video Link', 'kws-elementor-kit' ),
            'type'    => 'checkbox',
            'default' => "on",
        ];
        $settings_fields['kws_elementor_kit_other_settings'][] = [
            'name' => 'video_link_group_end',
            'type' => 'end_group',
        ];
        return $settings_fields;
    }
    
    function kws_elementor_kit_welcome()
    {
        $current_user = wp_get_current_user();
        
        if ( isset( $current_user->user_firstname ) or isset( $current_user->user_lastname ) ) {
            $user_name = $current_user->user_firstname . ' ' . $current_user->user_lastname;
        } else {
            $user_name = $current_user->display_name;
        }
        
        ?>

		<div class="cft-dashboard-panel" cft-scrollspy="target: > div > div > .cft-card; cls: cft-animation-slide-bottom-small; delay: 300">
			<div class="cft-grid cft-hidden@xl" cft-grid cft-height-match="target: > div > .cft-card">
				<div class=" cft-welcome-banner">
					<div class="cft-welcome-content cft-card cft-card-body">
						<h1 class="cft-feature-title">
							Welcome <?php 
        echo  esc_html( $user_name ) ;
        ?>
							!</h1>
						<p>Welcome to KWS Elementor Kit.
                        </p>

						<a class="cft-button cft-btn-red cft-margin-small-top cft-margin-small-right" target="_blank" rel="" href="https://kwstech.in/kws-elementor-kit/">Read Knowledge Base</a>
						
					</div>
				</div>
			</div>


			<div class="cft-grid cft-visible@xl" cft-grid cft-height-match="target: > div > .cft-card">
				<div class="cft-width-2-3@m cft-welcome-banner">
					<div class="cft-welcome-content cft-card cft-card-body">
						<h1 class="cft-feature-title">
							Welcome <?php 
        echo  esc_html( $current_user->user_firstname ) ;
        ?> <?php 
        echo  esc_html( $current_user->user_lastname ) ;
        ?>
							!</h1>
                        <p>KWS Elementor Kit by KWS Tech for building your amazing site.</p>
					</div>
				</div>
			</div>

			<div class="cft-grid" cft-grid cft-height-match="target: > div > .cft-card">
				<div class="cft-width-2-3@m">
					<div class="cft-card cft-card-body cft-card-green cft-system-requirement">
						<h1 class="cft-feature-title cft-margin-small-bottom">System Requirement</h1>
						<?php 
        $this->kws_elementor_kit_system_requirement();
        ?>
					</div>
				</div>
			</div>

		</div>


	<?php 
    }
    
    function kws_elementor_kit_system_requirement()
    {
        $php_version = phpversion();
        $max_execution_time = ini_get( 'max_execution_time' );
        $memory_limit = ini_get( 'memory_limit' );
        $post_limit = ini_get( 'post_max_size' );
        $uploads = wp_upload_dir();
        $upload_path = $uploads['basedir'];
        $yes_icon = '<span class="valid"><i class="dashicons-before dashicons-yes"></i></span>';
        $no_icon = '<span class="invalid"><i class="dashicons-before dashicons-no-alt"></i></span>';
        $environment = Utils::get_environment_info();
        ?>
		<ul class="check-system-status cft-grid cft-child-width-1-2@m cft-grid-small ">
			<li>
				<div>

					<span class="label1">PHP Version: </span>

					<?php 
        
        if ( version_compare( $php_version, '7.0.0', '<' ) ) {
            echo  $no_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently: ' . $php_version . ' (Min: 7.0 Recommended)</span>' ;
        } else {
            echo  $yes_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently: ' . $php_version . '</span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">Maximum execution time: </span>

					<?php 
        
        if ( $max_execution_time < '90' ) {
            echo  $no_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently: ' . $max_execution_time . '(Min: 90 Recommended)</span>' ;
        } else {
            echo  $yes_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently: ' . $max_execution_time . '</span>' ;
        }
        
        ?>
				</div>
			</li>
			<li>
				<div>
					<span class="label1">Memory Limit: </span>

					<?php 
        
        if ( intval( $memory_limit ) < '256' ) {
            echo  $no_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently: ' . $memory_limit . ' (Min: 256M Recommended)</span>' ;
        } else {
            echo  $yes_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently: ' . $memory_limit . '</span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">Max Post Limit: </span>

					<?php 
        
        if ( intval( $post_limit ) < '32' ) {
            echo  $no_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently: ' . $post_limit . ' (Min: 32M Recommended)</span>' ;
        } else {
            echo  $yes_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently: ' . $post_limit . '</span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">Uploads folder writable: </span>

					<?php 
        
        if ( !is_writable( $upload_path ) ) {
            echo  $no_icon ;
            // XSS ok.
        } else {
            echo  $yes_icon ;
            // XSS ok.
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">MultiSite: </span>

					<?php 
        
        if ( $environment['wp_multisite'] ) {
            echo  '<span class="label2">MultiSite</span>' ;
        } else {
            echo  '<span class="label2">No MultiSite </span>' ;
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">GZip Enabled: </span>

					<?php 
        
        if ( $environment['gzip_enabled'] ) {
            echo  $yes_icon ;
            // XSS ok.
        } else {
            echo  $no_icon ;
            // XSS ok.
        }
        
        ?>
				</div>
			</li>

			<li>
				<div>
					<span class="label1">Debug Mode: </span>
					<?php 
        
        if ( $environment['wp_debug_mode'] ) {
            echo  $no_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently Turned On</span>' ;
        } else {
            echo  $yes_icon ;
            // XSS ok.
            echo  '<span class="label2">Currently Turned Off</span>' ;
        }
        
        ?>
				</div>
			</li>

		</ul>

		<div class="cft-admin-alert">
			<strong>Note:</strong> If you have multiple addons like <b>Elementor Kit</b> so you need some more requirement some
			cases so make sure you added more memory for others addon too.
		</div>
	<?php 
    }
    
    function plugin_page()
    {
        echo  '<div class="wrap kws-elementor-kit-dashboard">' ;
        echo  '<h1>' . CFTKEK_TITLE . ' Settings</h1>' ;
        $this->settings_api->show_navigation();
        ?>


		<div class="cft-switcher">
			<div id="kws_elementor_kit_welcome_page" class="cft-option-page group">
				<?php 
        $this->kws_elementor_kit_welcome();
        ?>
			</div>

			<?php 
        $this->settings_api->show_forms();
        ?>

		</div>

		</div>

		<?php 
        if ( !defined( 'CFTKEK_WL' ) ) {
            $this->footer_info();
        }
        ?>

		<?php 
        $this->script();
        ?>

	<?php 
    }
    
    /**
     * Tabbable JavaScript codes & Initiate Color Picker
     *
     * This code uses localstorage for displaying active tabs
     */
    function script()
    {
        ?>
		<script>

		jQuery(document).ready(function(){
				 jQuery('.kek-no-result').removeClass('cft-animation-shake');
		});

			function filterSearch(e) {
				var parentID = '#' + jQuery(e).data('id');
				var search = jQuery(parentID).find('.cft-search-input').val().toLowerCase();
				if (!search) {
					jQuery(parentID).find('.cft-search-input').attr('cft-filter-control', "");
					jQuery(parentID).find('.cft-widget-all').trigger('click');
				} else {
					jQuery(parentID).find('.cft-search-input').attr('cft-filter-control', "filter: [data-widget-name*='" + search + "']");
					jQuery(parentID).find('.cft-search-input').removeClass('cft-active'); // Thanks to Bar-Rabbas
					jQuery(parentID).find('.cft-search-input').trigger('click');
				}
			}



			jQuery('.kek-options-parent').each(function(e, item) {
				var eachItem = '#' + jQuery(item).attr('id');
				
				jQuery(eachItem).on("beforeFilter", function() {
					jQuery(eachItem).find('.kek-no-result').removeClass('cft-animation-shake');
				});

				jQuery(eachItem).on("afterFilter", function() {

					var isElementVisible = false;
					var i = 0;

					while (!isElementVisible && i < jQuery(eachItem).find(".cft-option-item").length) {
						if (jQuery(eachItem).find(".cft-option-item").eq(i).is(":visible")) {
							isElementVisible = true;
						}
						i++;
					}

					if (isElementVisible === false) {
						jQuery(eachItem).find('.kek-no-result').addClass('cft-animation-shake');
					}
				});


			});


			jQuery('.kek-widget-filter-nav li a').on('click', function(e) {
				jQuery(this).closest('.cft-widget-filter-wrapper').find('.cft-search-input').val('');
				jQuery(this).closest('.cft-widget-filter-wrapper').find('.cft-search-input').val('').attr('cft-filter-control', '');
			});

			jQuery(document).ready(function($) {
				'use strict';

				function hashHandler() {
					var $tab = jQuery('.kws-elementor-kit-dashboard .cft-tab');
					if (window.location.hash) {
						var hash = window.location.hash.substring(1);
						cftUIkit.tab($tab).show(jQuery('#cft-' + hash).data('tab-index'));
					}
				}

				jQuery(window).on('load', function() {
					hashHandler();
				});

				window.addEventListener("hashchange", hashHandler, true);

				jQuery('.toplevel_page_kws_elementor_kit_options > ul > li > a ').on('click', function(event) {
					jQuery(this).parent().siblings().removeClass('current');
					jQuery(this).parent().addClass('current');
				});

				jQuery('#kws_elementor_kit_active_modules_page a.cft-active-all-widget').click(function() {

					<?php 
        ?>

						jQuery('#kws_elementor_kit_active_modules_page .cft-widget-free .checkbox:visible').each(function() {
							jQuery(this).attr('checked', 'checked').prop("checked", true);
						});

					<?php 
        ?>

					jQuery(this).addClass('cft-active');
					jQuery('a.cft-deactive-all-widget').removeClass('cft-active');
				});

				jQuery('#kws_elementor_kit_active_modules_page a.cft-deactive-all-widget').click(function() {

					jQuery('#kws_elementor_kit_active_modules_page .checkbox:visible').each(function() {
						jQuery(this).removeAttr('checked');
					});

					jQuery(this).addClass('cft-active');
					jQuery('a.cft-active-all-widget').removeClass('cft-active');
				});

				jQuery('#kws_elementor_kit_elementor_extend a.cft-active-all-widget').click(function() {

					jQuery('#kws_elementor_kit_elementor_extend .checkbox:visible').each(function() {
						jQuery(this).attr('checked', 'checked').prop("checked", true);
					});

					jQuery(this).addClass('cft-active');
					jQuery('a.cft-deactive-all-widget').removeClass('cft-active');
				});

				jQuery('#kws_elementor_kit_elementor_extend a.cft-deactive-all-widget').click(function() {

					jQuery('#kws_elementor_kit_elementor_extend .checkbox:visible').each(function() {
						jQuery(this).removeAttr('checked');
					});

					jQuery(this).addClass('cft-active');
					jQuery('a.cft-active-all-widget').removeClass('cft-active');
				});

				jQuery('form.settings-save').submit(function(event) {
					event.preventDefault();

					cftUIkit.notification({
						message: '<div cft-spinner></div> <?php 
        esc_html_e( 'Please wait, Saving settings...', 'kws-elementor-kit' );
        ?>',
						timeout: false
					});

					jQuery(this).ajaxSubmit({
						success: function() {
							cftUIkit.notification.closeAll();
							cftUIkit.notification({
								message: '<span class="dashicons dashicons-yes"></span> <?php 
        esc_html_e( 'Settings Saved Successfully.', 'kws-elementor-kit' );
        ?>',
								status: 'primary'
							});
						},
						error: function(data) {
							cftUIkit.notification.closeAll();
							cftUIkit.notification({
								message: '<span cft-icon=\'icon: warning\'></span> <?php 
        esc_html_e( 'Unknown error, make sure access is correct!', 'kws-elementor-kit' );
        ?>',
								status: 'warning'
							});
						}
					});

					return false;
				});

			});
		</script>
	<?php 
    }
    
    function footer_info()
    {
        ?>
		<div class="kws-elementor-kit-footer-info">
			<p>Elementor Kit Addon for KWS</p>
		</div>
<?php 
    }
    
    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages()
    {
        $pages = get_pages();
        $pages_options = [];
        if ( $pages ) {
            foreach ( $pages as $page ) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }
        return $pages_options;
    }

}
new KwsElementorKit_Admin_Settings();