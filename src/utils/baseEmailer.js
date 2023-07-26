import {pendButton} from "./ajaxTestingZone";

export function baseEmailer() {
    let $ = jQuery;

    $(document).ready(function () {
        $('#calendar-invite-form').submit(function (e) {
            e.preventDefault();

            let emailInput = $('input[name="lead_email_address"]');
            emailInput.removeClass('is-invalid');

            if (emailInput.val() === '') {
                emailInput.addClass('is-invalid');
                return;
            }

            let submitButton = $(e.target).find('button[type="submit"]');
            let submitButtonText = submitButton.html();
            pendButton(submitButton, 'Sending...', 'start')


            let form = $(e.target).closest('form');
            let formData = form.serializeArray();

            let betterFormData = {};

            formData.forEach((field) => {
                betterFormData[field.name] = field.value;
            });

            $.ajax({
                url: base_crm.ajax_url,
                method: 'POST',
                data: {
                    action: base_crm.ajax_action,
                    data: betterFormData,
                    nonce: base_crm.ajax_nonce,
                    method: 'base_email',
                    base_email: {
                        deprecated: false
                    }
                },
                success: (response) => {
                    console.log(response);
                    alert('Appointment reminder email dispatched to ' + betterFormData.lead_email_address + '!');
                    $(this).trigger('reset');
                    $('#modal-calendar-invite').modal('hide');
                    $('#modal-call-lead').modal('hide');
                },
                error: (error) => {
                    console.log(error);
                    console.log('error');
                },
                complete: () => {
                    pendButton(submitButton, submitButtonText, 'end');
                }
            });
        });
    });
}