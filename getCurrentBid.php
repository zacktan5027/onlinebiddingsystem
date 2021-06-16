<?php
session_start();

require_once "include/conn.php";

if (isset($_POST["getCurrentBid"])) {

    $itemID = $_POST["itemID"];


    $sql = $conn->query("SELECT * FROM item NATURAL JOIN bidding WHERE itemID=" . $itemID . "");
    $row = $sql->fetch_array();

    $output = $row["current_bid"];

    echo $output;
}
