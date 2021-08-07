<?php

//upload.php

session_start();

require_once "../../include/conn.php";

$folder_name = '../../itemPicture/';


if (!empty($_FILES)) {
    $itemID = $_GET['id'];
    $temp_file = $_FILES['file']['tmp_name'];

    $unique_id = rand(time(), 100000000);
    $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $new_img_name = $itemID . "_" . $unique_id . "." . $extension;

    $sql = mysqli_query($conn, "INSERT INTO `item_picture`(`itemID`, `picture_name`) VALUES (" . $itemID . ",'" . $new_img_name . "')") or die();

    move_uploaded_file($temp_file, $folder_name . $new_img_name);
}

if (isset($_POST["name"])) {
    $filename = $folder_name . $_POST["name"];

    $sql = mysqli_query($conn, "DELETE FROM `item_picture` WHERE picture_name ='" . $_POST["name"] . "'") or die();

    unlink($filename);
}


if (isset($_POST["getPicture"])) {

    print_r($_POST);
    $result = array();
    $files = scandir('../../itemPicture');

    $output = '<div class="row">';
    $itemID = $_POST['itemID'];

    if (false !== $files) {
        foreach ($files as $file) {
            if ('.' !=  $file && '..' != $file) {
                if (strtok($file, '_') == $itemID) {
                    $output .= '
       <div class="col-md-4 text-center">
        <img src="' . $folder_name . $file . '" class="img-thumbnail rounded" style="width:200px;height:200px" />
        <button type="button" class="btn btn-danger my-2 text-uppercase" style="width:80%" id="' . $file . '">Remove</button>
       </div>
       ';
                }
            }
        }
    }
    $output .= '</div>';
    echo $output;
}
