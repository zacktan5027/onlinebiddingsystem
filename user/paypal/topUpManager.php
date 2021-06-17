<?php

require_once "../../../include/conn.php";
require_once "../../../include/session.php";


if (isset($_POST["recordData"])) {
    $userID = $_SESSION["user"]["id"];
    $topUpValue = $_POST["total_amt"];

    // Fetching JSON
    $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
    $response_json = file_get_contents($req_url);

    // Continuing if we got a result
    if (false !== $response_json) {
        // Try/catch for json_decode operation
        try {
            // Decoding
            $response_object = json_decode($response_json);

            // YOUR APPLICATION CODE HERE, e.g.
            $base_price = $topUpValue; // Your price in USD
            $converted_price = round(($base_price * $response_object->rates->MYR));
        } catch (Exception $e) {
            // Handle JSON parse error...
        }
    }

    $sql = "SELECT * FROM user WHERE userID ='$userID'";
    $query = $conn->query($sql);
    $row = $query->fetch_array();
    $old_balance = $row['account_balance'];

    $new_balance = $old_balance + $converted_price;

    $new_balance = sprintf('%0.2f', $new_balance);

    $sql = "UPDATE user SET account_balance=? WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('di', $new_balance, $userID);
    $stmt->execute();
}
