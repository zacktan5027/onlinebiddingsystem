<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$sql = $conn->query("SELECT * FROM report WHERE report_status IS NULL");
$reports = [];
while ($row = $sql->fetch_array()) {
    $reports[] = array(
        "reportID" => $row["reportID"],
        "userID" => $row["userID"],
        "reportTitle" => $row["report_title"],
        "reportTime" => $row["report_time"],
        "itemDescription" => $row["report_description"],
        "reportCategory" => $row["report_category"],
        "itemID" => $row["itemID"],
        "sellerID" => $row["sellerID"]
    );
}


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
                <h1 class="headline m-3 font-weight-bold text-uppercase">Manage Report</h1>
                <hr>
                <div class="card  rounded shadow">
                    <div class="card-header text-uppercase">
                        <i class="fas fa-table me-1"></i>
                        Report List
                    </div>
                    <div class="card-body">
                        <table id="reportList">
                            <thead>
                                <tr>
                                    <th>Report ID</th>
                                    <th>Report Time</th>
                                    <th>User ID</th>
                                    <th>Report Title</th>
                                    <th>Category</th>
                                    <th>Target Item</th>
                                    <th>Target User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reports as $key => $report) { ?>
                                    <tr>
                                        <td><?= $report["reportID"] ?></td>
                                        <td><?= $report["reportTime"] ?></td>
                                        <td><?= $report["userID"] ?></td>
                                        <td><?= $report["reportTitle"] ?></td>
                                        <td><?= $report["reportCategory"] ?></td>
                                        <td>
                                            <?php
                                            if ($report["itemID"] != NULL) {
                                                $sql = "SELECT * FROM item WHERE itemID = {$report['itemID']}";
                                                $query = mysqli_query($conn, $sql);
                                                $item = mysqli_fetch_array($query);
                                                echo $item["item_name"];
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($report["sellerID"] != NULL) {
                                                $sql = "SELECT * FROM user WHERE userID = {$report['sellerID']}";
                                                $query = mysqli_query($conn, $sql);
                                                $seller = mysqli_fetch_array($query);
                                                echo $seller["firstName"] . " " . $seller["lastName"];
                                            } else {
                                                echo "N/A";
                                            }
                                            ?>
                                        </td>
                                        <td><a href="reportDetail.php?id=<?= $report["reportID"] ?>"><button class="btn btn-primary text-uppercase" style="width:100%">DETAIL</button></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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

    const reportList = document.getElementById("reportList");
    if (reportList) {
        new simpleDatatables.DataTable(reportList);
    }
</script>

</html>