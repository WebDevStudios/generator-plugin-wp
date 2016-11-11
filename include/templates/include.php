<?php
/**
 * <%= includename %>
 *
 * @since <%= version %>
 * @package <%= pluginname %>
 */

/**
 * <%= includename %>.
 *
 * @since <%= version %>
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
	}
}
