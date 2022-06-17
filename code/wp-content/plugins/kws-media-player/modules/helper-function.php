<?php
namespace KwsMediaPlayer\Widgets;

if ( ! defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly



function kmp_get_image_position_options()
{
    return array(
        '' => esc_html__( 'Default','kws-kmp' ),
		'top left' => esc_html__( 'Top Left','kws-kmp' ),
		'top center' => esc_html__( 'Top Center','kws-kmp' ),
		'top right' => esc_html__( 'Top Right','kws-kmp' ),
		'center left' => esc_html__( 'Center Left','kws-kmp' ),
		'center center' => esc_html__( 'Center Center','kws-kmp' ),
		'center right' => esc_html__( 'Center Right', 'kws-kmp' ),
		'bottom left' => esc_html__( 'Bottom Left', 'kws-kmp' ),
		'bottom center' => esc_html__( 'Bottom Center','kws-kmp' ),
		'bottom right' => esc_html__( 'Bottom Right','kws-kmp' ),
    );
}
function kmp_get_image_reapeat_options()
{
    return array(
        '' => esc_html__( 'Default', 'kws-kmp' ),
		'no-repeat' => esc_html__( 'No-repeat', 'kws-kmp' ),
		'repeat' => esc_html__( 'Repeat', 'kws-kmp' ),
		'repeat-x' => esc_html__( 'Repeat-x','kws-kmp' ),
		'repeat-y' => esc_html__( 'Repeat-y','kws-kmp' ),
    );
}
function kmp_get_image_size_options()
{
    return array(
        '' => esc_html__( 'Default', 'kws-kmp' ),
		'auto' => esc_html__( 'Auto', 'kws-kmp' ),
		'cover' => esc_html__( 'Cover', 'kws-kmp' ),
		'contain' => esc_html__( 'Contain', 'kws-kmp' ),
    );
}


function kmp_get_animation_options()
{
    return array(
        'no-animation' => esc_html__( 'No-animation', 'kws-kmp' ),
		'transition.fadeIn' => esc_html__( 'FadeIn', 'kws-kmp' ),
		'transition.flipXIn' => esc_html__( 'FlipXIn', 'kws-kmp' ),
		'transition.flipYIn' => esc_html__( 'FlipYIn', 'kws-kmp' ),
		'transition.flipBounceXIn' => esc_html__( 'FlipBounceXIn', 'kws-kmp' ),
		'transition.flipBounceYIn' => esc_html__( 'FlipBounceYIn', 'kws-kmp' ),
		'transition.swoopIn' => esc_html__( 'SwoopIn', 'kws-kmp' ),
		'transition.whirlIn' => esc_html__( 'WhirlIn', 'kws-kmp' ),
		'transition.shrinkIn' => esc_html__( 'ShrinkIn', 'kws-kmp' ),
		'transition.expandIn' => esc_html__( 'ExpandIn', 'kws-kmp' ),
		'transition.bounceIn' => esc_html__( 'BounceIn', 'kws-kmp' ),
		'transition.bounceUpIn' => esc_html__( 'BounceUpIn', 'kws-kmp' ),
		'transition.bounceDownIn' => esc_html__( 'BounceDownIn', 'kws-kmp' ),
		'transition.bounceLeftIn' => esc_html__( 'BounceLeftIn', 'kws-kmp' ),
		'transition.bounceRightIn' => esc_html__( 'BounceRightIn', 'kws-kmp' ),
		'transition.slideUpIn' => esc_html__( 'SlideUpIn', 'kws-kmp' ),
		'transition.slideDownIn' => esc_html__( 'SlideDownIn', 'kws-kmp' ),
		'transition.slideLeftIn' => esc_html__( 'SlideLeftIn', 'kws-kmp' ),
		'transition.slideRightIn' => esc_html__( 'SlideRightIn', 'kws-kmp' ),
		'transition.slideUpBigIn' => esc_html__( 'SlideUpBigIn', 'kws-kmp' ),
		'transition.slideDownBigIn' => esc_html__( 'SlideDownBigIn', 'kws-kmp' ),
		'transition.slideLeftBigIn' => esc_html__( 'SlideLeftBigIn', 'kws-kmp' ),
		'transition.slideRightBigIn' => esc_html__( 'SlideRightBigIn', 'kws-kmp' ),
		'transition.perspectiveUpIn' => esc_html__( 'PerspectiveUpIn', 'kws-kmp' ),
		'transition.perspectiveDownIn' => esc_html__( 'PerspectiveDownIn', 'kws-kmp' ),
		'transition.perspectiveLeftIn' => esc_html__( 'PerspectiveLeftIn', 'kws-kmp' ),
		'transition.perspectiveRightIn' => esc_html__( 'PerspectiveRightIn', 'kws-kmp' ),
    );
	
}
function kmp_get_out_animation_options()
{
    return array(
        'no-animation' => esc_html__( 'No-animation', 'kws-kmp' ),
		'transition.fadeOut' => esc_html__( 'FadeOut', 'kws-kmp' ),
		'transition.flipXOut' => esc_html__( 'FlipXOut', 'kws-kmp' ),
		'transition.flipYOut' => esc_html__( 'FlipYOut', 'kws-kmp' ),
		'transition.flipBounceXOut' => esc_html__( 'FlipBounceXOut', 'kws-kmp' ),
		'transition.flipBounceYOut' => esc_html__( 'FlipBounceYOut', 'kws-kmp' ),
		'transition.swoopOut' => esc_html__( 'SwoopOut', 'kws-kmp' ),
		'transition.whirlOut' => esc_html__( 'WhirlOut', 'kws-kmp' ),
		'transition.shrinkOut' => esc_html__( 'ShrinkOut', 'kws-kmp' ),
		'transition.expandOut' => esc_html__( 'ExpandOut', 'kws-kmp' ),
		'transition.bounceOut' => esc_html__( 'BounceOut', 'kws-kmp' ),
		'transition.bounceUpOut' => esc_html__( 'BounceUpOut', 'kws-kmp' ),
		'transition.bounceDownOut' => esc_html__( 'BounceDownOut', 'kws-kmp' ),
		'transition.bounceLeftOut' => esc_html__( 'BounceLeftOut', 'kws-kmp' ),
		'transition.bounceRightOut' => esc_html__( 'BounceRightOut', 'kws-kmp' ),
		'transition.slideUpOut' => esc_html__( 'SlideUpOut', 'kws-kmp' ),
		'transition.slideDownOut' => esc_html__( 'SlideDownOut', 'kws-kmp' ),
		'transition.slideLeftOut' => esc_html__( 'SlideLeftOut', 'kws-kmp' ),
		'transition.slideRightOut' => esc_html__( 'SlideRightOut', 'kws-kmp' ),
		'transition.slideUpBigOut' => esc_html__( 'SlideUpBigOut', 'kws-kmp' ),
		'transition.slideDownBigOut' => esc_html__( 'SlideDownBigOut', 'kws-kmp' ),
		'transition.slideLeftBigOut' => esc_html__( 'SlideLeftBigOut', 'kws-kmp' ),
		'transition.slideRightBigOut' => esc_html__( 'SlideRightBigOut', 'kws-kmp' ),
		'transition.perspectiveUpOut' => esc_html__( 'PerspectiveUpOut', 'kws-kmp' ),
		'transition.perspectiveDownOut' => esc_html__( 'PerspectiveDownOut', 'kws-kmp' ),
		'transition.perspectiveLeftOut' => esc_html__( 'PerspectiveLeftOut', 'kws-kmp' ),
		'transition.perspectiveRightOut' => esc_html__( 'PerspectiveRightOut', 'kws-kmp' ),
    );
	
}