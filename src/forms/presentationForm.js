import { Tab } from "bootstrap";
const $ = jQuery;

export const presentationForm = () => {
    const presentationFormElement = $("#presentation-form");
    const beginPresentationButton = $("#presentation-script-select-button");

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

    const beginTab = $("#begin");
    const stepOneTab = $("#step-one");
    const stepTwoTab = $("#step-two");
    const stepThreeTab = $("#step-three");
    const stepFourTab = $("#step-four");
    const stepFiveTab = $("#step-five");
    const stepSixTab = $("#step-six");
    const stepSevenTab = $("#step-seven");

    const scriptSelect = $("#presentation-script-select");
    const scriptSelectOptions = $("#presentation-script-select option");
    const scriptSelectOptionArray = Array.from(scriptSelectOptions).map(
        (option) => {
            return option.value;
        },
    );
    const scriptSelectHelper = $("#scriptSelectHelper");

    // Sales Plans Radio Buttons
    const finalExpenseRadio = $("input[name='final-expense']");
    const finalExpenseExistingCoverageRadio = $(
        "input[name='final-expense-existing-coverage']",
    );
    const finalExpenseAmountNeededRadio = $(
        "input[name='final-expense-amount-needed']",
    );
    const finalExpenseQualifiedAmountRadio = $(
        "input[name='final-expense-qualified-amount']",
    );
    const finalExpenseChildRow = $("final-expense-child-row");
    const finalExpenseChildRiderAmountRadio = $(
        "input[name='final-expense-child-rider-amount']",
    );

    const planTypeRadio = $("input[name='plan-type']");

    // hidden variable fields
    const isMarriedField = $("input[name='is-married']");
    const leadIdField = $("input[name='lead-id']");

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

    // planTypeRadio.on("change", (e) => {
    //     let selectedOption = e.target.value;
    //     if (selectedOption === "Standard") {
    //         if (isMarriedField.val() === "1") {
    //             fieldsGroupToggle("standard-married", "enabled");
    //             fieldsGroupToggle("standard-single", "disabled");
    //         }
    //     }

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

    // Final Expense
    finalExpenseRadio.on("change", (e) => {
        let selectedOption = e.target.value;
        switch (selectedOption) {
            case "Yes":
                fieldsGroupToggle("final-expense", "enabled");
                $("#final-expense-child-row").addClass("d-none");
                $("#final-expense-child-rider-amount").attr("disabled", true);
                if (isMarriedField.val() === "1") {
                    spouseFieldsGroupToggle("final-expense", "enabled");
                }
                break;
            case "No":
                fieldsGroupToggle("final-expense", "disabled");
                $("#final-expense-child-row").addClass("d-none");
                $("#final-expense-child-rider-amount").attr("disabled", true);
                if (isMarriedField.val() === "1") {
                    spouseFieldsGroupToggle("final-expense", "disabled");
                }
                break;
            case "Yes w/ Child Rider":
                fieldsGroupToggle("final-expense", "enabled");
                $("#final-expense-child-row").removeClass("d-none");
                $("#final-expense-child-rider-amount").attr("disabled", false);
                if (isMarriedField.val() === "1") {
                    spouseFieldsGroupToggle("final-expense", "enabled");
                }
                break;
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
    } else {
        $(`.${prefix}-field`).addClass("d-none");
        $(`.${prefix}-field input`).attr("disabled", true);
    }
};

const spouseFieldsGroupToggle = (prefix, mode) => {
    if (mode === "enabled") {
        $(`#${prefix}-spouse-row`).removeClass("d-none");
        $(`spouse-${prefix}-field`).removeClass("d-none");
        $(`spouse-${prefix}-field input`).attr("disabled", false);
    } else {
        $(`#${prefix}-spouse-row`).addClass("d-none");
        $(`spouse-${prefix}-field`).addClass("d-none");
        $(`spouse-${prefix}-field input`).attr("disabled", true);
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
    $("input[name=client-is-married").val(data.is_married);

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
