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
        add_action('rest_api_init', function () {
            register_rest_route('basecrm/v1', '/leads', array(
                'methods' => 'GET',
                'callback' => array($this, 'getLeads'),
            ));
            register_rest_route('basecrm/v1', '/leads/(?P<id>\d+)', array(
                'methods' => 'GET',
                'callback' => array($this, 'getLead'),
            ));
            register_rest_route('basecrm/v1', '/leads', array(
                'methods' => 'POST',
                'callback' => array($this, 'createLead'),
            ));
            register_rest_route('basecrm/v1', '/leads/(?P<id>\d+)', array(
                'methods' => 'PUT',
                'callback' => array($this, 'updateLead'),
            ));
            register_rest_route('basecrm/v1', '/leads/(?P<id>\d+)', array(
                'methods' => 'DELETE',
                'callback' => array($this, 'deleteLead'),
            ));
        });
    }

    public function get($endpoint, $params = [])
    {
        // get lead
        echo 'get lead';
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

    public function request($method, $endpoint, $params = [])
    {
        // ...
    }

    public function getLeads()
    {
        // validate request
        $this->validateRequest();
        $leads = new Lead(1);
        // $leads = $leads->getLeads();
        wp_send_json( $leads );
    }

    private function validateRequest()
    {
        // check wordpress nonce
        // if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'wp_rest')) {
        //     wp_send_json_error('Invalid nonce');
        // }
        return true;
    }
}
