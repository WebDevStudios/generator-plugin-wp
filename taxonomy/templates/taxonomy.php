<?php
/**
 * <%= taxonomyname %>.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
 */ // @codingStandardsIgnoreLine
<% if ( ! composer ) { %> // @codingStandardsIgnoreLine
/**
 * Include Taxonomy Core
 *
 * @since   <%= version %>
 */
require_once dirname( __FILE__ ) . '/../vendor/taxonomy-core/Taxonomy_Core.php';
<% if ( options.cmb2 ) { %> // @codingStandardsIgnoreLine
/**
 * Include CMB2
 *
 * @since   <%= version %>
 */
require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';
<% } // @codingStandardsIgnoreLine
} %> // @codingStandardsIgnoreLine
/**
 * <%= taxonomyname %>.
 *
 * @since <%= version %>
 *
 * @see   https://github.com/WebDevStudios/Taxonomy_Core
 */
class <%= classname %> extends Taxonomy_Core { // @codingStandardsIgnoreLine
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
	 * Register Taxonomy.
	 *
	 * See documentation in Taxonomy_Core, and in wp-includes/taxonomy.php.
	 *
	 * @since  <%= version %>
	 *
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		parent::__construct(
			// Should be an array with Singular, Plural, and Registered name.
			array(
				__( '<%= taxonomyname %>', '<%= slug %>' ),
				__( '<%= taxonomyname %>s', '<%= slug %>' ),
				'<%= taxonomyslug %>',
			),
			// Register taxonomy arguments.
			array(
				'hierarchical' => false,
			),
			// Post types to attach to.
			array(
				'post',
			)
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
