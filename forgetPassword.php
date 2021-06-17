<?php

require_once "include/conn.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <title>Forget Password</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>


    <div class="container">
        <div class="container-content rounded shadow">
            <div class="container">
                <h1 class="text-uppercase text-center">Forget Password</h1>
                <hr>
                <form action="forgetPasswordManager.php" method="POST" class="needs-validation" novalidate>
                    <div class="form-group text-center">
                        <label for="username">Please enter your username</label>
                        <input type="text" name="username" id="username" class=form-control placeholder="Enter username" required>
                        <div class="invalid-feedback">
                            Please enter a username
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" value="Reset now" name="forgetPassword" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="js/form-validation.js"></script>
<script src="js/forgetPassword.js"></script>

</html>