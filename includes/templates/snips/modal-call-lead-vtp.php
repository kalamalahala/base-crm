<?php

use BaseCRM\ServerSide\Lead;

$lead = new Lead();
$lead_types = $lead->lead_types();

?>
<div class="modal fade" id="modal-call-lead-vtp" tabindex="-1" role="dialog" aria-labelledby="call-lead-title" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="call-lead-title">Call Lead</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="call-lead-form-vtp">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <label for="script-select" class="input-group-text">Select Script</label>
                                <select name="script-select" id="script-select" class="form-select">
                                    <option value="Select a Script" selected>Select a Script</option>
                                    <?php
                                    foreach ($lead_types as $short => $long) {
                                        $allowed_types = array(
                                            'vtp', // just the one for now for testing
                                        );
                                        $disabled = in_array($short, $allowed_types) ? true : 'disabled';
                                        if ($disabled !== true) continue;
                                        echo "<option value='$short' $disabled>$long</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php echo BaseCRM::snip('script-vtp'); ?>
                    <!-- Does the client have a job? Yes/No radio -->
                    <!-- <div class="row employment-question d-none">
                        <div class="col-12">
                            <p class="h4">Employed?</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lead-is-employed" id="lead-is-employed-yes" value="Yes">
                                <label class="form-check-label" for="lead-is-employed-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lead-is-employed" id="lead-is-employed-no" value="No" checked>
                                <label class="form-check-label" for="lead-is-employed-no">
                                    No
                                </label>
                            </div>
                        </div>
                    </div> -->
                    <!-- Conversation Notes Textarea -->
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea name="conversation-notes" id="conversation-notes" class="form-control mb-3" style="height: 115px;"></textarea>
                                <label for="conversation-notes">Conversation Notes</label>
                            </div>
                        </div>
                    </div>
                    <!-- Rebuttals? Yes/No -->
                    <!-- <div class="row rebuttals-question d-none">
                        <div class="col-12">
                            <p class="h4">Rebuttals?</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lead-has-rebuttals" id="lead-has-rebuttals-yes" value="Yes">
                                <label class="form-check-label" for="lead-has-rebuttals-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input type="radio" class="form-check-input" name="lead-has-rebuttals" id="lead-has-rebuttals-no" value="No" checked>
                                <label class="form-check-label" for="lead-has-rebuttals-no">
                                    No
                                </label>
                            </div>
                        </div>
                    </div> -->
                    <?php // echo BaseCRM::snip('script-rebuttals'); 
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <p class="lead">OK, this is what I'll do, I'll call you <span class="referral-text">(choose a day)</span> at <span class="referral-text">(choose a time)</span> <span class="script-reminder">Give two time options. For example, if the client wants to set for 5, ask if they'd like you to call betwen 5 & 5:30, or 5:30 & 6.</span></p>
                            <p class="lead">Do me a favor, grab a pen and paper <span class="script-reminder">(provide name, time, agent number & ask to repeat)</span></p>
                            <p class="lead">To secure our appointment, I have a few questions:</p>
                        </div>
                    </div>
                    <h4>Tie Down Information</h4>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="h4">What is your email address?</p>
                            <div class="input-group has-validation mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                <input type="text" class="form-control" name="lead-email" id="lead-email" placeholder="Email Address" aria-label="Email Address" aria-describedby="lead-email">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="col-12">

                            <button id="send-client-registration-email" class="btn btn-primary w-100"><i class="fa-solid fa-envelope"></i> Send Client Registration Email</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12" id="married-col">
                            <p class="h4">Is <span class="lead-first-name">name</span> married?</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lead-is-married" id="lead-is-married-yes" value="Yes">
                                <label class="form-check-label" for="lead-is-married-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="lead-is-married" id="lead-is-married-no" value="No" checked>
                                <label class="form-check-label" for="lead-is-married-no">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 d-none" id="married-col-2">
                            <p class="h4">Spouse's Name</p>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" name="lead-spouse-first-name" id="lead-spouse-first-name" placeholder="Spouse's Name" aria-label="Spouse's Name" aria-describedby="spouse-name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="children-col">
                            <p class="h4">Does <span class="lead-first-name">name</span> have children?</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lead-has-children" id="lead-has-children-yes" value="Yes">
                                <label class="form-check-label" for="lead-has-children-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="lead-has-children" id="lead-has-children-no" value="No" checked>
                                <label class="form-check-label" for="lead-has-children-no">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6 d-none" id="children-col-2">
                            <p class="h4">Enter number of children:</p>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" name="lead-num-children" id="lead-num-children" placeholder="Number of Children" aria-label="Number of Children" aria-describedby="spouse-name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="lead">
                                You may qualify for additional products that we offer. If so, you would need to bank with a traditional bank or a credit union. Do you currently use a local bank, credit union or pre-paid card for your checking needs?
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p class="h4">
                                Does <span class="lead-first-name">name</span> use a major bank?
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lead-bank" id="lead-bank-yes" value="Yes">
                                <label class="form-check-label" for="lead-bank-yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="lead-bank" id="lead-bank-no" value="No" checked>
                                <label class="form-check-label" for="lead-bank-no">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" class="form-control" name="lead-bank-name" id="lead-bank-name" placeholder="Bank Name" aria-label="Bank Name" aria-describedby="lead-bank-name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h4>Tie Down</h4>
                            <hr>
                            <p class="lead">
                                <span class="lead-first-name">(client name),</span> I'm sending you a calendar invite now. This does two things:
                            </p>
                            <p class="lead">
                            <ol>
                                <li class="lead">It serves as a reminder for you, and</li>
                                <li class="lead">it secures your appointment time on my schedule so that no other family can book that time.</li>
                            </ol>
                            </p>
                            <p class="lead">Again, that appointment time will be <span class="script-reminder">Repeat appointment day and time</span>.</p>
                            <p class="lead">
                            <ul>
                                <li class="lead">
                                    Now <span class="lead-first-name">(client name)</span> by reserving this time, I will not be available for any other family,
                                    and there are a lot of people who need my help. So, is there anything that may prevent us from speaking at <span class="script-reminder">Repeat appointment day and time</span>?
                                </li>
                            </ul>
                            </p>
                            <p class="lead">
                                Talk to you soon, have a great day!
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h4>Name and Phone Number</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" class="form-control" name="lead-first-name" id="lead-first-name" placeholder="First Name" aria-label="First Name" aria-describedby="lead-first-name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" class="form-control" name="lead-last-name" id="lead-last-name" placeholder="Last Name" aria-label="Last Name" aria-describedby="lead-last-name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                        <input type="text" class="form-control" name="lead-phone" id="lead-phone" placeholder="Phone Number" aria-label="Phone Number" aria-describedby="lead-phone">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row">
                        <div class="col">
                            <h4>Pick Appointment Time</h4>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                                        <input type="text" class="form-control" name="lead-appointment-date" id="lead-appointment-date" placeholder="Appointment Date" aria-label="Appointment Date" aria-describedby="lead-appointment-date">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="call-lead-submit">Finish Call & Send Intake Form</button>
                </div>
                <input type="hidden" name="ccid" value="base">
                <input type="hidden" name="bid" value="base">
                <input type="hidden" name="lead_id" id="lead-id" value="">
            </form>
        </div>
    </div>
</div>