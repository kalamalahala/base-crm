<?php /** @noinspection SqlNoDataSourceInspection */

namespace BaseCRM\ServerSide;

use BaseCRM\ServerSide\AppointmentInterface;
use JetBrains\PhpStorm\NoReturn;


class Appointment implements AppointmentInterface
{

    public int $id;
    public string $created_at;
    public string $updated_at;
    public int $lead_id;
    public int $agent_id;
    public string $appointment_date;
    public string $appointment_time;
    public string $appointment_type;
    public string $appointment_status;
    public string $appointment_notes;

    private string $appointments_table;
    private string $presentations_table;

    public function __construct(int $id = null)
    {
        if (defined('BaseCRM_APPOINTMENTS_TABLE') && defined('BaseCRM_PRESENTATIONS_TABLE')) {
            $this->appointments_table = BaseCRM_APPOINTMENTS_TABLE;
            $this->presentations_table = BaseCRM_PRESENTATIONS_TABLE;
        } else {
            global $wpdb;
            $this->appointments_table = $wpdb->prefix . 'base_crm_appointments';
            $this->presentations_table = $wpdb->prefix . 'base_crm_presentations';
        }

        if ($id) {
            $this->id = $id;
            $this->getAppointment($id);
        }
    }

    public function getAppointment($id): Appointment
    {
        global $wpdb;
        $appointments_table = $wpdb->prefix . 'basecrm_appointments';
        $appointment = $wpdb->get_row("SELECT * FROM $this->appointments_table WHERE id = $id");
        if ($appointment) {
            $this->id = $appointment->id;
            $this->created_at = $appointment->created_at;
            $this->updated_at = $appointment->updated_at;
            $this->lead_id = $appointment->lead_id;
            $this->agent_id = $appointment->agent_id;
            $this->appointment_date = $appointment->appointment_date;
            $this->appointment_time = $appointment->appointment_time;
            $this->appointment_type = $appointment->appointment_type;
            $this->appointment_status = $appointment->appointment_status;
            $this->appointment_notes = $appointment->appointment_notes;
            return $this;
        }
        return new Appointment();
    }

    public function getAppt(int $id): bool
    {
        $output = json_encode($this->getAppointment($id));
        if ($output == '{}') {
            echo "Appointment ID $id not found";
            return false;
        }
        echo $output;
        return true;
    }

    public function getAll()
    {
        global $wpdb;
        $appointments_table = $wpdb->prefix . 'base_crm_appointments';
        return $wpdb->get_results("SELECT * FROM $appointments_table");
    }

    public function getAppointmentsForUser($user_id = null)
    {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        global $wpdb;
        $appointments_table = $wpdb->prefix . 'base_crm_appointments';
        $leads_table = $wpdb->prefix . 'base_crm_leads';

        $query = "SELECT a.id AS 'appointment_id',
                        a.created_at AS 'appointment_created_at',
                        a.updated_at AS 'appointment_updated_at',
                        a.lead_id AS 'appointment_lead_id',
                        a.appointment_date, a.appointment_time,
                        a.appointment_type, a.appointment_status, a.appointment_notes,
                        l.id AS 'lead_id',
                        l.phone AS 'lead_phone',
                        CONCAT(l.first_name,' ',l.last_name) AS 'lead_name'
                        FROM $appointments_table a JOIN $leads_table l ON a.lead_id = l.id
                        WHERE a.agent_id = $user_id;";


        $appointments = $wpdb->get_results($query);

        $results = [];
        $results['data'] = $appointments;
        $results['query'] = $wpdb->last_query;
        $results['error'] = $wpdb->last_error;

        return $appointments;
    }

    public function updateAppointment($id, $data)
    {
        global $wpdb;
        $appointments_table = $wpdb->prefix . 'base_crm_appointments';
        $wpdb->update(
            $appointments_table,
            array(
                'updated_at' => $data['updated_at'],
                'lead_id' => $data['lead_id'],
                'agent_id' => $data['agent_id'],
                'appointment_date' => $data['appointment_date'],
                'appointment_time' => $data['appointment_time'],
                'appointment_type' => $data['appointment_type'],
                'appointment_status' => $data['appointment_status'],
                'appointment_notes' => $data['appointment_notes'],
            ),
            array('id' => $id)
        );
    }

    public function deleteAppointment($id)
    {
        global $wpdb;
        $appointments_table = $wpdb->prefix . 'base_crm_appointments';
        $wpdb->delete(
            $appointments_table,
            array('id' => $id)
        );
    }

    public function callLead($lead_id)
    {
        $lead = new Lead($lead_id);
        $appointment = new Appointment();
        $appointment->createAppointment(array(
            'created_at' => $this->datetime_now('Y-m-d H:i:s'),
            'updated_at' => $this->datetime_now('Y-m-d H:i:s'),
            'lead_id' => $lead_id,
            'agent_id' => $lead->assigned_to,
            'appointment_date' => date('Y-m-d'),
            'appointment_time' => date('H:i:s'),
            'appointment_type' => 'Call',
            'appointment_status' => 'Scheduled',
            'appointment_notes' => 'Call Lead',
        ));
    }

    public function createAppointment($data)
    {
        global $wpdb;
        $appointments_table = $wpdb->prefix . 'base_crm_appointments';

        $insert = $wpdb->insert(
            $appointments_table,
            array(
                'created_at' => $this->datetime_now('Y-m-d H:i:s'),
                'updated_at' => $this->datetime_now('Y-m-d H:i:s'),
                'lead_id' => $data['lead_id'],
                'agent_id' => $data['agent_id'],
                'appointment_date' => $data['appointment_date'],
                'appointment_time' => $data['appointment_time'],
                'appointment_type' => $data['appointment_type'],
                'appointment_status' => $data['appointment_status'],
                'appointment_notes' => $data['appointment_notes'] ?? '',
            )
        );

        return $insert;
    }

    /**
     * Return a formatted date and time string.
     *
     * @param string $format
     * @return string
     */
    public function datetime_now(string $format): string
    {
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('America/New_York'));
        return $datetime->format($format);
    }

    public function submit_presentation($form_data)
    {
        global $wpdb;
        $appointments_table = $this->appointments_table;
        $presentations_table = $this->presentations_table;

        // Format the $_POST parameter into a JSON string
        $form_submission = json_encode($form_data);
        $insert = $wpdb->insert(
            $presentations_table,
            array(
                'created_at' => $this->datetime_now('Y-m-d H:i:s'),
                'updated_at' => $this->datetime_now('Y-m-d H:i:s'),
                'lead_id' => $form_data['lead-id'],
                'agent_id' => $form_data['agent_id'],
                'appointment_id' => $form_data['appointment-id'],
                'form_submission' => $form_submission,
            )
        );
    }

    public function getAppointments($params = []): array
    {
        $query = "SELECT * FROM $this->appointments_table WHERE ";

        if (!isset($params['start_date'])) {
            $params['start_date'] = '2020-01-01';
        }

        if (!isset($params['end_date'])) {
            $params['end_date'] = date('Y-m-d');
        }

        if (isset($params['start_date']) && isset($params['end_date'])) {
            $query .= "appointment_date BETWEEN '{$params['start_date']}' AND '{$params['end_date']}'";
        }

        if (isset($params['lead_id'])) {
            $query .= " AND lead_id = {$params['lead_id']}";
        }

        if (isset($params['agent_id'])) {
            $query .= " AND agent_id = {$params['agent_id']}";
        }

        if (isset($params['appointment_type'])) {
            $query .= " AND appointment_type = '{$params['appointment_type']}'";
        }

        if (isset($params['appointment_status'])) {
            $query .= " AND appointment_status = '{$params['appointment_status']}'";
        }

        if (isset($params['appointment_date'])) {
            $query .= " AND appointment_date = '{$params['appointment_date']}'";
        }

        if (isset($params['appointment_time'])) {
            $query .= " AND appointment_time = '{$params['appointment_time']}'";
        }

        if (isset($params['appointment_notes'])) {
            $query .= " AND appointment_notes CONTAINS '{$params['appointment_notes']}'";
        }

        global $wpdb;
        return $wpdb->get_results($query, ARRAY_A);
    }

    public function getAgentAppts(int $param): array
    {
        $params['agent_id'] = $param;
        return $this->getAppointments($params);
    }
}
/**
 * Post Values
 */
/*
script-select: 
cskw
lead-is-employed: 
on
conversation-notes: 
lead-has-rebuttals: 
No
lead-email: 
solo.driver.bob@gmail.com
lead-is-married: 
Yes
lead-spouse-first-name: 
Megan
lead-has-children: 
No
lead-bank: 
No
lead-bank-name: 
lead-first-name: 
Tyler
lead-last-name: 
Karle
lead-phone: 
(904) 532-1080
lead-appointment-date: "2022-12-19 12:00"
ccid: 
base
bid: 
base
lead_id: 
35
action: 
base_crm_ajax
nonce: 
e2bd7b065f
method: 
call_lead
*/