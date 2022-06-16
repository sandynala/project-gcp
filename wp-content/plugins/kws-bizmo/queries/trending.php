<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


function query_trending_articles( $query ) {
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
        'page_views_count' => array(
            'key'       => 'view_count',
            'compare'   => 'EXISTS',
            'type'      => 'NUMERIC',
        ),
        'page_likes_count' => array(
            'key'       => 'like_count',
            'compare'   => 'EXISTS',
            'type'      => 'NUMERIC',
        ), 
    );
    

	$query->set( 'meta_query', $meta_query );

    // set the new orderby
    $query->set('orderby', [
        'page_views_count'  => 'DESC',
        'page_likes_count'  => 'DESC',
        'comment_count'     => 'DESC',
    ]);
}

add_action( 'elementor/query/trending_articles', 'query_trending_articles');
add_action( 'kws_elementor_kit_pro/query/trending_articles', 'query_trending_articles');



function shortcode_get_trending_tile_keys( $atts ) {
    $the_id = get_the_ID();

    $field_names = [
                        'view_count' => 'far fa-eye', 
                        'share_count' => 'fas fa-share-alt', 
                        'like_count' => 'far fa-heart', 
                        'bookmark_count' => 'far fa-bookmark', 
                        'comment_count' => 'far fa-comment-dots',
                   ];

    $field_values = [];
    foreach( array_keys($field_names) as $field_name) {
        $fv = get_field( $field_name, $the_id );
        if( !$fv ) {
            $fv = 0;
        }
        $field_values[ $field_names[ $field_name ] ] = $fv;
    }

    $out_html = '<div class="elementor-widget-container">
	<ul class="elementor-inline-items elementor-icon-list-items elementor-post-info">';

    $count = 1;
    arsort( $field_values );
    foreach( array_keys( $field_values ) as $field_key ) {

        $field_value = $field_values[ $field_key ];
        $out_html = $out_html . '<li class="elementor-icon-list-item elementor-inline-item">
        <span class="elementor-icon-list-icon ' . $field_key . '"></span>
        <span class="elementor-icon-list-text elementor-post-info__item">
            ' . $field_value . '
        </span>
    </li>';
        
        $count += 1;
        if($count > 2) {
            break;
        }
    }


    $out_html = $out_html . '	</ul>
    </div>';

    return $out_html;
}
add_shortcode( 'trending_tile_keys', 'shortcode_get_trending_tile_keys' );