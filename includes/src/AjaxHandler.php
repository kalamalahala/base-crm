<?php /** @noinspection PhpUnused */

namespace BaseCRM\Ajax;

use BaseCRM;
use BaseCRM\ServerSide\AjaxInterface;
use BaseCRM\ServerSide\BaseEmail;
use BaseCRM\ServerSide\Lead;
use BaseCRM\ServerSide\Appointment;
use JetBrains\PhpStorm\NoReturn;

class AjaxHandler implements AjaxInterface
{

    public function __construct()
    {
        add_action('wp_ajax_base_crm_ajax', array($this, 'ajaxHandler'));
        add_action('wp_ajax_nopriv_base_crm_ajax', array($this, 'ajaxHandler'));
    }

    public function ajaxHandler(): void
    {
        // Check for nonce security
        if (!check_ajax_referer('base_crm_ajax_nonce', 'nonce', false)) {
            $this->json_response(array('error' => 'Invalid nonce'), 403);
        }

        // Route the request based on 'method' value
        $method = $_POST['method'] ?? $_GET['method'] ?? null;
        if (!$method) {
            $this->json_response(array('error' => 'Invalid method'), 400);
        }

        $defined_methods = get_class_methods($this);
        if (!in_array($method, $defined_methods)) {
            $this->json_response(array('error' => 'Method not found'), 404);
        } else {
            $this->$method();
        }
    }

    #[NoReturn] public function json_response($data, $status = 200): void
    {
        wp_send_json($data, $status);

        // ensure exit
        die();
    }

    #[NoReturn] public function base_email(): void
    {
        if (!isset($_POST['base_email'])) {
            $this->json_response(array('error' => 'Invalid request'), 400);
        }

        $lead = new Lead($_POST['data']['lead_id']);

        $to = "$lead->first_name $lead->last_name <{$_POST['data']['lead_email_address']}>";
        $agent_name = BaseCRM::agent_name($_POST['data']['agent_id']);
        $appointment_date = date('F j, Y', strtotime($_POST['data']['appointment_date']));

        if ($_POST['data']['appointment_type'] != '' && $_POST['data']['appointment_type'] != 'Child Safe Kit') {
            $appointment_type = $_POST['data']['appointment_type'];
        } else {
            $appointment_type = 'Child Safe Kit';
        }

        if ($_POST['data']['appointment_notes']) {
            $appointment_notes = $_POST['data']['appointment_notes'];
        }

        $lead_data = [
            'first_name' => $lead->first_name,
            'agent_name' => $agent_name,
            'appointment_date' => $appointment_date,
            'notes' => $appointment_notes ?? '',
            'appointment_type' => $appointment_type,
            'contact_phone' => $lead->phone,
        ];


        $email = new BaseEmail();
        $email->set_to($to);
        $email->set_subject("Child Safe Kit Appointment");
        $email->set_default_body($lead_data);
        $email->set_attachments('');

        $status = $email->send();

        $this->json_response(array('success' => $status));
    }

    // BaseCRM Lead Methods

    /**
     * Inserts a lead via ajax request from the Create Lead Form
     *
     * @return void die()
     */
    #[NoReturn] public function base_crm_create_lead(): void
    {
        $lead = new Lead();
        $lead->processPost($_POST);
        $response = [];

        if ($lead->id) {
            $response['lead'] = $lead;
            $response['success'] = true;
            $response['message'] = "$lead->first_name $lead->last_name created successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "There was a problem creating this entry, check the form details and try again.";
            $response['errors'] = $lead->errors;
        }

        $status = $response['success'] ? 200 : 400;

        $this->json_response($response, $status);
    }

    #[NoReturn] public function get_leads_for_user(int $wp_user_id = null): void
    {
        $leads = new Lead();
        $wp_user_id = $wp_user_id ?? $_POST['wp_user_id'] ?? $_GET['wp_user_id'] ?? null;
        $leads = $leads->getLeadsForUser($wp_user_id);
        $this->json_response($leads);
    }

    #[NoReturn] public function get_appointments_for_user(int $wp_user_id = null): void
    {
        $appointments = new Appointment();
        $wp_user_id = $wp_user_id ?? $_POST['wp_user_id'] ?? $_GET['wp_user_id'] ?? null;
        $appointments = $appointments->getAppointmentsForUser($wp_user_id);
        $this->json_response($appointments);
    }

    #[NoReturn] public function delete_lead(int $lead_id = null): void
    {
        $lead = new Lead();
        $lead_id = $lead_id ?? $_POST['lead_id'] ?? $_GET['lead_id'] ?? null;
        $lead = $lead->deleteLead($lead_id);
        $this->json_response($lead);
    }

    #[NoReturn] public function disposition_lead(int $lead_id = null, string $disposition = ''): void
    {
        $lead = new Lead();
        if (isset($_POST['lead_disposition'])) {
            $disposition = $_POST['lead_disposition'];
        } elseif (isset($_GET['lead_disposition'])) {
            $disposition = $_GET['lead_disposition'];
        } else {
            $this->json_response(array('error' => 'Invalid disposition'), 400);
        }
        $lead_id = $lead_id ?? $_POST['lead_id'] ?? $_GET['lead_id'] ?? null;
        $lead = $lead->dispositionLead($lead_id, $disposition);
        $this->json_response($lead);
    }

    #[NoReturn] public function call_lead(int $lead_id = null): void
    {
        $results = [];
        $lead_id = $lead_id ?? $_POST['lead_id'] ?? $_GET['lead_id'] ?? null;


        $lead = new Lead($lead_id);
        $lead_types = $lead->lead_types();
        $lead_type = $lead_types[$_POST['script-select']];
        // $lead->updateLead($lead_id, array('lead_type' => $lead_type));

        // explode the date and time
        $datetime_array = explode(' ', $_POST['lead-appointment-date']);
        $time = $datetime_array[1];

        $appointment = new Appointment();
        $insert = $appointment->createAppointment(array(
            'lead_id' => $lead_id,
            'agent_id' => get_current_user_id(),
            'appointment_type' => $lead_type,
            'appointment_date' => $_POST['lead-appointment-date'],
            'appointment_time' => $time,
            'appointment_status' => 'Scheduled',
        ));

        if ($insert) {
            $lead->updateLeadStatus($lead_id, 'Scheduled');
            $results['success'] = true;
            $results['message'] = "Appointment created successfully!";
        } else {
            $this->json_response($results);
        }
        $this->json_response($results);
    }

    #[NoReturn] public function get_lead(): void
    {
        $lead_id = $_POST['lead_id'] ?? $_GET['lead_id'] ?? null;
        $lead = new Lead($lead_id);
        $this->json_response($lead);
    }


    #[NoReturn] public function add_referral(): void
    {
        /**
         * POST data
         * @var $user_id int
         * @var $lead_id int
         * @var $appointment_id int
         * @var $string string
         * @var $referral_last_name string
         * @var $referral_phone string
         * @var $referral_email string
         * @var $referral_relationship string
         */

        // collect appointment type
        // $appointment = new Appointment();
        // $appointment_type = $appointment->getAppointmentByLeadId($_POST['lead_id'])->appointment_type;

        // collect lead first name
        $lead = new Lead($_POST['lead_id']);
        $lead_first_name = $lead->first_name;
        $appointment_type = $lead->lead_type;

        $referral = new Lead();
        $post_data = [
            'assigned_to' => $_POST['user_id'],
            'lead_type' => $appointment_type,
            'lead_source' => 'Referral',
            'first_name' => $_POST['referral_first_name'],
            'last_name' => $_POST['referral_last_name'],
            'phone' => $_POST['referral_phone'],
            'email' => $_POST['referral_email'],
            'lead_relationship' => $_POST['referral_relationship'],
            'lead_referred_by' => $lead_first_name,
        ];

        $referral->processPost($post_data);

        $response = [];

        if ($referral->id) {
            $response['success'] = true;
            $response['message'] = "$referral->first_name $referral->last_name created successfully!";
        } else {
            $response['success'] = false;
            $response['message'] = "There was a problem creating this entry, check the form details and try again.";
            $response['errors'] = $referral->errors;
        }

        $status = $response['success'] ? 200 : 400;

        $this->json_response($response, $status);
    }

    #[NoReturn] public function get_leads_for_admin(): void
    {
        $leads = new Lead();
        $leads = $leads->getLeadsForAdmin();
        $this->json_response($leads);
    }

    #[NoReturn] public function assign_leads(): void
    {
        $leads = new Lead();
        $lead_ids = $_POST['leads'];
        $leads = $leads->assignLeads($_POST['agent'], $lead_ids);
        $this->json_response($leads);
    }

    #region Appointment Methods
    #[NoReturn] public function get_appointments(): void
    {
        $appointments = new Appointment();
        $appointments = $appointments->getAll();
        $this->json_response('Hello world!', 400);
//			$this->json_response( $appointments );
    }
    #endregion

    #region Client Methods
    #[NoReturn] public function get_clients_for_user(): void
    {
        $clients = new Lead();
        $clients = $clients->getClientsForUser();
        $this->json_response($clients);
    }
    #endregion
}
