<?php

namespace KwsElementorKit\Traits;

use KwsElementorKit\Utils;

defined( 'ABSPATH' ) || die();

trait Global_Widget_Functions {

    function render_image($image_id, $size) {
		$placeholder_image_src = Utils::get_placeholder_image_src();
		$image_src = wp_get_attachment_image_src($image_id, $size);
		if (!$image_src) {
			$image_src = $placeholder_image_src;
		} else {
			$image_src = $image_src[0];
		}
		?>
		<img class="kek-img" src="<?php echo esc_url($image_src); ?>" alt="<?php echo esc_html(get_the_title()); ?>">
		<?php
	}

    function render_title() {
		$settings = $this->get_settings_for_display();
		if (!$this->get_settings('show_title')) {
			return;
		}
		$this->add_render_attribute('post-title', 'class', 'kek-title', true);
		$titleClass = $this->get_render_attribute_string('post-title');
		?>
		<<?php echo Utils::get_valid_html_tag($settings['title_tags']) .' '. $titleClass ?>>
			<a href="<?php echo esc_url(get_permalink()) ?>" class="title-animation-<?php echo $settings['title_style']; ?>" title="<?php echo esc_html(get_the_title()) ?>">
				<?php echo esc_html(get_the_title())  ?>
			</a>
		</<?php echo Utils::get_valid_html_tag($settings['title_tags']) ?>>
		<?php
	}

    function render_category() {
		if (!$this->get_settings('show_category')) {
			return;
		}
		?>
		<div class="kek-category">
			<?php echo kek_get_category($this->get_settings('posts_source')); ?>
		</div>
		<?php
	}

    function render_date() {
		$settings = $this->get_settings_for_display();
		if (!$this->get_settings('show_date')) {
			return;
		}
		?>
		<div class="kek-date">
			<?php if ($settings['human_diff_time'] == 'yes') {
				echo kws_elementor_kit_post_time_diff(($settings['human_diff_time_short'] == 'yes') ? 'short' : '');
			} else {
				echo get_the_date();
			} ?>
		</div>
		
		<?php if ($settings['show_time']) : ?>
			<div class="kek-post-time">
				<i class="kek-icon-clock" aria-hidden="true"></i>
				<?php echo get_the_time(); ?>
			</div>
		<?php endif; ?>
		<?php
	}

    function render_excerpt($excerpt_length ) {
		if ( ! $this->get_settings('show_excerpt') ) { return; }
		$strip_shortcode = $this->get_settings_for_display('strip_shortcode');
		?>
		<div class="kek-text">
		<?php
			if ( has_excerpt() ) {
				the_excerpt();
			} else {
				echo kws_elementor_kit_custom_excerpt( $excerpt_length , $strip_shortcode);
			}
        ?>
		</div>
		<?php
	}

}