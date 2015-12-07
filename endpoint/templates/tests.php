<?php

class <%= classname %>_Test extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( '<%= classname %>') );
	}

	function test_class_access() {
		$this->assertTrue( <%= rc.prefix %>()-><%= nameslug %> instanceof <%= classname %> );
	}
}
