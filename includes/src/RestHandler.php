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

    public function makeRoutes() {
        register_rest_route('basecrm/v1', '/leads/vtp', array(
            'methods' => 'POST',
            'callback' => array($this, 'insert_lead_from_vtp'),
            'permission_callback' => function () {
                return $this->authorizeRest();
            }
        ));
        // update lead id field 'is_client' to 1
        register_rest_route('basecrm/v1', '/to_client/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'to_client'),
            'permission_callback' => function () {
                return $this->authorizeRest();
            }
        ));
    }

    public function to_client($id): void {
        $id = $id['id'] ?? null;
        if (!$id) {
            echo 'no id';

        }

        $lead = new Lead();
        $lead->toClient($id);

        echo "Success: $id";

    }


    public function authorizeRest() {
        $valid_sources = [
            'thejohnson.group'
        ];
        
        $source_url = $_POST['source_url'] ?? null;
        if ($source_url === false) {
            return false;
        }

        $valid_source = false;
        foreach ($valid_sources as $valid_source) {
            if (strpos($source_url, $valid_source) !== false) {
                $valid_source = true;
                break;
            }
        }

        return $valid_source;
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

    public function insert_lead_from_vtp() {

        error_log(print_r($_POST, true));

        $form_id = $_POST['form_id'] ?? null;
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
        } else if (!$form_id) {
            $form_data = array(
                'first_name' => $_POST['first_name'] ?? null,
                'last_name' => $_POST['last_name'] ?? null,
                'email' => $_POST['email'] ?? null,
                'phone' => $_POST['phone'] ?? null,
                'lead_source' => 'TJG WCN',
                'lead_type' => 'other',
                'lead-notes' => json_encode($_POST)
            );
        }

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
