<?php

require_once "checkLogin.php";
require_once "../include/conn.php";


if (isset($_POST["receiveOrder"])) {
    $biddingID = $_POST["biddingID"];

    $sql = $conn->query("UPDATE bidding SET bidding_status='received' WHERE biddingID='$biddingID'");

    echo ("<script>
                window.alert('Successfully update status');
                window.location.href='myBid.php';
                </script>");
}
