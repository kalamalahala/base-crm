// noinspection JSUnusedGlobalSymbols

const $ = jQuery;

export function ajaxTestingZone() {
    $(document).ready(function () {
        $('#test-ajax').click(function () {
            $.ajax({
                type: "POST",
                url: base_crm.ajaxurl,
                data: {
                    action: 'base_crm_test_ajax',
                },
                success: function (response) {
                    console.log(response);
                }
            });
        });
    });
}