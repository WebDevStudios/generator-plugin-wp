<?php
/**
 * <%= mainclassname %>
 *
 * @since <%= version %>
 * @package <%= mainclassname %>
 */
class <%= mainclassname %>_Test extends WP_UnitTestCase {

	function test_class_exists() {
		$this->assertTrue( class_exists( '<%= classname %>') );
	}

	function test_get_instance() {
		$this->assertTrue( <%= prefix %>() instanceof <%= classname %> );
	}

	function test_sample() {
		// Replace this with some actual testing code.
		$this->assertTrue( true );
	}
}
