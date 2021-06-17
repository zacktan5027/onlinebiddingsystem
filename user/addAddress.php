<?php

require_once "../include/conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Add Address</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <a href="myAddress.php" class="float-left">
            <h1 class="mx-4"><i class="fas fa-arrow-left"></i></h1>
        </a>
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Add Address</h1>
        <hr>
        <div class="card">
            <div class="card-body">
                <form action="addressManager.php" id="bookingForm" method="post" onsubmit="return checkAddress(this)" class="needs-validation" novalidate>
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
                                <input type="text" id="address1" class="form-control" placeholder="Enter Address 1" name="address1" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Please enter a address. Example: 1A, Lorong 9
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Address2 <small style="color:gray">(Taman Sejati Indah)</small> </label>
                                <input type="text" id="address2" class="form-control" placeholder="Enter Address 2" name="address2" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Please enter a address. Example: Taman Sejati Indah
                                </div>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" id="city" placeholder="City" name="city" maxlength="30" required>
                                <div class="invalid-feedback">
                                    Please enter a city
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>State</label>
                                <select class="form-control" id="state" name="state" required>
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
                                <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter Phone Number" pattern=".{10,13}" maxlength="13" required>
                                <div class="invalid-feedback">
                                    Please enter a phone number
                                </div>
                            </div>
                        </div>
                        <div class="form-group p-3">
                            <input type="submit" value="Add address" name="addAddress" id="addAddress" class="btn btn-primary text-uppercase">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="../js/addAddress.js"></script>
<script src="../js/form-validation.js"></script>

</html>