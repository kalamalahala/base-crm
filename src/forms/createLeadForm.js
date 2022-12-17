import { parsePhoneNumberWithError, ParseError } from "libphonenumber-js";
import * as EmailValidator from "email-validator";

const $ = jQuery;
const createLeadFormElement = $("#create-lead-form");
const firstNameField = $("#first-name-field");
const lastNameField = $("#last-name-field");
const emailField = $("#email-field");
const phoneField = $("#phone-field");
const isMarriedField = createLeadFormElement.find("input[name='is-married']");
const isMarriedYesField = $("#is-married-yes");
const isMarriedNoField = $("#is-married-no");
const spouseFirstNameField = $("#spouse-first-name-field");
const spouseLastNameField = $("#spouse-last-name-field");
const leadTypeField = $("#lead-type");

const spouseNameContainer = $("#spouse-name-container");
const leadNotesContainer = $("#lead-notes-container");

const successAlert = $("#create-lead-success");
const successAlertText = $("#create-lead-success-text");
const errorAlert = $("#create-lead-error");
const errorAlertText = $("#create-lead-error-text");
const validationAlert = $("#create-lead-validation");
const validationAlertText = $("#create-lead-validation-text");

const submitButton = $("#create-lead-btn");
const submitButtonHTML = submitButton.html();

const ajaxUrl = base_crm.ajax_url;
const ajaxAction = base_crm.ajax_action;
const ajaxNonce = base_crm.ajax_nonce;

export const createLeadForm = () => {
    $(document).on("submit", '#create-lead-form', function (e) {
        e.preventDefault();
        console.log("submitting form");
        // check for any elements with is-invalid class
        let invalidElements = $(this).find(".is-invalid");
        if (invalidElements.length > 0) {
            validationAlert.removeClass("d-none");
            validationAlertText.text("Please fix the errors in the form.");
            return;
        }


        // reset alerts
        successAlert.addClass("d-none");
        errorAlert.addClass("d-none");
        validationAlert.addClass("d-none");

        // disable submit button
        submitButton.prop("disabled", true);
        submitButton.html("<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Submitting...");

        // get form
        let form = $(this);
        handleSubmit(form);

        // refresh datatable
        let table = $("#lead-table").DataTable();
        table.clear().draw();
        table.ajax.reload();
    });

    // is married field
    isMarriedField.on("change", function () {
        if (isMarriedYesField.is(":checked")) {
            showAndEnable(spouseNameContainer);
            spouseLastNameField.val(lastNameField.val());
        } else {
            hideAndDisable(spouseNameContainer);
            spouseFirstNameField.val("");
        }
    });

    // lead type field
    leadTypeField.on("change", function () {
        if (leadTypeField.val() === "other") {
            showAndEnable(leadNotesContainer);
        } else {
            hideAndDisable(leadNotesContainer);
        }
    });

    // update spouse last name field when last name field changes, if is married is yes
    lastNameField.on("change", function () {
        if (isMarriedYesField.is(":checked")) {
            spouseLastNameField.val(lastNameField.val());
        }
    });

    // validate phone field
    phoneField.on("change", function () {
        let phone = phoneField.val();
        let validate = validatePhoneField(phone);
        
        if (validate instanceof ParseError) {
            phoneField.addClass("is-invalid");
            phoneField.removeClass("is-valid");

            switch (validate.message) {
                case "TOO_SHORT":
                    phoneField.siblings(".invalid-feedback").text('Phone number must be at least 10 digits.');
                    break;
                case "TOO_LONG":
                    phoneField.siblings(".invalid-feedback").text('Phone number must be no more than 15 digits.');
                    break;
                default:
                    phoneField.siblings(".invalid-feedback").text('Phone number is invalid.');
                    break;
            }
        } else {
            phoneField.removeClass("is-invalid");
            phoneField.addClass("is-valid");
            phoneField.siblings(".invalid-feedback").text("");

            phoneField.val(validate);
        }
    });

    // validate email field
    emailField.on("change", function () {
        let email = emailField.val();
        let validate = EmailValidator.validate(email);

        if (validate) {
            emailField.removeClass("is-invalid");
            emailField.addClass("is-valid");
            emailField.siblings(".invalid-feedback").text("");
        } else {
            emailField.addClass("is-invalid");
            emailField.removeClass("is-valid");
            emailField.siblings(".invalid-feedback").text("Email is invalid.");
        }
    });

    // clean up form when reset button is clicked
    $(document).on("click", "#create-lead-reset-btn", function (e) {
        e.preventDefault();
        resetForm(createLeadFormElement);
    });
};

const showAndEnable = (container) => {
    container.removeClass("d-none");
    container.find("input, textarea, select, button").prop("disabled", false);
};

const hideAndDisable = (container) => {
    container.addClass("d-none");
    container.find("input, textarea, select, button").prop("disabled", true);
};

const handleSubmit = (form) => {
    console.log("submitting form");
    let data = new FormData(form[0]);
    data.append("action", ajaxAction);
    data.append("nonce", ajaxNonce);
    data.append("method", "base_crm_create_lead");

    $.ajax({
        url: ajaxUrl,
        type: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function (response) {
            console.log(response);
            successAlert.removeClass("d-none");
            successAlertText.text(response.message);
        },
        error: function (error) {
            console.log(error);
            errorAlert.removeClass("d-none");
            errorAlertText.text(error.responseJSON.message);
        },
        complete: function () {
            console.log("complete");
            submitButton.prop("disabled", false);
            submitButton.html(submitButtonHTML);
        },
    });
};

const validatePhoneField = (phone) => {
    try {
        let formParsedNumber = parsePhoneNumberWithError(phone, {
            defaultCountry: "US",
            extract: false,
        });

        if (!formParsedNumber.isPossible()) {
            if (formParsedNumber.nationalNumber.length < 10) {
                let error = new ParseError(
                    "TOO_SHORT",
                    "Phone number is too short.",
                );
                return error;
            } else {
                let error = new ParseError(
                    "TOO_LONG",
                    "Phone number is too long.",
                );
                return error;
            }
        }

        let formattedNumber = formParsedNumber.formatNational();
        return formattedNumber;
    } catch (error) {
        if (error instanceof ParseError) {
            return error;
        } else {
            throw error;
        }
    }
};

const resetForm = (form) => {
    // reset alerts
    successAlert.addClass("d-none");
    errorAlert.addClass("d-none");
    validationAlert.addClass("d-none");

    // reset form
    form.trigger("reset");

    // reset fields
    phoneField.removeClass("is-invalid");
    phoneField.removeClass("is-valid");
    phoneField.siblings(".invalid-feedback").text("");

    emailField.removeClass("is-invalid");
    emailField.removeClass("is-valid");
    emailField.siblings(".invalid-feedback").text("");

    // reset containers
    hideAndDisable(spouseNameContainer);
    hideAndDisable(leadNotesContainer);
};
