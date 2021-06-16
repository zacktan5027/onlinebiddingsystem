<?php
/*
    * Success page -  Shortcut and Mark Flow.
    * Buyer can change shipping information for Shortcut flow before execute.
    * Buyer can view order details after execute.
*/
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$rootPath = "../";
include_once('../api/Config/Config.php');
include('../templates/header.php');
require_once('../topUpManager.php');
?>
<!-- HTML Content -->
<div class="row-fluid">
    <div class="col-sm-offset-3 col-md-4">
        <div id="loadingAlert" class="card" style="display: none;">
            <div class="card-body">
                <div class="alert alert-info block" role="alert">
                    Loading....
                </div>
            </div>
        </div>
        <br>
        <div class="container">
            <h1>Your transaction is being processing...Please wait...</h1>
        </div>
        <!-- <form id="orderConfirm" class="form-horizontal" style="display: none;">
            <h3>Your payment is authorized.</h3>
            <h4>Confirm the order to execute</h4>
            <hr>
            <div class="form-group">
                <label class="col-sm-5 control-label">Shipping Information</label>
                <div class="col-sm-7">
                    <p id="confirmRecipient"></p>
                    <p id="confirmAddressLine1"></p>
                    <p id="confirmAddressLine2"></p>
                    <p>
                        <span id="confirmCity"></span>,
                        <span id="confirmState"></span> - <span id="confirmZip"></span>
                    </p>
                    <p id="confirmCountry"></p>
                </div>
            </div>
            <div class="form-group">
                <label for="shippingMethod" class="col-sm-5 control-label">Shipping Type</label>
                <div class="col-sm-7">
                    <select class="form-control" name="shippingMethod" id="shippingMethod">
                        <optgroup label="United Parcel Service" style="font-style:normal;">
                            <option value="8.00">
                                Worldwide Expedited - $8.00</option>
                            <option value="4.00">
                                Worldwide Express Saver - $4.00</option>
                        </optgroup>
                        <optgroup label="Flat Rate" style="font-style:normal;">
                            <option value="2.00" selected>
                                Fixed - $2.00</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-sm-offset-5 col-sm-7">
                    <label class="btn btn-primary" id="confirmButton">Complete Payment</label>
                </div>
            </div>
        </form> -->
        <!-- <form id="orderView" class="form-horizontal" style="display: block;">
            <h3>Your payment is complete</h3>
            <h4>
                <span id="viewFirstName"></span>
                <span id="viewLastName"></span>,
                Thank you for your Order
            </h4>
            <hr>
            <div class="form-group">
                <div class="form-group">
                    <label class="col-sm-5 control-label">Shipping Details</label>
                    <div class="col-sm-7">
                        <p id="viewRecipientName"></p>
                        <p id="viewAddressLine1"></p>
                        <p id="viewAddressLine2"></p>
                        <p>
                            <span id="viewCity"></span>,
                            <span id="viewState"></span> - <span id="viewPostalCode"></span>
                        </p>
                        <p id="confirmCountry"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 control-label">Transaction Details</label>
                    <div class="col-sm-7">
                        <p>Transaction ID: <span id="viewTransactionID"></span></p>
                        <p>Payment Total Amount: <span id="viewFinalAmount"></span> </p>
                        <p>Currency Code: <span id="viewCurrency"></span></p>
                        <p>Payment Status: <span id="viewPaymentState"></span></p>
                        <p id="transactionType">Payment Type: <span id="viewTransactionType"></span> </p>
                    </div>
                </div>
            </div>
            <hr>
            <h3> Click <a href='../index.php'>here </a> to return to Home Page</h3>
        </form> -->
    </div>

</div>

<!-- Javascript Import -->
<script src="<?= $rootPath ?>js/config.js"></script>

<!-- PayPal In-Context Checkout script -->
<script type="text/javascript">
    showDom('loadingAlert');

    document.onreadystatechange = function() {
        if (document.readyState === 'complete') {
            $.ajax({
                type: 'POST',
                url: '<?= $rootPath . URL['services']['orderGet'] ?>',
                success: function(response) {
                    hideDom('loadingAlert');
                    if (response.ack) {
                        showPaymentExecute(response.data);

                    } else {
                        alert('Something went wrong');
                    }
                }
            });
        }
    }

    function showPaymentGet(res) {
        // Listen for click on confirm button
        document.querySelector('#confirmButton').addEventListener('click', function() {
            let shippingMethodSelect = document.getElementById("shippingMethod"),
                updatedShipping = shippingMethodSelect.options[shippingMethodSelect.selectedIndex].value,
                currentShipping = res.purchase_units[0].amount.breakdown.shipping.value;

            let postPatchOrderData = {
                "order_id": res.id,
                "item_amt": res.purchase_units[0].amount.breakdown.item_total.value,
                "tax_amt": res.purchase_units[0].amount.breakdown.tax_total.value,
                "handling_fee": res.purchase_units[0].amount.breakdown.handling.value,
                "insurance_fee": res.purchase_units[0].amount.breakdown.insurance.value,
                "shipping_discount": res.purchase_units[0].amount.breakdown.shipping_discount.value,
                "total_amt": res.purchase_units[0].amount.value,
                "currency": res.purchase_units[0].amount.currency_code,
                "updated_shipping": updatedShipping,
                "current_shipping": currentShipping
            };

            console.log('patch data: ' + JSON.stringify(postPatchOrderData));
            // Execute the payment
            hideDom('confirmButton');
            showDom('loadingAlert');

            console.log('Current shipping ' + currentShipping + ' and updated shipping is ' + updatedShipping);
            console.log('order id: <?= $_SESSION['order_id'] ?>');
            if (currentShipping == updatedShipping) {
                return callPaymentCapture();
            } else {
                $.ajax({
                    type: 'POST',
                    url: '<?= $rootPath . URL['services']['orderPatch'] ?>',
                    data: postPatchOrderData,
                    success: function(response) {
                        console.log('Patch Order Response : ' + JSON.stringify(response));
                        if (response.ack)
                            return callPaymentCapture();
                        else
                            alert("Something went wrong");
                    }
                });
            }
        });
    }

    function callPaymentCapture() {
        $.ajax({
            type: 'POST',
            url: '<?= $rootPath . URL['services']['orderCapture'] ?>',
            success: function(response) {
                hideDom('orderConfirm');
                hideDom('loadingAlert');
                console.log('Capture Response : ' + JSON.stringify(response));
                if (response.ack)
                    showPaymentExecute(response.data);
                else
                    alert("Something went wrong");
            }
        });
    }



    function showPaymentExecute(result) {
        recordIntoDatabase(result.purchase_units[0].amount.value);
    }

    function recordIntoDatabase(res) {
        $.ajax({
            url: "../topUpManager.php",
            method: "POST",
            data: {
                recordData: "true",
                total_amt: res,
            },
            success: function(data) {
                window.location.href = "../../topUp.php";
            },
        });
    }
</script>

<?php
include('../templates/footer.php');
?>