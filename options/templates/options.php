<?php
/**
 * <%= optionsname %>
 * @version <%= version %>
 * @package <%= pluginname %>
 */

<% if ( ! composer && ! options.nocmb2 ) {
	%>require_once '../vendor/cmb2/init.php';<%
} %>

class <%= classname %> {
	/**
	 * Parent plugin class
	 *
	 * @var class
	 * @since  <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Option key, and option page slug
	 *
	 * @var string
	 * @since  <%= version %>
	 */
	private $key = '<%= optionsprefix %>';

	/**
	 * Options page metabox id
	 *
	 * @var string
	 * @since  <%= version %>
	 */
	private $metabox_id = '<%= optionsprefix %>_metabox';

	/**
	 * Options Page title
	 *
	 * @var string
	 * @since  <%= version %>
	 */
	protected $title = '';

	/**
	 * Constructor
	 *
	 * @since <%= version %>
	 * @return  null
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		$this->title = __('<%= optionsname %>','<%= slug %>');
	}

	/**
	 * Initiate our hooks
	 *
	 * @since <%= version %>
	 * @return  null
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );<% if ( ! options.nocmb2 ) { %>
		add_action( 'cmb2_init', array( $this, 'fields' ) );<% } %>
	}

	/**
	 * Register our setting to WP
	 *
	 * @since  <%= version %>
	 * @return null
	 */
	public function admin_init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 *
	 * @since <%= version %>
	 * @return  null
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page(
			$this->title,
			$this->title,
			'manage_options',
			$this->key,
			array( $this, 'admin_page_display' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 *
	 * @since  <%= version %>
	 * @return  null
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2><% if ( ! options.nocmb2 ) { %>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?><% } %>
		</div>
		<?php
	}<% if ( ! options.nocmb2 ) { %>

	/**
	 * Add custom fields to the options page.
	 *
	 * @since <%= version %>
	 * @return  null
	 */
	public function fields() {
		$box = new_cmb2_box( array(
			'id'      => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );
	}<% } %>
}
