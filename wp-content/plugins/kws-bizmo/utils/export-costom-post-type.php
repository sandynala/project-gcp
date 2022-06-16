<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * This file can be optimized to externalize the post views updation
 */
/*Export Code */
function cptui_register_my_cpts() {

	/**
	 * Post Type: Articles.
	 */

	$labels = [
		"name" => __( "Articles", "hello-elementor" ),
		"singular_name" => __( "Article", "hello-elementor" ),
		"menu_name" => __( "Articles", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Articles", "hello-elementor" ),
		"labels" => $labels,
		"description" => "Formatted Articles in Text format",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "article",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "articles", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 20,
		"menu_icon" => "dashicons-welcome-write-blog",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "revisions" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "articles", $args );

	/**
	 * Post Type: Videos.
	 */

	$labels = [
		"name" => __( "Videos", "hello-elementor" ),
		"singular_name" => __( "Video", "hello-elementor" ),
		"menu_name" => __( "Videos", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Videos", "hello-elementor" ),
		"labels" => $labels,
		"description" => "Video Content",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "video",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "videos", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 21,
		"menu_icon" => "dashicons-video-alt3",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "revisions" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "videos", $args );

	/**
	 * Post Type: Podcasts.
	 */

	$labels = [
		"name" => __( "Podcasts", "hello-elementor" ),
		"singular_name" => __( "Podcast", "hello-elementor" ),
		"menu_name" => __( "Podcasts", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Podcasts", "hello-elementor" ),
		"labels" => $labels,
		"description" => "Audio Podcasts",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "podcast",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "podcasts", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 21,
		"menu_icon" => "dashicons-format-audio",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "revisions" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "podcasts", $args );

	/**
	 * Post Type: Webinars.
	 */

	$labels = [
		"name" => __( "Webinars", "hello-elementor" ),
		"singular_name" => __( "Webinar", "hello-elementor" ),
		"menu_name" => __( "Webinars", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Webinars", "hello-elementor" ),
		"labels" => $labels,
		"description" => "Webinars",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "webinar",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "webinars", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 21,
		"menu_icon" => "dashicons-video-alt",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "revisions" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "webinars", $args );

	/**
	 * Post Type: Discussions.
	 */

	$labels = [
		"name" => __( "Discussions", "hello-elementor" ),
		"singular_name" => __( "Discussion", "hello-elementor" ),
		"menu_name" => __( "Discussions", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Discussions", "hello-elementor" ),
		"labels" => $labels,
		"description" => "Discussions or Doctor's Dilemma",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "discussion",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "discussions", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 21,
		"menu_icon" => "dashicons-format-chat",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "revisions" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "discussions", $args );

	/**
	 * Post Type: Testimonials.
	 */

	$labels = [
		"name" => __( "Testimonials", "hello-elementor" ),
		"singular_name" => __( "Testimonial", "hello-elementor" ),
		"menu_name" => __( "Testimonials", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Testimonials", "hello-elementor" ),
		"labels" => $labels,
		"description" => "Testimonials",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "testimonial",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "testimonials", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 21,
		"menu_icon" => "dashicons-format-quote",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "revisions", "post-formats" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "testimonials", $args );

	/**
	 * Post Type: Contact Addresses.
	 */

	$labels = [
		"name" => __( "Contact Addresses", "hello-elementor" ),
		"singular_name" => __( "Contact Address", "hello-elementor" ),
		"menu_name" => __( "Address", "hello-elementor" ),
		"all_items" => __( "Addresses", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Contact Addresses", "hello-elementor" ),
		"labels" => $labels,
		"description" => "Contact Address for HH",
		"public" => true,
		"publicly_queryable" => false,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "contact_address", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 51,
		"menu_icon" => "dashicons-excerpt-view",
		"taxonomies" => [ "address_location" ],
		"show_in_graphql" => false,
	];

	register_post_type( "contact_address", $args );

	/**
	 * Post Type: FAQ.
	 */

	$labels = [
		"name" => __( "FAQ", "hello-elementor" ),
		"singular_name" => __( "FAQ", "hello-elementor" ),
	];

	$args = [
		"label" => __( "FAQ", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "faq_item", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 52,
		"menu_icon" => "dashicons-menu",
		"supports" => [ "title", "editor", "excerpt", "custom-fields" ],
		"taxonomies" => [ "faq_category" ],
		"show_in_graphql" => false,
	];

	register_post_type( "faq_item", $args );

	/**
	 * Post Type: Breaking News.
	 */

	$labels = [
		"name" => __( "Breaking News", "hello-elementor" ),
		"singular_name" => __( "Breaking News", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Breaking News", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "breaking_news", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-admin-site",
		"supports" => [ "title", "editor", "excerpt", "custom-fields", "comments" ],
		"show_in_graphql" => false,
	];

	register_post_type( "breaking_news", $args );

	/**
	 * Post Type: Recorded Webinars.
	 */

	$labels = [
		"name" => __( "Recorded Webinars", "hello-elementor" ),
		"singular_name" => __( "Recorded Webinar", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Recorded Webinars", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "recorded-webinars",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "recorded-webinars", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 20,
		"menu_icon" => "dashicons-media-video",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "comments", "revisions" ],
		"taxonomies" => [ "category", "post_tag" ],
		"show_in_graphql" => false,
	];

	register_post_type( "recorded-webinars", $args );

	/**
	 * Post Type: Info Graphics.
	 */

	$labels = [
		"name" => __( "Info Graphics", "hello-elementor" ),
		"singular_name" => __( "Info Graphic", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Info Graphics", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "healthcards",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "healthcards", "with_front" => true ],
		"query_var" => true,
		"menu_icon" => "dashicons-admin-page",
		"supports" => [ "title", "editor", "thumbnail", "excerpt", "custom-fields", "revisions" ],
		"taxonomies" => [ "cards" ],
		"show_in_graphql" => false,
	];

	register_post_type( "healthcards", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );

