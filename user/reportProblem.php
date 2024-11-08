<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css" type="text/css">
    <title>Report a Problem</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include "header.php"; ?>
    <?php include "navbar.php"; ?>

    <div class="container">
        <div class="title">
            <h1 class="headline mb-3 font-weight-bold text-uppercase">Report a problem</h1>
            <hr>
        </div>
        <div class="container">
            <div class="card rounded shadow">
                <div class="card-body">
                    <?php
                    if (isset($_GET["sellerID"])) {
                        $sql = "SELECT * FROM user WHERE userID = {$_GET["sellerID"]}";
                        $query = mysqli_query($conn, $sql);
                        $seller = mysqli_fetch_array($query);
                    ?>
                        <div class="row mx-auto">
                            <div class="col-6">
                                <img src="../profilePicture/<?= $seller["profile_picture"] ?>" class="sellerImage whiteMargin">
                            </div>
                            <div class="col-6">
                                <h4 class="my-5"><?= $seller["firstName"] . " " . $seller["lastName"] ?></h4>
                            </div>
                        </div>
                        <form action="reportProblemManager.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="sellerID" value="<?= $_GET["sellerID"] ?>">
                            <div class="form-group">
                                <label for="problemTitle">Problem Title</label>
                                <input type="text" name="reportTitle" id="problemTitle" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="problemDescription">Problem Description</label>
                                <textarea name="reportDescription" id="problemDescription" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="btn-group-toggle d-flex flex-wrap justify-content-center" data-toggle="buttons">
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option1" value="Scam" autocomplete="off" required> Scam
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option2" value="Sexually Inappropriate" autocomplete="off">Sexually Inappropriate
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option3" value="Offensive" autocomplete="off"> Offensive
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option4" value="Violence" autocomplete="off"> Violence
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option5" value="Prohibited Content" autocomplete="off"> Prohibited Content
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option6" value="Spam" autocomplete="off"> Spam
                                    </label>
                                    <label class="btn btn-secondary  p-2 m-1">
                                        <input type="radio" name="options" id="option7" value="False Product" autocomplete="off"> False Product
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option8" value="Political Issue" autocomplete="off"> Political Issue
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option9" value="Other" autocomplete="off"> Other
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group text-center">
                                <input type="submit" value="Send Report" name="sellerReport" class="btn btn-primary">
                            </div>
                        </form>
                    <?php
                    } else if (isset($_GET["itemID"])) {
                        $sql = "SELECT * FROM item WHERE itemID = {$_GET["itemID"]}";
                        $query = mysqli_query($conn, $sql);
                        $item = mysqli_fetch_array($query);
                    ?>
                        <div class="row mx-auto">
                            <h4 class="my-5"><?= $item["item_name"] ?></h4>
                        </div>
                        <form action="reportProblemManager.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="itemID" value="<?= $_GET["itemID"] ?>">
                            <div class="form-group">
                                <label for="problemTitle">Problem Title</label>
                                <input type="text" name="reportTitle" id="problemTitle" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="problemDescription">Problem Description</label>
                                <textarea name="reportDescription" id="problemDescription" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="btn-group-toggle d-flex flex-wrap justify-content-center" data-toggle="buttons">
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option1" value="Scam" autocomplete="off" required> Scam
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option2" value="Sexually Inappropriate" autocomplete="off">Sexually Inappropriate
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option3" value="Offensive" autocomplete="off"> Offensive
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option4" value="Violence" autocomplete="off"> Violence
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option5" value="Prohibited Content" autocomplete="off"> Prohibited Content
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option6" value="Spam" autocomplete="off"> Spam
                                    </label>
                                    <label class="btn btn-secondary  p-2 m-1">
                                        <input type="radio" name="options" id="option7" value="False Product" autocomplete="off"> False Product
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option8" value="Political Issue" autocomplete="off"> Political Issue
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option9" value="Other" autocomplete="off"> Other
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group text-center">
                                <input type="submit" value="Send Report" name="itemReport" class="btn btn-primary">
                            </div>
                        </form>
                    <?php
                    } else {
                    ?>
                        <form action="reportProblemManager.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="screenShot">ScreenShot for reporting</label>
                                <input type="file" name="screenShot" id="screenShot" class="form-control-file" onchange="previewFile(this);">
                                <div class="text-center">
                                    <img id="previewScreenShot" src="../profilePicture/blankPicture.png" width="100" height="100" alt="Placeholder">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="problemTitle">Problem Title</label>
                                <input type="text" name="reportTitle" id="problemTitle" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="problemDescription">Problem Description</label>
                                <textarea name="reportDescription" id="problemDescription" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <div class="btn-group-toggle d-flex flex-wrap justify-content-center" data-toggle="buttons">
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option1" value="Scam" autocomplete="off" required> Scam
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option2" value="Sexually Inappropriate" autocomplete="off">Sexually Inappropriate
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option3" value="Offensive" autocomplete="off"> Offensive
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option4" value="Violence" autocomplete="off"> Violence
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option5" value="Prohibited Content" autocomplete="off"> Prohibited Content
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option6" value="Spam" autocomplete="off"> Spam
                                    </label>
                                    <label class="btn btn-secondary  p-2 m-1">
                                        <input type="radio" name="options" id="option7" value="False Product" autocomplete="off"> False Product
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option8" value="Political Issue" autocomplete="off"> Political Issue
                                    </label>
                                    <label class="btn btn-secondary p-2 m-1">
                                        <input type="radio" name="options" id="option9" value="Other" autocomplete="off"> Other
                                    </label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group text-center">
                                <input type="submit" value="Send Report" name="sendReport" class="btn btn-primary">
                            </div>
                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include "footer.php" ?>

</body>

<script src="../js/reportProblem.js"></script>

</html>