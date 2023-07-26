// noinspection JSUnresolvedReference

const $ = jQuery;

export function ajaxTestingZone() {
    $(document).ready(function () {
        $('.test-clicker').click((e) => {
            e.preventDefault();
            console.log('clicked');
            let button = $(e.target);
            let currentHtml = button.html();
            pendButton(button, 'Fetching...', 'start');

            let gkId = button.data('gk-id');
            let leadId = button.data('lead-id');
            let formId = button.data('form-id');

            // query gravityforms rest api for most recent entry where field 18 (lead_id) matches leadId
            let gfEndpoint = 'gf/v2/entries?form_ids[0]=' + formId + 'search={"field_filters":[{"key":"18","value":"' + leadId + '"}]}';

            // ajax GET to WordPress rest endpoint using wpApiSettings object
            $.ajax({
                url: wpApiSettings.root + gfEndpoint,
                method: 'GET',
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce)
                    console.log('URL: ' + wpApiSettings.root + gfEndpoint);
                },
                success: async (response) => {
                    button.html('Success!');
                    console.log(response);
                    let entryId = response.entries[0].id;
                    console.log('success, entry id: ' + entryId);

                    let gravityKitEndpoint = `gravityview/v1/views/${gkId}/entries/${entryId}.html`;
                    await $.ajax({
                        url: wpApiSettings.root + gravityKitEndpoint,
                        method: 'GET',
                        beforeSend: (xhr) => {
                            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                            console.log('URL: ' + wpApiSettings.root + gravityKitEndpoint);
                            pendButton(button, 'Fetching Entry ...', 'start')
                        },
                        success: (response) => {
                            console.log(response);
                            console.log('success');
                            $('.test-result').html(response);
                        },
                        error: (response) => {
                            console.log(response);
                            console.log('error');
                            $('.test-result').html(response);
                        },
                        complete: () => {
                            pendButton(button, currentHtml, 'end');
                        }
                    });
                },
                error: (response) => {
                    console.log(response);
                    console.log('error');
                },
            });
        });


        $('#test-ajax').click(function () {
            // fetch endpoint https://migrate-test.local/wp-json/basecrm/v1/appointments
            const restURL = "basecrm/v1/calendar-form";

            const agentId = base_crm.current_user_id;
            const leadId = $('#lead-id').val();

            $('#fetch-container').html('<div class="spinner-border" role="status"></div> Loading...');

            $.ajax({
                url: wpApiSettings.root + restURL + '?agent_id=' + agentId + '&lead_id=' + leadId,
                method: 'GET',
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce)
                },
                success: (response) => {
                    $('#fetch-container').html(response);
                    $('#calendar-datepicker').flatpickr({
                        static: false,
                        enableTime: true,
                        dateFormat: "Y-m-d H:i",
                        minDate: "today",
                        time_24hr: false,
                        altInput: true,
                        altFormat: "F j, Y \\a\\t h:i K",
                        minuteIncrement: 30,
                    });
                },
                error: (response) => {
                    $('#fetch-container').html(response.responseJSON);
                }
            });
            $('#modal-calendar-invite').removeClass('hide').modal('show');
        });

        $(document).on('submit', '#calendar-invite-form', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            const restURL = "http://migrate-test.local/wp-json/basecrm/v1/";
            const endpoint = "appointment/new";

            $.get(restURL + endpoint + '?' + formData, function (data) {
                console.log(data);
                $('#modal-calendar-invite').modal('hide');
            });
        });

        $(document).on('click', '#nonce-testing', (e) => {
            e.preventDefault();
            const nonce = wpApiSettings.nonce;
            const url = wpApiSettings.root + 'gf/v2/entries';

            $.ajax({
                url: url,
                method: 'GET',
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', nonce);
                },
                success: (response) => {
                    console.log(response);
                    console.log(`URL: ${url}`);
                    console.log('success');
                },
                error: (response) => {
                    console.log(response);
                    console.log(`URL: ${url}`);
                    console.log('error');
                },
            });
        });
    });
}

export function pendButton(button, message, mode) {
    if (mode === 'start') {
        button.html('<div class="spinner-border" role="status"></div> ' + message);
        button.prop('disabled', true);
    } else {
        button.html(message);
        button.prop('disabled', false);
    }

}