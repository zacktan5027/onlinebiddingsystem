<?php

session_start();

require_once "../include/conn.php";

if (isset($_POST["saveProfile"])) {

    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phoneNumber = $_POST["phoneNumber"];
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
