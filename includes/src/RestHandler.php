<?php

/**
 * BaseCRM REST API
 */

namespace BaseCRM\Rest;

use BaseCRM\ServerSide\RestInterface;
use BaseCRM\ServerSide\Lead;

class RestHandler implements RestInterface
{
    public function __construct()
    {
        // Wordpress REST API
        add_action('rest_api_init', array($this, 'makeRoutes'));
    }

    public function makeRoutes()
    {
        register_rest_route('basecrm/v1', '/leads/vtp', array(
            'methods' => 'POST',
            'callback' => array($this, 'insert_lead_from_vtp'),
            'permission_callback' => function () {
                return $this->authorizeRest();
            }
        ));
    }

    /**
     * Attempt to authorize the REST API request
     *
     * @return boolean
     */
    public function authorizeRest(): bool
    {
        $valid_sources = [                                  // valid source urls
            'thejohnson.group'
        ];

        $source_url = $_POST['source_url'] ?? null;         // source url
        if (!empty($source_url)) {                          // if source url is not empty
            foreach ($valid_sources as $url) {              // loop through valid sources
                if (strpos($source_url, $url) !== false) {  // if source url contains valid source
                    return true;                            // return true
                }
            }
        }

        return false;                                       // return false
    }

    public function get($endpoint, $params = [])
    {
        // ...
    }

    public function post($endpoint, $params = [])
    {
        // ...
    }

    public function put($endpoint, $params = [])
    {
        // ...
    }

    public function delete($endpoint, $params = [])
    {
        // ...
    }

    public function patch($endpoint, $params = [])
    {
        // ...
    }

    private function getLeads($params = [])
    {
        // ...
    }

    private function getLead($params = [])
    {
        // ...
    }

    public function insert_lead_from_vtp()
    {

        error_log('insert_lead_from_vtp before creating form data array');
        error_log(print_r($_POST, true));

        $form_id = $_POST['form_id'] ?? null;
        $form_data = [];

        if ($form_id == 2) {
            $form_data = array(
                'first_name' => $_POST['1_3'] ?? null,
                'last_name' => $_POST['1_6'] ?? null,
                'email' => $_POST['4'] ?? null,
                'phone' => $_POST['3'] ?? null,
                'lead_source' => 'VTP',
                'lead_type' => 'other',
                'lead-notes' => json_encode($_POST)
            );
        } else if ($form_id == 13) {
            $form_data = array(
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'lead_source' => $_POST['lead_source'] ?? '',
                'lead_type' => $_POST['lead_type'] ?? '',
                'date_last_contacted' => $_POST['date_last_contacted'] ?? '',
                'date_last_appointment' => $_POST['date_last_appointment'] ?? '',
                'lead-notes' => json_encode($_POST['entry'])
            );
        }

        if (empty($form_data)) {
            return $this->json_response(array(
                'status' => 'error',
                'message' => 'No form data'
            ), 400);
        }

        error_log('form data array only');
        error_log(print_r($form_data, true));

        $lead = new Lead();
        $lead->processPost($form_data);

        if ($lead->id) {
            return $this->json_response(array(
                'status' => 'success',
                'message' => 'Lead created successfully',
                'id' => $lead->id
            ), 200);
        } else {
            return $this->json_response(array(
                'status' => 'error',
                'message' => 'Lead not created'
            ), 400);
        }
    }

    public function json_response($data, $status = 200)
    {
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data);
    }

    public function requestStatus($code)
    {
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
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}
