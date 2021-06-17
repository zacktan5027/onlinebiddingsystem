<?php

require_once "../include/session.php";
require_once "../include/conn.php";

if (isset($_POST["sendReport"])) {
    $userID = $_SESSION["user"]["id"];
    $reportTitle = $_POST["reportTitle"];
    $reportDescription = $_POST["reportDescription"];
    $options = $_POST["options"];

    if ($_FILES['screenShot']['name'] == "") {
        $image = "";
    } else {
        $unique_id = rand(time(), 100000000);

        $extension  = pathinfo($_FILES["screenShot"]["name"], PATHINFO_EXTENSION);
        $target_dir = "../reportSubmission/";
        $target = $target_dir . $userID . "_" . $unique_id . "." . $extension;
        $image = $userID . "_" . $unique_id . "." . $extension;
    }

    $sql = "INSERT INTO `report`(`userID`, `report_title`, `report_description`, `report_category`, `screenshot`) VALUES (?,?,?,?,?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('issss', $userID, $reportTitle, $reportDescription, $options, $image);
        $stmt->execute();
        $stmt->close();

        move_uploaded_file($_FILES["screenShot"]["tmp_name"], $image);


        echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully report the problem.');
        						    window.location.href='index.php';
        						    </script>");
    } else {
        echo "<script>
                window.alert('Something went wrong');
                window.location.href='register.php'
                </script>";
    }
}
