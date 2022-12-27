<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <?php

    /**
     * The template for displaying the leads page
     */

    // If this file is called directly, abort.
    if (!defined('WPINC')) {
        die;
    }
    use BaseCRM\ServerSide\Lead;

    ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/r-2.4.0/sp-2.1.0/sl-1.5.0/datatables.min.css" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/r-2.4.0/sp-2.1.0/sl-1.5.0/datatables.min.js"></script>
    <title><?php echo BaseCRM::i18n('Leads'); ?></title>
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
                                    <button class="nav-link active" id="view-tab" data-bs-toggle="tab" data-bs-target="#view" type="button" role="tab" aria-controls="view" aria-selected="true"><?php echo BaseCRM::i18n('View'); ?></button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="create-lead-tab" data-bs-toggle="tab" data-bs-target="#create-lead" type="button" role="tab" aria-controls="create-lead" aria-selected="false"><?php echo BaseCRM::i18n('Create'); ?></button>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="view" role="tabpanel" aria-labelledby="view-tab">
                                    <div class="lead-table-container">
                                        <div class="row mt-3">
                                            <div class="col">
                                                <h3><?php echo BaseCRM::i18n('Your Leads'); ?></h3>
                                                <table class="table table-striped table-bordered" id="lead-table" style="width: 100%">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo BaseCRM::i18n('Last Updated'); ?></th> <!-- 1 -->
                                                            <th><?php echo BaseCRM::i18n('Name'); ?></th> <!-- 2 -->
                                                            <th><?php echo BaseCRM::i18n('Phone'); ?></th> <!-- 3 -->
                                                            <th><?php echo BaseCRM::i18n('Disposition'); ?></th> <!-- 4 -->
                                                            <th><?php echo BaseCRM::i18n('Last Contact'); ?></th> <!-- 5 -->
                                                            <th><?php echo BaseCRM::i18n('Actions'); ?></th> <!-- 6 -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <h3>Debug</h3>
                                                <pre id="debug">
                                                    <?php
                                                     $lead = new Lead();
                                                     $args = [
                                                        'columns' => [
                                                            'id',
                                                            'updated_at',
                                                            'first_name',
                                                            'phone',
                                                            'lead_disposition',
                                                            'date_last_contacted',
                                                        ],
                                                        'order' => [
                                                            'column_name' => 'updated_at',
                                                            'direction' => 'desc'
                                                        ],
                                                        'search' => [
                                                            'first_name' => 'Tyler'
                                                        ]
                                                        ];
                                                     $debug = $lead->leads_datatable(null, $args);
                                                     echo print_r($debug, true);
                                                    ?>
                                                </pre>
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
                                <span class="loading-text"><?php echo BaseCRM::i18n('Initializing...'); ?></span>
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