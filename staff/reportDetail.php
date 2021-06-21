<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$reportID = $_GET["id"];

$sql = mysqli_query($conn, "SELECT * FROM report WHERE reportID=" . $reportID . "");
$row = mysqli_fetch_array($sql);

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
                <a href="report.php" class="float-left">
                    <h1 class="mx-4"><i class="fas fa-arrow-left"></i></h1>
                </a>
                <h1 class="headline m-3 font-weight-bold text-uppercase">Report Detail</h1>
                <hr>
                <div class="card m-4 rounded shadow">
                    <div class="card-header">
                        <h2>Report Screenshot</h2>
                    </div>
                    <div class="card-body text-center">

                        <?php if ($row["screenshot"] == "") {
                        ?>
                            <p>No screenshot available</p>
                        <?php
                        } else {
                        ?>
                            <img src="../reportSubmission/<?= $row["screenshot"] ?>" width="300" height="300">
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="card m-4 rounded shadow">
                    <div class="card-header">
                        <h2>Report Title</h2>
                    </div>
                    <div class="card-body">
                        <p><?= $row["report_title"] ?></p>
                    </div>
                </div>
                <div class="card m-4 rounded shadow">
                    <div class="card-header">
                        <h2>Report Description</h2>
                    </div>
                    <div class="card-body">
                        <p><?= $row["report_description"] ?></p>
                    </div>
                </div>
                <div class="card m-4 rounded shadow">
                    <div class="card-header">
                        <h2>Report Category</h2>
                    </div>
                    <div class="card-body">
                        <p><?= $row["report_category"] ?></p>
                    </div>
                </div>

                <div class="card m-4 rounded shadow">
                    <div class="card-header">
                        <h4>Action</h4>
                    </div>
                    <div class="card-body text-center">
                        <form action="reportManager.php" method="post">
                            <input type="hidden" name="reportID" value="<?= $reportID ?>">
                            <input type="submit" value="Accept Report" name="acceptReport" class="btn btn-primary text-uppercase">
                            <input type="submit" value="Reject Report" name="rejectReport" class="btn btn-danger text-uppercase">
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