<?php

require_once "../include/session.php";
require_once "../include/conn.php";

if (isset($_POST["addStaff"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if ($password != $confirmPassword) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Both password must be the same');
    							    window.location.href='manageStaff.php';
    							    </script>");
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $verification_status = "active";
    $account_type = "staff";

    $query = "INSERT INTO `user`(`username`, `password`,`verification_status`, `account_type`) VALUES ('$username','$password','$verification_status','$account_type')";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully add a staff account.');
    							    window.location.href='manageStaff.php';
    							    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('System ecounter error, failed to add a staff account.');
    							    window.location.href='manageStaff.php';
    							    </script>");
    }
}

if (isset($_POST["editStaff"])) {
    $staffID = $_POST["staffID"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    if ($password != $confirmPassword) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Both password must be the same');
    							    window.location.href='manageStaff.php';
    							    </script>");
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE `user` SET `password`='$password' WHERE userID = $staffID";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully edit the account.');
    							    window.location.href='manageStaff.php';
    							    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('System ecounter error, failed to edit the account.');
    							    window.location.href='manageStaff.php';
    							    </script>");
    }
}

if (isset($_POST["suspendStaff"])) {
    $staffID = $_POST["staffID"];
    $verification_status = "suspend";

    $query = "UPDATE `user` SET `verification_status`='$verification_status' WHERE userID = $staffID";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully suspend the account.');
    							    window.location.href='manageStaff.php';
    							    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('System ecounter error, failed to suspend the account.');
    							    window.location.href='manageStaff.php';
    							    </script>");
    }
}

if (isset($_POST["activeStaff"])) {
    $staffID = $_POST["staffID"];
    $verification_status = "active";

    $query = "UPDATE `user` SET `verification_status`='$verification_status' WHERE userID = $staffID";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully active the account.');
    							    window.location.href='manageStaff.php';
    							    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('System ecounter error, failed to active the account.');
    							    window.location.href='manageStaff.php';
    							    </script>");
    }
}
