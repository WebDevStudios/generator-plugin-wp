<?php
/**
 * <%= pluginname %> Page Builder
 *
 * @since <%= version %>
 * @package <%= pluginname %>
 */

/**
 * WDS Simple Page Builder Class
 */
class <%= classname %> {
	/**
	 * Parent plugin class
	 *
	 * @var   <%= mainclassname %>
	 * @since <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 *
	 * @since  NEXT
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function hooks() {
		add_action( 'spb_init', array( $this, 'load_pagebuilder_parts' ) );
	}

	/**
	 * Registers our parts directory in the Page Builder template stack.
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function load_pagebuilder_parts() {
		spb_register_template_stack( array( $this, 'get_template_part_dir' ), 10 );
	}

	/**
	 * Register our plugin's template parts directory.
	 * This function needs to be in the global scope to work properly.
	 *
	 * @since  NEXT
	 * @return string Absolute path to template parts directory.
	 */
	public function get_template_part_dir() {
		/**
		 * Filters the absolute path of the template location.
		 *
		 * @param string The absolute path of the template package in use.
		 */
		return apply_filters( '<%= prefix %>_get_template_part_dir', $this->plugin->path . '<%= partsdir %>/' );
	}
}
