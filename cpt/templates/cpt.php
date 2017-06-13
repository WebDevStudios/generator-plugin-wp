<?php
/**
 * <%= cptname %>.
 *
 * class-name: <%= classname %>
 * class-slug: <%= nameslug %>
 * class-active: true
 *
 * @since   <%= version %>
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
 * @since <%= version %>
 *
 * @see   https://github.com/WebDevStudios/CPT_Core
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
	 *
	 * Register Custom Post Types.
	 *
	 * See documentation in CPT_Core, and in wp-includes/post.php.
	 *
	 * @since  <%= version %>
	 *
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Register this cpt.
		// First parameter should be an array with Singular, Plural, and Registered name.
		parent::__construct(
			array(
				esc_html__( '<%= cptname %>', '<%= slug %>' ),
				esc_html__( '<%= cptname %>s', '<%= slug %>' ),
				'<%= cptslug %>',
			),
			array(
				'supports' => array(
					'title',
					'editor',
					'excerpt',
					'thumbnail',
				),
				'menu_icon' => 'dashicons-admin-post', // https://developer.wordpress.org/resource/dashicons/
				'public'    => true,
			)
		);
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  <%= version %>
	 */
	public function hooks() {<% if ( ! options.nocmb2 ) { %>
		add_action( 'cmb2_init', array( $this, 'fields' ) );
	}

	/**
	 * Add custom fields to the CPT.
	 *
	 * @since  <%= version %>
	 */
	public function fields() {

		// Set our prefix.
		$prefix = '<%= cptprefix %>_';

		// Define our metaboxes and fields.
		$cmb = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => esc_html__( '<%= cptname %> Meta Box', '<%= slug %>' ),
			'object_types'  => array( '<%= cptslug %>' ),
		) );<% } %>
	}

	/**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 *
	 * @since  <%= version %>
	 *
	 * @param  array $columns Array of registered column names/labels.
	 * @return array          Modified array.
	 */
	public function columns( $columns ) {
		$new_column = array();
		return array_merge( $new_column, $columns );
	}

	/**
	 * Handles admin column display. Hooked in via CPT_Core.
	 *
	 * @since  <%= version %>
	 *
	 * @param array   $column   Column currently being rendered.
	 * @param integer $post_id  ID of post to display column for.
	 */
	public function columns_display( $column, $post_id ) {
		switch ( $column ) {
		}
	}
}
