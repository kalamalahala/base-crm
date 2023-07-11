import {pendButton} from "./ajaxTestingZone";

const $ = jQuery;
export function getNeedsAnalysis(e) {
    e.preventDefault();
    console.log('clicked ' + e.target);
    console.log('data: ', e.target.dataset);
    let leadId = $(e.target).data('id')
    let formId = base_crm.na_form_id;
    let gkId = base_crm.gview_id;
    console.log(`leadId: ${leadId}, formId: ${formId}, gkId: ${gkId}`);

    // query gravityforms rest api for most recent entry where field 18 (lead_id) matches leadId
    let gfEndpoint = 'gf/v2/entries?form_ids[0]=' + formId + 'search={"field_filters":[{"key":"18","value":"' + leadId + '"}]}';

    // ajax GET to WordPress rest endpoint using wpApiSettings object
    $.ajax({
        url: wpApiSettings.root + gfEndpoint,
        method: 'GET',
        beforeSend: (xhr) => {
            xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce)
            console.log('URL: ' + wpApiSettings.root + gfEndpoint);
            $('#modal-client-info-body').html('Fetching Needs Analysis ...');
            $('#modal-client-info').modal('show');
        },
        success: (response) => {
            console.log(response);
            let entryId = response.entries[0].id;
            console.log('success, entry id: ' + entryId);

            let gravityKitEndpoint = `gravityview/v1/views/${gkId}/entries/${entryId}.html`;
            $.ajax({
                url: wpApiSettings.root + gravityKitEndpoint,
                method: 'GET',
                beforeSend: (xhr) => {
                    xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                    console.log('GET URL: ' + wpApiSettings.root + gravityKitEndpoint);
                    $('#modal-client-info-body').html('Fetching Needs Analysis Entry ...');
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