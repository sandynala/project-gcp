<?php
	
	namespace KwsElementorKit\Modules\PostCategory\Widgets;
	
	use KwsElementorKit\Base\Module_Base;
	use Elementor\Controls_Manager;
	use Elementor\Group_Control_Border;
	use Elementor\Group_Control_Box_Shadow;
	use Elementor\Group_Control_Typography;
	use Elementor\Group_Control_Background;
	use Elementor\Group_Control_Image_Size;
	
	use KwsElementorKit\Modules\QueryControl\Controls\Group_Control_Posts;
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly
	
	class Post_Category extends Module_Base {
		private $_query = null;
		
		public function get_name() {
			return 'kek-post-category';
		}
		
		public function get_title() {
			return CFTKEK . esc_html__( 'Category', 'kws-elementor-kit' );
		}
		
		public function get_icon() {
			return 'kek-widget-icon kek-icon-post-category';
		}
		
		public function get_categories() {
			return [ 'kws-elementor-kit' ];
		}
		
		public function get_keywords() {
			return [ 'post', 'list', 'blog', 'recent', 'news', 'category' ];
		}
		
		public function get_style_depends() {
			if ( $this->kek_is_edit_mode() ) {
				return [ 'kek-all-styles' ];
			} else {
				return [ 'kek-post-category' ];
			}
		}
		
		public function get_custom_help_url() {
			return '';
		}
		
		public function on_import( $element ) {
			if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
				$element['settings']['posts_post_type'] = 'post';
			}
			
			return $element;
		}
		
		public function on_export( $element ) {
			$element = Group_Control_Posts::on_export_remove_setting_from_element( $element, 'posts' );
			
			return $element;
		}
		
		public function get_query() {
			return $this->_query;
		}
		
		protected function _register_controls() {
			
		    $image_settings = kws_elementor_kit_option( 'category_image', 'kws_elementor_kit_other_settings', 'on' );
			
			$this->start_controls_section(
				'section_content_layout',
				[
					'label' => esc_html__( 'Layout', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'style',
				[
					'label'   => __( 'Style', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => 'Style 1',
						'2' => 'Style 2',
                        '3' => 'Style 3',
					],
				]
			);
			
			$this->add_responsive_control(
				'columns',
				[
					'label'          => __( 'Columns', 'kws-elementor-kit' ),
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
						'{{WRAPPER}} .kek-post-category' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
					],
				]
			);
			
			$this->add_responsive_control(
				'column_gap',
				[
					'label'     => esc_html__( 'Column Gap', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 20,
					],
					'selectors' => [
						'{{WRAPPER}} .kek-post-category' => 'grid-gap: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'item_height',
				[
					'label'     => esc_html__( 'Item Height', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 50,
							'max' => 500,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item' => 'min-height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'alignment',
				[
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
						]
					],
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item' => 'text-align: {{VALUE}};',
					],
				]
			);
			if ( $image_settings == 'on' ):
				$this->add_control(
					'show_image',
					[
						'label'     => esc_html__( 'Show Image', 'kws-elementor-kit' ),
						'type'      => Controls_Manager::SWITCHER,
						'default'   => 'no',
						'separator' => 'before'
					]
				);
			endif;
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'      => 'cat_image_size',
					'exclude'   => [ 'custom' ],
					'include'   => [],
					'default'   => 'thumbnail',
					'condition' => [
						'show_image' => 'yes'
					]
				]
			);
			$this->add_control(
				'show_count',
				[
					'label'   => esc_html__( 'Show Count', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);
			$this->add_control(
				'show_checkbox',
				[
					'label'   => esc_html__( 'Show Checkbox', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
				]
			);
			$this->add_control(
				'show_text',
				[
					'label' => esc_html__( 'Show Text', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_control(
				'text_length',
				[
					'label'       => esc_html__( 'Text Limit', 'kws-elementor-kit' ),
					'description' => esc_html__( 'If you set 0 so you will get full main content.', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 30,
					'condition'   => [
						'show_text' => 'yes'
					],
				]
			);
			
			$this->add_control(
				'view_all_button',
				[
					'label' => esc_html__( 'View All Button', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_post_grid_query',
				[
					'label' => esc_html__( 'Query', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'item_limit',
				[
					'label'   => esc_html__( 'Item Limit', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SLIDER,
					'range'   => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'default' => [
						'size' => 6,
					],
				]
			);
			
			$this->add_control(
				'taxonomy',
				[
					'label'   => esc_html__( 'Taxonomy', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'category',
					'options' => kws_elementor_kit_get_taxonomies(),
				]
			);
			
			$this->add_control(
				'orderby',
				[
					'label'   => esc_html__( 'Order By', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'name',
					'options' => [
						'name'       => esc_html__( 'Name', 'kws-elementor-kit' ),
						'post_date'  => esc_html__( 'Date', 'kws-elementor-kit' ),
						'post_title' => esc_html__( 'Title', 'kws-elementor-kit' ),
						'menu_order' => esc_html__( 'Menu Order', 'kws-elementor-kit' ),
						'rand'       => esc_html__( 'Random', 'kws-elementor-kit' ),
					],
				]
			);
			
			$this->add_control(
				'order',
				[
					'label'   => esc_html__( 'Order', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'asc',
					'options' => [
						'asc'  => esc_html__( 'ASC', 'kws-elementor-kit' ),
						'desc' => esc_html__( 'DESC', 'kws-elementor-kit' ),
					],
				]
			);
			
			$this->add_control(
				'exclude',
				[
					'label'       => esc_html__( 'Exclude', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => __( 'Category ID: 12,3,1', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'parent',
				[
					'label'       => esc_html__( 'Parent', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::TEXT,
					'placeholder' => __( 'Category ID: 12', 'kws-elementor-kit' ),
				]
			);
			
			$this->end_controls_section();
			
			//Style
			$this->start_controls_section(
				'kek_section_style',
				[
					'label' => esc_html__( 'Items', 'kws-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->start_controls_tabs( 'tabs_item_style' );
			
			$this->start_controls_tab(
				'tab_item_normal',
				[
					'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'single_background',
				[
					'label' => esc_html__( 'Single Background', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'item_background',
					'selector'  => '{{WRAPPER}} .kek-post-category .kek-category-item',
					'condition' => [
						'single_background' => 'yes'
					]
				]
			);
			
			$this->add_control(
				'multiple_background',
				[
					'label'       => esc_html__( 'Multiple Background', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::TEXTAREA,
					'placeholder' => '#000000, #f5f5f5, #999999',
					'condition'   => [
						'single_background' => ''
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'item_border',
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item',
				]
			);
			
			$this->add_responsive_control(
				'item_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-post-category .kek-category-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'item_padding',
				[
					'label'      => __( 'Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-post-category .kek-category-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'item_box_shadow',
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item',
				]
			);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'tab_item_hover',
				[
					'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'itam_background_hover',
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item:hover',
				]
			);
			
			$this->add_control(
				'item_border_color_hover',
				[
					'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item:hover' => 'border-color: {{VALUE}};'
					],
					'condition' => [
						'item_border_border!' => ''
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'item_box_shadow_hover',
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item:hover',
				]
			);
			
			$this->add_control(
				'item_hover_opacity',
				[
					'label'     => esc_html__( 'Opacity', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'max'  => 1,
							'step' => 0.1
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item:hover' => 'opacity: {{SIZE}};',
					],
				]
			);
			
			$this->end_controls_tab();
			
			$this->end_controls_tabs();
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_category_image',
				[
					'label'     => esc_html__( 'Image', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_image' => 'yes',
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'cat_image_background',
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-image img',
				]
			);
			$this->add_responsive_control(
				'cat_image_width',
				[
					'label'      => esc_html__( 'Image Size', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'default'    => [
						'unit' => '%',
						'size' => 100,
					],
					'selectors'  => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-image img' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition'  => [
						'style' => '1'
					]
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'cat_image_border',
					'label'    => esc_html__( 'Border', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-image img',
				]
			);
			
			$this->add_responsive_control(
				'cat_image_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'cat_image_padding',
				[
					'label'      => esc_html__( 'Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_responsive_control(
				'cat_image_bottom_spacing',
				[
					'label'     => esc_html__( 'Spacing', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'unit' => 'px',
						'size' => 10,
					],
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'style' => '1'
					],
				]
			);
			
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'cat_image_box_shadow',
					'label'    => esc_html__( 'Shadow', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-image img',
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_category_name',
				[
					'label' => esc_html__( 'Name', 'kws-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_control(
				'category_name_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-name' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'category_name_color_hover',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item:hover .kek-category-name' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'category_name_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-name',
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_category_text',
				[
					'label' => esc_html__( 'Description', 'kws-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_control(
				'category_text_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-text' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'category_text_color_hover',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item:hover .kek-category-text' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'category_text_spacing',
				[
					'label'     => __( 'Spacing', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-text' => 'padding-top: {{SIZE}}px;'
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'category_text_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-text',
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_count',
				[
					'label' => esc_html__( 'Count', 'kws-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_control(
				'count_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'count_color_hover',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-post-category .kek-category-item:hover .kek-category-count' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'count_background',
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count',
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'count_border',
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count',
				]
			);
			
			$this->add_responsive_control(
				'count_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'count_padding',
				[
					'label'      => __( 'Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'count_box_shadow',
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count',
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'count_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count',
				]
			);
			
			$this->add_control(
				'count_offset_toggle',
				[
					'label'        => __( 'Offset', 'kws-elementor-kit' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'label_off'    => __( 'None', 'kws-elementor-kit' ),
					'label_on'     => __( 'Custom', 'kws-elementor-kit' ),
					'return_value' => 'yes',
				]
			);
			
			$this->start_popover();
			
			$this->add_responsive_control(
				'count_horizontal_offset',
				[
					'label'       => __( 'Horizontal Offset', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'  => - 300,
							'step' => 2,
							'max'  => 300,
						],
					],
					'condition'   => [
						'count_offset_toggle' => 'yes'
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count' => 'right: {{SIZE}}px;',
					],
				]
			);
			
			$this->add_responsive_control(
				'count_vertical_offset',
				[
					'label'       => __( 'Vertical Offset', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'  => - 300,
							'step' => 2,
							'max'  => 300,
						],
					],
					'condition'   => [
						'count_offset_toggle' => 'yes'
					],
					'render_type' => 'ui',
					'selectors'   => [
						'{{WRAPPER}} .kek-post-category .kek-category-item .kek-category-count' => 'top: {{SIZE}}px;',
					],
				]
			);
			
			$this->end_popover();
			
			$this->end_controls_section();

		}
		
		public function render() {
			$settings       = $this->get_settings_for_display();
			$image_settings = kws_elementor_kit_option( 'category_image', 'kws_elementor_kit_other_settings', 'on' );
			$categories     = get_categories(
				[
					'taxonomy'   => $settings["taxonomy"],
					'orderby'    => $settings["orderby"],
					'order'      => $settings["order"],
					'hide_empty' => 0,
					'exclude'    => explode( ',', esc_attr( $settings["exclude"] ) ),
					'parent'     => $settings["parent"],
				] );
			
			$this->add_render_attribute( 'category-container', 'class', 'kek-post-category' );
			$this->add_render_attribute( 'category-container', 'class', 'kek-category-style-' . $settings['style'] );
			
			if ( $settings['view_all_button'] == 'yes') {
				$this->add_render_attribute( 'category-container', 'class', 'kek-category-view-all');
			}
			
			
			if ( ! empty( $categories ) ) :
				
				?>
                <div <?php $this->print_render_attribute_string( 'category-container' ); ?>>
					<?php
						$multiple_bg    = explode( ',', rtrim( $settings['multiple_background'], ',' ) );
						$total_category = count( $categories );
						
						// re-creating array for the multiple colors
						$jCount = count( $multiple_bg );
						$j      = 0;
						for ( $i = 0; $i < $total_category; $i ++ ) {
							if ( $j == $jCount ) {
								$j = 0;
							}
							$multiple_bg_create[ $i ] = $multiple_bg[ $j ];
							$j ++;
						}
						
						foreach ( $categories as $index => $cat ) :
							
							$this->add_render_attribute( 'category-item', 'class', 'kek-category-item', true );
							
							$this->add_render_attribute( 'category-item', 'href', get_category_link( $cat->cat_ID ), true );
							
							$bg_color = strToHex( $cat->cat_name );
							//===============================
							// 		CATEGORY IMAGE
							$category_image_id = get_term_meta( $cat->cat_ID, 'kek-category-image-id', true );
							
							if ( ! empty( $category_image_id ) ) {
								$category_url   = wp_get_attachment_image_url( $category_image_id, $settings['cat_image_size_size'] );
								$category_image = '<div class="kek-category-image"><img src="' . $category_url . '" alt=""></div>';
							} else {
								$category_image = '';
							}
							//===============================
							
							if ( ! empty( $settings['multiple_background'] ) ) {
								$bg_color = $multiple_bg_create[ $index ];
								if ( ! preg_match( '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $multiple_bg_create[ $index ] ) ) {
									$bg_color = strToHex( $cat->cat_name );
								}
							}
							
							if ( $settings['single_background'] == '' ) {
								$this->add_render_attribute( 'category-item', 'style', "background-color: $bg_color", true );
							}
							
							?>

                            <a <?php $this->print_render_attribute_string( 'category-item' ); ?>>
                                <!-- display image  -->
								<?php if ( $image_settings == 'on' && $settings['show_image'] == 'yes' ):
									echo $category_image;
								endif; ?>
                                <div class="kek-content">
                                    <span class="kek-category-name"><?php echo $cat->cat_name; ?></span>
									
									<?php if ( ! empty( $cat->category_description ) and $settings['show_text'] == 'yes' ) : ?>
                                        <span class="kek-category-text"><?php echo wp_trim_words( $cat->category_description, $settings['text_length'] ); ?></span>
									<?php endif; ?>
									
									<?php if ( $settings['show_count'] == 'yes' ){ 
									?>

                                        <span class="kek-category-count"><?php echo $cat->category_count; ?></span>
										<?php } ?>
                                    
									<!-- Custom code to show check box to select category -->
                                    
									<?php if ( $settings['show_checkbox'] == 'yes' ){
										?>
										<div class="custom_checkbox">
  											<input type="checkbox" name="<?php echo $cat->cat_name; ?>" value="<?php echo $cat->slug; ?>" class="category_checkbox">
											<span class="unchecked_item"></span>
											<span class="checked_item">
												<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 32 32">
												<g id="Group_11701" data-name="Group 11701" transform="translate(-152 -47)">
													<circle id="Ellipse_33" data-name="Ellipse 33" cx="16" cy="16" r="16" transform="translate(152 47)"/>
													<path id="Path_717" data-name="Path 717" d="M0-5.05,3.462-1.891l7.76-9.194" transform="translate(162.278 69.173)" fill="none" stroke="#fff" stroke-width="3"/>
												</g>
												</svg>
											</span>
										</div>

									<!-- <span class="kek-category-count"><?php echo $cat->category_count; ?></span> -->
									
									<?php } ?> 
                                </div>
								
								<?php if ( $settings['view_all_button'] == 'yes' ) : ?>
                                    <div class="kek-category-btn">
                                        <span>view all</span>
                                    </div>
								<?php endif; ?>

                            </a>
							<?php
							
							if ( ! empty( $settings['item_limit']['size'] ) ) {
								if ( $index == ( $settings['item_limit']['size'] - 1 ) ) {
									break;
								}
							}
						endforeach;
					?>
                </div>
			<?php
			else :
				
				echo '<div class="kek-alert">' . __( 'Category Not Found!', 'kws-elementor-kit' ) . '</div>';
			
			endif;
		}
	}
