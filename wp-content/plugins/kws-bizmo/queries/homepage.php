<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

function query_hero_articles( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'articles' ] ); 

	// Get current meta Query
	$meta_query = $query->get( 'meta_query' );

	// If there is no meta query when this filter runs, it should be initialized as an empty array.
	if ( ! $meta_query ) {
		$meta_query = [];
	}
    
    // add our condition to the meta_query
    $meta_query = array(
        'relation' => 'AND',
        'page_show_in_homepage' => array(
            'key'       => 'show_in_homepage',
            'compare'   => '=',
            'value'     => '1',
        ),
        'page_display_order' => array(
            'key'       => 'display_order',
            'compare'   => 'EXISTS',
            'type'      => 'NUMERIC',
        ),
    );
    

	$query->set( 'meta_query', $meta_query );

    // set the new orderby
    $query->set('orderby', [
        'page_display_order'  => 'ASC',
        'post_date'  => 'DESC',
    ]);
}
add_action( 'kws_elementor_kit_pro/query/hero_articles', 'query_hero_articles');




add_action( 'elementor/query/home_discussions', 'query_home_discussions');
function query_home_discussions( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'discussions' ] ); 
    $query->set( 'meta_query', '' );
    $query->set('orderby', [
        'post_date'  => 'DESC',
    ]);
}

add_action( 'elementor/query/home_infographics', 'query_home_infographics');
function query_home_infographics( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'infographic_cards' ] ); 
    
    $meta_query = array(
        'page_show_in_homepage' => array(
            'key'       => 'show_in_homepage',
            'compare'   => '=',
            'value'     => '1',
        ),
    );
    $query->set( 'meta_query', $meta_query );
}


add_action( 'elementor/query/home_podcasts', 'query_home_podcasts');
function query_home_podcasts( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'podcasts' ] ); 

    $meta_query = array(
        'page_show_in_homepage' => array(
            'key'       => 'show_in_homepage',
            'compare'   => '=',
            'value'     => '1',
        ),
    );
    $query->set( 'meta_query', $meta_query );
}

add_action( 'elementor/query/home_videos', 'query_home_videos');
function query_home_videos( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'videos' ] ); 
    
    $meta_query = array(
        'page_show_in_homepage' => array(
            'key'       => 'show_in_homepage',
            'compare'   => '=',
            'value'     => '1',
        ),
    );
    $query->set( 'meta_query', $meta_query );
}

add_action( 'elementor/query/home_testimonials', 'query_home_testimonials');
function query_home_testimonials( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'testimonials' ] ); 
    
    $meta_query = array(
        'page_show_in_homepage' => array(
            'key'       => 'show_in_homepage',
            'compare'   => '=',
            'value'     => '1',
        ),
    );
    $query->set( 'meta_query', $meta_query );
}

add_action( 'elementor/query/home_upcoming_webinars', 'query_home_upcoming_webinars');
function query_home_upcoming_webinars( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'webinars' ] ); 
    
    $cur_time = current_time( 'timestamp', false );
    $meta_query = array(
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
    $query->set( 'meta_query', $meta_query );
    // set the new orderby
    $query->set('orderby', [
        'page_end_time'  => 'ASC',
    ]);
}


add_action( 'elementor/query/home_recorded_webinars', 'query_home_recorded_webinars');
function query_home_recorded_webinars( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'recorded-webinars' ] ); 
    
    $cur_time = current_time( 'timestamp', false );
    $meta_query = array(
        'relation' => 'AND',
        'page_show_in_homepage' => array(
            'key'       => 'show_in_homepage',
            'compare'   => '=',
            'value'     => '1',
        ),
        /*
        'page_end_time' => array(
            'key'       => 'end_time',
            'value'     => date_i18n("Y-m-d H:i", $cur_time), // date("Y-m-d H:i"),
            'compare'   => '<',
            'type'      => 'DATETIME',
        ),
        */
    );
    $query->set( 'meta_query', $meta_query );
    // set the new orderby
    $query->set('orderby', [
        'page_end_time'  => 'ASC',
    ]);
}


add_action( 'elementor/query/home_breaking_news', 'query_home_breaking_news');
add_action( 'kws_elementor_kit_pro/query/home_breaking_news', 'query_home_breaking_news');
function query_home_breaking_news( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'breaking_news' ] ); 
    
    $meta_query = array(
        'relation' => 'AND',
        'page_show_in_homepage' => array(
            'key'       => 'is_visible',
            'compare'   => '=',
            'value'     => '1',
        ),
        'page_display_order' => array(
            'key'       => 'display_order',
            'compare'   => 'EXISTS',
            'type'      => 'NUMERIC',
        ),
    );

    $query->set( 'meta_query', $meta_query );

    // set the new orderby
    $query->set('orderby', [
        'page_display_order'  => 'ASC',
    ]);

}

/*
// Uncomment this block when we need to set a default value to a newly created ACF 
add_action('init', 'bulk_update_post_meta_data');
function bulk_update_post_meta_data() {
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'articles',
        'suppress_filters' => true
    );

    $posts_array = get_posts( $args );

    foreach($posts_array as $post_array) {
        update_post_meta($post_array->ID, 'display_order', '999999');
    }
}
*/
