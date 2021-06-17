<?php

require_once "include/conn.php";

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $email = $_POST["email"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $phoneNumber = $_POST["phoneNumber"];

    if ($_FILES['image']['name'] == "") {
        $image = "";
    } else {
        $temp_file = $_FILES['image']['tmp_name'];
        //get the latest total number of user in the system
        $getID = "SELECT * FROM USER";
        $resultGetID = $conn->query($getID);
        $id = $resultGetID->num_rows + 1;

        $unique_id = rand(time(), 100000000);

        //rename the  profile picture 
        $extension  = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $target_dir = "profilePicture/";
        $image = $id . "_" . $unique_id . "." . $extension;
    }

    if (trim($firstName) == "" || trim($lastName) == "") {
        $message = "";
        if (trim($firstName) == "") {
            $message = "First Name Field";
        }
        if (trim($lastName) == "") {
            if ($message == "")
                $message .= "Last Name Field";
            else
                $message .= " and Last Name Field";
        }
        echo "<script LANGUAGE='JavaScript'>
            window.alert('You should not leave " . $message . " empty.');
            window.location.href='register.php'
            </script>";
    }

    //check whether the username is existed in the database
    $checkUsername = "SELECT * FROM USER WHERE username ='" . $username . "'";
    $resultCheckUsername = $conn->query($checkUsername);
    if ($resultCheckUsername != false && $resultCheckUsername->num_rows > 0) {
        echo "<script LANGUAGE='JavaScript'>
            window.alert('The username is already taken, please try again.');
            window.location.href='register.php'
            </script>";
        return;
    }

    //check whether the email is exist in the database
    $checkEmail = "SELECT * FROM USER WHERE email = '" . $email . "'";
    $resulCheckEmail = $conn->query($checkEmail);
    if ($resulCheckEmail != false && $resulCheckEmail->num_rows > 0) {
        echo "<script LANGUAGE='JavaScript'>
                window.alert('Your email is already taken, please try again.');
                window.location.href='register.php'
                </script>";
        return;
    }

    //check whether the phone number is exist in the database
    $checkPhoneNumber = "SELECT * FROM USER WHERE phone_number='" . $phoneNumber . "'";
    $resultCheckPhoneNumber = $conn->query($checkPhoneNumber);
    if ($resultCheckPhoneNumber != false && $resultCheckPhoneNumber->num_rows > 0) {
        echo "<script LANGUAGE='JavaScript'>
                window.alert('Your phone number is already taken, please try again.');
                window.location.href='register.php'
                </script>";
        return;
    }

    $verification_key = md5(time() . $username);
    $verification_status = "inactive";
    $account_type = "user";
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO `user`(`username`, `password`, `firstName`, `lastName`, `email`, `phone_number`, `verification_key`, `verification_status`, `account_type`, `profile_picture`) VALUES (?,?,?,?,?,?,?,?,?,?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ssssssssss', $username, $password, $firstName, $lastName, $email, $phoneNumber, $verification_key, $verification_status, $account_type, $image);
        $stmt->execute();
        $stmt->close();

        //move the profile picture to folder 
        move_uploaded_file($temp_file, $target_dir . $image);

        ini_set("smtp", "smtp.server.com");
        $to = "$email";
        $subject = "Online Bidding System - Account Verification";
        $message = "Hi, " . $firstName . " " . $lastName . ". Click <a href='http://localhost/obs/verify.php?vkey=" . $verification_key . "&email=" . $email . "'>here</a> to verify your account.";
        $headers  = 'From: adhe.ansa@gmail.com';
        $headers .= "MIME-Version:1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        mail($to, $subject, $message, $headers);

        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully register, an email is sent to $email ,please verify your account.');
    							    window.location.href='register.php';
    							    </script>");
    } else {
        echo "<script>
                window.alert('Something went wrong');
                window.location.href='register.php'
                </script>";
    }
}
