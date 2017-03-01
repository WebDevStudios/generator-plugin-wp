<?php
/**
 * <%= cptname %>
 *
 * @since <%= version %>
 * @package <%= mainclassname %>
 */

<% if ( ! composer ) {
	%>require_once dirname( __FILE__ ) . '/../vendor/cpt-core/CPT_Core.php';<%
	if ( ! options.nocmb2 ) { %>
<%		%>require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';<%
	}
} %>

/**
 * <%= cptname %> post type class.
 *
 * @see https://github.com/WebDevStudios/CPT_Core
 * @since <%= version %>
 */
class <%= classname %> extends CPT_Core {
	/**
	 * Parent plugin class.
	 *
	 * @var <%= mainclassname %>
	 * @since  <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Constructor.
	 * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php.
	 *
	 * @since  <%= version %>
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Register this cpt.
		// First parameter should be an array with Singular, Plural, and Registered name.
		parent::__construct(
			array(
				__( '<%= cptname %>', '<%= slug %>' ),
				__( '<%= cptname %>s', '<%= slug %>' ),
				'<%= cptslug %>',
			),
			array(
				'supports' => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
				),
			)
		);
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function hooks() {<% if ( ! options.nocmb2 ) { %>
		add_action( 'cmb2_init', array( $this, 'fields' ) );
	}

	/**
	 * Add custom fields to the CPT.
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function fields() {

		// Set our prefix.
		$prefix = '<%= cptprefix %>_';

		// Define our metaboxes and fields.
		$cmb = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => __( '<%= cptname %> Meta Box', '<%= slug %>' ),
			'object_types'  => array( '<%= cptslug %>' ),
		) );<% } %>
	}

	/**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 *
	 * @since  <%= version %>
	 * @param  array $columns Array of registered column names/labels.
	 * @return array          Modified array
	 */
	public function columns( $columns ) {
		$new_column = array();
		return array_merge( $new_column, $columns );
	}

	/**
	 * Handles admin column display. Hooked in via CPT_Core.
	 *
	 * @since  <%= version %>
	 * @param array $column  Column currently being rendered.
	 * @param int   $post_id ID of post to display column for.
	 */
	public function columns_display( $column, $post_id ) {
		switch ( $column ) {
		}
	}
}
