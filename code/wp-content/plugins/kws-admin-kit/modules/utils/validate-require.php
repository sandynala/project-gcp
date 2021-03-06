<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}


if ( ! class_exists( 'kws_required_fields' ) ) {

// initialise
add_action( 'plugins_loaded', array( 'kws_required_fields', 'instance' ) );

class kws_required_fields {

	/**
	 * Translation DOM
	 */
	const DOM = __CLASS__;

	/**
	 * @var string Plugin basename
	 */
	protected static $version = '1.5.3';

	/**
	 * @var string Plugin basename
	 */
	protected static $plugin;

	/**
	 * @var string Plugin url
	 */
	protected static $plugin_url;

	/**
	 * Holds the registered validation config
	 */
	public static $fields = array();

	public $post_id;
	public $transient_key;
	public $transient_key_warn;
	public $current_user;
	public $errors;
	public $warnings;
	public $cache_time = 60;

	public $default_validation = array( __CLASS__, '_not_empty' );

	/**
	 * Reusable object instance.
	 *
	 * @type object
	 */
	protected static $instance = null;

	/**
	 * Creates a new instance. Called on 'plugins_loaded'.
	 * May be used to access class methods from outside.
	 *
	 * @see    __construct()
	 * @return void
	 */
	public static function instance() {
		null === self :: $instance AND self :: $instance = new self;
		return self :: $instance;
	}


	public function __construct() {

		if ( ! is_admin() )
			return;

		// set plugin base
		self::$plugin = KWSADM_PBNAME;

		// plugin url
		self::$plugin_url = KWSADM_UTILS_URL;

		// translations
		load_plugin_textdomain( self::DOM, false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

		// force post to remain as draft if error messages are set
		add_filter( 'wp_insert_post_data', array( $this, 'force_draft' ), 12, 2 );
		add_action( 'wp_insert_post', array( $this, 'force_draft_meta' ), 12, 3 );

		// force non empty title & content so plugin can take over
		add_filter( 'pre_post_title', 	array( $this, 'mask_empty' ) );
		add_filter( 'pre_post_content', array( $this, 'mask_empty' ) );

		// display & clear any errors
		add_action( 'admin_notices', array( $this, 'notice_handler' ) );

		// settings
		add_action( 'admin_init', array( $this, 'admin_init' ), 9 );

		// set up vars
		$this->post_id = isset( $_GET[ 'post' ] ) ? intval( $_GET[ 'post' ] ) : 0;
		$this->current_user = get_current_user_id();
		$this->transient_key = "save_post_error_{$this->post_id}_{$this->current_user}"; // key should be specific to post and the user editing the post
		$this->transient_key_warn = "save_post_warn_{$this->post_id}_{$this->current_user}";


		// add settings link
		add_filter( 'plugin_action_links_' . self::$plugin, array( $this, 'settings_link' ), 10, 1 );

		// enqueue assets
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ), 100 );

		// Add a class to the admin body tag to show that we're using the current admin style
		add_filter( 'admin_body_class', array( $this, 'filter_admin_body_class' ) );
	}


	/**
	 * Adds a link direct othe required fields settings on the plugins page
	 *
	 * @param array $links Array of links displayed on plugins page
	 * @return array
	 */
	public function settings_link( $links ) {
		$settings_link = '<a href="' . admin_url( 'options-writing.php#required-fields-settings' ) . '">' . __( 'Settings', self::DOM ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}


	// add setting to writing screen for required custom excerpt/content
	public function admin_init() {
		global $pagenow;

		// error handling
		if ( $pagenow == 'post.php' ) {

			// get errors
			$this->errors = get_option( $this->transient_key );
			$this->warnings = get_option( $this->transient_key_warn );

			// if errors or not published unset the 'published' message
			if ( isset( $_GET[ 'message' ] ) && $_GET[ 'message' ] == 6 ) {
				if ( $this->errors || get_post_status( $this->post_id ) !== 'publish' )
					unset( $_GET[ 'message' ] );
			}

		}

		// easy method of disabling admin area for plugin/theme
		if ( apply_filters( 'kws_required_fields_disable_admin', false ) )
			return;

		add_settings_section( 'kws_required_fields', '', array( $this, 'section' ), 'writing' );

		// use warnings instead
		$use_soft = get_option( 'kws_required_fields_soft' );
		register_setting( 'writing', 'kws_required_fields_soft', 'intval' );
		add_settings_field(
			'kws_required_fields_soft',
			'<label for="kws_required_fields_soft">' . __( 'Do not prevent publishing', self::DOM ) . '</label>',
			array( $this, 'checkbox_field' ),
			'writing',
			'kws_required_fields',
			array(
				'name' => 'kws_required_fields_soft',
				'value' => $use_soft,
				'description' => __( 'Displays validation messages as warnings and not errors.' )
			)
			);


		$post_types = get_post_types( array( 'public' => true ), 'objects' );

		$fields = array();

		foreach( $post_types as $post_type ) {

			if ( in_array( $post_type->name, apply_filters( 'kws_required_fields_ignored_post_types', array( 'attachment', 'nav_menu_item' ) ) ) )
				continue;

			$post_type_fields = array();

			add_settings_section( "kws_required_fields_{$post_type->name}", sprintf( __( 'Required fields for %s', self::DOM ), $post_type->labels->name ), '__return_false', 'writing' );

			if ( post_type_supports( $post_type->name, 'title' ) ) {
				$post_type_fields[ "post_title_{$post_type->name}" ] = array(
					'name' => 'post_title',
					'title' => __( 'Title', self::DOM ),
					'setting_cb' => 'intval',
					'setting_field' => array( $this, 'checkbox_field' ),
					'message' => sprintf( __( 'Your %s needs a <a href="#titlediv" title="Skip to title">title</a>!', self::DOM ), $post_type->labels->singular_name ),
					'validation_cb' => false,
					'post_type' => $post_type->name,
					'highlight' => '#titlediv',
					'soft' => $use_soft );
			}

			if ( post_type_supports( $post_type->name, 'editor' ) ) {
				$post_type_fields[ "post_content_{$post_type->name}" ] = array(
					'name' => 'post_content',
					'title' => __( 'Content', self::DOM ),
					'setting_cb' => 'intval',
					'setting_field' => array( $this, 'checkbox_field' ),
					'message' => __( 'You should add some <a href="#postdivrich" title="Skip to content">content</a> before you publish.', self::DOM ),
					'validation_cb' => false,
					'post_type' => $post_type->name,
					'highlight' => '#postdivrich',
					'soft' => $use_soft );
			}

			if ( post_type_supports( $post_type->name, 'excerpt' ) ) {
				$post_type_fields[ "post_excerpt_{$post_type->name}" ] = array(
					'name' => 'post_excerpt',
					'title' => __( 'Excerpt', self::DOM ),
					'setting_cb' => 'intval',
					'setting_field' => array( $this, 'checkbox_field' ),
					'message' => __( 'You should write a <a href="#postexcerpt" title="Skip to excerpt">custom excerpt</a> to summarise your post. It can help to encourage users to click through to your content.', self::DOM ),
					'validation_cb' => false,
					'post_type' => $post_type->name,
					'highlight' => '#postexcerpt',
					'soft' => $use_soft );
			}

			if ( is_object_in_taxonomy( $post_type->name, 'category' ) ) {
				$default = get_term( get_option( 'default_category' ), 'category' );
				$post_type_fields[ "category_{$post_type->name}" ] = array(
					'name' => 'category',
					'title' => __( 'Category', self::DOM ),
					'description' => sprintf( __( 'This will force authors to choose a category other than "%s"', self::DOM ), $default->name ),
					'setting_cb' => 'intval',
					'setting_field' => array( $this, 'checkbox_field' ),
					'message' => sprintf( __( 'You should choose a <a href="#categorydiv" title="Skip to categories">category</a> other than the default "%s".', self::DOM ), $default->name ),
					'validation_cb' => array( $this, '_has_category' ),
					'post_type' => $post_type->name,
					'highlight' => '#categorydiv',
					'soft' => $use_soft );
			}

			if ( is_object_in_taxonomy( $post_type->name, 'post_tag' ) ) {
				$post_type_fields[ "tag_{$post_type->name}" ] = array(
					'name' => 'post_tag',
					'title' => __( 'Tags', self::DOM ),
					'setting_cb' => 'intval',
					'setting_field' => array( $this, 'checkbox_field' ),
					'message' => __( 'You should add one or more <a href="#tagsdiv-post_tag" title="Skip to tags">tags</a> to your post to help people find related content.', self::DOM ),
					'validation_cb' => array( $this, '_has_tag' ),
					'post_type' => $post_type->name,
					'highlight' => '#tagsdiv-post_tag',
					'soft' => $use_soft );
			}

			if ( current_theme_supports( 'post-thumbnails' ) && post_type_supports( $post_type->name, 'thumbnail' ) ) {
				$required_image_size = get_option( "require_image_size_{$post_type->name}", array( 0, 0 ) );

				$image_size_message = implode( __( ' and ', self::DOM ), array_filter( array(
					intval( $required_image_size[ 0 ] ) ? $required_image_size[ 0 ] . 'px ' . __( 'wide', self::DOM ) : '',
					intval( $required_image_size[ 1 ] ) ? $required_image_size[ 1 ] . 'px ' . __( 'tall', self::DOM ) : ''
				) ) );

				$post_type_fields[ "thumbnail_id_{$post_type->name}" ] = array(
					'name' => '_thumbnail_id',
					'title' => __( 'Featured image', self::DOM ),
					'setting_cb' => 'intval',
					'setting_field' => array( $this, 'checkbox_field' ),
					'message' => __( 'You should set a <a href="#postimagediv" title="Skip to featured image">featured image</a> before you can publish.', self::DOM ),
					'validation_cb' => false,
					'post_type' => $post_type->name,
					'highlight' => '#postimagediv',
					'soft' => $use_soft );
				$post_type_fields[ "image_size_{$post_type->name}" ] = array(
					'name' => 'image_size',
					'title' => __( 'Featured image minimum size', self::DOM ),
					'setting_cb' => array( $this, '_check_image_size_fields' ),
					'setting_field' => array( $this, 'image_size_field' ),
					'message' => sprintf( __( 'To keep your site looking perfect your <a href="#postimagediv" title="Skip to featured image">featured image</a> should be at least %s.', self::DOM ), "<strong>$image_size_message</strong>" ),
					'validation_cb' => array( $this, '_check_image_size' ),
					'post_type' => $post_type->name,
					'highlight' => '#postimagediv',
					'soft' => $use_soft );
			}

			// add post type specific fields
			$fields = array_merge( $fields, $post_type_fields );

		}

		$fields = apply_filters( 'kws_required_fields_settings', $fields );

		foreach( $fields as $name => $field ) {
			$field_name = "require_{$name}";
			$field_value = get_option( $field_name );
			$field_id = sanitize_title_with_dashes( $field_name );
			add_settings_field( $field_name , '<label for="' . $field_id . '">' . $field[ 'title' ] . '</label>', $field[ 'setting_field' ], 'writing', 'kws_required_fields_' . $field[ 'post_type' ], array(
				'name' => $field_name,
				'value' => $field_value,
				'description' => isset( $field[ 'description' ] ) ? $field[ 'description' ] : ''
			) );
			register_setting( 'writing', $field_name, $field[ 'setting_cb' ] );

			// if the setting validation returns true register the field as required
			if ( call_user_func( $field[ 'setting_cb' ], $field_value ) )
				$this->register( $field[ 'name' ], $field[ 'message' ], $field[ 'validation_cb' ], $field[ 'post_type' ], $field[ 'highlight' ], $field[ 'soft' ] );

		}

	}

	/**
	 * Enqueue required fields javascript
	 *
	 * @return void
	 */
	public function scripts() {
		global $pagenow;

		// makes sure hidden required fields are shown and highlights errors
		$required_fields = array();

		foreach( self::$fields as $post_type => $fields ) {
			$required_fields[ $post_type ] = array();
			foreach( $fields as $field ) {
				$required_fields[ $post_type ][] = array(
					'name' => $field[ 'name' ],
					'message' => $field[ 'message' ],
					'highlight' => $field[ 'highlight' ]
				);
			}
		}

		wp_register_style( 'kws_required-fields', self::$plugin_url . '/css/required-fields.css', array(), self::$version );
		wp_register_script( 'kws_required-fields', self::$plugin_url . '/js/required-fields.js', array( 'jquery', 'post' ), self::$version, true );
		wp_localize_script( 'kws_required-fields', 'kws_required_fields_l10n', array(
			'fields' => $required_fields
		) );

		// post page
		if ( $pagenow == 'post.php' || $pagenow == 'post-new.php' ) {

			wp_enqueue_style( 'kws_required-fields' );
			wp_enqueue_script( 'kws_required-fields' );

		}

		// settings
		if ( $pagenow == 'options-writing.php' ) {

			wp_enqueue_style( 'kws_required-fields' );

		}

	}

	/**
	 * Some inline branding for interconnect/it
	 *
	 * @return void
	 */
	public function section() { ?>
		<div id="required-fields-settings" class="kws-branding">
			<h2><?php _e( 'Required Post Fields', self::DOM ); ?></h2>
			<p><?php _e( 'Use the settings below to make the corresponding fields required before content can be published.', self::DOM ); ?></p>
		</div>
		<?php
	}

	public function checkbox_field( $args ) {
		$field_id = sanitize_title_with_dashes( $args[ 'name' ] );
		echo '<label for="' . $field_id . '"><input type="checkbox" id="' . $field_id . '" name="' . $args[ 'name' ] . '" value="1" ' . checked( 1, intval( $args[ 'value' ] ), false ) . ' />';
		if ( ! empty( $args[ 'description' ] ) )
			echo ' <span class="description">' . $args[ 'description' ] . '</span>';
		echo '</label>';
	}

	public function image_size_field( $args ) {
		if ( ! is_array( $args[ 'value' ] ) )
			$args[ 'value' ] = array( '', '' );
		echo '<input size="3" type="number" name="' . $args[ 'name' ] . '[]" value="' . $args[ 'value' ][ 0 ] . '" /> px ' . __( 'wide', self::DOM ) . ' ' . _( 'by' ) . ' ';
		echo '<input size="3" type="number" name="' . $args[ 'name' ] . '[]" value="' . $args[ 'value' ][ 1 ] . '" /> px ' . __( 'tall', self::DOM );
		echo '<div><span class="description">' . __( 'Set to blank or 0 to allow any size', self::DOM ) . '</span></div>';
	}

	/**
	 * Register a validation callback to determine whether a post can be published or not
	 * The message is displayed if the callback returns false.
	 * The check can be assigned to one or more post types.
	 *
	 * @param string $name          The $_POST array key or post meta key
	 * @param string $message       Error message to display if callback fails
	 * @param callback $validation_cb 	A callback that returns true or false
	 * @param string|array $post_types    The post type or array of post types to register this validation for
	 * @param string $highlight 	A CSS selector for the html element to highlight if the error occurs
	 * @param bool $soft 			Indicates whether the rule should prevent publishing or just appear as a warning
	 *
	 * @return void
	 */
	public function register( $name, $message = '', $validation_cb = false, $post_types = 'post', $highlight = '', $soft = false ) {

		if ( $post_types == 'any' )
			$post_types = get_post_types( array( 'public' => true ) );

		foreach( (array)$post_types as $type ) {
			if ( ! isset( self::$fields[ $type ] ) )
				self::$fields[ $type ] = array();
			self::$fields[ $type ][] = array(
				'name' => $name,
				'cb' => $this->_get_callback( $validation_cb ),
				'message' => empty( $message ) ? sprintf( __( '%s is required before you can publish.', self::DOM ), $this->prettify_name( $name ) ) : $message,
				'highlight' => $highlight,
				'soft' => $soft
				);
		}

	}


	/**
	 * Unregister a validation callback for certain post types
	 *
	 * @param string $name          The $_POST array key or post meta key
	 * @param callback|bool|string $validation_cb 	The callback to remove. If false removes the default not
	 * 												empty check, if 'all' removes all validations from $name
	 * @param string|array $post_types    The post type or array of post types to register this validation for
	 *
	 * @return void
	 */
	public function unregister( $name, $validation_cb = false, $post_types = 'post' ) {

		if ( $post_types == 'any' )
			$post_types = get_post_types( array( 'public' => true ) );

		foreach( (array)$post_types as $type ) {
			if ( ! isset( self::$fields[ $type ] ) )
				continue;
			foreach( self::$fields[ $type ] as $i => $field ) {
				if ( $validation_cb === 'all' && $field[ 'name' ] === $name ) {
					unset( self::$fields[ $type ][ $i ] );
				} elseif ( array( 'name' => $field[ 'name' ], 'cb' => $field[ 'cb' ] ) == array( 'name' => $name, 'cb' => $this->_get_callback( $validation_cb ) ) ) {
					unset( self::$fields[ $type ][ $i ] );
				}
			}
		}

	}


	/**
	 * Returns the default callback if an invalid callback is passed
	 *
	 * @param callback|array $callback A callback that returns true or false or an array of arrays of callbacks and error messages
	 *
	 * @return callback|array
	 */
	private function _get_callback( $callback ) {
		return is_callable( $callback ) ? $callback : $this->default_validation;
	}


	public function prettify_name( $name ) {
		$name = preg_replace( '/[_\-\[\]]+/', ' ', $name );
		$name = ucwords( trim( $name ) );
		return $name;
	}

	/**
	 * Makes post title and content into a space so built in WP check doesn't kick in
	 *
	 * HT Jan Fabry http://wordpress.stackexchange.com/a/28223/1733
	 *
	 * @param $value string 	Content / Title
	 * @return string
	 */
	public function mask_empty( $value ) {
		if ( empty( $value ) )
			return ' ';
		return $value;
	}

	/**
	 * Main workhorse of the plugin, runs all the validation callback and builds
	 * the error array for display
	 *
	 * @param $data array 	Post data array
	 * @param $postarr 		The $_POST array
	 * @return $data 		The final post data array to be inserted/updated
	 */
	public function force_draft( $data, $postarr ) {

		// reset 'empty' mask
		if ( ' ' === $data['post_title'] )
			$data['post_title'] = '';
		if ( ' ' === $data['post_content'] )
			$data['post_content'] = '';

		$post_id = isset( $postarr[ 'ID' ] ) ? $postarr[ 'ID' ] : false;
		$post_id = isset( $postarr[ 'post_ID' ] ) ? $postarr[ 'post_ID' ] : false;
		if ( ! $post_id )
			return $data;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $data;
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return $data;

		// reset transient key
		$this->transient_key = "save_post_error_{$post_id}_{$this->current_user}";
		$this->transient_key_warn = "save_post_warn_{$post_id}_{$this->current_user}";

		// clear errors
		delete_option( $this->transient_key );
		delete_option( $this->transient_key_warn );

		$errors = $warnings = array();

		// add error messages here
		foreach( self::$fields[ $postarr[ 'post_type' ] ] as $validation ) {
			$value = $this->_find_field( $validation[ 'name' ], $postarr );

			// if we're doing multiple validations
			if ( $value !== null && is_callable( $validation[ 'cb' ] ) ) {
				if ( ! call_user_func( $validation[ 'cb' ], $value, $postarr ) ) {
					if ( $validation[ 'soft' ] )
						$warnings[ sanitize_key( $validation[ 'name' ] ) ] = $validation;
					else
						$errors[ sanitize_key( $validation[ 'name' ] ) ] = $validation;
				}
			}
		}

		if ( ! empty( $errors ) ) {
			// store errors for display
			update_option( $this->transient_key, $errors );
			// revert to draft if attempting to publish for first time
			if ( isset( $_POST[ 'publish' ] ) )
				$data[ 'post_status' ] = 'draft';
		}

		if( ! empty( $warnings ) ) {
			// store warnings for display
			update_option( $this->transient_key_warn, $warnings );
		}

		return $data;
	}

	/**
	 * Secondary workhorse, runs all the validation callbacks against metadata after save_post action has run
	 *
	 * @param $post_id int
	 * @param $post WP_Post
	 * @param $update bool
	 * @return void
	 */
	public function force_draft_meta( $post_id, $post, $update ) {
		global $wpdb;

		$postarr = $_POST;

		if ( ! $post_id )
			return;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		if ( ! current_user_can( 'edit_post', $post_id ) )
			return;
		if ( ! isset( $postarr[ 'post_type' ] ) )
			return;
		if ( ! $update )
			return;

		$errors = $warnings = array();

		// add error messages here
		foreach( self::$fields[ $postarr[ 'post_type' ] ] as $validation ) {
			if ( $this->_find_field( $validation[ 'name' ], $postarr ) !== null )
				continue;

			$value = $this->_find_meta_field( $validation[ 'name' ], $post_id );

			// if we're doing multiple validations
			if ( is_callable( $validation[ 'cb' ] ) ) {
				if ( ! call_user_func( $validation[ 'cb' ], $value, $postarr ) ) {
					if ( $validation[ 'soft' ] ) {
						$warnings[ sanitize_key( $validation[ 'name' ] ) ] = array_filter(
                                                                                                    $validation,
                                                                                                    function( $a ) {
                                                                                                        if ( is_object( $a ) )
                                                                                                            return false;
                                                                                                        else
                                                                                                            return true;
                                                                                                    }
                                                                                                );
					}
                    else {
						$errors[ sanitize_key( $validation[ 'name' ] ) ] = array_filter(
                                                                                                $validation,
                                                                                                function( $a ) {
                                                                                                    if ( is_object( $a ) )
                                                                                                        return false;
                                                                                                    else
                                                                                                        return true;
                                                                                                }
                                                                                            );
                    }
				}
			}
		}

		if ( ! empty( $errors ) ) {
			// store errors for display
			$errors = array_merge( get_option( $this->transient_key, array() ), $errors );
			update_option( $this->transient_key, $errors );
			// revert to draft if attempting to publish for first time
			if ( isset( $_POST[ 'publish' ] ) && $post->post_status !== 'draft' ) {
				$wpdb->update( $wpdb->posts, array( 'post_status' => 'draft' ), array( 'ID' => $post_id ), array( '%s' ), array( '%d' ) );
				wp_transition_post_status( 'draft', $post->post_status, $post );
			}
		}

		if ( ! empty( $warnings ) ) {
			// store warnings for display
			$warnings = array_merge( get_option( $this->transient_key_warn, array() ), $warnings );
			update_option( $this->transient_key_warn, $warnings );
		}

		return;
	}

	public function notice_handler() {
		global $pagenow;

		if ( $this->errors && $pagenow == 'post.php' ) {
			echo '<div class="error required-fields-errors">';
			foreach( $this->errors as $code => $validation ) {
				$highlight = $validation[ 'highlight' ] ? ' data-highlight="' . esc_attr( $validation[ 'highlight' ] ) . '"' : '';
				echo '<p class="' . $code . '"' . $highlight . '>' . $validation[ 'message' ] . '</p>';
			}
			echo '</div>';

			// remove errors
			delete_option( $this->transient_key );
		}

		if ( $this->warnings && $pagenow == 'post.php' ) {
			echo '<div class="error required-fields-warnings required-fields-errors">';
			foreach( $this->warnings as $code => $validation ) {
				$highlight = $validation[ 'highlight' ] ? ' data-highlight="' . esc_attr( $validation[ 'highlight' ] ) . '"' : '';
				echo '<p class="' . $code . '"' . $highlight . '>' . $validation[ 'message' ] . '</p>';
			}
			echo '</div>';

			// remove warnings
			delete_option( $this->transient_key_warn );
		}
	}

	/**
	 * Append a class name to the admin body class so the CSS can be targeted at
	 * the modern version of the WordPress admin
	 *
	 * @param string $body_class The class attribute for the body tag
	 *
	 * @return string    The same attribute as passed in but with our ID added.
	 */
	public function filter_admin_body_class( $body_class ) {
		if ( version_compare( get_bloginfo( 'version' ), 3.8, 'ge' ) && !stristr( $body_class, 'rqf-modern' ) ) {
			$body_class .= ' rqf-modern';
		}

		return $body_class;
	}


	/**
	 * Finds the field according $name, first checking the $postarr then then post meta
	 * If post meta is found will return the individual value if one found, otherwise an array of values with that key
	 *
	 * @param string $name    The key to search for in the post data / meta data
	 * @param array $postarr The $_POST array
	 *
	 * @return mixed|null
	 */
	private function _find_field( $name, $postarr ) {

		if ( array_key_exists( $name, $postarr ) )
			return $postarr[ $name ];

		return null;
	}

	private function _find_meta_field( $name, $post_id ) {

		$custom_fields = get_post_meta( $post_id );
		if ( is_array( $custom_fields ) && array_key_exists( $name, $custom_fields ) ) {
			if ( count( $custom_fields[ $name ] ) > 1 )
				return $custom_fields[ $name ];
			return array_shift( $custom_fields[ $name ] );
		}

		return null;
	}

	// default validation callback
	public static function _not_empty( $value, $postarr ) {
		if ( is_string( $value ) )
			$value = trim( $value );
		return ! empty( $value );
	}

	// generic check if true
	public function _is_true( $value, $postarr ) {
		return (bool)$value;
	}

	// 1 is the ID of the 'Uncategorized' category
	public function _has_category( $value, $postarr ) {
		$cats = $postarr[ 'post_category' ];
		$cats = array_filter( $cats, array( $this, '_has_category_filter' ) );
		return count( $cats );
	}

	public function _has_category_filter( $id ) {
		return intval( $id ) > 1;
	}

	// Check we have at least one tag
	public function _has_tag( $value, $postarr ) {
		$tags = array_filter( explode( ',', $postarr[ 'tax_input' ][ 'post_tag' ] ) );
		return count( $tags );
	}

	// image size field validation
	public function _check_image_size_fields( $value ) {
		if ( ! is_array( $value ) )
			return false;
		return array_map( 'intval', $value );
	}

	// test featured image size
	public function _check_image_size( $value, $postarr ) {

		list( $req_width, $req_height ) = get_option( 'require_image_size_' . $postarr[ 'post_type' ], array( 0, 0 ) );

		// no required size
		if ( ! $req_width && ! $req_height )
			return true;

		// no thumbnail
		if ( ! $thumbnail_id = get_post_thumbnail_id( $postarr[ 'ID' ] ) )
			return true;

		$file = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		if ( $file ) {
			list( $src, $width, $height, $crop ) = $file;
			// original is wider than required
			if ( $width >= $req_width && $height >= $req_height )
				return true;
		}

		return false;
	}

}

if ( ! function_exists( 'register_required_field' ) ) {

	/**
	 * Registers a field as required for a post to be published.
	 * The default callback checks if the value of the post data or
	 * post meta field corresponding to the $name is empty or not.
	 *
	 * Use on admin_init or any hook after plugins_loaded
	 *
	 * @param string $name          The post data array key or custom field key
	 * @param string $message       The error message to display if validation fails
	 * @param bool|callback $validation_cb 	A callback that returns true if the field value is ok. Takes 2 arguments, $value if found and $postarr - the full $_POST array
	 * 										If false the default not empty check is used
	 * @param string|array $post_type     The post type or array of post types to run the validation on
	 * @param string $highlight 	The CSS selector of the html element to highlight when this error occurs
	 * @param bool $soft 			If true only shows a warning instead of an error and won't prevent publishing
	 *
	 * @return void
	 */
	function register_required_field( $name, $message = '', $validation_cb = false, $post_type = 'post', $highlight = '', $soft = false ) {
		$rf = kws_required_fields::instance();
		$rf->register( $name, $message, $validation_cb, $post_type, $highlight, $soft );
	}

}

if ( ! function_exists( 'unregister_required_field' ) ) {

	/**
	 * Unregisters a field validation by name and callback and optionally for specific post type(s)
	 * Should be called on admin_init
	 *
	 * @param string $name          The post data array key or custom field key
	 * @param bool|callback|string $validation_cb 	The callback to remove. If false the default not empty check
	 * 												is removed. If 'all' then all validations are removed for $name
	 * @param string|array $post_type     The post type or array of post types to run the validation on
	 *
	 * @return void
	 */
	function unregister_required_field( $name, $validation_cb = false, $post_type = 'post' ) {
		$rf = kws_required_fields::instance();
		$rf->unregister( $name, $validation_cb, $post_type );
	}

}

}
