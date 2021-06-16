<?php

require_once "include/conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Bidding System</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <!-- HERO SECTION-->
    <div class="container">
        <div id="carouselControl" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active shadow mb-3 bg-body">
                    <section class="hero pb-3 bg-cover bg-center d-flex align-items-center rounded " style="background: url(https://bloggingwizard.com/wp-content/uploads/2020/10/Buy-And-Sell-Websites-Social.png)">
                        <div class=" container py-5">
                            <div class="row px-4 px-lg-5">
                                <div class="col-lg-6 bg-white rounded shadow p-3 mb-5 bg-body rounded">
                                    <p class="text-muted small text-uppercase mb-2">
                                        Shop With Us
                                    </p>
                                    <h1 class="h2 text-uppercase mb-3">You will find all the things you want</h1>
                                    <a class="btn btn-dark" href="items.php">Browse items</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="carousel-item shadow mb-3 bg-body">
                    <section class="hero pb-3 bg-cover bg-center d-flex align-items-center rounded shadow" style="background: url(https://apac.productmanagementfestival.com/wp-content/uploads/2017/01/sell-your-product-online.jpg)">
                        <div class=" container py-5">
                            <div class="row px-4 px-lg-5">
                                <div class="col-lg-6 bg-dark rounded shadow p-3 mb-5 bg-body rounded">
                                    <p class="text-white small text-uppercase mb-2">
                                        Shop Online Make Your Life Easier
                                    </p>
                                    <h1 class="text-white h2 text-uppercase mb-3">Online Payment available!!</h1>
                                    <a class="btn btn-primary" href="items.php">Browse collections</a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="carousel-item shadow mb-3 bg-body">
                    <section class="hero pb-3 bg-cover bg-center d-flex align-items-center rounded shadow" style="background: url(https://www.metacompliance.com/wp-content/uploads/2020/05/New-Zoom-Phishingscam-01-01.png)">
                        <div class=" container py-5">
                            <div class="row px-4 px-lg-5">
                                <div class="col-lg-6 bg-dark rounded shadow p-3 mb-5 bg-body rounded">
                                    <p class="text-white small text-uppercase mb-2">
                                        Beware of Scam
                                    </p>
                                    <h1 class="text-white h2 text-uppercase mb-3">Do not give your account to others</h1>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselControl" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselControl" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <section class="pt-5">
            <header class="text-center">
                <p class="small text-muted small text-uppercase mb-1">
                    Carefully created collections
                </p>
                <h2 class="h5 text-uppercase mb-4">Browse our categories</h2>
            </header>
            <div class="d-flex justify-content-around flex-wrap align-content-around">
                <?php
                $query = "SELECT * FROM `category`";
                $sql = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_array($sql)) {
                ?>
                    <a class="category-item" href="items.php?category=<?= $row["categoryID"] ?>">
                        <img class="img-fluid rounded m-2 shadow bg-body rounded" src="https://image.freepik.com/free-vector/yellow-background-with-dynamic-abstract-shapes_1393-144.jpg" alt="" width="200px" /><strong class="category-item-title"><?= $row["category_name"] ?></strong></a>
                <?php
                }
                ?>
            </div>
        </section>
        <div class="container-content rounded shadow">
            <header>
                <p class="small text-muted small text-uppercase mb-1">
                    Most popular items
                </p>
                <h2 class="h5 text-uppercase mb-4">Top trending items</h2>
            </header>
            <div class="row">
                <?php
                $sql = $conn->query("SELECT *,COUNT(bidding_history.itemID) as popular,item.itemID as item_id FROM bidding NATURAL JOIN item LEFT JOIN bidding_history ON bidding_history.itemID=item.itemID WHERE bidding_status='start' AND item_status=1 GROUP BY item.itemID ORDER BY popular DESC LIMIT 8");
                $items = [];
                while ($row = $sql->fetch_array()) {
                    $items[] = array(
                        "itemID" => $row["item_id"],
                        "sellerID" => $row["sellerID"],
                        "itemName" => $row["item_name"],
                        "itemDescription" => $row["item_description"],
                        "itemStartPrice" => $row["item_start_price"],
                        "itemQuantity" => $row["item_quantity"],
                        "itemCategory" => $row["item_category"],
                        "itemCondition" => $row["item_condition"],
                        "itemWebsite" => $row["item_website"],
                        "currentBid" => $row["current_bid"],
                    );
                }

                foreach ($items as $item) {
                    $itemID = $item['itemID'];
                    $sql = $conn->query("select * from item_picture WHERE itemID=$itemID limit 1");
                    $row = $sql->fetch_array();
                ?>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="product text-center">
                            <div class="position-relative mb-3">
                                <div class="badge text-white badge-"></div>
                                <a class="d-block" href="itemDetail.php?id=<?= $item["itemID"] ?>">
                                    <?php
                                    if (empty($row)) {
                                    ?>
                                        <img class="img-fluid" style="height:200px;width:200px" src="itemPicture/noImage.png" alt="..." />
                                    <?php
                                    } else {
                                    ?>
                                        <img class="img-fluid" style="height:200px;width:200px" src="itemPicture/<?= $row['picture_name'] ?>" alt="..." />

                                    <?php
                                    }
                                    ?>
                                </a>
                                <div class="product-overlay">
                                    <ul class="mb-0 list-inline">
                                        <li class="list-inline-item m-0 p-0">
                                            <a class="btn btn-sm btn-dark" href="itemDetail.php?id=<?= $item["itemID"] ?>">View</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <h6>
                                <a class="reset-anchor" href="itemDetail.php?id=<?= $item["itemID"] ?>"><?= $item['itemName'] ?></a>
                            </h6>
                            <p class="small text-muted">RM
                                <?php
                                if ($item["currentBid"] > 0)
                                    echo sprintf("%0.2f", $item["currentBid"]);
                                else
                                    echo sprintf("%0.2f", $item["itemStartPrice"]);
                                ?>
                            </p>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

</html>