<?php
/**
 * <%= cliname %>.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
 */

/**
 * <%= cliname %>.
 *
 * @since <%= version %>
 */
class <%= classname %> { // @codingStandardsIgnoreLine
	/**
	 * Parent plugin class
	 *
	 * @var   <%= mainclassname %>
	 *
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

		// If we have WP CLI, add our commands.
		if ( $this->verify_wp_cli() ) {
			$this->add_commands();
		}
	}

	/**
	 * Check for WP CLI running.
	 *
	 * @since  <%= version %>
	 *
	 * @return boolean True if WP CLI currently running.
	 */
	public function verify_wp_cli() {
		return ( defined( 'WP_CLI' ) && WP_CLI );
	}

	/**
	 * Add our commands.
	 *
	 * @since  <%= version %>
	 */
	public function add_commands() {
		WP_CLI::add_command( '<%= uslug %>', array( $this, '<%= uslug %>_command' ) );
	}

	/**
	 * Create a method stub for our first CLI command.
	 *
	 * @since <%= version %>
	 */
	public function <%= uslug %>_command() { // @codingStandardsIgnoreLine

	}
}
