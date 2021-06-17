<?php

require_once "../include/session.php";
require_once "../include/conn.php";

if (isset($_POST["saveRating"])) {

    $itemID = $_POST["itemID"];
    $rating = $_POST["rating"];
    $feedback = $_POST["feedback"];
    $biddingID = $_POST["biddingID"];

    $sql = $conn->query("SELECT sellerID FROM item WHERE itemID = $itemID");
    $row = $sql->fetch_array();

    $buyerID = $_SESSION["user"]["id"];
    $sellerID = $row["sellerID"];


    $sql = "INSERT INTO `feedback`(`buyerID`, `sellerID`, `itemID`, `rating`, `feedback`) VALUES (?,?,?,?,?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('iiiis', $buyerID, $sellerID, $itemID, $rating, $feedback);
        $stmt->execute();
        $stmt->close();

        $updateStatus = $conn->query("UPDATE `bidding` SET `bidding_status`='complete' WHERE biddingID=$biddingID");

        echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully rated the item.');
        						    window.location.href='myBid.php';
        						    </script>");
    }
}
