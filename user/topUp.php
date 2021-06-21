<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$sql = "SELECT * FROM user WHERE userID =" . $_SESSION["user"]["id"] . "";
$query = $conn->query($sql);
$row = $query->fetch_array();
$account_balance = $row['account_balance'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Top up</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <section class="section">
        <div class="container">
            <h1 class="headline mb-3 font-weight-bold text-uppercase">Top up e-wallet</h1>
            <hr>
            <div class="card rounded shadow">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row" id="amount">
                            <div class="col-md-10 col-lg-4">
                                <div style="text-align: center;">
                                    <button class="btn btn-primary" value="5" style="width: 250px; margin:10px 0px;font-size:25px">5</button>
                                </div>
                                <div style="text-align: center;">
                                    <button class="btn btn-primary" value="50" style="width: 250px; margin:10px 0px;font-size:25px">50</button>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-4">
                                <div style="text-align: center;">
                                    <button class="btn btn-primary" value="10" style="width: 250px; margin:10px 0px;font-size:25px">10</button>
                                </div>
                                <div style="text-align: center;">
                                    <button class="btn btn-primary" value="100" style="width: 250px; margin:10px 0px;font-size:25px">100</button>
                                </div>
                            </div>
                            <div class="col-md-10 col-lg-4">
                                <div style="text-align: center;">
                                    <button class="btn btn-primary" value="20" style="width: 250px; margin:10px 0px;font-size:25px">20</button>
                                </div>
                                <div style="text-align: center;">
                                    <button class="btn btn-primary" value="500" style="width: 250px; margin:10px 0px;font-size:25px">500</button>
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <center>
                            <h3>Your balance : RM <?= sprintf("%0.2f", $account_balance) ?></h3>
                        </center>
                        <form action="paypal/index.php" method="POST">
                            <div style="text-align: center;">
                                <div class="row">
                                    <div class="col-md-10 col-lg-3" style="text-align:right">
                                        <h1>RM:</h1>
                                    </div>
                                    <div class="col-md-10 col-lg-9">
                                        <input style="width:70%;text-align:center;font-size:30px" class="form-control" id="topupValue" maxlength="4" type="text" name="topUpValue" required>
                                    </div>
                                </div>
                                <input class="btn btn-primary text-uppercase m-3" type="submit" name="topUp" value="Pay now">
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include "footer.php" ?>

</body>

<script>
    $(document).ready(function() {

        $('#amount button').click(function() {
            var amount = $(this).val();
            $("#topupValue").val(amount)
        });

        $("#topupValue").keypress(function(e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

    });
</script>

</html>