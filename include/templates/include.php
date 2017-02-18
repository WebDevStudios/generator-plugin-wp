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
	}
}
