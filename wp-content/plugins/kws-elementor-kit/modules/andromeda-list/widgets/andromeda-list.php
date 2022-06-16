<?php
	
	namespace KwsElementorKit\Modules\AndromedaList\Widgets;
	
	use Elementor\Controls_Manager;
	use Elementor\Group_Control_Border;
	use Elementor\Group_Control_Box_Shadow;
	use Elementor\Group_Control_Typography;
	use Elementor\Group_Control_Text_Shadow;
	use Elementor\Group_Control_Image_Size;
	use Elementor\Group_Control_Background;
	
	use KwsElementorKit\Traits\Global_Widget_Controls;
	use KwsElementorKit\Traits\Global_Widget_Functions;
	use KwsElementorKit\Includes\Controls\GroupQuery\Group_Control_Query;
	use KwsElementorKit\Modules\QueryControl\Controls\Group_Control_Posts;
	use WP_Query;
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly
	
	class Andromeda_List extends Group_Control_Query {
		
		use Global_Widget_Controls;
		use Global_Widget_Functions;

		private $_query = null;
		
		public function get_name() {
			return 'kek-andromeda-list';
		}
		
		public function get_title() {
			return CFTKEK . esc_html__( 'Andromeda List', 'kws-elementor-kit' );
		}
		
		public function get_icon() {
			return 'kek-widget-icon kek-icon-andromeda-list';
		}
		
		public function get_categories() {
			return [ 'kws-elementor-kit' ];
		}
		
		public function get_keywords() {
			return [ 'post', 'grid', 'blog', 'recent', 'news', 'andromeda', 'list' ];
		}
		
		public function get_style_depends() {
			if ( $this->kek_is_edit_mode() ) {
				return [ 'kek-all-styles' ];
			} else {
				return [ 'kws-elementor-kit-font', 'kek-andromeda-list' ];
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
					'default'        => '2',
					'tablet_default' => '1',
					'mobile_default' => '1',
					'options'        => [
						'1' => '1',
						'2' => '2',
					],
					'selectors'      => [
						'{{WRAPPER}} .kek-andromeda-list .kek-list-wrap' => 'grid-template-columns: repeat({{SIZE}}, 1fr);',
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
						'{{WRAPPER}} .kek-andromeda-list .kek-list-wrap' => 'grid-gap: {{SIZE}}{{UNIT}};',
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
			
			$this->add_control(
				'show_image',
				[
					'label'   => esc_html__( 'Show Image', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
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
					'label'   => esc_html__( 'Show Author', 'kws-elementor-kit' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'yes',
				]
			);
			
			//Global Date Controls
			$this->register_date_controls();
			
			$this->add_control(
				'show_pagination',
				[
					'label' => esc_html__( 'Show Pagination', 'kws-elementor-kit' ),
					'type'  => Controls_Manager::SWITCHER,
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
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'name'     => 'item_background',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item',
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'item_border',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item',
				]
			);
			
			$this->add_responsive_control(
				'item_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .kek-andromeda-list .kek-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'item_box_shadow',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item',
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
					'name'     => 'item_hover_background',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item:hover',
				]
			);
			
			$this->add_control(
				'item_hover_border_color',
				[
					'label'     => esc_html__( 'Border Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'condition' => [
						'item_border_border!' => '',
					],
					'selectors' => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'item_hover_box_shadow',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item:hover',
				]
			);
			
			$this->end_controls_tab();
			
			$this->end_controls_tabs();
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_image',
				[
					'label'     => esc_html__( 'Image', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
					'condition' => [
						'show_image' => 'yes'
					]
				]
			);
			
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'     => 'item_image_border',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-image-wrap .kek-img',
				]
			);
			
			$this->add_responsive_control(
				'item_image_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-image-wrap .kek-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_responsive_control(
				'item_image_size',
				[
					'label'     => esc_html__( 'Size(px)', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::SLIDER,
					'range'     => [
						'px' => [
							'min' => 100,
							'max' => 500,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-image-wrap' => 'max-width: {{SIZE}}{{UNIT}}; min-width: {{SIZE}}{{UNIT}};',
					],
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
					'label'   => esc_html__('Style', 'kws-elementor-kit'),
					'type'    => Controls_Manager::SELECT,
					'default' => 'underline',
					'options' => [
						'underline'        => esc_html__('Underline', 'kws-elementor-kit'),
						'middle-underline' => esc_html__('Middle Underline', 'kws-elementor-kit'),
						'overline'         => esc_html__('Overline', 'kws-elementor-kit'),
						'middle-overline'  => esc_html__('Middle Overline', 'kws-elementor-kit'),
					],
				]
			);
			
			$this->add_control(
				'title_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-title a' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'title_hover_color',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-title a:hover' => 'color: {{VALUE}};',
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
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'title_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-title',
				]
			);
			
			$this->add_group_control(
				Group_Control_Text_Shadow::get_type(),
				[
					'name'     => 'title_text_shadow',
					'label'    => __( 'Text Shadow', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-title a',
				]
			);
			
			$this->end_controls_section();
			
			$this->start_controls_section(
				'section_style_meta',
				[
					'label'     => esc_html__( 'Meta', 'kws-elementor-kit' ),
					'tab'       => Controls_Manager::TAB_STYLE,
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
			
			$this->add_control(
				'meta_color',
				[
					'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-meta *' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_control(
				'meta_hover_color',
				[
					'label'     => esc_html__( 'Hover Color', 'kws-elementor-kit' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-meta .kek-author a:hover' => 'color: {{VALUE}};',
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
							'min'  => 0,
							'max'  => 50,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-meta .kek-date' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'meta_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-meta',
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
							'min'  => 0,
							'max'  => 50,
							'step' => 2,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'category_background',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a',
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
							'default' => '#8D99AE',
						],
					],
					'selector'       => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a',
				]
			);
			
			$this->add_responsive_control(
				'category_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-elementor-kit' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a+a' => 'margin-left: {{SIZE}}{{UNIT}};',
					],
				]
			);
			
			
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'category_shadow',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a',
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name'     => 'category_typography',
					'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a',
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
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a:hover' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'     => 'category_hover_background',
					'selector' => '{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a:hover',
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
						'{{WRAPPER}} .kek-andromeda-list .kek-item .kek-item-box .kek-content .kek-category a:hover' => 'border-color: {{VALUE}};',
					],
				]
			);
			
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
		public function query_posts( $posts_per_page ) {
			
			$default = $this->getGroupControlQueryArgs();
			if ( $posts_per_page ) {
				$args['posts_per_page'] = $posts_per_page;
				$args['paged']  = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
			}
			$args         = array_merge( $default, $args );
			$this->_query = new WP_Query( $args );
		}
		
		public function render_author() {
			
			if ( ! $this->get_settings( 'show_author' ) ) {
				return;
			}
			
			?>

            <div class="kek-author">
                <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ) ?>">
                    <i class="kek-icon-user"></i>
                    <span class="kek-author-name"><?php echo get_the_author() ?></span>
                </a>
            </div>
			
			<?php
		}
		
		public function render_date() {
			$settings = $this->get_settings_for_display();
			
			if ( ! $this->get_settings( 'show_date' ) ) {
				return;
			}
			
			?>
			<div class="kek-flex">
				<div class="kek-date">
					<i class="kek-icon-calendar"></i>
					<span class="kek-andromeda-date">
						<?php if ($settings['human_diff_time'] == 'yes') {
							echo kws_elementor_kit_post_time_diff(($settings['human_diff_time_short'] == 'yes') ? 'short' : '');
						} else {
							echo get_the_date();
						} ?>
					</span>
				</div>
				<?php if ($settings['show_time']) : ?>
				<div class="kek-post-time">
					<i class="kek-icon-clock" aria-hidden="true"></i>
					<?php echo get_the_time(); ?>
				</div>
				<?php endif; ?>
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
                <div class="kek-item-box">
					<?php if ( 'yes' == $settings['show_image'] ) : ?>
                        <div class="kek-image-wrap">
							<?php $this->render_image( get_post_thumbnail_id( $post_id ), $image_size ); ?>
                        </div>
					<?php endif; ?>
                    <div class="kek-content">
                        <div>
							<?php $this->render_category(); ?>
							<?php $this->render_title(); ?>
                            <div class="kek-meta">
								<?php $this->render_author(); ?>
								<?php $this->render_date(); ?>
                            </div>
                        </div>
                    </div>
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
			$this->add_render_attribute( 'list-wrap', 'class', 'kek-andromeda-list' );
		
			if (isset($settings['kek_in_animation_show']) && ($settings['kek_in_animation_show'] == 'yes')) {
				$this->add_render_attribute( 'list-wrap', 'class', 'kek-in-animation' );
				if (isset($settings['kek_in_animation_delay']['size'])) {
					$this->add_render_attribute( 'list-wrap', 'data-in-animation-delay', $settings['kek_in_animation_delay']['size'] );
				}
			}

			?>
			<div <?php $this->print_render_attribute_string('list-wrap'); ?>>
                <div class="kek-list-wrap">
					
					<?php while ( $wp_query->have_posts() ) :
						$wp_query->the_post();
						
						$thumbnail_size = $settings['primary_thumbnail_size'];
						
						?>
						
						<?php $this->render_post_grid_item( get_the_ID(), $thumbnail_size ); ?>
					
					<?php endwhile; ?>
                </div>
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
