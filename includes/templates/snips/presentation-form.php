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
            <span class="presentation-lead-type h3 mb-0">Client Name</span>
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
                    <button class="nav-link active" id="begin-tab" data-bs-toggle="tab" data-bs-target="#begin" type="button" role="tab" aria-controls="begin" aria-selected="true">Script Select</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-one-tab" data-bs-toggle="tab" data-bs-target="#step-one" type="button" role="tab" aria-controls="step-one" aria-selected="false">Step One</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-two-tab" data-bs-toggle="tab" data-bs-target="#step-two" type="button" role="tab" aria-controls="step-two" aria-selected="false">Step Two</button>
                </li>
                <!-- Step Three -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-three-tab" data-bs-toggle="tab" data-bs-target="#step-three" type="button" role="tab" aria-controls="step-three" aria-selected="false">Step Three</button>
                </li>
                <!-- Step Four -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-four-tab" data-bs-toggle="tab" data-bs-target="#step-four" type="button" role="tab" aria-controls="step-four" aria-selected="false">Step Four</button>
                </li>
                <!-- Step Five -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-five-tab" data-bs-toggle="tab" data-bs-target="#step-five" type="button" role="tab" aria-controls="step-five" aria-selected="false">Step Five</button>
                </li>
                <!-- Step Six -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-six-tab" data-bs-toggle="tab" data-bs-target="#step-six" type="button" role="tab" aria-controls="step-six" aria-selected="false">Step Six</button>
                </li>
                <!-- Step Seven -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="step-seven-tab" data-bs-toggle="tab" data-bs-target="#step-seven" type="button" role="tab" aria-controls="step-seven" aria-selected="false">Step Seven</button>
                </li>
            </ul>
        </div>
    </div> <!-- End Row -->
    <div class="row">
        <div class="col-12">
            <!-- Tab panes -->
            <form id="presentation-form" class="presentation-form" action="">
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

                                    <select name="presentation-script-select" id="presentation-script-select">
                                        <option selected><?php echo BaseCRM::i18n('Choose a script'); ?></option>
                                        <?php
                                        foreach ($scripts as $id => $name) {
                                            echo '<option value="' . $id . '">' . $name . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-primary" id="presentation-script-select-button"><?php echo BaseCRM::i18n('Begin Presentation'); ?></button>
                            </div>
                            <?php
                            echo '<pre>';
                            foreach ($scripts as $id => $script) {
                                print_r($id . ' - ' . $script);
                                echo '<br>';
                            }
                            echo '</pre>';
                            ?>
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
                                <div class="cskw d-none" id="cskw">
                                    CSKW Script - Empty
                                </div>
                                <!-- CSKR -->
                                <div class="cskr d-none" id="cskr">
                                    CSKR - Empty
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
                    </div>
                    <div class="tab-pane" id="step-two" role="tabpanel" aria-labelledby="step-two-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100" style="width: 28%">2/7</div>
                        </div>
                        Step Two Content
                    </div>
                    <div class="tab-pane" id="step-three" role="tabpanel" aria-labelledby="step-three-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="42" aria-valuemin="0" aria-valuemax="100" style="width: 42%">3/7</div>
                        </div>
                        Step Three Content
                    </div>
                    <div class="tab-pane" id="step-four" role="tabpanel" aria-labelledby="step-four-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100" style="width: 56%">4/7</div>
                        </div>
                        Step Four Content
                    </div>
                    <div class="tab-pane" id="step-five" role="tabpanel" aria-labelledby="step-five-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">5/7</div>
                        </div>
                        Step Five Content
                    </div>
                    <div class="tab-pane" id="step-six" role="tabpanel" aria-labelledby="step-six-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" style="width: 84%">6/7</div>
                        </div>
                        Step Six content
                    </div>
                    <div class="tab-pane" id="step-seven" role="tabpanel" aria-labelledby="step-seven-tab">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">7/7</div>
                        </div>
                        Step Seven Content
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>