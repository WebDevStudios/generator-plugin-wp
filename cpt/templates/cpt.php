<?php
/**
 * <%= cptname %>
 * @version <%= version %>
 * @package <%= pluginname %>
 */

<% if ( ! composer ) { %>
require_once '../vendor/cpt-core/CPT_Core.php';
<% } %>

class <%= classname %> extends CPT_Core {
	/**
	 * Parent plugin class
	 * @var class
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
	 *
	 * @since <%= version %>
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Register this cpt
		// First parameter should be an array with Singular, Plural, and Registered name
		parent::__construct(
			array( __( '<%= cptname %>', '<%= slug %>' ), __( '<%= cptname %>s', '<%= slug %>' ), '<%= cptslug %>' ),
			array( 'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ), )
		);
	}

	/**
	 * Initiate our hooks
	 * @since <%= version %>
	 */
	public function hooks() {
	}

	/**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 * @since  <%= version %>
	 * @param  array  $columns Array of registered column names/labels
	 * @return array           Modified array
	 */
	public function columns( $columns ) {
		$new_column = array(
		);
		return array_merge( $new_column, $columns );
	}

	/**
	 * Handles admin column display. Hooked in via CPT_Core.
	 * @since  <%= version %>
	 * @param  array  $column Array of registered column names
	 */
	public function columns_display( $column, $post_id ) {
		switch ( $column ) {
		}
	}
}