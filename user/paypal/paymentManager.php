<?php

require_once "../../include/conn.php";
require_once "../../include/session.php";

if (isset($_POST["recordData"])) {
    if ($_POST["success"]) {
        $paid = "paid";
        $paymentmethod = "paypal";
        $itemID = $_POST["itemID"];
        $status = 1;
        $sql = "UPDATE `bidding` SET `bidding_status`=?,`payment_method`=?,`success`=? WHERE itemID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssii', $paid, $paymentmethod, $status, $itemID);
        $stmt->execute();
        $stmt->close();
    }
}

if (isset($_POST["systemPay"])) {
    $success = false;
    $itemPrice = $_POST["itemPrice"];
    $accountBalance = $_POST["accountBalance"];
    $itemID = $_POST["itemID"];

    if ($accountBalance < $itemPrice) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('You do not have enough balance, please top up your System Pay');
    							    window.location.href='payment.php?id=" . $itemID . "';
    							    </script>");
    } else {
        $newAccountBalance = $accountBalance - $itemPrice;
        $success = true;
    }

    if ($success) {
        $paid = "paid";
        $paymentmethod = "system pay";
        $status = 1;
        $sql = "UPDATE `bidding` SET `bidding_status`=?,`payment_method`=?,`success`=? WHERE itemID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssii', $paid, $paymentmethod, $status, $itemID);
        $stmt->execute();
        $stmt->close();

        $sql = "UPDATE `user` SET `account_balance`=? WHERE userID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('di', $newAccountBalance, $_SESSION["user"]["id"]);
        $stmt->execute();
        $stmt->close();

        echo ("<script LANGUAGE='JavaScript'>
    							    window.location.href='../index.php';
    							    </script>");
    }
}
