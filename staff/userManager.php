<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

if (isset($_POST["suspend"])) {

    $sql = "UPDATE user SET verification_status ='suspend' WHERE userID=" . $_POST["userID"] . "";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $sql = "UPDATE bidding JOIN item ON bidding.itemID=item.itemID JOIN user ON user.userID=item.sellerID SET bidding_status='suspend' WHERE userID=" . $_POST["userID"] . "";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "UPDATE item SET item_status ='-1' WHERE sellerID = " . $_POST["userID"] . "";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        $sql = "DELETE FROM bidding_history WHERE bidderID =" . $_POST["userID"] . "";
        $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if ($query) {
            $sql = "SELECT * FROM bidding WHERE bidderID=" . $_POST["userID"] . " AND bidding_status='start'";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            if (mysqli_num_rows($query) > 0) {
                while ($row = mysqli_fetch_array($query)) {
                    $sql = "SELECT * FROM bidding_history WHERE itemID=" . $row["itemID"] . " ORDER BY bid_price DESC LIMIT 1";
                    $getBidder = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    if (mysqli_num_rows($getBidder) > 0) {
                        $bidder = mysqli_fetch_array($getBidder);

                        $sql = "UPDATE bidding SET bidderID=" . $bidder["bidderID"] . " WHERE itemID=" . $bidder["itemID"] . "";
                        $changeBidder = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    } else {
                        $sql = "UPDATE bidding SET bidderID=NULL WHERE itemID=" . $row["itemID"] . "";
                        $changeBidder = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                    }
                }
            }
            if (isset($_POST["report"])) {
                echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully active the account');
    							    window.location.href='reportDetail.php?id=" . $_POST["reportID"] . "';
    							    </script>");
            } else {
                echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully suspend the account');
    							    window.location.href='userList.php';
    							    </script>");
            }
        } else {
            $sql = "UPDATE user SET verification_status ='active' WHERE userID=" . $_POST["userID"] . "";
            $query = mysqli_query($conn, $sql);

            echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to suspend the account');
    							    window.location.href='userList.php';
    							    </script>");
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to suspend the account');
    							    window.location.href='userList.php';
    							    </script>");
    }
}

if (isset($_POST["active"])) {
    $sql = "UPDATE user SET verification_status ='active' WHERE userID=" . $_POST["userID"] . "";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $sql = "UPDATE bidding JOIN item ON bidding.itemID=item.itemID JOIN user ON user.userID=item.sellerID SET bidding_status='pending' WHERE userID=" . $_POST["userID"] . "";
        $query = mysqli_query($conn, $sql);

        $sql = "UPDATE item SET item_status ='1' WHERE sellerID = " . $_POST["userID"] . "";
        $query = mysqli_query($conn, $sql);

        if ($query) {
            if (isset($_POST["report"])) {
                echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully active the account');
    							    window.location.href='reportDetail.php?id=" . $_POST["reportID"] . "';
    							    </script>");
            } else {
                echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully active the account');
    							    window.location.href='userList.php';
    							    </script>");
            }
        } else {
            $sql = "UPDATE user SET verification_status ='suspend' WHERE userID=" . $_POST["userID"] . "";
            $query = mysqli_query($conn, $sql);
            echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to active the account');
    							    window.location.href='userList.php';
    							    </script>");
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to active the account');
    							    window.location.href='userList.php';
    							    </script>");
    }
}

if (isset($_POST["suspendItem"])) {
    $itemID = $_POST["itemID"];
    $userID = $_POST["userID"];

    $sql = "UPDATE item SET item_status ='-1' WHERE itemID = $itemID";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $sql = "UPDATE bidding SET bidding_status='suspend' WHERE itemID = $itemID";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            if (isset($_POST["report"])) {
                echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully suspend the item');
    							    window.location.href='reportDetail.php?id=" . $_POST["reportID"] . "';
    							    </script>");
            } else {
                echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully suspend the item');
    							    window.location.href='userDetail.php?id=$userID';
    							    </script>");
            }
        } else {
            $sql = "UPDATE item SET item_status ='1' WHERE itemID = $itemID";
            $query = mysqli_query($conn, $sql);
            echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to suspend the item');
    							    window.location.href='userDetail.php?id=$userID';
    							    </script>");
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to suspend the item');
    							    window.location.href='userDetail.php?id=$userID';
    							    </script>");
    }
}

if (isset($_POST["activeItem"])) {
    $itemID = $_POST["itemID"];
    $userID = $_POST["userID"];

    $sql = "SELECT * FROM user WHERE userID = $userID";
    $query = mysqli_query($conn, $sql);
    $status = mysqli_fetch_array($query);
    if ($status["verification_status"] == "suspend") {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('The user is currently suspended');
    							    window.location.href='userDetail.php?id=$userID';
    							    </script>");
        return;
    }


    $sql = "UPDATE item SET item_status ='1' WHERE itemID = $itemID";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $sql = "UPDATE bidding SET bidding_status='pending' WHERE itemID = $itemID";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            if (isset($_POST["report"])) {
                echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully active the item');
    							    window.location.href='reportDetail.php?id=" . $_POST["reportID"] . "';
    							    </script>");
            } else {
                echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Successfully active the item');
    							    window.location.href='userDetail.php?id=$userID';
    							    </script>");
            }
        } else {
            $sql = "UPDATE item SET item_status ='-1' WHERE itemID = $itemID";
            $query = mysqli_query($conn, $sql);
            echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to active the item');
    							    window.location.href='userDetail.php?id=$userID';
    							    </script>");
        }
    } else {
        echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to active the item');
    							    window.location.href='userDetail.php?id=$userID';
    							    </script>");
    }
}

echo ("<script LANGUAGE='JavaScript'>
    							    window.alert('Fail to process you request');
    							    window.location.href='index.php';
    							    </script>");
