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
        // GF Rest endpoint /wp-json/gf/v2/entries/?_labels=1&form_ids[0]=114&search={"field_filters":[{"key":"18","value":"${id}","operator":"is"}]}

        // console.log( rest_settings );

        /*
        $.ajax({
            url: `/wp-json/basecrm/v1/client/?lead_id=${id}`,
            type: 'GET',
            beforeSend: (xhr) => {
              xhr.setRequestHeader('X-WP-Nonce', base_crm.rest_nonce);
            },
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
        */

        $.get(`/wp-json/gf/v2/entries/?_labels=1&form_ids[0]=114&search={"field_filters":[{"key":"18","value":"${id}","operator":"is"}]}`, (data) => {
                $('#modal-client-info-name').html(name);
                console.log(data);
                let html = '';
                // console.log(data.entries);
                if (data.entries.length > 0) {
                    html += parseGFEntry(data.entries[0])
                } else {
                    html += '<p>No client information found.</p>';
                }

                $('#modal-client-info-body').html(html);
                $('#modal-client-info').modal('show');
        });


        // $.get(`/wp-json/basecrm/v1/client/?lead_id=${id}`, (data) => {
        // });


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
// example JSON
/*
{
    "total_count": 1,
    "entries": [
        {
            "id": "54135",
            "form_id": "114",
            "post_id": null,
            "date_created": "2023-06-30 15:33:45",
            "date_updated": "2023-06-30 15:33:45",
            "is_starred": "0",
            "is_read": "0",
            "ip": "127.0.0.1",
            "source_url": "http:\/\/migrate-test.local\/?gf_page=preview&id=114&crm_id=7",
            "user_agent": "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/114.0.0.0 Safari\/537.36",
            "currency": "USD",
            "payment_status": null,
            "payment_date": null,
            "payment_amount": null,
            "payment_method": null,
            "transaction_id": null,
            "is_fulfilled": null,
            "created_by": "1",
            "transaction_type": null,
            "status": "active",
            "18": "7",
            "3.1": "Cost of Living",
            "3.2": "Final Expense",
            "3.3": "Head Start",
            "3.4": "Mortgage Protection",
            "3.5": "Income Protection",
            "3.6": "Children's Education",
            "4": "Yes",
            "5": "Yes",
            "6": "Yes",
            "20.3": "Carleus",
            "20.6": "Johnson",
            "21": "1985-05-15",
            "22": "No",
            "9": "notes",
            "24.3": "Spouse",
            "24.6": "Johnson",
            "25": "1966-02-15",
            "26": "No",
            "27": "more notes",
            "28": [
                {
                    "Child Name": "Child",
                    "Date of Birth (YYYY\/MM\/DD)": "1999\/09\/19"
                },
                {
                    "Child Name": "Child 2",
                    "Date of Birth (YYYY\/MM\/DD)": "2023\/06\/30"
                }
            ],
            "10": "more notes!!!",
            "29": "Globe Life",
            "30": "125000",
            "31": "Annual Salary",
            "32": "500000",
            "33": "Own",
            "34": "12000",
            "14": "list existing policies here and even more notes",
            "15": "list all medical conditions here",
            "37": [
                {
                    "Who takes this?": "carleus",
                    "Medication Name": "medication 1",
                    "Dosage Amount": "5mg"
                }
            ],
            "38": [
                {
                    "Name": "Carleus",
                    "Height (ft. in.)": "5f 10in",
                    "Weight (lbs.)": "250"
                }
            ],
            "7": "",
            "19": "",
            "20.2": "",
            "20.4": "",
            "20.8": "",
            "24.2": "",
            "24.4": "",
            "24.8": "",
            "35": "",
            "36": "",
            "gpnf_entry_parent": false,
            "gpnf_entry_parent_form": false,
            "gpnf_entry_nested_form_field": false,
            "_labels": {
                "18": "Base CRM Lead Id",
                "3": {
                    "3": "Do you currently have any of the following protections?",
                    "3.1": "<strong>Cost of Living<\/strong> <small><mark>(covers the cost of life for your family in the event that you pass unexpectly)<\/mark><\/small>",
                    "3.2": "<strong>Final Expense<\/strong> <small><mark>(covers the cost of funeral services when you pass away)<\/mark><\/small>",
                    "3.3": "<strong>Head Start<\/strong> <small><mark>(both pays you money if heaven forbid your child were to pass prematurely, while also building cash value that your child could benefit from later in life)<\/mark><\/small>",
                    "3.4": "<strong>Mortgage Protection<\/strong> <small><mark>(pay off the balance of your mortgage ensuring that your family will keep a roof over their head if you're not here to do so)<\/mark><\/small>",
                    "3.5": "<strong>Income Protection<\/strong> <small><mark>(ensures that your family can count on your income for 2-5 years if you were to pass unexpectedly)<\/mark><\/small>",
                    "3.6": "<strong>Children's Education<\/strong> <small><mark>(covers the cost of your child's education if you were to pass away prematurely but also builds value that you can utilize to gift your child later in life)<\/mark><\/small>"
                },
                "4": "Have you started planning for retirement?",
                "5": "Do you have a policy that pays you money if you were to get hurt or sick?",
                "6": "Do you have a checking or savings account?",
                "7": "HTML Block",
                "19": "Client Information",
                "20": {
                    "20": "Primary Insured",
                    "20.2": "Prefix",
                    "20.3": "First",
                    "20.4": "Middle",
                    "20.6": "Last",
                    "20.8": "Suffix"
                },
                "21": "Date of Birth",
                "22": "Tobacco Use",
                "9": "Primary Insured Notes",
                "24": {
                    "24": "Spouse \/ Secondary Insured",
                    "24.2": "Prefix",
                    "24.3": "First",
                    "24.4": "Middle",
                    "24.6": "Last",
                    "24.8": "Suffix"
                },
                "25": "Spouse \/ Secondary Insured Date of Birth",
                "26": "Spouse \/ Secondary Insured Tobacco Use",
                "27": "Spouse \/ Secondary Insured Notes",
                "28": "Children \/ Grandchildren",
                "10": "Children \/ Grandchildren Notes",
                "35": "Financial Information & Insurance Policies",
                "29": "Where are you employed?",
                "30": "What is your pay?",
                "31": "How often?",
                "32": "Total Household Income",
                "33": "Do you own or rent?",
                "34": "How much is your Rent \/ Mortgage?",
                "14": "Do you have any existing insurance? (Whole life, term life, ADB, 401k, retirement)",
                "36": "Health Information",
                "15": "Do you have any medical conditions?",
                "37": "List any taken medications:",
                "38": "Insured Height & Weight"
            }
        }
    ]
}
 */

function parseGFEntry(entry) {
    // loop over entries array, print line with field label and value
    let html;
    html = '<div class="entry">';
    for (let label in entry._labels) {
        // if label is an object
        if (typeof entry._labels[label] === 'object') {
            // html += entryHTML(entry._labels[label]['3'], '');
            for (let subLabel in entry._labels[label]) {
                // if (subLabel !== '3') {
                    html += entryHTML(entry._labels[label][subLabel], entry[subLabel]);
        //         }
            }
            continue;
        }

        html += entryHTML(entry._labels[label], entry[label]);
    }
    html += '</div>';

    return html;
}

function entryHTML(label, value = '') {
    let entryLabel, entryValueHtml;
    if (value === '') {
        let entryValueHtml = '';
    } else {
        let entryValueHtml = `<span class="base-entry-value">${value}</span>`;
    }

    return `<div class="entry"><span class="base-entry-label">${label}</span><br /><small><span class="base-entry-value">${value}</span></small></div>`;
}


