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
            <form id="presentation-form" class="presentation-form" action="">
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
                                <input class="form-check-input" type="radio" name="plan-type" id="standard-plan" value="Standard">
                                <label class="form-check-label" for="standard-plan">
                                    Standard
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plan-type" id="alx-plan" value="ALX">
                                <label class="form-check-label" for="alx-plan">
                                    ALX
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plan-type" id="alx-head-start-plan" value="ALX w/ Children (Head Start)">
                                <label class="form-check-label" for="alx-head-start-plan">
                                    ALX w/ Children (Head Start)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="plan-type" id="supplementals-only-plan" value="Supplementals Only">
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
                        <div class="standard-plan">
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
                                <div class="row d-none" id="final-expense-spouse-row">
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
                                    <div class="col-3 spouse-final-expense-field">
                                        <p class="lead">Existing Coverage</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-final-expense-existing-coverage" id="spouse-final-expense-existing-coverage" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-final-expense-field">
                                        <p class="lead">Amount Needed</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-final-expense-amount-needed" id="spouse-final-expense-amount-needed" disabled>
                                        </div>
                                    </div>
                                    <div class="col-3 spouse-final-expense-field">
                                        <p class="lead">Qualified Amount</p>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control" placeholder="5000.00" aria-label="Amount (to the nearest dollar)" name="spouse-final-expense-qualified-amount" id="spouse-final-expense-qualified-amount" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end final expense -->
                            .
                        </div>
                    </div>
                    <div class="tab-pane" id="step-six" role="tabpanel" aria-labelledby="step-six-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" style="width: 84%">6/7</div>
                        </div>
                        <hr>
                        Step Six content
                    </div>
                    <div class="tab-pane" id="step-seven" role="tabpanel" aria-labelledby="step-seven-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">7/7</div>
                        </div>
                        <hr>
                        Step Seven Content
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>