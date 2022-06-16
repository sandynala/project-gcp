<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class MostLikedPostsWidget extends WP_Widget
{
     function __construct() {
	     load_plugin_textdomain( 'post-synergy', false, 'post-synergy/lang' );
          $widget_ops = array('description' => __('Widget to display most liked posts for a given time range.', 'post-synergy'));
          parent::__construct(false, $name = __('Most Liked Posts', 'post-synergy'), $widget_ops);
     }

     /** @see WP_Widget::widget */
     function widget($args, $instance) {
          global $MostLikedPosts;
          $MostLikedPosts->widget($args, $instance); 
     }
    
     function update($new_instance, $old_instance) {         
          if ( $new_instance['title'] == '' ) {
               $new_instance['title'] = __('Most Liked Posts', 'post-synergy');
          }
		
		if ( $new_instance['time_range'] == '' ) {
               $new_instance['time_range'] = 'all';
          }
		
		if ( empty( $new_instance['number']) ) {
               $new_instance['number'] = 10;
          }
		
		if ( !isset( $new_instance['show_count'] ) ) {
               $new_instance['show_count'] = 0;
          }
		
          return $new_instance;
     }
    
     function form($instance) {
          global $MostLikedPosts;
		
		/**
		* Define the array of defaults
		*/ 
		$defaults = array(
					'title' => __('Most Liked Posts', 'post-synergy'),
					'number' => 10,
					'time_range' => 'all',
					'show_count' => ''
				);
		
		$instance = wp_parse_args( $instance, $defaults );
		extract( $instance, EXTR_SKIP );
		
		$time_range_array = array(
							'all' => __('All time', 'post-synergy'),
							'1' => __('Last one day', 'post-synergy'),
							'2' => __('Last two days', 'post-synergy'),
							'3' => __('Last three days', 'post-synergy'),
							'7' => __('Last one week', 'post-synergy'),
							'14' => __('Last two weeks', 'post-synergy'),
							'21' => __('Last three weeks', 'post-synergy'),
							'1m' => __('Last one month', 'post-synergy'),
							'2m' => __('Last two months', 'post-synergy'),
							'3m' => __('Last three months', 'post-synergy'),
							'6m' => __('Last six months', 'post-synergy'),
							'1y' => __('Last one year', 'post-synergy')
						);
		
		$show_types = array('most_liked' => __('Most Liked', 'post-synergy'), 'recent_liked' => __('Recently Liked', 'post-synergy'));
		
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
      	?>
		<p>
           	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'post-synergy'); ?>:<br />
           	<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_html($title);?>" /></label>
      	</p>
		<p>
           	<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of posts to show', 'post-synergy'); ?>:<br />
           	<input type="number" class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" size="3" value="<?php echo $instance['number'];?>" /></label>
      		<small>(<?php echo __('Default', 'post-synergy'); ?> 10)</small>
      	</p>
		<p>
           	<label for="<?php echo $this->get_field_id('time_range'); ?>"><?php _e('Time range', 'post-synergy'); ?>:<br />
			<select name="<?php echo $this->get_field_name('time_range'); ?>" id="<?php echo $this->get_field_id('time_range'); ?>">
			<?php
			foreach ( $time_range_array as $time_range_key => $time_range_value ) {
				$selected = ($time_range_key == $instance['time_range']) ? 'selected' : '';
				echo '<option value="' . $time_range_key . '" ' . $selected . '>' . $time_range_value . '</option>';
			}
			?>
			</select>
      	</p>
		<p>
           	<label for="<?php echo $this->get_field_id('show_count'); ?>"><input type="checkbox" id="<?php echo $this->get_field_id('show_count'); ?>" name="<?php echo $this->get_field_name('show_count'); ?>" value="1" <?php if(isset($instance['show_count']) && $instance['show_count'] == '1') echo 'checked="checked"'; ?> /> <?php _e('Show like count', 'post-synergy'); ?></label>
      	</p>
		<input type="hidden" id="ps-most-submit" name="ps-submit" value="1" />	   
      	<?php
     }
}

class PsMostLikedPosts
{
     function __construct() {
          add_action( 'widgets_init', array(&$this, 'init') );
     }
    
     function init() {
          register_widget("MostLikedPostsWidget");
     }
     
     function widget($args, $instance = array() ) {
		global $wpdb;
		extract($args);
	    
		$where = '';
		$limit = '';
		$title = $instance['title'];
		$show_count = $instance['show_count'];
		$time_range = $instance['time_range'];
		//$show_type = $instance['show_type'];
		$order_by = 'ORDER BY like_count DESC, post_title';
		$num_posts = intval($instance['number']);

		if( $num_posts > 0 ) {
			$limit = "LIMIT " . $num_posts;
		}
		
		$widget_data  = $before_widget;
		$widget_data .= $before_title . esc_html($title) . $after_title;
		$widget_data .= '<ul class="ps-most-liked-posts">';
	
		$show_excluded_posts = get_option('kws_ps_post_show_on_widget');
		$excluded_posts = esc_html(get_option('kws_ps_post_excluded_posts'));
		$excluded_post_ids = explode(',', $excluded_posts);
		
		if( !$show_excluded_posts && count( $excluded_post_ids ) > 0 ) {
			$where = "AND post_id NOT IN (" . $excluded_posts . ")";
		}
		
		if ( $time_range != 'all' ) {
			$last_date = GetPsLastDate($time_range);
			$where .= " AND date_time >= '$last_date'";
		}
		
		// Getting the most liked posts
		$query = "SELECT post_id, SUM(value) AS like_count, post_title
				    FROM `{$wpdb->prefix}kws_ps_post` L, {$wpdb->prefix}posts P 
				   WHERE L.post_id = P.ID AND post_status = 'publish' AND value > 0 $where 
				   GROUP BY post_id $order_by $limit";
		
		$posts = $wpdb->get_results($query);

		if ( count( $posts ) > 0 ) {
			foreach ( $posts as $post ) {
				$post_title = esc_html($post->post_title);
				$permalink = get_permalink($post->post_id);
				$like_count = $post->like_count;
				
				$widget_data .= '<li><a href="' . $permalink . '" title="' . $post_title . '">' . $post_title . '</a>';
				$widget_data .= $show_count == '1' ? ' (' . $like_count . ')' : '';
				$widget_data .= '</li>';
			}
		} else {
			$widget_data .= '<li>';
			$widget_data .= __('No posts liked yet.', 'post-synergy');
			$widget_data .= '</li>';
		}
   
		$widget_data .= '</ul>';
		$widget_data .= $after_widget;
   
		echo $widget_data;
     }
}

$MostLikedPosts = new PsMostLikedPosts();

//recently like posts
class RecentlyLikedPostsWidget extends WP_Widget
{
     function __construct() {
	     load_plugin_textdomain( 'post-synergy', false, 'post-synergy/lang' );
          $widget_ops = array('description' => __('Widget to show recently liked posts.', 'post-synergy'));
          parent::__construct(false, $name = __('Recently Liked Posts', 'post-synergy'), $widget_ops);
     }

     function widget($args, $instance) {
          global $RecentlyLikedPosts;
          $RecentlyLikedPosts->widget($args, $instance); 
     }
    
     function update($new_instance, $old_instance) {         
          if($new_instance['title'] == ''){
               $new_instance['title'] = __('Recently Liked Posts', 'post-synergy');
          }
         
          if($new_instance['number'] == ''){
               $new_instance['number'] = 10;
          }
         
          return $new_instance;
     }
    
     function form($instance) {
		global $RecentlyLikedPosts;
		
		/**
		* Define the array of defaults
		*/ 
		$defaults = array(
			'title' => __('Recently Liked Posts', 'post-synergy'),
			'number' => 10
		);
		
		$instance = wp_parse_args( $instance, $defaults );
		extract( $instance, EXTR_SKIP );
      	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'post-synergy'); ?>:<br />
           	<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_html($instance['title']);?>" /></label>
      	</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of entries to show', 'post-synergy'); ?>:<br />
			<input type="number" class="tiny-text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" style="width: 40px;" value="<?php echo $instance['number'];?>" /> <small>(<?php echo __('Default', 'post-synergy'); ?> 10)</small></label>
      	</p>
		<input type="hidden" id="ps-recent-submit" name="ps-submit" value="1" />	   
      	<?php
     }
}

class RecentlyLikedPosts
{
     function __construct() {
          add_action( 'widgets_init', array(&$this, 'init') );
     }
    
     function init() {
          register_widget("RecentlyLikedPostsWidget");
     }
     
     function widget( $args, $instance = array() ) {
		global $wpdb;
		extract($args);
		
		$recent_id = array();
		$where = '';
		$title = $instance['title'];
		$number = intval($instance['number']);
		
		$widget_data  = $before_widget;
		$widget_data .= $before_title . esc_html($title) . $after_title;
		$widget_data .= '<ul class="ps-most-liked-posts ps-user-liked-posts">';
	
		$show_excluded_posts = get_option('kws_ps_post_show_on_widget');
		$excluded_posts = esc_html(get_option('kws_ps_post_excluded_posts'));
		
		if ( !$show_excluded_posts && !empty( $excluded_posts ) ) {
			$where = "AND post_id NOT IN (" . $excluded_posts . ")";
		}
		
		// Get the post IDs recently voted
		$recent_ids = $wpdb->get_col(
							"SELECT DISTINCT(post_id) FROM `{$wpdb->prefix}kws_ps_post`
							  WHERE value > 0 $where 
							  GROUP BY post_id 
							  ORDER BY MAX(date_time) DESC"
						);

		if(count($recent_ids) > 0) {
			$where = "AND post_id IN(" . implode(",", $recent_ids) . ")";
			
			// Getting the most liked posts
			$query = "SELECT post_id, post_title 
			            FROM `{$wpdb->prefix}kws_ps_post` L, {$wpdb->prefix}posts P 
					   WHERE L.post_id = P.ID AND post_status = 'publish' $where 
					   GROUP BY post_id
					   ORDER BY FIELD(post_id, " . implode(",", $recent_ids) . ") ASC LIMIT $number";

			$posts = $wpdb->get_results($query);
		 	
			if(count($posts) > 0) {
				foreach ($posts as $post) {
					$post_title = esc_html($post->post_title);
					$permalink = get_permalink($post->post_id);
					
					$widget_data .= '<li><a href="' . $permalink . '" title="' . $post_title . '">' . $post_title . '</a></li>';
				}
			}
		} else {
			$widget_data .= '<li>';
			$widget_data .= __('No posts liked yet.', 'post-synergy');
			$widget_data .= '</li>';
		}

		$widget_data .= '</ul>';
		$widget_data .= $after_widget;

		echo $widget_data;
     }
}

$RecentlyLikedPosts = new RecentlyLikedPosts();
?>