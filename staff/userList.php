<?php

session_start();

require_once "../include/conn.php";

$query = "SELECT * FROM user WHERE account_type='user'";
$sql = mysqli_query($conn, $query);

$users = [];
while ($row = mysqli_fetch_array($sql)) {
    $users[] = array(
        "userID" => $row["userID"],
        "firstName" => $row["firstName"],
        "lastName" => $row["lastName"],
        "email" => $row["email"],
        "phoneNumber" => $row["phone_number"],
        "account_status" => $row["verification_status"],
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/sidebar.css" rel="stylesheet" />

    <title>Home</title>
</head>

<body class="sb-sidenav-toggled">

    <div class="d-flex" id="wrapper">
        <?php include 'sidebar.php'; ?>
        <?php include 'header.php'; ?>

        <div id="page-content-wrapper">
            <?php include 'topNavigation.php'; ?>

            <div class="container">
                <h1 class="headline m-3 font-weight-bold text-uppercase">Manage User</h1>
                <hr>
                <div class="card  rounded shadow">
                    <div class="card-header text-uppercase">
                        <i class="fas fa-table me-1"></i>
                        User List
                    </div>
                    <div class="card-body">
                        <table id="userList">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user) { ?>
                                    <tr>
                                        <td><?= $user["userID"] ?></td>
                                        <td><?= $user["firstName"] ?></td>
                                        <td><?= $user["lastName"] ?></td>
                                        <td><?= $user["email"] ?></td>
                                        <td><?= $user["phoneNumber"] ?></td>
                                        <td>
                                            <a href="userDetail.php?id=<?= $user['userID'] ?>" class="btn btn-primary text-uppercase" style="width:100%">View</a>
                                            <?php if ($user["account_status"] == "active") {
                                            ?>
                                                <form action="userManager.php" method="post">
                                                    <input type="hidden" name="userID" value="<?= $user["userID"] ?>">
                                                    <input type="submit" value="Suspend" name="suspend" class="btn btn-danger text-uppercase" style="width:100%">
                                                </form>
                                            <?php
                                            } else if ($user["account_status"] == "inactive") {
                                            ?>
                                                INACTIVE
                                            <?php
                                            } else {
                                            ?>
                                                <form action="userManager.php" method="post">
                                                    <input type="hidden" name="userID" value="<?= $user["userID"] ?>">
                                                    <input type="submit" value="Active" name="active" class="btn btn-info text-uppercase" style="width:100%">
                                                </form>
                                            <?php
                                            } ?>
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

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        // Toggle the side navigation
        const sidebarToggle = document.body.querySelector("#sidebarToggle");
        if (sidebarToggle) {
            // Uncomment Below to persist sidebar toggle between refreshes
            // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            //     document.body.classList.toggle('sb-sidenav-toggled');
            // }
            sidebarToggle.addEventListener("click", (event) => {
                event.preventDefault();
                document.body.classList.toggle("sb-sidenav-toggled");
                localStorage.setItem(
                    "sb|sidebar-toggle",
                    document.body.classList.contains("sb-sidenav-toggled")
                );
            });
        }
    });

    const userList = document.getElementById("userList");
    if (userList) {
        new simpleDatatables.DataTable(userList);
    }
</script>

</html>