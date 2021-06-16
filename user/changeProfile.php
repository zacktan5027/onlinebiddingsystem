<?php

session_start();

require_once "../include/conn.php";

$sql = $conn->query("SELECT * FROM user WHERE userID=" . $_SESSION["user"]["id"] . "");
$user = $sql->fetch_array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Change Profile Picture</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Change Profile Picture</h1>
        <hr>
        <div class="text-center">
            <img class="rounded-circle border border-dark" id="previewProfile" src="../profilePicture/blankPicture.png" style="width:200px;height:200px" alt=""><br><br>
            <form action="profileManager.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="profilePicture">Please insert your profile picture</label>
                    <input type="file" name="image" id="profilePicture" class="form-control-file border" onchange="previewFile(this);" required>
                    <input type="submit" value="Save" name="changeProfile" class="btn btn-primary m-2">
                </div>
            </form>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script>
    function previewFile(input) {
        var file = $("input[type=file]").get(0).files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function() {
                $("#previewProfile").attr("src", reader.result);
            };

            reader.readAsDataURL(file);
        }
    }
</script>

</html>