<?php

require_once "../include/conn.php";
require_once "checkLogin.php";

$sql = $conn->query("SELECT * FROM bidding NATURAL JOIN item JOIN favourite ON favourite.itemID=item.itemID WHERE (bidding_status='start' OR bidding_status='suspend' OR bidding_status='end') AND favourite.userID = " . $_SESSION["user"]["id"] . "");
$biddingItems = [];
while ($row = $sql->fetch_array()) {
    $biddingItems[] = array(
        "itemID" => $row["itemID"],
        "itemName" => $row["item_name"],
        "itemDescription" => $row["item_description"],
        "itemStartPrice" => $row["item_start_price"],
        "itemQuantity" => $row["item_quantity"],
        "itemCategory" => $row["item_category"],
        "itemCondition" => $row["item_condition"],
        "itemWebsite" => $row["item_website"],
        "currentBid" => $row["current_bid"],
        "biddingStatus" => $row["bidding_status"],
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
    <title>My Wish List</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="card rounded shadow">
            <div class="card-body">
                <div class="card-body">
                    <div class="d-flex flex-wrap">
                        <?php
                        if (!empty($biddingItems)) {
                            foreach ($biddingItems as $key => $biddingItem) {
                                $sql = $conn->query("select * from item_picture WHERE itemID=" . $biddingItem["itemID"] . " limit 1");
                                $row = $sql->fetch_array();

                                if ($biddingItem["biddingStatus"] == "start") { ?>
                                    <div class="card m-2 rounded" style="width:200px">
                                        <?php
                                        $itemID = $biddingItem['itemID'];
                                        $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                        $itemPic = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($itemPic) > 0) {
                                            $itemPicture = mysqli_fetch_array($itemPic);
                                        ?>
                                            <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:100%;height:200px" alt="">
                                        <?php
                                        } else {
                                        ?>
                                            <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                        <?php
                                        }
                                        ?>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title"><?= $biddingItem["itemName"] ?></h5>
                                            <p class="card-text">Current highest bid: RM
                                                <?php
                                                if ($biddingItem["currentBid"] == 0) {
                                                    echo $biddingItem["itemStartPrice"];
                                                } else {
                                                    echo $biddingItem["currentBid"];
                                                }
                                                ?>
                                            </p>
                                            <a href="itemDetail.php?id=<?= $biddingItem["itemID"] ?>" class="btn btn-primary mt-auto" style="width:100%">See item</a>
                                        </div>
                                    </div>
                                <?php
                                } else if ($biddingItem["biddingStatus"] == "suspend") {
                                ?>
                                    <div class="card m-2 rounded" style="width:200px">
                                        <?php
                                        $itemID = $biddingItem['itemID'];
                                        $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                        $itemPic = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($itemPic) > 0) {
                                            $itemPicture = mysqli_fetch_array($itemPic);
                                        ?>
                                            <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                        <?php
                                        } else {
                                        ?>
                                            <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                        <?php
                                        }
                                        ?>
                                        <div class="card-body  d-flex flex-column">
                                            <h5 class="card-title"><?= $biddingItem["itemName"] ?></h5>
                                            <p class="card-text">Current highest bid: RM
                                                <?php
                                                if ($biddingItem["currentBid"] == 0) {
                                                    echo $biddingItem["itemStartPrice"];
                                                } else {
                                                    echo $biddingItem["currentBid"];
                                                }
                                                ?>
                                            </p>
                                            <form action="favouriteManager.php" method="post">
                                                <input type="hidden" name="buyerID" value="<?= $_SESSION["user"]["id"] ?>">
                                                <input type="hidden" name="itemID" value="<?= $biddingItem["itemID"] ?>">
                                                <input type="submit" value="Delete Favourite" name="unfavourite" class="btn btn-primary" style="width:100%">
                                            </form>
                                        </div>
                                        <div class="overlay">Item Suspended</div>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="card m-2 rounded" style="width:200px">
                                        <?php
                                        $itemID = $biddingItem['itemID'];
                                        $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                        $itemPic = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($itemPic) > 0) {
                                            $itemPicture = mysqli_fetch_array($itemPic);
                                        ?>
                                            <img src="../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:200px;height:200px" alt="">
                                        <?php
                                        } else {
                                        ?>
                                            <img src="../itemPicture/noImage.png" style="width:200px;height:200px" alt="">
                                        <?php
                                        }
                                        ?>
                                        <div class="card-body  d-flex flex-column">
                                            <h5 class="card-title"><?= $biddingItem["itemName"] ?></h5>
                                            <p class="card-text">Current highest bid: RM
                                                <?php
                                                if ($biddingItem["currentBid"] == 0) {
                                                    echo $biddingItem["itemStartPrice"];
                                                } else {
                                                    echo $biddingItem["currentBid"];
                                                }
                                                ?>
                                            </p>
                                            <form action="favouriteManager.php" method="post">
                                                <input type="hidden" name="buyerID" value="<?= $_SESSION["user"]["id"] ?>">
                                                <input type="hidden" name="itemID" value="<?= $biddingItem["itemID"] ?>">
                                                <input type="submit" value="Delete Favourite" name="unfavourite" class="btn btn-primary" style="width:100%">
                                            </form>
                                        </div>
                                        <div class="overlay">Item End</div>
                                    </div>
                            <?php
                                }
                            }
                        } else {
                            ?>
                            <center>You have no bid for anything yet.</center>
                        <?php
                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

</html>