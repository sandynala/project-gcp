<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


function kws_count_posts_cache_key( $type, $key ) {
    $cache_key = 'posts-' . $type . '-' . $key;

    return $cache_key;
}


function kws_count_posts( $post_type, $meta_query = '', $key = '' ) {
    /*
    global $wpdb;

    $query = "SELECT COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s";

    return 10;
    */

    global $wpdb;

    //$post_status = (array) $post_status;
    //$post_status = [ 'publish' ];
    // Meta Type
    $join = '';
    $join_where = '';
    if(!empty( $meta_query )) {
        $meta_query = (array) $meta_query;
        foreach( $meta_query as $alias => $condition ) {
            $join .= " INNER JOIN {$wpdb->postmeta} {$alias} ON {$alias}.post_id=p.ID ";
            $join_where .= "( {$condition} ) AND ";
        }
    }


    $post_type = (array) $post_type;
    $sql = "SELECT COUNT(*) FROM $wpdb->posts p {$join} WHERE p.post_status='publish' AND ";

    if( !empty( $join_where )) {
        $sql .= "{$join_where} ";
    }

    //Post status
    /*
    if(!empty($post_status)){
        $argtype = array_fill(0, count($post_status), '%s');
        $where = "(post_status=".implode( " OR post_status=", $argtype).') AND ';
        $sql .= $wpdb->prepare($where,$post_status);
    }
    */

    //Post type
    if(!empty($post_type)){
        $argtype = array_fill(0, count($post_type), '%s');
        $where = "(p.post_type=".implode( " OR p.post_type=", $argtype).') AND ';
        $sql .= $wpdb->prepare($where,$post_type);
    }

    $sql .='1=1';
    $count = $wpdb->get_var($sql);

    //echo 'SQL: ' . $sql;

    return $count;    
}

function kws_count_posts_orig( $type = 'post', $meta_query = '', $key = '' ) {
    //if ( ! post_type_exists( $type ) ) {
    //    return 0;
    //}
     
    $cache_key = kws_count_posts_cache_key( $type, $key );
 
    $counts = wp_cache_get( $cache_key, 'kws_counts' );
    if ( false !== $counts ) {
        return $counts;
    }
    
    $args = [
        'posts_per_page' => -1,
        'post_type' => $type,
        'post_status' => 'publish',
        'meta_query' => $meta_query,
        'sortby' => '',
    ];

    //$posts = get_posts( $args );
    //$counts = count( $posts );

    $posts_counts = new WP_Query( $args );
    $counts = $posts_counts->post_count;
    wp_cache_set( $cache_key, $counts, 'kws_counts' );

    //if( $type === 'webinars') {
    //    echo "Last SQL-Query: {$posts_counts->request}";
    //}

    return $counts;
}