export function baseEmailer() {
    let $ = jQuery;

    $(document).ready(function () {
        $(document).on('click', '#calendar-invite-form-submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: base_crm.ajax_url,
                method: 'POST',
                data: {
                    action: base_crm.ajax_action,
                    data: {},
                    nonce: base_crm.ajax_nonce,
                    method: 'base_email',
                    base_email: {
                        to: 'solo.driver.bob@gmail.com',
                        subject: 'Test Email',
                        message: 'This is a test email.',
                        attachments: '',
                    }
                },
                success: (response) => {
                    console.log(response);
                    console.log('success');
                },
                error: (error) => {
                    console.log(error);
                    console.log('error');
                }
            });
        });
    });
}