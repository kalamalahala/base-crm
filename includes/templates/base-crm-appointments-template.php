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


    <main>
        <!-- full width and height container -->
        <div class="base-sidebar container-fluid">
            <div class="row flex-nowrap">
                <?php echo BaseCRM::include_navbar(); ?>
                <div class="content col">
                    <div class="appointment-table-container">
                        <div class="row mt-3">
                            <div class="col">
                                <h3>Your Appointments</h3>
                                <table class="table table-striped table-bordered" id="appointment-table" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Created</th> <!-- 1 -->
                                            <th>Scheduled At</th> <!-- 2 -->
                                            <th>Appointment Name</th> <!-- 3 -->
                                            <th>Appointment Type</th> <!-- 4 -->
                                            <th>Phone Number</th> <!-- 5 -->
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
            </div>

        </div>
    </main>


</body>
<?php wp_footer(); ?>

</html>