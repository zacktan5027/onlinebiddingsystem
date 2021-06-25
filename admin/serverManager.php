<?php

require_once "checkLogin.php";
require_once "../include/conn.php";
require_once "sendMail.php";

if (isset($_POST['startServer'])) {
    if (file_exists('stop.txt')) {
        unlink('stop.txt');
    }
    ignore_user_abort(true);
    set_time_limit(0);
    $data = file_get_contents('start.txt');
    while (!file_exists('stop.txt')) {
        // Add 1 to $data
        $data = $data + 1;
        // Update file
        file_put_contents('start.txt', $data);


        $currentDate = date("Y-m-d");

        $checkEnd = "SELECT * FROM bidding JOIN user ON bidding.bidderID=user.userID NATURAL JOIN item WHERE bidding_status='end'";
        $stmt = $conn->prepare($checkEnd);
        $stmt->execute();
        $end = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($end)) {
            $stmt->close();
            if ($currentDate > $row["start_date"] || $currentDate == $row["start_date"]) {
                sendMail($row["email"], $row["item_name"]);
                $updateEnd = "UPDATE `bidding` SET `bidding_status`='email sent' WHERE itemID=?";
                $stmt = $conn->prepare($updateEnd);
                $stmt->bind_param('i', $row["itemID"]);
                $stmt->execute();
                $stmt->close();
            }
        }

        $checkStart = "SELECT * FROM bidding WHERE bidding_status='start'";
        $stmt = $conn->prepare($checkStart);
        $stmt->execute();
        $start = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($start)) {
            $stmt->close();
            if ($currentDate > $row["end_date"] || $currentDate == $row["end_date"]) {
                $updateStart = "UPDATE `bidding` SET `bidding_status`='end' WHERE itemID=?";
                $stmt = $conn->prepare($updateStart);
                $stmt->bind_param('i', $row["itemID"]);
                $stmt->execute();
                $stmt->close();
            }
        }

        $checkPending = "SELECT * FROM bidding WHERE bidding_status='pending'";
        $stmt = $conn->prepare($checkPending);
        $stmt->execute();
        $pending = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($pending)) {
            $stmt->close();
            if ($currentDate > $row["start_date"] || $currentDate == $row["start_date"]) {
                $updatePending = "UPDATE `bidding` SET `bidding_status`='start' WHERE itemID=?";
                $stmt = $conn->prepare($updatePending);
                $stmt->bind_param('i', $row["itemID"]);
                $stmt->execute();
                $stmt->close();
            }
        }
        sleep(10);
    }
}

echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to process you request');
    							    window.location.href='index.php';
    							    </script>");
