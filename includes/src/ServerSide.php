<?php

namespace BaseCRM\ServerSide;

require_once(plugin_dir_path( dirname( __FILE__ ) ) . 'src/Lead.php');
require_once(plugin_dir_path( dirname( __FILE__ ) ) . 'src/Shortcodes.php');
require_once(plugin_dir_path( dirname( __FILE__ ) ) . 'src/AjaxHandler.php');
require_once(plugin_dir_path( dirname( __FILE__ ) ) . 'src/Appointment.php');

interface LeadInterface {
    public function getLead($id): Lead;
    public function getLeads();
    public function createLead($data);
    public function updateLead($id, $data);
    public function deleteLead($id);
}

interface AppointmentInterface {
    public function getAppointment($id): Appointment;
    public function getAppointments();
    public function createAppointment($data);
    public function updateAppointment($id, $data);
    public function deleteAppointment($id);
}

interface AjaxInterface {
    public function __construct();
    public function ajaxHandler();
    public function json_response($data, $status = 200);
}

?>
