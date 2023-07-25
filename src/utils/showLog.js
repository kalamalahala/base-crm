// noinspection JSUnresolvedReference

export function showLogModal() {
    jQuery(document).ready(function () {
        jQuery(".log-modal-launcher").on('click', function (e) {
            e.preventDefault();
                jQuery.ajax(
                    {
                        url: base_crm.rest_url + 'basecrm/v1/print_log',
                        type: 'GET',
                        success: function (response) {
                            jQuery('#modal-debug-log-body').html(lineItemPrint(response));
                            jQuery('#modal-debug-log').modal('show');
                        },
                        error: function () {
                            console.log('error');
                        }
                    }
                );
            }
        );

        jQuery('.clear-log-contents').on('click', function (e) {
            e.preventDefault();
            jQuery.ajax(
                {
                    url: base_crm.rest_url + 'basecrm/v1/clear_log',
                    type: 'GET',
                    success: function (response) {
                        if (!response) {
                            jQuery('#modal-debug-log-body').html('Log contents cleared.');
                        } else {
                            jQuery('#modal-debug-log-body').html('Error clearing log contents.');
                        }
                    },
                    error: function () {
                        console.log('error');
                    }
                }
            );
        });

        jQuery('.get-log-contents').on('click', function (e) {
            e.preventDefault();
            jQuery.ajax(
                {
                    url: base_crm.rest_url + 'basecrm/v1/print_log',
                    type: 'GET',
                    success: function (response) {
                        jQuery('#modal-debug-log-body').html(lineItemPrint(response));
                    },
                    error: function () {
                        console.log('error');
                    }
                }
            );
        });
    });
}

function lineItemPrint(logContents) {
    if (logContents.length === 0) {
        return 'No log contents.';
    }
    let response = '';
    logContents.forEach(function (item) {
        response += item + '<br>';
    })

    return response;
}