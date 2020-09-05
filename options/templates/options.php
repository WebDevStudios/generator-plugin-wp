<?php
/**
 * <%= optionsname %>.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
 */ // @codingStandardsIgnoreLine
<% if ( ! composer && ! options.nocmb2 ) { %> // @codingStandardsIgnoreLine
/**
 * Include CMB2
 *
 * @since <%= version %>
 */
require_once dirname( __FILE__ ) . '/../vendor/cmb2/init.php';
<% } %> // @codingStandardsIgnoreLine
/**
 * <%= optionsname %> class.
 *
 * @since <%= version %>
 */
class <%= classname %> { // @codingStandardsIgnoreLine
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
	protected static $metabox_id = '<%= optionsprefix %>_metabox';

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
<% if ( options.nocmb2 ) { // @codingStandardsIgnoreLine
%>		add_action( 'admin_init', array( $this, 'admin_init' ) ); // @codingStandardsIgnoreLine
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );<% } else { // @codingStandardsIgnoreLine
%>		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );<% } %> // @codingStandardsIgnoreLine
	}<% if ( options.nocmb2 ) { %> // @codingStandardsIgnoreLine

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
	}

	/**
	 * Admin page markup. Mostly handled by CMB2.
	 *
	 * @since  <%= version %>
	 */
	public function admin_page_display() {
		?>
		<div class="wrap options-page <?php echo esc_attr( self::$key ); ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php // Your settings here. ?>
		</div>
		<?php
	}<% } else { %> // @codingStandardsIgnoreLine

	/**
	 * Add custom fields to the options page.
	 *
	 * @since  <%= version %>
	 */
	public function add_options_page_metabox() {

		// Add our CMB2 metabox.
		$cmb = new_cmb2_box(
			array(
				'id'           => self::$metabox_id,
				'title'        => $this->title,
				'object_types' => array( 'options-page' ),

				/*
				* The following parameters are specific to the options-page box
				* Several of these parameters are passed along to add_menu_page()/add_submenu_page().
				*/

				'option_key'   => self::$key, // The option key and admin menu page slug.
				// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
				// 'menu_title'      => esc_html__( 'Options', 'cmb2' ), // Falls back to 'title' (above).
				// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
				// 'capability'      => 'manage_options', // Cap required to view options-page.
				// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
				// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
				// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
				// 'save_button'     => esc_html__( 'Save Theme Options', 'cmb2' ), // The text for the options-page save button. Defaults to 'Save'.
			)
		);

		// Add your fields here.
		$cmb->add_field(
			array(
				'name'    => __( 'Test Text', '<%= slug %>' ),
				'desc'    => __( 'field description (optional)', '<%= slug %>' ),
				'id'      => 'test_text', // No prefix needed.
				'type'    => 'text',
				'default' => __( 'Default Text', '<%= slug %>' ),
			)
		);
	}

	/**
	 * Wrapper function around cmb2_get_option.
	 *
	 * @since  <%= version %>
	 *
	 * @param  string $key     Options array key.
	 * @param  mixed  $default Optional default value.
	 * @return mixed           Option value.
	 */
	public static function get_value( $key = '', $default = false ) {
		if ( function_exists( 'cmb2_get_option' ) ) {

			// Use cmb2_get_option as it passes through some key filters.
			return cmb2_get_option( self::$key, $key, $default );
		}

		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( self::$key, $default );

		$val = $default;

		if ( 'all' === $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}

		return $val;
	}<% } %> // @codingStandardsIgnoreLine
}
