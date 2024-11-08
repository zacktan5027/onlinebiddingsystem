<?php

session_start();

require_once "../../include/conn.php";

$userID = $_SESSION["user"]["id"];

$sql = "SELECT * FROM item JOIN bidding ON bidding.itemID=item.itemID WHERE sellerID = $userID";
$items = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <title>Manage Item</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Item List</h1>
        <hr>
        <div class="card rounded shadow">
            <div class="card-header text-uppercase">
                <a href="addItem.php"><button class="btn btn-primary text-uppercase float-right"><i class="fas fa-plus mr-2"></i> Add Item</button></a>
                <i class="fas fa-table me-1"></i>
                Item List
            </div>
            <div class="card-body">
                <table id="manageCategoryTable">
                    <thead>
                        <tr>
                            <th>Item Picture</th>
                            <th>Item Name</th>
                            <th>Item Description</th>
                            <th>Item Start Price</th>
                            <th>Item Quantity</th>
                            <th>Item Category</th>
                            <th>Item Condition</th>
                            <th>Item Start Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($item = mysqli_fetch_array($items)) { ?>
                            <tr>
                                <td>
                                    <?php
                                    $itemID = $item['itemID'];
                                    $sql = "SELECT * FROM item_picture WHERE itemID = $itemID LIMIT 1";
                                    $itemPic = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($itemPic) > 0) {
                                        $itemPicture = mysqli_fetch_array($itemPic);
                                    ?>
                                        <img src="../../itemPicture/<?= $itemPicture["picture_name"] ?>" style="width:100px;height:100px" alt="">
                                    <?php
                                    } else {
                                    ?>
                                        <img src="../../itemPicture/noImage.png" style="width:100px;height:100px" alt="">
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td><?= $item["item_name"] ?></td>
                                <td class='comment more'><?= $item["item_description"] ?></td>
                                <td><?= $item["item_start_price"] ?></td>
                                <td><?= $item["item_quantity"] ?></td>
                                <td><?php
                                    $categoryID =  $item["item_category"];
                                    $sql = "SELECT * FROM category WHERE categoryID = $categoryID";
                                    $category = mysqli_query($conn, $sql);
                                    $categoryName = mysqli_fetch_array($category);
                                    echo $categoryName["category_name"];
                                    ?></td>
                                <td><?= $item["item_condition"] ?></td>
                                <td><?= $item["start_date"] ?></td>
                                <td>
                                    <?php
                                    if ($item["item_status"] == -1) {
                                    ?>
                                        <button class="btn btn-danger text-uppercase">Suspended</button>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="editItem.php?id=<?= $item["itemID"] ?>" <?php if ($item["bidding_status"] != "pending") echo "onclick='return false;' style='cursor:default'"; ?>><button class="btn btn-primary text-uppercase" style="width:100%" <?php if ($item["bidding_status"] != "pending") echo "disabled"; ?>>Edit</button></a>
                                        <?php
                                        if ($item["item_status"] == 1) {
                                        ?>
                                            <form action="itemManager.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure want to unlist this item?')">
                                                <input type="hidden" name="itemID" value="<?= $item["itemID"] ?>">
                                                <input type="submit" value="Unlist" class="btn btn-danger text-uppercase" style="width:100%" name="unlistItem">
                                            </form>
                                        <?php
                                        } else {
                                        ?>
                                            <form action="itemManager.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure want to recover this item?')">
                                                <input type="hidden" name="itemID" value="<?= $item["itemID"] ?>">
                                                <input type="submit" value="recover" class="btn btn-info text-uppercase" style="width:100%" name="recoverItem">
                                            </form>
                                    <?php
                                        }
                                    }
                                    ?>

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "../footer.php" ?>

</body>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    const manageCategoryTable = document.getElementById("manageCategoryTable");
    if (manageCategoryTable) {
        new simpleDatatables.DataTable(manageCategoryTable);
    }
</script>
<script>
    $(document).ready(function() {
        var showChar = 100;
        var ellipsestext = "...";
        var moretext = "more";
        var lesstext = "less";
        $('.more').each(function() {
            var content = $(this).html();

            if (content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar - 1, content.length - showChar);

                var html = c + '<span class="more ellipses">' + ellipsestext + '</span><span class="more content" ><span style="display:none">' + h + ' </span> <a style="padding:2px 2px" href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function() {
            if ($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });
    });
</script>

</html>