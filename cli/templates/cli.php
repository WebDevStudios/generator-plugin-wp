<?php
/**
 * <%= cliname %>
 *
 * @since NEXT
 * @package <%= pluginname %>
 */

/**
 * <%= cliname %>.
 *
 * @since NEXT
 */
class <%= classname %> {
	/**
	 * Parent plugin class
	 *
	 * @var   <%= mainclassname %>
	 * @since NEXT
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
		$this->verify_wp_cli() {
			$this->cli_hooks();
		}

	}

	public function verify_wp_cli() {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			return true;
		}
		return false;
	}

	/**
	 * Initiate our hooks
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function cli_hooks() {
		WP_CLI::add_command( '<%= cliname %>', array($this,'<%= cliname %>_command' );
	}

	/**
	 * Create a method stub for our first CLI command.
	 *
	 * @since NEXT
	 * @return void
	 */
	public function <%= cliname %>_command() {

	}
}
