<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


add_action( 'elementor/query/contactus_addresses', 'query_contactus_addresses');
function query_contactus_addresses( $query ) {
    // Set the custom post type 
    $query->set( 'post_type', [ 'contact_address' ] ); 
    
    $meta_query = array(
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
