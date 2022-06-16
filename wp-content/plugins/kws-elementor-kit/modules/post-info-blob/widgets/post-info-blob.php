<?php

namespace KwsElementorKit\Modules\PostInfoBlob\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Box_Shadow;
use KwsElementorKit\Includes\Controls\GroupQuery\Group_Control_Query;
use KwsElementorKit\Modules\QueryControl\Controls\Group_Control_Posts;

if (!defined('ABSPATH')) {
	exit;
}

class Post_Info_Blob extends Group_Control_Query {
	public function get_name() {
		return 'kek-post-info-blob';
	}

	public function get_title() {
		return CFTKEK . esc_html__('Post Info Blob', 'kws-elementor-kit');
	}

	public function get_icon() {
		return 'kek-widget-icon kek-icon-post-info-blob';
	}

	public function get_categories() {
		return ['kws-elementor-kit'];
	}

	public function get_style_depends() {
		if ($this->kek_is_edit_mode()) {
			return ['kek-all-styles'];
		} else {
			return ['kws-elementor-kit-font', 'kek-post-info-blob'];
		}
	}
	public function get_script_depends() {
		if ($this->kek_is_edit_mode()) {
			return ['kek-all-scripts'];
		} else {
			return ['kek-post-info-blob'];
		}
	}

	public function get_keywords() {
		return ['post', 'grid', 'blog', 'recent', 'news', 'social-count', 'count'];
	}

	public function get_custom_help_url() {
		return '';
	}

	public function on_import($element) {
		if (!get_post_type_object($element['settings']['posts_post_type'])) {
			$element['settings']['posts_post_type'] = 'post';
		}

		return $element;
	}

	public function on_export($element) {
		$element = Group_Control_Posts::on_export_remove_setting_from_element($element, 'posts');

		return $element;
	}

	public function register_controls() {
		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__('Layout', 'kws-elementor-kit-pro'),
			]
		);

		$this->add_control(
			'select_style',
			[
				'label'      => esc_html__('Select Style', 'kws-elementor-kit-pro'),
				'type'       => Controls_Manager::SELECT,
				'default'    => '',
				'options'    => [
					''  => esc_html__('Style 1', 'kws-elementor-kit-pro'),
					'kek-style-2' => esc_html__('Style 2', 'kws-elementor-kit-pro'),
				],
			]
		);

		$this->add_responsive_control(
			'grid_columns',
			[
				'label' => __('Columns', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::SELECT,
				'default'        => '4',
				'tablet_default' => '4',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob' => ' grid-template-columns: repeat({{VALUE}}, 1fr);'
				],
				// 'condition' => [
				// 	'select_layout' => 'grid'
				// ]
			]
		);

		$this->add_responsive_control(
			'social_icon_space_between',
			[
				'label'         => esc_html__('Column Gap', 'kws-elementor-kit-pro'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px'],
				'range'         => [
					'px'        => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob' => 'grid-gap: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_social_sites',
			[
				'label' => esc_html__('Social Count', 'kws-elementor-kit'),
			]
		);
		$repeater = new Repeater();
		$repeater->start_controls_tabs(
			'social_count_tabs'
		);
		$repeater->start_controls_tab(
			'social_count_tabs_content',
			[
				'label' => esc_html__('Content', 'kws-elementor-kit-pro'),
			]
		);
		$repeater->add_control(
			'social_site_name',
			[
				'label'       => esc_html__('Label', 'kws-elementor-kit-pro'),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__('facebook', 'kws-elementor-kit-pro'),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'social_site_link',
			[
				'label'             => esc_html__('Link', 'kws-elementor-kit-pro'),
				'type'              => Controls_Manager::URL,
				'placeholder'       => esc_html__('https://facebook.com', 'kws-elementor-kit-pro'),
				'show_external'     => true,
				'default'           => [
					'url'           => 'https://kwstech.in',
					'is_external'   => true,
					'nofollow'      => true,
				],
			]
		);
		$repeater->add_control(
			'social_site_icon',
			[
				'label'         => esc_html__('Icon', 'kws-elementor-kit'),
				'type'          => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fab fa-wordpress',
					'library' => 'fa-brands',
				],
				'recommended' => [
					'fa-brands' => [
						'android',
						'apple',
						'behance',
						'bitbucket',
						'codepen',
						'delicious',
						'deviantart',
						'digg',
						'dribbble',
						'elementor',
						'facebook',
						'flickr',
						'foursquare',
						'free-code-camp',
						'github',
						'gitlab',
						'globe',
						'houzz',
						'instagram',
						'jsfiddle',
						'linkedin',
						'medium',
						'meetup',
						'mix',
						'mixcloud',
						'odnoklassniki',
						'pinterest',
						'product-hunt',
						'reddit',
						'shopping-cart',
						'skype',
						'slideshare',
						'snapchat',
						'soundcloud',
						'spotify',
						'stack-overflow',
						'steam',
						'telegram',
						'thumb-tack',
						'tripadvisor',
						'tumblr',
						'twitch',
						'twitter',
						'viber',
						'vimeo',
						'vk',
						'weibo',
						'weixin',
						'whatsapp',
						'wordpress',
						'xing',
						'yelp',
						'youtube',
						'500px',
					],
					'fa-solid' => [
						'envelope',
						'link',
						'rss',
					],
				],
				'skin' => 'inline',
				'label_block' => false
			]
		);
		$repeater->add_control(
			'social_counter',
			[
				'label'     => esc_html__('Number', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->add_control(
			'social_site_meta',
			[
				'label'     => esc_html__('Meta', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'social_count_tabs_style',
			[
				'label' => esc_html__('Style', 'kws-elementor-kit-pro'),
			]
		);
		$repeater->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'social_single_item_bg',
				'label'     => esc_html__('Background', 'kws-elementor-kit-pro'),
				'types'     => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector'  => '{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}}.kek-item',
			]
		);
		$repeater->add_control(
			'heading_icon_social_single',
			[
				'label'     => esc_html__('ICON NORMAL', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'social_single_color',
			[
				'label' => esc_html__('Color', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}} .kek-icon span' => 'color: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'social_single_bg_color',
			[
				'label' => esc_html__('Background', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}} .kek-icon span' => 'background: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'social_single_border_color',
			[
				'label' => esc_html__('Border', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}} .kek-icon span' => 'border-color: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'heading_icon_h_social_single',
			[
				'label'     => esc_html__('ICON HOVER', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'social_single_h_color',
			[
				'label' => esc_html__('Color', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}} .kek-icon:hover span' => 'color:{{VALUE}}',
				],
			]
		);
		$repeater->add_control(
			'social_single_h_bg_color',
			[
				'label' => esc_html__('Background', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}} .kek-icon:hover span' => 'background: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'social_single_h_border_color',
			[
				'label' => esc_html__('Border', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}} .kek-icon:hover span' => 'border-color: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'heading_number_social_single',
			[
				'label'     => esc_html__('N U M B E R', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'social_single_count_color',
			[
				'label' => esc_html__('Color', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}} .kek-count .counter-value' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'heading_meta_social_single',
			[
				'label'     => esc_html__('M E T A', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'social_single_meta_color',
			[
				'label' => esc_html__('Color', 'kws-elementor-kit-pro'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob {{CURRENT_ITEM}} .kek-meta' => 'color: {{VALUE}};',
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();
		$this->add_control(
			'social_counter_list',
			[
				'label'         => esc_html__('Social', 'kws-elementor-kit-pro'),
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'social_site_name'    => esc_html__('Facebook', 'kws-elementor-kit-pro'),
						'social_site_icon' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
						'social_counter'    => esc_html__('450', 'kws-elementor-kit-pro'),
						'social_site_meta'    => esc_html__('Likes', 'kws-elementor-kit-pro'),
						'social_site_link' => [
							'url' => esc_html__('https://facebook.com/kwstech', 'kws-elementor-kit-pro')
						]
					],
					[
						'social_site_name'    => esc_html__('Twitter', 'kws-elementor-kit-pro'),
						'social_site_icon' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
						'social_counter'    => esc_html__('3000', 'kws-elementor-kit-pro'),
						'social_site_meta'    => esc_html__('Followers', 'kws-elementor-kit-pro'),
						'social_site_link' => [
							'url' => esc_html__('https://twitter.com/kwstechcom', 'kws-elementor-kit-pro')
						]
					],
					[
						'social_site_name'    => esc_html__('Youtube', 'kws-elementor-kit-pro'),
						'social_site_icon' => [
							'value' => 'fab fa-youtube',
							'library' => 'fa-brands',
						],
						'social_counter'    => esc_html__('2000000', 'kws-elementor-kit-pro'),
						'social_site_meta'    => esc_html__('Subscriber', 'kws-elementor-kit-pro'),
						'social_site_link' => [
							'url' => esc_html__('https://youtube.com/kwstech', 'kws-elementor-kit-pro')
						]
					],
					[
						'social_site_name'    => esc_html__('Instagram', 'kws-elementor-kit-pro'),
						'social_site_icon' => [
							'value' => 'fab fa-instagram',
							'library' => 'fa-brands',
						],
						'social_counter'    => esc_html__('105000', 'kws-elementor-kit-pro'),
						'social_site_meta'    => esc_html__('Followers', 'kws-elementor-kit-pro'),
						'social_site_link' => [
							'url' => esc_html__('https://instagram.com/kwstech', 'kws-elementor-kit-pro')
						]
					],
				],
				'title_field'   => '{{{ social_site_name }}}',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'static_social_items',
			[
				'label' => esc_html__('Items', 'kws-elementor-kit-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs(
			'static_social_item_tabs'
		);
		$this->start_controls_tab(
			'static_social_tab_normal',
			[
				'label' => esc_html__('Normal', 'kws-elementor-kit-pro'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'social_static_background',
				'label'     => esc_html__('Background', 'kws-elementor-kit-pro'),
				'types'     => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-item',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'social_static_border',
				'label'     => esc_html__('Border', 'kws-elementor-kit-pro'),
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-item',
			]
		);
		$this->add_responsive_control(
			'social_static_padding',
			[
				'label'                 => esc_html__('Padding', 'kws-elementor-kit-pro'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .kek-post-info-blob .kek-item'    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'social_static_border_radius',
			[
				'label'                 => esc_html__('Radius', 'kws-elementor-kit-pro'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .kek-post-info-blob .kek-item'    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'static_social_shadow',
				'label'     => esc_html__('Box Shadow', 'kws-elementor-kit-pro'),
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-item',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'static_social_tab_hover',
			[
				'label' => esc_html__('Hover', 'kws-elementor-kit-pro'),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'static_social_hover_bg',
				'label'     => esc_html__('Background', 'kws-elementor-kit-pro'),
				'types'     => ['classic', 'gradient'],
				'exclude' => ['image'],
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-item:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'section_social_count_style',
			[
				'label' => esc_html__('Icons', 'kws-elementor-kit-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->start_controls_tabs(
			'social_icons_tab'
		);
		$this->start_controls_tab(
			'social_icon_tab_normal',
			[
				'label' => esc_html__('Normal', 'kws-elementor-kit-pro'),
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__('Color', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-icon span' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'icon_background',
				'label'     => esc_html__('Background', 'kws-elementor-kit-pro'),
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-icon span',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'social_icons_border',
				'label'     => esc_html__('Border', 'kws-elementor-kit-pro'),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-icon span',
			]
		);
		$this->add_responsive_control(
			'social_icon_padding',
			[
				'label'                 => esc_html__('Padding', 'kws-elementor-kit-pro'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .kek-post-info-blob .kek-icon span '    => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'social_icon_radius',
			[
				'label'                 => esc_html__('Radius', 'kws-elementor-kit-pro'),
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => ['px', '%', 'em'],
				'selectors'             => [
					'{{WRAPPER}} .kek-post-info-blob .kek-icon span '    => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'social_icon_size',
			[
				'label'         => esc_html__('Size', 'kws-elementor-kit-pro'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px'],
				'range'         => [
					'px'        => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-icon span i' => 'font-size: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->add_responsive_control(
			'social_icon_spacing',
			[
				'label'         => esc_html__('Bottom Spacing', 'kws-elementor-kit-pro'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px'],
				'range'         => [
					'px'        => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'select_style' => ''
				]
			]
		);
		$this->add_responsive_control(
			'social_icon_spacing_left',
			[
				'label'         => esc_html__('Spacing', 'kws-elementor-kit-pro'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px'],
				'range'         => [
					'px'        => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'select_style' => 'kek-style-2'
				]
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'social_icon_tab_hover',
			[
				'label' => esc_html__('Hover', 'kws-elementor-kit-pro'),
			]
		);
		$this->add_control(
			'icon_h_color',
			[
				'label'     => esc_html__('Color', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-icon span:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'icon_h_background',
				'label'     => esc_html__('Background', 'kws-elementor-kit-pro'),
				'types'     => ['classic', 'gradient'],
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-icon span:hover',
			]
		);
		$this->add_control(
			'icon_h_border_color',
			[
				'label'     => esc_html__('Border Color', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-icon span:hover' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'social_icons_border_border!' => ''
				]
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'social_counter',
			[
				'label' => esc_html__('Counter', 'kws-elementor-kit-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'counter_color',
			[
				'label'     => esc_html__('Color', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-count .counter-value' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'counter_typography',
				'label'     => esc_html__('Typography', 'kws-elementor-kit-pro'),
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-count .counter-value',
			]
		);
		$this->add_responsive_control(
			'social_counter_spacing',
			[
				'label'         => esc_html__('Bottom Spacing', 'kws-elementor-kit-pro'),
				'type'          => Controls_Manager::SLIDER,
				'size_units'    => ['px'],
				'range'         => [
					'px'        => [
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-count' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				]
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'social_meta',
			[
				'label' => esc_html__('Meta', 'kws-elementor-kit-pro'),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'meta_color',
			[
				'label'     => esc_html__('Color', 'kws-elementor-kit-pro'),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-post-info-blob .kek-meta' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'meta_typography',
				'label'     => esc_html__('Typography', 'kws-elementor-kit-pro'),
				'selector'  => '{{WRAPPER}} .kek-post-info-blob .kek-meta',
			]
		);
		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		$this->add_render_attribute('kek-post-info-blob', 'class', ['kek-post-info-blob', $settings['select_style']], true);
		$social_links = $this->get_settings('social_counter_list'); ?>
		<div <?php $this->print_render_attribute_string('kek-post-info-blob'); ?>>
			<?php foreach ($social_links as $link_key => $social_link) {
				$this->add_render_attribute($link_key, 'class', [
					'kek-item',
					'kek-social-icon',
					'kek-social-icon-' . strtolower($social_link['social_site_name']),
					'elementor-repeater-item-' . $social_link['_id'],
				]);
				if ($social_link['social_site_link']['is_external'] !== 'on') {
					$this->add_render_attribute($link_key, 'href', $social_link['social_site_link']['url']);
				} else {
					$this->add_render_attribute(
						$link_key,
						[
							'href' => [
								$social_link['social_site_link']['url']
							],
							'target' => '_blank'
						],
						null,
						true
					);
				}
			?>
				<a href="#" <?php $this->print_render_attribute_string($link_key); ?>>
					<div class="kek-icon">
						<span title="<?php echo $social_link['social_site_name']; ?>">
							<?php Icons_Manager::render_icon($social_link['social_site_icon'], ['aria-hidden' => 'true']); ?>
						</span>
					</div>
					<div class="kek-content">
						<div class="kek-count">
							<?php echo '<span class="counter-value">' . $social_link['social_counter'] . '</span>'; ?>
						</div>
						<div class="kek-meta">
							<?php printf('<span>%s</span>', $social_link['social_site_meta']); ?>
						</div>
					</div>
				</a>
	<?php
			}
			echo '</div>';
		}
	}
