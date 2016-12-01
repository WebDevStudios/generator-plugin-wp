<?php
/**
 * Plugin Name: <%= name %>
 * Plugin URI:  <%= homepage %>
 * Description: <%= description %>
 * Version:     <%= version %>
 * Author:      <%= author %>
 * Author URI:  <%= authorurl %>
 * Donate link: <%= homepage %>
 * License:     <%= license %>
 * Text Domain: <%= slug %>
 * Domain Path: /languages
 *
 * @link <%= homepage %>
 *
 * @package <%= name %>
 * @version <%= version %>
 */

/**
 * Copyright (c) <%= year %> <%= author %> (email : <%= authoremail %>)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using generator-plugin-wp
 */

<% if ( autoloader == 'Basic' ) { %>
/**
 * Autoloads files with classes when needed
 *
 * @since  <%= version %>
 * @param  string $class_name Name of the class being requested.
 * @return void
 */
function <%= prefix %>_autoload_classes( $class_name ) {
	if ( 0 !== strpos( $class_name, '<%= classprefix %>' ) ) {
		return;
	}

	$filename = strtolower( str_replace(
		'_', '-',
		substr( $class_name, strlen( '<%= classprefix %>' ) )
	) );

	<%= classname %>::include_file( 'includes/class-' . $filename );
}
spl_autoload_register( '<%= prefix %>_autoload_classes' );
<% } else if ( autoloader == 'Composer' ) { %>
// User composer autoload.
require 'vendor/autoload_52.php';
<% } else { %>
// Include additional php files here.
// require 'includes/admin.php';
<% } %>
/**
 * Main initiation class
 *
 * @since  <%= version %>
 */
final class <%= classname %> {

	/**
	 * Current version
	 *
	 * @var  string
	 * @since  <%= version %>
	 */
	const VERSION = '<%= version %>';

	/**
	 * URL of plugin directory
	 *
	 * @var string
	 * @since  <%= version %>
	 */
	protected $url = '';

	/**
	 * Path of plugin directory
	 *
	 * @var string
	 * @since  <%= version %>
	 */
	protected $path = '';

	/**
	 * Plugin basename
	 *
	 * @var string
	 * @since  <%= version %>
	 */
	protected $basename = '';

	/**
	 * Detailed activation error messages
	 *
	 * @var array
	 * @since  <%= version %>
	 */
	protected $activation_errors = array();

	/**
	 * Singleton instance of plugin
	 *
	 * @var <%= classname %>
	 * @since  <%= version %>
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since  <%= version %>
	 * @return <%= classname %> A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin
	 *
	 * @since  <%= version %>
	 */
	protected function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function plugin_classes() {
		// Attach other plugin classes to the base plugin class.
		// $this->plugin_class = new <%= classprefix %>Plugin_Class( $this );
	} // END OF PLUGIN CLASSES FUNCTION

	/**
	 * Add hooks and filters
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function hooks() {
		// Priority needs to be:
		// < 10 for CPT_Core,
		// < 5 for Taxonomy_Core,
		// 0 Widgets because widgets_init runs at init priority 1.
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Activate the plugin
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function _activate() {
		// Make sure any rewrite functionality has been loaded.
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin
	 * Uninstall routines should be in uninstall.php
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function _deactivate() {}

	/**
	 * Init hooks
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function init() {
		// bail early if requirements aren't met
		if ( ! $this->check_requirements() ) {
			return;
		}
		
		// load translated strings for plugin
		load_plugin_textdomain( '<%= slug %>', false, dirname( $this->basename ) . '/languages/' );

		// initialize plugin classes
		$this->plugin_classes();
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  <%= version %>
	 * @return boolean result of meets_requirements
	 */
	public function check_requirements() {
		// bail early if pluginmeets requirements
		if ( $this->meets_requirements() ) {
			return true;
		}

		// Add a dashboard notice.
		add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

		// Deactivate our plugin.
		add_action( 'admin_init', array( $this, 'deactivate_me' ) );

		return false;
	}

	/**
	 * Deactivates this plugin, hook this function on admin_init.
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function deactivate_me() {
		// We do a check for deactivate_plugins before calling it, to protect
		// any developers from accidentally calling it too early and breaking things.
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( $this->basename );
		}
	}

	/**
	 * Check that all plugin requirements are met
	 *
	 * @since  <%= version %>
	 * @return boolean True if requirements are met.
	 */
	public function meets_requirements() {
		// Do checks for required classes / functions
		// function_exists('') & class_exists('').
		// We have met all requirements.
		// Add detailed messages to $this->activation_errors array
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met
	 *
	 * @since  <%= version %>
	 * @return void
	 */
	public function requirements_not_met_notice() {
		// compile default message
		$default_message = sprintf( 
			__( '<%= name %> is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', '<%= slug %>' ), 
			admin_url( 'plugins.php' ) 
		);
		
		// default details to null
		$details = null;

		// add details if any exist
		if ( ! empty( $this->activation_errors ) && is_array( $this->activation_errors ) ) {
			$details = '<small>' . implode( '</small><br /><small>', $this->activation_errors ) . '</small>';
		}

		// output errors
		?>
		<div id="message" class="error">
			<p><?php echo $default_message; ?></p>
			<?php echo $details; ?>
		</div>
		<?php
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  <%= version %>
	 * @param string $field Field to get.
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return self::VERSION;
			case 'basename':
			case 'url':
			case 'path':
				return $this->$field;
			default:
				throw new Exception( 'Invalid ' . __CLASS__ . ' property: ' . $field );
		}
	}<% if ( autoloader == 'Basic' ) { %>

	/**
	 * Include a file from the includes directory
	 *
	 * @since  <%= version %>
	 * @param  string $filename Name of the file to be included.
	 * @return bool   Result of include call.
	 */
	public static function include_file( $filename ) {
		$file = self::dir( $filename . '.php' );
		if ( file_exists( $file ) ) {
			return include_once( $file );
		}
		return false;
	}

	/**
	 * This plugin's directory
	 *
	 * @since  <%= version %>
	 * @param  string $path (optional) appended path.
	 * @return string       Directory and path
	 */
	public static function dir( $path = '' ) {
		static $dir;
		$dir = $dir ? $dir : trailingslashit( dirname( __FILE__ ) );
		return $dir . $path;
	}

	/**
	 * This plugin's url
	 *
	 * @since  <%= version %>
	 * @param  string $path (optional) appended path.
	 * @return string       URL and path
	 */
	public static function url( $path = '' ) {
		static $url;
		$url = $url ? $url : trailingslashit( plugin_dir_url( __FILE__ ) );
		return $url . $path;
	}<% } %>
}

/**
 * Grab the <%= classname %> object and return it.
 * Wrapper for <%= classname %>::get_instance()
 *
 * @since  <%= version %>
 * @return <%= classname %>  Singleton instance of plugin class.
 */
function <%= prefix %>() {
	return <%= classname %>::get_instance();
}

// Kick it off.
add_action( 'plugins_loaded', array( <%= prefix %>(), 'hooks' ) );

register_activation_hook( __FILE__, array( <%= prefix %>(), '_activate' ) );
register_deactivation_hook( __FILE__, array( <%= prefix %>(), '_deactivate' ) );
