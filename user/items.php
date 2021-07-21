<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$userID = $_SESSION["user"]["id"];

$condition = "";
if (isset($_GET['condition'])) {
    if ($_GET['condition'] == "popularity")
        $condition = "ORDER BY popular DESC";
    else if ($_GET['condition'] == "low")
        $condition = "ORDER BY current_bid";
    else if ($_GET['condition'] == "high")
        $condition = "ORDER BY current_bid DESC";
    else
        $condition = "";
}

if (isset($_GET["category"])) {
    $category = " AND item_category=" . $_GET["category"] . "";
} else {
    $category = "";
}

if (isset($_POST["searchItem"])) {
    $search = " AND item_name LIKE '%" . $_POST["searchItem"] . "%'";
} else {
    $search = "";
}

//define total number of results you want per page  
$results_per_page = 18;

//find the total number of results stored in the database  
if (isset($_GET["category"])) {
    $query = "SELECT *,COUNT(bidding_history.itemID) as popular,item.itemID as item_id FROM bidding NATURAL JOIN item LEFT JOIN bidding_history ON bidding_history.itemID=item.itemID WHERE sellerID!=$userID AND bidding_status='start'AND item_status=1 $category $search GROUP BY item.itemID $condition";
} else {
    $query = "SELECT *,COUNT(bidding_history.itemID) as popular,item.itemID as item_id FROM bidding NATURAL JOIN item LEFT JOIN bidding_history ON bidding_history.itemID=item.itemID WHERE sellerID!=$userID AND bidding_status='start'AND item_status=1 $search GROUP BY item.itemID $condition";
}
$result = mysqli_query($conn, $query);
$number_of_result = mysqli_num_rows($result);

//determine the total number of pages available  
$number_of_page = ceil($number_of_result / $results_per_page);

//determine which page number visitor is currently on  
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

//determine the sql LIMIT starting number for the results on the displaying page  
$page_first_result = ($page - 1) * $results_per_page;

//retrieve the selected results from database   
if (isset($_GET["category"])) {
    $query = "SELECT *,COUNT(bidding_history.itemID) as popular,item.itemID as item_id FROM bidding NATURAL JOIN item LEFT JOIN bidding_history ON bidding_history.itemID=item.itemID WHERE sellerID!=$userID AND bidding_status='start' AND item_status=1 $category $search GROUP BY item.itemID $condition LIMIT " . $page_first_result . ',' . $results_per_page;
} else {
    $query = "SELECT *,COUNT(bidding_history.itemID) as popular,item.itemID as item_id FROM bidding NATURAL JOIN item LEFT JOIN bidding_history ON bidding_history.itemID=item.itemID WHERE sellerID!=$userID AND bidding_status='start'AND item_status=1 $search GROUP BY item.itemID $condition LIMIT " . $page_first_result . ',' . $results_per_page;
}
$result = mysqli_query($conn, $query);

$items = [];
while ($row = mysqli_fetch_array($result)) {
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

if ($number_of_result == 0) {
    $startResult = 0;
    if ($number_of_result > $results_per_page)
        $endResult = $results_per_page;
    else
        $endResult = $number_of_result;
} else {
    if ($page == 1) {
        $startResult = 1;
        if ($number_of_result > $results_per_page)
            $endResult = $results_per_page;
        else
            $endResult = $number_of_result;
    } else {
        $startResult = $page_first_result * ($page - 1) + 1;
        $endResult = $page_first_result + $results_per_page;
        if ($endResult > $number_of_result)
            $endResult = $number_of_result;
    }
}

$previous = $page;
$next = $page;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>All items</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <section class="py-5 bg-warning rounded shadow">
            <div class="container">
                <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
                    <div class="col-lg-8">
                        <h1 class="h2 text-uppercase mb-0">Item List
                            <?php
                            if (isset($_GET["category"])) {
                                $sql = "SELECT * FROM `category` WHERE categoryID = " . $_GET["category"] . "";
                                $query = mysqli_query($conn, $sql);
                                $row = mysqli_fetch_array($query);
                                echo "- " . $row["category_name"];
                            }
                            ?>
                        </h1>
                    </div>
                    <div class="col-lg-4 text-lg-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-warning justify-content-lg-end mb-0 px-0">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item" style="color: #8a7a00;" aria-current="page">All items</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <?php
        if (isset($_POST["searchItem"])) {
            $searchItem = $_POST["searchItem"];
            $id = $_SESSION["user"]["id"];
            $sql = "SELECT * FROM `user` WHERE (firstName = '$searchItem' OR lastName = '$searchItem') AND userID!=$id AND account_type='user'";
            $query = mysqli_query($conn, $sql);

            if (mysqli_num_rows($query) > 0) {
                $seller = mysqli_fetch_array($query);
        ?>
                <section class="mt-4">
                    <div class="card shadow rounded">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <img src="../profilePicture/<?= $seller["profile_picture"] ?>" class="sellerImage whiteMargin">
                                </div>
                                <div class="col-9">
                                    <h4 class="whiteMargin"><?= $seller["firstName"] . " " . $seller["lastName"] ?></h4>
                                    <a href="chat.php?sellerID=<?= $seller["userID"] ?>" class="btn btn-primary text-uppercase">Chat Now</a>
                                    <a href="shop.php?id=<?= $seller["userID"] ?>" class="btn btn-primary text-uppercase">View Shop</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
        <?php
            }
        }
        ?>

        <section>
            <div class="container p-0">
                <div class="container-content rounded shadow">
                    <?php

                    if (isset($_POST["searchItem"])) {
                        echo "<h2>Showing result for \"" . $_POST["searchItem"] . "\" </h2><hr>";
                    }

                    ?>
                    <div class="row">
                        <!-- SHOP SIDEBAR-->
                        <div class="col-lg-3 order-2 order-lg-1">
                            <h5 class="text-uppercase mb-4">Categories</h5>
                            <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                                <li class="dropdown-item text-uppercase"><a class="reset-anchor" href="items.php">All items</a></li>
                                <?php

                                $sql = "SELECT * FROM `category`";
                                $query = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <a class="reset-anchor" href="items.php?category=<?= $row["categoryID"] ?>">
                                        <li class="dropdown-item text-uppercase"><?= $row["category_name"] ?>
                                        </li>
                                    </a>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <!-- SHOP LISTING-->
                        <div class=" col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
                            <div class="row mb-3 align-items-center">
                                <div class="col-lg-6 mb-2 mb-lg-0">
                                    <p class="text-small text-muted mb-0">Showing <?= $startResult ?> – <?= $endResult ?> of <?= $number_of_result ?> results</p>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
                                        <li class="list-inline-item">
                                            <select id="conList" class="form-control" name="sorting" data-width="200" data-style="bs-select-form-control" data-title="Default sorting">
                                                <?php
                                                $select1 = "";
                                                $select2 = "";
                                                $select3 = "";
                                                $select4 = "";
                                                if (isset($_GET['condition'])) {
                                                    if ($_GET['condition'] == "popularity")
                                                        $select1 = "selected";
                                                    else if ($_GET['condition'] == "low")
                                                        $select2 = "selected";
                                                    else if ($_GET['condition'] == "high")
                                                        $select3 = "selected";
                                                    else
                                                        $select4 = "selected";
                                                }
                                                ?>
                                                <option value="default" <?= $select4 ?>>Default sorting</option>
                                                <option value="popularity" <?= $select1 ?>>Popularity</option>
                                                <option value="low" <?= $select2 ?>>Price: Low to High</option>
                                                <option value="high" <?= $select3 ?>>Price: High to Low</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <?php
                                if (count($items) != 0) {
                                    foreach ($items as $item) {

                                        $itemID = $item['itemID'];
                                        $sql = $conn->query("select * from item_picture WHERE itemID=$itemID limit 1");
                                        $row = $sql->fetch_array();

                                ?>
                                        <div class="col-lg-4 col-sm-6">
                                            <div class="product text-center">
                                                <div class="mb-3 position-relative">
                                                    <a class="d-block" href="itemDetail.php?id=<?= $item["itemID"] ?>">
                                                        <?php
                                                        if (empty($row)) {
                                                        ?>
                                                            <img class="img-fluid" style="height:200px;width:200px" src="../itemPicture/noImage.png" alt="..." />
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <img class="img-fluid" style="height:200px;width:200px" src="../itemPicture/<?= $row['picture_name'] ?>" alt="..." />

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
                                                    <?php
                                                    $sql = $conn->query("SELECT COUNT(historyID) as total_bidder FROM bidding_history WHERE itemID={$item["itemID"]}");
                                                    $total_bidder = $sql->fetch_array();
                                                    ?>
                                                    <a class="reset-anchor" href="itemDetail.php?id=<?= $item["itemID"] ?>"><?= $item['itemName'] ?><br> <i class="fas fa-user-tag"></i> <?= $total_bidder["total_bidder"] ?></a>
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
                                } else {
                                    ?>
                                    <div class="col-lg-4 col-sm-6">
                                        <p>0 result</p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <!-- PAGINATION-->
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center justify-content-lg-end">
                                    <?php
                                    if (isset($_GET["category"])) {
                                        if ($page == 1) {
                                    ?>
                                            <li class="page-item disabled"><a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a></li>

                                        <?php
                                        } else {
                                        ?>
                                            <li class="page-item"><a class="page-link" href="items.php?category=<?= $_GET["category"] ?>&page=<?= $previous - 1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                        <?php
                                        }
                                    } else {
                                        if ($page == 1) {
                                        ?>
                                            <li class="page-item disabled"><a class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a></li>

                                        <?php
                                        } else {
                                        ?>
                                            <li class="page-item"><a class="page-link" href="items.php?page=<?= $previous - 1 ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                            <?php
                                        }
                                    }

                                    //display the link of the pages in URL  
                                    for ($page = 1; $page <= $number_of_page; $page++) {
                                        if (isset($_GET['page'])) {
                                            if ($_GET['page'] == $page) {
                                            ?>
                                                <li class="page-item active"><a class="page-link" href="items.php?page=<?= $page ?>"><?= $page ?></a></li>
                                            <?php
                                            } else {
                                            ?>
                                                <li class="page-item"><a class="page-link" href="items.php?page=<?= $page ?>"><?= $page ?></a></li>

                                            <?php
                                            }
                                        } else {
                                            if ($page == 1) {
                                            ?>
                                                <li class="page-item active"><a class="page-link" href="items.php?page=<?= $page ?>"><?= $page ?></a></li>

                                            <?php
                                            } else {
                                            ?>
                                                <li class="page-item"><a class="page-link" href="items.php?page=<?= $page ?>"><?= $page ?></a></li>

                                            <?php
                                            }
                                        }
                                    }
                                    if (isset($_GET["category"])) {
                                        if ($number_of_page == 0 || $number_of_page == $next) {
                                            ?>
                                            <li class="page-item disabled"><a class="page-link" aria-label="Next"><span aria-hidden="true">»</span></a></li>

                                        <?php
                                        } else {
                                        ?>

                                            <li class="page-item"><a class="page-link" href="items.php?category=<?= $_GET["category"] ?>&page=<?= $next + 1 ?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                        <?php
                                        }
                                    } else {
                                        if ($number_of_page == 0 || $number_of_page == 1) {
                                        ?>
                                            <li class="page-item disabled"><a class="page-link" aria-label="Next"><span aria-hidden="true">»</span></a></li>

                                        <?php
                                        } else {
                                        ?>
                                            <li class="page-item"><a class="page-link" href="items.php?page=<?= $next + 1 ?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include "footer.php" ?>

</body>

<script>
    $("#conList").on('change', function() {

        if ($(this).val() == 0) {
            window.location = 'manageStaff.php';
        } else {
            localStorage.setItem('con', $(this).val());
            window.location = '?<?php
                                if (isset($_GET["category"])) {
                                    echo "category=" . $_GET["category"];
                                }
                                ?>&condition=' + $(this).val();
        }

    });
</script>

</html>