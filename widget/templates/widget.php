<?php
/**
 * <%= widgetname %>.
 *
 * @since   <%= version %>
 * @package <%= pluginname %>
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
	 *
	 * Set in `__construct` since `__()` shouldn't take a variable.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $widget_name = '';

	/**
	 * Default widget title displayed in Widgets dashboard.
	 *
	 * Set in `__construct` since `__()` shouldn't take a variable.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $default_widget_title = '';

	/**
	 * Shortcode name for this widget.
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
		$this->widget_name          = esc_html__( '<%= widgetname %>', '<%= slug %>' );
		$this->default_widget_title = esc_html__( '<%= widgetname %>', '<%= slug %>' );

		parent::__construct(
			$this->widget_slug,
			$this->widget_name,
			array(
				'classname'   => $this->widget_slug,
				'description' => esc_html__( 'A widget boilerplate description.', '<%= slug %>' ),
			)
		);

		add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
		add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
		add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
		add_shortcode( self::$shortcode, array( __CLASS__, 'get_widget' ) );
	}


	/**
	 * Delete this widget's cache.
	 *
	 * Note: Could also delete any transients, e.g:
	 *
	 *     delete_transient( 'some-transient-generated-by-this-widget' );
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
		echo self::get_widget( array(
			'before_widget' => $args['before_widget'],
			'after_widget'  => $args['after_widget'],
			'before_title'  => $args['before_title'],
			'after_title'   => $args['after_title'],
			'title'         => $instance['title'],
			'text'          => $instance['text'],
		) );
	}


	/**
	 * Return the widget/shortcode output.
	 *
	 * @since  <%= version %>
	 *
	 * @param  array $atts  Array of widget/shortcode attributes/args.
	 * @return string       Widget output.
	 */
	public static function get_widget( $atts ) {
		$widget = '';

		// Set up default values for attributes.
		$atts = shortcode_atts(
			array(
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '',
				'after_title'   => '',
				'title'         => '',
				'text'          => '',
			),
			(array) $atts,
			self::$shortcode
		);

		// Before widget hook.
		$widget .= $atts['before_widget'];

		// Title.
		$widget .= ( $atts['title'] ) ? $atts['before_title'] . esc_html( $atts['title'] ) . $atts['after_title'] : '';

		$widget .= wpautop( wp_kses_post( $atts['text'] ) );

		// After widget hook.
		$widget .= $atts['after_widget'];

		return $widget;
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

		// Sanitize title before saving to database.
		$instance['title'] = sanitize_text_field( $new_instance['title'] );

		// Sanitize text before saving to database.
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = force_balance_tags( $new_instance['text'] );
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
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
		$instance = wp_parse_args( (array) $instance,
			array(
				'title' => $this->default_widget_title,
				'text'  => '',
			)
		); ?>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', '<%= slug %>' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_html( $instance['title'] ); ?>" placeholder="optional" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php esc_html_e( 'Text:', '<%= slug %>' ); ?></label>
		<textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea></p>
		<p class="description"><?php esc_html_e( 'Basic HTML tags are allowed.', '<%= slug %>' ); ?></p>

		<?php
	}
}

/**
 * Register this widget with WordPress.
 *
 * Can also move this function to the parent plugin.
 *
 * @since  <%= version %>
 */
function <%= widgetregister %>() {
	register_widget( '<%= classname %>' );
}
add_action( 'widgets_init', '<%= widgetregister %>' );
