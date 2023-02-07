<?php

namespace BaseCRM\Ajax;

use BaseCRM\ServerSide\AjaxInterface;
use BaseCRM\ServerSide\Lead;
use BaseCRM\ServerSide\Appointment;
use BaseCRM\ServerSide\BaseEmailHandler;

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
     * @return void die()
     */
    public function base_crm_create_lead(): void
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


        $lead = new Lead($lead_id);
        $lead_types = $lead->lead_types();
        $lead_type = $lead_types[$_POST['script-select']];
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
            $this->json_response($results);
        }
        $this->json_response($results);
    }

    public function get_lead()
    {
        $lead_id = $_POST['lead_id'] ?? $_GET['lead_id'] ?? null;
        $lead = new Lead($lead_id);
        $this->json_response($lead);
    }


    public function add_referral()
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

    public function get_leads_for_admin()
    {
        $leads = new Lead();
        $leads = $leads->getLeadsForAdmin();
        $this->json_response($leads);
    }

    public function assign_leads()
    {
        $leads = new Lead();
        $lead_ids = $_POST['leads'];
        // $lead_id_string = implode(',', $lead_ids);
        // foreach ($lead_ids as $key => $lead_id) {
        //     $lead_ids[$key] = (int) $lead_id;
        // }
        $leads = $leads->assignLeads($_POST['agent'], $lead_ids);
        $this->json_response($leads);
    }

    public function vtp_contact()
    {
        $lead_id = $_POST['lead_id'] ?? $_GET['lead_id'] ?? null;
        if (!$lead_id) {
            $this->json_response(array('error' => 'Invalid lead id'), 400);
        }

        $lead = new Lead($lead_id);
        $update_data = [
            'date_last_contacted' => $lead->datetime_now('Y-m-d H:i:s'),
            'lead_disposition' => 'VTP Contacted',
            'lead_status' => 'Called',
        ];
        $update = $lead->wpdbUpdateLead($lead_id, $update_data);
        // $disp = $lead->dispositionLead($lead_id, 'VTP Contact');
        // $cont = $lead->updateProp('date_last_contacted', $lead->datetime_now('Y-m-d H:i:s'));

        $error = $update ? false : true;

        $this->json_response(array('success' => $error, 'lead' => $lead));
    }




    public function send_client_registration_email()
    {
        // init lead object
        $lead = new Lead($_POST['lead_id']);

        // exit if no lead id
        if (!$lead->id) {
            $this->json_response(array('error' => 'Invalid lead id'), 400);
        }

        // get email addresses
        $email_on_file = $lead->email;
        $specified_email = $_POST['lead-email'] ?? null;

        // if valid, update lead email if necessary, else return error
        if ($email_on_file !== $specified_email) {
            // if (filter_var($specified_email, FILTER_VALIDATE_EMAIL) === false) {
            //     $lead->updateLead($_POST['lead_id'], array('email' => $specified_email));
            // } else {
            //     $this->json_response(array('error' => 'Invalid email address'), 400);
            // }
            $lead->email = $specified_email;
        }

        $agent_phone = $lead->getAssignedAgentPhone();
        $tel_link = (!empty($agent_phone)) ?
            `<p>If you have any questions, please contact your Tax Professional at <a href="tel:$agent_phone" target="_blank" title="Call or Text Your Tax Professional">&#128241; $agent_phone </a></p>` :
            `<p>If you have any questions, please contact us as soon as possible by email or by phone.</p>`;

        $email = new BaseEmailHandler();

        $vtp_headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>',
            'Reply-To: ' . get_bloginfo('name') . ' <' . get_bloginfo('admin_email') . '>'
        );

        $body = <<<EMAIL
        <div style="font-family: 'Poppins', sans-serif; font-size: 12pt; color: #222222;">
            <p style="font-weight: bold;">Hi $lead->first_name,</p>
            <p>Thank you for choosing Virtual Tax Pro's to take care of your tax needs. Please click the link below to create your account and provide the necessary documentation to get your return completed quickly.</p>
            <p><a href="https://vtp.thejohnson.group/client-registration/?base=$lead->id" target="_blank" title="Complete your Registration">Complete Your Registration Here</a></p>
            <p>Thank you,</p>
            <p>Regards,</p>
            <p><img class="alignnone wp-image-2276" src="https://vtp.thejohnson.group/wp-content/uploads/2023/01/vtp_logo.png" alt="" width="130" height="69" /><br/>
            <span style="font-size: 10pt;">Email: <a href="info@vtp.thejohnson.group">info@vtp.thejohnson.group</a></span><br/>
            <span style="font-size: 10pt;">Phone: <a href="tel:+13863013703">(386) 301-3703</a></span></p>
        </div>
        EMAIL;

        $email->setHeaders($vtp_headers);
        $email->setTo($lead->email);
        $email->setSubject('Virtual Tax Pro Client Registration');
        $email->setMessageBody($body);

        $outgoing = $email->sendEmail();

        if ($outgoing) {
            $this->json_response(array('success' => true));
        } else {
            $this->json_response(array('error' => 'There was a problem sending the email'), 400);
        }
    }

    public function bulk_upload_leads()
    {
        // this is all built assuming this is a gravity forms export from
        // wcn form id 13

        // unstringify csvData
        $csvData = json_decode(stripslashes($_POST['csvData']));
        $leads_to_upload = array();
        foreach ($csvData as $key => $row) {
            $leads_to_upload[] = (array) $row;
        }

        // init lead object
        $lead = new Lead();
        $count = 0;
        $data = array();
        $errors = array();

        // loop through csvData and insert each row
        foreach ($leads_to_upload as $row) {
            // build lead data array
            $data['first_name'] = $row['Applicant Name (First)'];
            $data['last_name'] = $row['Applicant Name (Last)'];
            $data['email'] = $row['Client Email'];
            $data['phone'] = $row['Client Phone Number'];
            $data['date_last_appointment'] = $row['Entry Date'];
            $data['date_last_contacted'] = $row['Entry Date'];
            $data['lead_type'] = $row['Select Which No-Cost Offer Used'];
            $data['lead_disposition'] = 'After Appointment';
            $data['number_of_referrals_to_date'] = $row['Number of Referrals Collected'];
            $data['assigned_to'] = 0;
            $data['lead_notes'] = json_encode($row);

            $sale = $row['Was there a Sale?'];
            if ($sale === 'Yes') {
                $data['has_bank_account'] = 'Yes';
                $data['bank_account_type'] = 'Checking';
                $data['bank_account_number'] = $row['Account Number'];
                $data['bank_routing_number'] = $row['Routing Number'];
                $data['bank_name'] = $row['Bank Name'];
                $data['date_last_sale'] = $row['Entry Date'];
            }
            $data['lead_status'] = ($sale === 'Yes') ? 'Sold Policy' : 'Recent Appointment - No Sale';

            // insert lead
            $insert = $lead->processPost($data);

            // if insert was successful, increment count
            if (!is_array($insert)) {
                $count++;
            } else {
                $error = array(
                    'row' => $row,
                    'error' => $insert
                );
                $errors[] = $error;
            }
        }

        // return success message
        $this->json_response(array('success' => true, 'count' => $count, 'errors' => $errors));
    }

    public function add_epic_referral() {
        $lead = new Lead();

        $first_name = (isset($_POST['referral-first-name'])) ? $_POST['referral-first-name'] : '';
        $last_name = (isset($_POST['referral-last-name'])) ? $_POST['referral-last-name'] : '';
        $email = (isset($_POST['referral-email'])) ? $_POST['referral-email'] : '';
        $phone = (isset($_POST['referral-phone'])) ? $_POST['referral-phone'] : '';
        $lead_type = 'Manual Entry';
        $lead_disposition = '';
        $lead_status = '';

        $notes = array(
            'address' => [
                'street' => (isset($_POST['referral-street-address'])) ? $_POST['referral-street-address'] : '',
                'city' => (isset($_POST['referral-city'])) ? $_POST['referral-city'] : '',
                'state' => (isset($_POST['referral-state'])) ? $_POST['referral-state'] : '',
                'zip' => (isset($_POST['referral-zip'])) ? $_POST['referral-zip'] : '',
            ],
            'dob' => (isset($_POST['referral-dob'])) ? $_POST['referral-dob'] : '',
            'notes' => (isset($_POST['referral-notes'])) ? $_POST['referral-notes'] : '',
        );

        $data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'lead_type' => $lead_type,
            'lead_disposition' => $lead_disposition,
            'lead_status' => $lead_status,
            'lead_notes' => json_encode($notes),
        );

        $insert = $lead->processPost($data);

        if (is_array($insert)) {
            $this->json_response(array('error' => $insert), 400);
        } else {
            $this->json_response(array('success' => true, 'id' => $insert));
        }
    }
}
