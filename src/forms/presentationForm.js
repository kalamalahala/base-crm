import { Tab } from "bootstrap";
import { toggleVis } from "../utils/toggleVis";
import { setVis } from "../utils/setVis";
import { toggleFormElements } from "../utils/toggleFormElements";
import { yesNoFieldToBoolean } from "../utils/booleanYesNo";
import "jquery.repeater/jquery.repeater.min.js";
const $ = jQuery;

export const presentationForm = () => {
    const presentationFormElement = $("#presentation-form");
    $(document).on("submit", "#presentation-form", function (e) {
        e.preventDefault();
        return false;
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
    const isMarriedField = $("#presentation-form input[name='is-married']");
    const leadIdField = $("input[name='lead-id']");

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

        console.log(`SHOW: ${selectedPlanType}`);

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
            console.log(`hiding ${planType}`);
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

    const alxHeadStartFinalExpenseRadio = $("input[name='alx-head-start-final-expense']");
    const alxHeadStartFinalExpenseSpouseCoverageRadio = $(
        '#presentation-form input[name="spouse-alx-head-start-final-expense"]',
    );

    // Rebuttals radio inputs
    const rebuttalsRadio = $("input[name='has-rebuttals']");
    
    // Down Closing Radio
    const downClosingRadio = $("input[name='down-closing-radio']");

    // Final Expense
    finalExpenseRadio.on("change", (e) => {
        let selectedOption = e.target.value;
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
                console.log("No");
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
        switch (selectedOption) {
            case "Yes":
                fieldsGroupToggle("alx-head-start-final-expense", "enabled");
                $("#alx-head-start-final-expense-child-row").addClass( "d-none");
                $("#alx-head-start-final-expense-child-rider-amount").attr( "disabled", true);
                break;
            case "Yes w/ Child Rider":
                fieldsGroupToggle("alx-head-start-final-expense", "enabled");
                $("#alx-head-start-final-expense-child-row").removeClass( "d-none");
                $("#alx-head-start-final-expense-child-rider-amount").attr( "disabled", false);
                break;
            case "No":
                fieldsGroupToggle("alx-head-start-final-expense", "disabled");
                $("#alx-head-start-final-expense-child-row").addClass( "d-none");
                $("#alx-head-start-final-expense-child-rider-amount").attr( "disabled", true);
                break;
        }
    });

    alxHeadStartFinalExpenseSpouseCoverageRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        switch (selectedOption) {
            case "Yes":
                $("#presentation-form .spouse-alx-head-start-final-expense-field").removeClass("d-none");
                $("#presentation-form .spouse-alx-head-start-final-expense-field input").attr("disabled", false);
                break;
            case "No":
                $("#presentation-form .spouse-alx-head-start-final-expense-field").addClass("d-none");
                $("#presentation-form .spouse-alx-head-start-final-expense-field input").attr("disabled", true);
                break;
        }
    });

    // Region: Supplemental Health Radio Inputs
    const accidentProtectorMaxRadio = $("input[name='accident-protector-max-radio']");
    const acbAccidentRadio = $("input[name='acb-accident-radio']");
    const criticalIllnessProtectionRadio = $("input[name='critical-illness-protection']");
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
        Tab.getOrCreateInstance(stepOnePill).show();
    });

    $("#begin-transition-button").on("click", (e) => {
        e.preventDefault();
        Tab.getOrCreateInstance(stepTwoPill).show();
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
    // console.log(
    //     `attempting to toggle spouse fields for ${prefix}, isMarriedField: ${isMarriedField.val()}`,
    // );
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
    $("input[name=is-married").val(data.is_married);

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
