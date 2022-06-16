<?php
	
	namespace KwsElementorKit\Modules\CanisList\Widgets;
	
	use Elementor\Controls_Manager;
	use Elementor\Group_Control_Border;
	use Elementor\Group_Control_Box_Shadow;
	use Elementor\Group_Control_Typography;
	use Elementor\Group_Control_Text_Shadow;
	use Elementor\Group_Control_Image_Size;
	use Elementor\Group_Control_Background;
	use KwsElementorKit\Utils;
	
	use KwsElementorKit\Traits\Global_Widget_Controls;
	use KwsElementorKit\Traits\Global_Widget_Functions;
	use KwsElementorKit\Includes\Controls\GroupQuery\Group_Control_Query;
	use KwsElementorKit\Modules\QueryControl\Controls\Group_Control_Posts;
	use WP_Query;
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly
	
	class Canis_List extends Group_Control_Query {

		use Global_Widget_Controls;
		use Global_Widget_Functions;

		private $_query = null;
		
		public function get_name() {
			return 'kek-canis-list';
		}
		
		public function get_title() {
			return CFTKEK . esc_html__( 'Canis List', 'kws-elementor-kit' );
		}
		
		public function get_icon() {
			return 'kek-widget-icon kek-icon-canis-list';
		}
		
		public function get_categories() {
			return [ 'kws-elementor-kit' ];
		}
		
		public function get_keywords() {
			return [ 'post', 'grid', 'blog', 'recent', 'news', 'canis', 'list' ];
		}
		
		public function get_style_depends() {
			if ( $this->kek_is_edit_mode() ) {
				return [ 'kek-all-styles' ];
			} else {
				return [ 'kws-elementor-kit-font', 'kek-canis-list' ];
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

			//Global Title Controls
			$this->register_title_controls();
			
			$this->add_control(
				'show_category',
				[
					'label'   => esc_html__( 'Show Category', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);

			$this->add_control(
				'show_author',
				[
					'label'     => esc_html__( 'Show Author', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SWITCHER,
					'default'   => 'yes',
					'separator' => 'before'
				]
			);
			
			$this->add_control(
				'show_comments',
				[
					'label' => esc_html__( 'Show Comments', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
				]
			);
			
			$this->add_control(
				'meta_separator',
				[
					'label'       => __( 'Separator', 'kws-elementor-kit' ),
					'type'        => Controls_Manager::TEXT,
					'default'     => '//',
					'label_block' => false,
				]
			);
			
			//Global Date Controls
			$this->register_date_controls();

			$this->add_control(
				'hr',
				[
					'type' => Controls_Manager::DIVIDER,
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

			$this->add_control(
				'show_pagination',
				[
					'label'     => esc_html__( 'Show Pagination', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SWITCHER,
					'separator' => 'before'
				]
			);
			
			$this->add_control(
				'global_link',
				[
					'label'        => __( 'Item Wrapper Link', 'kws-elementor-kit' ),
					'type'         => Controls_Manager::SWITCHER,
					'prefix_class' => 'kek-global-link-',
					'description'  => __( 'Be aware! When Item Wrapper Link activated then title link and read more link will not work', 'kws-elementor-kit' ),
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
						'size' => 3,
					],
				]
			);
			
			$this->register_query_builder_controls();
			
			$this->end_controls_section();
		
			//Style
			$this->start_controls_section(
				'kek_section_style',
				[
					'label' => esc_html__( 'Item', 'kws-elementor-kit' ),
					'tab'   => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'item_border_style',
				[
					'label'   => esc_html__( 'Border Style', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'solid',
					'options' => [
						'none'  => esc_html__( 'None', 'kws-elementor-kit' ),
						'solid'  => esc_html__( 'Solid', 'kws-elementor-kit' ),
						'dashed' => esc_html__( 'Dashed', 'kws-elementor-kit' ),
						'dotted' => esc_html__( 'Dotted', 'kws-elementor-kit' ),
						'double' => esc_html__( 'Double', 'kws-elementor-kit' ),
					],
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item' => 'border-top-style: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'item_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item' => 'border-top-color: {{VALUE}};',
					],
					'condition' => [
						'item_border_style!' => 'none'
					]
				]
			);

			$this->add_responsive_control(
				'item_border_width',
				[
					'label'     => esc_html__( 'Border Width', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item' => 'border-top-width: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'item_border_style!' => 'none'
					]
				]
			);

			$this->add_responsive_control(
				'item_border_spacing',
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
						'{{WRAPPER}} .kek-canis-list .kek-item' => 'padding-top: {{SIZE}}{{UNIT}}; margin-top: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'content_padding',
				[
					'label'      => esc_html__( 'Content Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'before'
				]
			);

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
				'title_style',
				[
					'label'   => esc_html__( 'Style', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SELECT,
					'default' => 'underline',
					'options' => [
						'underline'        => esc_html__( 'Style 01', 'kws-elementor-kit' ),
						'middle-underline' => esc_html__( 'Style 02', 'kws-elementor-kit' ),
						'overline'         => esc_html__( 'Style 03', 'kws-elementor-kit' ),
						'middle-overline'  => esc_html__( 'Style 04', 'kws-elementor-kit' ),
						'style-5'          => esc_html__( 'Style 05', 'kws-elementor-kit' ),
						'style-6'          => esc_html__( 'Style 06', 'kws-elementor-kit' ),
					],
				]
			);
			
			$this->add_control(
				'title_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-title a' => 'color: {{VALUE}};',
					],
					'separator' => 'before'
				]
			);
			
			$this->add_control(
				'title_hover_color',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-title a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-title',
				]
			);
			
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'title_text_shadow',
					'label'    => __( 'Text Shadow', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-title a',
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_meta',
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
							],
							[
								'name'  => 'show_comments',
								'value' => 'yes'
							]
						]
					],
				]
			);
			
			$this->add_control(
				'meta_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-meta, {{WRAPPER}} .kek-canis-list .kek-item .kek-meta .kek-author-name-wrap .kek-author-name' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'meta_hover_color',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-meta .kek-author-name-wrap .kek-author-name:hover' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'meta_spacing',
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
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-meta' => 'padding-top: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'meta_space_between',
				[
					'label'     => esc_html__( 'Space Between', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 0,
							'max' => 50,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-meta .kek-separator' => 'margin: 0 {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'meta_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-meta',
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
			
			$this->add_responsive_control(
				'category_bottom_spacing',
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
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-category a' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'category_background',
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-category a',
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'category_border',
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-category a',
				]
			);
			
			$this->add_responsive_control(
				'category_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-category a+a' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'category_shadow',
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-category a',
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'category_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-category a',
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
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-category a:hover' => 'color: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'category_hover_background',
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-category a:hover',
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
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-category a:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			
			$this->end_controls_tab();
			
			$this->end_controls_tabs();
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_counter_number',
				[
					'label'     => esc_html__( 'Image', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_control(
				'image_overlay_color',
				[
					'label'     => esc_html__( 'Overlay Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap .kek-img-overlay:before' => 'background: {{VALUE}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'image_border',
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap',
				]
			);
			
			$this->add_responsive_control(
				'image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap, {{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'image_padding',
				[
					'label'      => esc_html__( 'Padding', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
		
			$this->add_control(
				'counter_number_heading',
				[
					'label'     => esc_html__( 'Counter Number', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);
			
			$this->add_control(
				'counter_number_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap:before' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'counter_number_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap:before',
				]
			);
			
			
			$this->add_control(
				'icon_heading',
				[
					'label'     => esc_html__( 'Icon', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::HEADING,
					'separator' => 'before'
				]
			);
			
			$this->add_control(
				'icon_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap:after' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'icon_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-canis-list .kek-item .kek-image-wrap:after',
				]
			);
			
			$this->end_controls_section();
			
			//Global Pagination Controls
			$this->register_pagination_controls();
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
			<a class="kek-image-wrap" href="<?php echo esc_url( get_permalink() ) ?>">
				<img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_html( get_the_title() ); ?>">
				<span class="kek-img-overlay"></span>
			</a>
			<?php
		}

		public function render_author() {
			
			if ( ! $this->get_settings( 'show_author' ) ) {
				return;
			}
			?>
            <div class="kek-author-name-wrap">
                <span class="kek-by"><?php echo esc_html_x('by', 'Frontend', 'kws-elementor-kit') ?></span>
                <a class="kek-author-name" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>">
					<?php echo get_the_author() ?>
                </a>
            </div>
			<?php
		}
		
		public function render_comments( $id = 0 ) {
			
			if ( ! $this->get_settings( 'show_comments' ) ) {
				return;
			}
			?>

            <div class="kek-canis-comments">
				<?php echo get_comments_number( $id ) ?>
				<?php echo esc_html_x( 'Comments', 'Frontend', 'kws-elementor-kit' ) ?>
            </div>
			
			<?php
		}
		
		public function render_post_grid_item( $post_id, $image_size ) {
			$settings = $this->get_settings_for_display();
			
			if ( 'yes' == $settings['global_link'] ) {
				
				$this->add_render_attribute( 'list-item', 'onclick', "window.open('" . esc_url( get_permalink() ) . "', '_self')", true );
			}
			$this->add_render_attribute( 'list-item', 'class', 'kek-item', true );
			
			?>
			<div <?php $this->print_render_attribute_string( 'list-item' ); ?>>
				<?php $this->render_image( get_post_thumbnail_id( $post_id ), $image_size ); ?>
				<div class="kek-content">
					<?php $this->render_category(); ?>
					<?php $this->render_title(); ?>
					<?php if ( $settings['show_author'] or $settings['show_comments'] or $settings['show_date'] ) : ?>
						<div class="kek-meta kek-flex kek-flex-middle">
							<?php if ( $settings['show_author'] ) : ?>
								<?php $this->render_author(); ?>
								<span class="kek-separator"><?php echo $settings['meta_separator']; ?></span>
							<?php endif; ?>
							<?php $this->render_date(); ?>
							<?php if ( $settings['show_comments'] ) : ?>
								<span class="kek-separator"><?php echo $settings['meta_separator']; ?></span>
								<?php $this->render_comments( $post_id ); ?>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php
		}
		
		protected function render() {
			$settings = $this->get_settings_for_display();
			
			$this->query_posts( $settings['item_limit']['size'] );
			$wp_query = $this->get_query();
			
			if ( ! $wp_query->found_posts ) {
				return;
			}

			$this->add_render_attribute( 'list-wrap', 'class', 'kek-canis-list' );
			
			if (isset($settings['kek_in_animation_show']) && ($settings['kek_in_animation_show'] == 'yes')) {
				$this->add_render_attribute( 'list-wrap', 'class', 'kek-in-animation' );
				if (isset($settings['kek_in_animation_delay']['size'])) {
					$this->add_render_attribute( 'list-wrap', 'data-in-animation-delay', $settings['kek_in_animation_delay']['size'] );
				}
			}
			
			?>
            <div <?php $this->print_render_attribute_string('list-wrap'); ?>>
				<?php while ( $wp_query->have_posts() ) :
					$wp_query->the_post();
					
					$thumbnail_size = $settings['primary_thumbnail_size'];
					
					?>
					
					<?php $this->render_post_grid_item( get_the_ID(), $thumbnail_size ); ?>
				
				<?php endwhile; ?>
            </div>
			
			<?php
			
			if ( $settings['show_pagination'] ) { ?>
                <div class="ep-pagination">
					<?php kws_elementor_kit_post_pagination( $wp_query, $this->get_id() ); ?>
                </div>
				<?php
			}
			wp_reset_postdata();
		}
	}
