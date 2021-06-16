<?php

session_start();

require_once "../../include/conn.php";

$id = $_SESSION["user"]["id"];
$sql = "SELECT * FROM feedback WHERE sellerID = $id";
$query = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <title>Document</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Feedback</h1>
        <hr>
        <div class="card rounded shadow">
            <div class="card-header text-uppercase">
                <i class="fas fa-table me-1"></i>
                Feedback List
            </div>
            <div class="card-body">
                <table id="manageFeedbackTable">
                    <thead>
                        <tr>
                            <th>Buyer Name</th>
                            <th>Item Name</th>
                            <th>Rating</th>
                            <th>Feedback</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                        ?>
                            <tr>
                                <td>
                                    <?php
                                    $userID = $row['buyerID'];
                                    $sql = "SELECT * FROM user WHERE userID =$userID";
                                    $buyer = mysqli_query($conn, $sql);
                                    $buyerName = mysqli_fetch_array($buyer);
                                    echo $buyerName["firstName"] . " " . $buyerName["lastName"];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    $itemID = $row['itemID'];
                                    $sql = "SELECT * FROM item WHERE itemID = $itemID";
                                    $item = mysqli_query($conn, $sql);
                                    $itemName = mysqli_fetch_array($item);
                                    echo $itemName["item_name"];
                                    ?>
                                </td>
                                <td><?= $row["rating"] ?></td>
                                <td><?= $row["feedback"] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "../footer.php" ?>

</body>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

<script>
    const manageFeedbackTable = document.getElementById("manageFeedbackTable");
    if (manageFeedbackTable) {
        new simpleDatatables.DataTable(manageFeedbackTable);
    }
</script>


</html>