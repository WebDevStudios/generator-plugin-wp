<?php
/**
 * <%= widgetname %> Tests.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
 */

/**
 * <%= widgetname %> Tests.
 *
 * @since   <%= version %>
 */
class <%= classname %>_Test extends WP_UnitTestCase {

	/**
	 * Test if our class exists.
	 *
	 * @since  <%= version %>
	 */
	public function test_class_exists() {
		$this->assertTrue( class_exists( '<%= classname %>' ) );
	}

	/**
	 * Replace this with some actual testing code.
	 *
	 * @since  <%= version %>
	 */
	public function test_sample() {
		$this->assertTrue( true );
	}
}
