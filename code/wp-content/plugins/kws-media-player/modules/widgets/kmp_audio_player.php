<?php 

namespace KwsMediaPlayer\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;


if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class CF_Audio_Player extends Widget_Base {
		
	public function get_name() {
		return 'cf-audio-player';
	}

    public function get_title() {
        return esc_html__('Audio Player', 'kws-kmp');
    }

    public function get_icon() {
        return 'fa fa-headphones kmp_backend_icon';
    }

    public function get_categories() {
        return array('kmp-essential');
    }

	public function get_script_depends() {
		return [ 'cf-audio-player' ];
	}
	
	public function get_style_depends() {
		return [ 'cf-audio-player' ];
	}
	
    protected function _register_controls() {
		$this->start_controls_section(
			'section_audio_player',
			[
				'label' => esc_html__( 'Audio Player', 'kws-kmp' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'ap_style',
			[
				'label' => esc_html__( 'Styles', 'kws-kmp' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-std',
				'options' => [
					'style-micro'  => esc_html__( 'Micro', 'kws-kmp' ),
					'style-std'  => esc_html__( 'Standard', 'kws-kmp' ),
				],
			]
		);
		$this->end_controls_section();		
		$this->start_controls_section(
			'section_audio_playlist',
			[
				'label' => esc_html__( 'Playlist', 'kws-kmp' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new Repeater();
		$repeater->add_control(
			'title',
			[
				'label' 		=> esc_html__( 'Song Title', 'kws-kmp' ),
				'type' 			=> Controls_Manager::TEXT,
				'dynamic' 		=> [ 'active' => true ],
				'label_block' 	=> true,
				'default' 		=> esc_html__( 'KMP Audio', 'kws-kmp' ),
			]
		);
		$repeater->add_control(
			'author',
			[
				'label' 		=> esc_html__( 'Song Author', 'kws-kmp' ),
				'type' 			=> Controls_Manager::TEXT,
				'dynamic' 		=> [ 'active' => true ],
				'default' 		=> esc_html__( 'KMP', 'kws-kmp' ),
				'label_block' 	=> true,				
			]
		);		
		$repeater->add_control(
			'audio_source',
			[
				'label' 		=> esc_html__( 'Source', 'kws-kmp' ),
				'type' 			=> Controls_Manager::SELECT,
				'default'		=> 'url',
				'options'		=> [
					'file'		=> esc_html__( 'Self Hosted', 'kws-kmp' ),
					'url'		=> esc_html__( 'External', 'kws-kmp' ),
				],
			]
		);
		$repeater->add_control(
			'source_mp3',
			[
				'label' 		=> esc_html__( 'File', 'kws-kmp' ),
				'type' 			=> Controls_Manager::MEDIA,
				'dynamic' 		=> ['active' 	=> true,],
				'condition'		=> [
					'audio_source' => 'file',
				],
				'media_type' => 'audio',
			]
		);
		$repeater->add_control(
			'source_mp3_url',
			[
				'label' 		=> esc_html__( 'URL', 'kws-kmp' ),
				'type' 			=> Controls_Manager::URL,				
				'dynamic' 		=> [
					'active' 	=> true,
				],
				'condition' 	=> [
					'audio_source' => 'url',
				],
			]
		);
		$repeater->add_control(
			'audio_track_image',
			[
				'label' => esc_html__( 'Image', 'kws-kmp' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
				'separator'	=> 'before',
			]
		);
		$this->add_control(
			'playlist',
			[
				'type' 		=> Controls_Manager::REPEATER,
				'default' 	=> [
					[
						
					]
				],
				'fields' 		=> $repeater->get_controls(),
				'title_field' 	=> '{{{ title }}}',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_audio_common',
			[
				'label' => esc_html__( 'Common Setting', 'kws-kmp' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'audio_track_image_c',
			[
				'label' => esc_html__( 'Image', 'kws-kmp' ),
				'type' => \Elementor\Controls_Manager::MEDIA,				
				'condition' => [
					'ap_style!' => ['style-micro', 'style-std'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
				'exclude' => [ 'custom' ],
			]
		);
		$this->add_control(
			'split_text',
			[
				'label' 		=> esc_html__( 'Split Text', 'kws-kmp' ),
				'type' 			=> Controls_Manager::TEXT,
				'dynamic' 		=> [ 'active' => true ],
				'label_block' 	=> true,
				'default' 		=> esc_html__( 'by', 'kws-kmp' ),
				'condition' => [
					'ap_style!' => ['style-micro', 'style-std'],
				],
			]
		);
		$this->add_responsive_control(
            'ap_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Max-width', 'kws-kmp'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 200,
						'max' => 2000,
						'step' => 5,
					],
				],				
				'render_type' => 'ui',			
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper' => 'max-width: {{SIZE}}{{UNIT}};margin:0 auto;',
				],				
            ]
        );
		$this->add_control(
			's_volume',
			[
				'label' => esc_html__( 'Default Volume', 'kws-kmp' ),
				'type' => Controls_Manager::SLIDER,				
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 80,
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Song Title', 'kws-kmp'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ap_style!' => 'style-xtended',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'kws-kmp' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .trackDetails .title,{{WRAPPER}} .cf-audio-player-wrapper .title',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .trackDetails .title,{{WRAPPER}} .cf-audio-player-wrapper .title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_author_style',
            [
                'label' => esc_html__('Song Author', 'kws-kmp'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ap_style!' => ['style-micro', 'style-std'],
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'author_typography',
				'label' => esc_html__( 'Typography', 'kws-kmp' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .trackDetails .artist,{{WRAPPER}} .cf-audio-player-wrapper .artist',
			]
		);
		$this->add_control(
			'author_color',
			[
				'label' => esc_html__( 'Author Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .trackDetails .artist,{{WRAPPER}} .cf-audio-player-wrapper .artist' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_split_txt_style',
            [
                'label' => esc_html__('Split Text', 'kws-kmp'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ap_style!' => ['style-micro', 'style-std'],
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'splittext_typography',
				'label' => esc_html__( 'Typography', 'kws-kmp' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .trackDetails .splitTxt,{{WRAPPER}} .cf-audio-player-wrapper .splitTxt',
			]
		);
		$this->add_control(
			'splittext_color',
			[
				'label' => esc_html__( 'Split Text Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .trackDetails .splitTxt,{{WRAPPER}} .cf-audio-player-wrapper .splitTxt' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_player_control_style',
            [
                'label' => esc_html__('Control', 'kws-kmp'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );		
		$this->add_control(
			'player_control_bg_stx',
			[
				'label' => esc_html__( 'Background Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper.style-xtended .controls' => 'background: {{VALUE}}',
				],
				'condition' => [
					'ap_style' => ['style-xtended'],
				],
			]
		);
		$this->add_responsive_control(
				'st_9_br',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-kmp' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .cf-audio-player-wrapper.style-xtended .controls' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],				
				]
			);
		$this->add_control(
			'player_control_color',
			[
				'label' => esc_html__( 'Icon Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .playlistIcon,{{WRAPPER}} .cf-audio-player-wrapper .volumeIcon .vol-icon-toggle,{{WRAPPER}} .cf-audio-player-wrapper .controls' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ap_style!' => [],
				],
			]
		);
		$this->add_responsive_control(
            'player_control_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Size', 'kws-kmp'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
				'render_type' => 'ui',			
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .playlistIcon,
					{{WRAPPER}} .cf-audio-player-wrapper .volumeIcon .vol-icon-toggle,
					{{WRAPPER}} .cf-audio-player-wrapper .controls .rew,
					{{WRAPPER}} .cf-audio-player-wrapper .controls .fwd,
					{{WRAPPER}} .cf-audio-player-wrapper .controls .play,
					{{WRAPPER}} .cf-audio-player-wrapper .controls .pause' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'ap_style!' => [],
				],
            ]
        );
		$this->add_control(
			'pl_list_c_play_i',
			[
				'label' => esc_html__( 'Play/Pause Icon Option', 'kws-kmp' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
            'player_control_play_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Play/Pause Icon Size', 'kws-kmp'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
				'render_type' => 'ui',			
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .controls .play,
					{{WRAPPER}} .cf-audio-player-wrapper .controls .pause' => 'font-size: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_control(
			'player_control_play_color',
			[
				'label' => esc_html__( 'Play/Pause Icon Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .controls .play,
					{{WRAPPER}} .cf-audio-player-wrapper .controls .pause' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'player_control_play_bg_size1',
			[
				'label' => esc_html__( 'Background Size', 'kws-kmp' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .controls .play,{{WRAPPER}} .cf-audio-player-wrapper .controls .pause' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};line-height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .cf-audio-player-wrapper.style-xtend .cf-ap-pp' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
			]
		);		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'player_control_play_bg',
				'label' => esc_html__( 'Background', 'kws-kmp' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .controls .play,
				{{WRAPPER}} .cf-audio-player-wrapper .controls .pause,{{WRAPPER}} .cf-audio-player-wrapper.style-c .cf-ap-pp,{{WRAPPER}} .cf-audio-player-wrapper.style-e .controls .cf-ap-pp,
				{{WRAPPER}} .cf-audio-player-wrapper.style-xtend .cf-ap-pp',
			]
		);		
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'player_control_play_bg_border',
					'label' => esc_html__( 'Border', 'kws-kmp' ),
					'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .controls .play,
									{{WRAPPER}} .cf-audio-player-wrapper .controls .pause',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'player_control_play_bg_br',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-kmp' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .cf-audio-player-wrapper .controls .play,
						{{WRAPPER}} .cf-audio-player-wrapper .controls .pause,
						{{WRAPPER}} .cf-audio-player-wrapper.style-c .cf-ap-pp,
						{{WRAPPER}} .cf-audio-player-wrapper.style-e .controls .cf-ap-pp,
						{{WRAPPER}} .cf-audio-player-wrapper.style-xtend .cf-ap-pp' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'default' => [
					'%' => [
					'top' => '50',
					'right' => '50',
					'bottom' => '50',
					'left' => '50',					
					],
				],
				]
			);
			
			$this->add_control(
				'pl_list_c_playlist_i',
				[
					'label' => esc_html__( 'Playlist Icon Option', 'kws-kmp' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'ap_style!' => ['style-xtend','style-xtended', 'style-micro', 'style-std'],
					],
				]
			);
			$this->add_responsive_control(
				'pl_list_c_playlist_i_size',
				[
					'type' => Controls_Manager::SLIDER,
					'label' => esc_html__('Size', 'kws-kmp'),
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 200,
							'step' => 1,
						],
					],				
					'render_type' => 'ui',			
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .playlistIcon' => 'font-size: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'ap_style!' => ['style-xtend','style-xtended', 'style-std'],
					],
				]
			);
			$this->add_control(
			'pl_list_c_playlist_i_color',
				[
					'label' => esc_html__( 'Playlist Icon Color', 'kws-kmp' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .playlistIcon' => 'color: {{VALUE}}',
					],
					'condition' => [
						'ap_style!' => ['style-xtend', 'style-xtended', 'style-std'],
					],
				]
			);
			$this->add_control(
				'pl_list_c_volume_i',
				[
					'label' => esc_html__( 'Volume Icon Option', 'kws-kmp' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'ap_style!' => ['style-xtend', 'style-xtended', 'style-std'],
					],
				]
				
			);
			$this->add_responsive_control(
				'pl_list_c_volume_i_size',
				[
					'type' => Controls_Manager::SLIDER,
					'label' => esc_html__('Size', 'kws-kmp'),
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 200,
							'step' => 1,
						],
					],				
					'render_type' => 'ui',			
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .volumeIcon .vol-icon-toggle' => 'font-size: {{SIZE}}{{UNIT}}',
					],
					'condition' => [
						'ap_style!' => ['style-xtend','style-xtended'],
					],
				]
			);
			$this->add_control(
			'pl_list_c_volume_i_color',
				[
					'label' => esc_html__( 'Volume Icon Color', 'kws-kmp' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .volumeIcon .vol-icon-toggle' => 'color: {{VALUE}}',
					],
					'condition' => [
						'ap_style!' => ['style-xtend','style-xtended'],
					],
				]
			);
			$this->add_control(
			'pl_list_c_volume_slider_rng_color',
				[
					'label' => esc_html__( 'Volume Slider Range Color', 'kws-kmp' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .volume .ui-slider-range' => 'background: {{VALUE}}',
					],
					'condition' => [
						'ap_style!' => ['style-xtend','style-xtended'],
					],
				]
			);
			$this->add_control(
			'pl_list_c_volume_slider_color',
				[
					'label' => esc_html__( 'Volume Slider Color', 'kws-kmp' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .volume.ui-widget-content' => 'background: {{VALUE}}',
					],
					'condition' => [
						'ap_style!' => ['style-xtend','style-xtended'],
					],
				]
			);
			$this->add_control(
			'pl_list_c_volume_slider_bg',
				[
				'label' => esc_html__( 'Volume Slider Background', 'kws-kmp' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .cf-volume-bg' => 'background: {{VALUE}}',
					],
					'condition' => [
						'ap_style!' => ['style-xtend','style-xtended'],
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pl_list_c_volume_shadow',
				'label' => esc_html__( 'Box Shadow', 'kws-kmp' ),
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .cf-volume-bg',
				'condition' => [
						'ap_style!' => ['style-xtend','style-xtended'],
					],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_audio_tracker',
			[
				'label' => esc_html__( 'Tracker', 'kws-kmp' ),
				'tab' => Controls_Manager::TAB_STYLE,	
				'condition' => [
					'ap_style!' => 'style-xtended',
				],
			]
		);
		$this->add_responsive_control(
            'player_tracker_time',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Time Size', 'kws-kmp'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
				'render_type' => 'ui',			
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .currenttime,
					{{WRAPPER}} .cf-audio-player-wrapper .durationtime' => 'font-size: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'ap_style' => '',
				],
            ]
        );
		$this->add_control(
			'player_tracker_time_color',
			[
				'label' => esc_html__( 'Time Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .currenttime,
					{{WRAPPER}} .cf-audio-player-wrapper .durationtime' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
				'condition' => [
					'ap_style' => '',
				],
			]
		);
		$this->add_responsive_control(
			'tracker_width',
			[
				'label' => esc_html__('Tracker width', 'kws-kmp'),
				'type' => Controls_Manager::SLIDER,				
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper.style-extend .controls,
					{{WRAPPER}} .cf-audio-player-wrapper.style-extend .tracker,
					{{WRAPPER}} .cf-audio-player-wrapper.style-extend .ap-time-seek-vol,
					{{WRAPPER}} .cf-audio-player-wrapper.style-e  .tracker,
					{{WRAPPER}} .cf-audio-player-wrapper.style-c .ap-time-seek-vol,					
					{{WRAPPER}} .cf-audio-player-wrapper.style-micro .main-wrapper-style,					
					{{WRAPPER}} .cf-audio-player-wrapper.style-std .ap-time-title,
					{{WRAPPER}} .cf-audio-player-wrapper.style-std .controls,
					{{WRAPPER}} .cf-audio-player-wrapper.style-std .tracker' => 'width: {{SIZE}}%;',
				],
				'separator' => 'before',
			]
		);		
		$this->add_control(
			'player_tracker_dot_color',
			[
				'label' => esc_html__( 'Dot Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .ui-slider .ui-slider-handle' => 'background: {{VALUE}}',
				],				
			]
		);
		$this->add_control(
			'player_track_color',
			[
				'label' => esc_html__( 'Track Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .ui-widget-content' => 'background: {{VALUE}}',
				],				
			]
		);
		$this->add_control(
			'player_track_fill_color',
			[
				'label' => esc_html__( 'Track Fill Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .tracker .ui-slider-range' => 'background: {{VALUE}}',
				],				
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_trackimage_style',
            [
                'label' => esc_html__('Track Image', 'kws-kmp'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ap_style' => ['style-xtend','style-xtended'],
				],
            ]
        );	
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'trackimg_border',
					'label' => esc_html__( 'Border', 'kws-kmp' ),
					'selector' => '{{WRAPPER}} .cf-audio-player-wrapper.style-c .trackimage img,{{WRAPPER}} .cf-audio-player-wrapper.style-e .ap-st5-img,{{WRAPPER}} .cf-audio-player-wrapper.style-extend .trackimage img,
					{{WRAPPER}} .cf-audio-player-wrapper.style-extended .cf-player .cf-player-hover .cf-player-bg-img',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'trackimg_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-kmp' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .cf-audio-player-wrapper.style-c .trackimage img,{{WRAPPER}} .cf-audio-player-wrapper.style-e .ap-st5-img,{{WRAPPER}} .cf-audio-player-wrapper.style-extend .trackimage img,{{WRAPPER}} .cf-audio-player-wrapper.style-extended .cf-player .cf-player-hover .cf-player-bg-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'trackimg_shadow',
				'label' => esc_html__( 'Box Shadow', 'kws-kmp' ),
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper.style-c .trackimage img,{{WRAPPER}} .cf-audio-player-wrapper.style-e .ap-st5-img,{{WRAPPER}} .cf-audio-player-wrapper.style-extend .trackimage img,{{WRAPPER}} .cf-audio-player-wrapper.style-extended .cf-player .cf-player-hover .cf-player-bg-img',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();		
		$this->start_controls_section(
            'section_playlist_style',
            [
                'label' => esc_html__('PlayList', 'kws-kmp'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ap_style!' => ['style-xtend','style-xtended', 'style-std'],
				],
            ]
        );
		$this->add_responsive_control(
			'playlist_padding',
			[
				'label' => esc_html__( 'Padding', 'kws-kmp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],				
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .playlist li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'playlist_margin',
			[
				'label' => esc_html__( 'Inner Margin', 'kws-kmp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],				
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .playlist li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'playlist_outer_margin',
			[
				'label' => esc_html__( 'Outer Margin', 'kws-kmp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],				
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .playlist' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'playlist_typography',
				'label' => esc_html__( 'Typography', 'kws-kmp' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .playlist li',
				
			]
		);
		$this->start_controls_tabs( 'playlist_n_a' );
			$this->start_controls_tab(
				'playlist_normal',
				[
					'label' => esc_html__( 'Normal', 'kws-kmp' ),					
				]
			);
			$this->add_control(
				'pl_n_color',
				[
					'label' => esc_html__( 'Color', 'kws-kmp' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .playlist li' => 'color: {{VALUE}}',
					],
					
				]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'playlist_active',
				[
					'label' => esc_html__( 'Active', 'kws-kmp' ),					
				]
			);
			$this->add_control(
				'pl_a_color',
				[
					'label' => esc_html__( 'Color', 'kws-kmp' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .playlist li.active' => 'color: {{VALUE}}',
					],
				]
			);	
			$this->add_control(
				'pl_a_bg',
				[
					'label' => esc_html__( 'Background', 'kws-kmp' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .playlist li.active' => 'background-color: {{VALUE}}',
					],
				]
			);	
			$this->end_controls_tab();
		$this->end_controls_tabs();
			$this->add_responsive_control(
				'pl_bg_top_offset',
				[
					'type' => Controls_Manager::SLIDER,
					'label' => esc_html__('Top Offset', 'kws-kmp'),
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'min' => 1,
							'max' => 200,
							'step' => 1,
						],
					],				
					'render_type' => 'ui',			
					'selectors' => [
						'{{WRAPPER}} .cf-audio-player-wrapper .playlist' => 'margin-top: {{SIZE}}{{UNIT}}',
					],				
				]
			);			
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'pl_bg',
					'label' => esc_html__( 'Background', 'kws-kmp' ),
					'types' => [ 'classic', 'gradient'],
					'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .playlist',
					'separator' => 'before',
				]
			);
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'pl_bg_border',
					'label' => esc_html__( 'Border', 'kws-kmp' ),
					'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .playlist',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'pl_bg_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-kmp' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .cf-audio-player-wrapper .playlist' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'pl_bg_shadow',
				'label' => esc_html__( 'Box Shadow', 'kws-kmp' ),
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .playlist',
				'separator' => 'before',
			]
		);	
		$this->end_controls_section();
		$this->start_controls_section(
            'section_player_bg_style',
            [
                'label' => esc_html__('Player Background', 'kws-kmp'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ap_style!' => ['style-xtended'],
				],
            ]
        );
		$this->add_responsive_control(
			'player_padding',
			[
				'label' => esc_html__( 'Padding', 'kws-kmp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],				
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .cf-player' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'ap_style' => ['style-e','style-xtend'],
				],
			]
		);
		$this->add_responsive_control(
			'player_margin',
			[
				'label' => esc_html__( 'Margin', 'kws-kmp' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],				
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper .cf-player' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'ap_style' => ['style-e'],
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'player_bg',
				'label' => esc_html__( 'Background', 'kws-kmp' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .cf-player',
				'condition' => [
					'ap_style!' => ['style-xtend','style-xtended'],
				],
			]
		);
		$this->add_control(
			'player_bg_overlay',
			[
				'label' => esc_html__( 'Background Overlay Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper.style-d .cf-player' => 'box-shadow:0 0 500px  {{VALUE}} inset;',
				],
				'condition' => [
					'ap_style' => [],
				],
			]
		);
		$this->add_control(
			'player_img_bg_overlay',
			[
				'label' => esc_html__( 'Background Image Overlay Color', 'kws-kmp' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper.style-f .ap-st5-content' => 'box-shadow:0 0 500px  {{VALUE}} inset;',
				],
				'condition' => [
					'ap_style' => [],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'player_img_bg_css_filters',
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper.style-extend .cf-player-bg-img',
				'condition' => [
					'ap_style' => ['style-xtend'],
				],				
			]
		);
		$this->add_control(
			'background_position',
			[
				'label' => esc_html__( 'Background Position', 'kws-kmp' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => kmp_get_image_position_options(),
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper.style-d .cf-player,
					{{WRAPPER}} .cf-audio-player-wrapper.style-f .ap-st5-content,
					{{WRAPPER}} .cf-audio-player-wrapper.style-extend .cf-player-bg-img' => 'background-position:{{VALUE}} !important;',
				],
				'condition' => [
					'ap_style' => ['style-xtend'],
				],
			]
		);
		$this->add_control(
			'background_repeat',
			[
				'label' => esc_html__( 'Background Repeat', 'kws-kmp' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'no-repeat',
				'options' => kmp_get_image_reapeat_options(),
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper.style-d .cf-player,
					{{WRAPPER}} .cf-audio-player-wrapper.style-f .ap-st5-content,
					{{WRAPPER}} .cf-audio-player-wrapper.style-extend .cf-player-bg-img' => 'background-repeat:{{VALUE}} !important;',
				],
				'condition' => [
					'ap_style' => ['style-xtend'],
				],
			]
		);
		$this->add_control(
			'background_size',
			[
				'label' => esc_html__( 'Background Size', 'kws-kmp' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => kmp_get_image_size_options(),
				'selectors' => [
					'{{WRAPPER}} .cf-audio-player-wrapper.style-d .cf-player,
					{{WRAPPER}} .cf-audio-player-wrapper.style-f .ap-st5-content,
					{{WRAPPER}} .cf-audio-player-wrapper.style-extend .cf-player-bg-img' => 'background-size:{{VALUE}} !important;',
				],
				'condition' => [
					'ap_style' => ['style-xtend'],
				],
			]
		);
		
		$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'player_border',
					'label' => esc_html__( 'Border', 'kws-kmp' ),
					'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .cf-player',
					'separator' => 'before',
				]
			);
			$this->add_responsive_control(
				'player_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'kws-kmp' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .cf-audio-player-wrapper .cf-player' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'player_bg_shadow',
				'label' => esc_html__( 'Box Shadow', 'kws-kmp' ),
				'selector' => '{{WRAPPER}} .cf-audio-player-wrapper .cf-player',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
		
		/*--On Scroll View Animation ---*/
		include KMP_PATH. 'modules/widgets/kmp-widget-animation.php';

	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$ap_style = $settings['ap_style'];
		$uid_widget=uniqid("ap");
		$split_text =$settings['split_text'];		
		$s_volume = (isset($settings['s_volume']['size'])) ? $settings['s_volume']['size'] : 80;
		
			/*--On Scroll View Animation ---*/
			include KMP_PATH. 'modules/widgets/kmp-widget-animation-attr.php';

			/*--Kmp Extra ---*/
			$KmpExtra_Class = "kmp-audio-player-widget";
			include KMP_PATH. 'modules/widgets/kmp-widgets-extra.php';

			$ap_trackdetails_splittxt='<span class="splitTxt"> '.esc_html($split_text).' </span>';
			$ap_play_pause ='<div class="cf-ap-pp"><div class="play"><i class="fas fa-play" aria-hidden="true"></i></div><div class="pause"><i class="fas fa-pause" aria-hidden="true"></i></div></div>';
			$ap_rew='<div class="rew"><i class="fas fa-backward" aria-hidden="true"></i></div>';
			$ap_fwd='<div class="fwd"><i class="fas fa-forward" aria-hidden="true"></i></div>';
			$ap_skiprew='<div class="skiprew"><i class="icon-rev-10" aria-hidden="true"></i></div>';
			$ap_skipfwd='<div class="skipfwd"><i class="icon-fwd-10" aria-hidden="true"></i></div>';
			$ap_endtime ='<div class="durationtime"></div>';
			$ap_currenttime ='<div class="currenttime">00:00</div>';
			$ap_tracker='<div class="tracker"></div>';
			$ap_volume='<div class="volumeIcon"><i class="fas fa-volume-up vol-icon-toggle" aria-hidden="true"></i><div class="cf-volume-bg"><div class="volume"></div></div></div>';
			$ap_playlisticon ='<div class="playlistIcon"><i class="fas fa-list" aria-hidden="true"></i></div>';

			$i=0;
			$ap_trackdetails_title=$ap_trackdetails_artist=$ap_img='';
			$ap_playlist='<ul class="playlist" id="playlist">';

			foreach ( $settings['playlist'] as $item ) {
				$audiourl=$thumb_img='';
				
				if(!empty($item['audio_source']) && $item['audio_source'] == 'file'){
					$audiourl=$item['source_mp3']['url'];
				}else if(!empty($item['audio_source']) && $item['audio_source'] == 'url'){
					$audiourl=$item['source_mp3_url']['url'];
				}
				
				if(!empty($item['audio_track_image']['id'])){
					$image_id=$item['audio_track_image']['id'];
					$thumb_img=wp_get_attachment_image_src($image_id, $settings['thumbnail_size']);					
					$thumb_img= isset($thumb_img[0]) ? $thumb_img[0] : '';
				}else if(!empty($settings['audio_track_image_c']['url'])){					
					$image_id=$settings['audio_track_image_c']['id'];
					$thumb_img=wp_get_attachment_image_src($image_id, $settings['thumbnail_size']);					
					$thumb_img= isset($thumb_img[0]) ? $thumb_img[0] : '';
				}else{
					$thumb_img=KMP_ASSETS_URL.'images/placeholder-grid.jpg';
				}
				
				if($i==0){ 
					$ap_trackdetails_title='<span class="title">'.esc_html($item['title']).'</span>';
					$ap_trackdetails_artist='<span class="artist">'.esc_html($item['author']).'</span>';
					if(!empty($item['audio_track_image']['url'])){
						$image_id=$item['audio_track_image']['id'];
						$ap_img=wp_get_attachment_image_src($image_id, $settings['thumbnail_size']);
						$ap_img= isset($ap_img[0]) ? $ap_img[0] : '';
					}elseif(!empty($settings['audio_track_image_c']['url'])) {	
						$image_id=$settings['audio_track_image_c']['id'];
						$ap_img=wp_get_attachment_image_src($image_id, $settings['thumbnail_size']);
						$ap_img= isset($ap_img[0]) ? $ap_img[0] : '';
					}else{
						$ap_img=KMP_ASSETS_URL.'images/placeholder-grid.jpg';
					}
				}
				
				$ap_playlist.='<li audioURL="'.esc_url($audiourl).'" audioTitle="'.esc_html($item['title']).'" artist="'.esc_attr($item['author']).'"  data-thumb="'.esc_url($thumb_img).'">'.esc_html($item['title']).'</li>';
				$i++;				
			}
			$ap_playlist.='</ul>';

			$audio_player = '<div class="cf-audio-player-wrapper '.esc_attr($uid_widget).' '.esc_attr($ap_style).' '.$animated_class.'" '.$animation_attr.' data-id="'.esc_attr($uid_widget).'" data-style="'.esc_attr($ap_style).'" data-apvolume="'.esc_attr($s_volume).'">';
			if($ap_style=='style-c'){
				$audio_player .= '<div class="cf-player">';
					$audio_player .= $ap_playlisticon;
					$audio_player .= '<div class="trackimage"> <img src="'.esc_url($ap_img).'"></div>';
					$audio_player .= '<div class="trackDetails ">'.$ap_trackdetails_title.' '.$ap_trackdetails_splittxt.' '.$ap_trackdetails_artist.'</div>';
					$audio_player .= '<div class="controls"> '.$ap_rew.' '.$ap_play_pause.' '.$ap_fwd.' </div>';
					$audio_player .= '<div class="ap-time-seek-vol">'.$ap_volume;					
					$audio_player .= '<div class="ap-time">'.$ap_currenttime;
					$audio_player .= $ap_endtime.'</div>';
					$audio_player .= $ap_tracker;
				$audio_player .= '</div></div>';
				$audio_player .= $ap_playlist;
			}else if($ap_style=='style-e'){
				$audio_player .= '<div class="cf-player">';
						$audio_player .= $ap_playlisticon;						
						$audio_player .= '<div class="ap-st5-img" style="background:url('.$ap_img.');"></div>';						
						$audio_player .= '<div class="ap-st5-content">';
								$audio_player .= '<div class="ap-controls-track"><div class="controls">'.$ap_play_pause.' <div class="ap-nextprev"> '.$ap_rew.'  '.$ap_fwd.' </div></div>';
								$audio_player .= $ap_tracker.'</div>';
								$audio_player .= '<div class="trackDetails ">'.$ap_trackdetails_title.' '.$ap_trackdetails_splittxt.' '.$ap_trackdetails_artist.'</div>';						
						$audio_player .= '</div>';
						$audio_player .= $ap_volume;
				$audio_player .= '</div>';
				$audio_player .= $ap_playlist;
			}else if($ap_style=='style-xtend'){
				$audio_player .= '<div class="cf-player">';
					$audio_player .= '<div class="cf-player-bg-img"></div>';					
					$audio_player .= '<div class="trackimage"> <img src="'.esc_url($ap_img).'"></div>';
					$audio_player .= '<div class="trackDetails ">'.$ap_trackdetails_title.' '.$ap_trackdetails_artist.'</div>';
					$audio_player .= '<div class="controls"> '.$ap_rew.' '.$ap_play_pause.' '.$ap_fwd.' </div>';					
					$audio_player .= $ap_tracker;
					$audio_player .= '<div class="ap-time-seek-vol">';
					$audio_player .= '<div class="ap-time">'.$ap_currenttime;
					$audio_player .= $ap_endtime.'</div>';
				$audio_player .= '</div></div>';
				$audio_player .= $ap_playlist;
			}else if($ap_style=='style-xtended'){
				$audio_player .= '<div class="cf-player">';
					$audio_player .= '<div class="cf-player-hover">';
					$audio_player .= '<div class="cf-player-bg-img" style="background:url('.$ap_img.');"><div class="trackDetails ">'.$ap_trackdetails_title.' '.$ap_trackdetails_artist.'</div></div>';
					$audio_player .= '<div class="controls"> '.$ap_rew.' '.$ap_play_pause.' '.$ap_fwd.' </div>';
				$audio_player .= '</div>';
				
				$audio_player .= '</div>';
				$audio_player .= $ap_playlist;
			}else if($ap_style=='style-micro'){
				$audio_player .= '<div class="cf-player">';				
						$audio_player .= '<div class="main-wrapper-style">';					
							$audio_player .= '<div class="controls">';					
								$audio_player .= $ap_play_pause;					
							$audio_player .= '</div>';							
							$audio_player .= $ap_tracker;
							$audio_player .= $ap_volume;
							$audio_player .= '</div>';
				$audio_player .= '</div>';
				$audio_player .= $ap_playlist;						
			}else if($ap_style=='style-std'){
				$audio_player .= '<div class="cf-player">';
					$audio_player .= '<div class="cf-player-top">';
						$audio_player .= $ap_tracker;
						$audio_player .= $ap_volume;
					$audio_player .= '</div>';
						//$audio_player .= '<div class="ap-time-title"> '.$ap_currenttime.' ' . '<div class="controls"> '.$ap_rew.' '.$ap_play_pause.' '.$ap_fwd.' </div>' .' '.$ap_endtime.' </div>';
						$audio_player .= '<div class="ap-time-title"> '.$ap_currenttime.' ' . '<div class="controls"> '.$ap_skiprew.' '.$ap_play_pause.' '.$ap_skipfwd.' </div>' .' '.$ap_endtime.' </div>';
				$audio_player .= '</div>';
				$audio_player .= $ap_playlist;
			}
			$audio_player .= '</div>';	
		
			echo $before_content.$audio_player.$after_content;
	}
}