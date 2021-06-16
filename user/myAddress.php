<?php

session_start();

require_once "../include/conn.php";

$sql = $conn->query("SELECT * FROM address WHERE userID=" . $_SESSION["user"]["id"] . "");
$addresses = [];
while ($row = $sql->fetch_array()) {
    $addresses[] = array(
        "name" => $row["name"],
        "phone_number" => $row["phone_number"],
        "addressID" => $row["addressID"],
        "address1" => $row["address1"],
        "address2" => $row["address2"],
        "city" => $row["city"],
        "postcode" => $row["postcode"],
        "state" => $row["state"]
    );
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>My Address</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <a href="addAddress.php" class="float-right"><button class="btn btn-primary text-uppercase">+ Add address</button></a>
        <h1 class="headline mb-3 font-weight-bold text-uppercase">My Address</h1>
        <hr>
        <div class="card rounded shadow">
            <div class="card-body">
                <?php
                if (empty($addresses)) {
                ?>
                    <p>There is no addresses</p>
                    <?php
                } else {
                    foreach ($addresses as $key => $address) {
                    ?><div class="row">
                            <div class="col-10">
                                <a href="editAddress.php?addressID=<?= $address["addressID"] ?>" class="btn btn-outline-secondary btn-block text-left p-4 m-1">
                                    <strong id="savedCustomerName"><?= $address["name"] ?></strong> - <span id="savedPhoneNumber"><?= $address["phone_number"] ?></span><br>
                                    <span id="savedAddress1"><?= $address["address1"] ?></span>, <span id="savedAddress2"><?= $address["address2"] ?></span>
                                    <span id="savedCity"><?= $address["city"] ?></span>
                                    <span id="savedPostCode"><?= $address["postcode"] ?></span> <span id="savedState"><?= $address["state"] ?></span>
                                    <i class="fas fa-angle-right float-right"></i>
                                </a>
                            </div>
                            <div class="col-2 my-auto">
                                <a href="addressManager.php?delete&addressID=<?= $address["addressID"] ?>" style="width:100%" class="btn btn-danger p-3 text-uppercase" onclick="return confirm('Are you sure want to delete this address?')">Delete</a>
                            </div>
                        </div>
                        <hr>
                <?php
                    }
                }
                ?>

                <div>

                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

</html>