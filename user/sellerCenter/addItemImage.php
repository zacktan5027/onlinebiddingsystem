<?php

require_once "../../include/conn.php";

$itemID = $_GET['id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js"></script>
    <script src="../../js/itemImage.js"></script>
    <title>Item Image</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "../header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <a href="editItem.php?id=<?= $itemID ?>" class="float-left">
            <h1 class="mx-4"><i class="fas fa-arrow-left"></i></h1>
        </a>
        <h1 class="headline mb-3 font-weight-bold text-uppercase">Item Image</h1>
        <hr>
        <div class="container-content rounded shadow">
            <form action="itemImageManager.php?id=<?= $itemID ?>" class="dropzone" id="dropzoneFrom">
                <input type="hidden" name="itemID" id="itemID" value="<?= $itemID ?>">
            </form>

            </form>
            <br />
            <br />
            <div align=" center">
                <button type="button" class="btn btn-primary text-uppercase" id="submit-all">Upload</button>
                <button type="button" class="btn btn-danger text-uppercase" id="remove-all">Remove</button>
                <a href="manageItems.php"><button class="btn btn-primary text-uppercase" id="">Done</button></a>
            </div>
            <br />
            <br />
            <div id="preview"></div>
            <br />
            <br />
        </div>
    </div>

    <?php include "../footer.php" ?>

</body>

</html>