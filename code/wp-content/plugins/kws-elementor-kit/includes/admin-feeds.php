<?php

namespace KwsElementorKit;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class Kws_Elementor_Kit_Admin_Feeds {

    public function __construct() {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_styles']);
        add_action('wp_dashboard_setup', [$this, 'kws_elementor_kit_register_rss_feeds'], 9999999999);
    }

    public function enqueue_styles() {
        $suffix = is_rtl() ? '.rtl' : '';
        wp_enqueue_style('kws-elementor-kit-admin', CFTKEK_URL . 'admin/assets/css/admin' . $suffix . '.css', [], CFTKEK_VER);
    }
    /**
     * KWS Elementor Kit Feeds Register
     */

    public function kws_elementor_kit_register_rss_feeds() {
        wp_add_dashboard_widget('cft-kek-dashboard-overview', esc_html__('KWS Elementor Kit News &amp; Updates', 'kws-elementor-kit'), [$this, 'kws_elementor_kit_rss_feeds_content_data']);
    }

    /**
     * KWS Elementor Kit dashboard overview fetch content data
     */
    public function kws_elementor_kit_rss_feeds_content_data() {
        echo '<div class="cft-kek-dashboard-widget">';
        $feeds = $this->kws_elementor_kit_get_feeds_remote_data();
        foreach ($feeds as $key => $feed) {
            printf('<div class="cft-product-feeds-content activity-block"><a href="%s" target="_blank"><img class="cft-kek-promo-image" src="%s"></a> <p>%s</p></div>', $feed->demo_link, $feed->image, $feed->content);
        }
        echo $this->kws_elementor_kit_get_feeds_posts_data();
    }
    /**
     * KWS Elementor Kit dashboard overview fetch remote data
     */
    public function kws_elementor_kit_get_feeds_remote_data() {
        //$source = wp_remote_get('https://kwstech.in/wp-json/kwstech/v1/product-feed/?product_category=kws-elementor-kit');
        //$reponse_raw = wp_remote_retrieve_body($source);
        //$reponse = json_decode($reponse_raw);
        $reponse = json_decode("{}");
        return $reponse;
    }
    /**
     * KWS Elementor Kit dashboard overview fetch posts data
     */
    public function kws_elementor_kit_get_feeds_posts_data() {
        // Get RSS Feed(s)
        include_once(ABSPATH . WPINC . '/feed.php');
        $rss = fetch_feed('https://kwstech.in/feed');
        if (!is_wp_error($rss)) :
            $maxitems = $rss->get_item_quantity(5);
            $rss_items = $rss->get_items(0, $maxitems);
        endif; ?>
        <!-- // Display the container -->
        <div class="cft-kek-overview__feed">
            <ul class="cft-kek-overview__posts">
                <?php
                // Check items
                if ($maxitems == 0) {
                    echo '<li class="cft-kek-overview__post">' . __('No item', 'kws-elementor-kit') . '.</li>';
                } else {
                    foreach ($rss_items as $item) :
                        $feed_url = $item->get_permalink();
                        $feed_title = $item->get_title();
                        $feed_date = human_time_diff($item->get_date('U'), current_time('timestamp')) . ' ' . __('ago', 'kws-elementor-kit');
                        $content = $item->get_content();
                        $feed_content = wp_html_excerpt($content, 120) . ' [...]';
                ?>
                        <li class="cft-kek-overview__post">
                            <?php printf('<a class="cft-kek-overview__post-link" href="%1$s" title="%2$s" target="_blank">%3$s</a>', $feed_url, $feed_date, $feed_title);
                            printf('<span class="cft-kek-overview__post-date">%1$s</span>', $feed_date);
                            printf('<p class="cft-kek-overview__post-description">%1$s</p>', $feed_content); ?>

                        </li>
                <?php
                    endforeach;
                }
                ?>
            </ul>
            <div class="cft-kek-overview__footer cft-kek-divider_top">
                <ul>
                    <?php
                    $footer_link = [
                        [
                            'url' => 'https://kwstech.in/blog/',
                            'title' => esc_html__('Blog', 'kws-elementor-kit'),
                        ],
                        [
                            'url' => 'https://kwstech.in/knowledge-base/',
                            'title' => esc_html__('Docs', 'kws-elementor-kit'),
                        ],
                    ];
                    foreach ($footer_link as $key => $link) {
                        printf('<li><a href="%1$s" target="_blank">%2$s<span aria-hidden="true" class="dashicons dashicons-external"></span></a></li>', $link['url'], $link['title']);
                    }
                    ?>
                </ul>
            </div>
        </div>
        </div>
<?php
    }
}
