<?php

namespace KwsElementorKit\Modules\NeptuneCarousel\Widgets;

use  Elementor\Controls_Manager ;
use  Elementor\Group_Control_Border ;
use  Elementor\Group_Control_Box_Shadow ;
use  Elementor\Group_Control_Typography ;
use  Elementor\Group_Control_Text_Shadow ;
use  Elementor\Group_Control_Image_Size ;
use  Elementor\Group_Control_Background ;
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
class Neptune_Carousel extends Group_Control_Query
{
    use  Global_Widget_Controls ;
    use  Global_Widget_Functions ;
    use  Global_Swiper_Functions ;
    private  $_query = null ;
    public function get_name()
    {
        return 'kek-neptune-carousel';
    }
    
    public function get_title()
    {
        return CFTKEK . esc_html__( 'Neptune Carousel', 'kws-elementor-kit' );
    }
    
    public function get_icon()
    {
        return 'kek-widget-icon kek-icon-neptune-carousel';
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
            'neptune'
        ];
    }
    
    public function get_style_depends()
    {
        
        if ( $this->kek_is_edit_mode() ) {
            return [ 'kek-all-styles' ];
        } else {
            return [ 'kws-elementor-kit-font', 'kek-neptune-carousel' ];
        }
    
    }
    
    public function get_script_depends()
    {
        
        if ( $this->kek_is_edit_mode() ) {
            return [ 'kek-all-scripts' ];
        } else {
            return [ 'kek-neptune-carousel' ];
        }
    
    }
    
    public function get_custom_help_url() {
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
        $this->add_responsive_control( 'content_alignment', [
            'label'     => __( 'Alignment', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => [
            'left'   => [
            'title' => __( 'Left', 'kws-elementor-kit' ),
            'icon'  => 'eicon-text-align-left',
        ],
            'center' => [
            'title' => __( 'Center', 'kws-elementor-kit' ),
            'icon'  => 'eicon-text-align-center',
        ],
            'right'  => [
            'title' => __( 'Right', 'kws-elementor-kit' ),
            'icon'  => 'eicon-text-align-right',
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-item .kek-content' => 'text-align: {{VALUE}};',
        ],
        ] );
        $this->add_control( 'carousel_active_item', [
            'label'        => __( 'Carousel Active Item', 'kwstech-element-pack' ) . CFTKEK_PC,
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'kek-neptune-carousel-active--',
            'render_type'  => 'template',
            'separator'    => 'before',
            'classes'      => CFTKEK_IS_PC,
        ] );
        $this->add_control( 'active_item', [
            'label'       => __( 'Custom Active Item', 'kwstech-element-pack' ) . CFTKEK_PC,
            'type'        => Controls_Manager::NUMBER,
            'default'     => 2,
            'description' => __( 'Type your item number.', 'kws-elementor-kit' ),
            'classes'     => CFTKEK_IS_PC,
            'condition'   => [
            'carousel_active_item' => '',
        ],
            'render_type' => 'template',
        ] );
        $this->end_controls_section();
        //New Query Builder Settings
        $this->start_controls_section( 'section_post_query_builder', [
            'label' => __( 'Query', 'kws-elementor-kit' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_control( 'item_limit', [
            'label'   => esc_html__( 'Item Limit', 'kws-elementor-kit' ),
            'type'    => Controls_Manager::SLIDER,
            'range'   => [
            'px' => [
            'min' => 0,
            'max' => 21,
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
        //Global Date Controls
        $this->register_date_controls();
        $this->add_control( 'show_category', [
            'label'     => esc_html__( 'Category', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
        ] );
        $this->add_control( 'show_comments', [
            'label'   => esc_html__( 'Show Comments', 'kws-elementor-kit' ),
            'type'    => Controls_Manager::SWITCHER,
            'default' => 'yes',
        ] );
        $this->add_control( 'item_match_height', [
            'label'        => __( 'Item Match Height', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'prefix_class' => 'kek-item-match-height--',
            'separator'    => 'before',
        ] );
        $this->add_control( 'global_link', [
            'label'        => __( 'Item Wrapper Link', 'kws-elementor-kit' ),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'kek-global-link-',
            'description'  => __( 'Be aware! When Item Wrapper Link activated then title link and read more link will not work', 'kws-elementor-kit' ),
        ] );
        $this->end_controls_section();
        //Navigaiton Global Controls
        $this->register_navigation_controls( 'neptune' );
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
            '{{WRAPPER}} .kek-neptune-carousel .kek-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->start_controls_tabs( 'tabs_item_style' );
        $this->start_controls_tab( 'tab_item_normal', [
            'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'content_background',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-item',
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'item_border',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-item',
        ] );
        $this->add_responsive_control( 'item_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'item_padding', [
            'label'      => __( 'Padding', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'item_box_shadow',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-item',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_item_hover', [
            'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'content_hover_background',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-item:hover',
        ] );
        $this->add_control( 'item_hover_border_color', [
            'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
            'item_border_border!' => '',
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-item:hover' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'item_hover_box_shadow',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-item:hover',
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
            '{{WRAPPER}} .kek-neptune-carousel .kek-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'title_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-title',
        ] );
        $this->add_group_control( Group_Control_Text_Shadow::get_type(), [
            'name'     => 'title_text_shadow',
            'label'    => __( 'Text Shadow', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-title',
        ] );
        $this->start_controls_tabs( 'tabs_title_style' );
        $this->start_controls_tab( 'tab_title_normal', [
            'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
        ] );
        $this->add_control( 'title_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-title a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_title_hover', [
            'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
        ] );
        $this->add_control( 'title_color_hover', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-title a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_meta', [
            'label'      => esc_html__( 'Meta', 'kws-elementor-kit' ),
            'tab'        => Controls_Manager::TAB_STYLE,
            'conditions' => [
            'relation' => 'or',
            'terms'    => [ [
            'name'  => 'show_date',
            'value' => 'yes',
        ], [
            'name'  => 'show_comments',
            'value' => 'yes',
        ] ],
        ],
        ] );
        $this->add_control( 'meta_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-meta' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_responsive_control( 'meta_space_between', [
            'label'     => esc_html__( 'Space Between', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-comments' => 'margin-left: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'meta_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-meta',
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'section_style_category', [
            'label'     => esc_html__( 'Category', 'kws-elementor-kit' ),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => [
            'show_category' => 'yes',
        ],
        ] );
        $this->add_responsive_control( 'category_bottom_spacing', [
            'label'     => esc_html__( 'Spacing', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min' => 0,
            'max' => 50,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
            '{{WRAPPER}} .kek-neptune-carousel .kek-category a' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'category_background',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-category a',
        ] );
        $this->add_group_control( Group_Control_Border::get_type(), [
            'name'     => 'category_border',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-category a',
        ] );
        $this->add_responsive_control( 'category_border_radius', [
            'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'category_padding', [
            'label'      => esc_html__( 'Padding', 'kws-elementor-kit' ),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors'  => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        ] );
        $this->add_responsive_control( 'category_spacing', [
            'label'     => esc_html__( 'Space Between', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::SLIDER,
            'range'     => [
            'px' => [
            'min'  => 0,
            'max'  => 50,
            'step' => 2,
        ],
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-category a+a' => 'margin-left: {{SIZE}}{{UNIT}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Box_Shadow::get_type(), [
            'name'     => 'category_shadow',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-category a',
        ] );
        $this->add_group_control( Group_Control_Typography::get_type(), [
            'name'     => 'category_typography',
            'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-category a',
        ] );
        $this->end_controls_tab();
        $this->start_controls_tab( 'tab_category_hover', [
            'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
        ] );
        $this->add_control( 'category_hover_color', [
            'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-category a:hover' => 'color: {{VALUE}};',
        ],
        ] );
        $this->add_group_control( Group_Control_Background::get_type(), [
            'name'     => 'category_hover_background',
            'selector' => '{{WRAPPER}} .kek-neptune-carousel .kek-category a:hover',
        ] );
        $this->add_control( 'category_hover_border_color', [
            'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
            'type'      => Controls_Manager::COLOR,
            'condition' => [
            'category_border_border!' => '',
        ],
            'selectors' => [
            '{{WRAPPER}} .kek-neptune-carousel .kek-category a:hover' => 'border-color: {{VALUE}};',
        ],
        ] );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        //Navigation Global Controls
        $this->register_navigation_style( 'neptune' );
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
    
    public function render_comments( $id = 0 )
    {
        if ( !$this->get_settings( 'show_comments' ) ) {
            return;
        }
        ?>

		<div class="kek-comments kek-flex kek-flex-middle">
			<i class="eicon-comments"></i>
			<span><?php 
        echo  get_comments_number( $id ) ;
        ?></span>
		</div>
		
		<?php 
    }
    
    public function render_header()
    {
        //Global Function
        $this->render_header_attribute( 'neptune' );
        ?>
		<div <?php 
        $this->print_render_attribute_string( 'carousel' );
        ?>>
			<div class="kek-post-wrapper">
				<div class="swiper-container">
					<div class="swiper-wrapper">
		<?php 
    }
    
    public function render_post_grid_item( $post_id, $image_size, $active_item )
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
            'kek-item swiper-slide ' . $active_item,
            true
        );
        ?>
		<div <?php 
        $this->print_render_attribute_string( 'grid-item' );
        ?>>
			<div class="kek-img-wrap">
				<?php 
        $this->render_image( get_post_thumbnail_id( $post_id ), $image_size );
        ?>
			</div>
			<div class="kek-content">
				<?php 
        $this->render_category();
        ?>
				<?php 
        $this->render_title();
        ?>
				<div class="kek-meta kek-flex-inline kek-flex-middle">
					<?php 
        $this->render_date();
        ?>
					<?php 
        $this->render_comments( $post_id );
        ?>
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
        $i = 0;
        while ( $wp_query->have_posts() ) {
            $wp_query->the_post();
            $thumbnail_size = $settings['primary_thumbnail_size'];
            $active_item = '';
            $this->render_post_grid_item( get_the_ID(), $thumbnail_size, $active_item );
        }
        $this->render_footer();
        wp_reset_postdata();
    }

}