<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

if (isset($_POST["getChat"])) {
    $senderID = $_SESSION["user"]["id"];
    $receiverID = mysqli_real_escape_string($conn, $_POST['sellerID']);
    $output = "";
    $sql = "SELECT * FROM messages LEFT JOIN user ON user.userID = messages.senderID
                WHERE (senderID = {$senderID} AND receiverID = {$receiverID})
                OR (senderID = {$receiverID} AND receiverID = {$senderID}) ORDER BY messageID";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['senderID'] == $senderID) {
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p><small class="font-weight-lighter">' . $row['send_time'] . '</small><br>' . $row['msg'] . '</p>
                                </div>
                                </div>';
            } else {
                $output .= '<div class="chat incoming">
                                <img src="../profilePicture/' . $row['profile_picture'] . '" class="smallImage" alt="">
                                <div class="details">
                                    <p><small class="font-weight-lighter">' . $row['send_time'] . '</small><br>' . $row['msg'] . '</p>
                                </div>
                                </div>';
            }
        }
    } else {
        $output .= '<div class="text-center">No messages are available. Once you send message they will appear here.</div>';
    }
    echo $output;
}

if (isset($_POST["sendChat"])) {

    $senderID = $_SESSION["user"]["id"];
    $receiverID = $_POST["sellerID"];
    $message = $_POST["message"];

    $sql = mysqli_query($conn, "INSERT INTO `messages`(`senderID`, `receiverID`, `msg`) VALUES (" . $senderID . "," . $receiverID . ",'" . $message . "')") or die();
}

echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to process you request');
    							    window.location.href='index.php';
    							    </script>");
