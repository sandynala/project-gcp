<?php
	
	namespace KwsElementorKit\Modules\VenusCarousel\Widgets;
	
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
	
	class Venus_Carousel extends Group_Control_Query {
		
		use Global_Widget_Controls;
		use Global_Swiper_Functions;

		private $_query = null;
		
		public function get_name() {
			return 'kek-venus-carousel';
		}
		
		public function get_title() {
			return CFTKEK . esc_html__( 'Venus Carousel', 'kws-elementor-kit' );
		}
		
		public function get_icon() {
			return 'kek-widget-icon kek-icon-venus-carousel';
		}
		
		public function get_categories() {
			return [ 'kws-elementor-kit' ];
		}
		
		public function get_keywords() {
			return [ 'post', 'carousel', 'blog', 'recent', 'news', 'venus' ];
		}
		
		public function get_style_depends() {
			if ( $this->kek_is_edit_mode() ) {
				return [ 'kek-all-styles' ];
			} else {
				return [ 'kws-elementor-kit-font', 'kek-venus-carousel' ];
			}
		}

		public function get_script_depends() {
			if ( $this->kek_is_edit_mode() ) {
				return [ 'kek-all-scripts' ];
			} else {
				return [ 'kek-venus-carousel' ];
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
			
			$this->add_group_control(
				Group_Control_Image_Size::get_type(),
				[
					'name'    => 'primary_thumbnail',
					'exclude' => [ 'custom' ],
					'default' => 'medium',
				]
			);
			
			$this->add_responsive_control(
				'default_image_height',
				[
					'label'     => esc_html__( 'Image Height(px)', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 200,
							'max' => 800,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-main-image .kek-blog-image' => 'height: {{SIZE}}px;',
					],
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
				'show_excerpt',
				[
					'label'   => esc_html__( 'Show Text', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);
			
			$this->add_control(
				'excerpt_length',
				[
					'label'       => esc_html__( 'Text Limit', 'kws-elementor-kit' ),
					'description' => esc_html__( 'It\'s just work for main content, but not working with excerpt. If you set 0 so you will get full main content.', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::NUMBER,
					'default'     => 30,
					'condition'   => [
						'show_excerpt' => 'yes'
					],
				]
			);
			
			$this->add_control(
				'strip_shortcode',
				[
					'label'     => esc_html__( 'Strip Shortcode', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'condition' => [
						'show_excerpt' => 'yes',
					],
				]
			);
			
			$this->add_control(
				'show_author',
				[
					'label'   => esc_html__( 'Show Author', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);

			
			$this->add_control(
				'show_category',
				[
					'label'   => esc_html__('Show Category', 'kws-elementor-kit'),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);
	
			//Global Date Controls
			$this->register_date_controls();
			
			$this->add_control(
				'item_match_height',
				[
					'label'        => __( 'Item Match Height', 'kws-elementor-kit' ),
					'type'         => Controls_Manager::SWITCHER,
					'default'      => 'yes',
					'prefix_class' => 'kek-item-match-height--',
					'separator'    => 'before'
				]
			);
			
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
			$this->register_navigation_controls( 'venus');
			
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
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'itam_background',
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item',
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'        => 'item_border',
					'label'       => __( 'Border', 'kws-elementor-kit' ),
					'placeholder' => '1px',
					'default'     => '1px',
					'selector'    => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item',
				]
			);
			
			$this->add_responsive_control(
				'item_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'item_box_shadow',
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item',
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
					'name'     => 'itam_background_color_hover',
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item:hover',
				]
			);
			
			$this->add_control(
				'item_border_color_hover',
				[
					'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item:hover' => 'border-color: {{VALUE}};'
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
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item:hover',
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
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'title_hover_color',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title:hover' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'title_spacing',
				[
					'label'     => esc_html__( 'Spacing', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
				]
			);
			
			$this->add_control(
				'title_advanced_style',
				[
					'label' => esc_html__( 'Advanced Style', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_control(
				'title_divider_color',
				[
					'label'     => esc_html__( 'Line Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title-wrap .kek-blog-title:before' => 'border-color: {{VALUE}};',
					],
					'condition' => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'title_background',
					'label'     => __( 'Background', 'kws-elementor-kit' ),
					'selector'  => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
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
					'selector'  => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
					'condition' => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'title_border',
					'selector'  => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
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
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'selector'  => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title',
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
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'  => [
						'title_advanced_style' => 'yes'
					]
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_text',
				[
					'label'     => esc_html__( 'Text', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_excerpt' => 'yes',
					],
				]
			);
			
			$this->add_control(
				'text_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-desc' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'text_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item .kek-post-grid-item-box .kek-blog-box-content .kek-blog-desc',
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_author',
				[
					'label'     => esc_html__( 'Author', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_author' => 'yes',
					],
				]
			);

			$this->add_responsive_control(
				'author_border_radius',
				[
					'label'      => __( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'author_background',
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap',
				]
			);
			
			$this->add_responsive_control(
				'author_padding',
				[
					'label'      => __( 'Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_control(
				'author_image_heading',
				[
					'label'     => esc_html__( 'Image', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);
			
			$this->add_responsive_control(
				'author_image_size',
				[
					'label'     => esc_html__( 'Size', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap .kek-author-img-wrap img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'author_image_spacing',
				[
					'label'     => esc_html__( 'Spacing', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid-item-box .kek-blog-post-author-wrap .kek-author-info-warp' => 'padding-left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_control(
				'author_name_heading',
				[
					'label'     => esc_html__( 'Name', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);
			
			$this->add_control(
				'author_name_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap .kek-author-info-warp .author-name .name' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'author_name_hover_color',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap .kek-author-info-warp .author-name .name:hover' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'author_name_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap .kek-author-info-warp .author-name .name',
				]
			);
			
			$this->add_control(
				'author_role_heading',
				[
					'label'     => esc_html__( 'Role', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);
			
			$this->add_control(
				'author_role_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap .kek-author-info-warp .author-depertment' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'author_role_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap .kek-author-info-warp .author-depertment',
				]
			);
			
			$this->add_responsive_control(
				'author_role_spacing',
				[
					'label'     => esc_html__( 'Spacing', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-blog-image-wrapper .kek-blog-post-author-wrap .kek-author-info-warp .author-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->end_controls_section();

			$this->start_controls_section(
				'section_style_category',
				[
					'label'     => esc_html__('Category/Date', 'kws-elementor-kit'),
					'tab'       => Controls_Manager::TAB_STYLE,
					'conditions' => [
						'relation' => 'or',
						'terms'    => [
							[
								'name'     => 'show_category',
								'value'    => 'yes'
							],
							[
								'name'     => 'show_date',
								'value'    => 'yes'
							]
						]
					],
				]
			);
	
			$this->add_responsive_control(
				'category_top_spacing',
				[
					'label'   => esc_html__('Spacing', 'kws-elementor-kit'),
					'type'    => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min'  => 0,
							'max'  => 50,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-category-meta-wrap' => 'top: {{SIZE}}{{UNIT}}; right: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_control(
				'category_date_heading',
				[
					'label'     => esc_html__('Date', 'kws-elementor-kit'),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'show_date' => 'yes'
					]
				]
			);
	
			$this->add_control(
				'category_date_color',
				[
					'label'     => esc_html__('Color', 'kws-elementor-kit'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-date, {{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-post-time' => 'color: {{VALUE}};',
					],
					'condition' => [
						'show_date' => 'yes'
					]
				]
			);

			$this->add_responsive_control(
				'date_spacing',
				[
					'label'   => esc_html__('Date Spacing', 'kws-elementor-kit'),
					'type'    => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min'  => 0,
							'max'  => 50,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-date' => 'margin-right: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'show_date' => 'yes'
					]
				]
			);
	
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'category_date_typography',
					'label'    => esc_html__('Typography', 'kws-elementor-kit'),
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-date, {{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-post-time',
					'condition' => [
						'show_date' => 'yes'
					]
				]
			);

			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name' => 'date_text_shadow',
					'label' => __( 'Text Shadow', 'kws-elementor-kit'),
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-date, {{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-post-time',
					'condition' => [
						'show_date' => 'yes'
					]
				]
			);
	
			$this->add_control(
				'category_heading',
				[
					'label'     => esc_html__('Category', 'kws-elementor-kit'),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->start_controls_tabs('tabs_category_style');
	
			$this->start_controls_tab(
				'tab_category_normal',
				[
					'label' => esc_html__('Normal', 'kws-elementor-kit'),
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_control(
				'category_color',
				[
					'label'     => esc_html__('Color', 'kws-elementor-kit'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a' => 'color: {{VALUE}};',
					],
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'category_background',
					'selector'  => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a',
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'           => 'category_border',
					'label'          => __( 'Border', 'kws-elementor-kit' ),
					'fields_options' => [
						'border' => [
							'default' => 'solid',
						],
						'width'  => [
							'default' => [
								'top'      => '1',
								'right'    => '1',
								'bottom'   => '1',
								'left'     => '1',
								'isLinked' => false,
							],
						],
						'color'  => [
							'default' => '#dddfe2',
						],
					],
					'selector'       => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a',
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_responsive_control(
				'category_border_radius',
				[
					'label'      => esc_html__('Border Radius', 'kws-elementor-kit'),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', '%'],
					'selectors'  => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_responsive_control(
				'category_padding',
				[
					'label'      => esc_html__('Padding', 'kws-elementor-kit'),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors'  => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_responsive_control(
				'category_space_between',
				[
					'label'   => esc_html__('Space Between', 'kws-elementor-kit'),
					'type'    => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min'  => 0,
							'max'  => 50,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a+a' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'category_shadow',
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a',
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'category_typography',
					'label'    => esc_html__('Typography', 'kws-elementor-kit'),
					'selector' => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a',
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->end_controls_tab();
	
			$this->start_controls_tab(
				'tab_category_hover',
				[
					'label' => esc_html__('Hover', 'kws-elementor-kit'),
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_control(
				'category_hover_color',
				[
					'label'     => esc_html__('Color', 'kws-elementor-kit'),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a:hover' => 'color: {{VALUE}};',
					],
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'category_hover_background',
					'selector'  => '{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a:hover',
					'condition' => [
						'show_category' => 'yes'
					]
				]
			);
	
			$this->add_control(
				'category_hover_border_color',
				[
					'label'     => esc_html__('Border Color', 'kws-elementor-kit'),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'category_border_border!' => '',
						'show_category' => 'yes'
					],
					'selectors' => [
						'{{WRAPPER}} .kek-venus-carousel .kek-post-grid .kek-post-grid-item .kek-post-grid-item-box .kek-venus-carousel-category a:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
	
			$this->end_controls_tab();
	
			$this->end_controls_tabs();
	
			$this->end_controls_section();

			//Navigation Global Controls
			$this->register_navigation_style( 'venus');
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
            <div class="kek-author-img-wrap">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 48 ); ?>
            </div>
			<?php
		}

		public function render_category() {

			if (!$this->get_settings('show_category')) {
				return;
			}
			?>
			<div class="kek-venus-carousel-category">
				<?php echo kek_get_category($this->get_settings('posts_source')); ?>
			</div>
			<?php
		}

		public function render_date() {
			$settings = $this->get_settings_for_display();
			if (!$this->get_settings('show_date')) {
				return;
			}

			?>
			<div class="kek-venus-carousel-date">
				<?php if ($settings['human_diff_time'] == 'yes') {
					echo kws_elementor_kit_post_time_diff(($settings['human_diff_time_short'] == 'yes') ? 'short' : '');
				} else {
					echo get_the_date();
				} ?>
			</div>
			<?php if ($settings['show_time']) : ?>
			<div class="kek-post-time">
				<i class="kek-icon-clock" aria-hidden="true"></i>
				<?php echo get_the_time(); ?>
			</div>
			<?php endif; ?>
			<?php
		}
		
		public function render_excerpt( $excerpt_length ) {
			
			if ( ! $this->get_settings( 'show_excerpt' ) ) {
				return;
			}
			$strip_shortcode = $this->get_settings_for_display( 'strip_shortcode' );
			
			?>
            <div class="kek-blog-desc">
				<?php
					if ( has_excerpt() ) {
						the_excerpt();
					} else {
						echo kws_elementor_kit_custom_excerpt( $excerpt_length, $strip_shortcode );
					}
				?>
            </div>
			<?php
		}
		
		public function render_header() {
			//Global Function
			$this->render_header_attribute( 'venus');
			
			?>
            <div <?php $this->print_render_attribute_string( 'carousel' ); ?>>
            <div class="kek-post-grid">
            <div class="swiper-container">
            <div class="swiper-wrapper">
			<?php
		}
		
		public function render_post_grid_item( $post_id, $image_size, $excerpt_length ) {
			$settings = $this->get_settings_for_display();
			
			if ( 'yes' == $settings['global_link'] ) {
				
				$this->add_render_attribute( 'grid-item', 'onclick', "window.open('" . esc_url( get_permalink() ) . "', '_self')", true );
			}
			$this->add_render_attribute( 'grid-item', 'class', 'kek-post-grid-item swiper-slide', true );
			
			?>
            <div <?php $this->print_render_attribute_string( 'grid-item' ); ?>>
                <div class="kek-post-grid-item-box">
                    <div class="kek-blog-image-wrapper">
                        <div class="kek-main-image">
							<?php $this->render_image( get_post_thumbnail_id( $post_id ), $image_size ); ?>
                        </div>
						
						<?php if ( $settings['show_author'] ) : ?>
                            <div class="kek-blog-post-author-wrap">
								
								<?php $this->render_author(); ?>
                                <div class="kek-author-info-warp">
							<span class="author-name">
								<a class="name"
                                   href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>">
									<?php echo get_the_author() ?>
								</a>
							</span>

                                    <span class="author-depertment">
								<?php
									$aid = get_the_author_meta( 'ID' );
									echo get_user_role( $aid );
								?>
							</span>
                                </div>
                            </div>
						<?php endif; ?>

						<?php if($settings['show_category'] == 'yes' or $settings['show_date'] == 'yes') : ?>
							<div class="kek-category-meta-wrap kek-flex kek-flex-middle">
								<?php $this->render_date(); ?>
								<?php $this->render_category(); ?>
							</div>
						<?php endif; ?>

                    </div>

                    <div class="kek-blog-box-content">
						
						<?php $this->render_title(); ?>

                        <div class="kek-blog-desc-wrap">
							<?php $this->render_excerpt( $excerpt_length ); ?>
                        </div>

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
				
				$this->render_post_grid_item( get_the_ID(), $thumbnail_size, $settings['excerpt_length'] );
			}
			
			wp_reset_postdata();
			
			$this->render_footer();
		}
	}
