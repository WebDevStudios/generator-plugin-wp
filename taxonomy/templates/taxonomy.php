<?php
/**
 * <%= taxonomyname %>
 *
 * @version <%= version %>
 * @package <%= pluginname %>
 */

<% if ( ! composer ) {
	%>require_once dirname(__FILE__) . '/../vendor/taxonomy-core/Taxonomy_Core.php';<%
} %>

class <%= classname %> extends Taxonomy_Core {
	/**
	 * Parent plugin class
	 *
	 * @var class
	 * @since  <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 * Register Taxonomy. See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php
	 *
	 * @since <%= version %>
	 * @return  null
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Register this taxonomy
		// First parameter should be an array with Singular, Plural, and Registered name
		// Second parameter is the register taxonomy arguments
		// Third parameter is post types to attach to.
		parent::__construct(
			array( __( '<%= taxonomyname %>', '<%= slug %>' ), __( '<%= taxonomyname %>s', '<%= slug %>' ), '<%= taxonomyslug %>' ),
			array( 'hierarchical' => false ),
			array( 'post' )
		);
	}

	/**
	 * Initiate our hooks
	 *
	 * @since <%= version %>
	 * @return  null
	 */
	public function hooks() {
	}
}
