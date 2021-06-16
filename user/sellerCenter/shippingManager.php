<?php

session_start();

require_once "../../include/conn.php";

if (isset($_POST["saveTracking"])) {

    $biddingID = $_POST["biddingID"];
    $courierName = $_POST["courierName"];
    $trackingNumber = $_POST["trackingNumber"];

    $updateStatus = $conn->query("UPDATE `bidding` SET `bidding_status`='shipped out' WHERE biddingID=$biddingID");
    $sql = $conn->query("INSERT INTO `delivery`(`biddingID`, `courier_name`, `tracking_number`) VALUES ($biddingID, '$courierName', $trackingNumber)");
    if ($sql) {
        echo ("<script>
                window.alert('Tracking number successfully added.');
                window.location.href='shipping.php';
                </script>");
    } else {
        echo ("<script>
                window.alert('Fail to add the tracking number. Please try again');
                window.location.href='shipping.php';
                </script>");
    }
}

if (isset($_POST["editTracking"])) {

    $biddingID = $_POST["biddingID"];
    $courierName = $_POST["courierName"];
    $trackingNumber = $_POST["trackingNumber"];

    $updateStatus = $conn->query("UPDATE `bidding` SET `bidding_status`='shipped out' WHERE biddingID=$biddingID");
    $sql = $conn->query("UPDATE `delivery` SET `courier_name`='$courierName',`tracking_number`=$trackingNumber WHERE biddingID=$biddingID");
    if ($sql) {
        echo ("<script>
                window.alert('Tracking number successfully edited.');
                window.location.href='shipping.php';
                </script>");
    } else {
        echo ("<script>
                window.alert('Fail to edit the tracking number. Please try again');
                window.location.href='shipping.php';
                </script>");
    }
}
