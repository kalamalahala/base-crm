<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <?php

    /**
     * The template for displaying the Clients page
     */

    // If this file is called directly, abort.
    if (!defined('WPINC')) {
        die;
    }

    use BaseCRM\ServerSide\Lead;


    ?>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/r-2.4.0/sp-2.1.0/sl-1.5.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/r-2.4.0/sp-2.1.0/sl-1.5.0/datatables.min.js"></script>
    <title><?php echo BaseCRM::i18n('Clients'); ?></title>
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
                        <div class="client-table-container">
                            <div class="row mt-3">
                                <div class="col">
                                    <h3><?php echo BaseCRM::i18n('Your Clients'); ?></h3>
                                    <table class="table table-striped table-hover" id="clients-table"
                                           style="width:100%;">
                                        <thead>
                                        <tr>
                                            <th><?php echo BaseCRM::i18n('Last Updated'); ?></th>
                                            <th><?php echo BaseCRM::i18n('Name'); ?></th>
                                            <th><?php echo BaseCRM::i18n('Phone'); ?></th>
                                            <th><?php echo BaseCRM::i18n('Disposition'); ?></th>
                                            <th><?php echo BaseCRM::i18n('Last Contact'); ?></th>
                                            <th><?php echo BaseCRM::i18n('Actions'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
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

<script type="text/javascript">
    // const $ = jQuery;
    jQuery(document).ready(function () {
        jQuery('.lead-table-loading-overlay').addClass('d-none');
    });
</script>
</html>