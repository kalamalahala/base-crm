import {pendButton} from "./ajaxTestingZone";

const $ = jQuery;
export function getNeedsAnalysis(e) {
    e.preventDefault();

    let leadId = $(e.target).data('id')
    let formId = base_crm.na_form_id;
    let gkId = base_crm.gview_id;
    let name = $(e.target).data('first-name') + ' ' + $(e.target).data('last-name');

    $('#modal-client-info-name').html(name);

    // query gravityforms rest api for most recent entry where field 18 (lead_id) matches leadId
    let gfEndpoint = 'gf/v2/entries?form_ids[0]=' + formId + 'search={"field_filters":[{"key":"18","value":"' + leadId + '"}]}';

    // ajax GET to WordPress rest endpoint using wpApiSettings object
    $.ajax({
        url: wpApiSettings.root + gfEndpoint,
        method: 'GET',
        beforeSend: (xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce)
            console.log('URL: ' + wpApiSettings.root + gfEndpoint);
            $('#modal-client-info-body').html(`
                <div class="spinner-border text-primary" role="status"></div>Searching for ${name}'s Needs Analysis Entry...
            `);
            $('#modal-client-info').modal('show');
        },
        success: (response) => {
            console.log(response);
            if (!response.entries.length) {
                $('#modal-client-info-body').html('No Needs Analysis Found');
                return;
            }
            let count = response.entries.length;
            let entryId = response.entries[0].id;
            console.log('success, entry id: ' + entryId);

            let gravityKitEndpoint = `gravityview/v1/views/${gkId}/entries/${entryId}?html`;
            $.ajax({
                url: wpApiSettings.root + gravityKitEndpoint,
                method: 'GET',
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                    $('#modal-client-info-body').html(`
                    <div class="spinner-border text-primary" role="status"></div>Found ${count} Needs Analysis Entries for ${name}. Fetching most recent entry...
                    `);
                },
                success: (response) => {
                    console.log(response);
                    console.log('success');
                    $('#modal-client-info-body').html(response);
                },
                error: (response) => {
                    console.log(response);
                    console.log('error');
                    $('#modal-client-info-body').html(response);
                },
            });
        },
        error: (response) => {
            console.log(response);
            console.log('error');
        },
    });
}