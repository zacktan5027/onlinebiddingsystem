<?php

// if(isset($_POST['serverStatus'])){
if (file_exists('stop.txt')) {
    $message = "Server Stop...";
} else if (file_exists('start.txt')) {
    $message = "Server Running...";
}
echo $message;
// }
