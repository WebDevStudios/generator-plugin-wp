<?php
/**
* Plugin Name: Subgenerator Test Plugin
* Plugin URI:  http://webdevstudios.com
* Description: A radical new plugin for WordPress!
* Version:     0.1.0
* Author:      WebDevStudios
* Author URI:  http://webdevstudios.com
* Donate link: http://webdevstudios.com
* License:     GPLv2
* Text Domain: subgenerator-test-plugin
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2015 WebDevStudios (email : contact@webdevstudios.com)
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
class Subgenerator_Test_Plugin {

	const VERSION = '0.1.0';

	protected $basename = '';
	protected $url  = '';
	protected $path = '';

	/**
	 * Sets up our plugin
	 * @since  0.1.0
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
	 * @since 0.1.0
	 */
	function plugin_classes() {
		// Attach other plugin classes to the base plugin class.

		// $this->admin = new STP_Admin( $this );

	}

	/**
	 * Add hooks and filters
	 * @since 0.1.0
	 */
	public function hooks() {
		register_activation_hook( __FILE__, array( $this, '_activate' ) );
		register_deactivation_hook( __FILE__, array( $this, '_deactivate' ) );

		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Activate the plugin
	 * @since  0.1.0
	 */
	function _activate() {
		// Make sure any rewrite functionality has been loaded
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin
	 * Uninstall routines should be in uninstall.php
	 * @since  0.1.0
	 */
	function _deactivate() {

	}

	/**
	 * Init hooks
	 * @since  0.1.0
	 * @return null
	 */
	public function init() {
		if ( $this->check_requirements() ) {
			$locale = apply_filters( 'plugin_locale', get_locale(), 'subgenerator-test-plugin' );
			load_textdomain( 'subgenerator-test-plugin', WP_LANG_DIR . '/subgenerator-test-plugin/subgenerator-test-plugin-' . $locale . '.mo' );
			load_plugin_textdomain( 'subgenerator-test-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
	}

	/**
	 * Check that all plugin requirements are met
	 * @since  0.1.0
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
	 * @since  0.1.0
	 * @return boolean result of meets_requirements
	 */
	public function check_requirements() {
		if ( ! $this->meets_requirements() ) {
			// Display our error
			echo '<div id="message" class="error">';
			echo '<p>' . sprintf( __( 'Subgenerator Test Plugin is missing requirements and has been <a href="%s">deactivated</a>. Please make sure all requirements are available.', 'subgenerator-test-plugin' ), admin_url( 'plugins.php' ) ) . '</p>';
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
	 * @since  0.1.0
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
$GLOBALS['Subgenerator_Test_Plugin'] = new Subgenerator_Test_Plugin();

/**
 * Grab the $Subgenerator_Test_Plugin object and return it
 */
function subgenerator_test_plugin() {
	global $Subgenerator_Test_Plugin;
	return $Subgenerator_Test_Plugin;
}
