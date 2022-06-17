<?php
	
	namespace KwsElementorKit\Traits;
	
	use Elementor\Controls_Manager;
	use Elementor\Group_Control_Border;
	use Elementor\Group_Control_Typography;
	use Elementor\Group_Control_Background;
	use Elementor\Group_Control_Box_Shadow;
	use KwsElementorKit\Modules\QueryControl\Controls\Group_Control_Posts;
	
	defined( 'ABSPATH' ) || die();
	
	trait Global_Widget_Controls {
		
		/**
		 * Register Group of pagination controls
		 */
		protected function register_pagination_controls() {
			
			$this->start_controls_section(
				'section_style_pagination',
				[
					'label'     => esc_html__( 'Pagination', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_pagination' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'pagination_alignment',
				[
					'label'   => __( 'Alignment', 'kws-elementor-kit' ) . CFTKEK_NC,
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'left'   => [
							'title' => __( 'Left', 'kws-elementor-kit' ),
							'icon'  => 'eicon-text-align-left',
						],
						'center'   => [
							'title' => __( 'Center', 'kws-elementor-kit' ),
							'icon'  => 'eicon-text-align-center',
						],
						'flex-end'  => [
							'title' => __( 'Right', 'kws-elementor-kit' ),
							'icon'  => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .ep-pagination .kek-pagination' => 'justify-content: {{VALUE}};',
					],
				]
			);
			
			$this->start_controls_tabs( 'tabs_pagination_style' );
			
			$this->start_controls_tab(
				'tab_pagination_normal',
				[
					'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'pagination_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.kek-pagination li a, {{WRAPPER}} ul.kek-pagination li span' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'pagination_background',
					'selector'  => '{{WRAPPER}} ul.kek-pagination li a',
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'pagination_border',
					'label'    => esc_html__( 'Border', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} ul.kek-pagination li a',
				]
			);

			$this->add_responsive_control(
				'pagination_radius',
				[
					'label'     => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} ul.kek-pagination li a' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
				]
			);

			$this->add_responsive_control(
				'pagination_padding',
				[
					'label'     => esc_html__( 'Padding', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::DIMENSIONS,
					'selectors' => [
						'{{WRAPPER}} ul.kek-pagination li a' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					],
				]
			);
			
			$this->add_responsive_control(
				'pagination_offset',
				[
					'label'     => esc_html__( 'Offset', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .kek-pagination' => 'margin-top: {{SIZE}}px;',
					],
				]
			);
			
			$this->add_responsive_control(
				'pagination_space',
				[
					'label'     => esc_html__( 'Spacing', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .kek-pagination'     => 'margin-left: {{SIZE}}px;',
						'{{WRAPPER}} .kek-pagination > *' => 'padding-left: {{SIZE}}px;',
					],
				]
			);
			
			$this->add_responsive_control(
				'pagination_arrow_size',
				[
					'label'     => esc_html__( 'Arrow Size', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} ul.kek-pagination li a svg' => 'height: {{SIZE}}px; width: auto;',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'pagination_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} ul.kek-pagination li a, {{WRAPPER}} ul.kek-pagination li span',
				]
			);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'tab_pagination_hover',
				[
					'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'pagination_hover_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.kek-pagination li a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'pagination_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.kek-pagination li a:hover' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'pagination_border_border!' => ''
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'pagination_hover_background',
					'types'    => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} ul.kek-pagination li a:hover',
				]
			);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'tab_pagination_active',
				[
					'label' => esc_html__( 'Active', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'pagination_active_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.kek-pagination li.kek-active a' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'pagination_active_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ul.kek-pagination li.kek-active a' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'pagination_border_border!' => ''
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'pagination_active_background',
					'selector' => '{{WRAPPER}} ul.kek-pagination li.kek-active a',
				]
			);
			
			$this->end_controls_tab();
			
			$this->end_controls_tabs();
			
			$this->end_controls_section();
		}
		
		/**
		 * Register Group of Date controls
		 */
		protected function register_date_controls() {
			
			$this->add_control(
				'show_date',
				[
					'label'     => esc_html__( 'Date', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'separator' => 'before'
				]
			);
			
			$this->add_control(
				'human_diff_time',
				[
					'label'     => esc_html__( 'Human Different Time', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'show_date' => 'yes'
					]
				]
			);
			
			$this->add_control(
				'human_diff_time_short',
				[
					'label'       => esc_html__( 'Time Short Format', 'kws-elementor-kit' ),
					'description' => esc_html__( 'This will work for Hours, Minute and Seconds', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SWITCHER,
					'condition'   => [
						'human_diff_time' => 'yes',
						'show_date'       => 'yes'
					]
				]
			);
			
			$this->add_control(
				'show_time',
				[
					'label'     => esc_html__( 'Show Time', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'human_diff_time' => '',
						'show_date'       => 'yes'
					]
				]
			);
		}
		
		/**
		 * Register Group of Title controls
		 */
		protected function register_title_controls() {
			
			$this->add_control(
				'show_title',
				[
					'label'   => esc_html__( 'Title', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);
			
			$this->add_control(
				'title_tags',
				[
					'label'     => __( 'Title HTML Tag', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'h3',
					'options'   => kws_elementor_kit_title_tags(),
					'condition' => [
						'show_title' => 'yes'
					]
				]
			);
		}
		
		/**
		 * Register Group of query controls
		 */
		protected function register_query_controls() {
			$this->add_group_control(
				Group_Control_Posts::get_type(),
				[
					'name'  => 'posts',
					'label' => esc_html__( 'Posts', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'advanced',
				[
					'label' => esc_html__( 'Advanced', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			
			$this->add_control(
				'orderby',
				[
					'label'   => esc_html__( 'Order By', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'post_date',
					'options' => [
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
					'default' => 'desc',
					'options' => [
						'asc'  => esc_html__( 'ASC', 'kws-elementor-kit' ),
						'desc' => esc_html__( 'DESC', 'kws-elementor-kit' ),
					],
				]
			);
			
			$this->add_control(
				'offset',
				[
					'label'     => esc_html__( 'Offset', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 0,
					'condition' => [
						'posts_post_type!' => 'by_id',
					],
				]
			);
		}
		
		function register_navigation_controls( $name ) {
			$this->start_controls_section(
				'section_content_navigation',
				[
					'label' => __( 'Navigation', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'navigation',
				[
					'label'        => __( 'Navigation', 'kws-elementor-kit' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'arrows',
					'options'      => [
						'both'            => esc_html__( 'Arrows and Dots', 'kws-elementor-kit' ),
						'arrows-fraction' => esc_html__( 'Arrows and Fraction', 'kws-elementor-kit' ),
						'arrows'          => esc_html__( 'Arrows', 'kws-elementor-kit' ),
						'dots'            => esc_html__( 'Dots', 'kws-elementor-kit' ),
						'progressbar'     => esc_html__( 'Progress', 'kws-elementor-kit' ),
						'none'            => esc_html__( 'None', 'kws-elementor-kit' ),
					],
					'prefix_class' => 'kek-navigation-type-',
					'render_type'  => 'template',
				]
			);
			
			$this->add_control(
				'both_position',
				[
					'label'     => __( 'Arrows and Dots Position', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'center',
					'options'   => kws_elementor_kit_navigation_position(),
					'condition' => [
						'navigation' => 'both',
					],
				]
			);
			
			$this->add_control(
				'arrows_fraction_position',
				[
					'label'     => __( 'Arrows and Fraction Position', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'center',
					'options'   => kws_elementor_kit_navigation_position(),
					'condition' => [
						'navigation' => 'arrows-fraction',
					],
				]
			);
			
			$this->add_control(
				'arrows_position',
				[
					'label'     => __( 'Arrows Position', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'center',
					'options'   => kws_elementor_kit_navigation_position(),
					'condition' => [
						'navigation' => 'arrows',
					],
				]
			);
			
			$this->add_control(
				'dots_position',
				[
					'label'     => __( 'Dots Position', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottom-center',
					'options'   => kws_elementor_kit_pagination_position(),
					'condition' => [
						'navigation' => 'dots',
					],
				
				]
			);
			
			$this->add_control(
				'progress_position',
				[
					'label'     => __( 'Progress Position', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => 'bottom',
					'options'   => [
						'bottom' => esc_html__( 'Bottom', 'kws-elementor-kit' ),
						'top'    => esc_html__( 'Top', 'kws-elementor-kit' ),
					],
					'condition' => [
						'navigation' => 'progressbar',
					],
				]
			);
			
			$this->add_control(
				'dynamic_bullets',
				[
					'label'     => __( 'Dynamic Bullets?', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SWITCHER,
					'condition' => [
						'navigation' => [ 'dots', 'both' ],
					],
				]
			);
			
			$this->add_control(
				'show_scrollbar',
				[
					'label' => __( 'Show Scrollbar?', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_control(
				'nav_arrows_icon',
				[
					'label'     => esc_html__( 'Arrows Icon', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SELECT,
					'default'   => '5',
					'options'   => [
						'1'        => esc_html__( 'Style 1', 'kws-elementor-kit' ),
						'2'        => esc_html__( 'Style 2', 'kws-elementor-kit' ),
						'3'        => esc_html__( 'Style 3', 'kws-elementor-kit' ),
						'4'        => esc_html__( 'Style 4', 'kws-elementor-kit' ),
						'5'        => esc_html__( 'Style 5', 'kws-elementor-kit' ),
						'6'        => esc_html__( 'Style 6', 'kws-elementor-kit' ),
						'7'        => esc_html__( 'Style 7', 'kws-elementor-kit' ),
						'8'        => esc_html__( 'Style 8', 'kws-elementor-kit' ),
						'9'        => esc_html__( 'Style 9', 'kws-elementor-kit' ),
						'10'       => esc_html__( 'Style 10', 'kws-elementor-kit' ),
						'11'       => esc_html__( 'Style 11', 'kws-elementor-kit' ),
						'12'       => esc_html__( 'Style 12', 'kws-elementor-kit' ),
						'13'       => esc_html__( 'Style 13', 'kws-elementor-kit' ),
						'14'       => esc_html__( 'Style 14', 'kws-elementor-kit' ),
						'15'       => esc_html__( 'Style 15', 'kws-elementor-kit' ),
						'16'       => esc_html__( 'Style 16', 'kws-elementor-kit' ),
						'17'       => esc_html__( 'Style 17', 'kws-elementor-kit' ),
						'18'       => esc_html__( 'Style 18', 'kws-elementor-kit' ),
						'circle-1' => esc_html__( 'Style 19', 'kws-elementor-kit' ),
						'circle-2' => esc_html__( 'Style 20', 'kws-elementor-kit' ),
						'circle-3' => esc_html__( 'Style 21', 'kws-elementor-kit' ),
						'circle-4' => esc_html__( 'Style 22', 'kws-elementor-kit' ),
						'square-1' => esc_html__( 'Style 23', 'kws-elementor-kit' ),
					],
					'condition' => [
						'navigation' => [ 'arrows-fraction', 'both', 'arrows' ],
					],
				]
			);
			
			$this->add_control(
				'hide_arrow_on_mobile',
				[
					'label'     => __( 'Hide Arrows on Mobile', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'condition' => [
						'navigation' => [ 'arrows-fraction', 'arrows', 'both' ],
					],
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_carousel_settings',
				[
					'label' => __( 'Carousel Settings', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'direction',
				[
					'label'       => esc_html__( 'Direction', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SELECT,
					'default'     => 'horizontal',
					'options'     => [
						'horizontal' => esc_html__( 'Horizontal', 'kws-elementor-kit' ),
						'vertical'   => esc_html__( 'Vertical', 'kws-elementor-kit' ),
					],
					'render_type' => 'template',
				]
			);
			
			$this->add_responsive_control(
				'vertical_height',
				[
					'label'       => __( 'Container Height', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'  => 200,
							'max'  => 1200,
							'step' => 10
						],
					],
					'default'     => [
						'size' => 900,
					],
					'selectors'   => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-wrapper' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition'   => [
						'direction' => 'vertical',
					],
					'render_type' => 'template',
				]
			);
			
			$this->add_control(
				'skin',
				[
					'label'        => esc_html__( 'Layout', 'kws-elementor-kit' ),
					'type'         => Controls_Manager::SELECT,
					'default'      => 'carousel',
					'options'      => [
						'carousel'  => esc_html__( 'Carousel', 'kws-elementor-kit' ),
						'coverflow' => esc_html__( 'Coverflow', 'kws-elementor-kit' ),
					],
					'prefix_class' => 'kek-carousel-style-',
					'render_type'  => 'template',
					'separator'    => 'before'
				]
			);
			
			$this->add_control(
				'coverflow_toggle',
				[
					'label'        => __( 'Coverflow Effect', 'kws-elementor-kit' ),
					'type'         => Controls_Manager::POPOVER_TOGGLE,
					'return_value' => 'yes',
					'condition'    => [
						'skin' => 'coverflow'
					]
				]
			);
			
			$this->start_popover();
			
			$this->add_control(
				'coverflow_rotate',
				[
					'label'       => esc_html__( 'Rotate', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => [
						'size' => 50,
					],
					'range'       => [
						'px' => [
							'min'  => - 360,
							'max'  => 360,
							'step' => 5,
						],
					],
					'condition'   => [
						'coverflow_toggle' => 'yes'
					],
					'render_type' => 'template',
				]
			);
			
			$this->add_control(
				'coverflow_stretch',
				[
					'label'       => __( 'Stretch', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => [
						'size' => 0,
					],
					'range'       => [
						'px' => [
							'min'  => 0,
							'step' => 10,
							'max'  => 100,
						],
					],
					'condition'   => [
						'coverflow_toggle' => 'yes'
					],
					'render_type' => 'template',
				]
			);
			
			$this->add_control(
				'coverflow_modifier',
				[
					'label'       => __( 'Modifier', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => [
						'size' => 1,
					],
					'range'       => [
						'px' => [
							'min'  => 1,
							'step' => 1,
							'max'  => 10,
						],
					],
					'condition'   => [
						'coverflow_toggle' => 'yes'
					],
					'render_type' => 'template',
				]
			);
			
			$this->add_control(
				'coverflow_depth',
				[
					'label'       => __( 'Depth', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SLIDER,
					'default'     => [
						'size' => 100,
					],
					'range'       => [
						'px' => [
							'min'  => 0,
							'step' => 10,
							'max'  => 1000,
						],
					],
					'condition'   => [
						'coverflow_toggle' => 'yes'
					],
					'render_type' => 'template',
				]
			);
			
			$this->end_popover();
			
			$this->add_control(
				'hr_005',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'skin' => 'coverflow'
					]
				]
			);
			
			$this->add_control(
				'autoplay',
				[
					'label'   => __( 'Autoplay', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				
				]
			);
			
			$this->add_control(
				'autoplay_speed',
				[
					'label'     => esc_html__( 'Autoplay Speed', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::NUMBER,
					'default'   => 5000,
					'condition' => [
						'autoplay' => 'yes',
					],
				]
			);
			
			$this->add_control(
				'pauseonhover',
				[
					'label' => esc_html__( 'Pause on Hover', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_responsive_control(
				'slides_to_scroll',
				[
					'type'           => Controls_Manager::SELECT,
					'label'          => esc_html__( 'Slides to Scroll', 'kws-elementor-kit' ),
					'default'        => 1,
					'tablet_default' => 1,
					'mobile_default' => 1,
					'options'        => [
						1 => '1',
						2 => '2',
						3 => '3',
						4 => '4',
						5 => '5',
						6 => '6',
					],
				]
			);
			
			$this->add_control(
				'centered_slides',
				[
					'label'       => __( 'Center Slide', 'kws-elementor-kit' ),
					'description' => __( 'Use even items from Layout > Columns settings for better preview.', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_control(
				'grab_cursor',
				[
					'label' => __( 'Grab Cursor', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_control(
				'loop',
				[
					'label'   => __( 'Loop', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				
				]
			);
			
			
			$this->add_control(
				'speed',
				[
					'label'   => __( 'Animation Speed (ms)', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 500,
					],
					'range'   => [
						'px' => [
							'min'  => 100,
							'max'  => 5000,
							'step' => 50,
						],
					],
				]
			);
			
			$this->add_control(
				'observer',
				[
					'label'       => __( 'Observer', 'kws-elementor-kit' ),
					'description' => __( 'When you use carousel in any hidden place (in tabs, accordion etc) keep it yes.', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SWITCHER,
				]
			);
			
			$this->end_controls_section();
		}
		
		function register_navigation_style( $name ) {
			$this->start_controls_section(
				'section_style_navigation',
				[
					'label'      => __( 'Navigation', 'kws-elementor-kit' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'navigation',
								'operator' => '!=',
								'value'    => 'none',
							],
							[
								'name'  => 'show_scrollbar',
								'value' => 'yes',
							],
						],
					],
				]
			);
			
			$this->add_control(
				'arrows_heading',
				[
					'label'     => __( 'A R R O W S', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->start_controls_tabs( 'tabs_navigation_arrows_style' );
			
			$this->start_controls_tab(
				'tabs_nav_arrows_normal',
				[
					'label'     => __( 'Normal', 'kws-elementor-kit' ),
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_control(
				'arrows_color',
				[
					'label'     => __( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev i, {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next i' => 'color: {{VALUE}}',
					],
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_control(
				'arrows_background',
				[
					'label'     => __( 'Background', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev, {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'nav_arrows_border',
					'selector'  => '{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev, {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next',
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_responsive_control(
				'border_radius',
				[
					'label'      => __( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev, {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_padding',
				[
					'label'      => esc_html__( 'Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev, {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_size',
				[
					'label'     => __( 'Size', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 10,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev i,
                {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next i' => 'font-size: {{SIZE || 24}}{{UNIT}};',
					],
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_space',
				[
					'label'     => __( 'Space Between Arrows', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev' => 'margin-right: {{SIZE}}px;',
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next' => 'margin-left: {{SIZE}}px;',
					],
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'tabs_nav_arrows_hover',
				[
					'label'     => __( 'Hover', 'kws-elementor-kit' ),
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_control(
				'arrows_hover_color',
				[
					'label'     => __( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev:hover i, {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next:hover i' => 'color: {{VALUE}}',
					],
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_control(
				'arrows_hover_background',
				[
					'label'     => __( 'Background', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev:hover, {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next:hover' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'navigation!' => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_control(
				'nav_arrows_hover_border_color',
				[
					'label'     => __( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev:hover, {{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next:hover' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'nav_arrows_border_border!' => '',
						'navigation!'               => [ 'dots', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->end_controls_tab();
			
			$this->end_controls_tabs();
			
			$this->add_control(
				'hr_1',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'navigation!' => [ 'arrows', 'arrows-fraction', 'progressbar', 'none' ],
					],
				]
			);
			
			$this->add_control(
				'dots_heading',
				[
					'label'     => __( 'D O T S', 'kwstech-element-pack' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->start_controls_tabs( 'tabs_navigation_dots_style' );
			
			$this->start_controls_tab(
				'tabs_nav_dots_normal',
				[
					'label'     => __( 'Normal', 'kwstech-element-pack' ),
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);
			
			$this->add_control(
				'dots_color',
				[
					'label'     => __( 'Color', 'kwstech-element-pack' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->add_responsive_control(
				'dots_space_between',
				[
					'label'     => __( 'Space Between', 'kwstech-element-pack' ) . CFTKEK_NC,
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}}' => '--kek-swiper-dots-space-between: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);
			
			$this->add_responsive_control(
				'dots_width_size',
				[
					'label'     => __( 'Width(px)', 'kwstech-element-pack' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);
			
			$this->add_responsive_control(
				'dots_height_size',
				[
					'label'     => __( 'Height(px)', 'kwstech-element-pack' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->add_responsive_control(
				'dots_border_radius',
				[
					'label'      => esc_html__('Border Radius', 'kwstech-element-pack'),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'dots_box_shadow',
					'selector' => '{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet',
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'tabs_nav_dots_active',
				[
					'label'     => __( 'Active', 'kwstech-element-pack' ) . CFTKEK_NC,
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->add_control(
				'active_dot_color',
				[
					'label'     => __( 'Color', 'kwstech-element-pack' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->add_responsive_control(
				'active_advanced_dots_width',
				[
					'label'     => __( 'Width(px)', 'kwstech-element-pack' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);
			
			$this->add_responsive_control(
				'active_dots_height',
				[
					'label'     => __( 'Height(px)', 'kwstech-element-pack' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
						'{{WRAPPER}}' => '--kek-swiper-dots-active-height: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->add_responsive_control(
				'active_dots_radius',
				[
					'label'      => esc_html__('Border Radius', 'kwstech-element-pack'),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet-active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->add_responsive_control(
				'active_dots_align',
				[
					'label'   => __( 'Alignment', 'kwstech-element-pack' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'flex-start' => [
							'title' => __( 'Top', 'kwstech-element-pack' ),
							'icon'  => 'eicon-v-align-top',
						],
						'center' => [
							'title' => __( 'Center', 'kwstech-element-pack' ),
							'icon'  => 'eicon-v-align-middle',
						],
						'flex-end' => [
							'title' => __( 'Bottom', 'kwstech-element-pack' ),
							'icon'  => 'eicon-v-align-bottom',
						],
					],
					'selectors' => [
						'{{WRAPPER}}' => '--kek-swiper-dots-align: {{VALUE}};',
					],
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'dots_active_box_shadow',
					'selector' => '{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-bullet-active',
					'condition' => [
						'navigation!' => ['arrows', 'arrows-fraction', 'progressbar', 'none'],
					],
				]
			);

			$this->end_controls_tab();

			$this->end_controls_tabs();
			
			$this->add_control(
				'hr_22',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'navigation' => 'arrows-fraction',
					],
				]
			);
			
			$this->add_control(
				'fraction_heading',
				[
					'label'     => __( 'F R A C T I O N', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'navigation' => 'arrows-fraction',
					],
				]
			);
			
			$this->add_control(
				'hr_12',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'navigation' => 'arrows-fraction',
					],
				]
			);
			
			$this->add_control(
				'fraction_color',
				[
					'label'     => __( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-fraction' => 'color: {{VALUE}}',
					],
					'condition' => [
						'navigation' => 'arrows-fraction',
					],
				]
			);
			
			$this->add_control(
				'active_fraction_color',
				[
					'label'     => __( 'Active Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-current' => 'color: {{VALUE}}',
					],
					'condition' => [
						'navigation' => 'arrows-fraction',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'fraction_typography',
					'label'     => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector'  => '{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-fraction',
					'condition' => [
						'navigation' => 'arrows-fraction',
					],
				]
			);
			
			$this->add_control(
				'hr_3',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'navigation' => 'progressbar',
					],
				]
			);
			
			$this->add_control(
				'progresbar_heading',
				[
					'label'     => __( 'P R O G R E S S B A R', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'navigation' => 'progressbar',
					],
				]
			);
			
			$this->add_control(
				'hr_13',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'navigation' => 'progressbar',
					],
				]
			);
			
			$this->add_control(
				'progresbar_color',
				[
					'label'     => __( 'Bar Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-progressbar' => 'background-color: {{VALUE}}',
					],
					'condition' => [
						'navigation' => 'progressbar',
					],
				]
			);
			
			$this->add_control(
				'progres_color',
				[
					'label'     => __( 'Progress Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'separator' => 'after',
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background: {{VALUE}}',
					],
					'condition' => [
						'navigation' => 'progressbar',
					],
				]
			);
			
			$this->add_control(
				'hr_4',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'show_scrollbar' => 'yes'
					],
				]
			);
			
			$this->add_control(
				'scrollbar_heading',
				[
					'label'     => __( 'S C R O L L B A R', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'condition' => [
						'show_scrollbar' => 'yes'
					],
				]
			);
			
			$this->add_control(
				'hr_14',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'show_scrollbar' => 'yes'
					],
				]
			);
			
			$this->add_control(
				'scrollbar_color',
				[
					'label'     => __( 'Bar Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-scrollbar' => 'background: {{VALUE}}',
					],
					'condition' => [
						'show_scrollbar' => 'yes'
					],
				]
			);
			
			$this->add_control(
				'scrollbar_drag_color',
				[
					'label'     => __( 'Drag Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-scrollbar .swiper-scrollbar-drag' => 'background: {{VALUE}}',
					],
					'condition' => [
						'show_scrollbar' => 'yes'
					],
				]
			);
			
			$this->add_responsive_control(
				'scrollbar_height',
				[
					'label'     => __( 'Height', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 1,
							'max' => 10,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-container-horizontal > .swiper-scrollbar' => 'height: {{SIZE}}px;',
					],
					'condition' => [
						'show_scrollbar' => 'yes'
					],
				]
			);
			
			$this->add_control(
				'hr_05',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);
			
			$this->add_control(
				'navi_offset_heading',
				[
					'label' => __( 'O F F S E T', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::HEADING,
				]
			);
			
			$this->add_control(
				'hr_6',
				[
					'type' => Controls_Manager::DIVIDER,
				]
			);
			
			$this->add_responsive_control(
				'arrows_ncx_position',
				[
					'label'          => __( 'Arrows Horizontal Offset', 'kws-elementor-kit' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 0,
					],
					'tablet_default' => [
						'size' => 0,
					],
					'mobile_default' => [
						'size' => 0,
					],
					'range'          => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'conditions'     => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'arrows',
							],
							[
								'name'     => 'arrows_position',
								'operator' => '!=',
								'value'    => 'center',
							],
						],
					],
					'selectors'      => [
						'{{WRAPPER}}' => '--kek-' . $name . '-carousel-arrows-ncx: {{SIZE}}px;'
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_ncy_position',
				[
					'label'          => __( 'Arrows Vertical Offset', 'kws-elementor-kit' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 40,
					],
					'tablet_default' => [
						'size' => 40,
					],
					'mobile_default' => [
						'size' => 40,
					],
					'range'          => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'selectors'      => [
						'{{WRAPPER}}' => '--kek-' . $name . '-carousel-arrows-ncy: {{SIZE}}px;'
					],
					'conditions'     => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'arrows',
							],
							[
								'name'     => 'arrows_position',
								'operator' => '!=',
								'value'    => 'center',
							],
						],
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_acx_position',
				[
					'label'      => __( 'Arrows Horizontal Offset', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => - 60,
					],
					'range'      => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev' => 'left: {{SIZE}}px;',
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next' => 'right: {{SIZE}}px;',
					],
					'conditions' => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'arrows',
							],
							[
								'name'  => 'arrows_position',
								'value' => 'center',
							],
						],
					],
				]
			);
			
			$this->add_responsive_control(
				'dots_nnx_position',
				[
					'label'          => __( 'Dots Horizontal Offset', 'kws-elementor-kit' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 0,
					],
					'tablet_default' => [
						'size' => 0,
					],
					'mobile_default' => [
						'size' => 0,
					],
					'range'          => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'conditions'     => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'dots',
							],
							[
								'name'     => 'dots_position',
								'operator' => '!=',
								'value'    => '',
							],
						],
					],
					'selectors'      => [
						'{{WRAPPER}}' => '--kek-' . $name . '-carousel-dots-nnx: {{SIZE}}px;'
					],
				]
			);
			
			$this->add_responsive_control(
				'dots_nny_position',
				[
					'label'          => __( 'Dots Vertical Offset', 'kws-elementor-kit' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 30,
					],
					'tablet_default' => [
						'size' => 30,
					],
					'mobile_default' => [
						'size' => 30,
					],
					'range'          => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'conditions'     => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'dots',
							],
							[
								'name'     => 'dots_position',
								'operator' => '!=',
								'value'    => '',
							],
						],
					],
					'selectors'      => [
						'{{WRAPPER}}' => '--kek-' . $name . '-carousel-dots-nny: {{SIZE}}px;'
					],
				]
			);
			
			$this->add_responsive_control(
				'both_ncx_position',
				[
					'label'          => __( 'Arrows & Dots Horizontal Offset', 'kws-elementor-kit' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 0,
					],
					'tablet_default' => [
						'size' => 0,
					],
					'mobile_default' => [
						'size' => 0,
					],
					'range'          => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'conditions'     => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'both',
							],
							[
								'name'     => 'both_position',
								'operator' => '!=',
								'value'    => 'center',
							],
						],
					],
					'selectors'      => [
						'{{WRAPPER}}' => '--kek-' . $name . '-carousel-both-ncx: {{SIZE}}px;'
					],
				]
			);
			
			$this->add_responsive_control(
				'both_ncy_position',
				[
					'label'          => __( 'Arrows & Dots Vertical Offset', 'kws-elementor-kit' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 40,
					],
					'tablet_default' => [
						'size' => 40,
					],
					'mobile_default' => [
						'size' => 40,
					],
					'range'          => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'conditions'     => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'both',
							],
							[
								'name'     => 'both_position',
								'operator' => '!=',
								'value'    => 'center',
							],
						],
					],
					'selectors'      => [
						'{{WRAPPER}}' => '--kek-' . $name . '-carousel-both-ncy: {{SIZE}}px;'
					],
				]
			);
			
			$this->add_responsive_control(
				'both_cx_position',
				[
					'label'      => __( 'Arrows Offset', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => - 60,
					],
					'range'      => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev' => 'left: {{SIZE}}px;',
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next' => 'right: {{SIZE}}px;',
					],
					'conditions' => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'both',
							],
							[
								'name'  => 'both_position',
								'value' => 'center',
							],
						],
					],
				]
			);
			
			$this->add_responsive_control(
				'both_cy_position',
				[
					'label'      => __( 'Dots Offset', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => 30,
					],
					'range'      => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-dots-container' => 'transform: translateY({{SIZE}}px);',
					],
					'conditions' => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'both',
							],
							[
								'name'  => 'both_position',
								'value' => 'center',
							],
						],
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_fraction_ncx_position',
				[
					'label'          => __( 'Arrows & Fraction Horizontal Offset', 'kws-elementor-kit' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 0,
					],
					'tablet_default' => [
						'size' => 0,
					],
					'mobile_default' => [
						'size' => 0,
					],
					'range'          => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'conditions'     => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'arrows-fraction',
							],
							[
								'name'     => 'arrows_fraction_position',
								'operator' => '!=',
								'value'    => 'center',
							],
						],
					],
					'selectors'      => [
						'{{WRAPPER}}' => '--kek-' . $name . '-carousel-arrows-fraction-ncx: {{SIZE}}px;'
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_fraction_ncy_position',
				[
					'label'          => __( 'Arrows & Fraction Vertical Offset', 'kws-elementor-kit' ),
					'type'           => Controls_Manager::SLIDER,
					'default'        => [
						'size' => 40,
					],
					'tablet_default' => [
						'size' => 40,
					],
					'mobile_default' => [
						'size' => 40,
					],
					'range'          => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'conditions'     => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'arrows-fraction',
							],
							[
								'name'     => 'arrows_fraction_position',
								'operator' => '!=',
								'value'    => 'center',
							],
						],
					],
					'selectors'      => [
						'{{WRAPPER}}' => '--kek-' . $name . '-carousel-arrows-fraction-ncy: {{SIZE}}px;'
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_fraction_cx_position',
				[
					'label'      => __( 'Arrows Offset', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => - 60,
					],
					'range'      => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-prev' => 'left: {{SIZE}}px;',
						'{{WRAPPER}} .kek-' . $name . '-carousel .kek-navigation-next' => 'right: {{SIZE}}px;',
					],
					'conditions' => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'arrows-fraction',
							],
							[
								'name'  => 'arrows_fraction_position',
								'value' => 'center',
							],
						],
					],
				]
			);
			
			$this->add_responsive_control(
				'arrows_fraction_cy_position',
				[
					'label'      => __( 'Fraction Offset', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::SLIDER,
					'default'    => [
						'size' => 30,
					],
					'range'      => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'selectors'  => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-fraction' => 'transform: translateY({{SIZE}}px);',
					],
					'conditions' => [
						'terms' => [
							[
								'name'  => 'navigation',
								'value' => 'arrows-fraction',
							],
							[
								'name'  => 'arrows_fraction_position',
								'value' => 'center',
							],
						],
					],
				]
			);
			
			$this->add_responsive_control(
				'progress_y_position',
				[
					'label'     => __( 'Progress Offset', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'default'   => [
						'size' => 15,
					],
					'range'     => [
						'px' => [
							'min' => - 200,
							'max' => 200,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-pagination-progressbar' => 'transform: translateY({{SIZE}}px);',
					],
					'condition' => [
						'navigation' => 'progressbar',
					],
				]
			);
			
			$this->add_responsive_control(
				'scrollbar_vertical_offset',
				[
					'label'     => __( 'Scrollbar Offset', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .kek-' . $name . '-carousel .swiper-container-horizontal > .swiper-scrollbar' => 'bottom: {{SIZE}}px;',
					],
					'condition' => [
						'show_scrollbar' => 'yes'
					],
				]
			);
			
			$this->end_controls_section();
		}
		
	}