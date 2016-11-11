<?php
/**
 * <%= cliname %>
 *
 * @since   <%= version %>
 * @package <%= pluginname %>
 */

/**
 * <%= cliname %>.
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
	protected
	$plugin = null;

	/**
	 * Constructor
	 *
	 * @since  <%= version %>
	 *
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 *
	 * @return void
	 */
	public
	function __construct( $plugin ) {
		$this->plugin = $plugin;
		if ( $this->verify_wp_cli() ) {
			$this->cli_hooks();
		}

	}

	public
	function verify_wp_cli() {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			return true;
		}

		return false;
	}

	/**
	 * Initiate our hooks
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public
	function cli_hooks() {
		WP_CLI::add_command( '<%= nameslug %>', array( $this, '<%= nameslug %>_command' ) );
	}

	/**
	 * Create a method stub for our first CLI command.
	 *
	 * @since <%= version %>
	 * @return void
	 */
	public
	function <%= nameslug %>_command(){

	}
}
