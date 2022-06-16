<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Get the like output on site
 * @param array
 * @return string
 */
function GetKwsPsPost($arg = null) {
     global $wpdb;
     $post_id = get_the_ID();
     $kws_ps_post = "";
     
     // Get the posts ids where we do not need to show like functionality
     $allowed_posts = explode(",", esc_html(get_option('kws_ps_post_allowed_posts')));
     $excluded_posts = explode(",", esc_html(get_option('kws_ps_post_excluded_posts')));
     $excluded_categories = get_option('kws_ps_post_excluded_categories');
     $excluded_sections = get_option('kws_ps_post_excluded_sections');
     
     if (empty($excluded_categories)) {
          $excluded_categories = array();
     }
     
     if (empty($excluded_sections)) {
          $excluded_sections = array();
     }
     
     $title_text = esc_html(get_option('kws_ps_post_title_text'));
     $category = get_the_category();
     $excluded = false;
     
     // Checking for excluded section. if yes, then dont show the like/dislike option
     if ((in_array('home', $excluded_sections) && is_home()) || (in_array('archive', $excluded_sections) && is_archive())) {
          return;
     }
     
     // Checking for excluded categories
     foreach($category as $cat) {
          if (in_array($cat->cat_ID, $excluded_categories) && !in_array($post_id, $allowed_posts)) {
               $excluded = true;
          }
     }
     
     // If excluded category, then dont show the like/dislike option
     if ($excluded) {
          return;
     }
     
     // Check for title text. if empty then have the default value
     if (empty($title_text)) {
          $title_text_like = __('Like', 'post-synergy');
          $title_text_unlike = __('Unlike', 'post-synergy');
     } else {
          $title_text = explode('/', esc_html(get_option('kws_ps_post_title_text')));
          $title_text_like = $title_text[0];
          $title_text_unlike = isset( $title_text[1] ) ? $title_text[1] : '';
     }
     
     // Checking for excluded posts
     if (!in_array($post_id, $excluded_posts)) {
          // Get the nonce for security purpose and create the like and unlike urls
          $nonce = wp_create_nonce("kws_ps_post_vote_nonce");
          $style = (get_option('kws_ps_post_display_style') == "") ? 'hidden' : get_option('kws_ps_post_display_style');
          
          //$all_counts = GetPsAllCount($post_id);
          //$kws_ps_post .= "<div class='kws-ps-info1' data-postid='" . $post_id . "' data-likes='" . $all_counts[0] . "' data-shares='" . $all_counts[2] . "' data-nonce='" . $nonce . "' ></div>";
          $all_counts = GetPsFieldsAllCount($post_id);
          $kws_ps_post .= "<div class='kws-ps-info' data-postid='" . $post_id . "' data-nonce='" . $nonce . "' ></div>";

          if( $style !== 'hidden' ) {
               $ajax_like_link = admin_url('admin-ajax.php?action=kws_ps_post_process_vote&task=like&post_id=' . $post_id . '&nonce=' . $nonce);
               $ajax_unlike_link = admin_url('admin-ajax.php?action=kws_ps_post_process_vote&task=unlike&post_id=' . $post_id . '&nonce=' . $nonce);
               
               //$like_count = GetPsLikeCount($post_id);
               //$unlike_count = GetPsUnlikeCount($post_id);
               $like_count = $all_counts[0];
               $unlike_count = $all_counts[1];
               $msg = GetPsVotedMessage($post_id);
               $alignment = ("left" == get_option('kws_ps_post_alignment')) ? 'align-left' : 'align-right';
               //$show_dislike = get_option('kws_ps_post_show_dislike');
     
               $kws_ps_post .= "<div class='watch-action'>";
               $kws_ps_post .= "<div class='watch-position " . $alignment . "'>";
               
               $kws_ps_post .= "<div class='action-like'>";
               $kws_ps_post .= "<a class='lbg-" . $style . " like-" . $post_id . " jlk' href='javascript:void(0)' data-task='like' data-post_id='" . $post_id . "' data-nonce='" . $nonce . "' rel='nofollow'>";
               $kws_ps_post .= "<img class='ps-pixel' src='" . plugins_url( 'images/pixel.gif' , __FILE__ ) . "' title='" . __($title_text_like, 'post-synergy') . "' />";
               $kws_ps_post .= "<span class='lc-" . $post_id . " lc'>" . $like_count . "</span>";
               $kws_ps_post .= "</a></div>";
               
               /* Show Dislike */
               //if ($show_dislike) {
                    $kws_ps_post .= "<div class='action-unlike'>";
                    $kws_ps_post .= "<a class='unlbg-" . $style . " unlike-" . $post_id . " jlk' href='javascript:void(0)' data-task='unlike' data-post_id='" . $post_id . "' data-nonce='" . $nonce . "' rel='nofollow'>";
                    $kws_ps_post .= "<img class='ps-pixel' src='" . plugins_url( 'images/pixel.gif' , __FILE__ ) . "' title='" . __($title_text_unlike, 'post-synergy') . "' />";
                    $kws_ps_post .= "<span class='unlc-" . $post_id . " unlc'>" . $unlike_count . "</span>";
                    $kws_ps_post .= "</a></div> ";
               //}
               
               $kws_ps_post .= "</div> ";
               $kws_ps_post .= "<div class='status-" . $post_id . " status " . $alignment . "'>" . $msg . "</div>";
               $kws_ps_post .= "</div><div class='ps-clear'></div>";
          }
     }
     
     if ($arg == 'put') {
          return $kws_ps_post;
     } else {
          echo $kws_ps_post;
     }
}

/**
 * Show the like content
 * @param $content string
 * @param $param string
 * @return string
 */
/*
function PutKwsPsPost($content) {
     $show_on_pages = false;
     
     if ((is_page() && get_option('kws_ps_post_show_on_pages')) || (!is_page())) {
          $show_on_pages = true;
     }

     if (!is_feed() && $show_on_pages) {     
          $kws_ps_post_content = GetKwsPsPost('put');
          $kws_ps_post_position = get_option('kws_ps_post_position');
          
          if ($kws_ps_post_position == 'top') {
               $content = $kws_ps_post_content . $content;
          } elseif ($kws_ps_post_position == 'bottom') {
               $content = $content . $kws_ps_post_content;
          } else {
               $content = $kws_ps_post_content . $content . $kws_ps_post_content;
          }
     }
     
     return $content;
}
add_filter('the_content', 'PutKwsPsPost');
*/

function PutAfterBodyOpen() {
     if (is_single()) {
          $show_on_pages = false;
     
          if ((is_page() && get_option('kws_ps_post_show_on_pages')) || (!is_page())) {
               $show_on_pages = true;
          }
     
          if (is_single() && !is_feed() && $show_on_pages) {     
               $kws_ps_post_content = GetKwsPsPost('put');
               echo $kws_ps_post_content;
          }
     }
}
add_filter('wp_body_open', 'PutAfterBodyOpen');



/**
 * Get already voted message
 * @param $post_id integer
 * @param $ip string
 * @return string
 */
function GetPsVotedMessage($post_id, $ip = null) {
     global $wpdb, $ps_ip_address;
     $ps_voted_message = '';
     $voting_period = get_option('kws_ps_post_voting_period');
     
     if (null == $ip) {
          $ip = $ps_ip_address;
     }
     
     if ($voting_period != 0 && $voting_period != 'once') {
          // If there is restriction on revoting with voting period, check with voting time
          $last_voted_date = GetPsLastDate($voting_period);
          //$query .= " AND date_time >= '$last_voted_date'";
          $query = $wpdb->prepare(
                         "SELECT COUNT(id) AS has_voted FROM {$wpdb->prefix}kws_ps_post
                           WHERE post_id = %d AND ip = %s AND date_time >= %s",
                         $post_id, $ip, $last_voted_date
                    );
     } else {
          $query = $wpdb->prepare(
                         "SELECT COUNT(id) AS has_voted FROM {$wpdb->prefix}kws_ps_post
                           WHERE post_id = %d AND ip = %s",
                         $post_id, $ip
                    );
     }

     $ps_has_voted = $wpdb->get_var($query);
     
     if ($ps_has_voted > 0) {
          $ps_voted_message = esc_html(get_option('kws_ps_post_voted_message'));
     }
     
     return $ps_voted_message;
}

add_shortcode('most_liked_posts', 'PsMostLikedPostsShortcode');

/**
 * Most liked posts shortcode
 * @param $args array
 * @return string
 */
function PsMostLikedPostsShortcode($args) {
     global $wpdb;
     $most_liked_post = '';
     $where = '';
     
     if (isset($args['limit'])) {
          $limit = intval($args['limit']);
     } else {
          $limit = 10;
     }
     
     if (!empty($args['time']) && $args['time'] != 'all') {
          $last_date = GetPsLastDate($args['time']);
          $where .= " AND date_time >= '$last_date'";
     }
     
     $posts = $wpdb->get_results(
          $wpdb->prepare(
               "SELECT post_id, SUM(value) AS like_count, post_title
                  FROM `{$wpdb->prefix}kws_ps_post` L, {$wpdb->prefix}posts P 
                 WHERE L.post_id = P.ID AND post_status = 'publish' AND value > 0 $where
                 GROUP BY post_id ORDER BY like_count DESC, post_title ASC LIMIT %d",
               $limit
          )
     );
 
     if (count($posts) > 0) {
          $most_liked_post .= '<table class="most-liked-posts-table">';
          $most_liked_post .= '<tr>';
          $most_liked_post .= '<td>' . __('Title', 'post-synergy') .'</td>';
          $most_liked_post .= '<td>' . __('Like Count', 'post-synergy') .'</td>';
          $most_liked_post .= '</tr>';
       
          foreach ($posts as $post) {
               $post_title = esc_html($post->post_title);
               $permalink = get_permalink($post->post_id);
               $like_count = $post->like_count;
               
               $most_liked_post .= '<tr>';
               $most_liked_post .= '<td><a href="' . $permalink . '" title="' . $post_title . '">' . $post_title . '</a></td>';
               $most_liked_post .= '<td>' . $like_count . '</td>';
               $most_liked_post .= '</tr>';
          }
       
          $most_liked_post .= '</table>';
     } else {
          $most_liked_post .= '<p>' . __('No posts liked yet.', 'post-synergy') . '</p>';
     }
     
     return $most_liked_post;
}

add_shortcode('recently_liked_posts', 'PsRecentlyLikedPostsShortcode');

/**
 * Get recently liked posts shortcode
 * @param $args array
 * @return string
 */
function PsRecentlyLikedPostsShortcode($args) {
     global $wpdb;
     $recently_liked_post = '';
     $where = '';
     
     if ( isset( $args['limit'] ) ) {
          $limit = $args['limit'];
     } else {
          $limit = 10;
     }
     
     $show_excluded_posts = get_option('kws_ps_post_show_on_widget');
	$excluded_posts = trim( esc_html(get_option('kws_ps_post_excluded_posts')) );
     $excluded_post_ids = explode(',', $excluded_posts);
     
     if ( !$show_excluded_posts && !empty( $excluded_posts ) ) {
          $where = "AND post_id NOT IN (" . $excluded_posts . ")";
     }

     // Get the post IDs recently voted
     $recent_ids = $wpdb->get_col(
                              "SELECT DISTINCT(post_id) FROM `{$wpdb->prefix}kws_ps_post`
                              WHERE value > 0 $where GROUP BY post_id ORDER BY MAX(date_time) DESC"
                         );

     if ( count( $recent_ids ) > 0 ) {
          $where = "AND post_id IN(" . implode(",", $recent_ids) . ")";
     
          // Getting the most liked posts
          $query = "SELECT post_id, SUM(value) AS like_count, post_title FROM `{$wpdb->prefix}kws_ps_post` L, {$wpdb->prefix}posts P 
                    WHERE L.post_id = P.ID AND post_status = 'publish' $where GROUP BY post_id
                    ORDER BY FIELD(post_id, " . implode(",", $recent_ids) . ") ASC LIMIT $limit";
     
          $posts = $wpdb->get_results($query);
     
          if ( count( $posts ) > 0 ) {
               $recently_liked_post .= '<table class="recently-liked-posts-table">';
               $recently_liked_post .= '<tr>';
               $recently_liked_post .= '<td>' . __('Title', 'post-synergy') .'</td>';
               $recently_liked_post .= '</tr>';
               
               foreach ( $posts as $post ) {
                    $post_title = esc_html($post->post_title);
                    $permalink = get_permalink($post->post_id);
                    
                    $recently_liked_post .= '<tr>';
                    $recently_liked_post .= '<td><a href="' . $permalink . '" title="' . $post_title . '">' . $post_title . '</a></td>';
                    $recently_liked_post .= '</tr>';
               }
            
               $recently_liked_post .= '</table>';
          }
     } else {
          $recently_liked_post .= '<p>' . __('No posts liked yet.', 'post-synergy') . '</p>';
     }
     
     return $recently_liked_post;
}

/**
 * Add the javascript and css for the plugin
 * @param no-param
 */
function KwsPsPostEnqueueScripts() {
     // Load javascript file
     wp_register_script( 'kws_ps_post_script', plugins_url( 'js/kws_ps_post.js', __FILE__ ), array('jquery') );
     wp_localize_script( 'kws_ps_post_script', 'pslp', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));

     wp_enqueue_script( 'jquery' );
     wp_enqueue_script( 'kws_ps_post_script' );
     
     // Load css file
     wp_register_style( 'kws_ps_post_style', plugins_url( 'css/kws_ps_post.css', __FILE__ ) );
     wp_enqueue_style( 'kws_ps_post_style' );
}