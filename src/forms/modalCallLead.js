import { booleanYesNo } from "../utils/booleanYesNo";
import flatpickr from "flatpickr";

const $ = jQuery;
const ajaxUrl = base_crm.ajax_url;
const ajaxNonce = base_crm.ajax_nonce;
const ajaxAction = base_crm.ajax_action;
const scriptList = base_crm.script_list;
const scriptListArray = Object.keys(scriptList);

const modal = $("#modal-call-lead");
const leadFirstNameSpan = $(".lead-first-name");
const leadLastNameSpan = $(".lead-last-name");
const leadRelationshipSpan = $(".lead-relationship");
const leadReferredBySpan = $(".lead-referred-by");
const leadFirstNameField = $("#lead-first-name");
const leadLastNameField = $("#lead-last-name");
const leadPhoneField = $("#lead-phone");
const leadEmailField = $("#lead-email");
const leadTypeField = $("#lead-type");
const leadSpouseFirstNameField = $("#lead-spouse-first-name");
const leadIsMarriedFieldYes = $("#lead-is-married-yes");
const leadIsMarriedFieldNo = $("#lead-is-married-no");
const leadIsEmployedFieldYes = $("#lead-is-employed-yes");
const leadIsEmployedFieldNo = $("#lead-is-employed-no");
const leadHasChildrenFieldYes = $("#lead-has-children-yes");
const leadHasChildrenFieldNo = $("#lead-has-children-no");
const leadNumChildrenField = $("#lead-num-children");
const leadIdField = $("#lead-id");
const scriptSelect = $("#script-select");
const rebuttalsRadio = modal.find('input[name="lead-has-rebuttals"]');
const marriedRadio = modal.find('input[name="lead-is-married"]');
const childrenRadio = modal.find('input[name="lead-has-children"]');
const employedRadio = modal.find('input[name="lead-is-employed"]');

const submitButton = $("#call-lead-submit");
const submitButtonHTML = submitButton.html();

export const callLeadModalHandler = () => {
    $("#script-select").on("change", function () {
        let scriptId = $(this).val();
        console.log(scriptId);
        if (scriptId !== "Select a Script") {
            $(".employment-question").removeClass("d-none");
            $(".rebuttals-question").removeClass("d-none");
        } else {
            $(".employment-question").addClass("d-none");
            $(".rebuttals-question").addClass("d-none");
        }

        showScriptHideOthers(scriptId);
    });

    rebuttalsRadio.on("change", function () {
        let hasRebuttals = $(this).val();
        if (hasRebuttals === "Yes") {
            $("#rebuttals-container").removeClass("d-none");
        } else {
            $("#rebuttals-container").addClass("d-none");
        }
    });

    marriedRadio.on("change", function () {
        let isMarried = $(this).val();
        if (isMarried === "Yes") {
            showMarriedFields();
        } else {
            hideMarriedFields();
        }
    });

    childrenRadio.on("change", function () {
        let hasChildren = $(this).val();
        if (hasChildren === "Yes") {
            showChildrenFields();
        } else {
            hideChildrenFields();
        }
    });

    $("#call-lead-form").on("submit", function (e) {
        e.preventDefault();
        let form = $(this);
        let formData = form.serialize();
        let crmId = $("#crm-id").val();

        let formDataObject = new FormData(form[0]);
        formDataObject.append("action", ajaxAction);
        formDataObject.append("nonce", ajaxNonce);
        formDataObject.append("method", "call_lead");

        // disable the submit button
        submitButton.prop("disabled", true);
        submitButton.html(
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Scheduling Appointment...',
        );

        // send the form data to the server
        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: formDataObject,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                // close the modal
                modal.modal("hide");
                // open the call clinic in a new window, passing the form data
                window.open(
                    `https://thejohnson.group/agent-portal/needs-analysis-questionnarie/?crm_id=${crmId}&close_on_submit=true&` +
                        formData,
                    "_blank",
                );
            },
            error: function (error) {
                console.log(error);
            },
            complete: function () {
                // enable the submit button
                submitButton.prop("disabled", false);
                submitButton.html(submitButtonHTML);
            },
        });
    });

    $(document).on('shown.bs.modal', '#modal-call-lead', function () {
        // set the date picker
        const dateTimeField = $("#lead-appointment-date");
        console.log(dateTimeField);
        dateTimeField.flatpickr({
            static: false,
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            minDate: "today",
            time_24hr: false,
            altInput: true,
            altFormat: "F j, Y \\a\\t h:i K",
            minuteIncrement: 30,
        });

        // console.log (pickr);
    });
};

export const populateScriptFields = (dataObject) => {
    console.log(dataObject);

    jQuery("#crm-id").val(dataObject.id);
    leadIdField.val(dataObject.id);
    leadFirstNameSpan.text(dataObject.first_name);
    leadLastNameSpan.text(dataObject.last_name);
    leadRelationshipSpan.text(dataObject.lead_relationship);
    leadReferredBySpan.text(dataObject.lead_referred_by);
    leadFirstNameField.val(dataObject.first_name);
    leadLastNameField.val(dataObject.last_name);
    leadPhoneField.val(dataObject.phone);
    leadEmailField.val(dataObject.email);
    leadTypeField.val(dataObject.lead_type);
    leadSpouseFirstNameField.val(dataObject.spouse_first_name);

    if (dataObject.num_children === null || dataObject.num_children === "" || dataObject.num_children === 0 || dataObject.num_children === "0" || dataObject.num_children === "null" || dataObject.num_children === "undefined" || dataObject.num_children === undefined) {
        leadNumChildrenField.val(0);
    } else {
        leadNumChildrenField.val(dataObject.num_children);
    }

    // set the radio buttons
    if (booleanYesNo(dataObject.is_married) === "Yes") {
        leadIsMarriedFieldYes.prop("checked", true);
        showMarriedFields();
    } else {
        leadIsMarriedFieldNo.prop("checked", true);
        hideMarriedFields();
    }

    if (booleanYesNo(dataObject.is_employed) === "Yes") {
        leadIsEmployedFieldYes.prop("checked", true);
    } else {
        leadIsEmployedFieldNo.prop("checked", true);
    }

    if (booleanYesNo(dataObject.has_children) === "Yes") {
        leadHasChildrenFieldYes.prop("checked", true);
        showChildrenFields();
    } else {
        leadHasChildrenFieldNo.prop("checked", true);
        hideChildrenFields();
    }

    // select the script that matches the lead type
    scriptSelect.val(dataObject.lead_type);
    showScriptHideOthers(dataObject.lead_type);

    if (dataObject.lead_type !== "cskw") {
        $(".employment-question").removeClass("d-none");
    }
    $(".rebuttals-question").removeClass("d-none");

    $("#modal-call-lead").modal("show");
};

/**
 * Show the selected script and hide all others
 *
 * @param {string} scriptId
 */
const showScriptHideOthers = (scriptId) => {
    let scriptContainer = $("#" + scriptId + "-script-container");
    scriptContainer.removeClass("d-none");
    $(scriptListArray).each(function (index, value) {
        if (value !== scriptId) {
            $("#" + value + "-script-container").addClass("d-none");
        }
    });

    // if the script is cskw, hide the employment question
    if (scriptId === "cskw") {
        $(".employment-question").addClass("d-none");
    } else {
        $(".employment-question").removeClass("d-none");
    }
};

const showMarriedFields = () => {
    $("#married-col").removeClass("col-12");
    $("#married-col").addClass("col-md-6");
    $("#married-col-2").removeClass("d-none");
    $("#married-col-2").find("input").prop("disabled", false);
};

const hideMarriedFields = () => {
    $("#married-col").addClass("col-12");
    $("#married-col").removeClass("col-md-6");
    $("#married-col-2").addClass("d-none");
    $("#married-col-2").find("input").prop("disabled", true);
};

const showChildrenFields = () => {
    $("#children-col").removeClass("col-12");
    $("#children-col").addClass("col-md-6");
    $("#children-col-2").removeClass("d-none");
    $("#children-col-2").find("input").prop("disabled", false);
};

const hideChildrenFields = () => {
    $("#children-col").addClass("col-12");
    $("#children-col").removeClass("col-md-6");
    $("#children-col-2").addClass("d-none");
    $("#children-col-2").find("input").prop("disabled", true);
};
