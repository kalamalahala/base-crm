const $ = jQuery;
const ajaxUrl = base_crm.ajax_url;
const ajaxNonce = base_crm.ajax_nonce;
const ajaxAction = base_crm.ajax_action;

import { populateScriptFields } from "../forms/modalCallLead";

export const dtButtonListeners = () => {
    // View Lead
    $(document).on("click", ".base-crm-view-lead", function (e) {
        e.preventDefault();
        const leadId = $(this).data("id");
    });

    // Edit Lead
    $(document).on("click", ".base-crm-edit-lead", function (e) {
        e.preventDefault();
        const leadId = $(this).data("id");
    });

    // Delete Lead
    $(document).on("click", ".base-crm-delete-lead", function (e) {
        e.preventDefault();
        const ajaxMethod = "delete_lead";
        const leadId = $(this).data("id");
        const table = $(this).closest("table").DataTable();
        $('.loading-text').text('Deleting Lead...');
        $('.lead-table-loading-overlay').removeClass('d-none');

        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: {
                action: ajaxAction,
                method: ajaxMethod,
                lead_id: leadId,
                nonce: ajaxNonce,
            },
            complete: function (response) {
                table.ajax.reload();
            },
        });
    });

    // Call Lead
    $(document).on("click", ".base-crm-call-lead", function (e) {
        e.preventDefault();
        let data = {
            id: $(this).data("id"),
            first_name: $(this).data("first-name"),
            last_name: $(this).data("last-name"),
            phone: $(this).data("phone"),
            email: $(this).data("email"),
            lead_type: $(this).data("lead-type"),
            lead_relationship: $(this).data("lead-relationship"),
            lead_referred_by: $(this).data("lead-referred-by"),
            is_married: $(this).data("is-married"),
            spouse_first_name: $(this).data("spouse-first-name"),
            is_employed: $(this).data("is-employed"),
            has_children: $(this).data("has-children"),
            num_children: $(this).data("num-children"),
        };

        populateScriptFields(data);
    });

    // Disposition Lead
    $(document).on("click", ".base-crm-disposition-lead", function (e) {
        e.preventDefault();
        const leadId = $(this).data("id");
        const leadDisposition = $(this).data("disposition");
        const ajaxMethod = "disposition_lead";
        const table = $(this).closest("table").DataTable();
        $('.loading-text').text('Dispositioning Lead...');
        $('.lead-table-loading-overlay').removeClass('d-none');

        $.ajax({
            url: ajaxUrl,
            type: "POST",

            data: {
                action: ajaxAction,
                method: ajaxMethod,
                lead_id: leadId,
                lead_disposition: leadDisposition,
                nonce: ajaxNonce,
            },
            complete: function (response) {
                table.ajax.reload();
            }
        });
    });
};
