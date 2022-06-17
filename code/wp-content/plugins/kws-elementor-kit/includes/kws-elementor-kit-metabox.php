<?php
if (!class_exists('Kws_Elementor_Kit_Metabox')) {
    class Kws_Elementor_Kit_Metabox {

        public function __construct() {
            $video_link = kws_elementor_kit_option('video_link', 'kws_elementor_kit_other_settings', 'off');
            if ($video_link == 'on') {
                add_action('admin_init', [$this, 'kek_video_link_metabox_fields']);
                add_action('save_post', [$this, 'kek_video_link_save_metabox']);
            }
        }

        public function kek_video_link_metabox_fields() {
            add_meta_box('kek_video_link_metabox', __('KWS Elementor Kit Additional'), [$this, 'kek_video_link_metabox_callback'], 'post', 'side', 'default');
        }
        public function kek_video_link_metabox_callback($post) {
            wp_nonce_field('kek_video_link_nonce_action', 'kek_video_link_nonce_field');
            $video_label     = esc_html__('Video Link', 'kws-elementor-kit');
            $video_link      = get_post_meta($post->ID, '_kek_video_link_meta_key', true);
            $display_content = <<<BDT
            <div class="kek-video-link-form-group">
                <label for="_kek_video_link_meta_key">{$video_label}</label>
                <input type="text" class="widefat" name="_kek_video_link_meta_key" id="_kek_video_link_meta_key" value="{$video_link}">
            </div>
BDT;
            echo $display_content;
        }

        public function kek_video_link_save_metabox($post_id) {
            if (!$this->is_secured_nonce('kek_video_link_nonce_action', 'kek_video_link_nonce_field', $post_id)) {
                return $post_id;
            }

            $video_link = isset($_POST['_kek_video_link_meta_key']) ? $_POST['_kek_video_link_meta_key'] : '';
            $video_link = sanitize_text_field($video_link);
            update_post_meta($post_id, '_kek_video_link_meta_key', $video_link);
        }


        public function is_secured_nonce($action, $nonce_field, $post_id) {
            $nonce = isset($_POST[$nonce_field]) ? $_POST[$nonce_field] : '';
            if ($nonce == '') {
                return false;
            } elseif (!wp_verify_nonce($nonce, $action)) {
                return false;
            } elseif (!current_user_can('edit_post', $post_id)) {
                return false;
            } elseif (wp_is_post_autosave($post_id)) {
                return false;
            } elseif (wp_is_post_revision($post_id)) {
                return false;
            } else {
                return true;
            }
        }
    }
    new Kws_Elementor_Kit_Metabox();
}
