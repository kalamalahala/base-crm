const $ = jQuery;
const ajaxUrl = base_crm.ajax_url;
const ajaxNonce = base_crm.ajax_nonce;
const ajaxAction = base_crm.ajax_action;

import { parsePhoneNumberWithError, ParseError } from "libphonenumber-js";
import * as EmailValidator from "email-validator";
import { validatePhoneField } from "./createLeadForm";
import "flatpickr";

export const referralsForm = () => {
    $('.referrals-form-container button[type="button"]').on("click", (e) => {
        e.preventDefault();

        let phoneValid = phoneField.hasClass("is-valid");

        if (!phoneValid) {
            return;
        }

        let referralsForm = $("#referrals-form");
        let referralsFormContainer = $(".referrals-form-container");
        let referralsFormButton = $(
            '.referrals-form-container button[type="button"].btn-whos-next',
        );
        let referralsFormButtonHTML = referralsFormButton.html();

        let debugOutput = $(".debug-output");

        referralsFormContainer.find(".alert").addClass("d-none");

        let referralData = referralsForm.serializeArray();
        // let referralData = new FormData(referralsForm[0]);

        // let userId = referralFormData[0].value;
        // let leadId = referralFormData[1].value;
        // let appointmentId = referralFormData[2].value;
        let referralFirstName = referralData[3].value;
        // let referralLastName = referralFormData[4].value;
        // let referralSpouseName = referralFormData[5].value;
        // let referralPhone = referralFormData[6].value;
        // let referralRelationship = referralFormData[7].value;

        let currentReferralCount = $(".referral-count-num").text();

        referralsFormButton.attr("disabled", true);
        referralsFormButton.text("Adding Referral...");

        // okay now build the actual form submission ajax request
        // submissionData.append("user_id", userId);
        // submissionData.append("lead_id", leadId);
        // submissionData.append("appointment_id", appointmentId);
        // submissionData.append("referral_first_name", referralFirstName);
        // submissionData.append("referral_last_name", referralLastName);
        // submissionData.append("referral_spouse_name", referralSpouseName);
        // submissionData.append("referral_phone", referralPhone);
        // submissionData.append("referral_relationship", referralRelationship);
        
        
        let submissionData = new FormData();
        submissionData.append("action", ajaxAction);
        submissionData.append("nonce", ajaxNonce);
        submissionData.append("method", "add_epic_referral");
        
        // debugOutput.html(
        //     `<div class="alert alert-info" role="alert">referralFormData: ${referralData
        //         .map((item) => {
        //             submissionData.append(item.name, item.value);
        //             return `<div>${item.name}: ${item.value}</div>`;
        //         })
        //         .join("")}</div>`,
        // );
        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: submissionData,
            processData: false,
            contentType: false,
            success: (response) => {
                console.log(response);
                if (response.success === true) {
                    referralsForm.trigger("reset");
                    $(".referral-count-num").text(
                        parseInt(currentReferralCount) + 1,
                    );
                    referralsFormButton.html(referralsFormButtonHTML);
                    referralsFormButton.attr("disabled", false);
                    $('input[name="referral-first-name"]').focus();
                    $(".alert-first-name").text(referralFirstName);
                    $("#referral-success").removeClass("d-none");
                } else {
                    referralsFormButton.html(referralsFormButtonHTML);
                    referralsFormButton.attr("disabled", false);
                    $("#referral-error").removeClass("d-none");
                }
            },
            error: (error) => {
                console.log(error);
                referralsFormButton.html(referralsFormButtonHTML);
                referralsFormButton.attr("disabled", false);
                $("#referral-error").removeClass("d-none");
            },
        });
    });

    // referral validation
    // validate phone field
    const phoneField = $(
        '.referrals-form-container input[name="referral-phone"]',
    );
    const emailField = $(
        '.referrals-form-container input[name="referral-email"]',
    );
    const dobField = $("#referral-dob");

    phoneField.on("change", function () {
        let phone = phoneField.val();
        let validate = validatePhoneField(phone);

        if (validate instanceof ParseError) {
            phoneField.addClass("is-invalid");
            phoneField.removeClass("is-valid");

            switch (validate.message) {
                case "TOO_SHORT":
                    phoneField
                        .parent()
                        .siblings(".invalid-feedback")
                        .text("Phone number must be at least 10 digits.")
                        .show();
                    break;
                case "TOO_LONG":
                    phoneField
                        .parent()
                        .siblings(".invalid-feedback")
                        .text("Phone number must be no more than 15 digits.")
                        .show();
                    break;
                default:
                    phoneField
                        .parent()
                        .siblings(".invalid-feedback")
                        .text("Phone number is invalid.")
                        .show();
                    break;
            }
        } else {
            phoneField.removeClass("is-invalid");
            phoneField.addClass("is-valid");
            phoneField.parent().siblings(".invalid-feedback").text("").hide();

            phoneField.val(validate);
        }
    });

    // validate email field
    emailField.on("change", function () {
        console.log("email changed");
        let email = emailField.val();
        let validate = EmailValidator.validate(email);

        if (validate) {
            emailField.removeClass("is-invalid");
            emailField.addClass("is-valid");
            emailField.parent().siblings(".invalid-feedback").text("").hide();
        } else {
            emailField.addClass("is-invalid");
            emailField.removeClass("is-valid");
            emailField
                .parent()
                .siblings(".invalid-feedback")
                .text("Entered email is invalid.")
                .show();
        }
    });

    dobField.flatpickr();
};
