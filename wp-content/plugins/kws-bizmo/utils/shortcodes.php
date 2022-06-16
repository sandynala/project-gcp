<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}



function self_hosted_ad( $atts ) {
    $a = shortcode_atts( array(
        'id' => '2110333a1ca8b36294327fcf0e68fb67',
        'zoneid' => '4',
        'source' => '//sas.happiesthealth.test/www/delivery/asyncjs.php',
    ), $atts );
 
    $output = '<ins data-revive-zoneid="' . esc_attr( $a[zoneid] ) . '" data-revive-id="' . esc_attr( $a['id'] ) . '"></ins><script async src="' . esc_url( $a['source'] ) . '"></script>';
    return $output;
}
add_shortcode( 'ads', 'self_hosted_ad' );


function shortcode_formatted_field( $atts ) {
    $atts = shortcode_atts( array(
        'field' => '',
        'format' => '',
    ), $atts );

    if ( !empty( $atts['field'] ) ) {
        $field = $atts['field'];
    } else {
        return '';
    }

    if ( !empty( $atts['format'] ) ) {
        $date_format = $atts['format'];
    } else {
        $date_format = 'j Y';
    }

    $field_value = get_field($field, get_the_id(), false);

    $value = date_i18n($date_format, strtotime($field_value));
    return $value;
}
add_shortcode( 'date_field', 'shortcode_formatted_field' );






function shortcode_get_type_of_post( $atts ) {
    $post_type = get_post_type();
    
    switch ($post_type) {
        case "articles":
            $post_name = "Article";
            break;

        case "videos":
            $post_name = "Video";
            break;

        case "podcasts":
            $post_name = "Podcast";
            break;

        case "webinars":
        case "recorded-webinars":
            $post_name = "Webinar";
            break;
        
        case "discussions":
            $post_name = "Discussion";
            break;
        
        case "healthcards":
            $post_name = "Health Card";
            break;

        case "testimonials":
                $post_name = "Testimonial";
                break;

        default:
            $post_name = "Unknown";
            break;
    }

    return $post_name;
}
add_shortcode( 'current_post_type', 'shortcode_get_type_of_post' );



function shortcode_get_post_counts( $atts ) {
    $atts = shortcode_atts( array(
        'type' => 'post',
    ), $atts );


    if ( !empty( $atts['type'] ) ) {
        $post_type = $atts['type'];
    } else {
        $post_type = 'post';
    }

    $key = '';
    $meta_ex = '';
    $post_count = -1;
    switch ($post_type) {
        case 'home-hero':
            $post_type = 'articles';
            $meta_ex = array(
                'mta' => "mta.meta_key = 'show_in_homepage' AND mta.meta_value = 1",
            );
            break;

        case 'home-discussions':
            $post_type = 'discussions';
            break;
        

        case 'any-webinars':
            $cur_time = current_time( 'Y-m-d H:i', false );
            $meta_ex = array(
                'mta' => "mta.meta_key = 'show_in_homepage' AND mta.meta_value = 1",
                'mtb' => "mtb.meta_key = 'end_time' AND mtb.meta_value >= '" . $cur_time . "'",
            );
            $post_count = kws_count_posts( 'webinars', $meta_ex, $key );
            $post_count += kws_count_posts( 'recorded-webinars', '', 'recorded-' . $key );
            break;

        case 'upcoming-webinars':
            $key = 'item-count';
            $post_type = 'webinars';

            $cur_time = current_time( 'Y-m-d H:i', false );
            $meta_ex = array(
                'mta' => "mta.meta_key = 'show_in_homepage' AND mta.meta_value = 1",
                'mtb' => "mtb.meta_key = 'end_time' AND mtb.meta_value >= '" . date_i18n("Y-m-d H:i", $cur_time) . "'",
            );
            /*
            $cur_time = current_time( 'timestamp', false );
            $meta_ex = array(
                'relation' => 'AND',
                'page_show_in_homepage' => array(
                    'key'       => 'show_in_homepage',
                    'compare'   => '=',
                    'value'     => '1',
                ),
                'page_end_time' => array(
                    'key'       => 'end_time',
                    'value'     => date_i18n("Y-m-d H:i", $cur_time), // date("Y-m-d H:i"),
                    'compare'   => '>=',
                    'type'      => 'DATETIME',
                ),
            );
            */
            break;
        
        case 'recorded-webinars':
            $key = 'item-count';
            $post_type = 'recorded-webinars';
            $meta_ex = array(
                'mta' => "mta.meta_key = 'show_in_homepage' AND mta.meta_value = 1",
            );
            break;

        default:
            break;
    }

    if($post_count < 0) {
        $post_count = kws_count_posts( $post_type, $meta_ex, $key );
    }
    return $post_count;
}
add_shortcode( 'get_post_counts', 'shortcode_get_post_counts' );


function author_img ($post_id) {

    $post_type = get_post_type();

    if($post_type === 'webinars'){

        $image = get_field('speaker_photo', $post_id);

    }elseif($post_type === 'podcasts' || $post_type === 'testimonials' || $post_type === 'podcasts' || $post_type === 'discussions'){

        $image = get_field('author_photo', $post_id);

    }
    $size = 'thumbnail'; // (thumbnail, medium, large, full or custom size)

    if( $image ) {

        echo wp_get_attachment_image( $image, $size );

    }

}

add_shortcode( 'shortcode_author_img', 'author_img' );

