<?php

session_start();

require_once "../include/conn.php";

$query = "SELECT * FROM category";
$sql = mysqli_query($conn, $query);

$categories = [];
while ($row = mysqli_fetch_array($sql)) {
    $categories[] = array(
        "id" => $row["categoryID"],
        "name" => $row["category_name"],
        "unlisted" => $row["unlisted"]
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

    <link href="css/styles.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <title>Simple Sidebar - Start Bootstrap Template</title>
    <!-- Favicon-->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/sidebar.css" rel="stylesheet" />
</head>

<body class="sb-sidenav-toggled">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <?php include 'sidebar.php'; ?>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper">

            <?php include 'topNavigation.php'; ?>

            <!-- Page content-->
            <div class="container-fluid">
                <div class="container">
                    <div>
                        <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addCategoryLabel">Add new Category</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="categoryManager.php" method="post" enctype="multipart/form">
                                            <div class="form-group">
                                                <label for="categoryName">
                                                    Category Name: </label>
                                                <input type="text" name="categoryName" id="categoryName" class="form-control" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger text-uppercase" data-bs-dismiss="modal" onclick="reset()">Close</button>
                                        <input type="submit" class="btn btn-primary text-uppercase" value="Add Category" name="addCategory">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-4 mb-4 rounded shadow">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" style="float: right" data-bs-toggle="modal" data-bs-target="#addCategory">
                                + Add Category
                            </button>
                            <i class="fas fa-table me-1"></i>
                            Category List
                        </div>
                        <div class="card-body">
                            <table id="manageCategoryTable">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($categories as $category) { ?>
                                        <tr>
                                            <td><?= $category["name"] ?></td>
                                            <td><?php if ($category["unlisted"]) {
                                                    echo "unlisted";
                                                } else {
                                                    echo "active";
                                                } ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary text-uppercase" data-bs-toggle="modal" data-bs-target="#editCategory<?= $category["id"] ?>">
                                                        Edit
                                                    </button>
                                                    <div class="modal fade" id="editCategory<?= $category["id"] ?>" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="categoryManager.php" method="post">
                                                                        <div class="form-group">
                                                                            <label for="categoryEditName<?= $category["id"] ?>">
                                                                                Category Name:
                                                                            </label>
                                                                            <input type="hidden" name="categoryID" value="<?= $category["id"] ?>">
                                                                            <input type="text" name="categoryName" id="categoryEditName<?= $category["id"] ?>" class="form-control" value="<?= $category["name"] ?>" required>
                                                                        </div>
                                                                        <div class="modal-footer mt-3">
                                                                            <button type="button" class="btn btn-danger text-uppercase" data-bs-dismiss="modal">Close</button>
                                                                            <input type="submit" class="btn btn-primary text-uppercase" value="Edit Category" name="editCategory">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php

                                                    if ($category["unlisted"]) {
                                                    ?>
                                                        <form action="categoryManager.php" method="post" onsubmit="return confirm('Do you really want to active the category?');">
                                                            <input type="hidden" name="categoryID" value="<?= $category["id"] ?>">
                                                            <input type="submit" type="button" class="btn btn-info text-uppercase" value="Active" name="activeCategory">
                                                        </form>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <form action="categoryManager.php" method="post" onsubmit="return confirm('Do you really want to unlist the account?');">
                                                            <input type="hidden" name="categoryID" value="<?= $category["id"] ?>">
                                                            <input type="submit" type="button" class="btn btn-danger text-uppercase" value="Unlist" name="unlistCategory">
                                                        </form>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="js/serverManager.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

</body>

</html>