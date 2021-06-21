<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$itemID = $_POST['itemID'];
$itemStatus = "";
if (isset($_POST['acceptItem'])) {

    $itemStatus = "accept";

    $sql = $conn->query("SELECT * FROM bidding_history NATURAL JOIN bidding NATURAL JOIN item WHERE bidding_status='email sent' AND itemID = " . $itemID . "");
    $row = $sql->fetch_array();

    if (!empty($row)) {
        $sql = "UPDATE `bidding` SET `bidding_status`=? WHERE itemID=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('si', $itemStatus, $itemID);
            $stmt->execute();
            $stmt->close();
        }

        echo ("<script LANGUAGE='JavaScript'>
        						    window.location.href='selectAddress.php?id=" . $itemID . "';
        						    </script>");
    }
}

if (isset($_POST['declineItem'])) {

    $itemStatus = "decline";
    $reason = $_POST['reason'];
    $sql = $conn->query("SELECT * FROM bidding_history NATURAL JOIN bidding NATURAL JOIN item WHERE bidding_status='email sent' AND itemID = " . $itemID . "");
    $row = $sql->fetch_array();

    if (!empty($row)) {
        $sql = "UPDATE `bidding` SET `bidding_status`=?,`reason`=?  WHERE itemID=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ssi', $itemStatus, $reason, $itemID);
            $stmt->execute();
            $stmt->close();
        }

        echo ("<script LANGUAGE='JavaScript'>
        						    window.location.href='myBid.php';
        						    </script>");
    }
}

echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to process you request');
    							    window.location.href='index.php';
    							    </script>");
