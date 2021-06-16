<?php

session_start();

require_once "../include/conn.php";

if (isset($_POST["favourite"])) {
    $buyerID = $_POST["buyerID"];
    $itemID = $_POST["itemID"];

    $sql = $conn->query("INSERT INTO `favourite`(`userID`, `itemID`) VALUES ('$buyerID','$itemID')");
}

if (isset($_POST["unfavourite"])) {
    $buyerID = $_POST["buyerID"];
    $itemID = $_POST["itemID"];

    $sql = $conn->query("DELETE FROM `favourite` WHERE userID=$buyerID AND itemID=$itemID");

    echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Favourite removed.');
        						    window.location.href='wishList.php';
        						    </script>");
}
