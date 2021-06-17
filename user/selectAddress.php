<?php

require_once "../include/session.php";
require_once "../include/conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Select Address</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Your detail</h1>
        <hr>
        <div class="container-content rounded shadow">
            <?php

            $sql = $conn->query("SELECT * FROM address WHERE userID = " . $_SESSION["user"]["id"] . "");
            while ($row = $sql->fetch_array()) {
            ?>
                <label class="btn btn-outline-secondary btn-block text-left p-4" onclick="return selectAddress(this)">
                    <strong id="savedCustomerName"><?= $row["name"] ?></strong> - <span id="savedPhoneNumber"><?= $row["phone_number"] ?></span><br>
                    <span id="savedAddress1"><?= $row["address1"] ?></span>, <span id="savedAddress2"><?= $row["address2"] ?></span>
                    <span id="savedCity"><?= $row["city"] ?></span>
                    <span id="savedPostCode"><?= $row["postcode"] ?></span> <span id="savedState"><?= $row["state"] ?></span>
                    <i class="fas fa-angle-right float-right"></i>
                </label>
            <?php } ?>
            <label class="btn btn-outline-secondary btn-block text-left p-4" onclick="clearForm()">
                Add new location
            </label>
            <form action="payment.php" id="addressForm" method="post" onsubmit="return checkAddress(this)" class="needs-validation" novalidate>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter Name" name="customerName" required>
                    <div class="invalid-feedback">
                        Please enter a name
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Address1 <small style="color:gray">(1A, Lorong 9)</small> </label>
                            <input type="text" id="address1" class="form-control" placeholder="Enter Address 1" name="address1" required>
                            <div class="invalid-feedback">
                                Please enter a address. Example: 1A, Lorong 9
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Address2 <small style="color:gray">(Taman Sejati Indah)</small> </label>
                            <input type="text" id="address2" class="form-control" placeholder="Enter Address 2" name="address2" required>
                            <div class="invalid-feedback">
                                Please enter a address. Example: Taman Sejati Indah
                            </div>
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" class="form-control" id="city" placeholder="City" name="city" required>
                            <div class="invalid-feedback">
                                Please enter a city
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>State</label>
                            <select class="form-control" id="state" required>
                                <option value="">Please choose one</option>
                                <option value="Kedah">Kedah</option>
                                <option value="Pulau Penang">Pulau Penang</option>
                                <option value="Perlis">Perlis</option>
                                <option value="Negeri Sembilan">Negeri Sembilan</option>
                                <option value="Malacca">Malacca</option>
                                <option value="Selangor">Selangor</option>
                                <option value="Perak">Perak</option>
                                <option value="Johor">Johor</option>
                                <option value="Terengganu">Terengganu</option>
                                <option value="Kelantan">Kelantan</option>
                                <option value="Pahang">Pahang</option>
                                <option value="Sabah">Sabah</option>
                                <option value="Sarawak">Sarawak</option>
                            </select>
                            <input type="hidden" id="stateValue" name="state">
                            <div class="invalid-feedback">
                                Please select a state
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Post Code <span style="color:red" id="postcode_error_msg"></span></label>
                            <input type="text" id="postcode" class="form-control" name="postcode" placeholder="Postcode" style="margin:3px 0 8px 0" pattern=".{5,5}" maxlength="5" required>
                            <div class="invalid-feedback">
                                Please enter a postcode
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Phone Number <span style="color:red" id="phone_error_msg"></span></label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter Phone Number" maxlength="13" required>
                            <div class="invalid-feedback">
                                Please enter a phone number
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label>Notes</label>
                        <textarea class="form-control" placeholder="Special Requirements" rows="5" name="note"></textarea>
                    </div>
                    <div class="col-lg-12 mt-2">
                        <input type="hidden" name="itemID" value="<?= $_GET['id'] ?>">
                        <input type="hidden" name="customerDecision" id="customerDecision" value="0">
                        <input type="submit" value="Next Step" name="insertAddress" class="btn btn-primary float-right text-uppercase">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="../js/address.js"></script>
<script src="../js/form-validation.js"></script>

</html>