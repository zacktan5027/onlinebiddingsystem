<?php

require_once "../include/session.php";
require_once "../include/conn.php";

if (!isset($_POST['editProfile'])) {
    echo ("<script>
                window.location.href='index.php';
                </script>");
}

$sql = $conn->query("SELECT * FROM user WHERE userID=" . $_SESSION["user"]["id"] . "");
$row = $sql->fetch_array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Edit Profile</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <section class="slider-hero hero-slider  hero-style-1  ">

        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-md-14 col-sm-14 col-lg-12">
                        <div class="details-form">
                            <a href="profile.php" class="float-left">
                                <h1 class="mx-4"><i class="fas fa-arrow-left"></i></h1>
                            </a>
                            <h1 class="headline mb-3 font-weight-bold">Profile</h1>
                            <hr>
                            <div class="card rounded shadow">
                                <div class="card-body">
                                    <div class="text-center">
                                        <img class="rounded-circle border border-dark" src="../profilePicture/<?= $row["profile_picture"] ?>" style="width:200px;height:200px" alt=""><br><br>
                                        <a href="changeProfile.php"><button class="btn btn-primary">Change Profile Picture</button></a>
                                    </div>
                                    <br>
                                    <hr>
                                    <div>
                                        <div>
                                            <form action="profileManager.php" method="post" enctype="multipart/form-data" onsubmit="return checkProfile(this)" class="needs-validation" novalidate>
                                                <table style="margin:0 auto;">
                                                    <tr style="height: 50px;">
                                                        <td style="width:300px">
                                                            <h3>First Name: </h3>
                                                        </td>
                                                        <td style="width:300px">
                                                            <input type="text" id="firstName" class="form-control" name="firstName" placeholder="Enter Name" value="<?= $row["firstName"] ?>" maxlength="30" required>
                                                            <div class="invalid-feedback">
                                                                Please enter your first name
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr style="height: 50px;">
                                                        <td style="width:300px">
                                                            <h3>Last Name: </h3>
                                                        </td>
                                                        <td style="width:300px">
                                                            <input type="text" id="lastName" class="form-control" name="lastName" placeholder="Enter Name" value="<?= $row["lastName"] ?>" maxlength="30" required>
                                                            <div class="invalid-feedback">
                                                                Please enter your last name
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr style="height: 50px;">
                                                        <td>
                                                            <h3>Phone Number: <span style="color:red" id="phone_error_msg"></span></h3>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="phoneNumber" id="phoneNumber" value="<?= $_SESSION['user']['phoneNumber'] ?>" class="form-control" pattern=".{10,13}" maxlength="13" placeholder="Enter Phone Number" required>
                                                            <div class="invalid-feedback">
                                                                Please enter your phone number
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>
                                                <div class="text-center">
                                                    <input type="submit" name="editProfile" value="Save Profile" class="btn btn-primary ">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <?php include "footer.php" ?>


</body>

<script src="../js/form-validation.js"></script>
<script src="../js/changeProfile.js"></script>

</html>