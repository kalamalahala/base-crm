<?php

	namespace BaseCRM\ServerSide;

	$base_crm_path = plugin_dir_path( dirname( __FILE__ ) ) . 'src/';

	$dependencies = [
		'Lead.php',
		'Shortcodes.php',
		'AjaxHandler.php',
		'Appointment.php',
		'RestHandler.php',
		'GFAPIHandler.php',
		'BaseEmail.php',
	];

	/**
	 * Load dependencies
	 */
	foreach ( $dependencies as $file ) {
		require_once $base_crm_path . $file;
	}

	interface LeadInterface {
		public function getLead( $id ): Lead;

		public function getLeads();

		public function createLead( $data );

		public function updateLead( $id, $data );

		public function deleteLead( $id );
	}

	interface AppointmentInterface {
		public function getAppointment( $id ): Appointment;

		public function getAppointments( $params = [] );

		public function createAppointment( $data );

		public function updateAppointment( $id, $data );

		public function deleteAppointment( $id );
	}

	interface AjaxInterface {
		public function __construct();

		public function ajaxHandler();

		public function json_response( $data, $status = 200 );
	}

	/**
	 * WP REST API
	 *
	 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/
	 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#arguments
	 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#methods
	 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#routes
	 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#permissions-callback
	 * @see https://developer.wordpress.org/rest-api/extending-the-rest-api/adding-custom-endpoints/#schema
	 */
	interface RestInterface {
		public function __construct();

		public function get( $endpoint, $params = [] );

		public function post( $endpoint, $params = [] );

		public function patch( $endpoint, $params = [] );

		public function put( $endpoint, $params = [] );

		public function delete( $endpoint, $params = [] );
	}
