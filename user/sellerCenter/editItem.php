<?php

require_once "../../include/conn.php";

session_start();

$itemID = $_GET["id"];

$sql = $conn->query("SELECT * FROM item NATURAL JOIN bidding WHERE itemID=" . $itemID . "");
$row = $sql->fetch_array();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <title>Edit item</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="card rounded shadow mb-2">
            <div class="card-body">
                <a href="addItemImage.php?id=<?= $itemID ?>"><button class="btn btn-primary float-right text-uppercase">Edit Image</button></a>
                <a href="manageItems.php" class="float-left">
                    <h1 class="mx-4"><i class="fas fa-arrow-left"></i></h1>
                </a>
                <h1 class="headline mb-3 font-weight-bold text-uppercase">Edit Item</h1>
                <hr>
                <p class="text-danger">
                    Field with * is required
                </p>
                <form action="itemManager.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="itemName">Item name<span class="text-danger">*</span>:</label>
                        <input type="text" name="itemName" id="itemName" class="form-control" value="<?= $row["item_name"] ?>" maxlength="30" placeholder="Enter Item Name" required>
                        <div class="invalid-feedback">
                            Please enter an item name
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemDescription">Item description<span class="text-danger">*</span>:</label>
                        <textarea name="itemDescription" class="form-control" rows="5" id="itemDescription" rows="5" placeholder="Enter item Description" required><?= $row["item_description"] ?></textarea>
                        <div class="invalid-feedback">
                            Please enter the description of the item
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startPrice">Start price<span class="text-danger">*</span>:</label>
                        <input type="text" name="startPrice" id="startPrice" class="form-control" maxlength="5" placeholder="Enter Start Price" value="<?= $row["item_start_price"] ?>" required>
                        <div class="invalid-feedback">
                            Please enter a start price for the item
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemQuantity">Item quantity<span class="text-danger">*</span>:</label>
                        <input type="number" name="itemQuantity" id="itemQuantity" class="form-control" maxlength="2" placeholder="Enter Item Quantity" value="<?= $row["item_quantity"] ?>" required>
                        <div class="invalid-feedback">
                            Please enter the quantity of the item
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemCategory">Item category<span class="text-danger">*</span>:</label>
                        <select name="itemCategory" id="itemCategory" class="form-control" required>
                            <option value="">Please choose a category</option>
                            <?php
                            $sql = "SELECT * FROM category";
                            $categories = $conn->query($sql);
                            while ($category = $categories->fetch_array()) {
                            ?>
                                <option value="<?= $category["categoryID"] ?>" <?php if ($category["categoryID"] == $row["item_category"]) echo "selected"; ?>>
                                    <?= $category["category_name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a category
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemCondition">Item condition<span class="text-danger">*</span>:</label>
                        <div class="container mt-0">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="condition1" value="bad" name="radio-stacked" <?php if ($row["item_condition"] == "bad") echo "checked"; ?> required>
                                <label class="form-check-label" for="condition1">Bad</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="condition2" value="normal" name="radio-stacked" <?php if ($row["item_condition"] == "normal") echo "checked"; ?> required>
                                <label class="form-check-label" for="condition2">Normal</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="condition3" value="good" name="radio-stacked" <?php if ($row["item_condition"] == "good") echo "checked"; ?> required>
                                <label class="form-check-label" for="condition3">Good</label>
                            </div>
                            <div class="form-check mb-3">
                                <input type="radio" class="form-check-input" id="condition4" value="new" name="radio-stacked" <?php if ($row["item_condition"] == "new") echo "checked"; ?> required>
                                <label class="form-check-label" for="condition4">New</label>
                                <div class="invalid-feedback">Please select the condition of the item</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemWebsite">Item website:</label>
                        <input type="text" name="itemWebsite" id="itemWebsite" class="form-control" maxlength="30" placeholder="Enter Item Website" value="<?= $row['item_website'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="itemStartDate">Item Start Date<span class="text-danger">*</span>:</label>
                        <input type="date" name="itemStartDate" id="itemStartDate" class="form-control" value="<?= $row["start_date"] ?>" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime(date('Y-m-d') . '+14 days')) ?>" required>
                        <div class="invalid-feedback">
                            Please choose a start date
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemDuration">Item Duration<span class="text-danger">*</span>:</label>
                        <select name="itemDuration" id="itemDuration" class="form-control" required>
                            <option value="">Please choose a duration</option>
                            <?php
                            for ($i = 1; $i < 15; $i++) {
                            ?>
                                <option value="<?= $i ?>" <?php
                                                            if ($i == $row["item_duration"])
                                                                echo "selected";
                                                            ?>><?= $i ?> day</option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a duration
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="itemID" value="<?= $row["itemID"] ?>">
                        <input type="submit" name="editItem" class="btn btn-primary" value="Edit Item">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../footer.php" ?>

</body>

<script src="../../js/form-validation.js"></script>

</html>