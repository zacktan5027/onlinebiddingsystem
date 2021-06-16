<?php

session_start();

require_once "../include/conn.php";

$itemID = $_POST["itemID"];
$customerName = $_POST["customerName"];
$phoneNumber = $_POST["phoneNumber"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$city = $_POST["city"];
$postcode = $_POST["postcode"];
$state = $_POST["state"];
$note = $_POST["note"];


if (isset($_POST['insertAddress'])) {

    if ($_POST["customerDecision"] == 1) {
        $sql = "INSERT INTO `address`(`userID`, `name`, `phone_number`, `address1`, `address2`, `city`, `postcode`, `state`) VALUES (?,?,?,?,?,?,?,?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('isssssss', $_SESSION["user"]["id"], $customerName, $phoneNumber, $address1, $address2, $city, $postcode, $state);
            $stmt->execute();
            $stmt->close();
        }
    }

    $itemStatus = "address_inserted";
    $address = $address1 . "," . $address2 . "," . $postcode . " " . $city . "," . $state;

    $sql = $conn->query("SELECT * FROM bidding_history NATURAL JOIN bidding NATURAL JOIN item WHERE bidding_status='accept' AND itemID = " . $itemID . "");
    $row = $sql->fetch_array();

    if (!empty($row)) {
        $sql = "UPDATE `bidding` SET `bidding_status`=?, `address`=?,`note`=? WHERE itemID=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sssi', $itemStatus, $address, $note, $itemID);
            $stmt->execute();
            $stmt->close();
        }

        echo ("<script LANGUAGE='JavaScript'>
        						    window.location.href='paypal/payment.php?id=" . $itemID . "';
        						    </script>");
    }
}
