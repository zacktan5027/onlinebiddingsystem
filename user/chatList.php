<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <link rel="stylesheet" href="css/userStyle.css" type="text/css">
    <title>Chat List</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>
    <div class="container">
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Chat List</h1>
        <hr>
        <div class="card rounded shadow">
            <div class="card-body">
                <div class="d-flex">
                    <?php
                    $userList1 = [];
                    $sql = "SELECT receiverID FROM messages JOIN user ON userID=senderID WHERE senderID=" . $_SESSION["user"]["id"] . "";
                    $query = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($query)) {
                        $userList1[] = $row["receiverID"];
                    }
                    $userList2 = [];
                    $sql = "SELECT senderID FROM messages JOIN user ON userID=senderID WHERE receiverID=" . $_SESSION["user"]["id"] . "";
                    $query = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($query)) {
                        $userList2[] = $row["senderID"];
                    }
                    $userList = array_unique(array_merge($userList1, $userList2));

                    foreach ($userList as $user) {
                        $sql = "SELECT * FROM user WHERE userID=$user";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($query);
                        if ($row["userID"] != $_SESSION["user"]["id"]) {
                    ?>
                            <div class="card m-2 p-4 rounded" width="250px">
                                <a href="chat.php?sellerID=<?= $row["userID"] ?>">
                                    <div class="d-flex">
                                        <img src="../profilePicture/<?php echo $row['profile_picture']; ?>" class="smallImage" alt="">
                                        <div class="p-2 ml-2">
                                            <h4><?php echo $row['firstName'] . " " . $row['lastName'] ?></h4>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

</html>