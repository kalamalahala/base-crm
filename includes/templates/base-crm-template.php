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
    <title>Document</title>
</head>
<body>


<main> <!-- full width and height container -->
    <div class="base-sidebar container-fluid">
        <div class="row flex-nowrap">
            <?php echo BaseCRM::include_navbar(); ?>
            <div class="content col">
                Home
            </div>
        </div>
        
    </div>
</main>


</body>
<?php wp_footer(); ?>
</html>