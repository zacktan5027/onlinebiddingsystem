<?php

require_once "../include/session.php";
require_once "../include/conn.php";

if (isset($_POST['insertBid'])) {

    $bidderID = $_POST["bidderID"];
    $bidPrice = $_POST["bidPrice"];
    $itemID = $_POST["itemID"];

    $sql = mysqli_query($conn, "UPDATE `bidding` SET `bidderID`=" . $bidderID . ",`current_bid`=" . $bidPrice . " WHERE itemID=" . $itemID . "") or die();
    $checkExistence = "SELECT * FROM bidding_history WHERE bidderID = " . $bidderID . " AND itemID = " . $itemID . "";
    $resulCheckExistence = $conn->query($checkExistence);
    if ($resulCheckExistence != false && $resulCheckExistence->num_rows > 0) {
        $sql = mysqli_query($conn, "UPDATE bidding_history SET bid_price=$bidPrice WHERE bidderID=$bidderID") or die();
    } else {
        $sql = mysqli_query($conn, "INSERT INTO `bidding_history`(`bidderID`, `itemID`,`bid_price`) VALUES (" . $bidderID . "," . $itemID . ", " . $bidPrice . ")") or die();
    }
}

if (isset($_POST["getCurrentBid"])) {

    $itemID = $_POST["itemID"];

    $sql = $conn->query("SELECT * FROM item NATURAL JOIN bidding WHERE itemID=" . $itemID . "");
    $row = $sql->fetch_array();
    if ($row["current_bid"] == 0) {
        $output = "RM " . sprintf('%0.2f', $row["item_start_price"]);
    } else {
        $output = "RM " . sprintf('%0.2f', $row["current_bid"]);
    }
    echo $output;
}

if (isset($_POST["getHighestBidder"])) {

    $itemID = $_POST["itemID"];

    $sql = $conn->query("SELECT * FROM `bidding` JOIN user ON bidderID=userID WHERE itemID=" . $itemID . "");
    $row = $sql->fetch_array();
    if (empty($row["current_bid"])) {
        $output = "No bidder found";
    } else {
        $output = $row["firstName"];
    }
    echo $output;
}

if (isset($_POST["getTotalBidder"])) {

    $itemID = $_POST["itemID"];

    $sql = $conn->query("SELECT COUNT(*) as total_bidder FROM bidding_history WHERE itemID=$itemID");
    $row = $sql->fetch_array();
    if (empty($row["total_bidder"])) {
        $output = "No bidder found";
    } else {
        $output = $row["total_bidder"];
    }
    echo $output;
}
