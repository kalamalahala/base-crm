// noinspection JSUnusedGlobalSymbols,JSUnresolvedReference
// import flatpickr from "flatpickr";

const $ = jQuery;

export function ajaxTestingZone() {
    $(document).ready(function () {
        $('#test-ajax').click(function () {
            // fetch endpoint https://migrate-test.local/wp-json/basecrm/v1/appointments
            const restURL = "http://migrate-test.local/wp-json/basecrm/v1/";
            const endpoint = "calendar-form";

            const agentId = base_crm.current_user_id;
            const leadId = $('#lead-id').val();

            $('#fetch-container').html('<div class="spinner-border" role="status"></div> Loading...');

            $.get(restURL + endpoint + '?agent_id=' + agentId + '&lead_id=' + leadId, function (data) {
                console.log(data);
                $('#fetch-container').html(data);
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
    });
}