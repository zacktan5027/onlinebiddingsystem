<?php
require_once "../include/session.php";
require_once "../include/conn.php";

if (isset($_GET["delete"])) {

    $sql = $conn->query("DELETE FROM `address` WHERE addressID=" . $_GET["addressID"] . "");

    echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully delete the address');
    							    window.location.href='myAddress.php';
    							    </script>");
}

if (isset($_POST["addAddress"])) {
    $customerName = trim($_POST["customerName"]);
    $phoneNumber = trim($_POST["phoneNumber"]);
    $address1 = trim($_POST["address1"]);
    $address2 = trim($_POST["address2"]);
    $city = trim($_POST["city"]);
    $postcode = trim($_POST["postcode"]);
    $state = trim($_POST["state"]);

    $sql = "INSERT INTO `address`(`userID`, `name`, `phone_number`, `address1`, `address2`, `city`, `postcode`, `state`) VALUES (?,?,?,?,?,?,?,?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('isssssss', $_SESSION["user"]["id"], $customerName, $phoneNumber, $address1, $address2, $city, $postcode, $state);
        $stmt->execute();
        $stmt->close();

        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully added the address');
    							    window.location.href='myAddress.php';
    							    </script>");
    }
}

if (isset($_POST["editAddress"])) {
    $addressID = trim($_POST["addressID"]);
    $customerName = trim($_POST["customerName"]);
    $phoneNumber = trim($_POST["phoneNumber"]);
    $address1 = trim($_POST["address1"]);
    $address2 = trim($_POST["address2"]);
    $city = trim($_POST["city"]);
    $postcode = trim($_POST["postcode"]);
    $state = trim($_POST["state"]);

    $sql = "UPDATE `address` SET `name`= ?,`phone_number`= ?,`address1`= ?,`address2`= ?,`city`= ?,`postcode`= ?,`state`=? WHERE addressID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sssssssi', $customerName, $phoneNumber, $address1, $address2, $city, $postcode, $state, $addressID);
        $stmt->execute();
        $stmt->close();

        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully edited the address');
    							    window.location.href='myAddress.php';
    							    </script>");
    }
}
