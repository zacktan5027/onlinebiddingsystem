<?php

require_once "checkLogin.php";
require_once "../include/conn.php";


if (isset($_GET['id'])) {
    $itemID = $_GET['id'];

    $sql = $conn->query("SELECT * FROM item NATURAL JOIN user WHERE itemID=" . $itemID . "");
    $row = $sql->fetch_array();

    $sellerID = $row['sellerID'];
} else {
    $sellerID = $_GET['sellerID'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <link rel="stylesheet" href="css/userStyle.css" type="text/css">
    <title>Chat</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="container-content shadow rounded">
            <div class="wrapper">
                <header>
                    <?php
                    $sql = mysqli_query($conn, "SELECT * FROM user WHERE userID = " . $_GET["sellerID"] . "");
                    if (mysqli_num_rows($sql) > 0) {
                        $row = mysqli_fetch_assoc($sql);
                    } else {
                        header("location: users.php");
                    }
                    ?>
                    <div class="d-flex align-items-center">
                        <?php if (isset($_GET['id'])) { ?>
                            <a href="chatList.php" style=" margin:auto 10px auto 0 "><i class="fas fa-arrow-left"></i></a>
                        <?php } else { ?>
                            <a href="chatList.php" style=" margin:auto 10px auto 0 "><i class="fas fa-arrow-left"></i></a>
                        <?php } ?>
                        <img src="../profilePicture/<?php echo $row['profile_picture']; ?>" class="smallImage" style="width:50px;height:50px" alt="">
                        <div class="p-2">
                            <span style="margin-top:50px"><?php echo $row['firstName'] . " " . $row['lastName'] ?></span>
                        </div>
                    </div>
                </header>
                <hr>
                <section class="chatArea">
                    <div id="chatBox" class="chatBox border rounded">

                    </div>
                    <form action="#" id="typingArea" class="needs-validation" novalidate>
                        <input type="hidden" name="sendChat">
                        <input type="hidden" name="sellerID" id="sellerID" value="<?php echo $sellerID; ?>">
                        <div class="input-group mt-3">
                            <input type="text" name="message" id="inputField" class="form-control" placeholder="Type a message here..." autocomplete="off" maxlength="100" required>
                            <div id="msg-error-msg" data-toggle="tooltip" data-placement="bottom" title="Please fill up this field"></div>
                            <div class="input-group-append">
                                <button id="sendButton" class="btn btn-primary rounded"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="../js/form-validation.js"></script>
<script src="../js/chat.js"></script>

</html>