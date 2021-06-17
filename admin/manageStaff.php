<?php

session_start();

require_once "../include/conn.php";

$staffs = [];
$query = "SELECT * FROM `user` WHERE account_type='staff'";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    $staffs[] = array(
        "staffID" => $row["userID"],
        "firstName" => $row["firstName"],
        "lastName" => $row["lastName"],
        "username" => $row["username"],
        "email" => $row["email"],
        "phoneNumber" => $row["phone_number"],
        "verificationStatus" => $row["verification_status"],
    );
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
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
                <div class="container mt-3">
                    <div>
                        <div class="modal fade" id="addStaff" tabindex="-1" aria-labelledby="addStaffLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addStaffLabel">Add new Staff</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="staffManager.php" method="post" enctype="multipart/form">
                                            <div class="form-group">
                                                <label for="username">
                                                    Username:
                                                </label>
                                                <input type="text" name="username" id="username" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">
                                                    Password:
                                                </label>
                                                <input type="password" name="password" id="password" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirmPassword">
                                                    Confirm Password:
                                                </label>
                                                <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" required>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger text-uppercase" data-bs-dismiss="modal" onclick="reset()">Close</button>
                                        <input type="submit" class="btn btn-primary text-uppercase" value="Add Staff" name="addStaff">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4 mt-4 rounded shadow">
                        <div class="card-header">

                            <i class="fas fa-table me-1"></i>
                            Staff List
                            <button type="button" class="btn btn-primary text-right text-uppercase" style="float:right" data-bs-toggle="modal" data-bs-target="#addStaff">
                                + Add Staff
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="manageStaffTable">
                                <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone Number</th>
                                        <th>Account Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($staffs as $staff) { ?>
                                        <tr>
                                            <td><?= $staff["firstName"] ?></td>
                                            <td><?= $staff["lastName"] ?></td>
                                            <td><?= $staff["username"] ?></td>
                                            <td><?= $staff["email"] ?></td>
                                            <td><?= $staff["phoneNumber"] ?></td>
                                            <td><?= $staff["verificationStatus"] ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-primary text-uppercase" data-bs-toggle="modal" style="width:100%" data-bs-target="#editStaff<?= $staff["staffID"] ?>">
                                                        Edit
                                                    </button>
                                                    <div class="modal fade" id="editStaff<?= $staff["staffID"] ?>" tabindex="-1" aria-labelledby="editStaffLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editStaffLabel">Edit <?= $staff["username"] ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="staffManager.php" id="editStaffForm<?= $staff["staffID"] ?>" method="post" enctype="multipart/form">
                                                                        <input type="hidden" name="editStaff">
                                                                        <input type="hidden" name="staffID" value="<?= $staff["staffID"] ?>">
                                                                        <div class="form-group">
                                                                            <label for="password">
                                                                                Password:
                                                                            </label>
                                                                            <input type="password" name="password" class="form-control" required>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="confirmPassword">
                                                                                Confirm Password:
                                                                            </label>
                                                                            <input type="password" name="confirmPassword" class="form-control" required>
                                                                        </div>
                                                                        <div class="modal-footer mt-3">
                                                                            <button type="button" class="btn btn-danger text-uppercase" data-bs-dismiss="modal" onclick="reset()">Close</button>
                                                                            <input type="submit" class="btn btn-primary text-uppercase" value="Edit Staff" name="editStaff">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php

                                                    if ($staff["verificationStatus"] == "active") {
                                                    ?>
                                                        <form action="staffManager.php" method="post" onsubmit="return confirm('Do you really want to suspend the account?');">
                                                            <input type="hidden" name="staffID" value="<?= $staff["staffID"] ?>">
                                                            <input type="submit" type="button" class="btn btn-danger text-uppercase" style="width:100%" value="Suspend" name="suspendStaff">
                                                        </form>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <form action="staffManager.php" method="post" onsubmit="return confirm('Do you really want to active the account?');">
                                                            <input type="hidden" name="staffID" value="<?= $staff["staffID"] ?>">
                                                            <input type="submit" type="button" class="btn btn-info text-uppercase" style="width:100%" value="Active" name="activeStaff">
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

</body>

<script src="js/serverManager.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>



</html>