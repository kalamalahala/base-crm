const $ = jQuery;

const ajaxUrl = base_crm.ajax_url;
const ajaxNonce = base_crm.ajax_nonce;
const ajaxAction = base_crm.ajax_action;
const ajaxMethod = "get_leads_for_user";
const dtUrlString =
    ajaxUrl +
    "?action=" +
    ajaxAction +
    "&method=" +
    ajaxMethod +
    "&nonce=" +
    ajaxNonce;

export const clientsTable = () => {
    jQuery("#clients-table").DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: dtUrlString,
            type: "GET",
            dataSrc: function (json) {
                return json.leads;
            },
        },
        columns: [
            { data: "updated_at", render: DataTable.render.datetime() },
            {
                data: "first_name",
                render: function (data, type, row, meta) {
                    return `${row.first_name} ${row.last_name}`;
                },
            },
            { data: "phone" },
            { data: "lead_disposition" },
            { data: "date_last_contacted" },
            {
                data: "id",
                render: function (data, type, row, meta) {
                    if (base_crm.is_admin == 1) {
                        var deleteButton = `
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item base-crm-delete-lead" href="#" data-id="${row.id}"><i class="fa-regular fa-trash-can"></i> Delete Lead</a></li>
                        `;
                    } else {
                        var deleteButton = "";
                    }

                    return (
                        `
                        <div class="dropstart">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Lead Actions</li>
                                <li><a class="dropdown-item base-crm-call-lead" href="#"
                                data-id="${row.id}" 
                                data-first-name="${row.first_name}" 
                                data-last-name="${row.last_name}" 
                                data-phone="${row.phone}" 
                                data-email="${row.email}" 
                                data-lead-type="${row.lead_type}" 
                                data-lead-relationship="${row.lead_relationship}"
                                data-lead-referred-by="${row.lead_referred_by}"
                                data-is-married="${row.is_married}"
                                data-spouse-first-name="${row.spouse_first_name}"
                                data-is-employed="${row.is_employed}"
                                data-has-children="${row.has_children}"
                                data-num-children="${row.num_children}"
                                ><i class="fa-regular fa-paper-plane"></i> Begin Script - ${row.first_name}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item disabled base-crm-view-lead" href="#" data-id="${row.id}"><i class="fa-regular fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item disabled base-crm-edit-lead" href="#" data-id="${row.id}"><i class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li class="dropdown-header">Lead Disposition</li>
                                <li><a class="dropdown-item base-crm-disposition-lead" href="#" data-id="${row.id}" data-disposition="No Answer"><i class="fa-solid fa-phone-slash"></i> No Answer</a></li>
                                <li><a class="dropdown-item base-crm-disposition-lead" href="#" data-id="${row.id}" data-disposition="Call Back"><i class="fa-solid fa-phone-volume"></i> Call Back</a></li>
                                <li><a class="dropdown-item base-crm-disposition-lead text-warning" href="#" data-id="${row.id}" data-disposition="Not Interested"><i class="fa-solid fa-xmark"></i> Not Interested</a></li>
                                <li><a class="dropdown-item base-crm-disposition-lead text-danger" href="#" data-id="${row.id}" data-disposition="Do Not Call"><i class="fa-solid fa-triangle-exclamation"></i> Do Not Call</a></li>` +
                        deleteButton +
                        `</ul></div>`
                    );
                },
            },
        ],
        createdRow: function (row, data, dataIndex) {
            if (data.lead_disposition == "Not Interested") {
                $(row).addClass("table-warning");
            }
            if (data.lead_disposition == "Do Not Call") {
                $(row).addClass("table-danger");
            }
        },
        dom:
            "<'row'<'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-3'i><'col-sm-12 col-md-3 filter-toggle d-flex justify-content-center my-2'><'col-sm-12 col-md-6'p>>",
        responsive: true, // responsive table
        order: [[1, "asc"]],
        buttons: ["copy", "csv", "excel", "pdf", "refresh"],
        paging: true,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"],
        ],
    });

    // remove loading overlay on dt.init
    $("#clients-table").on("init.dt", function () {
        $(".lead-table-loading-overlay").addClass("d-none");
    });

    $("#clients-table").on("draw.dt", function () {
        $(".lead-table-loading-overlay").addClass("d-none");
    });

    // add filter toggle button
    $(".filter-toggle").html(
        `<div><input type="checkbox" class="form-check-input" id="dt-filter-toggle"><label class="form-check-label" for="dt-filter-toggle">&nbsp;Show DNC / Not Interested</label></div>`,
    );

    $("#dt-filter-toggle").on("change", function () {
        $("#clients-table").DataTable().draw();
    });
};
if (base_crm.current_page === "/base/clients/") {
    $.fn.DataTable.ext.buttons.refresh = {
        text: "Refresh",
        action: function (e, dt, node, config) {
            dt.clear().draw();
            dt.ajax.reload();
        },
    };

    $.fn.DataTable.ext.search.push(function (settings, data, dataIndex) {
        var filterToggle = $("#dt-filter-toggle").prop("checked");
        var leadDisposition = data[4];
        if (!filterToggle) {
            if (
                leadDisposition == "Not Interested" ||
                leadDisposition == "Do Not Call"
            ) {
                return false;
            }
        }
        return true;
    });
}
