<?php

namespace KwsElementorKit\Modules\PlutoGrid\Widgets;

use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Text_Shadow ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Group_Control_Background ;
use  Elementor\Icons_Manager ;
use  KwsElementorKit\Traits\Global_Widget_Controls ;
use  KwsElementorKit\Traits\Global_Widget_Functions ;
use  KwsElementorKit\Includes\Controls\GroupQuery\Group_Control_Query ;
use  KwsElementorKit\Modules\QueryControl\Controls\Group_Control_Posts ;
use  WP_Query ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class Pluto_Grid extends Group_Control_Query
{
    use  Global_Widget_Controls ;
    use  Global_Widget_Functions ;
    private  $_query = null ;
    public function get_name()
    {
        return 'kek-pluto-grid';
    }
    
    public function get_title()
    {
        return CFTKEK . esc_html__( 'Pluto Grid', 'kws-elementor-kit' );
    }
    
    public function get_icon()
    {
        return 'kek-widget-icon kek-icon-pluto-grid';
    }
    
    public function get_categories()
    {
        return [ 'kws-elementor-kit' ];
    }
    
    public function get_keywords()
    {
        return [
            'post',
            'grid',
            'blog',
            'recent',
            'news',
            'pluto'
        ];
    }
    
    public function get_style_depends()
    {
        
        if ( $this->kek_is_edit_mode() ) {
            return [ 'kek-all-styles' ];
        } else {
            return [ 'kws-elementor-kit-font', 'kek-pluto-grid' ];
        }
    
    }
    
    public function get_custom_help_url()
    {
        return '';
    }
    
    public function on_import( $element )
    {
        if ( !get_post_type_object( $element['settings']['posts_post_type'] ) ) {
            $element['settings']['posts_post_type'] = 'post';
        }
        return $element;
    }
    
    public function on_export( $element )
    {
        $element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
        return $element;
    }
    
    public function get_query()
    {
        return $this->_query;
    }
    
    protected function _register_controls()
    {
        $this->start_controls_section( 'section_content_layout', [
            'label' => esc_html__( 'Layout', 'kws-elementor-kit' ),
        ] );
        $this->add_control( 'grid_style', [
            'label'   => esc_html__( 'Layout Style', 'kws-elementor-kit' ),
            'type'    => Controls_Manager::SELECT,
            'default' => '1',
            'options' => [
            '1' => esc_html__( 'Style 01', 'kws-elementor-kit' ),
            '2' => esc_html__( 'Style 02', 'kws-elementor-kit' ),
            '3' => esc_html__( 'Style 03', 'kws-elementor-kit' ),
        ],
        ] );
        $column_size = '';
        $this->add_responsive_control( 'columns', [
            'label'          => __( 'Columns', 'kws-elementor-kit' ) . CFTKEK_PC,
            'type'           => Controls_Manager::SELECT,
            'default'        => '3',
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
            '{{WRAPPER}} .kek-pluto-grid .kek-style-1' => $column_size,
        ],
            'condition'      => [
            'grid_style' => [ '1' ],
        ],
            'classes'        => CFTKEK_IS_PC,
        ] );
        $this->add_responsive_control( 'column_gap', [
            'label'     => esc_html__( 'Item Gap', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-post-grid' => 'grid-gap: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'secondary_image_height', [
            'label'     => esc_html__( 'Secondary Item Height', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 100,
            'max' => 800,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+2), {{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+3), {{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+4), {{WRAPPER}} .kek-pluto-grid .kek-style-3 .kek-item:nth-child(5n+2) .kek-img-wrap .kek-main-img .kek-img, {{WRAPPER}} .kek-pluto-grid .kek-style-3 .kek-item:nth-child(5n+3) .kek-img-wrap .kek-main-img .kek-img, {{WRAPPER}} .kek-pluto-grid .kek-style-3 .kek-item:nth-child(5n+4) .kek-img-wrap .kek-main-img .kek-img, {{WRAPPER}} .kek-pluto-grid .kek-style-3 .kek-item:nth-child(5n+5) .kek-img-wrap .kek-main-img .kek-img' => 'height: {{SIZE}}px;',
        ],
            'condition' => [
            'grid_style' => [ '2', '3' ],
        ],
        ] );
        $this->add_responsive_control( 'secondary_image_width', [
            'label'     => esc_html__( 'Secondary Image Width', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 100,
            'max' => 800,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+2) .kek-img-wrap .kek-main-img, {{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+3) .kek-img-wrap .kek-main-img, {{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+4) .kek-img-wrap .kek-main-img' => 'width: {{SIZE}}px;',
        ],
            'condition' => [
            'grid_style' => [ '2' ],
        ],
        ] );
        $this->add_group_control( Group_Control_Image_Size::get_type(), [
            'name'    => 'primary_thumbnail',
            'exclude' => [ 'custom' ],
            'default' => 'medium',
        ] );
        $this->end_controls_section();
        // Query Settings
        $this->start_controls_section( 'section_post_query_builder', [
            'label' => __( 'Query', 'kws-elementor-kit' ) . CFTKEK_NC,
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'item_limit', [
            'label'     => esc_html__( 'Item Limit', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => 0,
            'max'  => 21,
            'step' => 3,
        ],
        ],
            'default'   => [
            'size' => 6,
        ],
            'condition' => [
            'grid_style' => [ '1' ],
        ],
        ] );
        $this->add_control( 'item_limit_2', [
            'label'     => esc_html__( 'Item Limit', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => 0,
            'max'  => 20,
            'step' => 4,
        ],
        ],
            'default'   => [
            'size' => 4,
        ],
            'condition' => [
            'grid_style' => [ '2' ],
        ],
        ] );
        $this->add_control( 'item_limit_3', [
            'label'     => esc_html__( 'Item Limit', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => 0,
            'max'  => 20,
            'step' => 5,
        ],
        ],
            'default'   => [
            'size' => 5,
        ],
            'condition' => [
            'grid_style' => [ '3' ],
        ],
        ] );
        $this->register_query_builder_controls();
        $this->end_controls_section();
        $this->start_controls_section( 'section_content_additional', [
            'label' => esc_html__( 'Additional', 'kws-elementor-kit' ),
        ] );
        //Global Title Controls
        $this->register_title_controls();
        $this->add_control( 'show_excerpt', [
            'label'   => esc_html__( 'Show Text', 'kws-elementor-kit' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'excerpt_length', [
            'label'       => esc_html__( 'Text Limit', 'kws-elementor-kit' ),
            'description' => esc_html__( 'It\'s just work for main content, but not working with excerpt. If you set 0 so you will get full main content.', 'kws-elementor-kit' ),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 30,
            'condition'   => [
            'show_excerpt' => 'yes',
        ],
        ] );
        $this->add_control( 'strip_shortcode', [
            'label'     => esc_html__( 'Strip Shortcode', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'condition' => [
            'show_excerpt' => 'yes',
        ],
        ] );
        $this->add_control( 'show_author', [
            'label'     => esc_html__( 'Show Author', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
        ] );
        $this->add_control( 'meta_separator', [
            'label'       => __( 'Separator', 'kws-elementor-kit' ) . CFTKEK_NC,
            'type'        => Controls_Manager::TEXT,
            'default'     => '|',
            'label_block' => false,
        ] );
        //Global Date Controls
        $this->register_date_controls();
        $this->add_control( 'show_category', [
            'label'     => esc_html__( 'Show Category', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
        ] );
        $this->add_control( 'primary_meta_end_position', [
            'label'        => esc_html__( 'Primary Meta End Position', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'prefix_class' => 'kek-primary-meta-end-position--',
        ] );
        $this->add_control( 'secondary_meta_end_position', [
            'label'        => esc_html__( 'Secondary Meta End Position', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'kek-secondary-meta-end-position--',
            'condition'    => [
            'grid_style!' => '1',
        ],
        ] );
        $this->add_control( 'readmore_type', [
            'label'     => esc_html__( 'Read More Type', 'kws-elementor-kit' ) . CFTKEK_PC,
            'type'      => Controls_Manager::SELECT,
            'default'   => 'none',
            'options'   => [
            'none'     => esc_html__( 'None', 'kws-elementor-kit' ),
            'classic'  => esc_html__( 'Classic', 'kws-elementor-kit' ),
            'on_image' => esc_html__( 'On Image', 'kws-elementor-kit' ),
        ],
            'separator' => 'before',
            'classes'   => CFTKEK_IS_PC,
        ] );
        $this->add_control( 'show_pagination', [
            'label'     => esc_html__( 'Pagination', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'separator' => 'before',
        ] );
        $this->add_control( 'global_link', [
            'label'        => __( 'Item Wrapper Link', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'kek-global-link-',
            'description'  => __( 'Be aware! When Item Wrapper Link activated then title link and read more link will not work', 'kws-elementor-kit' ),
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_content_readmore', [
            'label'     => esc_html__( 'Read More', 'kws-elementor-kit' ) . CFTKEK_NC,
            'condition' => [
            'readmore_type' => 'classic',
        ],
        ] );
        $this->add_control( 'readmore_text', [
            'label'       => esc_html__( 'Read More Text', 'kws-elementor-kit' ),
            'type'        => Controls_Manager::TEXT,
            'default'     => esc_html__( 'Read More', 'kws-elementor-kit' ),
            'placeholder' => esc_html__( 'Read More', 'kws-elementor-kit' ),
        ] );
        $this->add_control( 'readmore_icon', [
            'label'       => esc_html__( 'Icon', 'kws-elementor-kit' ),
            'type'        => Controls_Manager::ICONS,
            'label_block' => false,
            'skin'        => 'inline',
        ] );
        $this->add_control( 'readmore_icon_align', [
            'label'     => esc_html__( 'Icon Position', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'default'   => 'right',
            'toggle'    => false,
            'options'   => [
            'left'  => [
            'title' => esc_html__( 'Left', 'kws-elementor-kit' ),
            'icon'  => 'eicon-h-align-left',
        ],
            'right' => [
            'title' => esc_html__( 'Right', 'kws-elementor-kit' ),
            'icon'  => 'eicon-h-align-right',
        ],
        ],
            'condition' => [
            'readmore_icon[value]!' => '',
        ],
        ] );
        $this->add_responsive_control( 'readmore_icon_indent', [
            'label'     => esc_html__( 'Icon Spacing', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'default'   => [
            'size' => 8,
        ],
            'range'     => [
            'px' => [
            'max' => 50,
        ],
        ],
            'condition' => [
            'readmore_icon[value]!' => '',
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-button-icon-align-right' => ( is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};' ),
            '{{WRAPPER}} .kek-pluto-grid .kek-button-icon-align-left'  => ( is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};' ),
        ],
        ] );
        $this->end_controls_section();
        //Style
        $this->start_controls_section( 'kek_section_style', [
            'label' => esc_html__( 'Items', 'kws-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_STYLE,
        ] );
        $this->add_responsive_control( 'content_padding', [
            'label'      => __( 'Content Padding', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->start_controls_tabs( 'tabs_item_style' );
        $this->start_controls_tab( 'tab_item_normal', [
            'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'itam_background',
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item',
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'        => 'item_border',
            'label'       => __( 'Border', 'kws-elementor-kit' ),
            'placeholder' => '1px',
            'default'     => '1px',
            'selector'    => '{{WRAPPER}} .kek-pluto-grid .kek-item',
        ] );
        $this->add_responsive_control( 'item_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'item_box_shadow',
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_item_hover', [
            'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'itam_background_color_hover',
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item:hover',
        ] );
        $this->add_control( 'item_border_color_hover', [
            'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item:hover' => 'border-color: {{VALUE}};',
        ],
            'condition' => [
            'item_border_border!' => '',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'item_box_shadow_hover',
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item:hover',
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_title', [
            'label'     => esc_html__( 'Title', 'kws-elementor-kit' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'show_title' => 'yes',
        ],
        ] );
        $this->add_control( 'title_style', [
            'label'   => esc_html__( 'Style', 'kws-elementor-kit' ),
            'type'    => Controls_Manager::SELECT,
            'default' => 'underline',
            'options' => [
            'underline'        => esc_html__( 'Underline', 'kws-elementor-kit' ),
            'middle-underline' => esc_html__( 'Middle Underline', 'kws-elementor-kit' ),
            'overline'         => esc_html__( 'Overline', 'kws-elementor-kit' ),
            'middle-overline'  => esc_html__( 'Middle Overline', 'kws-elementor-kit' ),
        ],
        ] );
        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'title_hover_color', [
            'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_responsive_control( 'title_spacing', [
            'label'     => esc_html__( 'Spacing', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'      => 'secondary_title_typography',
            'label'     => esc_html__( 'Secondary Typography', 'kws-elementor-kit' ),
            'selector'  => '{{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+2) .kek-title, {{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+3) .kek-title, {{WRAPPER}} .kek-pluto-grid .kek-style-2 .kek-item:nth-child(4n+4) .kek-title, {{WRAPPER}} .kek-pluto-grid .kek-style-3 .kek-item:nth-child(5n+2) .kek-title, {{WRAPPER}} .kek-pluto-grid .kek-style-3 .kek-item:nth-child(5n+3) .kek-title, {{WRAPPER}} .kek-pluto-grid .kek-style-3 .kek-item:nth-child(5n+4) .kek-title, {{WRAPPER}} .kek-pluto-grid .kek-style-3 .kek-item:nth-child(5n+5) .kek-title',
            'condition' => [
            'grid_style' => [ '2', '3' ],
        ],
        ] );
        $this->add_control( 'title_advanced_style', [
            'label' => esc_html__( 'Advanced Style', 'kws-elementor-kit' ),
            'type'  => Controls_Manager::SWITCHER,
        ] );
        $this->add_control( 'title_background', [
            'label'     => esc_html__( 'Background Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title a' => 'background-color: {{VALUE}};',
        ],
            'condition' => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_group_control( Group_Control_Text_Shadow::get_type(), [
            'name'      => 'title_text_shadow',
            'label'     => __( 'Text Shadow', 'kws-elementor-kit' ),
            'selector'  => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title a',
            'condition' => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'      => 'title_border',
            'selector'  => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title a',
            'condition' => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_responsive_control( 'title_border_radius', [
            'label'      => __( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'condition'  => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'      => 'title_box_shadow',
            'selector'  => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title a',
            'condition' => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_responsive_control( 'title_text_padding', [
            'label'      => __( 'Padding', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'condition'  => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_text', [
            'label'     => esc_html__( 'Text', 'kws-elementor-kit' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'show_excerpt' => 'yes',
        ],
        ] );
        $this->add_control( 'text_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-text-wrap .kek-text' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'text_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-text-wrap .kek-text',
        ] );
        $this->add_responsive_control( 'text_margin', [
            'label'      => __( 'Margin', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-text-wrap .kek-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_meta', [
            'label'      => esc_html__( 'Meta', 'kws-elementor-kit' ),
            'tab'        => Controls_Manager::TAB_STYLE,
            'conditions' => [
            'relation' => 'or',
            'terms'    => [ [
            'name'  => 'show_author',
            'value' => 'yes',
        ], [
            'name'  => 'show_date',
            'value' => 'yes',
        ] ],
        ],
        ] );
        $this->add_control( 'meta_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-meta .kek-blog-author a, {{WRAPPER}} .kek-pluto-grid .kek-item .kek-meta' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'meta_hover_color', [
            'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-meta .kek-blog-author a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_responsive_control( 'meta_spacing', [
            'label'     => esc_html__( 'Space Between', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-meta .kek-separator' => 'margin: 0 {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'meta_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-meta',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_category', [
            'label'     => esc_html__( 'Category', 'kws-elementor-kit' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'show_category' => 'yes',
        ],
        ] );
        $this->add_responsive_control( 'category_spacing', [
            'label'     => esc_html__( 'Spacing', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->start_controls_tabs( 'tabs_category_style' );
        $this->start_controls_tab( 'tab_category_normal', [
            'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
        ] );
        $this->add_control( 'category_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'category_background',
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a',
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'category_border',
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a',
        ] );
        $this->add_responsive_control( 'category_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'category_padding', [
            'label'      => esc_html__( 'Padding', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'category_margin', [
            'label'      => esc_html__( 'Margin', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'category_spacing_between', [
            'label'     => esc_html__( 'Space Between', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a+a' => 'margin-left: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'category_shadow',
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'category_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_category_hover', [
            'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
        ] );
        $this->add_control( 'category_hover_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'category_hover_background',
            'selector' => '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a:hover',
        ] );
        $this->add_control( 'category_hover_border_color', [
            'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
            'category_border_border!' => '',
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-grid .kek-item .kek-category a:hover' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        //Global Pagination Controls
        $this->register_pagination_controls();
    }
    
    /**
     * Main query render for this widget
     * @param $posts_per_page number item query limit
     */
    public function query_posts( $posts_per_page )
    {
        $default = $this->getGroupControlQueryArgs();
        
        if ( $posts_per_page ) {
            $args['posts_per_page'] = $posts_per_page;
            $args['paged'] = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
        }
        
        $args = array_merge( $default, $args );
        $this->_query = new WP_Query( $args );
    }
    
    public function render_readmore()
    {
        $settings = $this->get_settings_for_display();
        $animation = ( $this->get_settings( 'readmore_hover_animation' ) ? ' elementor-animation-' . $this->get_settings( 'readmore_hover_animation' ) : '' );
        ?>
	
			<a href="<?php 
        echo  esc_url( get_permalink() ) ;
        ?>" class="kek-readmore kek-display-inline-block <?php 
        echo  esc_attr( $animation ) ;
        ?>">
				<?php 
        echo  esc_html( $this->get_settings( 'readmore_text' ) ) ;
        ?>
				
				<?php 
        
        if ( $settings['readmore_icon']['value'] ) {
            ?>
					<span class="kek-button-icon-align-<?php 
            echo  esc_attr( $this->get_settings( 'readmore_icon_align' ) ) ;
            ?>">
						<?php 
            Icons_Manager::render_icon( $settings['readmore_icon'], [
                'aria-hidden' => 'true',
                'class'       => 'fa-fw',
            ] );
            ?>
					</span>
				<?php 
        }
        
        ?>
			</a>
			<?php 
    }
    
    public function render_readmore_on_image()
    {
        ?>
			<a href="<?php 
        echo  esc_url( get_permalink() ) ;
        ?>" class="kek-readmore-on-image">
				<span class="kek-readmore-icon"><span></span></span>
			</a>
			<?php 
    }
    
    public function render_post_grid_item( $post_id, $image_size, $excerpt_length )
    {
        $settings = $this->get_settings_for_display();
        if ( 'yes' == $settings['global_link'] ) {
            $this->add_render_attribute(
                'grid-item',
                'onclick',
                "window.open('" . esc_url( get_permalink() ) . "', '_self')",
                true
            );
        }
        $this->add_render_attribute(
            'grid-item',
            'class',
            'kek-item',
            true
        );
        ?>
            <div <?php 
        $this->print_render_attribute_string( 'grid-item' );
        ?>>
                <div class="kek-item-box">
                    <div class="kek-img-wrap">
                        <div class="kek-main-img">
							<?php 
        $this->render_image( get_post_thumbnail_id( $post_id ), $image_size );
        ?>
							<?php 
        ?>
                        </div>
                    </div>

                    <div class="kek-content">
                        <div>
                            
							<?php 
        $this->render_category();
        ?>
							<?php 
        $this->render_title();
        ?>

                            <div class="kek-text-wrap">
								<?php 
        $this->render_excerpt( $excerpt_length );
        ?>
								<?php 
        ?>
                            </div>

							<?php 
        
        if ( $settings['show_author'] or $settings['show_date'] ) {
            ?>
                            <div class="kek-meta">
								<?php 
            
            if ( $settings['show_author'] ) {
                ?>
                                <div class="kek-blog-author">
                                    <a class="author-name"
                                       href="<?php 
                echo  get_author_posts_url( get_the_author_meta( 'ID' ) ) ;
                ?>">
										<?php 
                echo  get_the_author() ;
                ?>
                                    </a>
                                </div>
								<span class="kek-separator"><?php 
                echo  $settings['meta_separator'] ;
                ?></span>
								<?php 
            }
            
            ?>
								<?php 
            $this->render_date();
            ?>
                            </div>
							<?php 
        }
        
        ?>

                        </div>
                    </div>

                </div>
            </div>
			<?php 
    }
    
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        if ( $settings['grid_style'] == '2' ) {
            $this->query_posts( $settings['item_limit_2']['size'] );
        } elseif ( $settings['grid_style'] == '3' ) {
            $this->query_posts( $settings['item_limit_3']['size'] );
        } else {
            $this->query_posts( $settings['item_limit']['size'] );
        }
        
        $wp_query = $this->get_query();
        if ( !$wp_query->found_posts ) {
            return;
        }
        $this->add_render_attribute( 'grid-wrap', 'class', 'kek-post-grid' );
        $this->add_render_attribute( 'grid-wrap', 'class', 'kek-style-' . $settings['grid_style'] );
        
        if ( isset( $settings['kek_in_animation_show'] ) && $settings['kek_in_animation_show'] == 'yes' ) {
            $this->add_render_attribute( 'grid-wrap', 'class', 'kek-in-animation' );
            if ( isset( $settings['kek_in_animation_delay']['size'] ) ) {
                $this->add_render_attribute( 'grid-wrap', 'data-in-animation-delay', $settings['kek_in_animation_delay']['size'] );
            }
        }
        
        ?>

            <div class="kek-pluto-grid">
				<div <?php 
        $this->print_render_attribute_string( 'grid-wrap' );
        ?>>
					
					<?php 
        while ( $wp_query->have_posts() ) {
            $wp_query->the_post();
            $thumbnail_size = $settings['primary_thumbnail_size'];
            ?>
						
						<?php 
            $this->render_post_grid_item( get_the_ID(), $thumbnail_size, $settings['excerpt_length'] );
            ?>
					
					<?php 
        }
        ?>
                </div>
            </div>
			
			<?php 
        
        if ( $settings['show_pagination'] ) {
            ?>
                <div class="ep-pagination">
					<?php 
            kws_elementor_kit_post_pagination( $wp_query, $this->get_id() );
            ?>
                </div>
				<?php 
        }
        
        wp_reset_postdata();
    }

}