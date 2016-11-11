<?php
/**
 * <%= optionsname %>
 *
 * @since <%= version %>
 * @package <%= pluginname %>
 */

<% if ( ! composer && ! options.nocmb2 ) {
	%>require_once dirname(__FILE__) . '/../vendor/cmb2/init.php';<%
} %>

/**
 * <%= optionsname %> class.
 *
 * @since <%= version %>
 */
class <%= classname %> {
	/**
	 * Parent plugin class
	 *
	 * @var    <%= mainclassname %>
	 * @since  NEXT
	 */
	protected $plugin = null;

	/**
	 * Option key, and option page slug
	 *
	 * @var    string
	 * @since  NEXT
	 */
	protected $key = '<%= optionsprefix %>';

	/**
	 * Options page metabox id
	 *
	 * @var    string
	 * @since  NEXT
	 */
	protected $metabox_id = '<%= optionsprefix %>_metabox';

	/**
	 * Options Page title
	 *
	 * @var    string
	 * @since  NEXT
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 *
	 * @since  NEXT
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		$this->title = __( '<%= optionsname %>', '<%= slug %>' );
	}

	/**
	 * Initiate our hooks
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );<% if ( ! options.nocmb2 ) { %>
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );<% } %>
	}

	/**
	 * Register our setting to WP
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function admin_init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page(
			$this->title,
			$this->title,
			'manage_options',
			$this->key,
			array( $this, 'admin_page_display' )
		);

		// Include CMB CSS in the head to avoid FOUC.
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo esc_attr( $this->key ); ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2><% if ( ! options.nocmb2 ) { %>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?><% } %>
		</div>
		<?php
	}<% if ( ! options.nocmb2 ) { %>

	/**
	 * Add custom fields to the options page.
	 *
	 * @since  NEXT
	 * @return void
	 */
	public function add_options_page_metabox() {

		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove.
				'key'   => 'options-page',
				'value' => array( $this->key ),
			),
		) );

		/*
		Add your fields here

		$cmb->add_field( array(
			'name'    => __( 'Test Text', 'myprefix' ),
			'desc'    => __( 'field description (optional)', 'myprefix' ),
			'id'      => 'test_text', // no prefix needed
			'type'    => 'text',
			'default' => __( 'Default Text', 'myprefix' ),
		) );
		*/

	}<% } %>
}
