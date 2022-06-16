<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


function KwsPsPostProcessVote() {
	global $wpdb, $ps_ip_address;
	
	// Get request data
	$post_id = (int)$_REQUEST['post_id'];
	$task = $_REQUEST['task'];
	
	$wpdb->show_errors();

	// Check for valid access
	if ( !wp_verify_nonce( $_REQUEST['nonce'], 'kws_ps_post_vote_nonce' ) ) {
		$error = 1;
		$msg = __( 'Invalid access', 'post-synergy' );
	} else {
		// Get setting data
		$is_logged_in = is_user_logged_in();
		$login_required = get_option( 'kws_ps_post_login_required' );
		$can_proceed = false;

		if ( $login_required && !$is_logged_in ) {
			// User needs to login to vote but has not logged in
			$error = 1;
			$msg = esc_html(get_option( 'kws_ps_post_login_message' ));
		} else {
			$has_already_voted = HasPsAlreadyVoted( $post_id, $ps_ip_address );
			$voting_period = get_option( 'kws_ps_post_voting_period' );
			$datetime_now = date( 'Y-m-d H:i:s' );
			
			if ( "once" == $voting_period && $has_already_voted ) {
				// User can vote only once and has already voted.
				$error = 1;
				$msg = esc_html(get_option( 'kws_ps_post_voted_message' ));
			} elseif ( '0' == $voting_period ) {
				// User can vote as many times as he want
				$can_proceed = true;
			} else {
				if ( !$has_already_voted ) {
					// Never voted befor so can vote
					$can_proceed = true;
				} else {
					// Get the last date when the user had voted
					$last_voted_date = GetPsLastVotedDate( $post_id, $ps_ip_address );
					
					// Get the bext voted date when user can vote
					$next_vote_date = GetPsNextVoteDate( $last_voted_date, $voting_period );
					
					if ( $next_vote_date > $datetime_now ) {
						$revote_duration = ( strtotime( $next_vote_date ) - strtotime( $datetime_now ) ) / ( 3600 * 24 );
						
						$can_proceed = false;
						$error = 1;
						$msg = __( 'You can vote after', 'post-synergy' ) . ' ' . ceil( $revote_duration ) . ' ' . __( 'day(s)', 'post-synergy' );
					} else {
						$can_proceed = true;
					}
				}
			}
		}
		
		if ( $can_proceed ) {
			$current_user = wp_get_current_user();
			$user_id = (int)$current_user->ID;
			
			IncrementFieldCount( $task, $post_id );
			if ( $task == "like" ) {
				if ( $has_already_voted ) {
					$success = $wpdb->query(
								$wpdb->prepare(
									"UPDATE {$wpdb->prefix}kws_ps_post SET 
									value = value + 1,
									likes = likes + 1,
									date_time = '" . date( 'Y-m-d H:i:s' ) . "',
									user_id = %d WHERE post_id = %d AND ip = %s",
									$user_id, $post_id, $ps_ip_address
								)
							);
				} else {
					$success = $wpdb->query(
								$wpdb->prepare(
									"INSERT INTO {$wpdb->prefix}kws_ps_post SET 
									post_id = %d, value = '1', likes = '1',
									date_time = '" . date( 'Y-m-d H:i:s' ) . "',
									user_id = %d, ip = %s",
									$post_id, $user_id, $ps_ip_address
								)
							);
				}
			} 
			else if ( $task == "unlike" ) {
				if ( $has_already_voted ) {
					$success = $wpdb->query(
								$wpdb->prepare(
									"UPDATE {$wpdb->prefix}kws_ps_post SET 
									value = value - 1, unlikes = unlikes + 1,
									date_time = '" . date( 'Y-m-d H:i:s' ) . "',
									user_id = %d WHERE post_id = %d AND ip = %s",
									$user_id, $post_id, $ps_ip_address
								)
							);
				} else {
					$success = $wpdb->query(
								$wpdb->prepare(
									"INSERT INTO {$wpdb->prefix}kws_ps_post SET 
									post_id = %d, value = '-1', unlikes = 1,
									date_time = '" . date( 'Y-m-d H:i:s' ) . "',
									user_id = %d, ip = %s",
									$post_id, $user_id, $ps_ip_address
								)
							);
				}
			}
			else if ( $task == "shares" ) {
				if ( $has_already_voted ) {
					$success = $wpdb->query(
								$wpdb->prepare(
									"UPDATE {$wpdb->prefix}kws_ps_post SET 
									value = '0', shares = shares + 1,
									user_id = %d WHERE post_id = %d AND ip = %s",
									$user_id, $post_id, $ps_ip_address
								)
							);
				} else {
					$success = $wpdb->query(
								$wpdb->prepare(
									"INSERT INTO {$wpdb->prefix}kws_ps_post SET 
									post_id = %d, value = '0', shares = 1,
									date_time = '" . date( 'Y-m-d H:i:s' ) . "',
									user_id = %d, ip = %s",
									$post_id, $user_id, $ps_ip_address
								)
							);
				}
			}

			if ($success) {
				$error = 0;
				$msg = esc_html(get_option( 'kws_ps_post_thank_message' ));
			} else {
				$error = 1;
				$msg = __( 'Could not process your vote.' . $has_already_voted, 'post-synergy' );
			}
		}
		
		$options = get_option( 'ps_most_liked_posts' );
		$number = $options['number'];
		$show_count = $options['show_count'];
		
		//$ps_like_count = GetPsLikeCount( $post_id );
		//$ps_unlike_count = GetPsUnlikeCount( $post_id );
		$ps_like_count = GetPsSingleFieldCount( "like", $post_id);
		$ps_unlike_count = GetPsSingleFieldCount( "unlike", $post_id);
	}
	
	// Check for method of processing the data
	if ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		$result = array(
					"msg" => $msg,
					"error" => $error,
					"like" => $ps_like_count,
					"unlike" => $ps_unlike_count
				);
		
		echo json_encode($result);
	} else {
		wp_safe_redirect($_SERVER["HTTP_REFERER"]);
	}
	
	exit;
}



function KwsPsPostProcessSynergy() {
	global $wpdb, $ps_ip_address;
	
	// Get request data
	$post_id = (int)$_REQUEST['post_id'];
	$task = $_REQUEST['task'];
	
	$wpdb->show_errors();
	//$valid_tasks = array("like", "unlike", "share", "bookmark");
	//$voting_tasks = array("like", "unlike");

	//if( !in_array( $task, $valid_tasks ) ) {
	if( !in_array( $task, VALID_TASKS ) ) {
		// Check for valid access
		$error = 1;
		$msg = __( 'Access Denied', 'post-synergy' );
	}
	elseif ( !wp_verify_nonce( $_REQUEST['nonce'], 'kws_ps_post_vote_nonce' ) ) {
		// Check for valid access
		$error = 1;
		$msg = __( 'Access Denied', 'post-synergy' );
	} 
	else {
		// Get setting data
		$is_logged_in = is_user_logged_in();
		$login_required = get_option( 'kws_ps_post_login_required' );
		$can_proceed = false;

		//if ( !in_array($task, $voting_tasks) ) {
		if ( !in_array($task, VOTING_TASKS) ) {
			$can_proceed = true;
			$has_already_voted = true;
		} 
		elseif ( $login_required && !$is_logged_in ) {
			// User needs to login to vote but has not logged in
			$error = 1;
			$msg = esc_html(get_option( 'kws_ps_post_login_message' ));
		} 
		else {
			$has_already_voted = HasPsAlreadyVoted( $post_id, $ps_ip_address );
			$voting_period = get_option( 'kws_ps_post_voting_period' );
			$datetime_now = date( 'Y-m-d H:i:s' );
			
			if ( "once" == $voting_period && $has_already_voted ) {
				// User can vote only once and has already voted.
				$error = 1;
				$msg = esc_html(get_option( 'kws_ps_post_voted_message' ));
			} 
			elseif ( '0' == $voting_period ) {
				// User can vote as many times as he want
				$can_proceed = true;
			} 
			else {
				if ( !$has_already_voted ) {
					// Never voted befor so can vote
					$can_proceed = true;
				} 
				else {
					// Get the last date when the user had voted
					$last_voted_date = GetPsLastVotedDate( $post_id, $ps_ip_address );
					
					// Get the bext voted date when user can vote
					$next_vote_date = GetPsNextVoteDate( $last_voted_date, $voting_period );
					
					if ( $next_vote_date > $datetime_now ) {
						$revote_duration = ( strtotime( $next_vote_date ) - strtotime( $datetime_now ) ) / ( 3600 * 24 );
						
						$can_proceed = false;
						$error = 1;
						$msg = __( 'You can vote after', 'post-synergy' ) . ' ' . ceil( $revote_duration ) . ' ' . __( 'day(s)', 'post-synergy' );
					} 
					else {
						$can_proceed = true;
					}
				}
			}
		}
		
		if ( $can_proceed ) {
			$current_user = wp_get_current_user();
			$user_id = (int)$current_user->ID;
			
			IncrementFieldCount( $task, $post_id );
			$success = UpdateTaskLog($task, $user_id, $post_id, $has_already_voted);

			if ($success) {
				$error = 0;
				$msg = esc_html(get_option( 'kws_ps_post_thank_message' ));
			} else {
				$error = 1;
				$msg = __( 'Could not process your vote.', 'post-synergy' );
			}
		}
		
		$options = get_option( 'ps_most_liked_posts' );
		$number = $options['number'];
		$show_count = $options['show_count'];
	}
	
	// Check for method of processing the data
	if ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		//$ps_like_count = GetPsSingleFieldCount( "like", $post_id);
		//$ps_unlike_count = GetPsSingleFieldCount( "unlike", $post_id);
		$all_counts = GetPsFieldsAllCount($post_id);

		$result = array(
					"msg" => $msg,
					"error" => $error,
					"like" => $all_counts[0],
					"unlike" => $all_counts[1],
					"share" => $all_counts[2],
					"bookmark" => $all_counts[3],
					"thumbs_up" => $all_counts[4],
					"thumbs_down" => $all_counts[5],
					//"like" => $ps_like_count,
					//"unlike" => $ps_unlike_count
				);
		
		echo json_encode($result);
	} else {
		wp_safe_redirect($_SERVER["HTTP_REFERER"]);
	}
	
	exit;
}