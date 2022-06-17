<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


global $ps_ip_address;
$ps_ip_address = PsGetRealIpAddress();

/**
 * Load the language files for this plugin
 * @param void
 * @return void
 */
function PsLoadPluginTextdomain() {
     load_plugin_textdomain('post-synergy', false, 'post-synergy/lang');
}
add_action('init', 'PsLoadPluginTextdomain');


/**
 * Basic options function for the plugin settings
 * @param no-param
 * @return void
 */
function SetOptionsKwsPsPost() {
     global $wpdb;

     // Creating the like post table on activating the plugin
     $kws_ps_post_table_name = $wpdb->prefix . "kws_ps_post";
	
     if ($wpdb->get_var("show tables like '$kws_ps_post_table_name'") != $kws_ps_post_table_name) {
		$sql = "CREATE TABLE " . $kws_ps_post_table_name . " (
			`id` bigint(11) NOT NULL AUTO_INCREMENT,
			`post_id` int(11) NOT NULL,
               `likes` int(11) NOT NULL DEFAULT '0',
               `unlikes` int(11) NOT NULL DEFAULT '0',
               `shares` int(11) NOT NULL DEFAULT '0',
               `views` int(11) NOT NULL DEFAULT '0',
               `bookmarks` int(11) NOT NULL DEFAULT '0',
               `thumbs_ups` int(11) NOT NULL DEFAULT '0',
               `thumbs_downs` int(11) NOT NULL DEFAULT '0',
			`value` int(11) NOT NULL,
			`date_time` datetime NOT NULL,
			`ip` varchar(40) NOT NULL,
			`user_id` int(11) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		)";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
     }
	
     // Adding options for the like post plugin
     add_option('kws_ps_post_drop_settings_table', '0', '', 'yes');
     add_option('kws_ps_post_voting_period', 'once', '', 'yes');
     add_option('kws_ps_post_display_style', 'hidden', '', 'yes');
     add_option('kws_ps_post_alignment', 'left', '', 'yes');
     add_option('kws_ps_post_position', 'bottom', '', 'yes');
     add_option('kws_ps_post_login_required', '0', '', 'yes');
     add_option('kws_ps_post_login_message', __('Please login to vote.', 'post-synergy'), '', 'yes');
     add_option('kws_ps_post_thank_message', __('Thanks for your vote.', 'post-synergy'), '', 'yes');
     add_option('kws_ps_post_voted_message', __('You have already voted.', 'post-synergy'), '', 'yes');
     add_option('kws_ps_post_allowed_posts', '', '', 'yes');
     add_option('kws_ps_post_excluded_posts', '', '', 'yes');
     add_option('kws_ps_post_excluded_categories', '', '', 'yes');
     add_option('kws_ps_post_excluded_sections', '', '', 'yes');
     add_option('kws_ps_post_show_on_pages', '0', '', 'yes');
     add_option('kws_ps_post_show_on_widget', '1', '', 'yes');
     add_option('kws_ps_post_title_text', __('Like/Unlike', 'post-synergy'), '', 'yes');
     add_option('kws_ps_post_db_version', BIZMO_VERSION, '', 'yes');
}

register_activation_hook(BIZMO__FILE__, 'SetOptionsKwsPsPost');




/**
 * For dropping the table and removing options
 * @param no-param
 * @return no-return
 */
function UnsetOptionsKwsPsPost() {
     global $wpdb;

	// Check the option whether to drop the table on plugin uninstall or not
	$drop_settings_table = get_option('kws_ps_post_drop_settings_table');
	
	if ($drop_settings_table == 1) {
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}kws_ps_post");
	
		// Deleting the added options on plugin uninstall
		delete_option('kws_ps_post_drop_settings_table');
		delete_option('kws_ps_post_voting_period');
		delete_option('kws_ps_post_display_style');
		delete_option('kws_ps_post_alignment');
		delete_option('kws_ps_post_position');
		delete_option('kws_ps_post_login_required');
		delete_option('kws_ps_post_login_message');
		delete_option('kws_ps_post_thank_message');
		delete_option('kws_ps_post_voted_message');
		delete_option('kws_ps_post_db_version');
		delete_option('kws_ps_post_allowed_posts');
		delete_option('kws_ps_post_excluded_posts');
		delete_option('kws_ps_post_excluded_categories');
		delete_option('kws_ps_post_excluded_sections');
		delete_option('kws_ps_post_show_on_pages');
		delete_option('kws_ps_post_show_on_widget');
		delete_option('kws_ps_post_title_text');
		delete_option('kws_ps_post_lite_notify_author');
	}
}

register_uninstall_hook(BIZMO__FILE__, 'UnsetOptionsKwsPsPost');




function KwsPsPostAdminRegisterSettings() {
     // Registering the settings
     register_setting('kws_ps_post_options', 'kws_ps_post_drop_settings_table');
     register_setting('kws_ps_post_options', 'kws_ps_post_voting_period');
     register_setting('kws_ps_post_options', 'kws_ps_post_display_style');
     register_setting('kws_ps_post_options', 'kws_ps_post_alignment');
     register_setting('kws_ps_post_options', 'kws_ps_post_position');
     register_setting('kws_ps_post_options', 'kws_ps_post_login_required');
     register_setting('kws_ps_post_options', 'kws_ps_post_login_message');
     register_setting('kws_ps_post_options', 'kws_ps_post_thank_message');
     register_setting('kws_ps_post_options', 'kws_ps_post_voted_message');
     register_setting('kws_ps_post_options', 'kws_ps_post_allowed_posts');
     register_setting('kws_ps_post_options', 'kws_ps_post_excluded_posts');
     register_setting('kws_ps_post_options', 'kws_ps_post_excluded_categories');
     register_setting('kws_ps_post_options', 'kws_ps_post_excluded_sections');
     register_setting('kws_ps_post_options', 'kws_ps_post_show_on_pages');
     register_setting('kws_ps_post_options', 'kws_ps_post_show_on_widget');
     register_setting('kws_ps_post_options', 'kws_ps_post_db_version');	
     register_setting('kws_ps_post_options', 'kws_ps_post_title_text');	
}

add_action('admin_init', 'KwsPsPostAdminRegisterSettings');



/**
 * Create the update function for this plugin
 * @param no-param
 * @return no-return
 */
function UpdateOptionsKwsPsPost() {
     global $wpdb;

	// Get current database version for this plugin
	$current_db_version = get_option('kws_ps_post_db_version');
	
	if ($current_db_version != BIZMO_VERSION) {
		// Increase column size to support IPv6
		$wpdb->query("ALTER TABLE `{$wpdb->prefix}kws_ps_post` CHANGE `ip` `ip` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
		
		$user_col = $wpdb->get_row("SHOW COLUMNS FROM {$wpdb->prefix}kws_ps_post LIKE 'user_id'");

		if (empty($user_col)) {
			$wpdb->query("ALTER TABLE `{$wpdb->prefix}kws_ps_post` ADD `user_id` INT NOT NULL DEFAULT '0'");
		}

		// Update the database version
		update_option('kws_ps_post_db_version', BIZMO_VERSION);
	}
}

add_action('plugins_loaded', 'UpdateOptionsKwsPsPost');



if (is_admin()) {
	// Include the file for loading plugin settings
	require_once('kws_ps_post_admin.php');
} 
else {
	// Include the file for loading plugin settings for
	require_once('kws_ps_post_site.php');

	// Load the js and css files
	add_action('init', 'KwsPsPostEnqueueScripts');
}

/**
 * Get the actual ip address
 * @param no-param
 * @return string
 */
function PsGetRealIpAddress() {
	if (getenv('HTTP_CLIENT_IP')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('HTTP_X_FORWARDED')) {
		$ip = getenv('HTTP_X_FORWARDED');
	} elseif (getenv('HTTP_FORWARDED_FOR')) {
		$ip = getenv('HTTP_FORWARDED_FOR');
	} elseif (getenv('HTTP_FORWARDED')) {
		$ip = getenv('HTTP_FORWARDED');
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	
	return $ip;
}

/**
 * Check whether user has already voted or not
 * @param $post_id integer
 * @param $ip string
 * @return integer
 */
function HasPsAlreadyVoted($post_id, $ip = null) {
	global $wpdb, $ps_ip_address;
	
	if (null == $ip) {
		$ip = $ps_ip_address;
	}
	
	$ps_has_voted = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT COUNT(id) AS has_voted FROM {$wpdb->prefix}kws_ps_post
							  WHERE post_id = %d AND ip = %s",
							$post_id, $ip
						)
					);
	
	return $ps_has_voted;
}

/**
 * Get last voted date for a given post by ip
 * @param $post_id integer
 * @param $ip string
 * @return string
 */
function GetPsLastVotedDate($post_id, $ip = null) {
     global $wpdb, $ps_ip_address;
     
     if (null == $ip) {
          $ip = $ps_ip_address;
     }
     
     $ps_has_voted = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT date_time FROM {$wpdb->prefix}kws_ps_post
							  WHERE post_id = %d AND ip = %s",
							$post_id, $ip
						)
					);

     return $ps_has_voted;
}

/**
 * Get next vote date for a given user
 * @param $last_voted_date string
 * @param $voting_period integer
 * @return string
 */
function GetPsNextVoteDate($last_voted_date, $voting_period) {
	$hour = $day = $month = $year = 0;
	
     switch($voting_period) {
          case "1":
               $day = 1;
               break;
          case "2":
               $day = 2;
               break;
          case "3":
               $day = 3;
               break;
          case "7":
               $day = 7;
               break;
          case "14":
               $day = 14;
               break;
          case "21":
               $day = 21;
               break;
          case "1m":
               $month = 1;
               break;
          case "2m":
               $month = 2;
               break;
          case "3m":
               $month = 3;
               break;
          case "6m":
               $month = 6;
               break;
          case "1y":
               $year = 1;
            break;
     }
     
     $last_strtotime = strtotime($last_voted_date);
     $next_strtotime = mktime(date('H', $last_strtotime), date('i', $last_strtotime), date('s', $last_strtotime),
                    date('m', $last_strtotime) + $month, date('d', $last_strtotime) + $day, date('Y', $last_strtotime) + $year);
     
     $next_voting_date = date('Y-m-d H:i:s', $next_strtotime);
     
     return $next_voting_date;
}

/**
 * Get last voted date as per voting period
 * @param $post_id integer
 * @return string
 */
function GetPsLastDate($voting_period) {
	$hour = $day = $month = $year = 0;
	
     switch($voting_period) {
          case "1":
               $day = 1;
               break;
          case "2":
               $day = 2;
               break;
          case "3":
               $day = 3;
               break;
          case "7":
               $day = 7;
               break;
          case "14":
               $day = 14;
               break;
          case "21":
               $day = 21;
               break;
          case "1m":
               $month = 1;
               break;
          case "2m":
               $month = 2;
               break;
          case "3m":
               $month = 3;
               break;
          case "6m":
               $month = 6;
               break;
          case "1y":
               $year = 1;
            break;
     }
     
     $last_strtotime = strtotime(date('Y-m-d H:i:s'));
     $last_strtotime = mktime(date('H', $last_strtotime), date('i', $last_strtotime), date('s', $last_strtotime),
                    date('m', $last_strtotime) - $month, date('d', $last_strtotime) - $day, date('Y', $last_strtotime) - $year);
     
     $last_voting_date = date('Y-m-d H:i:s', $last_strtotime);
     
     return $last_voting_date;
}

/**
 * Get like count for a post
 * @param $post_id integer
 * @return string
 */
function GetPsLikeCount($post_id) {
	global $wpdb;
	
	$ps_like_count = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT SUM(likes) FROM {$wpdb->prefix}kws_ps_post
							  WHERE post_id = %d",
							$post_id
						)
					);
	
	if (!$ps_like_count) {
		$ps_like_count = 0;
	} 
	
	return $ps_like_count;
}


/**
 * Get unlike count for a post
 * @param $post_id integer
 * @return string
 */
function GetPsUnlikeCount($post_id) {
	global $wpdb;
	
	$ps_unlike_count = $wpdb->get_var(
						$wpdb->prepare(
							"SELECT SUM(unlikes) FROM {$wpdb->prefix}kws_ps_post
							  WHERE post_id = %d",
							$post_id
						)
					);
	
	if (!$ps_unlike_count) {
		$ps_unlike_count = 0;
	} 
	
	return $ps_unlike_count;
}


/**
 * Get unlike count for a post
 * @param $post_id integer
 * @return string
 */
function GetPsAllCount($post_id) {
     global $wpdb;

     $result = $wpdb->get_row(
                    $wpdb->prepare(
                         "SELECT post_id, SUM(likes) AS like_count, SUM(unlikes) AS unlike_count, SUM(shares) AS shares_count
                            FROM {$wpdb->prefix}kws_ps_post
                           WHERE post_id = %d",
                         $post_id
                    )
               );

     return array(
          $result->like_count, $result->unlike_count, $result->shares_count, 
     );
}


const VALID_TASKS = array("like", "unlike", "share", "bookmark", "thumbs_up", "thumbs_down");
const VOTING_TASKS = array("like", "unlike");

function GetPsFieldsAllCount( $post_id ) {
     $fields = get_fields( $post_id );
     return array(
          $fields[ "like_count" ],
          $fields[ "unlike_count" ],
          $fields[ "share_count" ],
          $fields[ "bookmark_count" ],
          $fields[ "thumbs_up_count" ],
          $fields[ "thumbs_down_count" ],
     );
}
function GetPsSingleFieldCount( $task, $post_id) {
     return get_field( $task . "_count", $post_id );
}

function IncrementFieldCount( $task, $post_id ) {
     $field = $task . "_count";
     $count = (int) get_field( $field, $post_id );
     $count++;
     update_field( $field, $count, $post_id );
}


function UpdateTaskLog($task, $user_id, $post_id, $has_already_voted) {
     global $wpdb, $ps_ip_address;
     $task_column = $task . "s";
     if ( $has_already_voted ) {
          $success = $wpdb->query(
                         $wpdb->prepare(
                              "UPDATE {$wpdb->prefix}kws_ps_post SET 
                              value = value + 1,
                              {$task_column} = {$task_column} + 1,
                              date_time = '" . date( 'Y-m-d H:i:s' ) . "',
                              user_id = %d WHERE post_id = %d AND ip = %s",
                              $user_id, $post_id, $ps_ip_address
                         )
                    );
     } 
     else {
          $success = $wpdb->query(
                         $wpdb->prepare(
                              "INSERT INTO {$wpdb->prefix}kws_ps_post SET 
                              post_id = %d, value = '1', {$task_column} = '1',
                              date_time = '" . date( 'Y-m-d H:i:s' ) . "',
                              user_id = %d, ip = %s",
                              $post_id, $user_id, $ps_ip_address
                         )
                    );
     }

     return $success;
}

// Load the widgets
require_once('kws_ps_post_widgets.php');

// Include the file for ajax calls
require_once('kws_ps_post_ajax.php');

// Associate the respective functions with the ajax call
add_action('wp_ajax_kws_ps_post_process_vote', 'KwsPsPostProcessVote');
add_action('wp_ajax_nopriv_kws_ps_post_process_vote', 'KwsPsPostProcessVote');

add_action('wp_ajax_kws_ps_post_process_synergy', 'KwsPsPostProcessSynergy');
add_action('wp_ajax_nopriv_kws_ps_post_process_synergy', 'KwsPsPostProcessSynergy');