<?php
/**
 * <%= taxonomyname %>.
 *
 * @since   <%= version %>
 * @package <%= pluginname %>
 */

<% if ( ! composer ) {
	%>require_once dirname( __FILE__ ) . '/../vendor/taxonomy-core/Taxonomy_Core.php';<%
	if ( ! options.nocmb2 ) { %>
<%		%>require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';<%
	}
} %>

/**
 * <%= taxonomyname %> class.
 *
 * @see   https://github.com/WebDevStudios/Taxonomy_Core
 * @since <%= version %>
 */
class <%= classname %> extends Taxonomy_Core {

	/**
	 * Parent plugin class.
	 *
	 * @var    <%= mainclassname %>
	 * @since  <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 *
	 * Registers Taxonomy.
	 *
	 * See documentation in `Taxonomy_Core`, and in `wp-includes/taxonomy.php`.
	 *
	 * @since  <%= version %>
	 *
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		/*
		 * Register this taxonomy.
		 *
		 * - First parameter should be an array with Singular, Plural, and Registered name
		 * - Second parameter is the register taxonomy arguments
		 * - Third parameter is post types to attach to
		 */
		parent::__construct(
			array( __( '<%= taxonomyname %>', '<%= slug %>' ), __( '<%= taxonomyname %>s', '<%= slug %>' ), '<%= taxonomyslug %>' ),
			array( 'hierarchical' => false ),
			array( 'post' )
		);
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since <%= version %>
	 */
	public function hooks() {
	}
}
