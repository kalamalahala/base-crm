import _default from "@popperjs/core/lib/modifiers/popperOffsets";

const $ = jQuery;

const ajaxUrl = base_crm.ajax_url;
const ajaxNonce = base_crm.ajax_nonce;
const ajaxAction = base_crm.ajax_action;
const ajaxMethod = "get_leads_for_admin";
const dtUrlString =
    ajaxUrl +
    "?action=" +
    ajaxAction +
    "&method=" +
    ajaxMethod +
    "&nonce=" +
    ajaxNonce;

export const adminTable = () => {
    jQuery("#admin-table").DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: dtUrlString,
            type: "GET",
            dataSrc: function (json) {
                console.log(base_crm.user_names);
                return json.leads;
            },
        },
        columns: [
            {
                // select checkbox
                data: "id",
                render: function (data, type, row, meta) {
                    return "";
                },
            },
            {
                data: "first_name",
                render: function (data, type, row, meta) {
                    return `${row.first_name} ${row.last_name}`;
                },
            },
            {
                data: "phone",
                render: function (data, type, row, meta) {
                    return `<a href="tel:${row.phone}">${row.phone}</a>`;
                },
            },
            {
                data: "email",
                render: function (data, type, row, meta) {
                    return `<a href="mailto:${row.email}">${row.email}</a>`;
                },
            },
            {
                data: "lead_source",
                render: function (data, type, row, meta) {
                    return row.lead_source;
                },
            },
            {
                data: "created_at",
                render: DataTable.render.datetime(),
            },
            {
                data: "assigned_to",
                render: function (data, type, row, meta) {
                    return base_crm.user_names[row.assigned_to];
                },
            },
            {
                data: "lead_disposition",
                render: function (data, type, row, meta) {
                    return row.lead_disposition;
                },
            },
            {
                data: "id",
                render: function (data, type, row, meta) {
                    return `<a href="/base/leads/${row.id}" class="btn btn-primary btn-sm">View</a>`;
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
        order: [[5, "desc"]],
        buttons: [
            {
                extend: "collection",
                text: "Export",
                buttons: ["copy", "csv", "excel", "pdf"],
            },
            {
                extend: "selectAll",
                text: "Select All",
            },
            {
                extend: "selectNone",
                text: "Select None",
            },
            "refresh",
        ],
        paging: true,
        pageLength: 100,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"],
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                className: "select-checkbox",
            },
        ],
        select: {
            style: "os",
            selector: "td:first-child",
        },
    });

    // remove loading overlay on dt.init
    $("#admin-table").on("init.dt", function () {
        $(".admin-table-loading-overlay").addClass("d-none");
    });

    $("#admin-table").on("draw.dt", function () {
        $(".admin-table-loading-overlay").addClass("d-none");
    });

    // add filter toggle button
    $(".filter-toggle").html(
        `<div><input type="checkbox" class="form-check-input" id="dt-filter-toggle"><label class="form-check-label" for="dt-filter-toggle">&nbsp;Show DNC / Not Interested</label></div>`,
    );

    $("#dt-filter-toggle").on("change", function () {
        $("#admin-table").DataTable().draw();
    });

    $('.leads-submit').on('click', function(e) {
        e.preventDefault();
        let agent = $('#assignTo').val();
        if (isNaN(agent)) { return; }

        let selected = $('#admin-table').DataTable().rows({selected: true}).data();
        if (selected.length < 1) { return; }
        
        let selectedIds = [];
        selected.each(function (value, index) {
            selectedIds.push(value.id);
        });
        
        let submitButton = $(this);
        let currentText = submitButton.text();
        submitButton.text('Assigning...').prop('disabled', true);

        let data = {
            'agent': agent,
            'leads': selectedIds,
            'action': ajaxAction,
            'nonce': ajaxNonce,
            'method': 'assign_leads'
        };

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: data,
            success: function (response) {
                if (response.success) {
                    $('#admin-table').DataTable().ajax.reload();
                    $('#assignTo').val('');
                    submitButton.text(currentText).prop('disabled', false); 
                }
            },
            error: function (response) {
                console.log(response);
                submitButton.text(currentText).prop('disabled', false);
            },
        });
            
        return;
    });
};
if (base_crm.current_page === "/base/settings/") {
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
