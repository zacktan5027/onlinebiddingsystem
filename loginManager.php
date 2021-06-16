<?php
session_start();
include_once "include/conn.php";

if (isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $checkUsername = "SELECT * FROM USER WHERE username = ?";
    $stmt = $conn->prepare($checkUsername);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = mysqli_stmt_get_result($stmt);
    $stmt->close();
    if ($row = mysqli_fetch_assoc($user)) {
        if ($row["verification_status"] == "active") {
            if (password_verify($password, $row["password"])) {
                $_SESSION["user"] = array(
                    "id" => $row["userID"],
                    "firstName" => $row["firstName"],
                    "lastName" => $row["lastName"],
                    "email" => $row["email"],
                    "phoneNumber" => $row["phone_number"],
                    "type" => $row["account_type"],
                    "profile_picture" => $row["profile_picture"],
                    "account_balance" => $row["account_balance"]
                );

                if ($row["account_type"] == "admin") {
                    echo ("<script>
                window.location.href='admin/index.php';
                </script>");
                } else if ($row["account_type"] == "staff") {
                    echo ("<script>
                window.location.href='staff/index.php';
                </script>");
                } else {
                    echo ("<script>
                window.location.href='user/index.php';
                </script>");
                }
            } else {
                echo ("<script>
                window.alert('Wrong password.');
                window.location.href='login.php';
                </script>");
            }
        } else if ($row["verification_status"] == "suspend") {
            echo ("<script>
                window.alert('Your account has been suspend please contact our support service for further information.');
                window.location.href='login.php';
                </script>");
        } else {
            echo ("<script>
                window.alert('Your account has not yet been active, please check your email to active your account.');
                window.location.href='login.php';
                </script>");
        }
    } else {
        echo ("<script>
                window.alert('Wrong account.');
                window.location.href='login.php';
                </script>");
    }
}
