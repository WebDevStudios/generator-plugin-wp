<?php
/**
 * <%= nameslug %> Tests.
 *
 * @since   <%= version %>
 * @package <%= mainclassname %>
 */
class <%= classname %>_Test extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();

		global $wp_rest_server;
		$this->server = $wp_rest_server = new WP_REST_Server;
		do_action( 'rest_api_init' );

		$this->subscriber = $this->factory->user->create( array( 'role' => 'subscriber' ) );
		$this->administrator = $this->factory->user->create( array( 'role' => 'administrator' ) );
	}

	/**
	 * Test if our class exists.
	 *
	 * @since  <%= version %>
	 */
	function test_class_exists() {
		$this->assertTrue( class_exists( '<%= classname %>') );
	}

	/**
	 * Test that we can access our class through our helper function.
	 *
	 * @since  <%= version %>
	 */
	function test_class_access() {
		$this->assertInstanceOf( '<%= classname %>', <%= rc.prefix %>()-><%= nameslug %> );
	}

	/**
	 * Replace this with some actual testing code.
	 *
	 * @since  <%= version %>
	 */
	function test_sample() {
		/*
		wp_set_current_user( $this->administrator );

		$request = new WP_REST_Request( 'POST', '/endpoint' );
		$request->set_param( 'key', 'value' );
		$response = $this->server->dispatch( $request );
		$this->assertResponseStatus( 200, $response );
		*/
		$this->assertTrue( true );
	}

	/**
	 * Test response status for API request.
	 *
	 * @since  <%= version %>
	 */
	protected function assertResponseStatus( $status, $response, $error_code = '', $debug = false ) {
         if ( $debug ) {
             error_log( '$response->get_data(): '. print_r( $response->get_data(), true ) );
         }
         $this->assertEquals( $status, $response->get_status() );

         if ( $error_code ) {
             $this->assertResponseErrorCode( $error_code, $response );
         }
     }

	 /**
 	 * Test response error code for API request.
 	 *
 	 * @since  <%= version %>
 	 */
     protected function assertResponseErrorCode( $error_code, $response ) {
         $response_data = $response->get_data();
         $this->assertEquals( $error_code, $response_data['code'] );
     }

	 /**
 	 * Test response data for API request.
 	 *
 	 * @since  <%= version %>
 	 */
     protected function assertResponseData( $data, $response ) {
         $response_data = $response->get_data();
         $tested_data = array();
         foreach( $data as $key => $value ) {
             if ( isset( $response_data[ $key ] ) ) {
                 $tested_data[ $key ] = $response_data[ $key ];
             } else {
                 $tested_data[ $key ] = null;
             }
         }
         $this->assertEquals( $data, $tested_data );
     }

	/**
	* Turn off Rest server.
	*
	* @since  <%= version %>
	*/
   public function tearDown() {
	   parent::tearDown();

	   global $wp_rest_server;
	   $wp_rest_server = null;
   }
}
