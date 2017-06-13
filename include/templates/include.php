<?php namespace <%= mainclassname %>\<%= classname %>;
/**
 * <%= includename %>.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
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
	 * @since <%= version %>
	 *
	 * @var   <%= mainclassname %>
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

	}
}
