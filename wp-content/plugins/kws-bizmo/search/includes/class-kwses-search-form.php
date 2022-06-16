<?php
/**
 * Render the search form
 *
 * @package KWSES/Classes
 * @author kwstech
 */

defined( 'ABSPATH' ) || exit();

/**
 * Class to render the search form markup.
 */
class KWSES_Search_Form {
	/**
	 * Form default arguments.
	 *
	 * @since 2.0
	 * @var array
	 */
	private $form_default_args = false;

	/**
	 * Class constructor
	 *
	 * @since 2.0
	 */
	public function __construct() {
		$this->form_default_args = array(
			'kwsessid'                 => false,
			'submit_button_label'     => esc_attr_x( 'Search', 'submit button' ),
			'input_box_placeholder'   => esc_attr_x( 'Search &hellip;', 'placeholder' ),
			'search_form_css_class'   => '',
			'search_button_css_class' => '',
			'search_input_css_class'  => '',
			'aria_label'              => '',
		);

		add_shortcode( 'kwses_search_form', array( $this, 'register_search_form_shortcode' ) );
	}

	/**
	 * Magic method to access the class properties.
	 *
	 * @since 2.0
	 * @param string $name Name of the property.
	 * @return mixed property or false
	 */
	public function __get( $name ) {
		if ( isset( $this->$name ) ) {
			return $this->$name;
		}

		return false;
	}

	/**
	 * Get form default argument keys with description.
	 *
	 * @since 2.0
	 * @param string $key_name argument key name to get default value.
	 * @return mixed Array of arguments or single argument default value.
	 */
	public function get_form_default_args( $key_name = false ) {
		$args_desc = array(
			'kwsessid'                 => __( 'Search setting ID', 'wp-extended-search' ),
			'submit_button_label'     => __( 'Label of search button', 'wp-extended-search' ),
			'input_box_placeholder'   => __( 'Placeholder value for search input box', 'wp-extended-search' ),
			'search_form_css_class'   => __( 'CSS class names on search form element', 'wp-extended-search' ),
			'search_button_css_class' => __( 'CSS class names on search button element', 'wp-extended-search' ),
			'search_input_css_class'  => __( 'CSS class names on search input element', 'wp-extended-search' ),
			'aria_label'              => __( 'ARIA label for the search form', 'wp-extended-search' ),
		);

		if ( ! empty( $key_name ) ) {
			return isset( $this->form_default_args[ $key_name ] ) ? $this->form_default_args[ $key_name ] : false;
		}

		return $args_desc;
	}

	/**
	 * Register WP shortcode
	 *
	 * @since 2.0
	 * @param array $atts Array of shortcode attributes.
	 * @return mixed Output of shortcode.
	 */
	public function register_search_form_shortcode( $atts ) {
		$atts = shortcode_atts( $this->form_default_args, $atts, 'kwses_search_form' );
		return $this->get_search_form( $atts );
	}

	/**
	 * Get the search form.
	 *
	 * @since 2.0
	 * @param array $args Array of arguments.
	 * @return mixed Search form HTML.
	 */
	public function get_search_form( $args = array() ) {

		$args = wp_parse_args( $args, $this->form_default_args );

		// Returns blank string if current setting ID does belong to widget.
		if ( ! empty( KWSES()->current_setting_id ) && KWSES()->current_setting_id != $args['kwsessid'] ) {
			return '';
		}

		/**
		 * Follow the link for documentation.
		 *
		 * @link https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/general-template.php#L171
		 */
		do_action( 'pre_get_search_form' );

		// Load search form template if exist for specific setting. e.g. kwses-searchform-1 where 1 is setting ID.
		$template_file        = empty( $args['kwsessid'] ) ? 'kwses-searchform.php' : 'kwses-searchform-' . $args['kwsessid'] . '.php';
		$search_form_template = locate_template( $template_file );
		if ( '' != $search_form_template ) {
			ob_start();
			require( $search_form_template );
			$form = ob_get_clean();

			// Add kwsessid hidden field to search form.
			$count = 1;
			$form  = str_replace( '</form>', $this->get_kwsessid_hidden_field( $args['kwsessid'] ) . '</form>', $form, $count );
		} else {
			// Build a string containing an aria-label to use for the search form.
			if ( isset( $args['aria_label'] ) && $args['aria_label'] ) {
				$aria_label = 'aria-label="' . esc_attr( $args['aria_label'] ) . '" ';
			} else {
				/*
				* If there's no custom aria-label, we can set a default here. At the
				* moment it's empty as there's uncertainty about what the default should be.
				*/
				$aria_label = '';
			}

			$form = '<form ' . $this->get_form_id_attr( $args['kwsessid'] ) . ' role="search" ' . $aria_label . 'method="get" class="search-form ' . $args['search_form_css_class'] . '" action="' . esc_url( home_url( '/' ) ) . '">
		<label>
		    <span class="screen-reader-text">' . _x( 'Search for:', 'label' ) . '</span>
		    <input type="search" class="search-field ' . $args['search_input_css_class'] . '" placeholder="' . $args['input_box_placeholder'] . '" value="' . get_search_query() . '" name="s" />
		</label>
		<input type="submit" class="search-submit ' . $args['search_button_css_class'] . '" value="' . $args['submit_button_label'] . '" />' .
			$this->get_kwsessid_hidden_field( $args['kwsessid'] ) .
			'</form>';
		}

		/**
		 * Follow the link for the documentation.
		 *
		 * @link https://core.trac.wordpress.org/browser/tags/5.2/src/wp-includes/general-template.php#L171
		 */
		$result = apply_filters( 'get_search_form', $form );

		// Return the original form before filter if form is null or does not contain the kwsessid field.
		if ( null === $result || ( ! empty( $this->get_kwsessid_hidden_field( $args['kwsessid'] ) ) && false === strpos( $result, $this->get_kwsessid_hidden_field( $args['kwsessid'] ) ) ) ) {
			$result = $form;
		}

		return $result;
	}

	/**
	 * Get HTML hidden field for setting ID.
	 *
	 * @since 2.0
	 * @param int $kwsessid KWSES setting ID.
	 * @return string HTML hidden field.
	 */
	public function get_kwsessid_hidden_field( $kwsessid = false ) {
		if ( ! empty( $kwsessid ) ) {
			return "<input type='hidden' value='$kwsessid' name='kwsessid' />";
		}

		return '';
	}

	/**
	 * Get form ID HTML attribute.
	 *
	 * @since 2.0
	 * @param int $kwsessid KWSES setting ID.
	 * @return string ID attribute.
	 */
	public function get_form_id_attr( $kwsessid = false ) {
		if ( ! empty( $kwsessid ) ) {
			return "id='kwses-form-$kwsessid'";
		}

		return '';
	}
}
