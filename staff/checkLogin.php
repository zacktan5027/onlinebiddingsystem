<?php

require_once "../include/session.php";

if (!isset($_SESSION["staff"])) {
    echo "<script language='javascript'>
    alert('Please log in first.');
    window.location = 'logout.php';
    </script>";
}
