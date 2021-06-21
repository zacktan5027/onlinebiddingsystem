<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$id = $_SESSION["user"]["id"];

if (isset($_POST["acceptReport"])) {
    $reportID = $_POST["reportID"];

    $sql = "SELECT * FROM report NATURAL JOIN user WHERE reportID = $reportID";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);

    $sql = "UPDATE report SET report_status='accept', handled_by=$id WHERE reportID = $reportID";
    $query = mysqli_query($conn, $sql);

    ini_set("smtp", "smtp.server.com");
    $to = $row["email"];
    $subject = "Online Bidding System - Report Response";
    $message = "Hi, " . $row["firstName"] . " " . $row["lastName"] . ". Thanks for report an problem to us. Your report has been accepted by us and we will improve the problem as soon as possible.";
    $headers  = 'From: adhe.ansa@gmail.com';
    $headers .= "MIME-Version:1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);


    echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully accept the report.');
        						    window.location.href='report.php';
        						    </script>");
}

if (isset($_POST["rejectReport"])) {
    $reportID = $_POST["reportID"];

    $sql = "SELECT * FROM report NATURAL JOIN user WHERE reportID = $reportID";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);

    $sql = "UPDATE report SET report_status='reject', handled_by=$id WHERE reportID = $reportID";
    $query = mysqli_query($conn, $sql);


    ini_set("smtp", "smtp.server.com");
    $to = $row["email"];
    $subject = "Online Bidding System - Report Response";
    $message = "Hi, " . $row["firstName"] . " " . $row["lastName"] . ". Thanks for report an problem to us. Your report has been rejected by us because we found that the problem being reported did not violate our policy.";
    $headers  = 'From: adhe.ansa@gmail.com';
    $headers .= "MIME-Version:1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    mail($to, $subject, $message, $headers);

    echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully reject the report.');
        						    window.location.href='report.php';
        						    </script>");
}

echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to process you request');
    							    window.location.href='index.php';
    							    </script>");
