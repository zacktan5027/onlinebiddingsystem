<?php

require_once "checkLogin.php";
require_once "../include/conn.php";


$query = "SELECT COUNT(*) as total_user FROM `user` WHERE account_type='user'";
$sql = mysqli_query($conn, $query);
$totalUser = mysqli_fetch_array($sql);

$query = "SELECT COUNT(*) as total_item FROM `item`";
$sql = mysqli_query($conn, $query);
$totalItem = mysqli_fetch_array($sql);

$query = "SELECT COUNT(*) as total_bidding FROM `bidding` WHERE bidding_status='start'";
$sql = mysqli_query($conn, $query);
$totalBidding = mysqli_fetch_array($sql);

$totalBiddingTable = [];
$totalBiddingTableDate = [];
$query = "SELECT COUNT(*) as total_bidding, `start_date` FROM `bidding` GROUP BY `start_date`";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    array_push($totalBiddingTable, $row["total_bidding"]);
    array_push($totalBiddingTableDate, $row["start_date"]);
}

$staffs = [];
$query = "SELECT * FROM `user` WHERE account_type='staff'";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    $staffs[] = array(
        "firstName" => $row["firstName"],
        "lastName" => $row["lastName"],
        "username" => $row["username"],
        "email" => $row["email"],
        "phoneNumber" => $row["phone_number"],
        "verificationStatus" => $row["verification_status"],
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

    <link href="css/styles.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <title>Dashboard</title>
    <!-- Favicon-->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/sidebar.css" rel="stylesheet" />
</head>

<body class="sb-sidenav-toggled">

    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <?php include 'sidebar.php'; ?>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <?php include 'topNavigation.php'; ?>
            <div class="container">
                <!-- Page content-->
                <div class="container-fluid">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4 text-uppercase">Dashboard</h1>
                        <div class="container">
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-primary text-white mb-4 rounded shadow">
                                    <div class="card-body">
                                        <h3>Total User</h3>
                                    </div>
                                    <div class="card-footer d-flex align-items-center flex-row-reverse">
                                        <div class="big text-dark ml-3"><i style="font-size:30px" class="fas fa-users"></i></div>
                                        <h1 class="text-dark"><?= $totalUser["total_user"] ?>&nbsp;</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-warning text-white mb-4 rounded shadow">
                                    <div class="card-body">
                                        <h3>Total Item</h3>
                                    </div>
                                    <div class="card-footer d-flex align-items-center flex-row-reverse">
                                        <div class="big text-dark ml-3"><i style="font-size:30px" class="fas fa-boxes"></i></div>
                                        <h1 class="text-dark"><?= $totalItem["total_item"] ?>&nbsp;</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6">
                                <div class="card bg-success text-white mb-4 rounded shadow">
                                    <div class="card-body">
                                        <h3>Total Bidding</h3>
                                    </div>
                                    <div class="card-footer d-flex align-items-center flex-row-reverse">
                                        <div class="big text-dark ml-3"><i style="font-size:30px" class="fas fa-gavel"></i></div>
                                        <h1 class="text-dark"><?= $totalBidding["total_bidding"] ?>&nbsp;</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h1 class="mt-4 text-uppercase">Total Bidding</h1>
                        <hr>
                        <div>
                            <div style="width:80%;max-width:1000px;display:block;margin-left:auto;margin-right:auto;">
                                <div class="card mb-4 rounded shadow">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Total Bidding
                                    </div>
                                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h1 class="mt-4 text-uppercase">Staff</h1>
                        <hr>
                        <div class="card mb-4 rounded shadow">
                            <div class="card-header text-uppercase">
                                <i class="fas fa-table me-1"></i>
                                Staff List
                            </div>
                            <div class="card-body">
                                <table id="staffList">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Salary</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($staffs as $staff) { ?>
                                            <tr>
                                                <td><?= $staff["firstName"] ?></td>
                                                <td><?= $staff["lastName"] ?></td>
                                                <td><?= $staff["username"] ?></td>
                                                <td><?= $staff["email"] ?></td>
                                                <td><?= $staff["phoneNumber"] ?></td>
                                                <td><?= $staff["verificationStatus"] ?></td>
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
    </div>
    </div>
    <script src="js/serverManager.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Area Chart Example
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($totalBiddingTableDate) ?>,
                datasets: [{
                    label: "Total Bidding",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?= json_encode($totalBiddingTable) ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
</body>

</html>