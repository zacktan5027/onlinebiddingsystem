<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$sql = "SELECT COUNT(*) as total_user FROM `user` WHERE account_type='user'";
$query = mysqli_query($conn, $sql);
$totalUser = mysqli_fetch_array($query);

$sql = "SELECT COUNT(*) as total_item FROM item";
$query = mysqli_query($conn, $sql);
$totalItem = mysqli_fetch_array($query);

$sql = "SELECT COUNT(*) as total_report FROM report";
$query = mysqli_query($conn, $sql);
$totalReport = mysqli_fetch_array($query);

$sql = "SELECT COUNT(*) as total_pending FROM report WHERE report_status IS NULL";
$query = mysqli_query($conn, $sql);
$totalPending = mysqli_fetch_array($query);

$reports = [];
$sql = "SELECT * FROM report JOIN user ON report.userID=user.userID WHERE report_status IS NULL";
$query = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($query)) {
    $reports[] = array(
        "reportID" => $row["reportID"],
        "userName" => $row["firstName"] . " " . $row["lastName"],
        "reportTitle" => $row["report_title"],
        "reportDescription" => $row["report_description"],
        "reportCategory" => $row["report_category"],
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/sidebar.css" rel="stylesheet" />

    <title>Home</title>
</head>

<body class="sb-sidenav-toggled">

    <div class="d-flex" id="wrapper">
        <?php include 'sidebar.php'; ?>

        <div id="page-content-wrapper">
            <?php include 'topNavigation.php'; ?>
            <div class="container">
                <h1 class="headline m-3 font-weight-bold text-uppercase">Dashboard</h1>
                <hr>
                <?php
                $sql = "SELECT firstName FROM user WHERE userID=" . $_SESSION["user"]["id"] . "";
                $query = mysqli_query($conn, $sql);
                $isFilled = mysqli_fetch_array($query);
                if ($isFilled["firstName"] == "") {
                ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Please update your profile!!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                }
                ?>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4 text-uppercase rounded shadow">
                            <div class="card-body">
                                <h4>Total User</h4>
                            </div>
                            <div class="card-footer d-flex align-items-center flex-row-reverse">
                                <div class="big text-dark ml-3"><i style="font-size:30px" class="fas fa-users"></i></div>
                                <h1 class="big text-dark ml-3"><?= $totalUser["total_user"] ?>&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4 text-uppercase rounded shadow">
                            <div class="card-body">
                                <h4>Total Item</h4>
                            </div>
                            <div class="card-footer d-flex align-items-center flex-row-reverse">
                                <div class="big text-dark ml-3"><i style="font-size:30px" class="fas fa-boxes"></i></div>
                                <h1 class="big text-dark ml-3"><?= $totalItem["total_item"] ?>&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4 text-uppercase rounded shadow">
                            <div class="card-body">
                                <h4>Total Report</h4>
                            </div>
                            <div class="card-footer d-flex align-items-center flex-row-reverse">
                                <div class="big text-dark ml-3"><i style="font-size:30px" class="fas fa-flag"></i></div>
                                <h1 class="big text-dark ml-3"><?= $totalReport["total_report"] ?>&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4 text-uppercase rounded shadow">
                            <div class="card-body">
                                <h4>Total Pending</h4>
                            </div>
                            <div class="card-footer d-flex align-items-center flex-row-reverse">
                                <div class="big text-dark ml-3"><i style="font-size:30px" class="fas fa-flag"></i></div>
                                <h1 class="big text-dark ml-3"><?= $totalPending["total_pending"] ?>&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card  rounded shadow">
                    <div class="card-header text-uppercase">
                        <i class="fas fa-table me-1"></i>
                        Report list
                    </div>
                    <div class="card-body">
                        <table id="reportList">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Report Title</th>
                                    <th>Report Description</th>
                                    <th>Report Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reports as $report) { ?>
                                    <tr>
                                        <td><?= $report["userName"] ?></td>
                                        <td><?= $report["reportTitle"] ?></td>
                                        <td><?= $report["reportDescription"] ?></td>
                                        <td><?= $report["reportCategory"] ?></td>
                                        <td><a href="reportDetail.php?id=<?= $report["reportID"] ?>"><button class="btn btn-primary" style="width:100%">VIEW</button></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>
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

        const reportList = document.getElementById("reportList");
        if (reportList) {
            new simpleDatatables.DataTable(reportList);
        }
    </script>
</body>

</html>