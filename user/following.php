<?php

require_once "../include/conn.php";

session_start();

$id = $_SESSION["user"]["id"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <title>Following</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Following</h1>
        <hr>
        <div class="card rounded shadow">
            <div class="card-body">
                <table id="followingTable">
                    <thead>
                        <tr>
                            <th>Seller Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM follow WHERE followerID=$id";
                        $query = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_array($query)) {
                        ?>
                                <tr>
                                    <td>
                                        <?php
                                        $userID = $row['sellerID'];
                                        $sql = "SELECT * FROM user WHERE userID =$userID";
                                        $seller = mysqli_query($conn, $sql);
                                        $sellerName = mysqli_fetch_array($seller);
                                        echo $sellerName["firstName"] . " " . $sellerName["lastName"];
                                        ?>
                                    </td>
                                    <td>
                                        <a href="chat.php?id=<?= $userID ?>" class="btn btn-primary text-uppercase">Chat Now</a>
                                        <a href="shop.php?id=<?= $userID ?>" class="btn btn-primary text-uppercase">View Shop</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    const followingTable = document.getElementById("followingTable");
    if (followingTable) {
        new simpleDatatables.DataTable(followingTable);
    }
</script>

</html>