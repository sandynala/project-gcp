<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


function query_about_us_addresses( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'contact_address' ] ); 

	// Get current meta Query
	$meta_query = $query->get( 'meta_query' );

	// If there is no meta query when this filter runs, it should be initialized as an empty array.
	if ( ! $meta_query ) {
		$meta_query = [];
	}
    
    // add our condition to the meta_query
    $meta_query = array(
        'address_sort_order' => array(
            'key'       => 'address_sort_order',
            'compare'   => 'EXISTS',
            'type'      => 'NUMERIC',
        ),
    );
    
	$query->set( 'meta_query', $meta_query );

    // set the new orderby
    $query->set('orderby', [
        'address_sort_order'    => 'ASC',
        'post_date'             => 'DESC',
    ]);
}
add_action( 'elementor/query/about_us_addressees', 'query_about_us_addresses');


function query_about_us_faqs( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'contact_address' ] ); 

	// Get current meta Query
	$meta_query = $query->get( 'meta_query' );

	// If there is no meta query when this filter runs, it should be initialized as an empty array.
	if ( ! $meta_query ) {
		$meta_query = [];
	}
    
    // add our condition to the meta_query
    $meta_query = array(
        'faq_sort_order' => array(
            'key'       => 'faq_sort_order',
            'compare'   => 'EXISTS',
            'type'      => 'NUMERIC',
        ),
    );
    
	$query->set( 'meta_query', $meta_query );

    // set the new orderby
    $query->set('orderby', [
        'faq_sort_order'    => 'ASC',
        'post_date'         => 'DESC',
    ]);
}
add_action( 'elementor/query/about_us_faqs', 'query_about_us_faqs');