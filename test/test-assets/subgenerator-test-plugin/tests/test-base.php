<?php
/**
 * Subgenerator_Test_Plugin.
 *
 * @since   0.0.0
 * @package Subgenerator_Test_Plugin
 */
class Subgenerator_Test_Plugin_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  0.0.0
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( 'Subgenerator_Test_Plugin') );
	}

	/**
	 * Test that our main helper function is an instance of our class.
	 *
	 * @since  0.0.0
	 */
	function test_get_instance() {
		$this->assertInstanceOf( subgenerator_test_plugin(), 'Subgenerator_Test_Plugin' );
	}

	/**
	 * Replace this with some actual testing code.
	 *
	 * @since  0.0.0
	 */
	function test_sample() {
		$this->assertTrue( true );
	}
}
