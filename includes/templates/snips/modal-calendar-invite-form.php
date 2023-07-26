<?php
/**
 * Modal Calendar Invite Form
 *
 * @package BaseCRM
 */

$agent_id = get_current_user_id();

?>

<div class="modal fade hide" id="modal-calendar-invite" tabindex="-1" role="dialog"
     aria-labelledby="modal-calendar-invite-title"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-calendar-invite-title"><i class="fa-regular fa-calendar"></i>&nbsp;Submit Calendar Invite</h3>
            </div>
            <div class="modal-body">
<!--                Bootstrap 5.2 form classes -->
                <form id="calendar-invite-form" action="" method="get">
                    <div id="fetch-container" style="width:100%;">
<!--Manually include form contents here to avoid issues with AJAX and WP_EDIT-->
                        <div class="row">
                            <div class="col">
                                <label for="appointment_date" class="form-label w-100">Select Appointment Date & Time
                                    <input type="text" name="appointment_date" value="2021-09-01" id="calendar-datepicker" class="form-control">
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="lead_email_address" class="form-label w-100">Enter Email Address
                                    <input type="text" name="lead_email_address" class="form-control" placeholder="email@email.com" />
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="appointment_notes" class="form-label w-100">Appointment Notes for Client
                                    <?php
                                    wp_editor('', 'appointment_email_contents', array(
                                        'textarea_name' => 'appointment_notes',
                                        'textarea_rows' => 5,
                                        'media_buttons' => false,
                                        'teeny' => true,
                                        'tinymce' => array(
                                            'toolbar1' => 'bold,italic,underline,separator,bullist,numlist,link,unlink,undo,redo',
                                            'toolbar2' => '',
                                            'toolbar3' => '',
                                        ),
                                        'quicktags' => array(
                                            'buttons' => 'strong,em,ul,ol,li,link,close',
                                        ),
                                    ));
                                    ?>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="reset" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                                <button type="submit" id="calendar-invite-form-submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                        <input type="hidden" name="agent_id" value="">
                        <input type="hidden" name="lead_id" value="">
                        <input type="hidden" name="appointment_type" value="">
                        <input type="hidden" name="lead_name" value="">
                        <input type="hidden" name="agent_name" value="">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

