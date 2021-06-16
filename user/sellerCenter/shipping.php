<?php

session_start();

require_once "../../include/conn.php";

$sql = $conn->query("SELECT * FROM bidding NATURAL JOIN item WHERE sellerID=" . $_SESSION["user"]["id"] . " AND bidding_status='paid' OR bidding_status='shipped out'");
$items = [];
while ($row = $sql->fetch_array()) {
    $items[] = array(
        "biddingID" => $row["biddingID"],
        "itemID" => $row["itemID"],
        "itemName" => $row["item_name"],
        "itemAddress" => $row["address"]
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <link rel="stylesheet" href="../css/styles.css" type="text/css">
    <title>Document</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Shipping</h1>
        <hr>
        <div class="card  rounded shadow">
            <div class="card-header text-uppercase">
                <i class="fas fa-table me-1"></i>
                Shipping List
            </div>
            <div class="card-body">
                <table id="manageShippingTable">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Address</th>
                            <th>Tracking Number</th>
                            <th>Courier Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item) {

                            $sql = $conn->query("SELECT * FROM delivery WHERE biddingID=" . $item["biddingID"] . "");
                            $row = $sql->fetch_array();
                        ?>
                            <tr>
                                <td><?= $item["itemName"] ?></td>
                                <td><?= $item["itemAddress"] ?></td>
                                <td><?php if (!empty($row)) echo $row["tracking_number"]; ?></td>
                                <td><?php if (!empty($row)) echo $row["courier_name"]; ?></td>
                                <td>
                                    <?php if (!empty($row)) { ?>
                                        <button type="button" class="btn btn-primary text-uppercase text-nowrap" style="width:100%" data-toggle="modal" data-target="#editTracking<?= $row["deliveryID"] ?>">Edit Tracking Number</button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="editTracking<?= $row["deliveryID"] ?>" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Tracking Number</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="shippingManager.php" method="post" enctype="multipart/form">
                                                            <div class="form-group">
                                                                <label for="trackingNumber">Tracking Number:</label>
                                                                <input type="hidden" name="biddingID" value="<?= $item["biddingID"] ?>">
                                                                <input type="text" name="trackingNumber" id="trackingNumber" class="form-control" maxlength="15" placeholder="Enter tracking number" value=<?= $row["tracking_number"] ?> required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="courierName">Courier Name</label>
                                                                <select name="courierName" id="courierName" class="form-control" value="<?= $row["courier_name"] ?>" required>
                                                                    <option value="">Please choose one</option>
                                                                    <option value=" AirAsia Courier">AirAsia Courier</option>
                                                                    <option value="AIRPAK Express">AIRPAK Express</option>
                                                                    <option value="Avanti Worldwide Express AWE">Avanti Worldwide Express AWE</option>
                                                                    <option value="Bungkusit (Malaysia Localize)">Bungkusit (Malaysia Localize)</option>
                                                                    <option value="City-Link">City-Link</option>
                                                                    <option value="DHL Worldwide Express">DHL Worldwide Express</option>
                                                                    <option value="DPEX">DPEX</option>
                                                                    <option value="Easy Parcel">Easy Parcel</option>
                                                                    <option value="FedEx">FedEx</option>
                                                                    <option value="GD Express">GD Express</option>
                                                                    <option value="GoGet (Malaysia Localize)">GoGet (Malaysia Localize)</option>
                                                                    <option value="J&T Express">J&T Express</option>
                                                                    <option value="Japan Post">Japan Post</option>
                                                                    <option value="Kangaroo">Kangaroo</option>
                                                                    <option value="KLACH Courier Services (M) Sdn Bhd (Malaysia Localize)">KLACH Courier Services (M) Sdn Bhd (Malaysia Localize)</option>
                                                                    <option value="LalaMove (Malaysia Localize)">LalaMove (Malaysia Localize)</option>
                                                                    <option value="Malaysian Express Worldwide">Malaysian Express Worldwide</option>
                                                                    <option value="MrSpeedy (Malaysia Localize)">MrSpeedy (Malaysia Localize)</option>
                                                                    <option value="Nationwide Express">Nationwide Express</option>
                                                                    <option value="Ninja Van">Ninja Van</option>
                                                                    <option value="Overseas Courier Service OCS">Overseas Courier Service OCS</option>
                                                                    <option value="Pgeon Delivery">Pgeon Delivery</option>
                                                                    <option value="Poslaju Malaysia EMS - National Courier Service">Poslaju Malaysia EMS - National Courier Service</option>
                                                                    <option value="S.O.S. Express - Pengangkutan SOS">S.O.S. Express - Pengangkutan SOS</option>
                                                                    <option value="SF Express">SF Express</option>
                                                                    <option value="Skynet Express">Skynet Express</option>
                                                                    <option value="Skynet Worldwide / Malaysia">Skynet Worldwide / Malaysia</option>
                                                                    <option value="Sure-Reach Worldwide Express - Kurier Surereach">Sure-Reach Worldwide Express - Kurier Surereach</option>
                                                                    <option value="TA Q Bin Express - Yamato Transport">TA Q Bin Express - Yamato Transport</option>
                                                                    <option value="TNT Express Worldwide">TNT Express Worldwide</option>
                                                                    <option value="UPS - United Parcel Service">UPS - United Parcel Service</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="submit" value="Save Now" name="editTracking" class="btn btn-primary text-uppercase">
                                                                <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <button type="button" class="btn btn-primary text-uppercase text-nowrap" style="width:100%" data-toggle="modal" data-target="#addTracking">Add Tracking Number</button>
                                </td>
                                <!-- Modal -->
                                <div class="modal fade" id="addTracking" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Tracking Number</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="shippingManager.php" method="post" enctype="multipart/form">
                                                    <div class="form-group">
                                                        <label for="trackingNumber">Tracking Number:</label>
                                                        <input type="hidden" name="biddingID" value="<?= $item["biddingID"] ?>">
                                                        <input type="text" name="trackingNumber" id="trackingNumber" class="form-control" maxlength="15" placeholder="Enter tracking number" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="courierName">Courier Name</label>
                                                        <select name="courierName" id="courierName" class="form-control" required>
                                                            <option value="">Please choose one</option>
                                                            <option value="AirAsia Courier">AirAsia Courier</option>
                                                            <option value="AIRPAK Express">AIRPAK Express</option>
                                                            <option value="Avanti Worldwide Express AWE">Avanti Worldwide Express AWE</option>
                                                            <option value="Bungkusit (Malaysia Localize)">Bungkusit (Malaysia Localize)</option>
                                                            <option value="City-Link">City-Link</option>
                                                            <option value="DHL Worldwide Express">DHL Worldwide Express</option>
                                                            <option value="DPEX">DPEX</option>
                                                            <option value="Easy Parcel">Easy Parcel</option>
                                                            <option value="FedEx">FedEx</option>
                                                            <option value="GD Express">GD Express</option>
                                                            <option value="GoGet (Malaysia Localize)">GoGet (Malaysia Localize)</option>
                                                            <option value="J&T Express">J&T Express</option>
                                                            <option value="Japan Post">Japan Post</option>
                                                            <option value="Kangaroo">Kangaroo</option>
                                                            <option value="KLACH Courier Services (M) Sdn Bhd (Malaysia Localize)">KLACH Courier Services (M) Sdn Bhd (Malaysia Localize)</option>
                                                            <option value="LalaMove (Malaysia Localize)">LalaMove (Malaysia Localize)</option>
                                                            <option value="Malaysian Express Worldwide">Malaysian Express Worldwide</option>
                                                            <option value="MrSpeedy (Malaysia Localize)">MrSpeedy (Malaysia Localize)</option>
                                                            <option value="Nationwide Express">Nationwide Express</option>
                                                            <option value="Ninja Van">Ninja Van</option>
                                                            <option value="Overseas Courier Service OCS">Overseas Courier Service OCS</option>
                                                            <option value="Pgeon Delivery">Pgeon Delivery</option>
                                                            <option value="Poslaju Malaysia EMS - National Courier Service">Poslaju Malaysia EMS - National Courier Service</option>
                                                            <option value="S.O.S. Express - Pengangkutan SOS">S.O.S. Express - Pengangkutan SOS</option>
                                                            <option value="SF Express">SF Express</option>
                                                            <option value="Skynet Express">Skynet Express</option>
                                                            <option value="Skynet Worldwide / Malaysia">Skynet Worldwide / Malaysia</option>
                                                            <option value="Sure-Reach Worldwide Express - Kurier Surereach">Sure-Reach Worldwide Express - Kurier Surereach</option>
                                                            <option value="TA Q Bin Express - Yamato Transport">TA Q Bin Express - Yamato Transport</option>
                                                            <option value="TNT Express Worldwide">TNT Express Worldwide</option>
                                                            <option value="UPS - United Parcel Service">UPS - United Parcel Service</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" value="Save Now" name="saveTracking" class="btn btn-primary text-uppercase">
                                                        <button type="button" class="btn btn-danger text-uppercase" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include "../footer.php" ?>

</body>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    const manageShippingTable = document.getElementById("manageShippingTable");
    if (manageShippingTable) {
        new simpleDatatables.DataTable(manageShippingTable);
    }

    $('select').each(function() {
        $(this).val($(this).attr('value')).change();
    });
</script>

</html>