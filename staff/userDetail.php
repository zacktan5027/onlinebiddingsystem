<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$userID = $_GET["id"];

$items = [];
$query = "SELECT * FROM `user` JOIN `item` ON user.userID=item.sellerID WHERE userID='$userID'";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    $items[] = array(
        "itemID" => $row["itemID"],
        "itemName" => $row["item_name"],
        "itemDescription" => $row["item_description"],
        "itemStartPrice" => $row["item_start_price"],
        "itemQuantity" => $row["item_quantity"],
        "itemCategory" => $row["item_category"],
        "itemWebsite" => $row["item_website"],
        "itemStatus" => $row["item_status"],
    );
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/sidebar.css" rel="stylesheet" />

    <title>Home</title>
</head>

<body class="sb-sidenav-toggled">

    <div class="d-flex" id="wrapper">
        <?php include 'sidebar.php'; ?>
        <?php include 'header.php'; ?>

        <div id="page-content-wrapper">
            <?php include 'topNavigation.php'; ?>
            <div class="container">
                <a href="userlist.php" class="float-left">
                    <h1 class="mx-4"><i class="fas fa-arrow-left"></i></h1>
                </a>
                <h1 class="headline m-3 font-weight-bold text-uppercase">Item List</h1>
                <hr>
                <div class="d-flex flex-wrap justify-content">
                    <?php
                    if (!empty($items)) {
                        foreach ($items as $item) {
                    ?>
                            <div class="flex-fill">
                                <div class="card mb-3 rounded shadow">
                                    <div class="row no-gutters">
                                        <div class="col-sm-3">
                                            <?php
                                            $query = "SELECT * FROM item_picture WHERE itemID = " . $item['itemID'] . " LIMIT 1";
                                            $sql = mysqli_query($conn, $query);
                                            $row = mysqli_fetch_array($sql);
                                            if (empty($row)) {
                                            ?>
                                                <img class="card-img" height="300" width="300" src="../itemPicture/noImage.png">
                                            <?php
                                            } else {
                                            ?>
                                                <img class="card-img" height="300" width="300" src="../itemPicture/<?= $row["picture_name"] ?>">
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $item["itemName"] ?></h5>
                                                <p class="card-text"><?= $item["itemDescription"] ?></p>
                                                <p class="card-text">RM <?= $item["itemStartPrice"] ?>
                                                </p>
                                                <?php
                                                if ($item["itemStatus"] >= 0) {
                                                ?>
                                                    <form action="userManager.php" method="post">
                                                        <input type="hidden" name="itemID" value="<?= $item['itemID'] ?>">
                                                        <input type="hidden" name="userID" value="<?= $userID ?>">
                                                        <input type="submit" class="btn btn-danger text-uppercase" value="Suspend Item" name="suspendItem">
                                                    </form>
                                                <?php
                                                } else {
                                                ?>
                                                    <form action="userManager.php" method="post">
                                                        <input type="hidden" name="itemID" value="<?= $item['itemID'] ?>">
                                                        <input type="hidden" name="userID" value="<?= $userID ?>">
                                                        <input type="submit" class="btn btn-primary text-uppercase" value="Active Item" name="activeItem">
                                                    </form>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <p>This use did not put anything to sell</p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        const sidebarToggle = document.body.querySelector("#sidebarToggle");
        if (sidebarToggle) {
            sidebarToggle.addEventListener("click", (event) => {
                event.preventDefault();
                document.body.classList.toggle("sb-sidenav-toggled");
                localStorage.setItem(
                    "sb|sidebar-toggle",
                    document.body.classList.contains("sb-sidenav-toggled")
                );
            });
        }
    });
</script>

</html>