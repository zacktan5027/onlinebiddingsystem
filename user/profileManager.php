<?php

require_once "../include/session.php";
require_once "../include/conn.php";

if (isset($_POST["editProfile"])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);

    $sql = "SELECT * FROM user WHERE phone_number='$phone_number' AND userID!=" . $_SESSION["user"]["id"] . "";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {

        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Phone number is used.');
    							    window.location.href='profile.php';
    							    </script>");
    } else {
        $sql = "UPDATE `user` SET `firstName`=?,`lastName`=?,`phone_number`=? WHERE userID=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('sssi', $firstName, $lastName, $phoneNumber, $_SESSION["user"]["id"]);
            $stmt->execute();
            $stmt->close();

            echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully edited your profile.');
    							    window.location.href='profile.php';
    							    </script>");
        }
    }
}

if (isset($_POST["changeProfile"])) {

    $userID = $_SESSION["user"]["id"];

    if ($_FILES['image']['name'] == "") {
        $image = "";
    } else {
        $temp_file = $_FILES['image']['tmp_name'];

        $unique_id = rand(time(), 100000000);

        //rename the  profile picture 
        $extension  = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $target_dir = "../profilePicture/";
        $image = $userID . "_" . $unique_id . "." . $extension;
    }

    $sql = "SELECT profile_picture FROM user WHERE userID = $userID";
    $query = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($query);
    unlink("../profilePicture/" . $row["profile_picture"]);

    $sql = "UPDATE user SET profile_picture = '$image' WHERE userID=$userID";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        move_uploaded_file($temp_file, $target_dir . $image);

        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully changed your profile picture.');
    							    window.location.href='profile.php';
    							    </script>");
    }
}
