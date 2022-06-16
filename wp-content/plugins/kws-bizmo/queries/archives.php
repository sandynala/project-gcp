<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'elementor/query/category_results', 'query_category_results');
function query_category_results( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'articles', 'videos', 'podcasts', 'webinars', 'discussions', 'recorded-webinars', 'health-cards' ] ); 
}
