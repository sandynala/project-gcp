<?php
if (!class_exists('Kws_Elementor_Kit_Category_Image')) {
    class Kws_Elementor_Kit_Category_Image {
        public function __construct() {
            add_action('category_add_form_fields', [$this, 'add_new_category_image'], 10, 2);
            add_action('created_category', [$this, 'save_category_image'], 10, 2);
            add_action('category_edit_form_fields', [$this, 'edit_category_image'], 10, 2);
            add_action('edited_category', [$this, 'updated_category_image'], 10, 2);
            add_action('admin_enqueue_scripts', [$this, 'load_media_files']);
            add_action('admin_footer', [$this, 'load_category_media_scripts']);
        }

        public function add_new_category_image() { ?>
            <div class="form-field term-group-wrap">
                <label for="kek-category-image-id"><?php _e('Image', 'kws-elementor-kit'); ?></label>
                <input type="hidden" id="kek-category-image-id" name="kek-category-image-id" class="kek-hidden-media-url" value="">
                <div id="kek-category-image-wrapper">
                </div>
                <p>
                    <input type="button" class="button button-secondary kek-category-image-add" id="kek-category-image-add" name="kek-category-image-add" value="<?php _e('Add Image', 'kws-elementor-kit'); ?>" />
                    <input type="button" class="button button-secondary kek-category-image-remove" id="kek-category-image-remove" name="kek-category-image-remove" value="<?php _e('Remove Image', 'kws-elementor-kit'); ?>" />
                </p>
            </div>
        <?php
        }
        public function save_category_image($term_id) {
            if (isset($_POST['kek-category-image-id']) && '' !== $_POST['kek-category-image-id']) {
                $image = $_POST['kek-category-image-id'];
                add_term_meta($term_id, 'kek-category-image-id', $image, true);
            }
        }
        public function edit_category_image($term) { ?>
            <tr class="form-field term-group-wrap">
                <th scope="row">
                    <label for="kek-category-image-id"><?php _e('Image', 'kws-elementor-kit'); ?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta($term->term_id, 'kek-category-image-id', true); ?>
                    <input type="hidden" id="kek-category-image-id" name="kek-category-image-id" value="<?php echo $image_id; ?>">
                    <div id="kek-category-image-wrapper">
                        <?php if ($image_id) { ?>
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        <?php } ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary kek-category-image-add" id="kek-category-image-add" name="kek-category-image-add" value="<?php _e('Add Image', 'kws-elementor-kit'); ?>" />
                        <input type="button" class="button button-secondary kek-category-image-remove" id="kek-category-image-remove" name="kek-category-image-remove" value="<?php _e('Remove Image', 'kws-elementor-kit'); ?>" />
                    </p>
                </td>
            </tr>
        <?php
        }

        public function updated_category_image($term_id) {
            if (isset($_POST['kek-category-image-id']) && '' !== $_POST['kek-category-image-id']) {
                $image = $_POST['kek-category-image-id'];
                update_term_meta($term_id, 'kek-category-image-id', $image);
            } else {
                update_term_meta($term_id, 'kek-category-image-id', '');
            }
        }

        public function load_media_files() {
            wp_enqueue_media();
        }

        public function load_category_media_scripts() { ?>
            <script>
                (function($) {
                    $(document).ready(function() {
                        $(".kek-category-image-add.button").on("click", function() {
                            let UPK = wp.media({
                                multiple: false
                            });
                            UPK.on('select', function() {
                                let attachment = UPK.state().get('selection').first().toJSON();
                                $("#kek-category-image-id").val(attachment.id);
                                $("#kek-category-image-url").val(attachment.url);
                                $("#kek-category-image-wrapper").html(`<img width="150" height="150" src='${attachment.url}' />`);
                            });
                            UPK.open();
                            return false;
                        });
                        $('.kek-category-image-remove.button').on("click", function() {
                            $('#kek-category-image-id').val('');
                            $('#kek-category-image-wrapper').html('<img width=150; height=150; class="kek-media-hidden-image" src="" style="margin:0; max-height:100px; padding:0;float:none;" />');
                        })
                    });
                })(jQuery);
            </script>
<?php }
    }

    new Kws_Elementor_Kit_Category_Image();
}
