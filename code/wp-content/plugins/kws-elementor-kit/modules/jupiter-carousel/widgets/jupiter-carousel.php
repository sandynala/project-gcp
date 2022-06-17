<?php
	
	namespace KwsElementorKit\Modules\JupiterCarousel\Widgets;
	
	use Elementor\Controls_Manager;
	use Elementor\Group_Control_Border;
	use Elementor\Group_Control_Box_Shadow;
	use Elementor\Group_Control_Typography;
	use Elementor\Group_Control_Text_Shadow;
	use Elementor\Group_Control_Image_Size;
	use Elementor\Group_Control_Background;
	use KwsElementorKit\Utils;
	
	use KwsElementorKit\Traits\Global_Widget_Controls;
	use KwsElementorKit\Traits\Global_Swiper_Functions;
	use KwsElementorKit\Includes\Controls\GroupQuery\Group_Control_Query;
	use KwsElementorKit\Modules\QueryControl\Controls\Group_Control_Posts;
	use WP_Query;
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly
	
	class Jupiter_Carousel extends Group_Control_Query {

		use Global_Widget_Controls;
		use Global_Swiper_Functions;

		private $_query = null;
		
		public function get_name() {
			return 'kek-jupiter-carousel';
		}
		
		public function get_title() {
			return CFTKEK . esc_html__( 'Jupiter Carousel', 'kws-elementor-kit' );
		}
		
		public function get_icon() {
			return 'kek-widget-icon kek-icon-jupiter-carousel';
		}
		
		public function get_categories() {
			return [ 'kws-elementor-kit' ];
		}
		
		public function get_keywords() {
			return [ 'post', 'carousel', 'blog', 'recent', 'news', 'jupiter' ];
		}
		
		public function get_style_depends() {
			if ( $this->kek_is_edit_mode() ) {
				return [ 'kek-all-styles' ];
			} else {
				return [ 'kws-elementor-kit-font', 'kek-jupiter-carousel' ];
			}
		}

		public function get_script_depends() {
			if ( $this->kek_is_edit_mode() ) {
				return [ 'kek-all-scripts' ];
			} else {
				return [ 'kek-jupiter-carousel' ];
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
			$this->start_controls_section(
				'section_content_layout',
				[
					'label' => esc_html__( 'Layout', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_responsive_control(
				'columns',
				[
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
				]
			);
			
			$this->add_responsive_control(
				'item_gap',
				[
					'label'   => __( 'Item Gap', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SLIDER,
					'default' => [
						'size' => 20,
					],
					'tablet_default' => [
						'size' => 20,
					],
					'mobile_default' => [
						'size' => 20,
					],
					'range'   => [
						'px' => [
							'min' => 0,
							'max' => 100,
						],
					],
				]
			);
			
			$this->add_responsive_control(
				'default_item_height',
				[
					'label'     => esc_html__( 'Item Height(px)', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 200,
							'max' => 800,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid .kek-post-grid-item' => 'height: {{SIZE}}px;',
					],
				]
			);
			
			$this->add_control(
				'content_style',
				[
					'label'   => esc_html__( 'Content Style', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => '1',
					'options' => [
						'1' => esc_html__( 'Style 01', 'kws-elementor-kit' ),
						'2' => esc_html__( 'Style 02', 'kws-elementor-kit' ),
						'3' => esc_html__( 'Style 03', 'kws-elementor-kit' ),
					],
				]
			);
			
			$this->add_control(
				'content_position',
				[
					'label'   => esc_html__( 'Content Position', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'bottom-left',
					'options' => [
						'top-left'      => esc_html__( 'Top Left', 'kws-elementor-kit' ),
						'top-right'     => esc_html__( 'Top Right', 'kws-elementor-kit' ),
						'center-center' => esc_html__( 'Center', 'kws-elementor-kit' ),
						'bottom-left'   => esc_html__( 'Bottom Left', 'kws-elementor-kit' ),
						'bottom-right'  => esc_html__( 'Bottom Right', 'kws-elementor-kit' ),
						'bottom-center' => esc_html__( 'Bottom Center', 'kws-elementor-kit' ),
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'    => 'primary_thumbnail',
					'exclude' => [ 'custom' ],
					'default' => 'medium',
				]
			);
			
			$this->end_controls_section();
			
			// Query Settings
			$this->start_controls_section(
				'section_post_query_builder',
				[
					'label' => __( 'Query', 'kws-elementor-kit' ) . CFTKEK_NC,
					'tab'   => Controls_Manager::TAB_CONTENT,
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
							'max' => 20,
						],
					],
					'default' => [
						'size' => 6,
					],
				]
			);
			
			$this->register_query_builder_controls();
			
			$this->end_controls_section();
	
			$this->start_controls_section(
				'section_content_additional',
				[
					'label' => esc_html__( 'Additional', 'kws-elementor-kit' ),
				]
			);
			
			//Global Title Controls
			$this->register_title_controls();

			$this->add_control(
				'show_category',
				[
					'label'   => esc_html__( 'Category', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);
			
			$this->add_control(
				'show_author',
				[
					'label'   => esc_html__( 'Author', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);
			
			//Global Date Controls
			$this->register_date_controls();
			
			$this->add_control(
				'global_link',
				[
					'label'        => __( 'Item Wrapper Link', 'kws-elementor-kit' ),
					'type'         => Controls_Manager::SWITCHER,
					'prefix_class' => 'kek-global-link-',
					'description'  => __( 'Be aware! When Item Wrapper Link activated then title link and read more link will not work', 'kws-elementor-kit' ),
					'separator' => 'before'
				]
			);
			
			$this->end_controls_section();
			
			//Navigaiton Global Controls
			$this->register_navigation_controls( 'jupiter');
			
			//Style
			$this->start_controls_section(
				'kek_section_style',
				[
					'label' => esc_html__( 'Items', 'kws-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);
			
			$this->add_responsive_control(
				'content_padding',
				[
					'label'      => __( 'Content Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
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
				'overlay_blur_effect',
				[
					'label'       => esc_html__( 'Glassmorphism', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SWITCHER,
					'description' => sprintf( __( 'This feature will not work in the Firefox browser untill you enable browser compatibility so please %1s look here %2s', 'kws-elementor-kit' ), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/backdrop-filter#Browser_compatibility" target="_blank">', '</a>' ),
					'default'     => 'yes',
					'condition'   => [
						'content_style' => '2',
					]
				]
			);
			
			$this->add_control(
				'overlay_blur_level',
				[
					'label'     => __( 'Blur Level', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min'  => 0,
							'step' => 1,
							'max'  => 50,
						]
					],
					'default'   => [
						'size' => 10
					],
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-blog-content-style-2 .kek-blog-box-content' => 'backdrop-filter: blur({{SIZE}}px); -webkit-backdrop-filter: blur({{SIZE}}px);'
					],
					'condition' => [
						'overlay_blur_effect' => 'yes',
						'content_style'       => '2',
					]
				]
			);
			
			$this->add_control(
				'overlay_background',
				[
					'label'     => esc_html__( 'Overlay Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-blog-content-style-1 .kek-post-grid-item-box:before, {{WRAPPER}} .kek-jupiter-carousel .kek-blog-content-style-2 .kek-blog-box-content, {{WRAPPER}} .kek-jupiter-carousel .kek-blog-content-style-3 .kek-post-grid-item .kek-post-grid-item-box:before' => 'background-color: {{VALUE}};'
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'item_border',
					'label'       => __( 'Border', 'kws-elementor-kit' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item',
				]
			);
			
			$this->add_responsive_control(
				'item_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'item_box_shadow',
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item',
				]
			);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'tab_item_hover',
				[
					'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'item_border_color_hover',
				[
					'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item:hover' => 'border-color: {{VALUE}};'
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
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item:hover',
				]
			);
			
			$this->add_responsive_control(
				'item_shadow_padding',
				[
					'label'       => __( 'Match Padding', 'kws-elementor-kit' ),
					'description' => __( 'You have to add padding for matching overlaping normal/hover box shadow when you used Box Shadow option.', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::SLIDER,
					'range'       => [
						'px' => [
							'min'  => 0,
							'step' => 1,
							'max'  => 50,
						]
					],
					'default'     => [
						'size' => 10
					],
					'selectors'   => [
						'{{WRAPPER}} .swiper-container' => 'padding: {{SIZE}}{{UNIT}}; margin: 0 -{{SIZE}}{{UNIT}};'
					],
				]
			);
			
			$this->end_controls_tab();
			
			$this->end_controls_tabs();
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_title',
				[
					'label'     => esc_html__( 'Title', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_title' => 'yes',
					],
				]
			);
			
			$this->add_control(
				'title_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'title_hover_color',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title:hover' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title-wrap',
				]
			);
			
			$this->add_control(
				'title_advanced_style',
				[
					'label' => esc_html__( 'Advanced Style', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'title_background',
					'label'     => __( 'Background', 'kws-elementor-kit' ),
					'selector'  => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
					'condition' => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'      => 'title_text_shadow',
					'label'     => __( 'Text Shadow', 'kws-elementor-kit' ),
					'selector'  => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
					'condition' => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'title_border',
					'selector'  => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
					'condition' => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->add_responsive_control(
				'title_border_radius',
				[
					'label'      => __( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'      => 'title_box_shadow',
					'selector'  => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
					'condition' => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->add_responsive_control(
				'title_text_padding',
				[
					'label'      => __( 'Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->add_responsive_control(
				'title_text_margin',
				[
					'label'      => __( 'Margin', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_author_date',
				[
					'label'      => esc_html__( 'Meta', 'kws-elementor-kit' ),
					'tab'        => Controls_Manager::TAB_STYLE,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'  => 'show_author',
								'value' => 'yes'
							],
							[
								'name'  => 'show_date',
								'value' => 'yes'
							]
						]
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'author_date_background',
					'selector'  => '{{WRAPPER}} .kek-jupiter-carousel .kek-blog-content-style-3 .kek-blog-box-content .kek-blog-post-meta',
					'condition' => [
						'content_style' => '3',
					],
				]
			);
			
			$this->add_control(
				'author_divider',
				[
					'type'      => Controls_Manager::DIVIDER,
					'condition' => [
						'content_style' => '3',
					],
				]
			);
			
			$this->add_control(
				'author_color',
				[
					'label'     => esc_html__( 'Text Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-post-meta *' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'author_hover_color',
				[
					'label'     => esc_html__( 'Hover Text Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-post-meta .kek-blog-author a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'date_divider_color',
				[
					'label'     => esc_html__( 'Divider Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-post-meta .kek-blog-date::before' => 'background: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'author_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-post-meta',
				]
			);
		
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_category',
				[
					'label'     => esc_html__( 'Category', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_category' => 'yes',
					],
				]
			);
			
			$this->start_controls_tabs( 'tabs_category_style' );
			
			$this->start_controls_tab(
				'tab_category_normal',
				[
					'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'category_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'category_background',
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a',
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'category_border',
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a',
				]
			);
			
			$this->add_responsive_control(
				'category_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'category_padding',
				[
					'label'      => esc_html__( 'Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'category_spacing',
				[
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
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a+a' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'category_shadow',
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a',
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'category_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a',
				]
			);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'tab_category_hover',
				[
					'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
				]
			);
			
			$this->add_control(
				'category_hover_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'category_hover_background',
					'selector' => '{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a:hover',
				]
			);
			
			$this->add_control(
				'category_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'category_border_border!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .kek-jupiter-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-badge a:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			
			$this->end_controls_tab();
			
			$this->end_controls_tabs();
			
			$this->end_controls_section();
			
			//Navigation Global Controls
			$this->register_navigation_style( 'jupiter');
		}
		
		/**
		 * Main query render for this widget
		 * @param $posts_per_page number item query limit
		 */
		public function query_posts( $posts_per_page ) {
			
			$default = $this->getGroupControlQueryArgs();
			if ( $posts_per_page ) {
				$args['posts_per_page'] = $posts_per_page;
				$args['paged']  = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
			}
			$args         = array_merge( $default, $args );
			$this->_query = new WP_Query( $args );
		}
		
		public function render_image( $image_id, $size ) {
			$placeholder_image_src = Utils::get_placeholder_image_src();
			
			$image_src = wp_get_attachment_image_src( $image_id, $size );
			
			if ( ! $image_src ) {
				$image_src = $placeholder_image_src;
			} else {
				$image_src = $image_src[0];
			}
			
			?>
            <img class="kek-blog-image" src="<?php echo esc_url( $image_src ); ?>"
                 alt="<?php echo esc_html( get_the_title() ); ?>">
			<?php
		}
		
		public function render_title() {
			$settings = $this->get_settings_for_display();
			
			if ( ! $this->get_settings( 'show_title' ) ) {
				return;
			}
			
			$this->add_render_attribute( 'blog-title', 'class', 'kek-blog-title-wrap', true );
			$titleClass = $this->get_render_attribute_string( 'blog-title' );
			?>

			<<?php echo Utils::get_valid_html_tag($settings['title_tags']) .' '. $titleClass ?>>
				<a href="<?php echo esc_url(get_permalink()) ?>" class="kek-blog-title" title="<?php echo esc_html(get_the_title()) ?>">
					<?php echo esc_html(get_the_title())  ?>
				</a>
			</<?php echo Utils::get_valid_html_tag($settings['title_tags']) ?>>

			<?php
		}
		
		public function render_author() {
			
			if ( ! $this->get_settings( 'show_author' ) ) {
				return;
			}
			
			?>
            <div class="kek-blog-author">
                <span class="by"><?php echo esc_html( 'by', 'kws-elementor-kit' ) ?></span>
                <span class="kek-post-grid-author">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>">
					<?php echo get_the_author() ?>
				</a>
			</span>
            </div>
			<?php
		}
		
		public function render_date() {
			$settings = $this->get_settings_for_display();
			
			if ( ! $this->get_settings( 'show_date' ) ) {
				return;
			}
			
			if ($settings['human_diff_time'] == 'yes') {
				echo kws_elementor_kit_post_time_diff(($settings['human_diff_time_short'] == 'yes') ? 'short' : '');
			} else {
				echo get_the_date();
			}
		}
		
		public function render_category() {
			
			if ( ! $this->get_settings( 'show_category' ) ) {
				return;
			}
			
			?>
            <div class="kek-blog-badge">
			<span>
				<?php echo kek_get_category($this->get_settings('posts_source')); ?>
			</span>
            </div>
			<?php
		}
		
		public function render_header() {
			$settings = $this->get_settings_for_display();
		
			//Global Function
			$this->render_header_attribute( 'jupiter');
			
			?>
            <div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
            <div class="kek-post-grid kek-pg-text-position-<?php echo esc_html( $settings['content_position'] ) ?> kek-blog-content-style-<?php echo esc_html( $settings['content_style'] ) ?>">
            <div class="swiper-container">
            <div class="swiper-wrapper">
			<?php
		}

		public function render_post( $post_id, $image_size ) {
			$settings = $this->get_settings_for_display();
			global $post;
			
			if ( 'yes' == $settings['global_link'] ) {
				
				$this->add_render_attribute( 'grid-item', 'onclick', "window.open('" . esc_url( get_permalink() ) . "', '_self')", true );
			}
			$this->add_render_attribute( 'grid-item', 'class', 'kek-post-grid-item swiper-slide kek-transition-toggle', true );
			
			?>
            <div <?php $this->print_render_attribute_string( 'grid-item' ); ?>>
                <div class="kek-post-grid-item-box">
					<?php $this->render_image( get_post_thumbnail_id( $post_id ), $image_size ); ?>

                    <div class="kek-blog-box-content">
                        <div class="kek-cetagory">
							<?php $this->render_category(); ?>
                        </div>

                        <div class="kek-blog-title-wrapper">
							<?php $this->render_title(); ?>
                        </div>
						
						<?php if ( $settings['show_author'] or $settings['show_date'] ) : ?>
                            <div class="kek-blog-post-meta">
								<?php $this->render_author(); ?>
                                <?php if ( $settings['show_date'] ) : ?>
                                    <div class="kek-blog-date">
                                        <i class="kek-icon-calendar"
                                           aria-hidden="true"></i><?php $this->render_date(); ?>
                                    </div>
								<?php endif; ?>
								<?php if ($settings['show_time']) : ?>
								<div class="kek-post-time">
									<i class="kek-icon-clock" aria-hidden="true"></i>
									<?php echo get_the_time(); ?>
								</div>
								<?php endif; ?>
                            </div>
						<?php endif; ?>


                    </div>
                </div>
            </div>
			<?php
		}
		
		public function render() {
			$settings = $this->get_settings_for_display();
			
			$this->query_posts( $settings['item_limit']['size'] );
			$wp_query = $this->get_query();
			
			if ( ! $wp_query->found_posts ) {
				return;
			}
			
			$this->render_header();
			
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				$thumbnail_size = $settings['primary_thumbnail_size'];
				
				$this->render_post( get_the_ID(), $thumbnail_size );
			}
			
			wp_reset_postdata();
			
			$this->render_footer();
		}
	}
