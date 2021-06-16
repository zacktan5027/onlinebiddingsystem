<?php

session_start();

require_once "../include/conn.php";

if (isset($_POST["follow"])) {
    $buyerID = $_POST["buyerID"];
    $sellerID = $_POST["sellerID"];

    $sql = $conn->query("INSERT INTO `follow`(`sellerID`, `followerID`) VALUES ('$sellerID','$buyerID')");
}

if (isset($_POST["unfollow"])) {
    $buyerID = $_POST["buyerID"];
    $sellerID = $_POST["sellerID"];

    $sql = $conn->query("DELETE FROM `follow` WHERE sellerID=$sellerID AND followerID=$buyerID");
}
