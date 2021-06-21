<?php

$rootPath = "../../";
include_once('../api/Config/Config.php');
include('../templates/header.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["normal"])) {
    echo "<script language='javascript'>
    alert('Please log in first.');
    window.location = '../../logout.php';
    </script>";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel</title>
</head>

<body>
    <?php include "../header.php"; ?>
    <div class="container mt-5 text-center">

        <div>

            <h4>
                You cancelled the order.
            </h4>
            <br />
            Return to <a href="<?= $rootPath ?>index.php">home page</a>.
        </div>
        <div class="col-md-4"></div>
    </div>
    <?php
    include('../templates/footer.php');
    ?>
</body>

</html>