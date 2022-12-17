<?php

namespace BaseCRM\Ajax;

use BaseCRM\ServerSide\AjaxInterface;
use BaseCRM\ServerSide\Lead;
use BaseCRM\ServerSide\Appointment;

class AjaxHandler implements AjaxInterface
{

    public function __construct()
    {
        add_action('wp_ajax_base_crm_ajax', array($this, 'ajaxHandler'));
        add_action('wp_ajax_nopriv_base_crm_ajax', array($this, 'ajaxHandler'));
    }

    public function ajaxHandler()
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

    public function json_response($data, $status = 200)
    {
        wp_send_json($data, $status);
        die();
    }

    // BaseCRM Lead Methods
    /**
     * Inserts a lead via ajax request from the Create Lead Form
     *
     * @return WP_JSON_Response die()
     */
    public function base_crm_create_lead()
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

    public function get_leads_for_user(int $wp_user_id = null): void
    {
        $leads = new Lead();
        $wp_user_id = $wp_user_id ?? $_POST['wp_user_id'] ?? $_GET['wp_user_id'] ?? null;
        $leads = $leads->getLeadsForUser($wp_user_id);
        $this->json_response($leads);
    }

    public function get_appointments_for_user(int $wp_user_id = null): void
    {
        $appointments = new Appointment();
        $wp_user_id = $wp_user_id ?? $_POST['wp_user_id'] ?? $_GET['wp_user_id'] ?? null;
        $appointments = $appointments->getAppointmentsForUser($wp_user_id);
        $this->json_response($appointments);
    }

    public function delete_lead(int $lead_id = null): void
    {
        $lead = new Lead();
        $lead_id = $lead_id ?? $_POST['lead_id'] ?? $_GET['lead_id'] ?? null;
        $lead = $lead->deleteLead($lead_id);
        $this->json_response($lead);
    }

    public function disposition_lead(int $lead_id = null, string $disposition = ''): void
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

    public function call_lead(int $lead_id = null)
    {
        $results = [];
        $lead_id = $lead_id ?? $_POST['lead_id'] ?? $_GET['lead_id'] ?? null;


        $lead = new Lead( $lead_id );
        $lead_types = $lead->lead_types();
        $lead_type = $lead_types[ $_POST['script-select'] ];
        // $lead->updateLead($lead_id, array('lead_type' => $lead_type));

        // explode the date and time
        $datetime_array = explode(' ', $_POST['lead-appointment-date']);
        $date = $datetime_array[0];
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
            return $this->json_response($results);
        }
        $this->json_response($results);
    }
}
