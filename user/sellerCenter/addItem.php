<?php

session_start();

require_once "../../include/conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <title>Add Item</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="card mb-2 rounded shadow">
            <div class="card-body">
                <a href="manageItems.php" class="float-left">
                    <h1 class="mx-4"><i class="fas fa-arrow-left"></i></h1>
                </a>
                <h1 class="headline mb-3 font-weight-bold text-uppercase">Add Item</h1>

                <hr>
                <form action="itemManager.php" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="itemName">Item name:</label>
                        <input type="text" name="itemName" id="itemName" class="form-control" required>
                        <div class="invalid-feedback">
                            Please enter an item name
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemDescription">Item description:</label>
                        <textarea name="itemDescription" id="itemDescription" class="form-control" required></textarea>
                        <div class="invalid-feedback">
                            Please enter the description of the item
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startPrice">Start price:</label>
                        <input type="text" name="startPrice" id="startPrice" class="form-control" required>
                        <div class="invalid-feedback">
                            Please enter a start price for the item
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="systemPay" id="systemPay">
                        <label for="systemPay"> Can use System Pay</label>
                    </div>
                    <div class="form-group">
                        <label for="itemQuantity">Item quantity:</label>
                        <input type="number" name="itemQuantity" id="itemQuantity" class="form-control" required>
                        <div class="invalid-feedback">
                            Please enter the quantity of the item
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemCategory">Item category:</label>
                        <select name="itemCategory" id="itemCategory" class="form-control" required>
                            <option value="">Please choose a category</option>
                            <?php
                            $sql = "SELECT * FROM category";
                            $categories = $conn->query($sql);
                            while ($category = $categories->fetch_array()) {
                            ?>
                                <option value="<?= $category["categoryID"] ?>">
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
                        <label for="itemCondition">Item condition:</label>
                        <div class="container mt-0">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="condition1" value="bad" name="itemCondition" required>
                                <label class="form-check-label" for="condition1">Bad</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="condition2" value="normal" name="itemCondition" required>
                                <label class="form-check-label" for="condition2">Normal</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" id="condition3" value="good" name="itemCondition" required>
                                <label class="form-check-label" for="condition3">Good</label>
                            </div>
                            <div class="form-check mb-3">
                                <input type="radio" class="form-check-input" id="condition4" value="new" name="itemCondition" required>
                                <label class="form-check-label" for="condition4">New</label>
                            </div>
                            <div class="invalid-feedback">Please select the condition of the item</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemWebsite">Item website:</label>
                        <input type="text" name="itemWebsite" id="itemWebsite" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="itemStartDate">Item Start Date:</label>
                        <input type="date" name="itemStartDate" id="itemStartDate" class="form-control" min="<?= date('Y-m-d') ?>" max="<?= date('Y-m-d', strtotime(date('Y-m-d') . '+14 days')) ?>" required>
                        <div class="invalid-feedback">
                            Please choose a start date
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="itemDuration">Item Duration:</label>
                        <select name="itemDuration" id="itemDuration" class="form-control" required>
                            <option value="">Please choose a duration</option>
                            <option value="1">1 day</option>
                            <option value="2">2 days</option>
                            <option value="3">3 days</option>
                            <option value="4">4 days</option>
                            <option value="5">5 days</option>
                            <option value="6">6 days</option>
                            <option value="7">7 days</option>
                            <option value="8">8 days</option>
                            <option value="9">9 days</option>
                            <option value="10">10 days</option>
                            <option value="11">11 days</option>
                            <option value="12">12 days</option>
                            <option value="13">13 days</option>
                            <option value="14">14 days</option>
                        </select>
                        <div class="invalid-feedback">
                            Please choose a duration
                        </div>
                    </div>
                    <div>
                        <input type="submit" name="addItem" class="btn btn-primary text-uppercase" value="Add Item">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "../footer.php" ?>


</body>

<script src="../../js/form-validation.js"></script>

</html>