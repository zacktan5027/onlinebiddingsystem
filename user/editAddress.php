<?php

session_start();

require_once "../include/conn.php";

$addressID = $_GET["addressID"];

$sql = $conn->query("SELECT * FROM address WHERE addressID=" . $addressID . "");
$address = $sql->fetch_array();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Edit Address</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <a href="myAddress.php" class="float-left">
            <h1 class="mx-4"><i class="fas fa-arrow-left"></i></h1>
        </a>
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Edit Address</h1>
        <hr>
        <div class="card">
            <div class="card-body">
                <form action="addressManager.php" id="bookingForm" method="post">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" placeholder="Enter Name" name="customerName" value="<?= $address["name"] ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Address1 <small style="color:gray">(1A, Lorong 9)</small> </label>
                                <input type="text" id="address1" class="form-control" placeholder="Enter Address 1" name="address1" value="<?= $address["address1"] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Address2 <small style="color:gray">(Taman Sejati Indah)</small> </label>
                                <input type="text" id="address2" class="form-control" placeholder="Enter Address 2" name="address2" value="<?= $address["address2"] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" id="city" placeholder="City" name="city" value="<?= $address["city"] ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>State</label>
                                <select class="form-control" id="state" name="state" required>
                                    <option value="">Please choose one</option>
                                    <?php

                                    $states = ["Kedah", "Pulau Penang", "Perlis", "Negeri Sembilan", "Malacca", "Selangor", "Perak", "Johor", "Terengganu", "Kelantan", "Pahang", "Sabah", "Sarawak"];
                                    foreach ($states as $key => $state) {
                                    ?>
                                        <option value="<?= $state ?>" <?php if ($state == $address["state"]) echo "selected"; ?>><?= $state ?></option>

                                    <?php
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Post Code <span style="color:red" id="postcode_error_msg"></span></label>
                                <input type="text" id="postcode" class="form-control" name="postcode" value="<?= $address["postcode"] ?>" placeholder="Postcode" style="margin:3px 0 8px 0" pattern=".{5,5}" maxlength="5" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number <span style="color:red" id="phone_error_msg"></span></label>
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="<?= $address["phone_number"] ?>" placeholder="Enter Phone Number" maxlength="11" required>
                            </div>
                        </div>
                        <div class="form-group p-3">
                            <input type="hidden" name="addressID" value="<?= $address["addressID"] ?>">
                            <input type="submit" value="Edit address" name="editAddress" id="editAddress" class="btn btn-primary text-uppercase">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script>
    $("#postcode").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#postcode_error_msg").html("Number only").show().fadeOut("slow");
            return false;
        }
    });


    $("#phoneNumber").keypress(function(e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            $("#phone_error_msg").html("Number only").show().fadeOut("slow");
            return false;
        }
    });

    let phoneNumber = document.querySelector("#phoneNumber");

    phoneNumber.onkeyup = function() {
        let phone_number = phoneNumber.value;
        phone_number = phone_number.replace(/[^0-9]/g, "");
        let block1 = "";
        let block2 = "";
        let block3 = "";
        let formatted = "";

        if (phone_number.length == 11) {
            block1 = phone_number.substring(0, 3);
            block2 = phone_number.substring(3, 7);
            block3 = phone_number.substring(7, 11);

            if (phone_number.length >= 4 && phone_number.length <= 7) {
                formatted = block1 + " " + block2;
                phoneNumber.value = formatted;
            } else if (phone_number.length >= 8 && phone_number.length <= 11) {
                formatted = block1 + " " + block2 + " " + block3;
                phoneNumber.value = formatted;
            } else {
                phoneNumber.value = phone_number;
            }
        } else {
            block1 = phone_number.substring(0, 3);
            block2 = phone_number.substring(3, 6);
            block3 = phone_number.substring(6, 10);

            if (phone_number.length >= 4 && phone_number.length <= 6) {
                formatted = block1 + " " + block2;
                phoneNumber.value = formatted;
            } else if (phone_number.length >= 7 && phone_number.length <= 10) {
                formatted = block1 + " " + block2 + " " + block3;
                phoneNumber.value = formatted;
            } else {
                phoneNumber.value = phone_number;
            }
        }
    };

    let state = document.querySelector("#state");
    state.value = <?= $address["state"] ?>;
</script>

</html>