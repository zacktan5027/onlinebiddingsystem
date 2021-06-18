<?php

require_once "include/conn.php";

if (isset($_POST["forgetPassword"])) {
    $username = $_POST["username"];
    $verification_key = md5(time());

    $sql = "SELECT firstName, lastName, email FROM user WHERE username = '$username'";
    $email = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_array($email)) {
        $sql = "UPDATE `user` SET `verification_key`=? WHERE username=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ss', $verification_key,  $username);
            $stmt->execute();
            $stmt->close();

            ini_set("smtp", "smtp.server.com");
            $to = $row["email"];
            $subject = "Online Bidding System - Change Password";
            $message = "Hi, " . $row["firstName"] . " " . $row["lastName"] . ". Click <a href='http://localhost/onlinebiddingsystem/changePassword.php?vkey=" . $verification_key . "&email=" . $row["email"] . "'>here</a> to change your password.";
            $headers  = 'From: adhe.ansa@gmail.com';
            $headers .= "MIME-Version:1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail($to, $subject, $message, $headers);

            echo "<script>
                window.alert('An email is sent to your email.');
                window.location.href='index.php'
                </script>";
        }
    }
}

if (isset($_POST["savePassword"])) {
    $password = $_POST["password"];
    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_POST["email"];
    $verification_key = md5(time());

    $sql = "UPDATE `user` SET `password`=?, `verification_key`=? WHERE `email`=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sss', $password, $verification_key, $email);
        $stmt->execute();
        $stmt->close();

        echo "<script>
                window.alert('Successfully changed you password');
                window.location.href='index.php'
                </script>";
    }
}
