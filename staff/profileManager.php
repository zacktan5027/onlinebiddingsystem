<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

if (isset($_POST["saveProfile"])) {

    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $email = trim($_POST["email"]);
    $phoneNumber = trim($_POST["phoneNumber"]);
    $userID = $_SESSION["user"]["id"];

    $sql = "UPDATE user SET firstName='$firstName', lastName='$lastName', email='$email', phone_number='$phoneNumber' WHERE userID='$userID'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully update your profile.');
        						    window.location.href='profile.php';
        						    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Fail to update your profile.');
        						    window.location.href='profile.php';
        						    </script>");
    }
}

echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to process you request');
    							    window.location.href='index.php';
    							    </script>");
