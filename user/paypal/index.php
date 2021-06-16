<?php
/*
    * Cart page - Shortcut Flow.
*/
session_start();

require_once "../../include/conn.php";

$rootPath = "";
include_once('api/Config/Config.php');
// include('templates/header.php');

$baseUrl = str_replace("index.php", "", URL['current']);

// Fetching JSON
$req_url = 'https://api.exchangerate-api.com/v4/latest/MYR';
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if (false !== $response_json) {

    // Try/catch for json_decode operation
    try {

        // Decoding
        $response_object = json_decode($response_json);

        // YOUR APPLICATION CODE HERE, e.g.
        $base_price = $_POST["topUpValue"]; // Your price in USD
        $converted_price = round(($base_price * $response_object->rates->USD), 2);
    } catch (Exception $e) {
        // Handle JSON parse error...
    }
}

define("topUpValue", $converted_price);

const SampleCart = array(
    "item_amt" => topUpValue,
    "tax_amt" => 0,
    "insurance_fee" => 0,
    "handling_fee" => 0,
    "shipping_amt" => 0,
    "shipping_discount" => 0,
    "total_amt" => topUpValue,
    "currency" => "USD",
    "shipping_info" => array(
        "recipient_name" => "John Doe",
        "line1" => "55 East 52nd Street",
        "line2" => "21st Floor",
        "city" => "New York",
        "state" => "NY",
        "postal_code" => "10022"
    )
);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Document</title>
</head>

<body>
    <?php include "header.php"; ?>
    <div style="height:100%">
        <div class="container">
            <div class="card mt-5 rounded shadow">
                <h3 class="text-center">Pricing Details</h3>
                <hr>
                <form>
                    <!-- Cart Details -->
                    <div class="form-group text-center">
                        <h1 for="total_amt" class="">Total Amount</h1>
                        <h3>RM <?= $base_price ?></h3>
                        <input class="form-control" type="hidden" id="total_amt" name="total_amt" value="<?= SampleCart['total_amt'] ?>" readonly>
                        <input class="form-control" type="hidden" id="camera_amount" name="camera_amount" value="<?= SampleCart['item_amt'] ?>" readonly>
                        <input class="form-control" type="hidden" id="tax_amt" name="tax_amt" value="<?= SampleCart['tax_amt'] ?>" readonly>
                        <input class="form-control" type="hidden" id="insurance_fee" name="insurance_fee" value="<?= SampleCart['insurance_fee'] ?>" readonly>
                        <input class="form-control" type="hidden" id="handling_fee" name="handling_fee" value="<?= SampleCart['handling_fee'] ?>" readonly>
                        <input class="form-control" type="hidden" id="shipping_amt" name="shipping_amt" value="<?= SampleCart['shipping_amt'] ?>" readonly>
                        <input class="form-control" type="hidden" id="shipping_discount" name="shipping_discount" value="<?= SampleCart['shipping_discount'] ?>" readonly>
                        <input class="form-control" type="hidden" id="currency_Code" name="currency_Code" value="<?= SampleCart['currency'] ?>" readonly>
                    </div>
                    <hr>
                    <!-- Checkout Options -->
                    <div class="form-group">
                        <!-- Container for PayPal Shortcut Checkout -->
                        <div id="paypalCheckoutContainer" class="container" style="width:50%"></div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</body>

<script src="https://www.paypal.com/sdk/js?client-id=sb&intent=capture&vault=false&commit=true<?php echo isset($_GET['buyer-country']) ? "&buyer-country=" . $_GET['buyer-country'] : "" ?>"></script>
<script src="<?= $rootPath ?>js/config.js"></script>

<script type="text/javascript">
    paypal.Buttons({

        env: '<?= PAYPAL_ENVIRONMENT ?>',

        style: {
            layout: 'vertical', // horizontal | vertical
            size: 'responsive', // medium | large | responsive
            shape: 'pill', // pill | rect
            color: 'gold', // gold | blue | silver | black,
            fundingicons: false, // true | false,
            tagline: false // true | false,
        },

        createOrder: function() {
            let formData = new FormData();
            formData.append('item_amt', document.getElementById("camera_amount").value);
            formData.append('tax_amt', document.getElementById("tax_amt").value);
            formData.append('handling_fee', document.getElementById("handling_fee").value);
            formData.append('insurance_fee', document.getElementById("insurance_fee").value);
            formData.append('shipping_amt', document.getElementById("shipping_amt").value);
            formData.append('shipping_discount', document.getElementById("shipping_discount").value);
            formData.append('total_amt', document.getElementById("total_amt").value);
            formData.append('currency', document.getElementById("currency_Code").value);
            formData.append('return_url', '<?= $baseUrl . URL["redirectUrls"]["returnUrl"] ?>' + '?commit=true');
            formData.append('cancel_url', '<?= $baseUrl . URL["redirectUrls"]["cancelUrl"] ?>');

            return fetch(
                '<?= $rootPath . URL['services']['orderCreate'] ?>', {
                    method: 'POST',
                    body: formData
                }
            ).then(function(response) {
                return response.json();
            }).then(function(resJson) {
                console.log('Order ID: ' + resJson.data.id);
                return resJson.data.id;
            });
        },

        // Wait for the payment to be authorized by the customer
        onApprove: function(data, actions) {
            return fetch(
                '<?= $rootPath . URL['services']['orderGet'] ?>', {
                    method: 'GET'
                }
            ).then(function(res) {
                return res.json();
            }).then(function(res) {
                window.location.href = 'pages/success.php';
            });
        }

    }).render('#paypalCheckoutContainer');
</script>

</html>