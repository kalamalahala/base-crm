<?php /** @noinspection PhpUnusedPrivateMethodInspection */

	/**
	 * BaseCRM REST API
	 */

	namespace BaseCRM\Rest;

	use BaseCRM;
    use BaseCRM\ServerSide\Appointment;
	use BaseCRM\ServerSide\GFAPIHandler;
	use BaseCRM\ServerSide\RestInterface;
	use BaseCRM\ServerSide\Lead;
	use JetBrains\PhpStorm\NoReturn;
	use WP_REST_Request;
	use WP_REST_Response;

	class RestHandler implements RestInterface {
		public function __construct() {
			// WordPress REST API
			add_action( 'rest_api_init', array( $this, 'makeRoutes' ) );
		}

		/**
		 * Add all routes to this function
		 * @return void
		 */
		public function makeRoutes(): void {
			#region Old methods
			register_rest_route( 'basecrm/v1', '/leads/vtp', array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'insert_lead_from_vtp' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );
			// update lead id field 'is_client' to 1
			register_rest_route( 'basecrm/v1', '/to_client/(?P<id>\d+)', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'to_client' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );
			#endregion

			# GET: /appointments getAppointments()
			# GET: /appointment/{id} getAppointment()
			# GET: /agent/{id}/appointments getAgentAppointments()
			# POST: /appointment insertAppointment()

			#region Appointment methods
			register_rest_route( 'basecrm/v1', '/appointments', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'getAppointments' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );

			register_rest_route( 'basecrm/v1', '/appointment/(?P<id>\d+)', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'getAppointment' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );

			register_rest_route( 'basecrm/v1', '/agent/(?P<id>\d+)/appointments', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'getAgentAppointments' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );

			register_rest_route( 'basecrm/v1', '/appointment/new', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'insertAppointment' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );
			#endregion

			#region Form HTML components
			register_rest_route( 'basecrm/v1', '/calendar-form', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'getCalendarForm' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );

			register_rest_route( 'basecrm/v1', '/get_calendar_invite_form', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'getCalendarInviteForm' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );

			register_rest_route( 'basecrm/v1', '/client', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'getClientDetails' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );
			#endregion

			#region Error Logging endpoints
			register_rest_route( 'basecrm/v1', '/print_log', array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'printLog' ),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			) );

			register_rest_route('basecrm/v1', '/clear_log', array(
				'methods' => 'GET',
				'callback' => array($this, 'clearLog'),
				'permission_callback' => function () {
					return $this->authorizeRest();
				}
			));
			#endregion

            #region Lead Methods
            register_rest_route( 'basecrm/v1', '/lead/(?P<id>\d+)', array(
                'methods'             => 'GET',
                'callback'            => array( $this, 'getLead' ),
                'permission_callback' => function () {
                    return $this->authorizeRest();
                }
            ));
            #endregion
		}


		#region Utility functions

		/**
		 * Checks if the request is coming from a valid source
		 * @return bool
		 */
		public function authorizeRest(): bool {
			$site          = get_site_url();
			$valid_sources = [
				'thejohnson.group',
				'migrate-test.local',
				'storm.local'
			];

			foreach ( $valid_sources as $source ) {
				if ( str_contains( $site, $source ) ) {
					return true;
				}
			}

			return false;
		}

		public function printLog(): void {
			error_log('called');
			$path = ABSPATH . 'wp-content/debug.log';
			// echo contents of file
			$log = file_get_contents( $path );

			// split log items by new line, and group matching timestamps to array
			$log = preg_split( '/\n/', $log );

			echo $this->json_response( $log );
		}

		public function clearLog(): void {
			$path = ABSPATH . 'wp-content/debug.log';
			// echo contents of file
			$log = file_put_contents( $path, '' );

			echo $this->json_response( $log );
		}

		public function json_response( $data, $status = 200 ): bool|string {
			header( "Content-Type: application/json" );
			header( "HTTP/1.1 " . $status . " " . $this->requestStatus( $status ) );

			return json_encode( $data );
		}

		public function requestStatus( int $code ): string {
			$status = array(
				200 => 'OK',
				400 => 'Bad Request',
				401 => 'Unauthorized',
				403 => 'Forbidden',
				404 => 'Not Found',
				405 => 'Method Not Allowed',
				500 => 'Internal Server Error',
				501 => 'Not Implemented',
			);

			return ( $status[ $code ] ) ?: $status[500];
		}
		#endregion


		#region Appointment method functions
		#[NoReturn] public function getAppointments( $params = [] ): void {
			$appointments = new Appointment();
			echo $this->json_response( $appointments->getAppointments( $params ) );
			die();
		}


		public function getAppointment( $params = [] ): void {
			$id = $params['id'] ?? null;
			if ( ! $id ) {
				echo 'no id';
			}

			$appointment = new Appointment();
			$appointment->getAppt( $id );
		}

		#[NoReturn] public function getAgentAppointments( $params = [] ): void {
			$id = $params['id'] ?? null;
			if ( ! $id ) {
				echo 'no id';
			}

			$appointment = new Appointment();
			$results     = $appointment->getAgentAppts( $id );

			echo $this->json_response( $results, ( count( $results ) > 0 ) ? 200 : 404 );
			die();
		}

		#endregion

		public function to_client( $id ): void {
			$id = $id['id'] ?? null;
			if ( ! $id ) {
				echo 'no id';

			}

			$lead = new Lead();
			$lead->toClient( $id );

			echo "Success: $id";

		}

		public function get( $endpoint, $params = [] ) {
			// ...
		}

		public function post( $endpoint, $params = [] ) {
			// ...
		}

		public function put( $endpoint, $params = [] ) {
			// ...
		}

		public function delete( $endpoint, $params = [] ) {
			// ...
		}

		public function patch( $endpoint, $params = [] ) {
			// ...
		}

		public function insert_lead_from_vtp(): bool|string {

			error_log( print_r( $_POST, true ) );

			$form_id   = $_POST['form_id'] ?? null;
			$form_data = false;

			if ( $form_id == 2 ) {
				$form_data = array(
					'first_name'  => $_POST['1_3'] ?? null,
					'last_name'   => $_POST['1_6'] ?? null,
					'email'       => $_POST['4'] ?? null,
					'phone'       => $_POST['3'] ?? null,
					'lead_source' => 'VTP',
					'lead_type'   => 'other',
					'lead-notes'  => json_encode( $_POST )
				);
			} else if ( ! $form_id ) {
				$form_data = array(
					'first_name'  => $_POST['first_name'] ?? null,
					'last_name'   => $_POST['last_name'] ?? null,
					'email'       => $_POST['email'] ?? null,
					'phone'       => $_POST['phone'] ?? null,
					'lead_source' => 'TJG WCN',
					'lead_type'   => 'other',
					'lead-notes'  => json_encode( $_POST )
				);
			}

			if ( ! $form_data ) {
				return false;
			}

			$lead = new Lead();
			$lead->processPost( $form_data );

			if ( $lead->id ) {
				return $this->json_response( array(
					'status'  => 'success',
					'message' => 'Lead created successfully',
					'id'      => $lead->id
				) );
			} else {
				return $this->json_response( array(
					'status'  => 'error',
					'message' => 'Lead not created'
				), 400 );
			}


		}

		public function getCalendarForm(): void {
            echo 0;
            /** DEPRECATED
			$agent_id         = $_GET['agent_id'] ?? get_current_user_id();
			$lead_id          = $_GET['lead_id'] ?? null;
			$appointment_type = $_GET['appointment_type'] ?? 'Child Safe Kit - Referral';

			if ( ! $lead_id ) {
				$form = "No lead id provided";
                echo $this->json_response( $form, 400 );
                die();
			}

            $lead = new Lead( $lead_id );
            $agent_name = BaseCRM::agent_name( $agent_id );

            $default_content = <<<HTML
Hi {$lead->first_name}, included are the details for your appointment with your agent {$agent_name}:

<strong>Date &amp; Time:</strong> <span id="appointment-datetime">should quick edit</span>
<strong>Appointment Type:</strong> {$appointment_type}
<strong>Your Contact Number:</strong> {$lead->phone}

Regards,
<img class="alignnone wp-image-2276" src="https://thejohnson.group/wp-content/uploads/2021/02/BlackTextLogo.png" alt="" width="106" height="69" />
<span style="font-size: 10pt;">Email: <a href="info@thejohnson.group">info@thejohnson.group</a></span>
<span style="font-size: 10pt;">Phone: <a href="tel:+13863013703">(386) 301-3703</a></span>
<span style="font-size: 10pt;"><mark><strong>Note: This email is intended only for internal use. If you have received this email in error, please discard it and notify the admin. Thank you.</strong></mark></span>
HTML;

            $tinyMCE = BaseCRM::calendar_invite_editor_box('appointment_notes', $default_content,  array(
                'textarea_name' => 'appointment_notes',
                'textarea_rows' => 10,
                'media_buttons' => false,
                'teeny'         => true,
                'tinymce'       => array(
                    'toolbar1' => 'bold,italic,underline,link,unlink,undo,redo',
                    'toolbar2' => '',
                    'toolbar3' => '',
                ),
                'quicktags'     => false,
                'editor_css'    => '<style>#wp-appointment_notes-wrap{display:none;}</style>',
            ));


			$form = <<<FORM
    <div class="row">
        <div class="col">
            <label for="appointment_date" class="form-label w-100">Appointment Date & Time
                <input type="text" name="appointment_date" value="2021-09-01" id="calendar-datepicker" class="form-control">
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="appointment_notes" class="form-label w-100">Appointment Notes
                {$tinyMCE}
            </label>
        </div>
    </div>
    <div class="row">
    <div class="col">
            <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
            <button type="submit" id="calendar-invite-form-submit" class="btn btn-primary">Submit</button>
</div>
    </div>
            <input type="hidden" name="agent_id" value="$agent_id">
            <input type="hidden" name="lead_id" value="$lead_id">
            <input type="hidden" name="appointment_type" value="$appointment_type">
            <input type="hidden" name="lead_name" value="{$lead->first_name} {$lead->last_name}">
            <input type="hidden" name="agent_name" value="$agent_name">
FORM;

//			echo $this->json_response( $form );
            **/
		}

		public function getCalendarInviteForm(): void {
			$form_id = $_GET['form_id'] ?? 13;
			$lead_id = $_GET['lead_id'] ?? null;

			$html = do_shortcode( '[gravityform id="' . $form_id . '" title="false" description="false" ajax="true" field_values="lead_id=' . $lead_id . '"]' );
			echo $this->json_response( $html );
		}

		public function insertAppointment(): void {
			/**
			 * Params passed via GET
			 * appointment_date
			 * appointment_notes
			 * agent_id
			 * lead_id
			 * appointment_type
			 * appointment_time // IGNORE
			 * appointment_timezone
			 */

			$data = [
				'lead_id'            => $_GET['lead_id'] ?? null,
				'agent_id'           => $_GET['agent_id'] ?? null,
				'appointment_type'   => $_GET['appointment_type'] ?? null,
				'appointment_date'   => $_GET['appointment_date'] ?? null,
				'appointment_notes'  => $_GET['appointment_notes'] ?? null,
				'appointment_time'   => $_GET['appointment_date'] ?? null,
				'appointment_status' => 'Scheduled'
			];


			$errors = [];

			foreach ( $data as $item => $contents ) {
				if ( ! $item ) {
					$errors[] = $item;
				}
			}

			if ( $errors ) {
				echo $this->json_response( $errors, 400 );
			}

			$appointment = new Appointment();
			$success     = $appointment->createAppointment( $data );

			$lead_data = [
				'lead_id'          => $data['lead_id'],
				'lead_status'      => 'Appointment Scheduled',
				'lead_disposition' => 'Appointment Scheduled',
				'assigned_to'      => $data['agent_id'],
			];

			$lead = new Lead( $data['lead_id'] );
			$lead->createClient( $lead_data );

			$results = [
				'status'  => $success ? 'success' : 'error',
				'message' => $success ? 'Appointment created successfully' : 'Appointment not created',
				'code'    => $success ? 200 : 400,
			];

			echo $this->json_response( $results, $results['code'] );
		}

		public function getClientDetails( WP_REST_Request $request ): WP_REST_Response {
			// collect lead id from endpoint
			$lead_id = $request->get_param( 'lead_id' );
			if ( ! $lead_id ) {
				return new WP_REST_Response( 'No lead id provided', 400 );
			}

			$gfapi   = new GFAPIHandler();
			$results = $gfapi->getMatchingEntries( $lead_id );

			$response = new WP_REST_Response();
			$response->set_data( $results );
			$response->set_status( 200 );

			return $response;
		}

		private function getLeads(): void {
			// ...
			echo $this->json_response( 'getLeads' );
		}

		public function getLead(): void {
			// ...
			echo $this->json_response( 'getLead' );
		}
	}
