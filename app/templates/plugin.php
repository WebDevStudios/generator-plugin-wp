<?php

namespace <%= namespace %>\<%= mainclassname %>;

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
 * @link    <%= homepage %>
 *
 * @package <%= mainclassname %>
 * @version <%= version %>
 *
 * Built using generator-plugin-wp (https://github.com/WebDevStudios/generator-plugin-wp)
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

<% if ( autoloader == 'Basic' ) { %>
/**
 * Autoloads files with classes when needed.
 *
 * @since  <%= version %>
 * @param  string $class_name Name of the class being requested.
 */
function <%= prefix %>_autoload_classes( $class_name ) {

	// If our class doesn't have our prefix, don't load it.
	if ( 0 !== strpos( $class_name, '<%= classprefix %>' ) ) {
		return;
	}

	// Set up our filename.
	$filename = strtolower( str_replace( '_', '-', substr( $class_name, strlen( '<%= classprefix %>' ) ) ) );

	// Include our file.
	<%= classname %>::include_file( 'includes/class-' . $filename );
}
spl_autoload_register( '<%= prefix %>_autoload_classes' );
<% } else if ( autoloader == 'Composer' && php52 ) { %>
// Use composer autoload with PHP 5.2 compatibility.
require 'vendor/autoload_52.php';
<% } else if ( autoloader == 'Composer' ) { %>
// Use composer autoload.
require 'vendor/autoload.php';
<% } else if ( autoloader == 'Namespace' ) { %>

	function <%= prefix %>_autoload_classes( $class_name ) {

		if ( false === strpos( $class_name, 'WDS\Cambium_Networks' ) ) {
			return;
		}

		// Break everything into parts.
		$class_array = explode( '\\', $class_name );

		// Build the filename from the last item in the array.
		$filename = strtolower( str_ireplace(
			array( 'WDSCN_', '_' ),
			array( '', '-' ),
			end( $class_array )
		) );

		/*
		 * Removes WDS\Cambium_Networks from the namespace and removes the \<classname> from
		 * the end of the namespace. Thus, allowing us to determine what folder structure the
		 * class resides in.
		 */
		$new_dir = array_slice( $class_array, 2, count( $class_array ) - 3 );

		// Glue the pieces back together.
		$new_dir = implode( '/', array_map( 'strtolower', $new_dir ) );

		// Build the directory.
		$new_dir = trailingslashit( $new_dir ) . 'class-' . $filename;

		// Require CPT Core or Taxonomy Core if we're trying to load one of those namespaces.
		if ( 0 === stripos( $new_dir, 'cpt/' ) ) {
			require_once dirname( __FILE__ ) . '/vendor/cpt-core/CPT_Core.php';
		} elseif ( 0 === stripos( $new_dir, 'taxonomy/' ) ) {
			require_once dirname( __FILE__ ) . '/vendor/taxonomy-core/Taxonomy_Core.php';
		}

		WDS_Cambium_Networks::include_file( 'includes/' . $new_dir );
	}
	spl_autoload_register( '\WDS\Cambium_Networks\wds_autoload_classes' );

<% } else { %>
// Include additional php files here.
// require 'includes/something.php';
<% } %>
/**
 * Main initiation class.
 *
 * @since  <%= version %>
 */
final class <%= classname %> {

	/**
	 * Current version.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	const VERSION = '<%= version %>';

	/**
	 * URL of plugin directory.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $url = '';

	/**
	 * Path of plugin directory.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $path = '';

	/**
	 * Plugin basename.
	 *
	 * @var    string
	 * @since  <%= version %>
	 */
	protected $basename = '';

	/**
	 * Detailed activation error messages.
	 *
	 * @var    array
	 * @since  <%= version %>
	 */
	protected $activation_errors = array();

	/**
	 * Singleton instance of plugin.
	 *
	 * @var    <%= classname %>
	 * @since  <%= version %>
	 */
	protected static $single_instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @since   <%= version %>
	 * @return  <%= classname %> A single instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$single_instance ) {
			self::$single_instance = new self();
		}

		return self::$single_instance;
	}

	/**
	 * Sets up our plugin.
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
	 */
	public function plugin_classes() {
		// $this->plugin_class = new <%= classprefix %>Plugin_Class( $this );

	} // END OF PLUGIN CLASSES FUNCTION

	/**
	 * Add hooks and filters.
	 * Priority needs to be
	 * < 10 for CPT_Core,
	 * < 5 for Taxonomy_Core,
	 * and 0 for Widgets because widgets_init runs at init priority 1.
	 *
	 * @since  <%= version %>
	 */
	public function hooks() {
		add_action( 'init', array( $this, 'init' ), 0 );
	}

	/**
	 * Activate the plugin.
	 *
	 * @since  <%= version %>
	 */
	public function _activate() {
		// Bail early if requirements aren't met.
		if ( ! $this->check_requirements() ) {
			return;
		}

		// Make sure any rewrite functionality has been loaded.
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin.
	 * Uninstall routines should be in uninstall.php.
	 *
	 * @since  <%= version %>
	 */
	public function _deactivate() {
		// Add deactivation cleanup functionality here.
	}

	/**
	 * Init hooks
	 *
	 * @since  <%= version %>
	 */
	public function init() {

		// Bail early if requirements aren't met.
		if ( ! $this->check_requirements() ) {
			return;
		}

		// Load translated strings for plugin.
		load_plugin_textdomain( '<%= slug %>', false, dirname( $this->basename ) . '/languages/' );

		// Initialize plugin classes.
		$this->plugin_classes();
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 *
	 * @since  <%= version %>
	 *
	 * @return boolean True if requirements met, false if not.
	 */
	public function check_requirements() {

		// Bail early if plugin meets requirements.
		if ( $this->meets_requirements() ) {
			return true;
		}

		// Add a dashboard notice.
		add_action( 'all_admin_notices', array( $this, 'requirements_not_met_notice' ) );

		// Deactivate our plugin.
		add_action( 'admin_init', array( $this, 'deactivate_me' ) );

		// Didn't meet the requirements.
		return false;
	}

	/**
	 * Deactivates this plugin, hook this function on admin_init.
	 *
	 * @since  <%= version %>
	 */
	public function deactivate_me() {

		// We do a check for deactivate_plugins before calling it, to protect
		// any developers from accidentally calling it too early and breaking things.
		if ( function_exists( 'deactivate_plugins' ) ) {
			deactivate_plugins( $this->basename );
		}
	}

	/**
	 * Check that all plugin requirements are met.
	 *
	 * @since  <%= version %>
	 *
	 * @return boolean True if requirements are met.
	 */
	public function meets_requirements() {

		// Do checks for required classes / functions or similar.
		// Add detailed messages to $this->activation_errors array.
		return true;
	}

	/**
	 * Adds a notice to the dashboard if the plugin requirements are not met.
	 *
	 * @since  <%= version %>
	 */
	public function requirements_not_met_notice() {

		// Compile default message.
		$default_message = sprintf( __( '<%= name %> is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', '<%= slug %>' ), admin_url( 'plugins.php' ) );

		// Default details to null.
		$details = null;

		// Add details if any exist.
		if ( $this->activation_errors && is_array( $this->activation_errors ) ) {
			$details = '<small>' . implode( '</small><br /><small>', $this->activation_errors ) . '</small>';
		}

		// Output errors.
		?>
		<div id="message" class="error">
			<p><?php echo wp_kses_post( $default_message ); ?></p>
			<?php echo wp_kses_post( $details ); ?>
		</div>
		<?php
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  <%= version %>
	 *
	 * @param  string $field Field to get.
	 * @throws Exception     Throws an exception if the field is invalid.
	 * @return mixed         Value of the field.
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
	 * Include a file from the includes directory.
	 *
	 * @since  <%= version %>
	 *
	 * @param  string $filename Name of the file to be included.
	 * @return boolean          Result of include call.
	 */
	public static function include_file( $filename ) {
		$file = self::dir( $filename . '.php' );
		if ( file_exists( $file ) ) {
			return include_once( $file );
		}
		return false;
	}

	/**
	 * This plugin's directory.
	 *
	 * @since  <%= version %>
	 *
	 * @param  string $path (optional) appended path.
	 * @return string       Directory and path.
	 */
	public static function dir( $path = '' ) {
		static $dir;
		$dir = $dir ? $dir : trailingslashit( dirname( __FILE__ ) );
		return $dir . $path;
	}

	/**
	 * This plugin's url.
	 *
	 * @since  <%= version %>
	 *
	 * @param  string $path (optional) appended path.
	 * @return string       URL and path.
	 */
	public static function url( $path = '' ) {
		static $url;
		$url = $url ? $url : trailingslashit( plugin_dir_url( __FILE__ ) );
		return $url . $path;
	}<% } %>
}

/**
 * Grab the <%= classname %> object and return it.
 * Wrapper for <%= classname %>::get_instance().
 *
 * @since  <%= version %>
 * @return <%= classname %>  Singleton instance of plugin class.
 */
function <%= prefix %>() {
	return <%= classname %>::get_instance();
}

// Kick it off.
add_action( 'plugins_loaded', array( <%= prefix %>(), 'hooks' ) );

// Activation and deactivation.
register_activation_hook( __FILE__, array( <%= prefix %>(), '_activate' ) );
register_deactivation_hook( __FILE__, array( <%= prefix %>(), '_deactivate' ) );
