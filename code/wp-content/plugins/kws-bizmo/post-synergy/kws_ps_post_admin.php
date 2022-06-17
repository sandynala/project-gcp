<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Create the admin menu for this plugin
 * @param no-param
 * @return no-return
 */
function KwsPsPostAdminMenu() {
	add_options_page('Post Synergy', __('Post Synergy', 'post-synergy'), 'activate_plugins', 'KwsPsPostAdminMenu', 'KwsPsPostAdminContent');
}

add_action('admin_menu', 'KwsPsPostAdminMenu');

/**
 * Pluing settings page
 * @param no-param
 * @return no-return
 */
function KwsPsPostAdminContent() {
	// Creating the admin configuration interface
	global $wpdb;
     
	$excluded_sections = get_option('kws_ps_post_excluded_sections');
	$excluded_categories = get_option('kws_ps_post_excluded_categories');
	
	if (empty($excluded_sections)) {
		$excluded_sections = array();
	}
	
	if (empty($excluded_categories)) {
		$excluded_categories = array();
	}
?>
<div class="wrap">
     <h2><?php echo __('KWS Business - Post Synergy', 'post-synergy') . ' v' . BIZMO_VERSION;?></h2>
     <br class="clear" />
	
	<div class="metabox-holder" id="poststuff">
		<div id="post-body">
			<div id="post-body-content">
				<div id="KwsPsPostOptions" class="postbox">
					<h3><big><?php echo __('Configuration', 'post-synergy'); ?></big></h3>
					<div class="inside">
						<form method="post" action="options.php" id="pslp_admin_settings">
							<?php settings_fields('kws_ps_post_options'); ?>
							<table class="form-table">
								<tr valign="top">
									<th scope="row"><label><?php _e('Synergy Period', 'post-synergy'); ?></label></th>
									<td>
										<?php
										$voting_period = get_option('kws_ps_post_voting_period');
										?>
										<select name="kws_ps_post_voting_period" id="kws_ps_post_voting_period">
											<option value="0"><?php echo __('Always can vote', 'post-synergy'); ?></option>
											<option value="once" <?php if ("once" == $voting_period) echo "selected='selected'"; ?>><?php echo __('Only once', 'post-synergy'); ?></option>
											<option value="1" <?php if ("1" == $voting_period) echo "selected='selected'"; ?>><?php echo __('One day', 'post-synergy'); ?></option>
											<option value="2" <?php if ("2" == $voting_period) echo "selected='selected'"; ?>><?php echo __('Two days', 'post-synergy'); ?></option>
											<option value="3" <?php if ("3" == $voting_period) echo "selected='selected'"; ?>><?php echo __('Three days', 'post-synergy'); ?></option>
											<option value="7" <?php if ("7" == $voting_period) echo "selected='selected'"; ?>><?php echo __('One week', 'post-synergy'); ?></option>
											<option value="14" <?php if ("14" == $voting_period) echo "selected='selected'"; ?>><?php echo __('Two weeks', 'post-synergy'); ?></option>
											<option value="21" <?php if ("21" == $voting_period) echo "selected='selected'"; ?>><?php echo __('Three weeks', 'post-synergy'); ?></option>
											<option value="1m" <?php if ("1m" == $voting_period) echo "selected='selected'"; ?>><?php echo __('One month', 'post-synergy'); ?></option>
											<option value="2m" <?php if ("2m" == $voting_period) echo "selected='selected'"; ?>><?php echo __('Two months', 'post-synergy'); ?></option>
											<option value="3m" <?php if ("3m" == $voting_period) echo "selected='selected'"; ?>><?php echo __('Three months', 'post-synergy'); ?></option>
											<option value="6m" <?php if ("6m" == $voting_period) echo "selected='selected'"; ?>><?php echo __('Six Months', 'post-synergy'); ?></option>
											<option value="1y" <?php if ("1y" == $voting_period) echo "selected='selected'"; ?>><?php echo __('One Year', 'post-synergy'); ?></option>
										</select>
										<br><span class="description"><?php _e('Select the voting period after which user can vote again.', 'post-synergy');?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Synergy Style', 'post-synergy'); ?></label></th>
									<td>
										<?php
										$display_style = get_option('kws_ps_post_display_style');
										?>
										<select name="kws_ps_post_display_style" id="kws_ps_post_display_style">
											<option value="hidden" <?php if ("hidden" == $display_style) echo "selected='selected'"; ?>><?php echo __('Hidden', 'post-synergy'); ?></option>
											<option value="style1" <?php if ("style1" == $display_style) echo "selected='selected'"; ?>><?php echo __('Shown', 'post-synergy'); ?></option>
										</select>
										<br><span class="description"><?php _e('Select the display style available options with 3 different sets of images or Hide it.', 'post-synergy'); ?></span>
									</td>
								</tr>			
								<tr valign="top">
									<th scope="row"><label><?php _e('Login required to vote', 'post-synergy'); ?></label></th>
									<td>	
										<input type="radio" name="kws_ps_post_login_required" id="login_yes" value="1" <?php if (1 == get_option('kws_ps_post_login_required')) { echo 'checked'; } ?> /> <?php echo __('Yes', 'post-synergy'); ?>
										<input type="radio" name="kws_ps_post_login_required" id="login_no" value="0" <?php if ((0 == get_option('kws_ps_post_login_required')) || ('' == get_option('kws_ps_post_login_required'))) { echo 'checked'; } ?> /> <?php echo __('No', 'post-synergy'); ?>
											<br><span class="description"><?php _e('Select whether only logged in users can vote or not.', 'post-synergy');?></span>
									</td>
								</tr>			
								<tr valign="top">
									<th scope="row"><label><?php _e('Login required message', 'post-synergy'); ?></label></th>
									<td>	
										<input type="text" size="40" name="kws_ps_post_login_message" id="kws_ps_post_login_message" value="<?php echo esc_html(get_option('kws_ps_post_login_message')); ?>" />
										<br><span class="description"><?php _e('Message to show in case login required and user is not logged in.', 'post-synergy');?></span>
									</td>
								</tr>			
								<tr valign="top">
									<th scope="row"><label><?php _e('Thank you message', 'post-synergy'); ?></label></th>
									<td>	
										<input type="text" size="40" name="kws_ps_post_thank_message" id="kws_ps_post_thank_message" value="<?php echo esc_html(get_option('kws_ps_post_thank_message')); ?>" />
										<br><span class="description"><?php _e('Message to show after successful voting.', 'post-synergy');?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Already voted message', 'post-synergy'); ?></label></th>
									<td>	
										<input type="text" size="40" name="kws_ps_post_voted_message" id="kws_ps_post_voted_message" value="<?php echo esc_html(get_option('kws_ps_post_voted_message')); ?>" />
										<br><span class="description"><?php _e('Message to show if user has already voted.', 'post-synergy');?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Show on pages', 'post-synergy'); ?></label></th>
									<td>	
										<input type="radio" name="kws_ps_post_show_on_pages" id="show_pages_yes" value="1" <?php if (('1' == get_option('kws_ps_post_show_on_pages'))) { echo 'checked'; } ?> /> <?php echo __('Yes', 'post-synergy'); ?>
										<input type="radio" name="kws_ps_post_show_on_pages" id="show_pages_no" value="0" <?php if ('0' == get_option('kws_ps_post_show_on_pages') || ('' == get_option('kws_ps_post_show_on_pages'))) { echo 'checked'; } ?> /> <?php echo __('No', 'post-synergy'); ?>
										<br><span class="description"><?php _e('Select yes if you want to show the like option on pages as well.', 'post-synergy')?></span>
									</td>
								</tr>	
								<tr valign="top">
									<th scope="row"><label><?php _e('Exclude on selected sections', 'post-synergy'); ?></label></th>
									<td>
										<input type="checkbox" name="kws_ps_post_excluded_sections[]" id="kws_ps_post_excluded_home" value="home" <?php if (in_array('home', $excluded_sections)) { echo 'checked'; } ?> /> <?php echo __('Home', 'post-synergy'); ?>
										<input type="checkbox" name="kws_ps_post_excluded_sections[]" id="kws_ps_post_excluded_archive" value="archive" <?php if (in_array('archive', $excluded_sections)) { echo 'checked'; } ?> /> <?php echo __('Archive', 'post-synergy'); ?>
										<br><span class="description"><?php _e('Check the sections where you do not want to avail the like/dislike options. This has higher priority than the "Exclude post/page IDs" setting.', 'post-synergy');?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Exclude selected categories', 'post-synergy'); ?></label></th>
									<td>	
										<select name='kws_ps_post_excluded_categories[]' id='kws_ps_post_excluded_categories' multiple="multiple" size="4" style="height:auto !important;">
											<?php 
											$categories=  get_categories();
											
											foreach ($categories as $category) {
												$selected = (in_array($category->cat_ID, $excluded_categories)) ? 'selected="selected"' : '';
												$option  = '<option value="' . $category->cat_ID . '" ' . $selected . '>';
												$option .= $category->cat_name;
												$option .= ' (' . $category->category_count . ')';
												$option .= '</option>';
												echo $option;
											}
											?>
										</select>
										<br><span class="description"><?php _e('Select categories where you do not want to show the like option. It has higher priority than "Exclude post/page IDs" setting.', 'post-synergy');?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Allow post IDs', 'post-synergy'); ?></label></th>
									<td>	
										<input type="text" size="40" name="kws_ps_post_allowed_posts" id="kws_ps_post_allowed_posts" value="<?php echo esc_html(get_option('kws_ps_post_allowed_posts')); ?>" />
										<br><span class="description"><?php _e('Suppose you have a post which belongs to more than one categories and you have excluded one of those categories. So the like/dislike will not be available for that post. Enter comma separated those post ids where you want to show the like/dislike option irrespective of that post category being excluded.', 'post-synergy');?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Exclude post/page IDs', 'post-synergy'); ?></label></th>
									<td>	
										<input type="text" size="40" name="kws_ps_post_excluded_posts" id="kws_ps_post_excluded_posts" value="<?php echo esc_html(get_option('kws_ps_post_excluded_posts')); ?>" />
										<br><span class="description"><?php _e('Enter comma separated post/page ids where you do not want to show the like option. If Show on pages setting is set to Yes but you have added the page id here, then like option will not be shown for the same page.', 'post-synergy');?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Show excluded posts/pages on widget', 'post-synergy'); ?></label></th>
									<td>	
										<input type="radio" name="kws_ps_post_show_on_widget" id="show_widget_yes" value="1" <?php if (('1' == get_option('kws_ps_post_show_on_widget')) || ('' == get_option('kws_ps_post_show_on_widget'))) { echo 'checked'; } ?> /> <?php echo __('Yes', 'post-synergy'); ?>
										<input type="radio" name="kws_ps_post_show_on_widget" id="show_widget_no" value="0" <?php if ('0' == get_option('kws_ps_post_show_on_widget')) { echo 'checked'; } ?> /> <?php echo __('No', 'post-synergy'); ?>
										<br><span class="description"><?php _e('Select yes if you want to show the excluded posts/pages on widget.', 'post-synergy')?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Position Setting', 'post-synergy'); ?></label></th>
									<td>	
										<input type="radio" name="kws_ps_post_position" id="position_top" value="top" <?php if (('top' == get_option('kws_ps_post_position')) || ('' == get_option('kws_ps_post_position'))) { echo 'checked'; } ?> /> <?php echo __('Top of Content', 'post-synergy'); ?>
										<input type="radio" name="kws_ps_post_position" id="position_bottom" value="bottom" <?php if ('bottom' == get_option('kws_ps_post_position')) { echo 'checked'; } ?> /> <?php echo __('Bottom of Content', 'post-synergy'); ?>
										<br><span class="description"><?php _e('Select the position where you want to show the like options.', 'post-synergy')?></span>
									</td>
								</tr>			
								<tr valign="top">
									<th scope="row"><label><?php _e('Alignment Setting', 'post-synergy'); ?></label></th>
									<td>	
										<input type="radio" name="kws_ps_post_alignment" id="alignment_left" value="left" <?php if (('left' == get_option('kws_ps_post_alignment')) || ('' == get_option('kws_ps_post_alignment'))) { echo 'checked'; } ?> /> <?php echo __('Left', 'post-synergy'); ?>
										<input type="radio" name="kws_ps_post_alignment" id="alignment_right" value="right" <?php if ('right' == get_option('kws_ps_post_alignment')) { echo 'checked'; } ?> /> <?php echo __('Right', 'post-synergy'); ?>
										<br><span class="description"><?php _e('Select the alignment whether to show on left or on right.', 'post-synergy')?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"><label><?php _e('Title text for like/unlike images', 'post-synergy'); ?></label></th>
									<td>
										<input type="text" name="kws_ps_post_title_text" id="kws_ps_post_title_text" value="<?php echo esc_html(get_option('kws_ps_post_title_text')); ?>" />
										<br><span class="description"><?php echo __('Enter both texts separated by "/" to show when user puts mouse over like/unlike images.', 'post-synergy')?></span>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row"></th>
									<td>
										<input class="button-primary" type="submit" name="Save" value="<?php _e('Save Options', 'post-synergy'); ?>" />
										<input class="button-secondary" type="submit" name="Reset" value="<?php _e('Reset Options', 'post-synergy'); ?>" onclick="return confirmReset()" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>		
		</div>
	
		<script>
		function confirmReset()
		{
			// Check whether user agrees to reset the settings to default or not
			var check = confirm("<?php _e('Are you sure to reset the options to default settings?', 'post-synergy')?>");
			
			if (check) {
				// Reset the settings
				document.getElementById('kws_ps_post_voting_period').value = 'once';
				document.getElementById('kws_ps_post_display_style').value = 'hidden';
				document.getElementById('login_yes').checked = false;
				document.getElementById('login_no').checked = true;
				document.getElementById('kws_ps_post_login_message').value = "<?php echo __('Please login to vote.', 'post-synergy'); ?>";
				document.getElementById('kws_ps_post_thank_message').value = "<?php echo __('Thanks for your vote.', 'post-synergy'); ?>";
				document.getElementById('kws_ps_post_voted_message').value = "<?php echo __('You have already voted.', 'post-synergy'); ?>";
				document.getElementById('show_pages_yes').checked = false;
				document.getElementById('show_pages_no').checked = true;
				document.getElementById('kws_ps_post_allowed_posts').value = '';
				document.getElementById('kws_ps_post_excluded_posts').value = '';
				document.getElementById('kws_ps_post_excluded_categories').selectedIndex = -1;
				document.getElementById('kws_ps_post_excluded_home').value = '';
				document.getElementById('kws_ps_post_excluded_archive').value = '';
				document.getElementById('show_widget_yes').checked = true;
				document.getElementById('show_widget_no').checked = false;
				document.getElementById('position_top').checked = false;
				document.getElementById('position_bottom').checked = true;
				document.getElementById('alignment_left').checked = true;
				document.getElementById('alignment_right').checked = false;
				document.getElementById('kws_ps_post_title_text').value = "<?php echo __('Like/Unlike', 'post-synergy'); ?>";
				
				return true;
			}
			
			return false;
		}
		
		function processAll()
		{
			var cfm = confirm('<?php echo __('Are you sure to reset all the counts present in the database?', 'post-synergy')?>');
			
			if (cfm) {
				return true;
			} else {
				return false;
			}
		}
		
		function processSelected()
		{
			var cfm = confirm('<?php echo __('Are you sure to reset selected counts present in the database?', 'post-synergy')?>');
			
			if (cfm) {
				return true;
			} else {
				return false;
			}
		}
		</script>
		
		<?php
		if (isset($_POST['resetall'])) {
			if (wp_verify_nonce( $_POST['_wpnonce'], 'kws_ps_post_lite_reset_counts_nonce' )) {
				$status = $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}kws_ps_post");
				if ($status) {
					echo '<div class="updated" id="message"><p>';
					echo __('All counts have been reset successfully.', 'post-synergy');
					echo '</p></div>';
				} else {
					echo '<div class="error" id="error"><p>';
					echo __('All counts could not be reset.', 'post-synergy');
					echo '</p></div>';
				}
			} else {
				echo '<div class="error" id="error"><p>';
				echo __('Invalid access to reset all counts.', 'post-synergy');
				echo '</p></div>';
			}
		}

		if (isset($_POST['resetselected'])) {
			if (wp_verify_nonce( $_POST['_wpnonce'], 'kws_ps_post_lite_reset_counts_nonce' )) {
				if (count($_POST['post_ids']) > 0) {
					// Filter proper values
					$all_ids = array_map(function($value) {
						return (int) $value;
					}, $_POST['post_ids']);

					$post_ids = implode(",", array_filter($all_ids));

					$status = $wpdb->query(
						"DELETE FROM {$wpdb->prefix}kws_ps_post WHERE post_id IN ($post_ids)"
					);

					if ($status) {
						echo '<div class="updated" id="message"><p>';

						if ($status > 1) {
							echo $status . ' ' . __('counts were reset successfully.', 'post-synergy');
						} else {
							echo $status . ' ' . __('count was reset successfully.', 'post-synergy');
						}
						
						echo '</p></div>';
					} else {
						echo '<div class="error" id="error"><p>';
						echo __('Selected counts could not be reset.', 'post-synergy');
						echo '</p></div>';
					}
				} else {
					echo '<div class="error" id="error"><p>';
					echo __('Please select posts to reset count.', 'post-synergy');
					echo '</p></div>';
				}
			} else {
				echo '<div class="error" id="error"><p>';
				echo __('Invalid access to reset selected counts.', 'post-synergy');
				echo '</p></div>';
			}
		}
		?>
		<!--
		<div class="clearfix"></div>
		<div class="ui-sortable meta-box-sortables" style="clear:left">
			<h2><?php _e('Most Liked Posts', 'post-synergy');?></h2>
			<?php
			// Getting the most liked posts
			$query = "SELECT COUNT(post_id) AS total
					    FROM `{$wpdb->prefix}kws_ps_post` L JOIN {$wpdb->prefix}posts P ON L.post_id = P.ID 
					   WHERE value > 0";
			$post_count = $wpdb->get_var($query);
	   
			if ($post_count > 0) {
	
				// Pagination script
				$limit = get_option('posts_per_page');
				
				if ( isset( $_GET['paged'] ) ) {
					$current = max( 1, $_GET['paged'] );
				} else {
					$current = 1;
				}
				
				$total_pages = ceil($post_count / $limit);
				$start = $current * $limit - $limit;
				
				$query = $wpdb->prepare(
					"SELECT post_id, SUM(likes) AS like_count, SUM(unlikes) AS unlike_count, SUM(shares) AS share_count, post_title
					   FROM `{$wpdb->prefix}kws_ps_post` L JOIN {$wpdb->prefix}posts P ON L.post_id = P.ID 
					  WHERE value > 0 
					  GROUP BY post_id
					  ORDER BY like_count DESC, unlike_count DESC, share_count DESC, post_title LIMIT %d, %d",
					$start, $limit
				);

				$result = $wpdb->get_results($query);
				?>
				<form method="post" action="<?php echo admin_url('options-general.php?page=KwsPsPostAdminMenu'); ?>" name="most_liked_posts_form" id="most_liked_posts_form">
					<div style="float:left">
						<?php
						wp_nonce_field('kws_ps_post_lite_reset_counts_nonce');
						?>
						<input class="button-secondary" type="submit" name="resetall" id="resetall" onclick="return processAll()" value="<?php echo __('Reset All Counts', 'post-synergy')?>" />
						<input class="button-secondary" type="submit" name="resetselected" id="resetselected" onclick="return processSelected()" value="<?php echo __('Reset Selected Counts', 'post-synergy')?>" />
					</div>
					<div style="float:right">
						<div class="tablenav top">
							<div class="tablenav-pages">
								<span class="displaying-num"><?php echo $post_count?> <?php echo __('items', 'post-synergy'); ?></span>
								<?php
								echo paginate_links(
									array(
										'current' 	=> $current,
										'prev_text'	=> '&laquo; ' . __('Prev', 'post-synergy'),
										'next_text'    	=> __('Next', 'post-synergy') . ' &raquo;',
										'base' 		=> @add_query_arg('paged','%#%'),
										'format'  	=> '?page=KwsPsPostAdminMenu',
										'total'   	=> $total_pages
									)
								);
								?>
							</div>
						</div>
					</div>
					<?php
					echo '<table cellspacing="0" class="wp-list-table widefat fixed likes">';
					echo '<thead><tr><th class="manage-column column-cb check-column" id="cb" scope="col" style="padding: 12px 0px 12px 4px;">';
					echo '<input type="checkbox" id="checkall">';
					echo '</th><th>';
					echo __('Post Title', 'post-synergy');
					echo '</th><th>';
					echo __('Likes', 'post-synergy');
					echo '</th><th>';
					echo __('Unlikes', 'post-synergy');
					echo '</th><th>';
					echo __('Shares', 'post-synergy');
					echo '</th><tr></thead>';
					echo '<tbody class="list:likes" id="the-list">';
					
					foreach ($result as $post) {
						$post_title = esc_html($post->post_title);
						$permalink = get_permalink($post->post_id);
						$like_count = $post->like_count;
						$unlike_count = $post->unlike_count;
						$share_count = $post->share_count;
						
						echo '<tr>';
						echo '<th class="check-column" scope="row" align="center"><input type="checkbox" value="' . $post->post_id . '" class="administrator" id="post_id_' . $post->post_id . '" name="post_ids[]"></th>';
						echo '<td><a href="' . $permalink . '" title="' . $post_title . '" target="_blank">' . $post_title . '</a></td>';
						echo '<td>' . $like_count . '</td>';
						echo '<td>' . $unlike_count . '</td>';
						echo '<td>' . $share_count . '</td>';
						echo '</tr>';
					}
		 		
					echo '</tbody></table>';
				?>
				</form>
				<?php
			} else {
				echo '<p>';
				echo __('No posts liked yet.', 'post-synergy');
				echo '</p>';
			}
			?>
		</div>
		-->
     </div>
</div>
<?php
}

// For adding metabox for posts/pages
add_action('admin_menu', 'KwsPsPostAddMetaBox');

/**
 * Metabox for for like post
 * @param no-param
 * @return no-return
 */
function KwsPsPostAddMetaBox() {
	// Add the meta box for posts/pages
     add_meta_box('post-synergy-meta-box', __('Post Synergy Exclude Option', 'post-synergy'), 'KwsPsPostShowMetaBox', 'post', 'side', 'high');
     add_meta_box('post-synergy-meta-box', __('Post Synergy Exclude Option', 'post-synergy'), 'KwsPsPostShowMetaBox', 'page', 'side', 'high');
}

/**
 * Callback function to show fields in meta box
 * @param no-param
 * @return string
 */
function KwsPsPostShowMetaBox() {
	global $post;

	// Use nonce for verification
	echo '<input type="hidden" name="kws_ps_post_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

     // Get whether current post is excluded or not
	$excluded_posts = explode(',', esc_html(get_option('kws_ps_post_excluded_posts')));

	if (in_array($post->ID, $excluded_posts)) {
		$checked = 'checked="checked"';
	} else {
		$checked = '';
	}

	echo '<p>';    
	echo '<label for="ps_exclude_post"><input type="checkbox" name="ps_exclude_post" id="ps_exclude_post" value="1" ', $checked, ' /> ';
	echo __('Check to disable like/unlike functionality', 'post-synergy');
	echo '</label>';
	echo '</p>';
}

add_action('save_post', 'KwsPsPostSaveData');

/**
 * Save data from meta box
 * @param no-param
 * @return string
 */
function KwsPsPostSaveData($post_id) {
     // Verify nonce
     if ( empty( $_POST['kws_ps_post_meta_box_nonce'] ) ||
	     !wp_verify_nonce( $_POST['kws_ps_post_meta_box_nonce'], basename(__FILE__) ) ) {
          return $post_id;
     }
    
     // Check autosave
     if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
          return $post_id;
     }
    
     // Check permissions
     if ('page' == $_POST['post_type']) {
          if (!current_user_can('edit_page', $post_id)) {
               return $post_id;
          }
     } elseif (!current_user_can('edit_post', $post_id)) {
          return $post_id;
     }

	// Initialise the excluded posts array
	$excluded_posts = array();
	$exc_posts = esc_html(get_option('kws_ps_post_excluded_posts'));

	// Check whether this post/page is to be excluded
	$exclude_post = isset( $_POST['ps_exclude_post'] ) ? $_POST['ps_exclude_post'] : 0;
	
	// Get old excluded posts/pages
	if (strlen($exc_posts) > 0) {
		$excluded_posts = explode(',', $exc_posts);
	}
	
	if ($exclude_post == 1 && !in_array($post_id, $excluded_posts)) {
		// Add this post/page id to the excluded list
		$excluded_posts[] = (int) $post_id;
		
		if (!empty($excluded_posts)) {
			// Since there are already excluded posts/pages, add this as a comma separated value
			update_option('kws_ps_post_excluded_posts', implode(',', $excluded_posts));
		} else {
			// Since there is no old excluded post/page, add this directly
			update_option('kws_ps_post_excluded_posts', $post_id);
		}
	} else if (!$exclude_post) {
		// Check whether this id is already in the excluded list or not
		$key = array_search($post_id, $excluded_posts);
		
		if ($key !== false) {
			// Since this is already in the list, so exluded this
			unset($excluded_posts[$key]);
			
			// Update the excluded posts list
			update_option('kws_ps_post_excluded_posts', implode(',', $excluded_posts));
		}
	}
}

/**
 * Add the javascript for admin of the plugin
 * @param no-param
 * @return string
 */
function KwsPsPostEnqueueAdminScripts() {
	wp_register_script( 'kws_ps_post_admin_script', plugins_url( 'js/kws_ps_post_admin.js', __FILE__ ), array('jquery') );
	wp_localize_script( 'kws_ps_post_admin_script', 'pslp', array(
												    'ajax_url' => admin_url( 'admin-ajax.php' ),
												)
				    );
  
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'kws_ps_post_admin_script' );
}