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
    ajaxNonce +
    "&is_client=1";

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
                                <li class="dropdown-header">Client Actions</li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item base-crm-view-client" href="#" data-id="${row.id}" data-first-name="${row.first_name}" data-last-name="${row.last_name}"><i class="fa-regular fa-eye"></i> View</a></li>
                                <li><a class="dropdown-item disabled base-crm-edit-lead" href="#" data-id="${row.id}" disabled><i class="fa-regular fa-pen-to-square"></i> Edit</a></li>
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

    // var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}};

    $(document).on('click', '.base-crm-view-client', (e) => {
        e.preventDefault();
        const id = $(e.currentTarget).data('id');
        const name = $(e.currentTarget).data('first-name') + ' ' + $(e.currentTarget).data('last-name');
        // REST endpoint /wp-json/basecrm/v1/client/?lead_id=id

        $.ajax({
            url: `/wp-json/basecrm/v1/client/?lead_id=${id}`,
            type: 'GET',
            success: (data, textStatus, jqXHR) => {
                $('#modal-client-info-name').html(name);
                $('#modal-client-info-body').html("<pre>" + JSON.stringify(data) + "</pre>");
                $('#modal-client-info').modal('show');
            }, error: (jqXHR, textStatus, errorThrown) => {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }, complete: (jqXHR, textStatus) => {
                console.log(jqXHR);
                console.log(textStatus);
            }
        });



        $.get(`/wp-json/basecrm/v1/client/?lead_id=${id}`, (data) => {
            $('#modal-client-info-name').html(name);



            $('#modal-client-info-body').html("<pre>" + JSON.stringify(data) + "</pre>");




            $('#modal-client-info').modal('show');
        });


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
