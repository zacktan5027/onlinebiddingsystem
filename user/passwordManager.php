<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

if (isset($_POST["changePassword"])) {
    $verification_key = md5(time() . $_SESSION["user"]["id"]);

    $email = $conn->query("SELECT email FROM user WHERE userID = " . $_SESSION["user"]["id"] . "");
    $row = $email->fetch_array();
    $sql = "UPDATE `user` SET `verification_key`=? WHERE userID=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('si', $verification_key, $_SESSION["user"]["id"]);
        $stmt->execute();
        $stmt->close();

        ini_set("smtp", "smtp.server.com");
        $to = $row["email"];
        $subject = "Online Bidding System - Change Password";
        $message = "Hi, " . $_SESSION["user"]["firstName"] . " " . $_SESSION["user"]["lastName"] . ". Click <a href='http://localhost/obs/changePassword.php?vkey=" . $verification_key . "&email=" . $row["email"] . "'>here</a> to change your password.";
        $headers  = 'From: adhe.ansa@gmail.com';
        $headers .= "MIME-Version:1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($to, $subject, $message, $headers);

        echo "<script>
                window.alert('An email is sent to your email.');
                window.location.href='logout.php'
                </script>";
    }
}

if (isset($_POST["savePassword"])) {

    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "UPDATE `user` SET `password`=? WHERE userID=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('si', $password, $_SESSION["user"]["id"]);
        $stmt->execute();
        $stmt->close();

        echo "<script>
                window.alert('Successfully changed you password.');
                window.location.href='logout.php'
                </script>";
    }
}
