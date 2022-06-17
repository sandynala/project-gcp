<?php

/**
 * KWS Elementor Kit widget filters
 * @since 5.7.4
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// WIDGETS - START
if (!function_exists('kek_is_pluto_carousel_enabled')) {
    function kek_is_pluto_carousel_enabled() {
        return apply_filters('kwselementorkit/widget/pluto-carousel', true);
    }
}
if (!function_exists('kek_is_mercury_slider_enabled')) {
    function kek_is_mercury_slider_enabled() {
        return apply_filters('kwselementorkit/widget/mercury-slider', true);
    }
}
if (!function_exists('kek_is_news_ticker_enabled')) {
    function kek_is_news_ticker_enabled() {
        return apply_filters('kwselementorkit/widget/news-ticker', true);
    }
}
if (!function_exists('kek_is_post_category_enabled')) {
    function kek_is_post_category_enabled() {
        return apply_filters('kwselementorkit/widget/post-category', true);
    }
}
if (!function_exists('kek_is_testimonial_grid_enabled')) {
    function kek_is_testimonial_grid_enabled() {
        return apply_filters('kwselementorkit/widget/testimonial-grid', true);
    }
}
// WIDGETS - END

/*
// TODO
// Selected - Start
if (!function_exists('kek_is_dyno_carousel_enabled')) {
    function kek_is_dyno_carousel_enabled() {
        return apply_filters('kwselementorkit/widget/dyno-carousel', true);
    }
}

// Selected - End

// Settings Filters
if (!function_exists('kek_is_mercury_slider_enabled')) {
    function kek_is_mercury_slider_enabled() {
        return apply_filters('kwselementorkit/widget/mercury-slider', true);
    }
}

if (!function_exists('kek_is_pluto_grid_enabled')) {
    function kek_is_pluto_grid_enabled() {
        return apply_filters('kwselementorkit/widget/pluto-grid', true);
    }
}

if (!function_exists('kek_is_pluto_carousel_enabled')) {
    function kek_is_pluto_carousel_enabled() {
        return apply_filters('kwselementorkit/widget/pluto-carousel', true);
    }
}

if (!function_exists('kek_is_neptune_grid_enabled')) {
    function kek_is_neptune_grid_enabled() {
        return apply_filters('kwselementorkit/widget/neptune-grid', true);
    }
}

if (!function_exists('kek_is_neptune_carousel_enabled')) {
    function kek_is_neptune_carousel_enabled() {
        return apply_filters('kwselementorkit/widget/neptune-carousel', true);
    }
}

if (!function_exists('kek_is_venus_grid_enabled')) {
    function kek_is_venus_grid_enabled() {
        return apply_filters('kwselementorkit/widget/venus-grid', true);
    }
}

if (!function_exists('kek_is_venus_carousel_enabled')) {
    function kek_is_venus_carousel_enabled() {
        return apply_filters('kwselementorkit/widget/venus-carousel', true);
    }
}

if (!function_exists('kek_is_jupiter_grid_enabled')) {
    function kek_is_jupiter_grid_enabled() {
        return apply_filters('kwselementorkit/widget/jupiter-grid', true);
    }
}

if (!function_exists('kek_is_jupiter_carousel_enabled')) {
    function kek_is_jupiter_carousel_enabled() {
        return apply_filters('kwselementorkit/widget/jupiter-carousel', true);
    }
}


if (!function_exists('kek_is_cygnus_list_enabled')) {
    function kek_is_cygnus_list_enabled() {
        return apply_filters('kwselementorkit/widget/cygnus-list', true);
    }
}
if (!function_exists('kek_is_canis_list_enabled')) {
    function kek_is_canis_list_enabled() {
        return apply_filters('kwselementorkit/widget/canis-list', true);
    }
}
if (!function_exists('kek_is_andromeda_list_enabled')) {
    function kek_is_andromeda_list_enabled() {
        return apply_filters('kwselementorkit/widget/andromeda-list', true);
    }
}


if (!function_exists('kek_is_news_ticker_enabled')) {
    function kek_is_news_ticker_enabled() {
        return apply_filters('kwselementorkit/widget/news-ticker', true);
    }
}
if (!function_exists('kek_is_post_category_enabled')) {
    function kek_is_post_category_enabled() {
        return apply_filters('kwselementorkit/widget/post-category', true);
    }
}
if (!function_exists('kek_is_social_share_enabled')) {
    function kek_is_social_share_enabled() {
        return apply_filters('kwselementorkit/widget/social-share', true);
    }
}
if (!function_exists('kek_is_social_count_enabled')) {
    function kek_is_social_count_enabled() {
        return apply_filters('kwselementorkit/widget/social-count', true);
    }
}
if (!function_exists('kek_is_post_info_blob_enabled')) {
    function kek_is_post_info_blob_enabled() {
        return apply_filters('kwselementorkit/widget/post-info-blob', true);
    }
}
*/


//Extensions
if (!function_exists('kek_is_animations_enabled')) {
    function kek_is_animations_enabled() {
        return apply_filters('kwselementorkit/extend/animations', true);
    }
}

