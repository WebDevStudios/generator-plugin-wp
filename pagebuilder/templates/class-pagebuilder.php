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
	}
}
