<?php
namespace KwsMediaPlayer\Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Background;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$this->start_controls_section(
    'section_animation_styling',
    [
        'label'=>esc_html__('On Scroll View Animation', 'kws-kmp'),
        'tab'=>Controls_Manager::TAB_STYLE,
    ]
);
$this->add_control(
    'animation_effects',
    [
        'label'=>esc_html__('In Animation Effect', 'kws-kmp'),
        'type'=>Controls_Manager::SELECT,
        'default'=>'no-animation',
        'options'=>kmp_get_animation_options(),
    ]
);
$this->add_control(
    'animation_delay',
    [
        'type'=>Controls_Manager::SLIDER,
        'label'=>esc_html__('Animation Delay', 'kws-kmp'),
        'default'=>[
            'unit'=>'',
            'size'=>50,
        ],
        'range'=>[
            ''=>[
                'min'=>0,
                'max'=>4000,
                'step'=>15,
            ],
        ],
        'condition'=>[
            'animation_effects!'=>'no-animation',
        ],
    ]
);

if(!empty($Kmp_Listing_block) && $Kmp_Listing_block == "Kmp_Listing_block"){
    $this->add_control(
        'animated_column_list',
        [
            'label'=>esc_html__('List Load Animation','kws-kmp'),
            'type'=>Controls_Manager::SELECT,
            'default'=>'',
            'options'=>[
                ''=> esc_html__('Content Animation Block','kws-kmp'),
                'stagger'=>esc_html__('Stagger Based Animation','kws-kmp'),
                'columns'=>esc_html__('Columns Based Animation','kws-kmp'),
            ],
            'condition'    => [
                'animation_effects!' => [ 'no-animation' ],
            ],
        ]
    );
    $this->add_control(
        'animation_stagger',
        [
            'type'=>Controls_Manager::SLIDER,
            'label'=>esc_html__('Animation Stagger', 'kws-kmp'),
            'default'=>[
                'unit'=>'',
                'size'=>150,
            ],
            'range'=>[
                '' => [
                    'min'=>0,
                    'max'=>6000,
                    'step'=>10,
                ],
            ],				
            'condition'=>[
                'animation_effects!'=>['no-animation'],
                'animated_column_list'=>'stagger',
            ],
        ]
    );
}

$this->add_control(
    'animation_duration_default',
    [
        'label' => esc_html__( 'Animation Duration', 'kws-kmp' ),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'no',
        'condition' => [
            'animation_effects!' => 'no-animation',
        ],
    ]
);
$this->add_control(
    'animate_duration',
    [
        'type'=>Controls_Manager::SLIDER,
        'label'=>esc_html__('Duration Speed', 'kws-kmp'),
        'default'=>[
            'unit'=>'px',
            'size'=>50,
        ],
        'range'=>[
            'px'=>[
                'min'=>100,
                'max'=>10000,
                'step'=>100,
            ],
        ],
        'condition' => [
            'animation_effects!'=>'no-animation',
            'animation_duration_default'=>'yes',
        ],
    ]
);
$this->add_control(
    'animation_out_effects',
    [
        'label'=>esc_html__( 'Out Animation Effect', 'kws-kmp' ),
        'type'=>Controls_Manager::SELECT,
        'default'=>'no-animation',
        'options'=>kmp_get_out_animation_options(),
        'separator'=>'before',
        'condition'=>[
            'animation_effects!'=>'no-animation',
        ],
    ]
);
$this->add_control(
    'animation_out_delay',
    [
        'type'=>Controls_Manager::SLIDER,
        'label'=>esc_html__('Out Animation Delay', 'kws-kmp'),
        'default'=>[
            'unit'=>'',
            'size'=>50,
        ],
        'range'=>[
            ''=>[
                'min'=>0,
                'max'=>4000,
                'step'=>15,
            ],
        ],
        'condition' => [
            'animation_effects!'=>'no-animation',
            'animation_out_effects!'=>'no-animation',
        ],
    ]
);
$this->add_control(
    'animation_out_duration_default',
    [
        'label'=>esc_html__('Out Animation Duration','kws-kmp'),
        'type'=>Controls_Manager::SWITCHER,
        'default'=>'no',
        'condition'=>[
            'animation_effects!'=>'no-animation',
            'animation_out_effects!'=>'no-animation',
        ],
    ]
);
$this->add_control(
    'animation_out_duration',
    [
        'type'=>Controls_Manager::SLIDER,
        'label'=>esc_html__('Duration Speed', 'kws-kmp'),
        'default'=>[
            'unit'=>'px',
            'size'=>50,
        ],
        'range'=>[
            'px'=>[
                'min'=>100,
                'max'=>10000,
                'step'=>100,
            ],
        ],
        'condition'=>[
            'animation_effects!'=>'no-animation',
            'animation_out_effects!'=>'no-animation',
            'animation_out_duration_default'=>'yes',
        ],
    ]
);
$this->end_controls_section();
