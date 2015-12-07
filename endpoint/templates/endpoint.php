<?php
/**
 * <%= includename %>
 * @version <%= version %>
 * @package <%= pluginname %>
 */

if ( class_exists( 'WP_REST_Controller' ) ) {
	class <%= classname %> extends WP_REST_Controller {
		/**
		 * Parent plugin class
		 *
		 * @var   class
		 * @since <%= version %>
		 */
		protected $plugin = null;

		/**
		 * Constructor
		 *
		 * @since  <%= version %>
		 * @return void
		 */
		public function __construct( $plugin ) {
			parent::__construct();
			$this->plugin = $plugin;
		}

		/**
     * Register the routes for the objects of the controller.
     *
     * @since  <%= version %>
		 * @return void
     */
		public function register_routes() {
			$version = '1';
			$namespace = '<%= pluginslug %>/v' . $version;
			$base = '<%= nameslug %>';

			/* register_rest_route( $namespace, '/' . $base, array(
				array(
					'methods' => WP_REST_Server::READABLE,
					'callback' => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permission_check' ),
					'args' => array(),
				)
			) );

			register_rest_route( $namespace, '/' . $base . '/(?P<id>[\d]+)', array(
				array(
					'methods'         => WP_REST_Server::READABLE,
          'callback'        => array( $this, 'get_item' ),
          'permission_callback' => array( $this, 'get_item_permissions_check' ),
          'args'            => array(
              'context'          => array(
                  'default'      => 'view',
              ),
          ),
        ),
        array(
          'methods'         => WP_REST_Server::EDITABLE,
          'callback'        => array( $this, 'update_item' ),
          'permission_callback' => array( $this, 'update_item_permissions_check' ),
          'args'            => $this->get_endpoint_args_for_item_schema( false ),
        ),
        array(
          'methods'  => WP_REST_Server::DELETABLE,
          'callback' => array( $this, 'delete_item' ),
          'permission_callback' => array( $this, 'delete_item_permissions_check' ),
          'args'     => array(
            'force'    => array(
              'default'      => false,
            ),
          ),
        ),
	    ) );

	    register_rest_route( $namespace, '/' . $base . '/schema', array(
	      'methods'         => WP_REST_Server::READABLE,
	      'callback'        => array( $this, 'get_public_item_schema' ),
	    ) ); */
		}
	}
}
