<?php

session_start();

require_once "../../include/conn.php";

$userID = $_SESSION["user"]["id"];

$sql = "SELECT COUNT(*) as total_items FROM item WHERE sellerID=$userID";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
$totalItems = $row["total_items"];

$sql = "SELECT COUNT(*) as total_success FROM bidding JOIN item on bidding.itemID=item.itemID JOIN user ON user.userID=item.sellerID WHERE userID = $userID AND success=1 ";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
$totalSuccess = $row["total_success"];

$sql = "SELECT COUNT(*) as total_bidding  FROM bidding JOIN item on bidding.itemID=item.itemID JOIN user ON user.userID=item.sellerID WHERE userID = $userID AND bidding_status='start'";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
$totalBidding = $row["total_bidding"];

$sql = "SELECT AVG(rating) as average_rating FROM feedback WHERE sellerID=$userID";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
if ($row["average_rating"] == NULL) {
    $averageRating = 0;
} else {
    $averageRating = $row["average_rating"];
}


$sql = "SELECT COUNT(*) as total_follower FROM follow WHERE sellerID = $userID";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
$totalFollowers = $row["total_follower"];

$sql = "SELECT AVG(success) as success_rate FROM bidding JOIN item on bidding.itemID=item.itemID JOIN user ON user.userID=item.sellerID WHERE userID = $userID";
$query = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($query);
$successRate = $row["success_rate"] * 100;

$failRate = 100 - $successRate;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <title>Seller Center</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="container-fluid">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <div class="container">
                    <hr>
                    <?php
                    $sql = "SELECT COUNT(*) as total_shipping FROM bidding JOIN item ON bidding.itemID = item.itemID WHERE sellerID=" . $_SESSION["user"]["id"] . " AND bidding_status='paid'";
                    $query = mysqli_query($conn, $sql);
                    $totalShipping = mysqli_fetch_array($query);
                    if ($totalShipping["total_shipping"] > 0) {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>You have <?= $totalShipping["total_shipping"] ?> items need to be shipped out.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text- mb-4 rounded shadow">
                            <div class="card-body text-white text-uppercase">
                                <h5>Total Items</h5>
                            </div>
                            <div class="card-footer d-flex align-items-center flex-row-reverse">
                                <div class="big text- ml-3"><i style="font-size:30px" class="fas fa-users"></i></div>
                                <h1><?= $totalItems ?>&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text- mb-4 rounded shadow">
                            <div class="card-body text-white text-uppercase">
                                <h5>Total Success</h5>
                            </div>
                            <div class="card-footer d-flex align-items-center flex-row-reverse">
                                <div class="big text- ml-3"><i style="font-size:30px" class="fas fa-boxes"></i></div>
                                <h1><?= $totalSuccess ?>&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text- mb-4 rounded shadow">
                            <div class="card-body text-white text-uppercase">
                                <h5>Total Bidding</h5>
                            </div>
                            <div class="card-footer d-flex align-items-center flex-row-reverse">
                                <div class="big text-black ml-3"><i style="font-size:30px" class="fas fa-gavel"></i></div>
                                <h1><?= $totalBidding ?>&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text- mb-4 rounded shadow">
                            <div class="card-body text-white text-uppercase">
                                <h5>Rating</h5>
                            </div>
                            <div class="card-footer d-flex align-items-center flex-row-reverse">
                                <div class="big text-black ml-3"><i style="font-size:30px" class="fas fa-star"></i></div>
                                <h1><?= sprintf("%.02f", $averageRating) ?>&nbsp;</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="card m-3 p-5 rounded shadow">
            <div>
                Follower : <?= $totalFollowers ?>
            </div>
            <div>
                Success Rate: <?= sprintf("%.02f", $successRate) ?> %
            </div>
            <div>
                Fail Rate: <?= sprintf("%.02f", $failRate) ?> %
            </div>



        </div>
    </div>

    <?php include "../footer.php" ?>

</body>

</html>