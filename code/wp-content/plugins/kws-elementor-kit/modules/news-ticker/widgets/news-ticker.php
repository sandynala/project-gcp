<?php
namespace KwsElementorKit\Modules\NewsTicker\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

use KwsElementorKit\Traits\Global_Widget_Controls;
use KwsElementorKit\Includes\Controls\GroupQuery\Group_Control_Query;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class News Ticker
 */
class News_Ticker extends Group_Control_Query {

	use Global_Widget_Controls;

	/**
	 * @var \WP_Query
	 */
	private $_query = null;

	public function get_name() {
		return 'kek-news-ticker';
	}

	public function get_title() {
		return CFTKEK . esc_html__( 'News Ticker', 'kws-elementor-kit' );
	}

	public function get_icon() {
		return 'kek-widget-icon kek-icon-news-ticker';
	}

	public function get_categories() {
		return [ 'kws-elementor-kit' ];
	}

	public function get_keywords() {
		return [ 'news', 'ticker', 'report', 'message', 'information', 'blog' ];
	}

	public function get_style_depends() {
		if ( $this->kek_is_edit_mode() ) {
			return [ 'kek-all-styles' ];
		} else {
			return [ 'kek-news-ticker' ];
		}
	}

	public function get_script_depends() {
		if ( $this->kek_is_edit_mode() ) {
			return [ 'kek-all-scripts' ];
		} else {
			return [ 'news-ticker-js', 'kek-news-ticker' ];
		}
	}

	public function get_custom_help_url() {
		return '';
	}

	public function get_query() {
		return $this->_query;
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_content_layout',
			[
				'label' => esc_html__( 'Layout', 'kws-elementor-kit' ),
			]
		);

		$this->add_control(
			'show_label',
			[
				'label'   => esc_html__( 'Label', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'news_label',
			[
				'label'       => esc_html__( 'Label', 'kws-elementor-kit' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [ 'active' => true ],
				'default'     => esc_html__( 'LATEST NEWS', 'kws-elementor-kit' ),
				'placeholder' => esc_html__( 'LATEST NEWS', 'kws-elementor-kit' ),
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'news_content',
			[
				'label'   => esc_html__( 'News Content', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => [
					'title'   => esc_html__( 'Title', 'kws-elementor-kit' ),
					'excerpt' => esc_html__( 'Excerpt', 'kws-elementor-kit' ),
				],
			]
		);

		$this->add_control(
			'show_date',
			[
				'label'     => esc_html__( 'Date', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'news_content' => 'title'
				],
			]
		);

		$this->add_control(
			'date_reverse',
			[
				'label'     => esc_html__( 'Date Reverse', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'show_date' => 'yes'
				],
			]
		);

		$this->add_control(
			'show_time',
			[
				'label'     => esc_html__( 'Time', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'news_content' => 'title'
				],
			]
		);

		$this->add_responsive_control(
			'news_ticker_height',
			[
				'label'   => __( 'Height', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 42,
				],
				'range' => [
					'px' => [
						'min' => 25,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_content_navigation',
			[
				'label' => esc_html__( 'Navigation', 'kws-elementor-kit' ),
			]
		);

		$this->add_control(
			'show_navigation',
			[
				'label'   => esc_html__( 'Navigation', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'play_pause',
			[
				'label'   => esc_html__( 'Play/Pause Button', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'navigation_size',
			[
				'label'   => esc_html__( 'Navigation Size', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-navigation svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'show_navigation' => 'yes'
				]
			]
		);

		$this->end_controls_section();

		// Query Settings
		$this->start_controls_section(
			'section_post_query_builder',
			[
				'label' => __( 'Query', 'kws-elementor-kit' ) . CFTKEK_NC,
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_limit',
			[
				'label'   => esc_html__( 'Posts Limit', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
			]
		);
		
		$this->register_query_builder_controls();
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_style_animation',
			[
				'label' => esc_html__( 'Animation', 'kws-elementor-kit' ),
			]
		);

		$this->add_control(
			'slider_animations',
			[
				'label'     => esc_html__( 'Animations', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'fade',
				'options'   => [
					'scroll'  	  => esc_html__( 'Scroll', 'kws-elementor-kit' ),
					'slide-left'  => esc_html__( 'Slide Left', 'kws-elementor-kit' ),
					'slide-up'    => esc_html__( 'Slide Up', 'kws-elementor-kit' ),
					'slide-right' => esc_html__( 'Slide Right', 'kws-elementor-kit' ),
					'slide-down'  => esc_html__( 'Slide Down', 'kws-elementor-kit' ),
					'fade'        => esc_html__( 'Fade', 'kws-elementor-kit' ),
					'typography'  => esc_html__( 'Typography', 'kws-elementor-kit' ),
				],
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => esc_html__( 'Autoplay', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);


		$this->add_control(
			'autoplay_interval',
			[
				'label'     => esc_html__( 'Autoplay Interval', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'   => esc_html__( 'Pause on Hover', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'speed',
			[
				'label'              => esc_html__( 'Animation Speed', 'kws-elementor-kit' ),
				'type'               => Controls_Manager::NUMBER,
				'default'            => 500,
			]
		);

		$this->add_control(
			'scroll_speed',
			[
				'label'   => __( 'Scroll Speed', 'kws-elementor-kit' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 10,
					],
				],
				'condition' => [
					'slider_animations' => 'scroll',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_news_ticker',
			[
				'label'     => esc_html__( 'News Ticker', 'kws-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_label',
			[
				'label'     => esc_html__( 'Label', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
				'separator' => 'before',
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-label-inner' => 'color: {{VALUE}};',
				],
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$border_side = is_rtl() ? 'right' : 'left';

		$this->add_control(
			'label_background',
			[
				'label'     => esc_html__( 'Background', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-label'       => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-label:after' => 'border-' . $border_side . '-color: {{VALUE}};',
				],
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'label_typography',
				'label'     => esc_html__( 'Typography', 'kws-elementor-kit' ),
				//'scheme'    => Schemes\Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .kek-news-ticker .kek-news-ticker-label-inner',
				'condition' => [
					'show_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'heading_content',
			[
				'label' => esc_html__( 'Content', 'kws-elementor-kit' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'content_color',
			[
				'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-content a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-content span' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'content_background',
			[
				'label'     => esc_html__( 'Background', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker'     => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-content:before, {{WRAPPER}} .kek-news-ticker .kek-news-ticker-content:after'     => 'box-shadow: 0 0 12px 12px {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_typography',
				'label'    => esc_html__( 'Typography', 'kws-elementor-kit' ),
				'selector' => '{{WRAPPER}} .kek-news-ticker .kek-news-ticker-content',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label'     => esc_html__( 'Navigation', 'kws-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_navigation' => 'yes'
				]
			]
		);

		$this->add_control(
			'navigation_background',
			[
				'label'     => esc_html__( 'Navigation Background', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-navigation' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_arrow_style' );

		$this->start_controls_tab(
			'tab_arrow_normal',
			[
				'label' => esc_html__( 'Normal', 'kws-elementor-kit' ),
			]
		);

		$this->add_control(
			'navigation_color',
			[
				'label'     => esc_html__( 'Navigation Color', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-navigation button span svg' => 'color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrow_hover',
			[
				'label' => esc_html__( 'Hover', 'kws-elementor-kit' ),
			]
		);

		$this->add_control(
			'hover_color',
			[
				'label'     => esc_html__( 'Color', 'kws-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .kek-news-ticker .kek-news-ticker-navigation button:hover span svg' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Main query render for this widget
	 * @param $posts_per_page number item query limit
	 */
	public function query_posts( $posts_per_page ) {
		
		$default = $this->getGroupControlQueryArgs();
		if ( $posts_per_page ) {
			$args['posts_per_page'] = $posts_per_page;
				$args['paged']  = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
		}
		$args         = array_merge( $default, $args );
		$this->_query = new WP_Query( $args );
	}

	public function render() {
		$settings = $this->get_settings_for_display();

		$this->query_posts( $settings['posts_limit'] );

		$wp_query = $this->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->render_header($settings);

		$post_count = 0;
		while ( $wp_query->have_posts() ) {
			$wp_query->the_post();
			
			$this->render_loop_item($settings);
			$post_count ++;
		}
			
		$this->render_footer(($post_count > 1));

		wp_reset_postdata();

	}

	protected function render_title( $has_content ) {
		$classes = ['kek-news-ticker-content-title'];
		?>

		<?php if($has_content) { ?>
		<a href="<?php echo esc_url(get_permalink()); ?>"  class="breaking-news-title-width">
		<?php } else { ?>
		<span class="breaking-news-title-width">
		<?php } ?>
			<?php $this->render_date(); ?>

			<?php $this->render_time(); ?>

			<?php the_title() ?>
		<?php if($has_content) { ?>
		</a>
		<?php } else { ?>
		</span>
		<?php } ?>

		
		<?php
	}


	protected function render_excerpt() {
		
		?>
		<a href="<?php echo esc_url(get_permalink()); ?>">
			<?php the_excerpt(); ?>
		</a>
		<?php
	}

	protected function render_header($settings) {

		$this->add_render_attribute(
			[
				'slider-settings' => [
					'class' => [
						'kek-news-ticker',
					],
					'data-settings' => [
						wp_json_encode(array_filter([
							"effect"       => $settings["slider_animations"],
							"autoPlay"     => ($settings["autoplay"]) ? true : false,
							"interval"     => $settings["autoplay_interval"],
							"pauseOnHover" => ($settings["pause_on_hover"]) ? true : false,
							"scrollSpeed"  => (isset( $settings["scroll_speed"]["size"]) ?  $settings["scroll_speed"]["size"] : 1),
							"direction"    => (is_rtl()) ? 'rtl' : false
						]))
					],
				]
			]
		);
		
		?>
		<div id="newsTicker1" <?php echo $this->get_render_attribute_string( 'slider-settings' ); ?>>
			<?php if ( 'yes' == $settings['show_label'] ) : ?>
				<div class="kek-news-ticker-label">
					<div class="kek-news-ticker-label-inner">
						<?php echo wp_kses( $settings['news_label'], kws_elementor_kit_allow_tags('title') ); ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="kek-news-ticker-content">
				<ul>
		<?php
	}

	public function render_date() {
		$settings = $this->get_settings_for_display();

		if ( ! $this->get_settings('show_date') ) {
			return;
		}

		$news_month = get_the_date('m');
		$news_day = get_the_date('d');
		
		?>

		<span class="kek-news-ticker-date cft-margin-small-right" title="<?php esc_html_e( 'Published on:', 'kws-elementor-kit' ); ?> <?php echo get_the_date(); ?>">
			<?php if ('yes' == $settings['date_reverse']) : ?>
				<span class="kek-news-ticker-date-day"><?php echo esc_attr( $news_day ); ?></span>
				<span class="kek-news-ticker-date-sep">/</span>
				<span class="kek-news-ticker-date-month"><?php echo esc_attr( $news_month ); ?></span>
			<?php else: ?>
				<span class="kek-news-ticker-date-month"><?php echo esc_attr( $news_month ); ?></span>
				<span class="kek-news-ticker-date-sep">/</span>
				<span class="kek-news-ticker-date-day"><?php echo esc_attr( $news_day ); ?></span>
			<?php endif; ?>
			<span>:</span>
		</span>

		<?php
	}

	public function render_time() {

		if ( ! $this->get_settings('show_time') ) {
			return;
		}

		$news_hour = get_the_time();
		
		?>

		<span class="kek-news-ticker-time cft-margin-small-right" title="<?php esc_html_e( 'Published on:', 'kws-elementor-kit' ); ?> <?php echo get_the_date(); ?> <?php echo get_the_time(); ?>">
			<span class="cft-text-uppercase"><?php echo esc_attr( $news_hour ); ?></span>
			<span>:</span>
		</span>

		<?php
	}


	protected function render_footer($show_buttons) {
		$settings = $this->get_settings_for_display();
		?>


				</ul>
			</div>
			<?php if ( $settings['show_navigation'] && $show_buttons) : ?>
			<div class="kek-news-ticker-controls kek-news-ticker-navigation">
				<button class="cft-visible@m">
					<span class="kek-news-ticker-prev cft-icon">
						<i class="fa fa-step-backward fa-2x"></i>
					</span>
				</button>

				<?php if ($settings['play_pause']) : ?>
				
				<button class="cft-visible@m">
					<span class="kek-news-ticker-action cft-icon">
						<svg width="30" height="30" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg"  data-svg="play" class="kek-news-ticker-play-pause">
							<polygon fill="grey" stroke="grey" points="4.9,0 22.1,12 4.9,26" width="30" height = "30"></polygon>

							<rect x="4" y="2" width="5" height="26" fill="grey" stroke="grey" />
							<rect x="15" y="2" width="5" height="26" fill="grey" stroke="grey"/>
						</svg>
					</span>
				</button> 
				<?php endif ?>
				
				<button>
					<span class="kek-news-ticker-arrow kek-news-ticker-next cft-icon">
						<i class="fa fa-step-forward"></i>
					</span>
				</button>

			</div>

			<?php endif; ?>
		</div>
		
		<?php
	}

	protected function render_loop_item($settings) {
		$content = get_the_content();
		$has_content = strlen($content) > 0;
		?>
		<li class="kek-news-ticker-item">

				<?php if( 'title' == $settings['news_content'] ) : ?>
					<?php $this->render_title( $has_content ); ?>
				<?php endif; ?>

				<?php if( 'excerpt' == $settings['news_content'] )  : ?>
					<?php $this->render_excerpt(); ?>
				<?php endif; ?>

				<?php
					if( $has_content ) {?>
						<a class = "breaking-news-readmore-button" href="<?php echo esc_url(get_permalink()); ?>">READ MORE</a>
				<?php } ?>

		</li>
		<?php
	}
}
