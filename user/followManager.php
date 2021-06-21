<?php

require_once "checkLogin.php";
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

echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to process you request');
    							    window.location.href='index.php';
    							    </script>");
