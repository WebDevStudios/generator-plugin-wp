<?php
/**
 * <%= widgetname %>.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
 */

/**
 * <%= widgetname %> class.
 *
 * @since <%= version %>
 */
class <%= classname %> extends WP_Widget {

	/**
	 * Unique identifier for this widget.
	 *
	 * Will also serve as the widget class.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $widget_slug = '<%= widgetslug %>';


	/**
	 * Widget name displayed in Widgets dashboard.
	 * Set in __construct since __() shouldn't take a variable.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $widget_name = '';


	/**
	 * Default widget title displayed in Widgets dashboard.
	 * Set in __construct since __() shouldn't take a variable.
	 *
	 * @var string
	 * @since  <%= version %>
	 */
	protected $default_widget_title = '';

	/**
	 * Shortcode name for this widget
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected static $shortcode = '<%= widgetslug %>';

	/**
	 * Construct widget class.
	 *
	 * @since  <%= version %>
	 */
	public function __construct() {

		$this->widget_name = esc_html__( '<%= widgetname %>', '<%= slug %>' );
		$this->default_widget_title = esc_html__( '<%= widgetname %>', '<%= slug %>' );

		parent::__construct(
			$this->widget_slug,
			$this->widget_name,
			array(
				'classname'   => $this->widget_slug,
				'description' => esc_html__( 'A widget boilerplate description.', '<%= slug %>' ),
			)
		);

		// Clear cache on save.
		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );

		// Add a shortcode for our widget.
		add_shortcode( self::$shortcode, array( __CLASS__, 'get_widget' ) );
	}

	/**
	 * Delete this widget's cache.
	 *
	 * Note: Could also delete any transients
	 * delete_transient( 'some-transient-generated-by-this-widget' );
	 *
	 * @since  <%= version %>
	 */
	public function flush_widget_cache() {
		wp_cache_delete( $this->widget_slug, 'widget' );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @since  <%= version %>
	 *
	 * @param  array $args     The widget arguments set up when a sidebar is registered.
	 * @param  array $instance The widget settings as set by user.
	 */
	public function widget( $args, $instance ) {

		// Set widget attributes.
		$atts = array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'before_title'  => $args['before_title'],
			'after_title'   => $args['after_title'],
			'title'         => $instance['title'],
			'text'          => $instance['text'],
		);

		// Display the widget.
		echo self::get_widget( $atts ); // WPCS XSS OK.
	}

	/**
	 * Return the widget/shortcode output
	 *
	 * @since  <%= version %>
	 *
	 * @param  array $atts Array of widget/shortcode attributes/args.
	 * @return string      Widget output
	 */
	public static function get_widget( $atts ) {

		$defaults = array(
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
			'title'         => '',
			'text'          => '',
		);

		// Parse defaults and create a shortcode.
		$atts = shortcode_atts( $defaults, (array) $atts, self::$shortcode );

		// Start an output buffer.
		ob_start();

		// Start widget markup.
		echo $atts['before_widget']; // WPCS XSS OK.

		// Maybe display widget title.
		echo ( $atts['title'] ) ? $atts['before_title'] . esc_html( $atts['title'] ) . $atts['after_title'] : '' ; // WPCS XSS OK.

		// Display widget text.
		echo wpautop( wp_kses_post( $atts['text'] ) ); // WPCS XSS OK.

		// End the widget markup.
		echo $atts['after_widget']; // WPCS XSS OK.

		// Return the output buffer.
		return ob_get_clean();
	}

	/**
	 * Update form values as they are saved.
	 *
	 * @since  <%= version %>
	 *
	 * @param  array $new_instance New settings for this instance as input by the user.
	 * @param  array $old_instance Old settings for this instance.
	 * @return array               Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {

		// Previously saved values.
		$instance = $old_instance;

		// Sanity check new data existing.
		$title = isset( $new_instance['title'] ) ? $new_instance['title'] : '';
		$text  = isset( $new_instance['text'] ) ? $new_instance['text'] : '';

		// Sanitize title before saving to database.
		$instance['title'] = sanitize_text_field( $title );

		// Sanitize text before saving to database.
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = force_balance_tags( $text );
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $text ) ) );
		}

		// Flush cache.
		$this->flush_widget_cache();

		return $instance;
	}

	/**
	 * Back-end widget form with defaults.
	 *
	 * @since  <%= version %>
	 *
	 * @param  array $instance Current settings.
	 */
	public function form( $instance ) {

		// Set defaults.
		$defaults = array(
			'title' => $this->default_widget_title,
			'text'  => '',
		);

		// Parse args.
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', '<%= slug %>' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" placeholder="optional" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>">
				<?php esc_html_e( 'Text:', '<%= slug %>' ); ?>
			</label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>
		<p class="description">
			<?php esc_html_e( 'Basic HTML tags are allowed.', '<%= slug %>' ); ?>
		</p>
		<?php
	}
}

/**
 * Register widget with WordPress.
 */
function <%= widgetregister %>() {
	register_widget( '<%= classname %>' );
}
add_action( 'widgets_init', '<%= widgetregister %>' );
