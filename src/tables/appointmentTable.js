import _default from "@popperjs/core/lib/modifiers/popperOffsets";
import { setLoadingOverlay } from "../utils/setLoadingOverlay";

const $ = jQuery;

const ajaxUrl = base_crm.ajax_url;
const ajaxNonce = base_crm.ajax_nonce;
const ajaxAction = base_crm.ajax_action;
const ajaxMethod = "get_appointments_for_user";
const dtUrlString =
    ajaxUrl +
    "?action=" +
    ajaxAction +
    "&method=" +
    ajaxMethod +
    "&nonce=" +
    ajaxNonce;

export const appointmentTable = () => {
    $("#appointment-table").DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: dtUrlString,
            type: "GET",
            dataSrc: "",
            // dataSrc: function (json) {
            //     return json.appointments;
            // },
        },
        columns: [
            { data: "appointment_created_at", render: DataTable.render.datetime() },
            {
                data: "appointment_date",
            },
            { data: "lead_name" },
            { data: "appointment_type" },
            { data: "lead_phone" },
            {
                data: "appointment_id",
                render: function (data, type, row, meta) {
                    if (base_crm.is_admin == 1) {
                        var deleteButton = `
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item base-crm-delete-appointment" href="#" data-id="${row.appointment_id}"><i class="fa-regular fa-trash-can"></i> Delete appointment</a></li>
                        `;
                    } else {
                        var deleteButton = "";
                    }

                    return (
                        `
                        <div class="dropstart">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">Appointment Actions</li>
                                <li><a class="dropdown-item base-crm-begin-presentation" href="#" data-id="${row.appointment_id}" data-lead-id="${row.lead_id}" data-fn="${row.first_name}" data-ln="${row.last_name}" data-e="${row.email}" data-p="${row.phone}"><i class="fa-regular fa-paper-plane"></i> Begin Presentation</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item disabled base-crm-view-appointment" href="#" data-id="${row.appointment_id}" data-lead-id="${row.lead_id}"><i class="fa-regular fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item disabled base-crm-edit-appointment" href="#" data-id="${row.appointment_id}" data-lead-id="${row.lead_id}"><i class="fa-regular fa-pen-to-square"></i> Edit</a></li>` +
                        deleteButton +
                        `</ul></div>`
                    );
                },
            },
        ],
        dom:
            "<'row'<'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
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
    $("#appointment-table").on("init.dt", function () {
        setLoadingOverlay("", false);
    });

    $("#appointment-table").on("draw.dt", function () {
        setLoadingOverlay("", false);
    });

    $("#dt-filter-toggle").on("change", function () {
        $("#appointment-table").DataTable().draw();
    });

$.fn.DataTable.ext.buttons.refresh = {
    text: "Refresh",
    action: function (e, dt, node, config) {
        dt.clear().draw();
        dt.ajax.reload();
    },
};
};

