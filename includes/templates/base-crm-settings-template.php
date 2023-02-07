<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/r-2.4.0/sp-2.1.0/sl-1.5.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/r-2.4.0/sp-2.1.0/sl-1.5.0/datatables.min.js"></script>

    <title>Document</title>
</head>

<body>


    <main> <!-- full width and height container -->
        <div class="base-sidebar container-fluid">
            <div class="row flex-nowrap">
                <?php echo BaseCRM::include_navbar(); ?>
                <div class="main-content col">
                    <div class="lead-table-container">
                        <div class="row mt-3">
                            <div class="col">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" id="assignLeadsTabList" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="assignLeads-tab" data-bs-toggle="tab" data-bs-target="#assignLeads" type="button" role="tab" aria-controls="assignLeads" aria-selected="true">Assign Leads</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="createIndividualLeads-tab" data-bs-toggle="tab" data-bs-target="#createIndividualLeads" type="button" role="tab" aria-controls="createIndividualLeads" aria-selected="false">Create Individual Leads</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="bulkUploadLeads-tab" data-bs-toggle="tab" data-bs-target="#bulkUploadLeads" type="button" role="tab" aria-controls="bulkUploadLeads" aria-selected="false">Bulk Upload</button>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="assignLeads" role="tabpanel" aria-labelledby="assignLeads-tab">
                                        <div class="row p-3 mb-3">
                                            <div class="col-12 d-flex flex-row">
                                                <p class="h3 mx-3 mb-3"><?php echo BaseCRM::i18n('All Leads'); ?></p>
                                                <form id="admin-assign-leads" action="" class="row row-cols-lg-auto g-3 align-items-center">
                                                    <div class="col-12">
                                                        <div class="form-floating">
                                                            <select name="assign-to" id="assignTo" class="form-select" style="width:200px;">
                                                                <option value="" selected>Assign To</option>
                                                                <?php
                                                                $users = BaseCRM::get_all_user_names();
                                                                foreach ($users as $key => $user) {
                                                                    echo '<option value="' . $key . '">' . $user . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                            <label for="assignTo"><?php echo BaseCRM::i18n('Select an Agent'); ?></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary leads-submit"><?php echo BaseCRM::i18n('Assign'); ?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row pb-3 mb-3">
                                            <div class="col-12">
                                                <!-- AJAX DataTable -->
                                                <table id="admin-table" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Select</th>
                                                            <th>Name</th>
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                            <th>Source</th>
                                                            <th>Created At</th>
                                                            <th>Assigned To</th>
                                                            <th>Disposition</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="createIndividualLeads" role="tabpanel" aria-labelledby="createIndividualLeads-tab">
                                        <form action="" method="" id="referrals-form">
                                            <input type="hidden" name="user-id" value="<?php echo $user_id; ?>">
                                            <input type="hidden" name="lead-id" value="0">
                                            <input type="hidden" name="appointment-id" value="0">
                                        </form>
                                        <div class="referrals-form-container mb-5"> <!-- Referrals Form -->
                                            <div class="row">
                                                <div class="col">
                                                    <p class="h1">Collect Referrals <span class="badge bg-primary" id="referral-count"><span class="referral-count-num">0</span> <i class="fa-solid fa-user"></i></span></p>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="referral-first-name" placeholder="First Name" id="firstNameFloating" class="form-control" form="referrals-form">
                                                        <label for="firstNameFloating">First Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="referral-last-name" placeholder="Last Name" id="lastNameFloating" class="form-control" form="referrals-form">
                                                        <label for="lastNameFloating">Last Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="input-group has-validation mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="referral-phone" placeholder="Phone Number" id="phoneFloating" class="form-control" form="referrals-form">
                                                            <label for="phoneFloating">Phone</label>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Enter a valid phone number.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group mb-3">
                                                        <div class="form-floating">
                                                            <!-- <input type="text" name="referral-spouse-name" placeholder="Spouse's Name" id="spouseNameFloating" class="form-control" form="referrals-form">
                                                            <label for="spouseNameFloating">Spouse's Name</label> -->
                                                            <input type="text" name="referral-dob" id="referral-dob" placeholder="Date of Birth" class="form-control" form="referrals-form">
                                                            <label for="referral-dob">Date of Birth</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- email address row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="referral-email" placeholder="Email Address" id="emailFloating" class="form-control" form="referrals-form">
                                                            <label for="emailFloating">Email Address</label>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Enter a valid email address.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- address row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="referral-street-address" placeholder="Address" id="addressFloating" class="form-control" form="referrals-form">
                                                            <label for="addressFloating">Street Address</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- line 2 -->
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="input-group mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="referral-city" placeholder="City" id="cityFloating" class="form-control" form="referrals-form">
                                                            <label for="cityFloating">City</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="input-group mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="referral-state" placeholder="State" id="stateFloating" class="form-control" form="referrals-form">
                                                            <label for="stateFloating">State</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="input-group mb-3">
                                                        <div class="form-floating">
                                                            <input type="text" name="referral-zip" placeholder="Zip Code" id="zipFloating" class="form-control" form="referrals-form">
                                                            <label for="zipFloating">Zip Code</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <!-- <div class="col-6"> -->
                                                    <!-- Relationship to Referrer Text -->
                                                    <!--
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="relationship-to-referrer" placeholder="Relationship to Referrer" id="relationshipToReferrerFloating" class="form-control" form="referrals-form">
                                                        <label for="relationshipToReferrerFloating">Relationship to Referrer</label>
                                                    </div>
                                                </div> -->
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <textarea class="form-control" name="referral-notes" id="referralNotesFloating" style="height:100px;" placeholder="Notes" form="referrals-form"></textarea>
                                                        <label for="referralNotesFloating">Notes</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <!-- Submit #referrals-form -->
                                                    <button type="button" class="btn btn-primary btn-lg btn-whos-next">Who's Next?</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="alert alert-success alert-dismissible fade show d-none" id="referral-success" role="alert">
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>Success!</strong> <span class="alert-first-name">[client name]</span> has been added to your referral list.
                                                    </div>

                                                    <div class="alert alert-danger alert-dismissible fade show d-none" id="referral-error" role="alert">
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        <strong>Error!</strong> <span class="alert-first-name">[client name]</span>'s email or phone number already exists.
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="debug-output">
                                            test
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="bulkUploadLeads" role="tabpanel" aria-labelledby="bulkUploadLeads-tab">
                                        <p class="h2 mt-3">Bulk Upload</p>
                                        <hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-success alert-dismissible fade show d-none" id="bulk-upload-success" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>Success!</strong> <span class="alert-first-name">[client name]</span> has been added to your referral list.
                                                </div>

                                                <div class="alert alert-danger alert-dismissible fade show d-none" id="bulk-upload-error" role="alert">
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    <strong>Error!</strong> <span class="alert-first-name">[client name]</span> has already been added to your referral list.
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <form action="" id="bulk-upload-form">
                                                    <div class="input-group mb-3">
                                                        <input type="file" class="form-control" id="bulk-upload-leads" name="bulk-upload-leads" aria-describedby="file-upload-reset" aria-label="Clear" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                                        <button class="btn btn-outline-danger" type="button" id="file-upload-reset" onclick="jQuery('#bulk-upload-leads').val('');jQuery('.upload-contents').html('');">Clear</button>
                                                    </div>
                                                    <div class="upload-contents mb-3">

                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Upload Leads</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>


</body>
<?php wp_footer(); ?>

</html>