<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$sql = $conn->query("SELECT * FROM user WHERE userID=" . $_SESSION["user"]["id"] . "");
$user = $sql->fetch_array();
?>

<?php

require_once "../include/conn.php";


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Profile</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="row">
            <div class="col-md-14 col-sm-14 col-lg-12">
                <div class="details-form">
                    <h1 class="headline mb-3 font-weight-bold">Profile</h1>
                    <hr>
                    <div class="card rounded shadow">
                        <div class="card-body">
                            <div>
                                <div class="text-center">
                                    <img class="rounded-circle border border-dark" src="../profilePicture/<?= $user["profile_picture"] ?>" style="width:200px;height:200px" alt=""><br><br>
                                </div>
                                <div class="m-3">
                                    <table style="margin: auto;">
                                        <tr style="height: 50px;">
                                            <td style="width:300px">
                                                <h3>First Name: </h3>
                                            </td>
                                            <td style="width:300px">
                                                <span><?= $user['firstName'] ?></span>
                                            </td>
                                        </tr>
                                        <tr style="height: 50px;">
                                            <td style="width:300px">
                                                <h3>Last Name: </h3>
                                            </td>
                                            <td style="width:300px">
                                                <span><?= $user['lastName'] ?></span>
                                            </td>
                                        </tr>
                                        <tr style="height: 50px;">
                                            <td>
                                                <h3>Phone Number: </h3>
                                            </td>
                                            <td>
                                                <span><?= $user['phone_number'] ?></span><br>
                                            </td>
                                        </tr>
                                        <tr style="height: 50px;">
                                            <td>
                                                <h3>Email: </h3>
                                            </td>
                                            <td>
                                                <span><?= $user['email'] ?></span><br>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-center">
                                    <form action="passwordManager.php" method="POST">
                                        <input type="submit" value="Change Password" name="changePassword" id="changePassword" class="btn btn-primary m-1 text-uppercase">
                                    </form>
                                    <form action="editProfile.php" method="POST">
                                        <input type="submit" class="btn btn-primary m-1 text-uppercase" name="editProfile" value="edit Profile">
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

</html>