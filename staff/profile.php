<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$userID = $_SESSION["user"]["id"];
$sql = "SELECT * FROM user WHERE userID = $userID";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/sidebar.css" rel="stylesheet" />

    <title>Home</title>
</head>

<body class="sb-sidenav-toggled">

    <div class="d-flex" id="wrapper">
        <?php include 'sidebar.php'; ?>
        <?php include 'header.php'; ?>

        <div id="page-content-wrapper">
            <?php include 'topNavigation.php'; ?>
            <div class="container">
                <h1 class="headline m-3 font-weight-bold text-uppercase">Profile</h1>
                <hr>
                <div class="container card  rounded shadow">
                    <div class="card-body">
                        <form action="profileManager.php" method="post" onsubmit="return checkProfile(this)" class="needs-validation" novalidate>
                            <div class="form-group">
                                <label for="firstName">First Name:</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" placeholder="Enter First Name" maxlength="30" value="<?= $row["firstName"] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter your first name
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Last Name:</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" placeholder="Enter Last Name" maxlength="30" value="<?= $row["lastName"] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter your last name
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{3}" maxlength="30" placeholder="Enter Email" value="<?= $row["email"] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter a valid email
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number:</label>
                                <input type="text" name="phoneNumber" id="phoneNumber" pattern=".{10,13}" maxlength="13" class="form-control" placeholder="Enter Phone Number" value="<?= $row["phone_number"] ?>" required>
                                <div class="invalid-feedback">
                                    Please enter a valid phone number
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" value="Save" class="btn btn-primary text-uppercase" name="saveProfile">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="../js/staffProfile.js"></script>
<script src="../js/form-validation.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        // Toggle the side navigation
        const sidebarToggle = document.body.querySelector("#sidebarToggle");
        if (sidebarToggle) {
            // Uncomment Below to persist sidebar toggle between refreshes
            // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            //     document.body.classList.toggle('sb-sidenav-toggled');
            // }
            sidebarToggle.addEventListener("click", (event) => {
                event.preventDefault();
                document.body.classList.toggle("sb-sidenav-toggled");
                localStorage.setItem(
                    "sb|sidebar-toggle",
                    document.body.classList.contains("sb-sidenav-toggled")
                );
            });
        }
    });
</script>

</html>