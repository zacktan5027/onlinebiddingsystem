<?php

session_start();

require_once "../../include/conn.php";

$sellerID = $_SESSION["user"]["id"];

if (isset($_POST["addItem"])) {
    $itemName = $_POST["itemName"];
    $itemDescription = $_POST["itemDescription"];
    $startPrice = $_POST["startPrice"];
    $itemQuantity = $_POST["itemQuantity"];
    $itemCategory = $_POST["itemCategory"];
    $itemCondition = $_POST["itemCondition"];
    $itemWebsite = $_POST["itemWebsite"];
    $itemStartDate = $_POST["itemStartDate"];
    $itemDuration = $_POST["itemDuration"];

    if (isset($_POST["systemPay"])) {
        $systemPay = 1;
    } else {
        $systemPay = 0;
    }

    $itemEndDate = date("Y-m-d", strtotime($itemDuration . " days", strtotime($itemStartDate)));

    $getTotalItems = "SELECT * FROM item";
    $resultGetTotalItems = $conn->query($getTotalItems);
    if ($resultGetTotalItems->num_rows > 0) {
        $resultGetTotalItems = $resultGetTotalItems->num_rows + 1;
    } else {
        $resultGetTotalItems = 1;
    }

    $sql = "INSERT INTO `item`(`sellerID`, `item_name`, `item_description`, `item_start_price`, `item_quantity`, `item_category`, `item_condition`, `item_website`, `item_duration`) VALUES (?,?,?,?,?,?,?,?,?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('issdiissi', $sellerID, $itemName, $itemDescription, $startPrice, $itemQuantity, $itemCategory, $itemCondition, $itemWebsite, $itemDuration);
        $stmt->execute();
        $stmt->close();

        $sql = "INSERT INTO `bidding`(`itemID`, `start_date`, `end_date`,`current_bid`, `system_pay`) VALUES (?,?,?,?,?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('issdi', $resultGetTotalItems, $itemStartDate, $itemEndDate, $startPrice, $systemPay);
            $stmt->execute();
            $stmt->close();
        }

        echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully added');
        						    window.location.href='addItemImage.php?id=" . $resultGetTotalItems . "';
        						    </script>");
    }
}

if (isset($_POST["editItem"])) {
    $itemID = $_POST["itemID"];
    $itemName = $_POST["itemName"];
    $itemDescription = $_POST["itemDescription"];
    $startPrice = $_POST["startPrice"];
    $itemQuantity = $_POST["itemQuantity"];
    $itemCategory = $_POST["itemCategory"];
    $itemCondition = $_POST["itemCondition"];
    $itemWebsite = $_POST["itemWebsite"];
    $itemStartDate = $_POST["itemStartDate"];
    $itemDuration = $_POST["itemDuration"];

    $itemEndDate = date("Y-m-d", strtotime($itemDuration . " days", strtotime($itemStartDate)));

    $checkStartBid = "SELECT * FROM bidding WHERE itemID = '$itemID' AND bidderID=0";
    $resultStartBid = $conn->query($checkStartBid);
    if ($resultStartBid->num_rows > 0) {
        $sql = "UPDATE `item` SET `item_name`=?,`item_description`=?,`item_start_price`=?,`item_quantity`=?,`item_category`=?,`item_condition`=?,`item_website`=?,`item_duration`=? WHERE itemID=?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param('ssdiissii', $itemName, $itemDescription, $startPrice, $itemQuantity, $itemCategory, $itemCondition, $itemWebsite, $itemDuration, $itemID);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE `bidding` SET `start_date`=?,`end_date`=? WHERE itemID=?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('ssi', $itemStartDate, $itemEndDate, $itemID);
                $stmt->execute();
                $stmt->close();
            }

            echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully edited');
        						    window.location.href='manageItems.php';
        						    </script>");
        } else {
        }
    }
}

if (isset($_POST["unlistItem"])) {
    $itemID = $_POST["itemID"];

    $sql = "UPDATE item SET item_status=0 WHERE itemID = $itemID";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        if ($query) {

            $sql = "UPDATE bidding SET bidding_status='suspend' WHERE itemID = $itemID";
            $query = mysqli_query($conn, $sql);

            echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully unlist item');
        						    window.location.href='manageItems.php';
        						    </script>");
        } else {
            $sql = "UPDATE item SET item_status=1 WHERE itemID = $itemID";
            $query = mysqli_query($conn, $sql);

            echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Fail to unlit item');
        						    window.location.href='manageItems.php';
        						    </script>");
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Fail to unlit item');
        						    window.location.href='manageItems.php';
        						    </script>");
    }
}


if (isset($_POST["recoverItem"])) {
    $itemID = $_POST["itemID"];

    $sql = "UPDATE item SET item_status=1 WHERE itemID = $itemID";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $sql = "UPDATE bidding SET bidding_status='pending' WHERE itemID = $itemID";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Successfully recover item');
        						    window.location.href='manageItems.php';
        						    </script>");
        } else {

            $sql = "UPDATE item SET item_status=0 WHERE itemID = $itemID";
            $query = mysqli_query($conn, $sql);

            echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Fail to recover item');
        						    window.location.href='manageItems.php';
        						    </script>");
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
        						    window.alert('Fail to recover item');
        						    window.location.href='manageItems.php';
        						    </script>");
    }
}
