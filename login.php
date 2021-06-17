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
    <title>Login</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="container-content rounded shadow">
            <div class="container">
                <h1 class="text-center text-uppercase">Login</h1>
                <hr>
                <form action="loginManager.php" method="post" class="needs-validation" novalidate>
                    <div class="form-group p-2">
                        <label for="username" class="font-weight-bold">Username:</label>
                        <input type="text" name="username" id="username" maxlength="25" class="form-control p-4" required>
                        <div class="invalid-feedback">
                            Please enter a username.
                        </div>
                    </div>
                    <div class="form-group p-2">
                        <label for="password" class="font-weight-bold">Password:</label>
                        <input type="password" name="password" id="password" maxlength="25" class="form-control p-4" required>
                        <div class="invalid-feedback">
                            Please enter a password.
                        </div>
                    </div>
                    <div class="form-group p-2 text-center">
                        <input type="submit" value="login" class="btn btn-primary text-uppercase font-weight-bold" name="login">
                    </div>
                </form>
                <a href="forgetPassword.php">Forget password?</a><br>
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="js/form-validation.js"></script>
<script src="js/login.js"></script>


</html>