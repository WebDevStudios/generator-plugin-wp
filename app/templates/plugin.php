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
require 'vendor/autoload.php';

/**
 * Main initiation class
 */
class <%= classname %> {

	const VERSION = '<%= version %>';

	protected static $url  = '';
	protected static $path = '';

	/**
	 * Sets up our plugin
	 * @since  0.1.0
	 */
	public function __construct() {
		$this->hooks();
	}

	public function hooks() {
		register_activation_hook( __FILE__, array( $this, '_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, '_deactivate' ) );

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'cmb2_init', array( $this, 'fields' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	/**
	 * Activate the plugin
	 */
	function _activate() {
		// Make sure any rewrite functionality has been loaded
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin
	 * Uninstall routines should be in uninstall.php
	 */
	function _deactivate() {

	}

	/**
	 * Init hooks
	 * @since  0.1.0
	 * @return null
	 */
	public function init() {
		$locale = apply_filters( 'plugin_locale', get_locale(), '<%= slug %>' );
		load_textdomain( '<%= slug %>', WP_LANG_DIR . '/<%= slug %>/<%= slug %>-' . $locale . '.mo' );
		load_plugin_textdomain( '<%= slug %>', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Hooks for the Admin
	 * @since  0.1.0
	 * @return null
	 */
	public function admin_init() {
	}

	/**
	 * Magic getter for our object.
	 *
	 * @param string $field
	 *
	 * @throws Exception Throws an exception if the field is invalid.
	 *
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'version':
				return self::$field;
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
