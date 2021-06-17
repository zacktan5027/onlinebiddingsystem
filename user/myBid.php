<?php

require_once "../include/session.php";
require_once "../include/conn.php";

$sql = $conn->query("SELECT * FROM bidding_history NATURAL JOIN bidding NATURAL JOIN item WHERE bidding_status='start' OR bidding_status='suspend' AND bidderID = " . $_SESSION["user"]["id"] . "");
$biddingItems = [];
while ($row = $sql->fetch_array()) {
    $biddingItems[] = array(
        "itemID" => $row["itemID"],
        "itemName" => $row["item_name"],
        "itemDescription" => $row["item_description"],
        "itemStartPrice" => $row["item_start_price"],
        "itemQuantity" => $row["item_quantity"],
        "itemCategory" => $row["item_category"],
        "itemCondition" => $row["item_condition"],
        "itemWebsite" => $row["item_website"],
        "currentBid" => $row["current_bid"],
        "biddingStatus" => $row["bidding_status"],
    );
}

$sql = $conn->query("SELECT * FROM bidding_history NATURAL JOIN bidding NATURAL JOIN item WHERE (bidding_status='email sent' OR bidding_status='accept' OR bidding_status='address_inserted') AND bidderID = " . $_SESSION["user"]["id"] . "");
$successItems = [];
while ($row = $sql->fetch_array()) {
    $successItems[] = array(
        "itemID" => $row["itemID"],
        "itemName" => $row["item_name"],
        "itemDescription" => $row["item_description"],
        "itemStartPrice" => $row["item_start_price"],
        "itemQuantity" => $row["item_quantity"],
        "itemCategory" => $row["item_category"],
        "itemCondition" => $row["item_condition"],
        "itemWebsite" => $row["item_website"],
        "currentBid" => $row["current_bid"],
        "biddingStatus" => $row["bidding_status"],

    );
}

$sql = $conn->query("SELECT * FROM bidding_history NATURAL JOIN bidding NATURAL JOIN item WHERE (bidding_status='paid') AND bidderID = " . $_SESSION["user"]["id"] . "");
$historyItems = [];
while ($row = $sql->fetch_array()) {
    $historyItems[] = array(
        "itemID" => $row["itemID"],
        "itemName" => $row["item_name"],
        "itemDescription" => $row["item_description"],
        "itemStartPrice" => $row["item_start_price"],
        "itemQuantity" => $row["item_quantity"],
        "itemCategory" => $row["item_category"],
        "itemCondition" => $row["item_condition"],
        "itemWebsite" => $row["item_website"],
        "currentBid" => $row["current_bid"],
        "biddingStatus" => $row["bidding_status"],

    );
}

$sql = $conn->query("SELECT * FROM bidding_history NATURAL JOIN bidding NATURAL JOIN item JOIN delivery ON bidding.biddingID=delivery.biddingID WHERE (bidding_status='shipped out' OR bidding_status='received') AND bidderID = " . $_SESSION["user"]["id"] . "");
$receiveItems = [];
while ($row = $sql->fetch_array()) {
    $receiveItems[] = array(
        "itemID" => $row["itemID"],
        "itemName" => $row["item_name"],
        "itemDescription" => $row["item_description"],
        "biddingID" => $row["biddingID"],
        "courierName" => $row["courier_name"],
        "trackingNumber" => $row["tracking_number"],
        "biddingStatus" => $row["bidding_status"]
    );
}


$sql = $conn->query("SELECT * FROM bidding_history NATURAL JOIN bidding NATURAL JOIN item JOIN delivery ON bidding.biddingID=delivery.biddingID WHERE (bidding_status='complete') AND bidderID = " . $_SESSION["user"]["id"] . "");
$completeItems = [];
while ($row = $sql->fetch_array()) {
    $completeItems[] = array(
        "itemID" => $row["itemID"],
        "itemName" => $row["item_name"],
        "itemDescription" => $row["item_description"],
        "biddingID" => $row["biddingID"],
        "courierName" => $row["courier_name"],
        "trackingNumber" => $row["tracking_number"],
        "biddingStatus" => $row["bidding_status"]
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <title>My Bid</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <h1 class="headline mb-3 font-weight-bold text-uppercase">My Bid List</h1>
        <hr>
        <ul class="nav nav-tabs justify-content-center">
            <li class="active"><a data-toggle="tab" href="#home" class="nav-link active">MY BID</a></li>
            <li><a data-toggle="tab" href="#menu1" class="nav-link">MY SUCCESS BID</a></li>
            <li><a data-toggle="tab" href="#menu2" class="nav-link">MY HISTORY</a></li>
            <li><a data-toggle="tab" href="#menu3" class="nav-link">TO RECEIVE</a></li>
            <li><a data-toggle="tab" href="#menu4" class="nav-link">COMPLETED</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade active show">
                <div class="container">
                    <h1 class="text-uppercase">My bid</h1>
                    <hr>
                    <div class="card rounded shadow">
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <?php
                                if (!empty($biddingItems)) {
                                    foreach ($biddingItems as $key => $biddingItem) {
                                        if ($biddingItem["biddingStatus"] == "start") { ?>
                                            <div style="width:200px">
                                                <?php
                                                $itemID = $biddingItem['itemID'];
                                                $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                                $itemPic = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($itemPic) > 0) {
                                                    $itemPicture = mysqli_fetch_array($itemPic);
                                                ?>
                                                    <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                                <?php
                                                }
                                                ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $biddingItem["itemName"] ?></h5>
                                                    <p class="card-text">Current highest bid: RM <?= $biddingItem["currentBid"] ?></p>
                                                    <a href="itemDetail.php?id=<?= $biddingItem["itemID"] ?>" class="btn btn-primary text-uppercase" style="width:100%">See item</a>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div style="width:200px">
                                                <?php
                                                $itemID = $biddingItem['itemID'];
                                                $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                                $itemPic = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($itemPic) > 0) {
                                                    $itemPicture = mysqli_fetch_array($itemPic);
                                                ?>
                                                    <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                                <?php
                                                }
                                                ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $biddingItem["itemName"] ?></h5>
                                                    <p class="card-text">Current highest bid: RM <?= $biddingItem["currentBid"] ?></p>
                                                    <button class="btn btn-primary text-uppercase" style="width:100%;cursor:default" disabled>See item</button>
                                                </div>
                                                <div class="overlay">Item Suspended</div>
                                            </div>
                                    <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <center>You have no bid for anything yet.</center>
                                <?php
                                }

                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                <div class="container">
                    <h1 class="text-uppercase">My success bid</h1>
                    <hr>
                    <div class="card rounded shadow">
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <?php
                                if (!empty($successItems)) {
                                    foreach ($successItems as $key => $successItem) {
                                        print_r($row);

                                        if ($successItem["biddingStatus"] == "email sent") { ?>
                                            <div style="width:200px">
                                                <?php
                                                $itemID = $successItem['itemID'];
                                                $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                                $itemPic = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($itemPic) > 0) {
                                                    $itemPicture = mysqli_fetch_array($itemPic);
                                                ?>
                                                    <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                                <?php
                                                }
                                                ?>
                                                <div class="card-body">
                                                    <h4 class="card-title"><?= $successItem["itemName"] ?></h4>
                                                    <p class="card-text">Final highest bid: RM <?= $successItem["currentBid"] ?></p>

                                                    <button type="button" style="width:100%" class="btn btn-primary text-uppercase text-nowrap" data-toggle="modal" data-target="#acceptItem<?= $key ?>">
                                                        Accept Item
                                                    </button>
                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="acceptItem<?= $key ?>">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Accept Item</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">

                                                                    <form action="successBidManager.php" method="POST">
                                                                        <div class="form-group">
                                                                            <h5>Please take note:</h5>
                                                                            <p>Once you accept the item, you cannot cancel it anymore</p>
                                                                        </div>
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <form action="successBidManager.php" method="POST">
                                                                        <input type="hidden" name="itemID" value="<?= $successItem["itemID"] ?>">
                                                                        <input type="submit" value="Accept" name="acceptItem" class="btn btn-primary text-uppercase text-nowrap">
                                                                    </form>
                                                                    <button type="button" class="btn btn-danger text-uppercase text-nowrap" data-dismiss="modal">Close</button>
                                                                </div>


                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" style="width:100%" class="btn btn-danger text-uppercase text-nowrap" data-toggle="modal" data-target="#declineItem<?= $key ?>">
                                                        Decline Item
                                                    </button>
                                                    <!-- The Modal -->
                                                    <div class="modal fade" id="declineItem<?= $key ?>">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">

                                                                <!-- Modal Header -->
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Decline Item</h4>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <!-- Modal body -->
                                                                <div class="modal-body">
                                                                    <h5>Please take note:</h5>
                                                                    <p>Once you decline the item, you cannot accept it anymore</p>
                                                                    <form action="successBidManager.php" method="POST">
                                                                        <div class="form-group">
                                                                            <input type="hidden" name="itemID" value="<?= $successItem["itemID"] ?>">
                                                                            <h6 for="reason">Reason for decline this item</h6>
                                                                            <textarea name="reason" id="reason" class="form-control" cols="30" rows="5" placeholder="Enter your reason here" required></textarea>
                                                                        </div>
                                                                </div>

                                                                <!-- Modal footer -->
                                                                <div class="modal-footer">
                                                                    <input type="submit" value="Decline" name="declineItem" class="btn btn-primary text-uppercase text-nowrap">
                                                                    <button type="button" class="btn btn-danger text-uppercase text-nowrap" data-dismiss="modal">Close</button>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } else if ($successItem["biddingStatus"] == "accept") {
                                        ?>
                                            <div style="width:200px">
                                                <?php
                                                $itemID = $successItem['itemID'];
                                                $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                                $itemPic = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($itemPic) > 0) {
                                                    $itemPicture = mysqli_fetch_array($itemPic);
                                                ?>
                                                    <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                                <?php
                                                }
                                                ?>
                                                <div class="card-body">
                                                    <h4 class="card-title"><?= $successItem["itemName"] ?></h4>
                                                    <p class="card-text">Final highest bid: RM <?= $successItem["currentBid"] ?></p>
                                                    <a href="selectAddress.php?id=<?= $successItem["itemID"] ?>">
                                                        <button type="button" class="btn btn-primary text-uppercase text-nowrap">
                                                            Insert Address
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php
                                        } else if ($successItem["biddingStatus"] == "address_inserted") {
                                        ?>
                                            <div style="width:200px">
                                                <?php
                                                $itemID = $successItem['itemID'];
                                                $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                                $itemPic = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($itemPic) > 0) {
                                                    $itemPicture = mysqli_fetch_array($itemPic);
                                                ?>
                                                    <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                                <?php
                                                }
                                                ?>
                                                <div class="card-body">
                                                    <h4 class="card-title"><?= $successItem["itemName"] ?></h4>
                                                    <p class="card-text">Final highest bid: RM <?= $successItem["currentBid"] ?></p>
                                                    <a href="paypal/payment.php?id=<?= $successItem["itemID"] ?>">
                                                        <button type="button" class="btn btn-primary text-uppercase">
                                                            Pay Now
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <center>You have no success bid yet.</center>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
                <div class="container">
                    <h1 class="text-uppercase">My history</h1>
                    <hr>
                    <div class="card rounded shadow">
                        <div class="card-body">
                            <div class="d-flex flex-wrap">
                                <?php
                                if (!empty($historyItems)) {
                                    foreach ($historyItems as $key => $historyItem) {
                                        if ($historyItem["biddingStatus"] == "paid") { ?>
                                            <div style=" width:200px">
                                                <?php
                                                $itemID = $historyItem['itemID'];
                                                $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                                $itemPic = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($itemPic) > 0) {
                                                    $itemPicture = mysqli_fetch_array($itemPic);
                                                ?>
                                                    <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                                <?php
                                                } else {
                                                ?>
                                                    <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                                <?php
                                                }
                                                ?> <div class="card-body">
                                                    <h4 class="card-title"><?= $historyItem["itemName"] ?></h4>
                                                    <p class="card-text">Paid: RM <?= $historyItem["currentBid"] ?></p>
                                                    <a href="historyItem.php?id=<?= $historyItem["itemID"] ?>" class="btn btn-primary text-uppercase" style="width:100%">See item</a>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                } else {
                                    ?>
                                    <center>You have no bid for anything yet.</center>
                                <?php
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu3" class="tab-pane fade">
                <div class="container">
                    <h1 class="text-uppercase">To Receive</h1>
                    <hr>
                    <div class="card rounded shadow">
                        <div class="card-body">
                            <table id="receiveTable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Item Name</th>
                                        <th>Courier Name</th>
                                        <th>Tracking Number</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($receiveItems)) {
                                        foreach ($receiveItems as $key => $receiveItem) {
                                            if ($receiveItem["biddingStatus"] == "shipped out" || $receiveItem["biddingStatus"] == "received") { ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $itemID = $receiveItem['itemID'];
                                                        $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                                        $itemPic = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($itemPic) > 0) {
                                                            $itemPicture = mysqli_fetch_array($itemPic);
                                                        ?>
                                                            <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                                        <?php
                                                        }
                                                        ?>

                                                    </td>
                                                    <td><?= $receiveItem["itemName"] ?> </td>
                                                    <td><?= $receiveItem["courierName"] ?></td>
                                                    <td><?= $receiveItem["trackingNumber"] ?></td>
                                                    <td>
                                                        <?php if ($receiveItem["biddingStatus"] == "shipped out") { ?>
                                                            <button type="button" class="btn btn-info text-uppercase" data-toggle="modal" data-target="#editTracking">Receive Order</button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="editTracking" role="dialog">
                                                                <div class="modal-dialog">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Receive Order</h4>
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <h2>Are you sure?</h2>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <div class="form-group">
                                                                                <form action="receiveOrder.php" method="post" enctype="multipart/form">
                                                                                    <input type="hidden" name="biddingID" value="<?= $receiveItem["biddingID"] ?>">
                                                                                    <input type="submit" value="Yes" name="receiveOrder" class="btn btn-primary text-uppercase">
                                                                                    <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Cancel</button>
                                                                            </div>
                                                                        </div>
                                                                        </form>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        <?php } else if ($receiveItem["biddingStatus"] == "received") { ?>
                                                            <button type="button" class="btn btn-info text-uppercase" data-toggle="modal" data-target="#editTracking">Rate</button>
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="editTracking" role="dialog">
                                                                <div class="modal-dialog">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title">Rate</h4>
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="container">
                                                                                <h1>Add Your Rating</h1>
                                                                                <hr>
                                                                                <div class="col-lg-12">
                                                                                    <h3>Put your Rating </h3>
                                                                                    <span id="error_msg" style="display: none;color:red"></span>
                                                                                    <br>
                                                                                    <div style="background: #f1f1f1; padding: 30px;color:white;text-align:center">
                                                                                        <?php
                                                                                        for ($counter = 0; $counter < 5; $counter++) {
                                                                                            echo '<i class="fa fa-star fa-2x star" data-index="' . $counter . '" style="text-shadow: 0 0 3px #000;"></i>';
                                                                                        }
                                                                                        ?>

                                                                                    </div>

                                                                                </div>

                                                                                <input type="hidden" name="demo_id" id="demo_id" value="1">
                                                                                <br>
                                                                                <div class="col-lg-12">
                                                                                    <form action="ratingManager.php" method="post" id="ratingForm" onsubmit="return checkForm()">
                                                                                        <h3>Put your Feedback</h3><br>
                                                                                        <input type="hidden" name="biddingID" value="<?= $receiveItem["biddingID"] ?>">
                                                                                        <input type="hidden" name="itemID" value="<?= $receiveItem["itemID"] ?>">
                                                                                        <input type="hidden" name="rating" id="rating">
                                                                                        <textarea class="form-control" rows="5" style="font-size:16px" placeholder="Write your review here..." name="feedback" id="feedback" required></textarea><br>
                                                                                        <div class="modal-footer">
                                                                                            <div class="form-group">
                                                                                                <form action="receiveOrder.php" method="post" enctype="multipart/form">
                                                                                                    <button class="btn btn-primary text-uppercase" id="rating_submit" name="saveRating">Submit</button>
                                                                                            </div>
                                                                                            <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Cancel</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="menu4" class="tab-pane fade">
                <div class="container">
                    <h1 class="text-uppercase">Completed</h1>
                    <hr>
                    <div class="card rounded shadow">
                        <div class="card-body">
                            <table id="completedTable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Item Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($completeItems)) {
                                        foreach ($completeItems as $completeItem) {
                                            if ($completeItem["biddingStatus"] == "complete") { ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $itemID = $completeItem['itemID'];
                                                        $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                                        $itemPic = mysqli_query($conn, $sql);
                                                        if (mysqli_num_rows($itemPic) > 0) {
                                                            $itemPicture = mysqli_fetch_array($itemPic);
                                                        ?>
                                                            <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $completeItem["itemName"] ?> </td>
                                                    <td><a href="historyItem.php?id=<?= $completeItem["itemID"] ?>" class="btn btn-primary text-uppercase">See Item</a></td>
                                                </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>
<script src="../js/rating.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

<script>
    const receiveTable = document.getElementById("receiveTable");
    if (receiveTable) {
        new simpleDatatables.DataTable(receiveTable);
    }
    const completedTable = document.getElementById("completedTable");
    if (completedTable) {
        new simpleDatatables.DataTable(completedTable);
    }
</script>

</html>