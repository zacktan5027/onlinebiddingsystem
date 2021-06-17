<?php

require_once "include/conn.php";

if (isset($_GET["vkey"]) && isset($_GET["email"])) {
    $vkey = $_GET["vkey"];
    $email = $_GET["email"];
} else {
    echo "<script>
                window.alert('Please enter using the email sent by the system.');
                window.location.href='index.php'
                </script>";
}


$sql = "SELECT * FROM user WHERE email = '$email' AND verification_key = '$vkey'";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) <= 0) {
    echo "<script>
                window.alert('Please use the latest email sent.');
                window.location.href='index.php'
                </script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css" type="text/css">
    <title>Change Password</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="container-content rounded shadow">
            <div class="container">
                <form action="forgetPasswordManager.php" method="POST" class="needs-validation" novalidate onsubmit="return checkPassword(this)">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <div class="form-group" id="passwordForm">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" data-toggle="collapse" href="#passwordRequirement" class="form-control" minlength="8" maxlength="15" placeholder="Enter Password" required>
                        <div>
                            <input type="checkbox" name="passwordVisible" id="passwordVisible" tabindex="-1">
                            <label for="passwordVisible">Show Password</label>
                        </div>
                        <div id="passwordRequirement" class="panel-collapse collapse">
                            <div class="requirement-body p-3">
                                <h3>Password must contain the following:</h3>
                                <p id="lowerCase" class="invalid">A <b>lowercase</b> letter</p>
                                <p id="upperCase" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                <p id="number" class="invalid">A <b>number</b></p>
                                <p id="passwordLength" class="invalid">Minimum <b>8 characters</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm Password:</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" data-toggle="collapse" href="#confirmPasswordRequirement" class="form-control" minlength="8" maxlength="15" placeholder="Enter Confirm Password" required>

                        <div>
                            <input type="checkbox" name="confirmPasswordVisible" id="confirmPasswordVisible" tabindex="-1">
                            <label for="confirmPasswordVisible">Show Password</label>
                        </div>
                        <div id="confirmPasswordRequirement" class="panel-collapse collapse">
                            <div class="requirement-body p-3">
                                <h3>Password must match with the previous password:</h3>
                                <p id="match" class="invalid"><b>Match</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Save Password" name="savePassword" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="js/register.js"></script>
<script src="js/form-validation.js"></script>

</html>