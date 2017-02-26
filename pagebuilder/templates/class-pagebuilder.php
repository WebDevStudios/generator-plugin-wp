<?php
/**
 * <%= pluginname %> Page Builder.
 *
 * @since   <%= version %>
 * @package <%= pluginname %>
 */

/**
 * WDS Simple Page Builder Class.
 *
 * @since <%= version %>
 */
class <%= classname %> {

	/**
	 * Parent plugin class.
	 *
	 * @var   <%= mainclassname %>
	 * @since <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * @since  <%= version %>
	 *
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  <%= version %>
	 */
	public function hooks() {
		add_action( 'spb_init', array( $this, 'load_pagebuilder_parts' ) );
	}

	/**
	 * Registers our parts directory in the Page Builder template stack.
	 *
	 * @since  <%= version %>
	 */
	public function load_pagebuilder_parts() {
		spb_register_template_stack( array( $this, 'get_template_part_dir' ), 10 );
	}

	/**
	 * Register our plugin's template parts directory.
	 *
	 * This function needs to be in the global scope to work properly.
	 *
	 * @since  <%= version %>
	 *
	 * @return string Absolute path to template parts directory.
	 */
	public function get_template_part_dir() {

		// The absolute path to the template parts directory.
		$default = $this->plugin->path . '<%= partsdir %>/';

		/**
		 * Filters the absolute path of the template location.
		 *
		 * @var   string Absolute path to template parts directory.
		 */
		$filtered = apply_filters( '<%= prefix %>_get_template_part_dir', $default );

		if ( is_string( $filtered ) ) {
			return $filtered;
		}

		return $default;
	}
}
