<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Prepare HTML Presentation Form
 */

use BaseCRM\ServerSide\Lead;

// Get the current user
$user = wp_get_current_user();
$user_id = $user->ID;
$user_name = BaseCRM::agent_name($user_id);

// Get scripts
$scripts = new Lead();
$scripts = $scripts->lead_types();

?>

<div class="presentation-form-container p-3">
    <div class="row">
        <div class="col-12">
            <span class="h3 mb-0" id="client-full-name-header">Client Name</span>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <?php echo BaseCRM::i18n('Agent - '); ?> <span class="presentation-agent-name"><?php echo $user_name; ?></span>
            <hr>
        </div>
    </div> <!-- End Row -->
    <!-- Begin Form Element: #presentation-form -->
    <div class="row mb-3">
        <div class="col-12">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-justified" id="step1" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="begin-pill" data-bs-toggle="tab" data-bs-target="#begin" type="button" role="tab" aria-controls="begin" aria-selected="true">Script Select</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-one-pill" data-bs-toggle="tab" data-bs-target="#step-one" type="button" role="tab" aria-controls="step-one" aria-selected="false">Step One</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-two-pill" data-bs-toggle="tab" data-bs-target="#step-two" type="button" role="tab" aria-controls="step-two" aria-selected="false">Step Two</button>
                </li>
                <!-- Step Three -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-three-pill" data-bs-toggle="tab" data-bs-target="#step-three" type="button" role="tab" aria-controls="step-three" aria-selected="false">Step Three</button>
                </li>
                <!-- Step Four -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-four-pill" data-bs-toggle="tab" data-bs-target="#step-four" type="button" role="tab" aria-controls="step-four" aria-selected="false">Step Four</button>
                </li>
                <!-- Step Five -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-five-pill" data-bs-toggle="tab" data-bs-target="#step-five" type="button" role="tab" aria-controls="step-five" aria-selected="false">Step Five</button>
                </li>
                <!-- Step Six -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-six-pill" data-bs-toggle="tab" data-bs-target="#step-six" type="button" role="tab" aria-controls="step-six" aria-selected="false">Step Six</button>
                </li>
                <!-- Step Seven -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-seven-pill" data-bs-toggle="tab" data-bs-target="#step-seven" type="button" role="tab" aria-controls="step-seven" aria-selected="false">Step Seven</button>
                </li>
            </ul>
        </div>
    </div> <!-- End Row -->
    <div class="row">
        <div class="col-12">
            <!-- Tab panes -->
            <form id="presentation-form" class="presentation-form repeater" action="">
                <!-- hidden variables -->
                <input type="hidden" name="lead-id" value="0">
                <input type="hidden" name="is-married" value="0">
                <div class="tab-content">
                    <!-- Beginning Tab -->
                    <div class="tab-pane active" id="begin" role="tabpanel" aria-labelledby="begin-tab">

                        <div class="row">
                            <div class="col">
                                <p>
                                    Build rapport!
                                </p>
                                <p>
                                <ul>
                                    <li>
                                        F - Family: How are you and your family doing?
                                    </li>
                                    <li>
                                        O - Occupation: Are you able to go to work, or are you working from home?
                                    </li>
                                    <li>
                                        R - Recreation: What do you like to do for fun?
                                    </li>
                                </ul>
                                </p>
                                <div class="my-3">

                                    <select name="presentation-script-select" id="presentation-script-select" class="form-select" aria-describedby="scriptSelectHelper">
                                        <option selected value="0"><?php echo BaseCRM::i18n('Choose a script'); ?></option>
                                        <?php
                                        foreach ($scripts as $id => $name) {
                                            echo '<option value="' . $id . '">' . $name . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <small id="scriptSelectHelper" class="form-text text-muted"><?php echo BaseCRM::i18n('Select a script to begin the presentation.'); ?></small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="presentation-script-select-button"><?php echo BaseCRM::i18n('Begin Presentation'); ?></button>
                            </div>
                        </div>
                    </div> <!-- End Beginning Tab -->
                    <div class="tab-pane" id="step-one" role="tabpanel" aria-labelledby="step-one-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="14" aria-valuemin="0" aria-valuemax="100" style="width: 14%">1/7</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <div class="adp d-none" id="adp">
                                    ADP Script - Empty
                                </div>
                                <div class="cskr d-none" id="csk">
                                    <div class="row" id="csk-script-container">
                                        <div class="col">
                                            <p class="h4">Child Safe Kit</p>
                                            <p class="lead"><span class="lead-first-name">[client name]</span> I'll start with the facts.</p>
                                            <p class="lead">
                                                More than 800,000 kids go missing in our country every year. And you know what it's like to lose sight of your kids for just a few seconds. That feeling that you get,
                                                it's like your heart stops, you start to panic, it's like you're holding your breath waiting to see them.
                                            </p>
                                            <p class="lead">
                                                Imagine if those seconds turned to minutes, and the minutes turned to hours. Studies show that every hour a child
                                                is missing adds 60 miles in any direction that they could be. And, according to the FBI, 93% of abducted children
                                                are killed within the first 24 hours of being taken. And, if that's not bad enough, human trafficking is on the rise.
                                                Over 200,000 children are at risk every year. So, my company has partnered with the International Union of Police Associations
                                                and we give out child safe kits to the community.
                                            </p>
                                            <p class="lead">
                                                The kits allow you to keep all pertinent info about your child in one place. And if you ever need to utilize the kit, you'll be able to
                                                share it via email right from your phone. You'll also have access to a variety of other services related to keeping your child(ren) safe, like offender
                                                searches and app monitoring systems for your child's mobile phone. As you can imagine, time is of the essence, and with technology today,
                                                this child safe kit puts you in the greatest position of strength to help your find your child quickly and protect them from potential
                                                predators.
                                            </p>
                                            <p class="lead">
                                                Before we end our call, you'll receive an email that will grant you access to the entire program. Please take advantage of all that it offers as soon as possible.
                                            </p>
                                            <p class="lead">
                                                Now <span class="lead-first-name">[client name]</span>, we've made a commitment to get this program to every parent possible, and to do that we need your help.
                                                You help by providing the contact information for every parent you know, so we can protect their children as well. Who's the first parent that comes to mind?
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="cskw d-none" id="csk">
                                    <div class="row" id="csk-script-container">
                                        <div class="col">
                                            <p class="h4">Child Safe Kit</p>
                                            <p class="lead"><span class="lead-first-name">[client name]</span> I'll start with the facts.</p>
                                            <p class="lead">
                                                More than 800,000 kids go missing in our country every year. And you know what it's like to lose sight of your kids for just a few seconds. That feeling that you get,
                                                it's like your heart stops, you start to panic, it's like you're holding your breath waiting to see them.
                                            </p>
                                            <p class="lead">
                                                Imagine if those seconds turned to minutes, and the minutes turned to hours. Studies show that every hour a child
                                                is missing adds 60 miles in any direction that they could be. And, according to the FBI, 93% of abducted children
                                                are killed within the first 24 hours of being taken. And, if that's not bad enough, human trafficking is on the rise.
                                                Over 200,000 children are at risk every year. So, my company has partnered with the International Union of Police Associations
                                                and we give out child safe kits to the community.
                                            </p>
                                            <p class="lead">
                                                The kits allow you to keep all pertinent info about your child in one place. And if you ever need to utilize the kit, you'll be able to
                                                share it via email right from your phone. You'll also have access to a variety of other services related to keeping your child(ren) safe, like offender
                                                searches and app monitoring systems for your child's mobile phone. As you can imagine, time is of the essence, and with technology today,
                                                this child safe kit puts you in the greatest position of strength to help your find your child quickly and protect them from potential
                                                predators.
                                            </p>
                                            <p class="lead">
                                                Before we end our call, you'll receive an email that will grant you access to the entire program. Please take advantage of all that it offers as soon as possible.
                                            </p>
                                            <p class="lead">
                                                Now <span class="lead-first-name">[client name]</span>, we've made a commitment to get this program to every parent possible, and to do that we need your help.
                                                You help by providing the contact information for every parent you know, so we can protect their children as well. Who's the first parent that comes to mind?
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- POS -->
                                <div class="pos d-none" id="pos">
                                    POS Script - Empty
                                </div>
                                <!-- OPAI Script -->
                                <div class="opai d-none" id="opai">
                                    OPAI Script - Empty
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" id="begin-transition-button">Go to Transition <i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                    <div class="tab-pane" id="step-two" role="tabpanel" aria-labelledby="step-two-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100" style="width: 28%">2/7</div>
                        </div>
                        <hr>
                        <div class="transition-script">
                            <p class="lead">
                                Now <span class="lead-first-name">[client name]</span>, as we discussed earlier, my company is very active in the community.
                                In addition to protecting the children of our communities with programs like the child safe program, we also provide financial
                                relief to those who qualify with our insurance products. The products we offer pay you or your family in the event of sickness,
                                accident, or even death. Now <span class="lead-first-name">[client name]</span>, I'm not sure that you'll qualify for <strong>ANY</strong>
                                of these products, but you have been approved for a FREE needs analysis and a NO-COST insurance policy. The policy will cover you and
                                your spouse for $3,000 each, and each of your children for $1,000.
                            </p>
                            <p class="lead">
                                Let's start with the needs analysis. <span class="script-reminder">(go to CE3)</span>
                            </p>
                        </div>
                    </div>
                    <div class="tab-pane" id="step-three" role="tabpanel" aria-labelledby="step-three-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%">3/7</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <div class="additional-questions-script">
                                    <p class="h4">Additional Questions</p>
                                    <p class="h5">
                                        Tobacco &amp; Marijuana Use
                                    </p>
                                    <p class="lead">
                                        Have you or your spouse consumed tobacco or marijuana in any way in the past 12 months? (hookah, cigar, vape pen, snuff, edibles, etc)
                                    </p>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tobacco-question" id="tobacco-yes">
                                        <label class="form-check-label" for="tobacco-yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tobacco-question" id="tobacco-no" checked>
                                        <label class="form-check-label" for="tobacco-no">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="h5">Section Two (What are they working with?)</p>
                                <p class="lead">
                                    The first question asks "Where are you currently employed?" In addition to that question it is good practice to ask:
                                <ul>
                                    <li class="script-pointer">How long have you been employed there?</li>
                                    <li class="script-pointer">What is your position there?</li>
                                    <li class="script-pointer">Do you have a side hustle or a part time job?</li>
                                </ul>
                                </p>
                                <p class="lead">
                                    The next major question asks, "What is you and/or your spouse's monthly take home pay?" Be specific when asking this question.
                                    <span class="script-pointer">You want to know what they make after taxes. You also want to make sure that the number they give
                                        includes their side hustle or part time job's income.
                                    </span>
                                </p>
                                <p class="lead">
                                    The next question asks, "How much life insurance do your currently have through work?" In addition to this question you want to ask:
                                <ul>
                                    <li class="script-pointer">Does your employer pay for the coverage or do you?</li>
                                    <li class="script-pointer">Do you know how many years your rate is locked in for before the price increases?</li>
                                    <li class="script-pointer">If you were to leave your place of employment today, can you keep your coverage?</li>
                                </ul>
                                </p>
                                <p class="lead">
                                    The next question asks, "Do you have life insurance outside of work?" The sub-questions ask if they have whole life, term life, or both and how much?
                                    In addition to these questions, ask:
                                <p class="h5">If whole life:</p>
                                <ul>
                                    <li class="script-pointer">Have you borrowed against your policy?</li>
                                    <li class="script-pointer">Does your policy title read whole life or something different such as universal life or a flexible benefit-adjustable premium?</li>
                                    <li class="script-pointer">Do you receive statements about how your policy is performing?</li>
                                </ul>
                                <p class="h5">If term:</p>
                                <ul>
                                    <li class="script-pointer">What type of term policy do you have? (5, 10, 20, 30 year policy, or a decreasing term)</li>
                                    <li class="script-pointer">How many years do you have left before the premium increases?</li>
                                    <li class="script-pointer">Are you able to convert your policy to a permanent policy?</li>
                                </ul>
                                </p>
                                <p class="h5">Section 3 (Household Survey)</p>
                                <p class="lead">
                                    The first question asks, "Do you currently rent or own?" In addition to this question, you want to ask:
                                <p class="h5">
                                    If they rent:
                                </p>
                                <ul>
                                    <li class="script-pointer">How much is your monthly rent?</li>
                                    <li class="script-pointer">How long have you been living there?</li>
                                    <li class="script-pointer">How much would you say that your rent increases each year?</li>
                                    <li class="script-pointer">Do you currently have a policy that will pay rent for your family if they were to pass away?</li>
                                </ul>
                                <p class="h5">
                                    If they own:
                                </p>
                                <ul>
                                    <li class="script-pointer">What is your mortgage balance?</li>
                                    <li class="script-pointer">How many years do you have left to pay?</li>
                                    <li class="script-pointer">Do you have insurance to pay off your mortgage in case of death?</li>
                                </ul>
                                </p>
                                <p class="lead">
                                    The next question asks, "How much have you saved for your child's college education?" and the last question in this section asks,
                                    "Do you bank locally for checking?" The way you should ask this question is:
                                </p>
                                <ul>
                                    <li class="script-pointer">Do you have a traditional checking account?</li>
                                    <li class="script-pointer">Do you bank with a traditional bank or a credit union? Who do you bank with?</li>
                                </ul>
                                <p class="h5">Section 4 (Health Questions)</p>
                                <p class="lead">
                                    In addition to the questions listed you also want to ask:
                                </p>
                                <ul>
                                    <li class="script-pointer">How tall are you? How much do you weigh?</li>
                                    <li class="script-pointer">Do you have any medical conditions that a doctor has diagnosed you with?</li>
                                    <li class="script-pointer">Do you take medication for anything? Are you supposed to be taking medication for anything?</li>
                                    <li class="script-pointer">Have you been denied insurance in the past?</li>
                                    <li class="script-pointer">Have you been treated for drug or alcohol abuse in the last two years?</li>
                                    <li class="script-pointer">Are you on medicaid or medicare?</li>
                                    <li class="script-pointer">Does cancer run in your family?</li>
                                    <li class="script-pointer">Do illnesses such as heart attack, stroke, or endstage renal failure run in your family?</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="step-four" role="tabpanel" aria-labelledby="step-four-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100" style="width: 56%">4/7</div>
                        </div>
                        <hr>
                        <p class="lead">Select Sales Type</p>
                        <div class="sales-type-container">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plan-type" id="standard-plan" value="standard-plan">
                                <label class="form-check-label" for="standard-plan">
                                    Standard
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plan-type" id="alx-plan" value="alx-plan">
                                <label class="form-check-label" for="alx-plan">
                                    ALX
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plan-type" id="alx-head-start-plan" value="alx-head-start-plan">
                                <label class="form-check-label" for="alx-head-start-plan">
                                    ALX w/ Children (Head Start)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plan-type" id="supplementals-only-plan" value="supplementals-only-plan">
                                <label class="form-check-label" for="supplementals-only-plan">
                                    Supplementals Only
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="step-five" role="tabpanel" aria-labelledby="step-five-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">5/7</div>
                        </div>
                        <hr>
                        <!-- Begin Plan Form Fields -->
                        <div class="plan-group standard-plan">
                            <p class="h5">Standard Plan</p>
                            <div class="final-expense">
                                <div class="row">
                                    <div class="col-3">
                                        <p class="lead">Final Expense</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="final-expense" id="final-expense-yes" value="Yes">
                                            <label class="form-check-label" for="final-expense-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="final-expense" id="final-expense-yes-w-child" value="Yes w/ Child Rider">
                                            <label class="form-check-label" for="final-expense-yes-w-child">
                                                Yes w/ Child Rider
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="final-expense" id="final-expense-no" value="No" checked>
                                            <label class="form-check-label" for="final-expense-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 final-expense-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="final-expense-existing-coverage" id="final-expense-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 final-expense-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="final-expense-amount-needed" id="final-expense-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 final-expense-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="final-expense-qualified-amount" id="final-expense-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="final-expense-child-row">
                                    <div class="col-3">
                                        <!-- empty column -->
                                        &nbsp;
                                    </div>
                                    <div class="col-3">
                                        <p class="lead">Child Rider Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="final-expense-child-rider-amount" id="final-expense-child-rider-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="spouse-final-expense-row">
                                    <div class="col-3">
                                        <p class="lead">Spouse's Final Expense Coverage</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-final-expense" id="spouse-final-expense-yes" value="Yes">
                                            <label class="form-check-label" for="spouse-final-expense-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-final-expense" id="spouse-final-expense-no" value="No" checked>
                                            <label class="form-check-label" for="spouse-final-expense-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-final-expense-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-final-expense-existing-coverage" id="spouse-final-expense-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-final-expense-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-final-expense-amount-needed" id="spouse-final-expense-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-final-expense-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-final-expense-qualified-amount" id="spouse-final-expense-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end final expense -->
                            <div class="income-protection">
                                <!-- income protection -->
                                <div class="row">
                                    <div class="col-3">
                                        <p class="lead">Income Protection</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="income-protection" id="income-protection-yes" value="Yes">
                                            <label class="form-check-label" for="income-protection-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="income-protection" id="income-protection-yes-w-child" value="Yes w/ Child Rider">
                                            <label class="form-check-label" for="income-protection-yes-w-child">
                                                Yes w/ Child Rider
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="income-protection" id="income-protection-no" value="No" checked>
                                            <label class="form-check-label" for="income-protection-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 income-protection-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="income-protection-existing-coverage" id="income-protection-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 income-protection-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="income-protection-amount-needed" id="income-protection-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 income-protection-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="income-protection-qualified-amount" id="income-protection-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="income-protection-child-row">
                                    <div class="col-3">
                                        <!-- empty column -->
                                        &nbsp;
                                    </div>
                                    <div class="col-3">
                                        <p class="lead">Child Rider Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="income-protection-child-rider-amount" id="income-protection-child-rider-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="spouse-income-protection-row">
                                    <div class="col-3">
                                        <p class="lead">Spouse's Income Protection Coverage</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-income-protection" id="spouse-income-protection-yes" value="Yes">
                                            <label class="form-check-label" for="spouse-income-protection-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-income-protection" id="spouse-income-protection-no" value="No" checked>
                                            <label class="form-check-label" for="spouse-income-protection-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-income-protection-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-income-protection-existing-coverage" id="spouse-income-protection-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-income-protection-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-income-protection-amount-needed" id="spouse-income-protection-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-income-protection-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-income-protection-qualified-amount" id="spouse-income-protection-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end of income protection -->
                            <div class="mortgage-protection">
                                <!-- mortgage protection -->
                                <div class="row">
                                    <div class="col-3">
                                        <p class="lead">Mortgage Protection</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mortgage-protection" id="mortgage-protection-yes" value="Yes">
                                            <label class="form-check-label" for="mortgage-protection-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mortgage-protection" id="mortgage-protection-yes-w-child" value="Yes w/ Child Rider">
                                            <label class="form-check-label" for="mortgage-protection-yes-w-child">
                                                Yes w/ Child Rider
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="mortgage-protection" id="mortgage-protection-no" value="No" checked>
                                            <label class="form-check-label" for="mortgage-protection-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 mortgage-protection-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="mortgage-protection-existing-coverage" id="mortgage-protection-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 mortgage-protection-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="mortgage-protection-amount-needed" id="mortgage-protection-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 mortgage-protection-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="mortgage-protection-qualified-amount" id="mortgage-protection-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="mortgage-protection-child-row">
                                    <div class="col-3">
                                        <!-- empty column -->
                                        &nbsp;
                                    </div>
                                    <div class="col-3">
                                        <p class="lead">Child Rider Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="mortgage-protection-child-rider-amount" id="mortgage-protection-child-rider-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="spouse-mortgage-protection-row">
                                    <div class="col-3">
                                        <p class="lead">Spouse's Mortgage Protection Coverage</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-mortgage-protection" id="spouse-mortgage-protection-yes" value="Yes">
                                            <label class="form-check-label" for="spouse-mortgage-protection-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-mortgage-protection" id="spouse-mortgage-protection-no" value="No" checked>
                                            <label class="form-check-label" for="spouse-mortgage-protection-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-mortgage-protection-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-mortgage-protection-existing-coverage" id="spouse-mortgage-protection-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-mortgage-protection-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-mortgage-protection-amount-needed" id="spouse-mortgage-protection-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-mortgage-protection-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-mortgage-protection-qualified-amount" id="spouse-mortgage-protection-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end of mortgage protection -->
                            <div class="ce-protection">
                                <!-- ce protection -->
                                <div class="row">
                                    <div class="col-3">
                                        <p class="lead">Children's Education Protection</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ce-protection" id="ce-protection-yes" value="Yes">
                                            <label class="form-check-label" for="ce-protection-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ce-protection" id="ce-protection-yes-w-child" value="Yes w/ Child Rider">
                                            <label class="form-check-label" for="ce-protection-yes-w-child">
                                                Yes w/ Child Rider
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ce-protection" id="ce-protection-no" value="No" checked>
                                            <label class="form-check-label" for="ce-protection-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 ce-protection-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="ce-protection-existing-coverage" id="ce-protection-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 ce-protection-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="ce-protection-amount-needed" id="ce-protection-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 ce-protection-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="ce-protection-qualified-amount" id="ce-protection-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="ce-protection-child-row">
                                    <div class="col-3">
                                        <!-- empty column -->
                                        &nbsp;
                                    </div>
                                    <div class="col-3">
                                        <p class="lead">Child Rider Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="ce-protection-child-rider-amount" id="ce-protection-child-rider-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="spouse-ce-protection-row">
                                    <div class="col-3">
                                        <p class="lead">Spouse's Children's Education Protection Coverage</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-ce-protection" id="spouse-ce-protection-yes" value="Yes">
                                            <label class="form-check-label" for="spouse-ce-protection-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-ce-protection" id="spouse-ce-protection-no" value="No" checked>
                                            <label class="form-check-label" for="spouse-ce-protection-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-ce-protection-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-ce-protection-existing-coverage" id="spouse-ce-protection-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-ce-protection-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-ce-protection-amount-needed" id="spouse-ce-protection-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-ce-protection-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-ce-protection-qualified-amount" id="spouse-ce-protection-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end of children's education protection -->
                        </div> <!-- end of standard-plan -->
                        <div class="plan-group alx-plan">
                            <p class="h5">ALX Plan</p>
                            <div class="alx-final-expense">
                                <div class="row">
                                    <div class="col-3">
                                        <p class="lead">Final Expense</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alx-final-expense" id="alx-final-expense-yes" value="Yes">
                                            <label class="form-check-label" for="alx-final-expense-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alx-final-expense" id="alx-final-expense-yes-w-child" value="Yes w/ Child Rider">
                                            <label class="form-check-label" for="alx-final-expense-yes-w-child">
                                                Yes w/ Child Rider
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alx-final-expense" id="alx-final-expense-no" value="No" checked>
                                            <label class="form-check-label" for="alx-final-expense-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 alx-final-expense-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="alx-final-expense-existing-coverage" id="alx-final-expense-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 alx-final-expense-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="alx-final-expense-amount-needed" id="alx-final-expense-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 alx-final-expense-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="alx-final-expense-qualified-amount" id="alx-final-expense-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="alx-final-expense-child-row">
                                    <div class="col-3">
                                        <!-- empty column -->
                                        &nbsp;
                                    </div>
                                    <div class="col-3">
                                        <p class="lead">Child Rider Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="alx-final-expense-child-rider-amount" id="alx-final-expense-child-rider-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="spouse-alx-final-expense-row">
                                    <div class="col-3">
                                        <p class="lead">Spouse's Final Expense Coverage</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-alx-final-expense" id="spouse-alx-final-expense-yes" value="Yes">
                                            <label class="form-check-label" for="spouse-alx-final-expense-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-alx-final-expense" id="spouse-alx-final-expense-no" value="No" checked>
                                            <label class="form-check-label" for="spouse-alx-final-expense-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-alx-final-expense-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-alx-final-expense-existing-coverage" id="spouse-alx-final-expense-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-alx-final-expense-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-alx-final-expense-amount-needed" id="spouse-alx-final-expense-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-alx-final-expense-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-alx-final-expense-qualified-amount" id="spouse-alx-final-expense-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end ALX final expense -->
                        </div> <!-- end of alx-plan -->
                        <div class="plan-group alx-head-start-plan">
                            <div class="alx-head-start-final-expense">
                                <div class="row">
                                    <div class="col-3">
                                        <p class="lead">Final Expense</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alx-head-start-final-expense" id="alx-head-start-final-expense-yes" value="Yes">
                                            <label class="form-check-label" for="alx-head-start-final-expense-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alx-head-start-final-expense" id="alx-head-start-final-expense-yes-w-child" value="Yes w/ Child Rider">
                                            <label class="form-check-label" for="alx-head-start-final-expense-yes-w-child">
                                                Yes w/ Child Rider
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="alx-head-start-final-expense" id="alx-head-start-final-expense-no" value="No" checked>
                                            <label class="form-check-label" for="alx-head-start-final-expense-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 alx-head-start-final-expense-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="alx-head-start-final-expense-existing-coverage" id="alx-head-start-final-expense-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 alx-head-start-final-expense-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="alx-head-start-final-expense-amount-needed" id="alx-head-start-final-expense-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 alx-head-start-final-expense-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="alx-head-start-final-expense-qualified-amount" id="alx-head-start-final-expense-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="alx-head-start-final-expense-child-row">
                                    <div class="col-3">
                                        <!-- empty column -->
                                        &nbsp;
                                    </div>
                                    <div class="col-3">
                                        <p class="lead">Child Rider Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="alx-head-start-final-expense-child-rider-amount" id="alx-head-start-final-expense-child-rider-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-none" id="spouse-alx-head-start-final-expense-row">
                                    <div class="col-3">
                                        <p class="lead">Spouse's Final Expense Coverage</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-alx-head-start-final-expense" id="spouse-alx-head-start-final-expense-yes" value="Yes">
                                            <label class="form-check-label" for="spouse-alx-head-start-final-expense-yes">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="spouse-alx-head-start-final-expense" id="spouse-alx-head-start-final-expense-no" value="No" checked>
                                            <label class="form-check-label" for="spouse-alx-head-start-final-expense-no">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-alx-head-start-final-expense-field d-none">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-alx-head-start-final-expense-existing-coverage" id="spouse-alx-head-start-final-expense-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-alx-head-start-final-expense-field d-none">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-alx-head-start-final-expense-amount-needed" id="spouse-alx-head-start-final-expense-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-alx-head-start-final-expense-field d-none">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-alx-head-start-final-expense-qualified-amount" id="spouse-alx-head-start-final-expense-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end ALX final expense -->

                            <div class="alx-head-start-plan plan-group head-start-repeater">
                                <div class="row mb-1">
                                    <div class="col-12">
                                        <div class="d-flex flex-row">
                                            <p class="h4 mr-3">Head Start&nbsp;</p>
                                            <input type="button" value="Add" data-repeater-create class="btn btn-primary btn-sm" />
                                        </div>
                                    </div>
                                </div>
                                <div data-repeater-list="head-start-child">
                                    <div data-repeater-item>
                                        <div class="row mb-3">
                                            <div class="col-5">
                                                <input class="form-control" type="text" placeholder="Child Name" name="child-name" />
                                            </div>
                                            <div class="col-5">
                                                <input class="form-control" type="text" placeholder="$5,000.00" name="policy-amount" />
                                            </div>
                                            <div class="col-2">
                                                <input type="button" value="Delete" data-repeater-delete class="btn btn-secondary btn-sm" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="plan-group supplementals-only-plan">
                            <p class="lead">
                                Continue to Supplemental Coverage Tab
                            </p>
                        </div>
                    </div> <!-- end of tab-pane -->
                    <div class="tab-pane" id="step-six" role="tabpanel" aria-labelledby="step-six-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" style="width: 84%">6/7</div>
                        </div>
                        <hr>
                        <p class="h5">Supplemental Coverage Options</p>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="accident-protector-max-radio" id="accident-protector-max-yes" value="Yes">
                                    <label class="form-check-label" for="accident-protector-max-yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="accident-protector-max-radio" id="accident-protector-max-no" value="No" checked>
                                    <label class="form-check-label" for="accident-protector-max-no">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="acb-accident-radio" id="acb-accident-yes" value="Yes">
                                    <label class="form-check-label" for="acb-accident-yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="acb-accident-radio" id="acb-accident-no" value="No" checked>
                                    <label class="form-check-label" for="acb-accident-no">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="critical-illness-protection" id="critical-illness-protection-yes" value="Yes">
                                    <label class="form-check-label" for="critical-illness-protection-yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="critical-illness-protection" id="critical-illness-protection-no" value="No" checked>
                                    <label class="form-check-label" for="critical-illness-protection-no">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cash-cancer" id="cash-cancer-yes" value="Yes">
                                    <label class="form-check-label" for="cash-cancer-yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cash-cancer" id="cash-cancer-no" value="No" checked>
                                    <label class="form-check-label" for="cash-cancer-no">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cancer-endurance" id="cancer-endurance-yes" value="Yes">
                                    <label class="form-check-label" for="cancer-endurance-yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cancer-endurance" id="cancer-endurance-no" value="No" checked>
                                    <label class="form-check-label" for="cancer-endurance-no">
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cancer-protection" id="cancer-protection-yes" value="Yes">
                                    <label class="form-check-label" for="cancer-protection-yes">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="cancer-protection" id="cancer-protection-no" value="No" checked>
                                    <label class="form-check-label" for="cancer-protection-no">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <p class="h5">Monthly Premiums</p>
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="option-1" class="form-label">Option 1</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control" name="option-1" id="option-1" aria-describedby="optionOneHelp" placeholder="$50.00">
                                    </div>
                                    <small id="optionOneHelp" class="form-text text-muted">Dollar amount from CE3</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="form-label" for="option-2">Option 2</div>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="text" class="form-control" name="option-2" id="option-2" aria-describedby="optionTwoHelp" placeholder="$50.00">
                                    </div>
                                    <small id="optionTwoHelp" class="form-text text-muted">Dollar amount from CE3</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="step-seven" role="tabpanel" aria-labelledby="step-seven-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">7/7</div>
                        </div>
                        <hr>
                        <div class="irt-scripts">
                            <p class="h5">Introduce, Recap, Tie Down</p>
                            <div class="irt-group all-plans">
                                <p class="lead">
                                    Ok <span class="lead-first-name">[client name]</span>, every person I speak to has a different need
                                    and a different want when it comes to insuring themselves and their family. Obviously, what works for
                                    you will be different than what works for someone else, so because of that fact I'm going to briefly
                                    explain the need for these benefits.
                                </p>
                                <p class="lead supplementals-yes"> <!-- include if supplemental is yes -->
                                    The health supplements are self-explanatory. If you get hurt or sick, you want to have an income source
                                    to provide you with a financial cushion.</p>
                                <p class="lead">
                                    As far as life insurance, there are four major reasons why families purchase coverage:
                                </p>
                                <ul>
                                    <li>To cover their final expenses</li>
                                    <li>To protect their income</li>
                                    <li>To pay off their mortgage in the event of death</li>
                                    <li>And to make sure their kids can go to college</li>
                                </ul>
                                <p class="lead">
                                    These needs are typically met by applying for whole life insurance or term life insurance, and it's not
                                    uncommon to have both types of coverage in your lifetime.
                                </p>
                                <p class="lead">
                                    Typically, you want to utilize term insurance to protect temporary needs like your mortgage, your income,
                                    and sending your kids to college. You want to utilize whole life insurance to protect the cost of your final
                                    expenses because you'll always have that need and you'll need protection for your entire life, hence the term
                                    "WHOLE LIFE". Does that make sense?
                                </p>
                                <p class="lead">
                                    <span class="lead-first-name">[client name]</span>, <strong>do me a favor, grab a pen and paper to write down
                                        what we're about to discuss:
                                    </strong>
                                </p>
                            </div>
                            <div class="irt-group supplemental-irt-only">
                                <p class="h5">Introduce, Recap, Tie Down</p>
                                <p class="lead">
                                    Ok <span class="lead-first-name">[client name]</span>, because medical conditions run in your family, my system
                                    shows that you may qualify for products that will put money in your pocket if you were to ever be diagnosed with
                                    a condition, or engaged in an activity that would trigger the policy.
                                </p>
                                <p class="lead">
                                    <span class="lead-first-name">[client name]</span>, <strong>do me a favor, grab a pen and paper to write down
                                        what we're about to discuss:</strong>
                                </p>
                            </div>
                            <div class="supplemental-health-irt supplementals-yes">
                                <p class="h5">Supplemental Health IRTs</p>
                                <p class="lead">
                                    Okay <span class="lead-first-name">[client name]</span>, there are two parts to what you qualify for, the first
                                    part is the LIVING BENEFIT and the second part is Life Insurance. What we're going to cover now is the first part:
                                </p>
                                <ul>
                                    <li class="supplemental-health-irt-accident-protector-max">
                                        <p class="h5">Accident Protector Max</p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span>, this first/next benefit is designed to put money
                                            in <em><strong>your</strong></em> pocket if you were to get hurt in any way that causes you to go to
                                            the hospital or doctor. It pays you:
                                        </p>
                                        <p class="lead">
                                        <ol>
                                            <li>$500 for an ER visit</li>
                                            <li>$1,000 if you end up hospitalized</li>
                                            <li>Up to $500 per day for up to 26 weeks for any one injury</li>
                                            <li>If you have to go to the ICU it pays $1,000 per day for up to 30 days</li>
                                            <li>$300 if you need an ambulance</li>
                                            <li>$200 for specific injuries</li>
                                            <li>If you're confined to the hospital for 30 days or more, the company will
                                                pay for the cost of your policy
                                            </li>
                                            <li>The policy includes accidental death coverage that ranges from a payout of
                                                $25,000 up to $250,000
                                            </li>
                                        </ol>
                                        </p>
                                        <p class="lead">
                                            I've sent you over a brochure with a full breakdown of everything included in the policy.
                                        </p>
                                        <p class="lead">
                                            As you can see, that's a lot of financial protection, and if you've ever been to the ER,
                                            you know first hand how expensive it can be. I'm sure you see how absolutely important it
                                            is to have this type of security when life happens, right?
                                        </p>
                                        <p class="h5">Tie Down</p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span> on your paper I want you to write "Accident Pro",
                                            and to the right of "Accident Pro" I want you to write "Pays Me", <span class="spouse-inclusion d-none">and under
                                                your name write your spouse's name,</span> <span class="script-reminder">Give them time to write, don't rush.</span>
                                            <span class="spouse-inclusion d-none">To the right of your spouse's name, write down "Pays Me"</span>
                                        </p>
                                    </li>
                                    <li class="supplemental-health-irt-acb-accident-policy">
                                        <p class="h5">ACB Accident</p>
                                        <p class="lead">
                                            Ok <span class="lead-first-name">[client name]</span>, in addition to your coverage you are also going to be
                                            able to take advantage of our accident PLUS plan, and what this does is give you an additional $100,000 in the
                                            case of a standard fatal accident, $150,000 for a fatal traffic accident, and $300,000 for a fatal traveling accident.
                                        </p>
                                        <p class="lead">
                                            Now <span class="lead-first-name">[client name]</span>, I'm sure you can see how important it is to have
                                            this type of financial protection, yes?
                                        </p>
                                        <p class="h5">Tie Down</p>
                                        <p class="lead">
                                            To make sure we're on the same page, in the upper left corner of your paper, I want you to write "ACB", and to
                                            the right of "ACB" I want you to write "$100,000 - $300,000", <span class="spouse-inclusion d-none">and under your
                                                name write your spouse's name,</span> <span class="script-reminder">Give them time to write, don't rush.</span>
                                            <span class="spouse-inclusion d-none">To the right of your spouse's name, write down "$100,000 - $300,000"</span>
                                        </p>
                                    </li>
                                    <li class="supplemental-health-irt-critical-illness-protection">
                                        <p class="h5">Critical Illness</p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span>, because critical illness runs in your family, the
                                            first/next living benefit I want to go over with you is the critical illness plan. This plan pays you a
                                            lump sum cash benefit just for being diagnosed. The payout ranges from $10,000 up to $55,000 based on what
                                            you qualify for.
                                        </p>
                                        <p class="lead">I've sent you over a brochure with a full breakdown of everything included in the policy.</p>
                                        <p class="lead">
                                            I'm sure you can see how having an immediate lump sum of money can help you to get by in uncertain times, right?
                                        </p>
                                        <p class="h5">Tie Down</p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span> on your paper I want you to write "Critical Illness", and to
                                            the right of "Critical Illness" I want you to write "$________", <span class="spouse-inclusion d-none">and under your
                                                name write your spouse's name,</span> <span class="script-reminder">Give them time to write, don't rush.</span>
                                            <span class="spouse-inclusion d-none">To the right of your spouse's name, write down "$________"</span>
                                        </p>
                                    </li>
                                    <li class="supplemental-health-irt-cancer-endurance">
                                        <p class="h5">Cancer Endurance</p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span>, because cancer runs in your family, the first/next living benefit
                                            that you qualify for is the cancer endurance plan. This plan pays you money for the different treatments that you'll need
                                            if you get cancer. For example,
                                        </p>
                                        <p class="lead">
                                        <ul>
                                            <li>Just for being diagnosed with cancer, the policy will pay you $10,000</li>
                                            <li>In addition to that, every time you have a chemo treatment you'll receive $500</li>
                                            <li>If you're confined to the hospital, the policy will pay you $750 per day for the first 90 days,
                                                and $1,200 per day for every day afterward.
                                            </li>
                                            <li>If you don't believe in traditional medicine there's a holistic benefit</li>
                                            <li>If you want to travel to a special care facility the policy reimburses you for your travel and hotel stay</li>
                                            <li>The policy even pays you up to $10,000 per year for medications you need in addition to chemo</li>
                                        </ul>
                                        </p>
                                        <p class="lead">
                                            And <strong>these</strong> are just a few of the benefits that the policy offers. I've sent you over a brochure with a
                                            full breakdown of everything included with the policy because there's too much to cover on one call.
                                        </p>
                                        <p class="lead">
                                            Now <span class="lead-first-name">[client name]</span> all of the benefits will pay you directly, NOT the hospital,
                                            and NOT the doctor. There are NO taxes, NO deductibles, and NO co-pay.
                                        </p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span>, I'm sure you can see the importance of having this type of financial
                                            security if you get cancer, yes?
                                        </p>
                                        <p class="h5">Tie Down</p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span> on your paper I want you to write "Cancer Endurance", and to the
                                            right of "Cancer Endurance" I want you to write "Pays Me", <span class="spouse-inclusion d-none">and under your name
                                                write your spouse's name,</span> <span class="script-reminder">Give them time to write, don't rush.</span>
                                            <span class="spouse-inclusion d-none">To the right of your spouse's name, write down "Pays Me"</span>
                                    </li>
                                    <li class="supplemental-health-irt-cash-cancer">
                                        <p class="h5">Cash Cancer</p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span>, in addition to the base cancer policy, the cash cancer policy
                                            allows you to increase the initial diagnosis benefit from $10,000 up to a total of $50,000. This addition is important
                                            because if you get diagnosed with cancer, you won't know how it will impact you financially. We want to make sure that
                                            you're able to take care of home and focus on getting well, so we recommend starting with a minimum addition of $10,000.
                                            This will give you a total of $20,000 upon your first diagnosis.
                                        </p>
                                        <p class="lead">
                                            Now <span class="lead-first-name">[client name]</span>, having this coverage can't change getting such horrible news,
                                            but can definitely provide peace of mind when going through uncertain times. I'm sure you can see how important it is
                                            to have this type of financial protection, yes?
                                        </p>
                                        <p class="h5">Tie Down</p>
                                        <p class="lead">
                                            <span class="lead-first-name">[client name]</span> on your paper I want you to write "Cash Cancer", and to the right
                                            of "Cash Cancer" I want you to write "$10,000", <span class="spouse-inclusion d-none">and under your name write
                                                your spouse's name,</span> <span class="script-reminder">Give them time to write, don't rush.</span>
                                            <span class="spouse-inclusion d-none">To the right of your spouse's name, write down "$10,000"</span>
                                    </li>
                                    <li class="supplemental-health-irt-intensive-care-protection d-none">Intensive Care Protection</li>
                                </ul>
                            </div>
                            <div class="standard-plan-irt standard-irt-final-expense">
                                <p class="h5">Final Expense</p>
                                <p class="lead">
                                    Ok <span class="lead-first-name">[client name]</span>, based on what you've shared with me, the first/next thing that
                                    you qualify for is FINAL EXPENSE protection. The average cost of a funeral today is $15,000, however due to inflation the
                                    company recommends $30,000. Right now you have <span class="final-expense-existing-coverage-amount">$$$$</span>, so you need
                                    <span class="final-expense-coverage-needed">$$$$</span>, and you qualify for <span class="final-expense-coverage-amount">$$$$</span>.
                                </p>
                                <p class="h5">Tie Down</p>
                                <p class="lead">
                                    <span class="lead-first-name">[client name]</span> I'm sure you see how important it is to make sure your family doesn't struggle
                                    to cover the cost of your final expenses, right?
                                </p>
                                <p class="lead">
                                    To make sure we're on the same page, in the upper left corner of your paper I want you to write "Final Expense", and under
                                    "Final Expense", write your first name, <span class="spouse-inclusion d-none">and under your name write your spouse's name</span>.
                                    <span class="script-reminder">Give them time to write, don't rush.</span> To the right of your name write down
                                    <span class="final-expense-coverage-amount">$$$$</span>, <span class="spouse-inclusion d-none">and to the right of your spouse's
                                        name write down <span class="spouse-final-expense-coverage-amount">$$$$</span></span>.
                                </p>
                            </div>
                            <div class="standard-plan-irt standard-irt-income-protection">
                                <p class="h5">Income Protection</p>
                                <p class="lead">
                                    Ok <span class="lead-first-name">[client name]</span>, based on what you've shared with me, the first/next need that you
                                    have is protecting your income. Have you thought about what happens to your family's quality of life should you pass
                                    away unexpectedly? <span class="script-reminder">Let them answer, and converse accordingly.</span> To protect your income, we
                                    recommend that you replace a minimum of 2 years of your annual earnings.
                                </p>
                                <p class="lead">
                                    Right now, you have <span class="income-protection-existing-coverage-amount">$$$$</span>, so you need <span class="income-protection-coverage-needed">$$$$</span>, and you qualify for <span class="income-protection-coverage-amount">$$$$</span>.
                                </p>
                                <p class="h5">Tie Down</p>
                                <p class="lead">
                                    <span class="lead-first-name">[client name]</span>, not to be dramatic, but when your heartbeat stops, so does your income. This
                                    policy is designed to make sure your family's survival and quality of life can continue when you can no longer be here
                                    to provide. I'm sure you see how absolutely important this is, yes?
                                </p>
                                <p class="lead">
                                    Again, to make sure we're on the same page, underneath what you just wrote, I want you to write "Income Protection", and under
                                    "Income Protection", write your first name, <span class="spouse-inclusion d-none">and under your name write your spouse's name</span>.
                                    <span class="script-reminder">Give them time to write, don't rush.</span> To the right of your name write down
                                    <span class="income-protection-coverage-amount">$$$$</span>, <span class="spouse-inclusion d-none">and to the right of your spouse's
                                        name write down <span class="spouse-income-protection-coverage-amount">$$$$</span></span>.
                                </p>
                            </div>
                            <div class="standard-plan-irt standard-irt-mortgage-protection">
                                <p class="h5">Mortgage Protection</p>
                                <p class="lead">
                                    Ok <span class="lead-first-name">[client name]</span>, the first/next major need you have to protect is your mortgage.
                                    This policy is designed to pay off your mortgage balance and ensure that your family has a place to live when
                                    you can no longer be here to secure their well-being. You stated that you owe <span class="mortgage-protection-existing-coverage-amount">$$$$</span> in coverage to
                                    ensure that your family has a place to call home. With that said, we recommend <span class="mortgage-protection-coverage-needed">$$$$</span>, and you qualify for <span class="mortgage-protection-coverage-amount">$$$$</span>.
                                </p>
                                <p class="h5">Tie Down</p>
                                <p class="lead">
                                    <span class="lead-first-name">[client name]</span>, I'm sure it goes without saying that you want to protect your family's quality
                                    of life, and make sure that they'll have a roof over their head, right?
                                </p>
                                <p class="lead">
                                    To make sure we're on the same page, underneath what you just wrote, I want you to write "Mortgage Protection", and under
                                    "Mortgage Protection", write your first name, <span class="spouse-inclusion d-none">and under your name write your spouse's name</span>.
                                    <span class="script-reminder">Give them time to write, don't rush.</span> To the right of your name write down
                                    <span class="mortgage-protection-coverage-amount">$$$$</span>, <span class="spouse-inclusion d-none">and to the right of your spouse's
                                        name write down <span class="spouse-mortgage-protection-coverage-amount">$$$$</span></span>.
                                </p>
                            </div>
                            <div class="standard-plan-irt standard-irt-ce-protection">
                                <p class="h5">Children's Education</p>
                                <p class="lead">
                                    <span class="lead-first-name">[client name]</span>, the next major need you have to protect is your children's ability
                                    to go to college. If you're not here to secure their education, this policy is to make sure that your kids can go to college
                                    without having to apply for student loans.
                                </p>
                                <p class="lead">
                                    Right now you have <span class="ce-protection-existing-coverage-amount">$$$$</span> saved for their education, so we recommend
                                    <span class="ce-protection-coverage-needed">$$$$</span>, and you qualify for <span class="ce-protection-coverage-amount">$$$$</span>.
                                </p>
                                <p class="h5">Tie Down</p>
                                <p class="lead">
                                    <span class="lead-first-name">[client name]</span>, I'm sure you see how absolute important it is to make sure that
                                    your child(ren) can go to college, right? Underneath what you just wrote, I want you to write "Children's Education", and
                                    under "Children's Education", write your first name, <span class="spouse-inclusion d-none">and under your name write your spouse's name</span>.
                                    <span class="script-reminder">Give them time to write, don't rush.</span> To the right of your name write down
                                    <span class="ce-protection-coverage-amount">$$$$</span>, <span class="spouse-inclusion d-none">and to the right of your spouse's
                                        name write down <span class="spouse-ce-protection-coverage-amount">$$$$</span></span>.
                                </p>
                            </div>
                            <div class="alx-plan-irt alx-irt-final-expense">
                                <p class="h5">Final Expense</p>
                                <p class="lead">
                                    Ok <span class="lead-first-name">[client name]</span>, when it comes to life insurance, based on the answers you gave
                                    in the needs survey, I have good news and I have indifferent news!
                                </p>
                                <p class="lead">The indifferent news is that you do not qualify for traditional coverage. However, the good news is
                                    that we are able to get you covered today.
                                </p>
                                <p class="lead">
                                    What's bad about the policy is that it costs more for you to have, and there is a three year waiting period for natural
                                    causes of death. During the three year period, if you were to pass from an accident the full face amount would be paid
                                    to your beneficiary. If you pass from natrual causes in the three year period, your beneficiary will receive all
                                    premiums paid into the policy, plus an additional 10% for each year the policy was active.
                                </p>
                                <p class="lead">
                                    Additionaly, this policy is a whole life policy, which is the most secure form of insurance that you can acquire. The
                                    rate is guaranteed, so your premium is locked in for life, there's no physical exam required to get coverage, the policy
                                    builds cash value, and the policy is paid up in 20 years. <span class="lead-first-name">[client name]</span>, right now
                                    you have <span class="final-expense-existing-coverage-amount">$$$$</span>, so you need <span class="final-expense-coverage-needed">$$$$</span>.
                                    The good news is that you qualify for <span class="final-expense-coverage-amount">$$$$</span>.
                                </p>
                                <p class="h5">Tie Down</p>
                                <p class="lead">
                                    <span class="lead-first-name">[client name]</span>, most insurance companies wouldn't be able to offer you coverage <strong>at all</strong>
                                    based on your answers to the survey. I'm sure you must be relieved that we can help, and I'm sure you can see how absolutely important
                                    it is to take advantage of this coverage today, right?
                                </p>
                                <p class="lead">
                                    To make sure we're on the same page, in the upper left corner of your paper I want you to write "Guaranteed Life", and under
                                    "Guaranteed Life", write your first name, <span class="spouse-inclusion d-none">and under your name write your spouse's name</span>.
                                    <span class="script-reminder">Give them time to write, don't rush.</span> To the right of your name write down
                                    <span class="final-expense-coverage-amount">$$$$</span>, <span class="spouse-inclusion d-none">and to the right of your spouse's
                                        name write down <span class="spouse-final-expense-coverage-amount">$$$$</span></span>.
                                </p>
                                <div class="lead head-start-irt">
                                    <p class="lead">

                                        In addition to covering your final expenses, my system also shows that your children qualify for the Head Start
                                        program. This allows you to take advantage of coverage for them today and add additional coverage two more times
                                        over the next few years without proving insurability. I'm sure you see how important it is to secure coverage
                                        for your kids while they are still young and healthy, right?
                                    </p>
                                    <p class="lead">
                                        To make sure we're on the same page, in the upper left corner of your paper I want you to write "Head Start", and under
                                        "Head Start", write your child's name, <span class="script-reminder">Give them time to write, don't rush.</span>
                                        To the right of their name write down <span class="head-start-coverage-amount">$$$$</span>.
                                        <span class="script-reminder">
                                            If they have more than one child, repeat the process for each child.
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="final-recap-scripts">
                            <p class="h5">Final Recap</p>
                            <p class="lead">
                                We have your
                            <ul class="coverage-items-selected">
                                <li class="coverage-item-accident-protector-max">
                                    <strong>Accident Pro Max</strong> plan that pays YOU if you go to the
                                    hospital or doctor for accidental injuries
                                </li>
                                <li class="coverage-item-cash-cancer"><strong>Cash Cancer</strong></li>
                                <li class="coverage-item-cancer-endurance"><strong>Cancer Endurance</strong></li>
                                <li class="coverage-item-intensive-care"><strong>Intensive Care</strong></li>
                                <li class="coverage-item-critical-illness"><strong>Critical Illness</strong></li>
                                <li class="coverage-item-acb-accident">Accident Plus Plan</li>
                                <li class="coverage-item-final-expense">Final Expenses covered,</li>
                                <li class="coverage-item-income-protection">Income protected,</li>
                                <li class="coverage-item-mortgage-proection">Mortgage protected,</li>
                                <li class="coverage-item-ce-protection">(and) the ability for your kids to go to college covered as well.</li>
                            </ul>
                            If it all makes sense, then starting today you've taken an important step to being properly protected.
                            This plan is intended to meet your needs. My system shows that you have two options, and both options cover everything we just discussed.
                            The difference between the two is that the first option includes inflation for Final Expense, and the second does not.
                            <span class="lead-first-name">[client name]</span>, this will be the last thing I ask you to write down today,
                            Option 1 is <span class="option-1-amount">$$$$</span>, and Option 2 is <span class="option-2-amount">$$$$</span>. <span class="script-reminder">
                                Give them time to write, don't rush.
                            </span> <strong>Which option works best for you?</strong>
                            </p>
                        </div>
                        <hr>
                        <div class="rebuttals-radio">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has-rebuttals" id="rebutalls-yes" value="Yes">
                                <label class="form-check-label" for="rebutalls-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="has-rebuttals" id="rebuttals-no" value="No" checked>
                                <label class="form-check-label" for="rebuttals-no">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="rebuttals-script-container d-none">
                            <p class="h5">I already have insurance.</p>
                            <p class="lead">Yes, you do have insurance, and the needs analysis has already taken that into consideration. Simply put, what you have is good, but it's <strong>just not enough</strong> to cover your needs. It's better for you to do something about it now while you still can, rather than when it's too late. The good news is that you still have two options! <strong>Which option works best for you?</strong></p>
                            <p class="h5">I need to think about it.</p>
                            <p class="lead"><strong>Yes</strong>, you do need to think about it. It's a big decision for you and your family! Fortunately, I help families think about it every day.</p>
                            <p class="lead">It usually comes down to one or two things, <strong>"do I need this?"</strong>, or <strong>"can I afford it?"</strong>.</p>
                            <p class="lead">Now, we just talked about how you see the importance of having your final expenses covered, your income protected, your mortgage protected, and the ability to send your kids to college taken care of. You told me you saw those as absolutely important, so you don't really need to think about that.</p>
                            <p class="lead">Really, it just comes down to affordability.</p>
                            <p class="lead">Now, I don't pretend to know anyone's financial situation, but let me ask you a question. What do you think will have a bigger impact on your family? Having the premiums you wrote down in the bank? Or having these needs taken care of?</p>
                            <p class="lead">Either way, the important thing is to get started today. The good news is that you have two options. So, if option one is too much, you can always start with option two and increase it later. <strong>Which option works best for you? </strong></p>
                            <p class="h5">I can't afford it.</p>
                            <p class="lead">Ok, I understand. Let me ask you, you understand how important this is right? So here's what we can do: let's adjust the Final Expense benefit to $15,000. That should help cover the cost of a funeral. Your income protection will remain the same, along with your mortgage coverage and the college education benefit. Let's recalculate and see where we're at. Does _____ make you feel better?</p>
                        </div>
                        <hr>
                        <div class="down-closing-radio">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="down-closing-radio" id="down-closing-yes" value="Yes">
                                <label class="form-check-label" for="down-closing-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="down-closing-radio" id="down-closing-no" value="No" checked>
                                <label class="form-check-label" for="down-closing-no">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="down-closing-script-container d-none">
                            <p class="h5">Down Closing</p>
                            <p class="lead">When there is no breakthrough on the price of the program, and the offer must be reduced, follow the process below.</p>
                            <p class="lead"><strong>Drop 3: $15,000 WL to $10,000 WL</strong></p>
                            <p class="lead">I understand and appreciate your concern. I know you understand how important this is so here's what we can do: let's adjust this Final Expense benefit to $10,000, this should still help cover the costs of your final expenses, and everything else we discussed will remain the same. Does this make you feel better?</p>
                            <p class="lead"><span style="background-color:#FBF719;">If <strong>yes:</strong></span> <span class="lead-first-name">[client name]</span>, under final expense on your paper, please cross out the amount that you previously wrote and write down the new amount: $10,000.</p>
                            <p class="lead"><strong>Drop 4: $10,000 WL to $7,500 WL</strong></p>
                            <p class="lead">So to ensure that we can cover the base cost of your Final Expenses, we can drop your coverage down to $7,500, and everything else will remain the same. How does that sound?</p>
                            <p class="lead"><span style="background-color:#FBF719;">If <strong>yes:</strong></span> <span class="lead-first-name">[client name]</span>, under final expense on your paper, please cross out the amount that you previously wrote and write down the new amount: $7,500.</p>
                            <p class="lead"><strong>Drop 5: Income Protection</strong></p>
                            <p class="lead">To make sure your needs are covered, we will leave the Final Expense benefit at $7,500 and adjust your income protection from 2 years to 1 year. That way, your needs are still covered, and when things get better, you can always increase them later. Give me a moment to recalculate your coverage. <strong><em><span style="background-color:#FBF719;">(pregnant pause and state the new premium)</span></em></strong> Is that affordable for you?</p>
                            <p class="lead"><strong>Drop 5: Determine Budget</strong></p>
                            <p class="lead"><span class="lead-first-name">[client name]</span>, we've gone through several options to make sure that you're properly protected. I understand that affordability is your main concern. So, to make sure that we get you all the coverage you need at a price point you can afford, what is your budget?</p>
                            <p class="lead"><span style="background-color:#FBF719;"><em><strong>(Determine what is realistic for the client and proceed to close)</strong></em></span></p>
                        </div>
                        <hr>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>