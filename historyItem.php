<?php

require_once "include/conn.php";

session_start();

$itemID = $_GET["id"];

$sql = "SELECT * FROM item NATURAL JOIN bidding WHERE itemID=" . $itemID . "";
$query = mysqli_query($conn, $sql);
$number_of_picture = mysqli_num_rows($query);
$item = mysqli_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title><?= $item["item_name"] ?></title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>
    <div class="container">
        <div class="container-content rounded shadow">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-6">
                    <div id="itemPictures" class="carousel slide" data-ride="carousel">
                        <!-- The slideshow -->
                        <div class="carousel-inner">
                            <?php
                            $sql = $conn->query("SELECT * FROM item NATURAL JOIN item_picture WHERE itemID=" . $itemID . "");
                            $pictures = [];
                            while ($result = $sql->fetch_array()) {
                                echo $result["picture_name"];
                                $pictures[] = array(
                                    "pictureName" => $result["picture_name"]
                                );
                            } ?>
                            <?php
                            if (empty($pictures)) {
                            ?>
                                <div class="carousel-item active">
                                    <img src="itemPicture/noImage.png" height="500" width="500">
                                </div>
                                <?php
                            } else {
                                foreach ($pictures as $key => $picture) {
                                    if ($key == 0) {
                                ?>
                                        <div class="carousel-item active">
                                            <img src="itemPicture/<?php echo $picture["pictureName"]; ?>" height="500">
                                        </div>
                                    <?php } else {
                                    ?>
                                        <div class="carousel-item">
                                            <img src="itemPicture/<?= $picture["pictureName"] ?>" height="500" width="500">
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#itemPictures" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#itemPictures" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>
                <br>
                <!-- PRODUCT DETAILS-->
                <div class="col-lg-6">
                    <h1 class="text-uppercase">
                        <u><?= $item["item_name"] ?></u>
                    </h1>
                    <hr>
                    <h3 class="text-capitalize">current bid price</h3>
                    <h1 class="text-muted" id="currentBid" style="font-weight: normal;">
                        RM
                        <?php
                        if ($item["current_bid"] == 0)
                            echo $item["item_start_price"];
                        else
                            echo $item["current_bid"];
                        ?>
                    </h1>
                    <h4 class="text-capitalize">Highest bidder</h4>
                    <h1 id="highestBidder" class="text-muted" style="font-weight: normal;">
                        <?php

                        $getBidderName = $conn->query("SELECT * FROM bidding JOIN user WHERE userID=bidderID AND itemID=" . $itemID . "");
                        $name = $getBidderName->fetch_array();
                        if ($getBidderName->num_rows > 0)
                            echo $name["firstName"];
                        else
                            echo "No bidder found";

                        ?>
                    </h1>
                    <h4 class="text-capitalize">total bidder</h4>
                    <h1 id="totalBidder" class="text-muted" style="font-weight: normal;">
                        <?php

                        $getTotalBidder = $conn->query("SELECT COUNT(*) as total_bidder FROM bidding_history WHERE itemID=$itemID");
                        $totalBidder = $getTotalBidder->fetch_array();
                        if ($getTotalBidder->num_rows > 0)
                            echo $totalBidder["total_bidder"];
                        else
                            echo "0";
                        ?>
                    </h1>
                    <br>
                    <hr><br>
                    <ul class="list-unstyled small d-inline-block">
                        <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">Condition:</strong><span class="ml-2 text-muted text-uppercase"><?= $item["item_condition"] ?></span></li>
                        <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">Start Price:</strong><span class="ml-2 text-muted text-uppercase">RM <?= sprintf('%0.2f', $item["item_start_price"]) ?></span></li>
                        <?php
                        $sql = "SELECT * FROM category WHERE categoryID=" . $item["item_category"] . "";
                        $query = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($query);
                        ?>
                        <li class="px-3 py-2 mb-1 bg-white text-muted">
                            <strong class="text-uppercase text-dark">Category:</strong><a class="reset-anchor ml-2" href="items.php?category=<?= $row["categoryID"] ?>"><?= $row["category_name"] ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- DETAILS TABS-->
        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a></li>
            <li class="nav-item"><a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Seller</a></li>
        </ul>
        <div class="tab-content mb-5 border shadow" id="myTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="p-4 p-lg-5 bg-white">
                    <h6 class="text-uppercase">Product description </h6>
                    <p class="text-muted text-small mb-0"><?= $item["item_description"] ?></p>
                </div>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="p-4 p-lg-5 bg-white">

                    <div class="media-body ml-3">
                        <?php
                        $sql = $conn->query("SELECT * FROM item NATURAL JOIN bidding NATURAL JOIN user WHERE userID=" . $item["sellerID"] . "");
                        $seller = $sql->fetch_array();
                        ?>
                        <div class="row">
                            <div class="col-3">
                                <img src="profilePicture/<?= $seller["profile_picture"] ?>" class="sellerImage whiteMargin">
                            </div>
                            <div class="col-9">
                                <h4 class=""><?= $seller["firstName"] . " " . $seller["lastName"] ?></h4>
                                <div class="m-1">
                                    <span id="heart" style="cursor:pointer" onclick="alert('Please log in first'); window.location ='login.php'"><i class="fa fa-heart-o" aria-hidden="true"></i> Follow </span>
                                </div>
                                <a href="#" class="btn btn-primary text-uppercase" onclick="alert('Please log in first'); window.location ='login.php'" disabled>Chat Now</a>
                                <a href="shop.php?id=<?= $seller["userID"] ?>" class="btn btn-primary text-uppercase">View Shop</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="../js/bid.js"></script>
<script>
    $(document).ready(function() {

        $("#favourite").click(function() {
            if ($("#favourite").hasClass("liked")) {
                let itemID = <?= $itemID ?>;
                let buyerID = <?= $_SESSION["user"]["id"] ?>;
                $.ajax({
                    url: "favouriteManager.php",
                    method: "post",
                    data: {
                        unfavourite: true,
                        buyerID: buyerID,
                        itemID: itemID
                    },
                    success: function(response) {
                        $("#favourite").html(
                            '<i class="fa fa-heart-o" aria-hidden="true"> <span style="font-family:Libre Franklin, sans-serif">Add to wish list</span> </i>'
                        );
                        $("#favourite").removeClass("liked");
                    },
                });
            } else {
                let itemID = <?= $itemID ?>;
                let buyerID = <?= $_SESSION["user"]["id"] ?>;
                $.ajax({
                    url: "favouriteManager.php",
                    method: "post",
                    data: {
                        favourite: true,
                        buyerID: buyerID,
                        itemID: itemID
                    },
                    success: function(response) {
                        $("#favourite").html('<i class="fa fa-heart" aria-hidden="true"> <span style="font-family:Libre Franklin, sans-serif;font-weight:normal">Add to wish list</span> </i>');
                        $("#favourite").addClass("liked");
                    },
                });
            }
        });

        $("#heart").click(function() {
            if ($("#heart").hasClass("liked")) {
                let sellerID = <?= $item["sellerID"] ?>;
                let buyerID = <?= $_SESSION["user"]["id"] ?>;
                $.ajax({
                    url: "followManager.php",
                    method: "post",
                    data: {
                        unfollow: true,
                        buyerID: buyerID,
                        sellerID: sellerID
                    },
                    success: function(response) {
                        $("#heart").html(
                            '<i class="fa fa-heart-o" aria-hidden="true"> <span style="font-family:Libre Franklin, sans-serif;font-weight:normal">Follow</span> </i>'
                        );
                        $("#heart").removeClass("liked");
                    },
                });
            } else {
                let sellerID = <?= $item["sellerID"] ?>;
                let buyerID = <?= $_SESSION["user"]["id"] ?>;
                $.ajax({
                    url: "followManager.php",
                    method: "post",
                    data: {
                        follow: true,
                        buyerID: buyerID,
                        sellerID: sellerID
                    },
                    success: function(response) {
                        $("#heart").html('<i class="fa fa-heart" aria-hidden="true">  <span style="font-family:Libre Franklin, sans-serif;font-weight:normal">Follow</span> </i>');
                        $("#heart").addClass("liked");
                    },
                });
            }
        });

    });
</script>

</html>