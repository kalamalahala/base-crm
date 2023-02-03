<?php

namespace BaseCRM\ServerSide;

use BaseCRM\ServerSide\Appointment;
use BaseCRM;
use DateTime;
use WP_User;

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
    public $is_employed;
    public $has_children;
    public $num_children;
    public $has_bank_account;
    public $bank_account_type;
    public $bank_name;
    public $bank_account_number;
    public $bank_routing_number;
    public $spouse_first_name;
    public $spouse_last_name;
    public $date_last_contacted;
    public $date_last_appointment;
    public $date_last_sale;
    public $date_last_followup;
    public $date_last_disposition;
    public $number_of_referrals_to_date;
    public $is_policyholder;
    public $is_spouse_policyholder;

    public $date_last_contacted_string;

    private $table;
    private $meta_table;

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

    public function updateProp($prop, $value)
    {
        $this->$prop = $value;

        return $this->$prop;
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
        $this->is_employed = $data['is_employed'];
        $this->has_children = $data['has_children'];
        $this->num_children = $data['num_children'];
        $this->has_bank_account = $data['has_bank_account'];
        $this->bank_account_type = $data['bank_account_type'];
        $this->bank_name = $data['bank_name'];
        $this->bank_account_number = $data['bank_account_number'];
        $this->bank_routing_number = $data['bank_routing_number'];
        $this->spouse_first_name = $data['spouse_first_name'];
        $this->spouse_last_name = $data['spouse_last_name'];
        $this->date_last_contacted = $data['date_last_contacted'];
        $this->date_last_appointment = $data['date_last_appointment'];
        $this->date_last_sale = $data['date_last_sale'];
        $this->date_last_followup = $data['date_last_followup'];
        $this->date_last_disposition = $data['date_last_disposition'];
        $this->number_of_referrals_to_date = $data['number_of_referrals_to_date'];
        $this->is_policyholder = $data['is_policyholder'];
        $this->is_spouse_policyholder = $data['is_spouse_policyholder'];

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
                'is_employed' => $this->is_employed,
                'has_children' => $this->has_children,
                'num_children' => $this->num_children,
                'has_bank_account' => $this->has_bank_account,
                'bank_account_type' => $this->bank_account_type,
                'bank_name' => $this->bank_name,
                'bank_account_number' => $this->bank_account_number,
                'bank_routing_number' => $this->bank_routing_number,
                'spouse_first_name' => $this->spouse_first_name,
                'spouse_last_name' => $this->spouse_last_name,
                'date_last_contacted' => $this->date_last_contacted,
                'date_last_appointment' => $this->date_last_appointment,
                'date_last_sale' => $this->date_last_sale,
                'date_last_followup' => $this->date_last_followup,
                'date_last_disposition' => $this->date_last_disposition,
                'number_of_referrals_to_date' => $this->number_of_referrals_to_date,
                'is_policyholder' => $this->is_policyholder,
                'is_spouse_policyholder' => $this->is_spouse_policyholder,
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
        $validation = $this->validatePost($post);
        if ($validation !== true) {
            wp_send_json(['success' => false, 'errors' => $validation]);
        }
        $data_array['id'] = $post['id'] ?? 0;
        $data_array['created_at'] = $post['created_at'] ?? $this->datetime_now('Y-m-d H:i:s');
        $data_array['updated_at'] = $post['updated_at'] ?? $this->datetime_now('Y-m-d H:i:s');
        $data_array['assigned_to'] = $post['assigned_to'] ?? get_current_user_id();
        $data_array['assigned_by'] = $post['assigned_by'] ?? 0;
        $data_array['assigned_at'] = $post['assigned_at'] ?? $this->datetime_now('Y-m-d H:i:s');
        $data_array['lead_status'] = $post['lead_status'] ?? 'New';
        $data_array['lead_disposition'] = $post['lead_disposition'] ?? 'New';
        $data_array['lead_type'] = $post['lead_type'] ?? $_POST['lead-type'] ?? 'New'; // front end form field name is lead-type
        $data_array['lead_source'] = $post['lead_source'] ?? 'New';
        $data_array['lead_relationship'] = $post['lead_relationship'] ?? $_POST['lead-relationship'] ?? 'new'; // front end form field name is lead-relationship
        $data_array['lead_referred_by'] = $post['lead_referred_by'] ?? $_POST['lead-referred-by'] ?? 'new'; // front end form field name is lead-referred-by
        $data_array['first_name'] = $post['first_name'] ?? $_POST['first-name-field'] ?? ''; // front end form field name is first-name-field
        $data_array['last_name'] = $post['last_name'] ?? $_POST['last-name-field'] ?? ''; // front end form field name is last-name-field
        $data_array['email'] = $post['email'] ?? $_POST['email-field'] ?? ''; // front end form field name is email-field
        $data_array['phone'] = $post['phone'] ?? $_POST['phone-field'] ?? ''; // front end form field name is phone-field
        $data_array['is_married'] = ($post['is-married'] ?? $_POST['is-married'] ?? 'No') === 'Yes' ? 1 : 0; // front end form field name is is-married
        $data_array['is_employed'] = ($post['is-employed'] ?? $_POST['is-employed'] ?? 'No') === 'Yes' ? 1 : 0; // front end form field name is is-employed
        $data_array['has_children'] = ($post['has-children'] ?? $_POST['has-children'] ?? 'No') === 'Yes' ? 1 : 0; // front end form field name is has-children}
        $data_array['num_children'] = $post['num_children'] ?? $_POST['num-children-field'] ?? 0; // front end form field name is num-children-field
        $data_array['has_bank_account'] = ($post['has-bank-account'] ?? $_POST['has-bank-account'] ?? 'No') === 'Yes' ? 1 : 0; // front end form field name is has-bank-account
        $data_array['bank_account_type'] = $post['bank_account_type'] ?? $_POST['bank-account-type-field'] ?? ''; // front end form field name is bank-account-type-field
        $data_array['bank_name'] = $post['bank_name'] ?? $_POST['bank-name-field'] ?? ''; // front end form field name is bank-name-field
        $data_array['bank_account_number'] = $post['bank_account_number'] ?? $_POST['bank-account-number-field'] ?? ''; // front end form field name is bank-account-number-field
        $data_array['bank_routing_number'] = $post['bank_routing_number'] ?? $_POST['bank-routing-number-field'] ?? ''; // front end form field name is bank-routing-number-field
        $data_array['spouse_first_name'] = $post['spouse_first_name'] ?? $_POST['spouse-first-name-field'] ?? ''; // front end form field name is spouse-first-name-field
        $data_array['spouse_last_name'] = $post['spouse_last_name'] ?? $_POST['spouse-last-name-field'] ?? ''; // front end form field name is spouse-last-name-field
        $data_array['date_last_contacted'] = $post['date_last_contacted'] ?? $this->date_last_contacted ?? '0000-00-00 00:00:00';
        $data_array['date_last_appointment'] = $post['date_last_appointment'] ?? $this->date_last_appointment ?? '0000-00-00 00:00:00';
        $data_array['date_last_sale'] = $post['date_last_sale'] ?? $this->date_last_sale ?? '0000-00-00 00:00:00';
        $data_array['date_last_followup'] = $post['date_last_followup'] ?? $this->date_last_followup ?? '0000-00-00 00:00:00';
        $data_array['date_last_disposition'] = $post['date_last_disposition'] ?? $this->date_last_disposition ?? '0000-00-00 00:00:00';
        $data_array['number_of_referrals_to_date'] = $post['number_of_referrals_to_date'] ?? $this->number_of_referrals_to_date ?? 0;
        $data_array['is_policyholder'] = ($post['is-policyholder'] ?? $_POST['is-policyholder'] ?? 'No') === 'Yes' ? 1 : 0; // front end form field name is is-policyholder
        $data_array['is_spouse_policyholder'] = ($post['is-spouse-policyholder'] ?? $_POST['is-spouse-policyholder'] ?? 'No') === 'Yes' ? 1 : 0; // front end form field name is is-spouse-policyholder
        

        $this->setLead($data_array);                                    // set lead object properties

        if ($this->id) {
            $this->updateLead($this->id, $data_array);                       // update lead object properties
        } else {
            $this->id = $this->insertLead();                                // create new lead
            $notes = $post['lead-notes'] ?? $_POST['lead_notes'] ?? null;   // front end form field name is lead-notes
            if ($notes) {
                $this->addLeadMeta($this->id, 'lead_notes', $notes);            // add lead notes to lead meta table
            }
        }

        return $this;
    }

    public function table_columns() {
        // return array of this Object's public property names
        $cols = array_keys(get_object_vars($this));

        $unneeded = [
            'table',
            'meta_table',
            'errors',
        ];

        foreach ($unneeded as $key) {
            $index = array_search($key, $cols);
            if ($index !== false) {
                unset($cols[$index]);
            }
        }

        return $cols;
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

            $lead_to_modify = new Lead($lead->id);

            $last_contacted = $lead_to_modify->date_last_contacted;
            if ($last_contacted && $last_contacted !== '0000-00-00 00:00:00') {
                $now = new DateTime($this->datetime_now('Y-m-d H:i:s'));
                $last_contacted = new DateTime($last_contacted);
                $interval = $now->diff($last_contacted);

                if ($interval->format('%a') == 0) {
                    $lead_to_modify->date_last_contacted_string = 'Today';
                } elseif ($interval->format('%a') == 1) {
                    $lead_to_modify->date_last_contacted_string = 'Yesterday';
                } else {
                    $lead_to_modify->date_last_contacted_string = $interval->format('%a days ago');
                }

            } else {
                $lead_to_modify->date_last_contacted_string = 'Never';
            }

            return $lead_to_modify;
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

    public function wpdbUpdateLead($id, $data)
    {
        global $wpdb;
        $update = $wpdb->update(
            $this->table,
            $data,
            [
                'id' => $id,
            ]
        );

        return $update;
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
            'vtp' => 'Virtual Tax Pro',
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

    public function leads_datatable(int $user_id = null, array $args = [])
    {
        if (!$user_id) { // if no user_id is passed, check role
            $user_id = get_current_user_id();
            if (!$user_id) {
                return false;
            }
            $user = new WP_User($user_id);
            $role = $user->roles[0];
            if ($role === 'administrator') {
                $user_id = null;
            }
        }

        $cols_in_table = $this->table_columns();
        $requested_cols = $args['columns'] ?? $cols_in_table;
        $cols = array_intersect($cols_in_table, $requested_cols);
        $cols = array_map(function ($col) {
            return $this->table . '.' . $col;
        }, $cols);
        $cols = implode(', ', $cols);

        $search = $args['search'] ?? null;
        $order = $args['order'] ?? null;
        $limit = $args['limit'] ?? null;
        $offset = $args['offset'] ?? null;

        $query = "SELECT {$cols} FROM {$this->table}";

        if ($user_id) {
            $query .= " WHERE {$this->table}.assigned_to = {$user_id}";
        }

        if ($search) {
            if (count($search) > 1) {
                $query .= " AND (";
            }
            foreach ($search as $key => $value) {
                $query .= " AND {$this->table}.{$key} LIKE '%{$value}%'";
            }
        }

        if ($order) {
            $query .= " ORDER BY {$this->table}.{$order['column_name']} {$order['direction']}";
        }

        if ($limit) {
            $query .= " LIMIT {$limit}";
        }

        if ($offset) {
            $query .= " OFFSET {$offset}";
        }

        global $wpdb;
        $leads = $wpdb->get_results($query);

        $response = [];

        $response['leads'] = array_map(function ($lead) {
            return new Lead($lead->id);
        }, $leads);

        $response['recordsTotal'] = count($leads);
        $response['recordsFiltered'] = count($leads);
        $response['draw'] = $_POST['draw'] ?? $_GET['draw'] ?? 1;
        $response['query'] = $query;

        return $response;
    }

    public function isValid($data) {
        $errors = [];

        if (empty($data['first_name'])) {
            $errors['first_name'] = 'First Name is required';
        }

        if (empty($data['last_name'])) {
            $errors['last_name'] = 'Last Name is required';
        }

        if (empty($data['phone'])) {
            $errors['phone'] = 'Phone is required';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        }

        if (empty($data['lead_type'])) {
            $errors['lead_type'] = 'Lead Type is required';
        }

        if (empty($data['lead_status'])) {
            $errors['lead_status'] = 'Lead Status is required';
        }

        if (empty($data['lead_disposition'])) {
            $errors['lead_disposition'] = 'Lead Disposition is required';
        }

        if (empty($data['lead_source'])) {
            $errors['lead_source'] = 'Lead Source is required';
        }

        if (empty($data['lead_notes'])) {
            $errors['lead_notes'] = 'Lead Notes is required';
        }

        if (empty($data['assigned_to'])) {
            $errors['assigned_to'] = 'Assigned To is required';
        }

        return $errors;
    }

    public function validatePost($data) {
        $errors = [];

        $first_name = $data['first_name'] ?? null;
        $last_name = $data['last_name'] ?? null;
        $phone = $data['phone'] ?? $data['phone-field'] ?? null;
        $email = $data['email'] ?? $data['email-field'] ?? null;
        $lead_type = $data['lead_type'] ?? null;
        $lead_status = $data['lead_status'] ?? null;
        $lead_disposition = $data['lead_disposition'] ?? null;
        $lead_source = $data['lead_source'] ?? null;
        $lead_notes = $data['lead_notes'] ?? null;
        $assigned_to = $data['assigned_to'] ?? null;

        if (empty($phone) && empty($email)) {
            $errors['phone'] = ($phone) ? '' : 'Phone is required if Email is empty';
            $errors['email'] = ($email) ? '' : 'Email is required if Phone is empty';
        }

        if (!empty($email)) {
            if (!$this->emailExists($email)) {
                $errors['email'] = 'Email already exists';
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email is not valid';
            }
        }

        if (empty($errors)) {
            return true;
        }
        
        return $errors;
    }

    public function emailExists(string $email): bool {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)) {
            return false;
        }

        global $wpdb;
        $query = "SELECT * FROM {$this->table} WHERE email = '{$email}'";
        $result = $wpdb->get_results($query);
        return (count($result) > 0) ? false : true;
    }

    public function getLeadsForAdmin() {
        global $wpdb;
        $wp_usermeta_table = $wpdb->prefix . 'usermeta';
        $query = "SELECT l.id,
            l.assigned_to,
            l.first_name,
            l.last_name,
            l.phone,
            l.email,
            l.lead_type,
            l.lead_source,
            l.lead_disposition,
            l.created_at,
            l.updated_at,
            (SELECT meta_value FROM {$wp_usermeta_table} WHERE user_id = l.assigned_to AND meta_key = 'first_name') AS assigned_to_first_name,
            (SELECT meta_value FROM {$wp_usermeta_table} WHERE user_id = l.assigned_to AND meta_key = 'last_name') AS assigned_to_last_name
            FROM {$this->table} l
            ";
        $result = $wpdb->get_results($query);
        $response = [];
        $response['result'] = $result;
        $response['error'] = $wpdb->last_error;
        $response['leads'] = array_map(function ($lead) {
            return new Lead($lead->id);
        }, $result);
        $response['recordsTotal'] = count($result);
        $response['recordsFiltered'] = count($result);
        $response['draw'] = $_POST['draw'] ?? $_GET['draw'] ?? 1;
        
        return $response;
    }

    public function assignLeads($user_id, $lead_ids) {
        
        global $wpdb;
        $updates = 0;
        
        foreach ($lead_ids as $lead_id) {
            $query = "UPDATE {$this->table} SET assigned_to = {$user_id} WHERE id = {$lead_id}";
            $result = $wpdb->query($query);
            $updates += $result;
        }

        $query = $wpdb->last_query;
        

        if ($result > 0) {
            $response['success'] = true;
            $response['message'] = $result . ' Leads assigned successfully';
        } else {
            $response['success'] = true;
            $response['message'] = 'No Leads assigned';
        }

        $response['error'] = $wpdb->last_error;
        $response['query'] = $query;
        $response['updates'] = $updates;

        return $response;
    }

    public function getAssignedAgentPhone() {
        $assigned_to = $this->assigned_to;
        
        // get 'agent_phone' meta key for this user ID
        $agent_phone = get_user_meta($assigned_to, 'agent_phone', true);
        return $agent_phone;
    }


}
