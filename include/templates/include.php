<?php
/**
 * <%= includename %>
 * @version <%= version %>
 * @package <%= name %>
 */

class <%= classname %> {
	/**
	 * Parent plugin class
	 * @var class
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 * @since <%= version %>
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks
	 * @since <%= version %>
	 */
	public function hooks() {
	}
}