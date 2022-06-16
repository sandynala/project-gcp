<?php

namespace KwsElementorKit\Modules\PlutoCarousel\Widgets;

use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Text_Shadow ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Group_Control_Background ;
use  Elementor\Icons_Manager ;
use  KwsElementorKit\Utils ;
use  KwsElementorKit\Traits\Global_Widget_Controls ;
use  KwsElementorKit\Traits\Global_Widget_Functions ;
use  KwsElementorKit\Traits\Global_Swiper_Functions ;
use  KwsElementorKit\Includes\Controls\GroupQuery\Group_Control_Query ;
use  KwsElementorKit\Modules\QueryControl\Controls\Group_Control_Posts ;
use  WP_Query ;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly
class Pluto_Carousel extends Group_Control_Query
{
    use  Global_Widget_Controls ;
    use  Global_Widget_Functions ;
    use  Global_Swiper_Functions ;
    private  $_query = null ;
    public function get_name()
    {
        return 'kek-pluto-carousel';
    }
    
    public function get_title()
    {
        return CFTKEK . esc_html__( 'Pluto Carousel', 'kws-elementor-kit' );
    }
    
    public function get_icon()
    {
        return 'kek-widget-icon kek-icon-pluto-carousel';
    }
    
    public function get_categories()
    {
        return [ 'kws-elementor-kit' ];
    }
    
    public function get_keywords()
    {
        return [
            'post',
            'carousel',
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
            return [ 'kws-elementor-kit-font', 'kek-pluto-carousel' ];
        }
    
    }
    
    public function get_script_depends()
    {
        
        if ( $this->kek_is_edit_mode() ) {
            return [ 'kek-all-scripts' ];
        } else {
            return [ 'kek-pluto-carousel' ];
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
        $this->add_responsive_control( 'columns', [
            'label'          => __( 'Columns', 'kws-elementor-kit' ),
            'type'           => Controls_Manager::SELECT,
            'default'        => 3,
            'tablet_default' => 2,
            'mobile_default' => 1,
            'options'        => [
            1 => '1',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5',
            6 => '6',
        ],
        ] );
        $this->add_responsive_control( 'item_gap', [
            'label'          => __( 'Item Gap', 'kws-elementor-kit' ),
            'type'           => Controls_Manager::SLIDER,
            'default'        => [
            'size' => 20,
        ],
            'tablet_default' => [
            'size' => 20,
        ],
            'mobile_default' => [
            'size' => 20,
        ],
            'range'          => [
            'px' => [
            'min' => 0,
            'max' => 100,
        ],
        ],
        ] );
        $this->add_group_control( Group_Control_Image_Size::get_type(), [
            'name'    => 'primary_thumbnail',
            'exclude' => [ 'custom' ],
            'default' => 'medium',
        ] );
        $this->add_responsive_control( 'default_image_height', [
            'label'     => esc_html__( 'Image Height(px)', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 100,
            'max' => 500,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-img-wrap .kek-main-img' => 'height: {{SIZE}}px;',
        ],
        ] );
        $this->end_controls_section();
        // Query Settings
        $this->start_controls_section( 'section_post_query_builder', [
            'label' => __( 'Query', 'kws-elementor-kit' ) . CFTKEK_NC,
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'item_limit', [
            'label'   => esc_html__( 'Item Limit', 'kws-elementor-kit' ),
            'type'    => Controls_Manager::SLIDER,
            'range'   => [
            'px' => [
            'min' => 1,
            'max' => 20,
        ],
        ],
            'default' => [
            'size' => 6,
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
            'label'     => esc_html__( 'Show Text', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
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
        $this->add_control( 'meta_info', [
            'label'       => __( 'Info', 'kws-elementor-kit' ) . CFTKEK_NC,
            'type'        => Controls_Manager::TEXT,
            'default'     => '|',
            'label_block' => false,
            'dynamic' => [
                'active' => true,
				'categories' => [
					\Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY,
					\Elementor\Modules\DynamicTags\Module::NUMBER_CATEGORY
				],                
            ],
        ] );

        //Global Date Controls
        $this->register_date_controls();
        $this->add_control( 'show_category', [
            'label'     => esc_html__( 'Show Category', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
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
        $this->add_control( 'item_match_height', [
            'label'        => __( 'Item Match Height', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'prefix_class' => 'kek-item-match-height--',
            'separator'    => 'before',
            'render_type'  => 'template',
        ] );
        $this->add_control( 'meta_end_position', [
            'label'        => esc_html__( 'Meta End Position', 'kws-elementor-kit' ) . CFTKEK_NC,
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'kek-meta-end-position--',
            'condition'    => [
            'item_match_height' => 'yes',
        ],
        ] );
        $this->add_control( 'global_link', [
            'label'        => __( 'Item Wrapper Link', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'kek-global-link-',
            'description'  => __( 'Be aware! When Item Wrapper Link activated then title link and read more link will not work', 'kws-elementor-kit' ),
            'separator'    => 'before',
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-button-icon-align-right' => ( is_rtl() ? 'margin-right: {{SIZE}}{{UNIT}};' : 'margin-left: {{SIZE}}{{UNIT}};' ),
            '{{WRAPPER}} .kek-pluto-carousel .kek-button-icon-align-left'  => ( is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};' ),
        ],
        ] );
        $this->end_controls_section();
        //Navigaiton Global Controls
        $this->register_navigation_controls( 'pluto' );
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->start_controls_tabs( 'tabs_item_style' );
        $this->start_controls_tab( 'tab_item_normal', [
            'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'itam_background',
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-item',
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'        => 'item_border',
            'label'       => __( 'Border', 'kws-elementor-kit' ),
            'placeholder' => '1px',
            'default'     => '1px',
            'selector'    => '{{WRAPPER}} .kek-pluto-carousel .kek-item',
        ] );
        $this->add_responsive_control( 'item_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'item_box_shadow',
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-item',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_item_hover', [
            'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'itam_background_hover',
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-item:hover',
        ] );
        $this->add_control( 'item_border_color_hover', [
            'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-item:hover' => 'border-color: {{VALUE}};',
        ],
            'condition' => [
            'item_border_border!' => '',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'item_box_shadow_hover',
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-item:hover',
        ] );
        $this->add_responsive_control( 'item_shadow_padding', [
            'label'       => __( 'Match Padding', 'kws-elementor-kit' ),
            'description' => __( 'You have to add padding for matching overlaping normal/hover box shadow when you used Box Shadow option.', 'kws-elementor-kit' ),
            'type'        => Controls_Manager::SLIDER,
            'range'       => [
            'px' => [
            'min'  => 0,
            'step' => 1,
            'max'  => 50,
        ],
        ],
            'selectors'   => [
            '{{WRAPPER}} .swiper-container' => 'padding: {{SIZE}}{{UNIT}}; margin: 0 -{{SIZE}}{{UNIT}};',
        ],
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-title a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'title_hover_color', [
            'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-title a:hover' => 'color: {{VALUE}};',
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-title a',
        ] );
        $this->add_control( 'title_advanced_style', [
            'label' => esc_html__( 'Advanced Style', 'kws-elementor-kit' ),
            'type'  => Controls_Manager::SWITCHER,
        ] );
        $this->add_control( 'title_background', [
            'label'     => esc_html__( 'Background Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-title a' => 'background-color: {{VALUE}};',
        ],
            'condition' => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_group_control( Group_Control_Text_Shadow::get_type(), [
            'name'      => 'title_text_shadow',
            'label'     => __( 'Text Shadow', 'kws-elementor-kit' ),
            'selector'  => '{{WRAPPER}} .kek-pluto-carousel .kek-title a',
            'condition' => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'      => 'title_border',
            'selector'  => '{{WRAPPER}} .kek-pluto-carousel .kek-title a',
            'condition' => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_responsive_control( 'title_border_radius', [
            'label'      => __( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-title a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
            'condition'  => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'      => 'title_box_shadow',
            'selector'  => '{{WRAPPER}} .kek-pluto-carousel .kek-title a',
            'condition' => [
            'title_advanced_style' => 'yes',
        ],
        ] );
        $this->add_responsive_control( 'title_text_padding', [
            'label'      => __( 'Padding', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-text' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'text_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-text',
        ] );
        $this->add_responsive_control( 'text_margin', [
            'label'      => __( 'Margin', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_author', [
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
        $this->add_control( 'author_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-meta .kek-blog-author a, {{WRAPPER}} .kek-pluto-carousel .kek-meta' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'author_hover_color', [
            'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-meta .kek-blog-author a:hover' => 'color: {{VALUE}};',
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-meta .kek-separator' => 'margin: 0 {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'author_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-meta',
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-category a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'category_background',
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-category a',
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'category_border',
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-category a',
        ] );
        $this->add_responsive_control( 'category_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'category_padding', [
            'label'      => esc_html__( 'Padding', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'category_margin', [
            'label'      => esc_html__( 'Margin', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-category' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            '{{WRAPPER}} .kek-pluto-carousel .kek-category a+a' => 'margin-left: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'category_shadow',
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-category a',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'category_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-category a',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_category_hover', [
            'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
        ] );
        $this->add_control( 'category_hover_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-category a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'category_hover_background',
            'selector' => '{{WRAPPER}} .kek-pluto-carousel .kek-category a:hover',
        ] );
        $this->add_control( 'category_hover_border_color', [
            'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
            'category_border_border!' => '',
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-pluto-carousel .kek-category a:hover' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        //Navigation Global Controls
        $this->register_navigation_style( 'pluto' );
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
    
    public function render_header()
    {
        //Global Function
        $this->render_header_attribute( 'pluto' );
        ?>
		<div <?php 
        $this->print_render_attribute_string( 'carousel' );
        ?>>
			<div class="kek-post-grid">
				<div class="swiper-container">
					<div class="swiper-wrapper">
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
            'kek-item swiper-slide',
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
                        <p>X<?php $this->get_settings( 'meta_info' ) ?>X</p>
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
								<a class="author-name" href="<?php 
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
    
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $this->query_posts( $settings['item_limit']['size'] );
        $wp_query = $this->get_query();
        if ( !$wp_query->found_posts ) {
            return;
        }
        $this->render_header();
        while ( $wp_query->have_posts() ) {
            $wp_query->the_post();
            $thumbnail_size = $settings['primary_thumbnail_size'];
            $this->render_post_grid_item( get_the_ID(), $thumbnail_size, $settings['excerpt_length'] );
        }
        $this->render_footer();
        wp_reset_postdata();
    }

}