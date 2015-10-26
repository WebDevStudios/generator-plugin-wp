<?php

class BaseTest extends WP_UnitTestCase {

	function test_sample() {
		// replace this with some actual testing code
		$this->assertTrue( true );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'Subgenerator_Test_Plugin') );
	}
	
	function test_get_instance() {
		$this->assertTrue( subgenerator_test_plugin() instanceof Subgenerator_Test_Plugin );
	}
}
