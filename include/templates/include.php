<?php
/**
 * <%= includename %>
 * @version <%= version %>
 * @package <%= pluginname %>
 */

class <%= classname %> {
	/**
	 * Parent plugin class
	 *
	 * @var class
	 * @since  <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 *
	 * @since <%= version %>
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
