<?php

require_once "include/conn.php";

$itemID = $_GET["id"];

$sql = "SELECT * FROM item NATURAL JOIN bidding WHERE itemID=" . $itemID . "";
$query = mysqli_query($conn, $sql);
$number_of_picture = mysqli_num_rows($query);
$item = mysqli_fetch_array($query);
$endDate = $item["end_date"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css" type="text/css">
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
                                            <img src="itemPicture/<?php echo $picture["pictureName"]; ?>" class="img-responsive" width="100%" max-width="500px">
                                        </div>
                                    <?php } else {
                                    ?>
                                        <div class="carousel-item">
                                            <img src="itemPicture/<?= $picture["pictureName"] ?>" class="img-responsive" width="100%" max-width="500px">
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                        <a class="carousel-control-prev" href="#itemPictures" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#itemPictures" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                </div>
                <br>
                <div class="col-lg-6">
                    <h1>
                        <u><?= $item["item_name"] ?></u>
                    </h1>
                    <div><span>Time Left: <span id="countDown"></span></span></div>
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
                        <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">Start Price:</strong><span class="ml-2 text-muted text-uppercase">RM <?= sprintf("%0.2f", $item["item_start_price"]) ?></span></li>
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
        <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item "><a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a></li>
            <li class="nav-item "><a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Seller</a></li>
        </ul>
        <div class=" rounded tab-content mb-5 border shadow" id="myTabContent">
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
                            <div class="col-sm-3 text-center">
                                <img src="profilePicture/<?= $seller["profile_picture"] ?>" class="sellerImage whiteMargin">
                            </div>
                            <div class="col-sm-9 text-center text-sm-left">
                                <h4 class="whiteMargin"><?= $seller["firstName"] . " " . $seller["lastName"] ?></h4>
                                <a href="#" onclick="alert('Please log in first');window.location = 'login.php' " class="btn btn-primary" disabled>Chat Now</a>
                                <a href="shop.php?id=<?= $seller["userID"] ?>" class="btn btn-primary">View Shop</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script>
    let itemID = <?= $_GET["id"] ?>;

    function countdown() {
        const newYearsDate = new Date("<?= $endDate ?>");
        const currentDate = new Date();

        const totalSeconds = (newYearsDate - currentDate) / 1000;
        const minutes = Math.floor(totalSeconds / 60) % 60;
        const hours = Math.floor(totalSeconds / 3600) % 24;
        const days = Math.floor(totalSeconds / 3600 / 24);
        const seconds = Math.floor(totalSeconds) % 60;

        document.querySelector("#countDown").innerHTML = '<span><strong>' + days + '</strong> days</span> <span><strong>' + hours + '</strong> hours</span> <span><strong>' + minutes + '</strong> minutes</span> <span><strong>' + seconds + '</strong> seconds</span>'

    }
    setInterval(countdown, 1000);
</script>
<script src="js/unlogbid.js"></script>

</html>