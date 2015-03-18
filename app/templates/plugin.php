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

// User composer autoload.
require 'vendor/autoload_52.php';

/**
 * Main initiation class
 */
class <%= classname %> {

	const VERSION = '<%= version %>';

	protected $basename = '';
	protected $url  = '';
	protected $path = '';

	/**
	 * Sets up our plugin
	 * @since  <%= version %>
	 */
	public function __construct() {
		$this->basename = plugin_basename( __FILE__ );
		$this->url      = plugin_dir_url( __FILE__ );
		$this->path     = plugin_dir_path( __FILE__ );

		$this->plugin_classes();
		$this->hooks();
	}

	/**
	 * Attach other plugin classes to the base plugin class.
	 * @since <%= version %>
	 */
	function plugin_classes() {
		// Attach other plugin classes to the base plugin class.
		// $this->admin = new <%= classname %>_Admin( $this );
	}

	/**
	 * Add hooks and filters
	 * @since <%= version %>
	 */
	public function hooks() {
		register_activation_hook( __FILE__, array( $this, '_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, '_deactivate' ) );

		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Activate the plugin
	 * @since  <%= version %>
	 */
	function _activate() {
		// Make sure any rewrite functionality has been loaded
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin
	 * Uninstall routines should be in uninstall.php
	 * @since  <%= version %>
	 */
	function _deactivate() {

	}

	/**
	 * Init hooks
	 * @since  <%= version %>
	 * @return null
	 */
	public function init() {
		if ( $this->check_requirements() ) {
			$locale = apply_filters( 'plugin_locale', get_locale(), '<%= slug %>' );
			load_textdomain( '<%= slug %>', WP_LANG_DIR . '/<%= slug %>/<%= slug %>-' . $locale . '.mo' );
			load_plugin_textdomain( '<%= slug %>', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
	}

	/**
	 * Check that all plugin requirements are met
	 * @since  <%= version %>
	 * @return boolean
	 */
	public static function meets_requirements() {
		// Do checks for required classes / functions
		// function_exists('') & class_exists('')

		// We have met all requirements
		return true;
	}

	/**
	 * Check if the plugin meets requirements and
	 * disable it if they are not present.
	 * @since  <%= version %>
	 * @return boolean result of meets_requirements
	 */
	public function check_requirements() {
		if ( ! $this->meets_requirements() ) {
			// Display our error
			echo '<div id="message" class="error">';
			echo '<p>' . sprintf( __( '<%= name %> is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', '<%= slug %>' ), admin_url( 'plugins.php' ) ) . '</p>';
			echo '</div>';
			// Deactivate our plugin
			deactivate_plugins( $this->basename );

			return false;
		}

		return true;
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  <%= version %>
	 * @param string $field
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
				throw new Exception( 'Invalid '. __CLASS__ .' property: ' . $field );
		}
	}

}

// init our class
$GLOBALS['<%= classname %>'] = new <%= classname %>();

/**
 * Grab the $<%= classname %> object and return it
 */
function <%= prefix %>() {
	global $<%= classname %>;
	return $<%= classname %>;
}
