<?php

$conn = new mysqli('localhost', 'root', '', 'onlinebiddingsystem');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
