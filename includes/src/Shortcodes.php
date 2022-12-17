<?php

namespace BaseCRM\ServerSide;

use BaseCRM\ServerSide\Lead;
use BaseCRM;

class BaseCRM_Shortcodes {

    public function __construct() {
        $shortcodes = array(
            'base_crm_hello_world' => array($this, 'echo_text'),
            'base_crm_create_lead_form' => array($this, 'createLeadForm'),
        );

        foreach ($shortcodes as $shortcode => $function) {
            add_shortcode($shortcode, $function);
        }
    }

    public function echo_text() {
        return <<<HTML
        <h1>Hello World</h1>
        <p>This is a test</p>
        <p>It's working</p>
        HTML;
    }

    public function createLeadForm() {
        $form = BaseCRM::snip('create-lead-form');
        return $form;
    }

}