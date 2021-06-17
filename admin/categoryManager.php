<?php

require_once "../include/session.php";
require_once "../include/conn.php";

if (isset($_POST["addCategory"])) {

    $categoryName = $_POST["categoryName"];

    $query = "INSERT INTO `category`(`category_name`) VALUES ('$categoryName')";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully add a new category.');
    							    window.location.href='manageCategory.php';
    							    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('System ecounter error, failed to add a new category.');
    							    window.location.href='manageCategory.php';
    							    </script>");
    }
}

if (isset($_POST["editCategory"])) {

    $categoryID = $_POST["categoryID"];
    $categoryName = $_POST["categoryName"];

    $query = "UPDATE `category` SET `category_name`='$categoryName' WHERE categoryID='$categoryID'";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully edit the category.');
    							    window.location.href='manageCategory.php';
    							    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('System ecounter error, failed to edit the category.');
    							    window.location.href='manageCategory.php';
    							    </script>");
    }
}
if (isset($_POST["unlistCategory"])) {

    $unlisted = 1;
    $categoryID = $_POST["categoryID"];

    $query = "UPDATE `category` SET `unlisted`='$unlisted' WHERE categoryID='$categoryID'";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully unlist the category.');
    							    window.location.href='manageCategory.php';
    							    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('System ecounter error, failed to unlist the category.');
    							    window.location.href='manageCategory.php';
    							    </script>");
    }
}
if (isset($_POST["activeCategory"])) {
    $unlisted = 0;
    $categoryID = $_POST["categoryID"];

    $query = "UPDATE `category` SET `unlisted`='$unlisted' WHERE categoryID='$categoryID'";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully active the category.');
    							    window.location.href='manageCategory.php';
    							    </script>");
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('System ecounter error, failed to active the category.');
    							    window.location.href='manageCategory.php';
    							    </script>");
    }
}
