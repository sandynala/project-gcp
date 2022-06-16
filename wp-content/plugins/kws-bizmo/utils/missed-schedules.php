<?php

// Simple check for any missed schedules and publish the same 
function published_missed_schedules() {
    global $wpdb;
    $now=gmdate('Y-m-d H:i:00');

    $args=array(
        'public'                => true,
        'exclude_from_search'   => false,
        '_builtin'              => false
    ); 
    $post_types = get_post_types($args,'names','and');
    $str=implode ('\',\'',$post_types);

    if ($str) {
        $sql="SELECT ID FROM $wpdb->posts WHERE post_type IN ('post','page','$str') AND post_status='future' AND post_date_gmt<'$now'";
    }
    else {
        $sql="SELECT ID FROM $wpdb->posts WHERE post_type IN ('post','page') AND post_status='future' AND post_date_gmt<'$now'";
    }

    $resulto = $wpdb->get_results($sql);
    if($resulto) {
        foreach( $resulto as $thisarr ) {
            wp_publish_post($thisarr->ID);
        }
    }
}

// Run missed schedules only if we are hooking onto to post head
function ensure_missed_schedules() 
{
	if (is_front_page() || is_single()) {
        published_missed_schedules();
    }
}


// Cron based schedule check for every 5 mins check
function add_minute_interval($schedules) {
	$schedules['every5min'] = array('interval' => 300, 'display' => __('Every five minutes'));
	return $schedules;
} 

function missed_schedule_activate() {
	if (!wp_next_scheduled('missed_schedule_cron')) {
		wp_schedule_event(time(), 'every5min', 'missed_schedule_cron');
	} 
} 

function missed_schedule_deactivate() {
	if (wp_next_scheduled('missed_schedule_cron')) {
		wp_clear_scheduled_hook('missed_schedule_cron');
	} 
} 

// We can perform the checks in two ways, either
//   a. check at every page visit or
//   b. check on a cron schedule

// uncomment below line and comment other lines to enable Type A checks
add_action('wp_head', 'ensure_missed_schedules'); 

// uncomment below lines and comment above line to enable Type B checks
add_filter('cron_schedules', 'add_minute_interval');
add_action('missed_schedule_cron', 'published_missed_schedules', 10);
register_activation_hook(__FILE__, 'missed_schedule_activate');
register_deactivation_hook(__FILE__, 'missed_schedule_deactivate');

