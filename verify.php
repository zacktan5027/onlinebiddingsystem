<?php

require_once "include/conn.php";

$email = $_GET['email'];
$vkey = $_GET['vkey'];

$query = "SELECT * FROM user WHERE verification_key ='" . $vkey . "' AND email = '" . $email . "' ";
$result = mysqli_query($conn, $query);
if ($result) {
    $query = "UPDATE `user` SET `verification_status`= 'active' WHERE email='" . $email . "' ";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $status = 'active';
    }
} else {
    $status = 'inactive';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Account</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include 'header.php' ?>

    <section class="section">
        <div class="container">
            <?php if ($status == "active") { ?>
                <div>
                    <h1>You are succesfully verified your account</h1>
                    <div class="">
                        <a href="index.php"><button class="btn btn-primary">Back to Home</button> </a>
                    </div>
                </div>
            <?php } else { ?>
                <div>
                    <h1>You fail or haven't verified your account</h1>
                    <div>
                        <a href="index.php"><button class="btn btn-primary">Back to Home</button> </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <?php include "footer.php" ?>


</body>

</html>