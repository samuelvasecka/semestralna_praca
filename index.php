<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Home</title>
    <link rel="stylesheet" href="../semestralna_praca/styles/myFramework.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/logo.png">
</head>

<body class="c-bg-bg">
<?php include('../semestralna_praca/templates/header.php') ?>
<div class="header-space">
    <br/>
</div>
<div class="container">
    <div class="row">
        <div class="col-3 mobile-hide">
            <?php include('../semestralna_praca/templates/profile.php') ?>
        </div>
        <div class="col-6">
            <?php
            for ($i = 0; $i < 30; $i++) {
                include('../semestralna_praca/templates/item.php');
            }
            ?>

        </div>
        <div class="col-3 mobile-hide">
            <?php include('../semestralna_praca/templates/addItem.php') ?>
        </div>
    </div>
</div>

</body>
</html>