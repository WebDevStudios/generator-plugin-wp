<?php // @codingStandardsIgnoreLine
/**
 * <%= pluginname %> Page Builder Tests.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
 */
class <%= classname %>_Test extends WP_UnitTestCase { // @codingStandardsIgnoreLine

	/**
	 * Test if our class exists.
	 *
	 * @since  <%= version %>
	 */
	public function test_class_exists() {
		$this->assertTrue( class_exists( '<%= classname %>' ) );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since  <%= version %>
	 */
	public function test_class_access() {
		$this->assertInstanceOf( '<%= classname %>', <%= rc.prefix %>()-><%= nameslug %> ); // @codingStandardsIgnoreLine
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
