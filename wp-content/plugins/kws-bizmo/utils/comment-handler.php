<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * This file can be optimized to externalize the post views updation
 */
// custom comment code

// Add custom meta (ratings) fields to the default comment form
add_filter('comment_form_default_fields', 'custom_fields');

function custom_fields($fields) {

if(get_comments_number($post->ID) === '0'){
    echo "<h3 class='title-comments one_count'>0 comment</h3>";
}else if(get_comments_number($post->ID) === '1'){
    echo "<h3 class='title-comments one_count'>1 comment</h3>";
}else{
    echo "<h3 class='title-comments one_count'> ".get_comments_number($post->ID)." comments</h3>";
}

$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : ’ );

$fields[ 'author' ] = '<p class="comment-form-author">'.
'<input id="author" name="author" type="text" placeholder="Name *" class="form_field" value="'. esc_attr( $commenter['comment_author'] ) .
'" size="30"' . $aria_req . ' required /></p>';


$fields[ 'email' ] = '<p class="comment-form-email">'.
'<input id="email" name="email" type="text" placeholder="Email *" class="form_field" value="'. esc_attr( $commenter['comment_author_email'] ) .
'" size="30"' . $aria_req . ' required/></p>';


return $fields;
}

//Reply Text

function wpb_comment_reply_text( $link ) {
echo '<span class="comment_count"><script>jQuery(document).ready(function(){jQuery(".comment_count").each(function(){var get_len = jQuery(this).parents(".comment-body").parent().children("ol.children").children("li").length;jQuery(this).text(get_len);});});</script></span>';
$link = str_replace( 'Reply','', $link );
return $link;
}
add_filter( 'comment_reply_link', 'wpb_comment_reply_text' );

//date formate

add_filter( 'get_comment_date', 'wpsites_change_comment_date_format' );	
function wpsites_change_comment_date_format( $d ) {
    $d = printf( _x( '%s ago', '%s = human-readable time difference', 'your-text-domain' ), human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) );
    return $d;
}	

//submit & textarea button 

add_filter( 'comment_form_defaults', function( $defaults )
{
    // Edit this to your needs:
    $button = '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="SUBMIT" />';

    // Override the default submit button:
    $defaults['submit_button'] = $button;

    $defaults['comment_field'] = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" maxlength="250" required="required" placeholder="Write a response…" class="form_field"></textarea></p>';

    return $defaults;
} );

//end custom comment code


//ajax
// function ajax_comment_form(){
//     wp_register_script('ajax-comment', plugins_url('js/ajax-comment.js', __FILE__),'','',true);
//     wp_enqueue_script('ajax-comment');
// }
// add_action("wp_enqueue_scripts", "ajax_comment_form");
