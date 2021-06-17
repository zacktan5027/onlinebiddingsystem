<?php

require_once "../include/session.php";

function sendMail($email, $itemName)
{
    ini_set("smtp", "smtp.server.com");
    $to = $email;
    $subject = "Online Bidding System - Success Bid";
    $message = "You has successfully bidded the item " . $itemName . "";
    $headers  = 'From: adhe.ansa@gmail.com';
    $headers .= "MIME-Version:1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail(
        $to,
        $subject,
        $message,
        $headers
    );
}
