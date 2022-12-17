<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <?php



    ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/r-2.4.0/sp-2.1.0/sl-1.5.0/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/r-2.4.0/sp-2.1.0/sl-1.5.0/datatables.min.js"></script>
    <title>Leads</title>
</head>

<body>


    <main>
        <!-- full width and height container -->
        <div class="base-sidebar container-fluid">
            <div class="row flex-nowrap">
                <?php echo BaseCRM::include_navbar(); ?>
                <div class="main-content col">
                    <div class="row mt-3">
                        <div class="col">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="view-tab" data-bs-toggle="tab" data-bs-target="#view" type="button" role="tab" aria-controls="view" aria-selected="true">View</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="create-lead-tab" data-bs-toggle="tab" data-bs-target="#create-lead" type="button" role="tab" aria-controls="create-lead" aria-selected="false">Create</button>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="view" role="tabpanel" aria-labelledby="view-tab">
                                    <div class="lead-table-container">
                                        <div class="row mt-3">
                                            <div class="col">
                                                <h3>Your Leads</h3>
                                                <table class="table table-striped table-bordered" id="lead-table" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Updated</th> <!-- 1 -->
                                                            <th>First Name</th> <!-- 2 -->
                                                            <th>Last Name</th> <!-- 3 -->
                                                            <th>Phone</th> <!-- 4 -->
                                                            <th>Disposition</th> <!-- 5 -->
                                                            <th>Actions</th> <!-- 6 -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="create-lead" role="tabpanel" aria-labelledby="create-lead-tab">
                                    <?php echo BaseCRM::snip('create-lead-form'); ?>
                                </div>
                            </div>

                            <!-- Loading Overlay for #lead-table -->
                            <div class="lead-table-loading-overlay">
                                <div class="spinner-border text-primary" role="status">
                                </div>
                                &nbsp;
                                <span class="loading-text">Initializing...</span>
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