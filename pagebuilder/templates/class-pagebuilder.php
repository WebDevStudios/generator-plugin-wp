<?php
/**
 * <%= includename %>
 * @version <%= version %>
 * @package <%= pluginname %>
 */

/**
 * WDS Simple Page Builder Class
 */
class <%= classname %> {
	/**
	 * Parent plugin class
	 *
	 * @var   class
	 * @since <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 *
	 * @param string $plugin The parent class.
	 * @since  <%= version %>
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function hooks() {
		add_action( 'spb_init', array( $this, 'load_pagebuilder_parts' ) );
	}

	/**
	 * Registers our parts directory in the Page Builder template stack.
	 *
	 * @since  <% version %>
	 * @return void
	 */
	public function load_pagebuilder_parts() {
		spb_register_template_stack( '<%= prefix %>_get_template_part_dir', 10 );
	}
}

/**
 * Register our plugin's template parts directory.
 * This function needs to be in the global scope to work properly.
 *
 * @since  <% version %>
 * @return string Absolute path to template parts directory.
 */
function <% prefix %>_get_template_part_dir() {
	/**
	 * Filters the absolute path of the template location.
	 *
	 * @param string The absolute path of the template package in use.
	 */
	return apply_fitlers( '<% prefix %>_get_template_part_dir', <% prefix %>()->path . '<% partsdir %>/' );
}
