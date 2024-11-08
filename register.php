<?php

require_once "include/conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css" type="text/css">
    <title>Register</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="container-content rounded shadow">
            <div class="container">
                <h1 class="text-center text-uppercase text-">Register</h1>
                <hr>
                <p class="text-danger">
                    Field with * is required
                </p>
                <form id="registerForm" action="registerManager.php" method="post" enctype="multipart/form-data" onsubmit="return checkPassword(this)" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="profilePicture">Profile Picture:</label><br>
                        <input type="file" name="image" id="profilePicture" class="form-control-file" onchange="previewFile(this);"><br>
                        <div class="text-center">
                            <img id="previewProfile" src="profilePicture/blankPicture.png" style="border-radius:50%" width="100" height="100" alt="Placeholder">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username<span class="text-danger">*</span>:</label>
                        <input type="text" name="username" id="username" class="form-control" maxlength="25" placeholder="Enter Username" required>
                        <div class="invalid-feedback">
                            Please enter a username
                        </div>
                    </div>
                    <div class="form-group" id="passwordForm">
                        <label for="password">Password<span class="text-danger">*</span>:</label>
                        <input type="password" name="password" id="password" data-toggle="collapse" href="#passwordRequirement" class="form-control" minlength="8" maxlength="25" placeholder="Enter Password" required>
                        <div class="invalid-feedback">
                            Please enter a password
                        </div>
                        <div>
                            <input type="checkbox" name="passwordVisible" id="passwordVisible" tabindex="-1">
                            <label for="passwordVisible">Show Password</label>
                        </div>
                        <div id="passwordRequirement" class="panel-collapse collapse">
                            <div class="requirement-body p-3">
                                <h4>Password must contain the following:</h4>
                                <p id="lowerCase" class="invalid">A <b>lowercase</b> letter</p>
                                <p id="upperCase" class="invalid">A <b>uppercase</b> letter</p>
                                <p id="number" class="invalid">A <b>number</b></p>
                                <p id="passwordLength" class="invalid">Minimum <b>8 characters</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password<span class="text-danger">*</span>:</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" data-toggle="collapse" href="#confirmPasswordRequirement" class="form-control" minlength="8" maxlength="25" placeholder="Enter Confirm Password" required>
                        <div class="invalid-feedback">
                            Please enter a password
                        </div>
                        <div>
                            <input type="checkbox" name="confirmPasswordVisible" id="confirmPasswordVisible" tabindex="-1">
                            <label for="confirmPasswordVisible">Show Password</label>
                        </div>
                        <div id="confirmPasswordRequirement" class="panel-collapse collapse">
                            <div class="requirement-body p-3">
                                <h4>Password must match with the previous password:</h4>
                                <p id="match" class="invalid"><b>Match</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email<span class="text-danger">*</span>:</label>
                        <input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{3}" maxlength="30" placeholder=" Enter Email" required>
                        <div class="invalid-feedback">
                            Please enter a email
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="firstName">First Name<span class="text-danger">*</span>:</label>
                        <input type="text" name="firstName" id="firstName" class="form-control" maxlength="30" placeholder="Enter First Name" required>
                        <div class="invalid-feedback">
                            Please enter your first name
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name<span class="text-danger">*</span>:</label>
                        <input type="text" name="lastName" id="lastName" class="form-control" maxlength="30" placeholder="Enter Last Name" required>
                        <div class="invalid-feedback">
                            Please enter your last name
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number<span class="text-danger">*</span>: <span style="color:red" id="phone_error_msg"></span></label>
                        <input type="text" name="phoneNumber" id="phoneNumber" class="form-control" pattern=".{10,13}" maxlength="13" placeholder="Enter Phone Number" required>
                        <div class="invalid-feedback">
                            Please enter a phone number
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <input type="submit" name="register" class="btn btn-primary text-uppercase font-weight-bold" value="Register" onclick="checkForm();" />
                        <input type="reset" class="btn btn-danger text-uppercase font-weight-bold" value="Clear">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="js/register.js"></script>
<script src="js/form-validation.js"></script>
<script src="js/previewProfile.js"></script>

</html>