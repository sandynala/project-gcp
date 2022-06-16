<?php

namespace KwsElementorKit\Modules\SocialShare\Widgets;

use  KwsElementorKit\Base\Module_Base ;
use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Repeater ;
use  KwsElementorKit\Modules\SocialShare\Module ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class Social_Share extends Module_Base
{
    protected  $_has_template_content = false ;
    private static  $medias_class = array(
        'email'     => 'kek-icon-envelope',
        'vkontakte' => 'kek-icon-vk',
    ) ;
    private static function get_social_media_class( $media_name )
    {
        if ( isset( self::$medias_class[$media_name] ) ) {
            return self::$medias_class[$media_name];
        }
        return 'kek-icon-' . $media_name;
    }
    
    public function get_name()
    {
        return 'kek-social-share';
    }
    
    public function get_title()
    {
        return CFTKEK . esc_html__( 'Social Share', 'kws-elementor-kit' );
    }
    
    public function get_icon()
    {
        return 'kek-widget-icon kek-icon-social-share';
    }
    
    public function get_categories()
    {
        return [ 'kws-elementor-kit' ];
    }
    
    public function get_keywords()
    {
        return [ 'social', 'link', 'share' ];
    }
    
    public function get_style_depends()
    {
        
        if ( $this->kek_is_edit_mode() ) {
            return [ 'kek-all-styles' ];
        } else {
            return [ 'kws-elementor-kit-font', 'kek-social-share' ];
        }
    
    }
    
    public function get_script_depends()
    {
        
        if ( $this->kek_is_edit_mode() ) {
            return [ 'kek-all-scripts' ];
        } else {
            return [ 'goodshare' ];
        }
    
    }
    
    public function get_custom_help_url()
    {
        return '';
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_buttons_content', [
            'label' => esc_html__( 'Share Buttons', 'kws-elementor-kit' ),
        ] );
        $repeater = new Repeater();
        $medias = Module::get_social_media();
        $medias_names = array_keys( $medias );
        $repeater->add_control( 'button', [
            'label'   => esc_html__( 'Social Media', 'kws-elementor-kit' ),
            'type'    => Controls_Manager::SELECT,
            'options' => array_reduce( $medias_names, function ( $options, $media_name ) use( $medias ) {
            $options[$media_name] = $medias[$media_name]['title'];
            return $options;
        }, [] ),
            'default' => 'facebook',
        ] );
        $repeater->add_control( 'text', [
            'label' => esc_html__( 'Custom Label', 'kws-elementor-kit' ),
            'type'  => Controls_Manager::TEXT,
        ] );
        $this->add_control( 'share_buttons', [
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
            [
            'button' => 'facebook',
        ],
            [
            'button' => 'linkedin',
        ],
            [
            'button' => 'twitter',
        ],
            [
            'button' => 'pinterest',
        ]
        ],
            'title_field' => '{{{ button }}}',
        ] );
        $this->add_control( 'view', [
            'label'        => esc_html__( 'View', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'label_block'  => false,
            'options'      => [
            'icon-text' => 'Icon & Text',
            'icon'      => 'Icon',
            'text'      => 'Text',
        ],
            'default'      => 'icon-text',
            'separator'    => 'before',
            'prefix_class' => 'kek-ss-btns-view-',
            'render_type'  => 'template',
        ] );
        $this->add_control( 'show_counter', [
            'label'     => esc_html__( 'Count', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'condition' => [
            'view!' => 'icon',
        ],
        ] );
        $this->add_control( 'show_counter_note', [
            'type'            => Controls_Manager::RAW_HTML,
            'raw'             => esc_html__( 'Note: Social share count only works with those platform: vkontakte, facebook, odnoklassniki, moimir, linkedin, tumblr, pinterest, buffer.', 'kws-elementor-kit' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
            'condition'       => [
            'show_counter' => 'yes',
            'view!'        => 'icon',
        ],
        ] );
        $this->add_control( 'hr', [
            'type' => Controls_Manager::DIVIDER,
        ] );
        $this->add_control( 'layout_style', [
            'label'        => esc_html__( 'Display', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'default'      => 'inline',
            'options'      => [
            'inline' => esc_html__( 'Inline', 'kws-elementor-kit' ),
            'grid'   => esc_html__( 'Grid', 'kws-elementor-kit' ),
        ],
            'prefix_class' => 'kek-layout-style--',
        ] );
        $this->add_responsive_control( 'columns', [
            'label'          => __( 'Columns', 'kws-elementor-kit' ),
            'type'           => Controls_Manager::SELECT,
            'default'        => '4',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options'        => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
        ],
            'selectors'      => [
            '{{WRAPPER}} .kek-social-share' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
        ],
            'condition'      => [
            'layout_style' => 'grid',
        ],
        ] );
        $this->add_responsive_control( 'column_gap', [
            'label'     => esc_html__( 'Gap', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'default'   => [
            'size' => 10,
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-social-share' => 'grid-gap: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'layout_style' => 'grid',
        ],
        ] );
        $this->add_responsive_control( 'inline_column_gap', [
            'label'     => esc_html__( 'Columns Gap', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'default'   => [
            'size' => 10,
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-ss-btn'  => 'margin-right: calc({{SIZE}}{{UNIT}} / 2); margin-left: calc({{SIZE}}{{UNIT}} / 2);',
            '{{WRAPPER}} .kek-ep-grid' => 'margin-right: calc(-{{SIZE}}{{UNIT}} / 2); margin-left: calc(-{{SIZE}}{{UNIT}} / 2);',
        ],
            'condition' => [
            'layout_style' => 'inline',
        ],
        ] );
        $this->add_responsive_control( 'row_gap', [
            'label'     => esc_html__( 'Rows Gap', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'default'   => [
            'size' => 10,
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-ss-btn' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
            'condition' => [
            'layout_style' => 'inline',
        ],
        ] );
        $this->add_responsive_control( 'alignment', [
            'label'     => esc_html__( 'Alignment', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
            'flex-start'    => [
            'title' => esc_html__( 'Left', 'kws-elementor-kit' ),
            'icon'  => 'eicon-text-align-left',
        ],
            'center'        => [
            'title' => esc_html__( 'Center', 'kws-elementor-kit' ),
            'icon'  => 'eicon-text-align-center',
        ],
            'flex-end'      => [
            'title' => esc_html__( 'Right', 'kws-elementor-kit' ),
            'icon'  => 'eicon-text-align-right',
        ],
            'space-between' => [
            'title' => esc_html__( 'Justify', 'kws-elementor-kit' ),
            'icon'  => 'eicon-text-align-justify',
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-social-share' => 'justify-content: {{VALUE}};',
        ],
            'condition' => [
            'layout_style' => 'inline',
        ],
        ] );
        $this->add_control( 'hr_1', [
            'type'      => Controls_Manager::DIVIDER,
            'condition' => [
            'layout_style' => 'inline',
        ],
        ] );
        $this->add_control( 'layout_position', [
            'label'        => esc_html__( 'Position', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'default'      => 'default',
            'options'      => [
            'default'      => esc_html__( 'Default', 'kws-elementor-kit' ),
            'top-left'     => esc_html__( 'Top Left', 'kws-elementor-kit' ),
            'top-right'    => esc_html__( 'Top Right', 'kws-elementor-kit' ),
            'center-left'  => esc_html__( 'Center Left', 'kws-elementor-kit' ),
            'center-right' => esc_html__( 'Center Right', 'kws-elementor-kit' ),
            'bottom-left'  => esc_html__( 'Bottom Left', 'kws-elementor-kit' ),
            'bottom-right' => esc_html__( 'Bottom Right', 'kws-elementor-kit' ),
        ],
            'prefix_class' => 'kek-ss-position--',
            'condition'    => [
            'layout_style' => 'inline',
        ],
        ] );
        $this->add_control( 'social_share_offset', [
            'label'       => __( 'Offset', 'kws-elementor-kit' ),
            'type'        => Controls_Manager::POPOVER_TOGGLE,
            'condition'   => [
            'layout_position!' => 'default',
            'layout_style'     => 'inline',
        ],
            'render_type' => 'ui',
        ] );
        $this->start_popover();
        $this->add_responsive_control( 'ss_horizontal_offset', [
            'label'     => esc_html__( 'Horizontal', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => -200,
            'max'  => 200,
            'step' => 10,
        ],
        ],
            'default'   => [
            'unit' => 'px',
            'size' => 0,
        ],
            'condition' => [
            'social_share_offset' => 'yes',
        ],
            'selectors' => [
            '{{WRAPPER}}.kek-layout-style--inline .kek-social-share' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'ss_vertical_offset', [
            'label'     => esc_html__( 'Vertical', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => -200,
            'max'  => 200,
            'step' => 10,
        ],
        ],
            'default'   => [
            'unit' => 'px',
            'size' => 0,
        ],
            'condition' => [
            'social_share_offset' => 'yes',
        ],
            'selectors' => [
            '{{WRAPPER}}.kek-layout-style--inline .kek-social-share' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->end_popover();
        $this->add_control( 'share_url_type', [
            'label'     => esc_html__( 'Target URL', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SELECT,
            'options'   => [
            'current_page' => esc_html__( 'Current Page', 'kws-elementor-kit' ),
            'custom'       => esc_html__( 'Custom', 'kws-elementor-kit' ),
        ],
            'default'   => 'current_page',
            'separator' => 'before',
        ] );
        $this->add_control( 'share_url', [
            'label'         => esc_html__( 'URL', 'kws-elementor-kit' ),
            'type'          => Controls_Manager::URL,
            'show_external' => false,
            'placeholder'   => 'http://your-link.com',
            'condition'     => [
            'share_url_type' => 'custom',
        ],
        ] );
        $this->end_controls_section();
        //Style
        $this->start_controls_section( 'section_buttons_style', [
            'label' => esc_html__( 'Share Buttons', 'kws-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_control( 'style', [
            'label'        => esc_html__( 'Style', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'options'      => [
            'flat'     => esc_html__( 'Flat', 'kws-elementor-kit' ),
            'framed'   => esc_html__( 'Framed', 'kws-elementor-kit' ),
            'gradient' => esc_html__( 'Gradient', 'kws-elementor-kit' ),
            'minimal'  => esc_html__( 'Minimal', 'kws-elementor-kit' ),
            'boxed'    => esc_html__( 'Boxed Icon', 'kws-elementor-kit' ),
        ],
            'default'      => 'flat',
            'prefix_class' => 'kek-ss-btns-style-',
        ] );
        $prefix_class = '';
        $this->add_control( 'icon_top', [
            'label'        => __( 'Icon Position Top', 'kws-elementor-kit' ) . CFTKEK_PC,
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => $prefix_class,
            'condition'    => [
            'layout_position!' => [ 'center-left', 'center-right' ],
            'view'             => 'icon-text',
        ],
            'classes'      => CFTKEK_IS_PC,
        ] );
        $this->add_responsive_control( 'ss_icon_padding', [
            'label'      => __( 'Icon Padding', 'kws-elementor-kit' ) . CFTKEK_PC,
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
            '{{WRAPPER}}.kek-ss-icon-top--yes .kek-ss-btn .kek-ss-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'condition'  => [
            'icon_top' => 'yes',
        ],
        ] );
        $this->add_responsive_control( 'ss_text_padding', [
            'label'      => __( 'Text Padding', 'kws-elementor-kit' ) . CFTKEK_PC,
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors'  => [
            '{{WRAPPER}}.kek-ss-icon-top--yes .kek-ss-btn .kek-social-share-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'condition'  => [
            'icon_top' => 'yes',
        ],
        ] );
        $this->add_control( 'divider_one', [
            'type' => Controls_Manager::DIVIDER,
        ] );
        $this->add_responsive_control( 'button_size', [
            'label'     => esc_html__( 'Button Size', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => 0.5,
            'max'  => 2,
            'step' => 0.1,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-ss-btn' => 'font-size: calc({{SIZE}}{{UNIT}} * 10);',
        ],
        ] );
        $this->add_responsive_control( 'icon_size', [
            'label'          => esc_html__( 'Icon Size', 'kws-elementor-kit' ),
            'type'           => Controls_Manager::SLIDER,
            'range'          => [
            'em' => [
            'min'  => 0.5,
            'max'  => 4,
            'step' => 0.1,
        ],
            'px' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'default'        => [
            'unit' => 'em',
        ],
            'tablet_default' => [
            'unit' => 'em',
        ],
            'mobile_default' => [
            'unit' => 'em',
        ],
            'size_units'     => [ 'em', 'px' ],
            'selectors'      => [
            '{{WRAPPER}} .kek-ss-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
            'condition'      => [
            'view!' => 'text',
        ],
        ] );
        $this->add_responsive_control( 'button_height', [
            'label'          => esc_html__( 'Button Height', 'kws-elementor-kit' ),
            'type'           => Controls_Manager::SLIDER,
            'range'          => [
            'em' => [
            'min'  => 1,
            'max'  => 7,
            'step' => 0.1,
        ],
            'px' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
            'default'        => [
            'unit' => 'em',
        ],
            'tablet_default' => [
            'unit' => 'em',
        ],
            'mobile_default' => [
            'unit' => 'em',
        ],
            'size_units'     => [ 'em', 'px' ],
            'selectors'      => [
            '{{WRAPPER}} .kek-ss-btn' => 'height: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'border_size', [
            'label'      => esc_html__( 'Border Size', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em' ],
            'default'    => [
            'size' => 2,
        ],
            'range'      => [
            'px' => [
            'min' => 1,
            'max' => 20,
        ],
            'em' => [
            'max'  => 2,
            'step' => 0.1,
        ],
        ],
            'selectors'  => [
            '{{WRAPPER}} .kek-ss-btn' => 'border-width: {{SIZE}}{{UNIT}};',
        ],
            'condition'  => [
            'style' => [ 'framed', 'boxed' ],
        ],
        ] );
        $this->add_responsive_control( 'border_radius', [
            'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-ss-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_control( 'text_padding', [
            'label'      => esc_html__( 'Text Padding', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}}.kek-ss-btns-view-text .kek-social-share-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'separator'  => 'before',
            'condition'  => [
            'view' => 'text',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-social-share-title, {{WRAPPER}} .kek-ss-counter',
            'exclude'  => [ 'line_height' ],
        ] );
        $this->add_control( 'color_source', [
            'label'        => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SELECT,
            'label_block'  => false,
            'options'      => [
            'original' => 'Original Color',
            'custom'   => 'Custom Color',
        ],
            'default'      => 'original',
            'prefix_class' => 'kek-ss-btns-color-',
            'separator'    => 'before',
        ] );
        $this->start_controls_tabs( 'tabs_button_style' );
        $this->start_controls_tab( 'tab_button_normal', [
            'label'     => esc_html__( 'Normal', 'kws-elementor-kit' ),
            'condition' => [
            'color_source' => 'custom',
        ],
        ] );
        $this->add_control( 'primary_color', [
            'label'     => esc_html__( 'Primary Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}}.kek-ss-btns-style-flat .kek-ss-btn,
					 {{WRAPPER}}.kek-ss-btns-style-gradient .kek-ss-btn,
					 {{WRAPPER}}.kek-ss-btns-style-boxed .kek-ss-btn .kek-ss-icon,
					 {{WRAPPER}}.kek-ss-btns-style-minimal .kek-ss-btn .kek-ss-icon' => 'background-color: {{VALUE}}',
            '{{WRAPPER}}.kek-ss-btns-style-framed .kek-ss-btn,
					 {{WRAPPER}}.kek-ss-btns-style-minimal .kek-ss-btn,
					 {{WRAPPER}}.kek-ss-btns-style-boxed .kek-ss-btn'                                                                                                       => 'color: {{VALUE}}; border-color: {{VALUE}}',
        ],
            'condition' => [
            'color_source' => 'custom',
        ],
        ] );
        $this->add_control( 'secondary_color', [
            'label'     => esc_html__( 'Secondary Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}}.kek-ss-btns-style-flat .kek-ss-icon, 
					 {{WRAPPER}}.kek-ss-btns-style-flat .kek-social-share-text, 
					 {{WRAPPER}}.kek-ss-btns-style-gradient .kek-ss-icon,
					 {{WRAPPER}}.kek-ss-btns-style-gradient .kek-social-share-text,
					 {{WRAPPER}}.kek-ss-btns-style-boxed .kek-ss-icon,
					 {{WRAPPER}}.kek-ss-btns-style-minimal .kek-ss-icon' => 'color: {{VALUE}}',
            '{{WRAPPER}}.kek-ss-btns-style-framed .kek-ss-btn'                                                                                                                                                                                                                                                                                                                                                                                                                         => 'background-color: {{VALUE}}',
        ],
            'condition' => [
            'color_source' => 'custom',
        ],
        ] );
        $this->add_control( 'border_color', [
            'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}}.kek-ss-btns-style-boxed .kek-ss-btn, {{WRAPPER}}.kek-ss-btns-style-framed .kek-ss-btn' => 'border-color: {{VALUE}}',
        ],
            'condition' => [
            'color_source' => 'custom',
            'style'        => [ 'framed', 'boxed' ],
        ],
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_button_hover', [
            'label'     => esc_html__( 'Hover', 'kws-elementor-kit' ),
            'condition' => [
            'color_source' => 'custom',
        ],
        ] );
        $this->add_control( 'primary_color_hover', [
            'label'     => esc_html__( 'Primary Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}}.kek-ss-btns-style-flat .kek-ss-btn:hover,
					 {{WRAPPER}}.kek-ss-btns-style-gradient .kek-ss-btn:hover'                                                                                   => 'background-color: {{VALUE}}',
            '{{WRAPPER}}.kek-ss-btns-style-framed .kek-ss-btn:hover,
					 {{WRAPPER}}.kek-ss-btns-style-minimal .kek-ss-btn:hover,
					 {{WRAPPER}}.kek-ss-btns-style-boxed .kek-ss-btn:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}',
            '{{WRAPPER}}.kek-ss-btns-style-boxed .kek-ss-btn:hover .kek-ss-icon, 
					 {{WRAPPER}}.kek-ss-btns-style-minimal .kek-ss-btn:hover .kek-ss-icon'                                                        => 'background-color: {{VALUE}}',
        ],
            'condition' => [
            'color_source' => 'custom',
        ],
        ] );
        $this->add_control( 'secondary_color_hover', [
            'label'     => esc_html__( 'Secondary Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}}.kek-ss-btns-style-flat .kek-ss-btn:hover .kek-ss-icon, 
					 {{WRAPPER}}.kek-ss-btns-style-flat .kek-ss-btn:hover .kek-social-share-text, 
					 {{WRAPPER}}.kek-ss-btns-style-gradient .kek-ss-btn:hover .kek-ss-icon,
					 {{WRAPPER}}.kek-ss-btns-style-gradient .kek-ss-btn:hover .kek-social-share-text,
					 {{WRAPPER}}.kek-ss-btns-style-boxed .kek-ss-btn:hover .kek-ss-icon,
					 {{WRAPPER}}.kek-ss-btns-style-minimal .kek-ss-btn:hover .kek-ss-icon' => 'color: {{VALUE}}',
            '{{WRAPPER}}.kek-ss-btns-style-framed .kek-ss-btn:hover'                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               => 'background-color: {{VALUE}}',
        ],
            'condition' => [
            'color_source' => 'custom',
        ],
        ] );
        $this->add_control( 'border_hover_color', [
            'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}}.kek-ss-btns-style-boxed .kek-ss-btn:hover, {{WRAPPER}}.kek-ss-btns-style-framed .kek-ss-btn:hover' => 'border-color: {{VALUE}}',
        ],
            'condition' => [
            'color_source' => 'custom',
            'style'        => [ 'framed', 'boxed' ],
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }
    
    private function has_counter( $media_name )
    {
        $settings = $this->get_active_settings();
        return 'icon' !== $settings['view'] && 'yes' === $settings['show_counter'] && !empty(Module::get_social_media( $media_name )['has_counter']);
    }
    
    public function render()
    {
        $settings = $this->get_active_settings();
        if ( empty($settings['share_buttons']) ) {
            return;
        }
        $show_text = 'text' === $settings['view'] || 'icon-text' === $settings['view'];
        ?>
		<div class="kek-social-share kek-ep-grid">
			<?php 
        foreach ( $settings['share_buttons'] as $button ) {
            $social_name = $button['button'];
            $has_counter = $this->has_counter( $social_name );
            if ( 'custom' === $settings['share_url_type'] ) {
                $this->add_render_attribute(
                    'social-attrs',
                    'data-url',
                    esc_url( $settings['share_url']['url'] ),
                    true
                );
            }
            $this->add_render_attribute(
                [
                'social-attrs' => [
                'class'       => [ 'kek-ss-btn', 'kek-ss-' . $social_name ],
                'data-social' => $social_name,
            ],
            ],
                '',
                '',
                true
            );
            ?>
				<div class="kek-social-share-item kek-ep-grid-item">
					<div <?php 
            echo  $this->get_render_attribute_string( 'social-attrs' ) ;
            ?>>
						<?php 
            
            if ( 'icon' === $settings['view'] || 'icon-text' === $settings['view'] ) {
                ?>
							<span class="kek-ss-icon">
								<i class="<?php 
                echo  self::get_social_media_class( $social_name ) ;
                ?>"></i>
							</span>
						<?php 
            }
            
            ?>
						<?php 
            
            if ( $show_text || $has_counter ) {
                ?>
							<div class="kek-social-share-text kek-inline">
								<?php 
                
                if ( 'icon-text' === $settings['view'] || 'text' === $settings['view'] ) {
                    ?>
									<span class="kek-social-share-title">
										<?php 
                    echo  ( $button['text'] ? esc_html( $button['text'] ) : Module::get_social_media( $social_name )['title'] ) ;
                    ?>
									</span>
								<?php 
                }
                
                ?>
								<?php 
                
                if ( $has_counter ) {
                    ?>
									<span class="kek-social-share-counter" data-counter="<?php 
                    echo  esc_attr( $social_name ) ;
                    ?>"></span>
								<?php 
                }
                
                ?>
							</div>
						<?php 
            }
            
            ?>
					</div>
				</div>
				<?php 
        }
        ?>
		</div>

		
		<?php 
    }

}