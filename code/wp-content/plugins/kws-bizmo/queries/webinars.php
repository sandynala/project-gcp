<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'elementor/query/upcoming_webinars_archive', 'query_upcoming_webinars_archive');
function query_upcoming_webinars_archive( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'webinars' ] ); 
    
    $cur_time = current_time( 'timestamp', false );
    $meta_query = array(
        'end_time' => array(
            'key'       => 'end_time',
            'value'     => date_i18n("Y-m-d H:i", $cur_time), // date("Y-m-d H:i"),
            'compare'   => '>=',
            'type'      => 'DATETIME',
        ),
    );
    $query->set( 'meta_query', $meta_query );
    // set the new orderby
    $query->set('orderby', [
        'end_time'  => 'ASC',
    ]);
}


add_action( 'elementor/query/recorded_webinars_archive', 'query_recorded_webinars_archive');
function query_recorded_webinars_archive( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'recorded-webinars' ] ); 
    
    $cur_time = current_time( 'timestamp', false );
    $meta_query = array(
        'end_time' => array(
            'key'       => 'end_time',
            //'value'     => date_i18n("Y-m-d H:i", $cur_time), // date("Y-m-d H:i"),
            //'compare'   => '<',
            'compare'   => 'EXISTS',
            'type'      => 'DATE',
        ),
    );
    $query->set( 'meta_query', $meta_query );
    // set the new orderby
    $query->set('orderby', [
        'end_time'  => 'DESC',
    ]);
}




function shortcode_get_webinar_live_pill( $atts ) {
    $post_type = get_post_type();
    if( $post_type !== 'webinars') {
        return '';
    }

    $atts = shortcode_atts( array(
        'content' => '',
        //'format' => '',
    ), $atts );

    if ( !empty( $atts['content'] ) ) {
        $inner_content = $atts['content'];
    } else {
        $inner_content = 'Live Event';
    }
    //date_default_timezone_set('Asia/Kolkata'); 
    $the_post_id = get_the_ID();
    $stdate = strtr(get_field( 'start_time', $the_post_id ), '/', '-');
    $endate = strtr(get_field( 'end_time', $the_post_id ), '/', '-');
    //echo date( 'd-m-Y H:i:s', strtotime($stdate))."<br>";
    $newSDate = date("d-m-Y H:i", strtotime($stdate));
    $newEDate = date("d-m-Y H:i", strtotime($endate));

    //echo date('Y-m-d H:i:s').'<br>';
    
    /*$start_time = strtotime(get_field('start_time'));
    $end_time = strtotime(get_field('end_time'));*/
    $start_time = strtotime($newSDate).'<br>';
    $end_time = strtotime($newEDate).'<br>';
    //$curr_date = $newSDate = date("d-m-Y H:i");
    //$today_edate = $newSDate = date("d-m-Y H:i");

    $cur_time = current_time( 'timestamp', false ).'<br>';
    if( $cur_time >= $start_time && $cur_time <= $end_time ) {
        $pill_content = '<div class="webinar-live-pill">' . $inner_content . '</div>';
    }
    else {
        $pill_content = '';
    }

    return $pill_content;
}
add_shortcode( 'webinar_live_pill', 'shortcode_get_webinar_live_pill' );