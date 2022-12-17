<?php

// namespace BaseCRM;
use BaseCRM\ServerSide\Lead;

$lead = new Lead();
$lead_types = $lead->lead_types();

?>


<div class="form-component-container p-2">
    <!-- Bootstrap 5 -->
    <form action="#" id="create-lead-form">
        <div class="row my-3">
            <div class="col-12">
                <h3>Create Lead</h3>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text" id="first-name-prefix"><i class="fa-solid fa-signature"></i></span>
                    <input type="text" name="first-name-field" id="first-name-field" class="form-control" placeholder="First Name" aria-describedby="first-name-prefix">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text" id="last-name-prefix"><i class="fa-solid fa-signature"></i></span>
                    <input type="text" name="last-name-field" id="last-name-field" class="form-control" placeholder="Last Name" aria-describedby="last-name-prefix">
                </div>
            </div>
        </div>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <div class="input-group has-validation">
                    <span class="input-group-text" id="phone-prefix"><i class="fa-solid fa-phone"></i></span>
                    <input type="text" name="phone-field" id="phone-field" class="form-control" placeholder="Phone" aria-describedby="phone-prefix">
                    <span class="invalid-feedback"></span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group has-validation">
                    <span class="input-group-text" id="email-prefix"><i class="fa-solid fa-envelope"></i></span>
                    <input type="text" name="email-field" id="email-field" class="form-control" placeholder="Email" aria-describedby="email-prefix">
                    <span class="invalid-feedback">Required</span>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="is-married">Married / Significant Other? &nbsp;</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is-married" id="is-married-yes" value="Yes">
                    <label class="form-check-label" for="is-married-yes">Yes</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="is-married" id="is-married-no" value="No" checked>
                    <label class="form-check-label" for="is-married-no">No</label>
                </div>
            </div>
        </div>
        <div class="row mb-3 d-none" id="spouse-name-container">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text" id="spouse-first-name-prefix"><i class="fa-solid fa-signature"></i></span>
                    <input type="text" name="spouse-first-name-field" id="spouse-first-name-field" class="form-control" placeholder="Spouse First Name" aria-describedby="spouse-first-name-prefix" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text" id="spouse-last-name-prefix"><i class="fa-solid fa-signature"></i></span>
                    <input type="text" name="spouse-last-name-field" id="spouse-last-name-field" class="form-control" placeholder="Spouse Last Name" aria-describedby="spouse-last-name-prefix" disabled>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="lead-type" class="form-label">Lead Type</label>
                <select class="form-select" name="lead-type" id="lead-type">
                    <option selected>Select Lead Type</option>
                    <?php
                    foreach ($lead_types as $short => $long) {
                        echo "<option value='$short'>$long</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <h3>Referral Information</h3>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text" id="referred-by-prefix"><i class="fa-solid fa-user"></i> Referred By</span>
                    <input type="text" name="lead-referred-by" id="referred-by" class="form-control" placeholder="Enter name of referrer">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text" id="referred-by-relationship-prefix">
                        <i class="fa-solid fa-user"></i> Relationship to Referrer
                    </span>
                    <input type="text" name="lead-relationship" id="referred-by-relationship" class="form-control" placeholder="Enter relationship to referrer">
                </div>
            </div>
        </div>
        <div class="row mb-3 d-none" id="lead-notes-container">
            <div class="col-md-12">
                <label for="lead-notes" class="form-label">Notes</label>
                <textarea class="form-control" name="lead-notes" id="lead-notes" rows="3" placeholder="Notes are only displayed to The Johnson Group agents." disabled></textarea>
            </div>
        </div>
        <!-- Submit / Reset -->
        <div class="row mb-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary" id="create-lead-btn"><i class="fa-solid fa-check"></i> Create New Lead</button>
                <button type="reset" class="btn btn-secondary" id="create-lead-reset-btn"><i class="fa-regular fa-trash-can"></i> Reset</button>
            </div>
        </div>
        <div class="row mb-3">
            <!-- Success -->
            <div class="col-md-12">
                <div class="alert alert-success d-none" role="alert" id="create-lead-success">
                    <i class="fa-solid fa-check-circle"></i> <span id="create-lead-success-text">Lead created successfully!</span>
                </div>
            </div>
            <!-- Error -->
            <div class="col-md-12">
                <div class="alert alert-danger d-none" role="alert" id="create-lead-error">
                    <i class="fa-solid fa-exclamation-circle"></i> <span id="create-lead-error-text">There was an error creating the lead. Please try again.</span>
                </div>
            </div>
            <!-- Validation -->
            <div class="col-md-12">
                <div class="alert alert-danger d-none" role="alert" id="create-lead-validation">
                    <i class="fa-solid fa-exclamation-circle"></i> <span id="create-lead-validation-text">Please fill out all required fields.</span>
                </div>
            </div>
        </div>
    </form>
</div>