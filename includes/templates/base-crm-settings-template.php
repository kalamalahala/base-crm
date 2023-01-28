<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <?php

    // use BaseCRM\BaseCRM;

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
                </div>
            </div>
        </div>
    </main>


</body>
<?php wp_footer(); ?>

</html>