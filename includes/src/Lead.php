<?php

namespace BaseCRM\ServerSide;

use BaseCRM\ServerSide\Appointment;
use BaseCRM;

class Lead implements LeadInterface
{

    public $id;
    public $created_at;
    public $updated_at;
    public $assigned_to;
    public $assigned_by;
    public $assigned_at;
    public $lead_status;
    public $lead_disposition;
    public $lead_type;
    public $lead_source;
    public $lead_relationship;
    public $lead_referred_by;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $is_married;
    public $spouse_first_name;
    public $spouse_last_name;

    public $table;
    public $meta_table;

    public $errors = [];

    public function __construct($lead_id = null)
    {
        
        global $wpdb;
        if (defined('BaseCRM_LEADS_TABLE')) {
            $this->table = BaseCRM_LEADS_TABLE;
        } else {
            $this->table = $wpdb->prefix . 'base_crm_leads';
        }
        
        if (defined('BaseCRM_LEADS_META_TABLE')) {
            $this->meta_table = BaseCRM_LEADS_META_TABLE;
        } else {
            $this->meta_table = $wpdb->prefix . 'base_crm_leads_meta';
        }

        if (!empty($lead_id)) {
            $this->construct_lead($lead_id);
        }
    }

    private function construct_lead(int $lead_id)
    {
        $lead_array = $this->getLeadArray($lead_id);
        $lead = $this->setLead($lead_array);

        return $lead;
    }

    private function setLead(array $data)
    {
        $this->id = $data['id'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->assigned_to = $data['assigned_to'];
        $this->assigned_by = $data['assigned_by'];
        $this->assigned_at = $data['assigned_at'];
        $this->lead_status = $data['lead_status'];
        $this->lead_disposition = $data['lead_disposition'];
        $this->lead_type = $data['lead_type'];
        $this->lead_source = $data['lead_source'];
        $this->lead_relationship = $data['lead_relationship'];
        $this->lead_referred_by = $data['lead_referred_by'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->is_married = $data['is_married'];
        $this->spouse_first_name = $data['spouse_first_name'];
        $this->spouse_last_name = $data['spouse_last_name'];

        return $this;
    }

    private function insertLead(): int
    {
        global $wpdb;
        $insert = $wpdb->insert(
            $this->table,
            [
                'id' => null,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'assigned_to' => $this->assigned_to,
                'assigned_by' => $this->assigned_by,
                'assigned_at' => $this->assigned_at,
                'lead_status' => $this->lead_status,
                'lead_disposition' => $this->lead_disposition,
                'lead_type' => $this->lead_type,
                'lead_source' => $this->lead_source,
                'lead_relationship' => $this->lead_relationship,
                'lead_referred_by' => $this->lead_referred_by,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'is_married' => $this->is_married,
                'spouse_first_name' => $this->spouse_first_name,
                'spouse_last_name' => $this->spouse_last_name,
            ]
        );

        if (!$insert) {
            $this->errors[] = $wpdb->last_error;
            return 0;
        } else {
            return $wpdb->insert_id;
        }
    }

    public function processPost($post)
    {
        $data_array['id'] = $post['id'] ?? 0;
        $data_array['created_at'] = $post['created_at'] ?? $this->datetime_now('Y-m-d H:i:s');
        $data_array['updated_at'] = $post['updated_at'] ?? $this->datetime_now('Y-m-d H:i:s');
        $data_array['assigned_to'] = $post['assigned_to'] ?? get_current_user_id();
        $data_array['assigned_by'] = $post['assigned_by'] ?? 0;
        $data_array['assigned_at'] = $post['assigned_at'] ?? $this->datetime_now('Y-m-d H:i:s');
        $data_array['lead_status'] = $post['lead_status'] ?? 'new';
        $data_array['lead_disposition'] = $post['lead_disposition'] ?? 'new';
        $data_array['lead_type'] = $post['lead_type'] ?? $_POST['lead-type'] ?? 'new'; // front end form field name is lead-type
        $data_array['lead_source'] = $post['lead_source'] ?? 'new';
        $data_array['lead_relationship'] = $post['lead_relationship'] ?? $_POST['lead-relationship'] ?? 'new'; // front end form field name is lead-relationship
        $data_array['lead_referred_by'] = $post['lead_referred_by'] ?? $_POST['lead-referred-by'] ?? 'new'; // front end form field name is lead-referred-by
        $data_array['first_name'] = $post['first_name'] ?? $_POST['first-name-field'] ?? ''; // front end form field name is first-name-field
        $data_array['last_name'] = $post['last_name'] ?? $_POST['last-name-field'] ?? ''; // front end form field name is last-name-field
        $data_array['email'] = $post['email'] ?? $_POST['email-field'] ?? ''; // front end form field name is email-field
        $data_array['phone'] = $post['phone'] ?? $_POST['phone-field'] ?? ''; // front end form field name is phone-field

        $data_array['spouse_first_name'] = $post['spouse_first_name'] ?? $_POST['spouse-first-name-field'] ?? ''; // front end form field name is spouse-first-name-field
        $data_array['spouse_last_name'] = $post['spouse_last_name'] ?? $_POST['spouse-last-name-field'] ?? ''; // front end form field name is spouse-last-name-field

        if ($post['is-married'] === 'Yes') { // front end form field name is 'is-married
            $data_array['is_married'] = 1;
        } else {
            $data_array['is_married'] = 0;
        }


        $this->setLead($data_array);                                    // set lead object properties

        if ($this->id) {
            $this->updateLead($this->id, $data_array);                  // update lead object properties
        } else {
            $this->id = $this->insertLead();                            // create new lead
            if ($data_array['lead_type'] === 'other') {                 // if lead type is other, create lead meta entry
                $notes = $post['lead-notes'];                           // front end form field name is lead-notes
                $this->addLeadMeta($this->id, 'lead_notes', $notes);    // add lead notes to lead meta table
            }
        }

        return $this;
    }

    public function getLead($id): Lead
    {
        global $wpdb;
        $lead = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE id = %d",
                $id
            )
        );

        $lead = new Lead((array) $lead);

        return $lead;
    }

    public function getLeadArray($id): array
    {
        global $wpdb;
        $lead = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE id = %d",
                $id
            )
        );

        $lead = (array) $lead;

        return $lead;
    }

    public function getLeads($args = [])
    {
        global $wpdb;
        $leads = $wpdb->get_results(
            "SELECT * FROM {$this->table}"
        );

        $leads = array_map(function ($lead) {
            return new Lead((array) $lead);
        }, $leads);

        return $leads;
    }

    public function getLeadsForUser(int $user_id = null)
    {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }

        global $wpdb;
        $leads = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE assigned_to = %d",
                $user_id
            )
        );

        // $leads = (array) $leads;

        $response = [];

        $response['leads'] = array_map(function ($lead) {

            return new Lead($lead->id);
        }, $leads);

        $response['recordsTotal'] = count($leads);
        $response['recordsFiltered'] = count($leads);
        $response['draw'] = $_POST['draw'] ?? $_GET['draw'] ?? 1;

        return $response;
    }

    public function createLead($data)
    {
        $lead = new Lead();
        $lead->setLead($data);
        $insert = $lead->insertLead();

        return ($insert > 0) ? $lead : false;
    }

    public function updateLead($id, $data)
    {
        $lead = new Lead();
        $lead->setLead($data);
        return $lead;
    }

    public function updateLeadStatus($id, $status)
    {
        global $wpdb;
        $update = $wpdb->update(
            $this->table,
            [
                'lead_status' => $status,
            ],
            [
                'id' => $id,
            ]
        );

        return $update;
    }

    public function deleteLead($id)
    {
        global $wpdb;
        $delete = $wpdb->delete(
            $this->table,
            [
                'id' => $id,
            ]
        );

        return $delete;
    }

    public function dispositionLead($id, $disposition)
    {
        global $wpdb;
        $update = $wpdb->update(
            $this->table,
            [
                'lead_disposition' => $disposition,
            ],
            [
                'id' => $id,
            ]
        );

        return $update;
    }

    public function yeet()
    {
        return 'yeet';
    }

    public function addLeadMeta($lead_id, $meta_key, $meta_value)
    {
        global $wpdb;
        $wpdb->insert(
            $this->meta_table,
            [
                'lead_id' => $lead_id,
                'created_at' => $this->datetime_now('Y-m-d H:i:s'),
                'updated_at' => $this->datetime_now('Y-m-d H:i:s'),
                'meta_key' => $meta_key,
                'meta_value' => $meta_value,
            ]
        );
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

    public function lead_types()
    {
        $array = [
            'adp' => '$3,000 Accidental Death Policy',
            'cskw' => 'Child Safe Kit - Warm Market',
            'cskr' => 'Child Safe Kit - Referral',
            'pos' => 'POS',
            'opai' => 'OPAI',
            'other' => 'Other (See Notes)',
        ];

        return $array;
    }

    public function callLead($id)
    {
        // create and insert new Appointment
        $appointment = new Appointment();

        $appointment->createAppointment([
            'lead_id' => $id,
            'appointment_type' => 'call',
            'appointment_status' => 'scheduled',
            'appointment_date' => $this->datetime_now('Y-m-d H:i:s'),
            'appointment_notes' => '',
        ]);

        // update lead status
        $this->updateLead($id, [
            'lead_status' => 'scheduled',
        ]);

        // return $appointment;
    }


}
