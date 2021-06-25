<?php

require_once "../include/conn.php";

$currentDate = date("Y-m-d");

echo $currentDate . "<br>";

$sql = "SELECT * FROM bidding WHERE bidding_status='start'";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_array($query)) {
        if ($currentDate > $row["end_date"])
            echo $row["end_date"] . "<br>";
    }
    // echo $row["end_date"] . "<br>";
}
