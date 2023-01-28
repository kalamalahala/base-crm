import { Tab } from "bootstrap";
import { setVis } from "../utils/setVis";
import { yesNoFieldToBoolean } from "../utils/booleanYesNo";
import "jquery.repeater/jquery.repeater.min.js";
import { visHandle } from "../utils/visHandler";
import { scriptDollarAmount } from "../utils/scriptDollarAmount";
import { presentationFormHandler } from "../utils/presentationFormHandler";
import { parsePhoneNumberWithError, ParseError } from "libphonenumber-js";
import { validatePhoneField } from "./createLeadForm";
import * as EmailValidator from "email-validator";
const $ = jQuery;
const ajaxUrl = base_crm.ajax_url;
const ajaxNonce = base_crm.ajax_nonce;
const ajaxAction = base_crm.ajax_action;

export const presentationForm = () => {
    const presentationFormElement = $("#presentation-form");
    $(document).on("submit", "#presentation-form", function (e) {
        e.preventDefault();
        let doSubmit = confirm("Submit presentation form?");
        if (doSubmit) {
            // get First Name, Last Name, Phone, Email from form
            const fn = $("input[name='first-name']").val();
            const ln = $("input[name='last-name']").val();
            const ph = $("input[name='phone']").val();
            const em = $("input[name='email']").val();
            const rc = $('.referral-count-num').text();

            let ref = (rc > 0) ? 'y' : 'n';

            const params = {
                fn: fn,
                ln: ln,
                ph: ph,
                em: em,
                ref: ref,
                rc: (rc > 0) ? rc : null,
            };

            // redirect to: https://thejohnson.group/agent-portal/agent/reports/agent-wcn/?mode=create&cuid=null&agent_id=42215&redir=wcn with query string
            const baseUrl = new URL(
                "https://thejohnson.group/agent-portal/agent/reports/agent-wcn/",
            );
            const extraParams = {
                mode: "create",
                cuid: "null",
                redir: "wcn",
            };

            Object.keys(params).forEach((key) => {
                baseUrl.searchParams.append(key, params[key]);
            });

            Object.keys(extraParams).forEach((key) => {
                baseUrl.searchParams.append(key, extraParams[key]);
            });

            window.open(baseUrl, "_blank");

            // serialize form data into query string
            const formDataObject = $(this).serializeArray();
            presentationFormHandler(formDataObject);
            return;
        }
        return;
    });
    const beginPresentationButton = $("#presentation-script-select-button");

    $(".repeater").repeater({
        isFirstItemUndeletable: true,
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },
        ready: function (setIndexes) {},
    });

    // hidden variable fields
    const beginPill = $("#begin-pill");
    const stepOnePill = $("#step-one-pill");
    const stepTwoPill = $("#step-two-pill");
    const stepThreePill = $("#step-three-pill");
    const stepFourPill = $("#step-four-pill");
    const stepFivePill = $("#step-five-pill");
    const stepSixPill = $("#step-six-pill");
    const stepSevenPill = $("#step-seven-pill");

    const tabIdList = {
        begin: beginPill,
        stepOne: stepOnePill,
        stepTwo: stepTwoPill,
        stepThree: stepThreePill,
        stepFour: stepFourPill,
        stepFive: stepFivePill,
        stepSix: stepSixPill,
        stepSeven: stepSevenPill,
    };

    const nextButton = $("#next-button");
    const previousButton = $("#previous-button");

    const scriptSelect = $("#presentation-script-select");
    const scriptSelectOptions = $("#presentation-script-select option");
    const scriptSelectOptionArray = Array.from(scriptSelectOptions).map(
        (option) => {
            return option.value;
        },
    );
    const scriptSelectHelper = $("#scriptSelectHelper");

    // Plan Type Radio Buttons and Plan Groups Toggle
    const planTypeRadio = $("input[name='plan-type']");
    const planTypes = Array.from(planTypeRadio).map((radio) => {
        return radio.value;
    });

    planTypeRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        let selectedPlanType = planTypes.find((planType) => {
            return planType === selectedOption;
        });

        $(`#presentation-form .plan-group.${selectedPlanType}`).removeClass(
            "d-none",
        );
        $(`#presentation-form .plan-group.${selectedPlanType} input`).attr(
            "disabled",
            false,
        );

        let otherPlanTypes = planTypes.filter((planType) => {
            return planType !== selectedOption;
        });

        otherPlanTypes.forEach((planType) => {
            $(`#presentation-form .plan-group.${planType}`).addClass("d-none");
            $(`#presentation-form .plan-group.${planType} input`).attr(
                "disabled",
                true,
            );
        });
    });

    // Sales Plans Radio Buttons
    const finalExpenseRadio = $("input[name='final-expense']");
    const finalExpenseSpouseCoverageRadio = $(
        '#presentation-form input[name="spouse-final-expense"]',
    );

    const incomeProtectionRadio = $("input[name='income-protection']");
    const incomeProtectionSpouseCoverageRadio = $(
        '#presentation-form input[name="spouse-income-protection"]',
    );

    const mortgageProtectionRadio = $("input[name='mortgage-protection']");
    const mortgageProtectionSpouseCoverageRadio = $(
        '#presentation-form input[name="spouse-mortgage-protection"]',
    );

    const childrensEducationRadio = $("input[name='ce-protection']");
    const childrensEducationSpouseCoverageRadio = $(
        '#presentation-form input[name="spouse-ce-protection"]',
    );

    const alxFinalExpenseRadio = $("input[name='alx-final-expense']");
    const alxFinalExpenseSpouseCoverageRadio = $(
        '#presentation-form input[name="spouse-alx-final-expense"]',
    );

    const alxHeadStartFinalExpenseRadio = $(
        "input[name='alx-head-start-final-expense']",
    );
    const alxHeadStartFinalExpenseSpouseCoverageRadio = $(
        '#presentation-form input[name="spouse-alx-head-start-final-expense"]',
    );

    // Any input field with a name containing "amount"
    const amountFields = $('#presentation-form input[name*="amount"]');
    amountFields.on("change", (e) => {
        let selectedInput = e.target;
        let selectedValue = selectedInput.value;
        let targetedScript = $(selectedInput).data("script");
        if (targetedScript === undefined) {
            return;
        }
        let targetedScriptElement = $(`.${targetedScript}`);

        targetedScriptElement.text(scriptDollarAmount(selectedValue));
    });

    // Rebuttals radio inputs
    const rebuttalsRadio = $("input[name='has-rebuttals']");

    // Down Closing Radio
    const downClosingRadio = $("input[name='down-closing-radio']");

    // Final Expense
    finalExpenseRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        let selectedInput = e.target;
        visHandle(selectedInput);
        switch (selectedOption) {
            case "Yes":
                fieldsGroupToggle("final-expense", "enabled");
                $("#final-expense-child-row").addClass("d-none");
                $("#final-expense-child-rider-amount").attr("disabled", true);
                break;
            case "No":
                fieldsGroupToggle("final-expense", "disabled");
                $("#final-expense-child-row").addClass("d-none");
                $("#final-expense-child-rider-amount").attr("disabled", true);
                break;
            case "Yes w/ Child Rider":
                fieldsGroupToggle("final-expense", "enabled");
                $("#final-expense-child-row").removeClass("d-none");
                $("#final-expense-child-rider-amount").attr("disabled", false);
                break;
        }
    });

    finalExpenseSpouseCoverageRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        switch (selectedOption) {
            case "Yes":
                $("#presentation-form .spouse-final-expense-field").removeClass(
                    "d-none",
                );
                $("#presentation-form .spouse-final-expense-field input").attr(
                    "disabled",
                    false,
                );
                break;
            case "No":
                $("#presentation-form .spouse-final-expense-field").addClass(
                    "d-none",
                );
                $("#presentation-form .spouse-final-expense-field input").attr(
                    "disabled",
                    true,
                );
                break;
        }
    });

    // Income Protection
    incomeProtectionRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        let selectedInput = e.target;
        visHandle(selectedInput);
        switch (selectedOption) {
            case "Yes":
                fieldsGroupToggle("income-protection", "enabled");
                $("#income-protection-child-row").addClass("d-none");
                $("#income-protection-child-rider-amount").attr(
                    "disabled",
                    true,
                );
                break;
            case "No":
                fieldsGroupToggle("income-protection", "disabled");
                $("#income-protection-child-row").addClass("d-none");
                $("#income-protection-child-rider-amount").attr(
                    "disabled",
                    true,
                );
                break;
            case "Yes w/ Child Rider":
                fieldsGroupToggle("income-protection", "enabled");
                $("#income-protection-child-row").removeClass("d-none");
                $("#income-protection-child-rider-amount").attr(
                    "disabled",
                    false,
                );
                break;
        }
    });

    incomeProtectionSpouseCoverageRadio.on("change", (e) => {
        let selectedOption = e.target.value;

        switch (selectedOption) {
            case "Yes":
                $(
                    "#presentation-form .spouse-income-protection-field",
                ).removeClass("d-none");
                $(
                    "#presentation-form .spouse-income-protection-field input",
                ).attr("disabled", false);
                break;
            case "No":
                $(
                    "#presentation-form .spouse-income-protection-field",
                ).addClass("d-none");
                $(
                    "#presentation-form .spouse-income-protection-field input",
                ).attr("disabled", true);
                break;
        }
    });

    // Mortgage Protection
    mortgageProtectionRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        let selectedInput = e.target;
        visHandle(selectedInput);
        switch (selectedOption) {
            case "Yes":
                fieldsGroupToggle("mortgage-protection", "enabled");
                $("#mortgage-protection-child-row").addClass("d-none");
                $("#mortgage-protection-child-rider-amount").attr(
                    "disabled",
                    true,
                );
                break;
            case "No":
                fieldsGroupToggle("mortgage-protection", "disabled");
                $("#mortgage-protection-child-row").addClass("d-none");
                $("#mortgage-protection-child-rider-amount").attr(
                    "disabled",
                    true,
                );
                break;
            case "Yes w/ Child Rider":
                fieldsGroupToggle("mortgage-protection", "enabled");
                $("#mortgage-protection-child-row").removeClass("d-none");
                $("#mortgage-protection-child-rider-amount").attr(
                    "disabled",
                    false,
                );
                break;
        }
    });

    mortgageProtectionSpouseCoverageRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        switch (selectedOption) {
            case "Yes":
                $(
                    "#presentation-form .spouse-mortgage-protection-field",
                ).removeClass("d-none");
                $(
                    "#presentation-form .spouse-mortgage-protection-field input",
                ).attr("disabled", false);
                break;
            case "No":
                $(
                    "#presentation-form .spouse-mortgage-protection-field",
                ).addClass("d-none");
                $(
                    "#presentation-form .spouse-mortgage-protection-field input",
                ).attr("disabled", true);
                break;
        }
    });

    // Children's Education Protection
    childrensEducationRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        let selectedInput = e.target;
        visHandle(selectedInput);
        switch (selectedOption) {
            case "Yes":
                fieldsGroupToggle("ce-protection", "enabled");
                $("#ce-protection-child-row").addClass("d-none");
                $("#ce-protection-child-rider-amount").attr("disabled", true);
                break;
            case "No":
                fieldsGroupToggle("ce-protection", "disabled");
                $("#ce-protection-child-row").addClass("d-none");
                $("#ce-protection-child-rider-amount").attr("disabled", true);
                break;
            case "Yes w/ Child Rider":
                fieldsGroupToggle("ce-protection", "enabled");
                $("#ce-protection-child-row").removeClass("d-none");
                $("#ce-protection-child-rider-amount").attr("disabled", false);
                break;
        }
    });

    childrensEducationSpouseCoverageRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        switch (selectedOption) {
            case "Yes":
                $("#presentation-form .spouse-ce-protection-field").removeClass(
                    "d-none",
                );
                $("#presentation-form .spouse-ce-protection-field input").attr(
                    "disabled",
                    false,
                );
                break;
            case "No":
                $("#presentation-form .spouse-ce-protection-field").addClass(
                    "d-none",
                );
                $("#presentation-form .spouse-ce-protection-field input").attr(
                    "disabled",
                    true,
                );
                break;
        }
    });

    alxFinalExpenseRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        let selectedInput = e.target;
        visHandle(selectedInput);
        switch (selectedOption) {
            case "Yes":
                fieldsGroupToggle("alx-final-expense", "enabled");
                $("#alx-final-expense-child-row").addClass("d-none");
                $("#alx-final-expense-child-rider-amount").attr(
                    "disabled",
                    true,
                );
                break;
            case "No":
                fieldsGroupToggle("alx-final-expense", "disabled");
                $("#alx-final-expense-child-row").addClass("d-none");
                $("#alx-final-expense-child-rider-amount").attr(
                    "disabled",
                    true,
                );
                break;
            case "Yes w/ Child Rider":
                fieldsGroupToggle("alx-final-expense", "enabled");
                $("#alx-final-expense-child-row").removeClass("d-none");
                $("#alx-final-expense-child-rider-amount").attr(
                    "disabled",
                    false,
                );
                break;
        }
    });

    alxFinalExpenseSpouseCoverageRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        switch (selectedOption) {
            case "Yes":
                $(
                    "#presentation-form .spouse-alx-final-expense-field",
                ).removeClass("d-none");
                $(
                    "#presentation-form .spouse-alx-final-expense-field input",
                ).attr("disabled", false);
                break;

            case "No":
                $(
                    "#presentation-form .spouse-alx-final-expense-field",
                ).addClass("d-none");
                $(
                    "#presentation-form .spouse-alx-final-expense-field input",
                ).attr("disabled", true);
                break;
        }
    });

    alxHeadStartFinalExpenseRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        let selectedInput = e.target;
        visHandle(selectedInput);
        switch (selectedOption) {
            case "Yes":
                fieldsGroupToggle("alx-head-start-final-expense", "enabled");
                $("#alx-head-start-final-expense-child-row").addClass("d-none");
                $("#alx-head-start-final-expense-child-rider-amount").attr(
                    "disabled",
                    true,
                );
                break;
            case "Yes w/ Child Rider":
                fieldsGroupToggle("alx-head-start-final-expense", "enabled");
                $("#alx-head-start-final-expense-child-row").removeClass(
                    "d-none",
                );
                $("#alx-head-start-final-expense-child-rider-amount").attr(
                    "disabled",
                    false,
                );
                break;
            case "No":
                fieldsGroupToggle("alx-head-start-final-expense", "disabled");
                $("#alx-head-start-final-expense-child-row").addClass("d-none");
                $("#alx-head-start-final-expense-child-rider-amount").attr(
                    "disabled",
                    true,
                );
                break;
        }
    });

    alxHeadStartFinalExpenseSpouseCoverageRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        switch (selectedOption) {
            case "Yes":
                $(
                    "#presentation-form .spouse-alx-head-start-final-expense-field",
                ).removeClass("d-none");
                $(
                    "#presentation-form .spouse-alx-head-start-final-expense-field input",
                ).attr("disabled", false);
                break;
            case "No":
                $(
                    "#presentation-form .spouse-alx-head-start-final-expense-field",
                ).addClass("d-none");
                $(
                    "#presentation-form .spouse-alx-head-start-final-expense-field input",
                ).attr("disabled", true);
                break;
        }
    });

    // Region: Supplemental Health Radio Inputs
    const accidentProtectorMaxRadio = $(
        "input[name='accident-protector-max-radio']",
    );
    const acbAccidentRadio = $("input[name='acb-accident-radio']");
    const criticalIllnessProtectionRadio = $(
        "input[name='critical-illness-protection']",
    );
    const cashCancerRadio = $("input[name='cash-cancer']");
    const cancerEnduranceRadio = $("input[name='cancer-endurance']");
    const intensiveCareRadio = $("input[name='intensive-care']");

    // Region: Supplemental Health Radio Events
    accidentProtectorMaxRadio.on("change", (e) => {
        let state = yesNoFieldToBoolean(e.target.value);
        let target = $(e.target).data("visTarget");
        setVis(target, state);
    });

    acbAccidentRadio.on("change", (e) => {
        let state = yesNoFieldToBoolean(e.target.value);
        let target = $(e.target).data("visTarget");
        setVis(target, state);
    });

    criticalIllnessProtectionRadio.on("change", (e) => {
        let state = yesNoFieldToBoolean(e.target.value);
        let target = $(e.target).data("visTarget");
        setVis(target, state);
    });

    cashCancerRadio.on("change", (e) => {
        let state = yesNoFieldToBoolean(e.target.value);
        let target = $(e.target).data("visTarget");
        setVis(target, state);
    });

    cancerEnduranceRadio.on("change", (e) => {
        let state = yesNoFieldToBoolean(e.target.value);
        let target = $(e.target).data("visTarget");
        setVis(target, state);
    });

    intensiveCareRadio.on("change", (e) => {
        let state = yesNoFieldToBoolean(e.target.value);
        let target = $(e.target).data("visTarget");
        setVis(target, state);
    });

    // Toggle rebuttals visbility
    rebuttalsRadio.on("change", (e) => {
        let state = yesNoFieldToBoolean(e.target.value);
        let target = $(e.target).data("visTarget");
        setVis(target, state);
    });

    // Toggle down-closing visbility
    downClosingRadio.on("change", (e) => {
        let state = yesNoFieldToBoolean(e.target.value);
        let target = $(e.target).data("visTarget");
        setVis(target, state);
    });

    // Begin Tab Events
    beginPresentationButton.on("click", (e) => {
        e.preventDefault();
        let selectedScript = scriptSelect.val();
        if (selectedScript == "0") {
            // Warning class
            scriptSelect.addClass("border border-danger");
            scriptSelectHelper.removeClass("text-muted");
            scriptSelectHelper.addClass("text-danger");
            return;
        }
        showScript(selectedScript, scriptSelectOptionArray);
        previousButton.attr("disabled", false);
        nextButton.attr("disabled", false);
        Tab.getOrCreateInstance(stepOnePill).show();
    });

    $("#begin-transition-button").on("click", (e) => {
        e.preventDefault();
        Tab.getOrCreateInstance(stepTwoPill).show();
    });

    $("#begin-needs-analysis-button").on("click", (e) => {
        e.preventDefault();
        Tab.getOrCreateInstance(stepThreePill).show();
    });

    // referral validation
    // validate phone field
    const phoneField = $('.referrals-form-container input[name="referral-phone"]');
    const emailField = $('.referrals-form-container input[name="referral-email"]');
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
                        .text("Phone number must be at least 10 digits.").show();
                    break;
                case "TOO_LONG":
                    phoneField
                        .parent()
                        .siblings(".invalid-feedback")
                        .text("Phone number must be no more than 15 digits.").show();
                    break;
                default:
                    phoneField
                        .parent()
                        .siblings(".invalid-feedback")
                        .text("Phone number is invalid.").show();
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
        let email = emailField.val();
        let validate = EmailValidator.validate(email);

        if (validate) {
            emailField.removeClass("is-invalid");
            emailField.addClass("is-valid");
            emailField.parent().siblings(".invalid-feedback").text("").hide();
        } else {
            emailField.addClass("is-invalid");
            emailField.removeClass("is-valid");
            emailField.parent().siblings(".invalid-feedback").text("Entered email is invalid.").show();
        }
    });

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
        let referralsFormButtonText = referralsFormButton.text();

        referralsFormContainer.find(".alert").addClass("d-none");

        let referralFormData = referralsForm.serializeArray();
        console.log(referralFormData);

        let userId = referralFormData[0].value;
        let leadId = referralFormData[1].value;
        let appointmentId = referralFormData[2].value;
        let referralFirstName = referralFormData[3].value;
        let referralLastName = referralFormData[4].value;
        let referralSpouseName = referralFormData[5].value;
        let referralPhone = referralFormData[6].value;
        let referralRelationship = referralFormData[7].value;

        let currentReferralCount = $(".referral-count-num").text();

        referralsFormButton.attr("disabled", true);
        referralsFormButton.text("Adding Referral...");

        // let successChance = ((Math.floor(Math.random() * 100) + 1) > 50) ? true : false;
        // let alertId = (successChance) ? "referral-success" : "referral-error";

        // let increment = (successChance) ? 1 : 0;

        // setTimeout(() => {
        //     referralsForm.trigger("reset");
        //     $('.referral-count-num').text(parseInt(currentReferralCount) + increment);
        //     referralsFormButton.text(referralsFormButtonText);
        //     referralsFormButton.attr("disabled", false);
        //     $('input[name="referral-first-name"]').focus();
        //     $('.alert-first-name').text(referralFirstName);
        //     $(`#${alertId}`).removeClass("d-none");
        // }, 1000);

        // okay now build the actual form submission ajax request
        let submissionData = new FormData();
        submissionData.append("user_id", userId);
        submissionData.append("lead_id", leadId);
        submissionData.append("appointment_id", appointmentId);
        submissionData.append("referral_first_name", referralFirstName);
        submissionData.append("referral_last_name", referralLastName);
        submissionData.append("referral_spouse_name", referralSpouseName);
        submissionData.append("referral_phone", referralPhone);
        submissionData.append("referral_relationship", referralRelationship);
        submissionData.append("action", ajaxAction);
        submissionData.append("nonce", ajaxNonce);
        submissionData.append("method", "add_referral");

        $.ajax({
            url: ajaxUrl,
            type: "POST",
            data: submissionData,
            processData: false,
            contentType: false,
            success: (response) => {
                console.log(response);
                if (response.success) {
                    referralsForm.trigger("reset");
                    $(".referral-count-num").text(
                        parseInt(currentReferralCount) + 1,
                    );
                    referralsFormButton.text(referralsFormButtonText);
                    referralsFormButton.attr("disabled", false);
                    $('input[name="referral-first-name"]').focus();
                    $(".alert-first-name").text(referralFirstName);
                    $("#referral-success").removeClass("d-none");
                } else {
                    referralsFormButton.text(referralsFormButtonText);
                    referralsFormButton.attr("disabled", false);
                    $("#referral-error").removeClass("d-none");
                }
            },
            error: (error) => {
                console.log(error);
                referralsFormButton.text(referralsFormButtonText);
                referralsFormButton.attr("disabled", false);
                $("#referral-error").removeClass("d-none");
            },
        });
    });

    // Clear danger class if a valid script is selected
    scriptSelect.on("change", (e) => {
        let selectedScript = scriptSelect.val();
        if (selectedScript != "0") {
            scriptSelect.removeClass("border border-danger");
            scriptSelectHelper.removeClass("text-danger");
            scriptSelectHelper.addClass("text-muted");
        }
    });

    // Next Button clicked
    nextButton.on("click", (e) => {
        e.preventDefault();
        let currentTab = $(".tab-pane.active");
        let currentTabId = currentTab.attr("id");
        let nextTabId = getNextTabId(currentTabId, tabIdList);
        if (nextTabId != "stop") {
            previousButton.attr("disabled", false);
            Tab.getOrCreateInstance(tabIdList[nextTabId]).show();
            if (nextTabId === "stepSeven") {
                nextButton.attr("disabled", true);
            }
        }
    });

    // Previous Button clicked
    previousButton.on("click", (e) => {
        e.preventDefault();
        let currentTab = $(".tab-pane.active");
        let currentTabId = currentTab.attr("id");
        let previousTabId = getPreviousTabId(currentTabId, tabIdList);
        if (previousTabId != "stop") {
            nextButton.attr("disabled", false);
            Tab.getOrCreateInstance(tabIdList[previousTabId]).show();
            if (previousTabId === "begin") {
                previousButton.attr("disabled", true);
            }
        }
    });

    // Final Tab Shown events
    stepSevenPill.on("shown.bs.tab", (e) => {
        let formSnapshot = $("#presentation-form").serializeArray();
        let formObject = {};
        formSnapshot.forEach((field) => {
            formObject[field.name] = field.value;
        });
        console.log(formObject);
        const supplementalFields = [
            "accident-protector-max-radio",
            "acb-accident-radio",
            "critical-illness-protection",
            "cash-cancer",
            "cancer-endurance",
            "intensive-care",
        ];
        let supplementalsBool = false;

        supplementalFields.forEach((field) => {
            console.log(formObject[field]);
            if (formObject[field] === "Yes") {
                supplementalsBool = true;
            }
        });

        if (supplementalsBool) {
            $(".supplementals-yes").removeClass("d-none");
        } else {
            $(".supplementals-yes").addClass("d-none");
        }

        // If any Spouse coverage items are Yes, show spouse section
        const spousalFields = [
            "spouse-final-expense",
            "spouse-income-protection",
            "spouse-mortgage-protection",
            "spouse-ce-protection",
            "spouse-alx-final-expense",
            "spouse-alx-head-start-final-expense",
        ];
        let spouseBool = false;

        spousalFields.forEach((field) => {
            console.log(formObject[field]);
            if (formObject[field] === "Yes") {
                spouseBool = true;
            }
        });

        if (spouseBool) {
            $(".spouse-inclusion").removeClass("d-none");
        } else {
            $(".spouse-inclusion").addClass("d-none");
        }
    });
};

const showScript = (chosen, scriptArray) => {
    scriptArray.forEach((script) => {
        if (chosen === script) {
            $(`.${script}`).removeClass("d-none");
        } else {
            $(`.${script}`).addClass("d-none");
        }
    });
};

const getNextTabId = (currentTabId, tabIdList) => {
    let nextTabId;
    switch (currentTabId) {
        case "begin":
            nextTabId = "stepOne";
            break;
        case "step-one":
            nextTabId = "stepTwo";
            break;
        case "step-two":
            nextTabId = "stepThree";
            break;
        case "step-three":
            nextTabId = "stepFour";
            break;
        case "step-four":
            nextTabId = "stepFive";
            break;
        case "step-five":
            nextTabId = "stepSix";
            break;
        case "step-six":
            nextTabId = "stepSeven";
            break;
        case "step-seven":
            nextTabId = "stop";
            break;
        default:
            nextTabId = "stop";
            break;
    }
    return nextTabId;
};

const getPreviousTabId = (currentTabId, tabIdList) => {
    let previousTabId;
    switch (currentTabId) {
        case "begin":
            previousTabId = "stop";
            break;
        case "step-one":
            previousTabId = "begin";
            break;
        case "step-two":
            previousTabId = "stepOne";
            break;
        case "step-three":
            previousTabId = "stepTwo";
            break;
        case "step-four":
            previousTabId = "stepThree";
            break;
        case "step-five":
            previousTabId = "stepFour";
            break;
        case "step-six":
            previousTabId = "stepFive";
            break;
        case "step-seven":
            previousTabId = "stepSix";
            break;
        default:
            previousTabId = "begin";
            break;
    }
    return previousTabId;
};

const fieldsGroupToggle = (prefix, mode) => {
    if (mode === "enabled") {
        $(`.${prefix}-field`).removeClass("d-none");
        $(`.${prefix}-field input`).attr("disabled", false);
        toggleSpouseFields(prefix, mode);
    } else {
        $(`.${prefix}-field`).addClass("d-none");
        $(`.${prefix}-field input`).attr("disabled", true);
        toggleSpouseFields(prefix, mode);
    }
};

const toggleSpouseFields = (prefix, mode) => {
    const isMarriedField = $("#presentation-form input[name='is-married']");
    if (isMarriedField.val() != 1) return;
    if (mode === "enabled") {
        $(`#spouse-${prefix}-row`).removeClass("d-none");
    } else {
        $(`#spouse-${prefix}-row`).addClass("d-none");
    }
};

export const populatePresentationData = (data) => {
    const modal = $("#presentation-modal");
    let firstName = data.first_name;
    let lastName = data.last_name;
    let fullName = `${firstName} ${lastName}`;
    $("#client-full-name-header").text(fullName);
    $("#presentation-script-select").val(data.lead_type);
    $(".lead-first-name").text(firstName);
    $("input[name=lead-id]").val(data.id);
    $("input[name=appointment-id]").val(data.appointment_id);
    $("input[name=is-married").val(data.is_married);
    $("input[name=first-name]").val(firstName);
    $("input[name=last-name]").val(lastName);
    $("input[name=email]").val(data.email);
    $("input[name=phone]").val(data.phone);

    modal.modal("show");
};

/**
 * {
    "id": "35",
    "created_at": "2022-12-16 09:11:53",
    "updated_at": "2022-12-16 09:11:53",
    "assigned_to": "1",
    "assigned_by": "0",
    "assigned_at": "2022-12-16 09:11:53",
    "lead_status": "Scheduled",
    "lead_disposition": "No Answer",
    "lead_type": "cskw",
    "lead_source": "new",
    "lead_relationship": "State Farm",
    "lead_referred_by": "Jake",
    "first_name": "Tyler",
    "last_name": "Karle",
    "email": "solo.driver.bob@gmail.com",
    "phone": "(904) 532-1080",
    "is_married": "1",
    "is_employed": "0",
    "has_children": "0",
    "num_children": "0",
    "has_bank_account": "0",
    "bank_account_type": "",
    "bank_name": "",
    "bank_account_number": "",
    "bank_routing_number": "",
    "spouse_first_name": "Megan",
    "spouse_last_name": "Karle",
    "date_last_contacted": null,
    "date_last_appointment": null,
    "date_last_sale": null,
    "date_last_followup": null,
    "date_last_disposition": null,
    "number_of_referrals_to_date": null,
    "is_policyholder": null,
    "is_spouse_policyholder": null
}
 */
