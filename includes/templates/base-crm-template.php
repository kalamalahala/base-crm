<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
	<?php

		// use BaseCRM\BaseCRM;
		// Use this file for miscellaneous testing for now



        $gravity_view_id = 21918;
        $form_id = 114;

	?>
    <title>Document</title>
</head>
<body>


<main> <!-- full width and height container -->
    <div class="base-sidebar container-fluid">
        <div class="row flex-nowrap">
			<?php echo BaseCRM::include_navbar(); ?>
            <div class="content col">
                <div class="row mt-3">
                    <div class="col-3">
                        <a class="btn btn-primary test-clicker" data-gk-id="<?php echo $gravity_view_id; ?>" data-lead-id="4" data-form-id="<?php echo $form_id ?>" href="#">Click Here</a>
                    </div>
                    <div class="col-9">
                        <div class="test-result"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>


</body>
<?php wp_footer(); ?>
</html>