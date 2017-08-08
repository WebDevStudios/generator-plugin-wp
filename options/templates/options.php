<?php
/**
 * <%= optionsname %>.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
 */

<% if ( ! composer && options.nocmb2 ) {
	%>require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';<%
} %>

/**
 * <%= optionsname %> class.
 *
 * @since <%= version %>
 */
class <%= classname %> {
	/**
	 * Parent plugin class.
	 *
	 * @var    <%= mainclassname %>
	 * @since  <%= version %>
	 */
	protected $plugin = null;

	/**
	 * Option key, and option page slug.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected static $key = '<%= optionsprefix %>';

	/**
	 * Options page metabox ID.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $metabox_id = '<%= optionsprefix %>_metabox';

	/**
	 * Options Page title.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $title = '';

	/**
	 * Options Page hook.
	 *
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor.
	 *
	 * @since  <%= version %>
	 *
	 * @param  <%= mainclassname %> $plugin Main plugin object.
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();

		// Set our title.
		$this->title = esc_attr__( '<%= optionsname %>', '<%= slug %>' );
	}

	/**
	 * Initiate our hooks.
	 *
	 * @since  <%= version %>
	 */
	public function hooks() {

		// Hook in our actions to the admin.
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		<% if ( ! options.nocmb2 ) { %>
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
		<% } %>
	}

	/**
	 * Register our setting to WP.
	 *
	 * @since  <%= version %>
	 */
	public function admin_init() {
		register_setting( self::$key, self::$key );
	}

	/**
	 * Add menu options page.
	 *
	 * @since  <%= version %>
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page(
			$this->title,
			$this->title,
			'manage_options',
			self::$key,
			array( $this, 'admin_page_display' )
		);

		// Include CMB CSS in the head to avoid FOUC.
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2.
	 *
	 * @since  <%= version %>
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo esc_attr( self::$key ); ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2><% if ( ! options.nocmb2 ) { %>
			<?php cmb2_metabox_form( $this->metabox_id, self::$key ); ?><% } %>
		</div>
		<?php
	}<% if ( ! options.nocmb2 ) { %>

	/**
	 * Add custom fields to the options page.
	 *
	 * @since  <%= version %>
	 */
	public function add_options_page_metabox() {

		// hook in our save notices
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

		// Add our CMB2 metabox.
		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove.
				'key'   => 'options-page',
				'value' => array( self::$key ),
			),
		) );

		// Add your fields here.
		$cmb->add_field( array(
			'name'    => __( 'Test Text', '<%= slug %>' ),
			'desc'    => __( 'field description (optional)', '<%= slug %>' ),
			'id'      => 'test_text', // No prefix needed.
			'type'    => 'text',
			'default' => __( 'Default Text', '<%= slug %>' ),
		) );

	}

	/**
	 * Register settings notices for display
	 *
	 * @since  0.1.0
	 * @param  int   $object_id Option key
	 * @param  array $updated   Array of updated fields
	 * @return void
	 */
	public function settings_notices( $object_id, $updated ) {
		if ( $object_id !== self::$key || empty( $updated ) ) {
			return;
		}

		add_settings_error( self::$key . '-notices', '', __( 'Settings updated.', 'myprefix' ), 'updated' );
		settings_errors( self::$key . '-notices' );
	}

	/**
	 * Wrapper function around cmb2_get_option.
	 *
	 * @since  <%= version %>
	 *
	 * @param  string $key     Options array key
	 * @param  mixed  $default Optional default value
	 * @return mixed           Option value
	 */
	public static function get_value( $key = '', $default = false ) {
		if ( function_exists( 'cmb2_get_option' ) ) {

			// Use cmb2_get_option as it passes through some key filters.
			return cmb2_get_option( self::$key, $key, $default );
		}

		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( self::$key, $default );

		$val = $default;

		if ( 'all' == $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}

		return $val;
	}<% } %>
}
