<?php

require_once "checkLogin.php";
require_once "../include/conn.php";

$totalSuccessCategory = [];
$totalSuccessCategoryName = [];
$query = "SELECT COUNT(*) as total_success, category_name FROM `bidding` JOIN item ON bidding.itemID=item.itemID JOIN category ON item.item_category=category.categoryID WHERE success=1 GROUP BY category_name";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    array_push($totalSuccessCategory, $row["total_success"]);
    array_push($totalSuccessCategoryName, $row["category_name"]);
}

$totalSuccessDate = [];
$totalSuccessDateName = [];
$query = "SELECT COUNT(*) as total_success, end_date FROM `bidding` JOIN item ON bidding.itemID=item.itemID WHERE success=1 GROUP BY end_date";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    array_push($totalSuccessDate, $row["total_success"]);
    array_push($totalSuccessDateName, $row["end_date"]);
}

$totalBiddingCategory = [];
$totalBiddingCategoryName = [];
$query = "SELECT COUNT(*) as total_bidding, category_name FROM `bidding` JOIN item ON bidding.itemID=item.itemID JOIN category ON item.item_category=category.categoryID WHERE bidding_status='start' GROUP BY category_name";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    array_push($totalBiddingCategory, $row["total_bidding"]);
    array_push($totalBiddingCategoryName, $row["category_name"]);
}

$totalBiddingDate = [];
$totalBiddingDateName = [];
$query = "SELECT COUNT(*) as total_bidding, `start_date` FROM `bidding` JOIN item ON bidding.itemID=item.itemID WHERE bidding_status='start' GROUP BY `start_date`";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    array_push($totalBiddingDate, $row["total_bidding"]);
    array_push($totalBiddingDateName, $row["start_date"]);
}

$totalFavouriteCategory = [];
$totalFavouriteCategoryName = [];
$query = "SELECT COUNT(*) as total_favourite, `category_name` FROM favourite JOIN item on favourite.itemID=item.itemID JOIN category ON item.item_category=category.categoryID GROUP BY category_name";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    array_push($totalFavouriteCategory, $row["total_favourite"]);
    array_push($totalFavouriteCategoryName, $row["category_name"]);
}

$totalItem = [];
$totalItemName = [];
$query = "SELECT COUNT(*) as total_item, category_name FROM item JOIN category ON item.item_category=category.categoryID GROUP BY category_name";
$sql = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($sql)) {
    array_push($totalItem, $row["total_item"]);
    array_push($totalItemName, $row["category_name"]);
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

    <title>Report</title>
    <!-- Favicon-->
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/sidebar.css" rel="stylesheet" />
</head>

<body class="sb-sidenav-toggled">

    <?php include("header.php"); ?>

    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <?php include 'sidebar.php'; ?>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper">

            <?php include 'topNavigation.php'; ?>

            <div class="container">
                <!-- Page content-->
                <div class="container-fluid">
                    <ul class="nav nav-tabs justify-content-center">
                        <li class="active"><a data-toggle="tab" href="#home" class="nav-link active">TOTAL SUCCESS BID</a></li>
                        <li><a data-toggle="tab" href="#menu1" class="nav-link">CURRENT BIDDING</a></li>
                        <li><a data-toggle="tab" href="#menu2" class="nav-link">FAVORITE CATEGORY</a></li>
                        <li><a data-toggle="tab" href="#menu3" class="nav-link">TOTAL ITEM</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active show">
                            <ul class="nav nav-tabs justify-content-center">
                                <li class="active"><a data-toggle="tab" href="#totalSuccessCatgeoryTab" class="nav-link active">CATEGORY</a></li>
                                <li><a data-toggle="tab" href="#totalSuccessDateTab" class="nav-link">DATE</a></li>
                            </ul>
                            <div class="tab-content mt-3">
                                <div id="totalSuccessCatgeoryTab" class="tab-pane fade in active show">
                                    <div style="width:80%;max-width:1000px;display:block;margin-left:auto;margin-right:auto;">
                                        <div class="card mb-4 rounded shadow">
                                            <div class="card-header text-uppercase">
                                                <i class="fas fa-chart-area me-1"></i>
                                                Total Success
                                            </div>
                                            <div class="card-body"><canvas id="totalSuccessCategory" width="100%" height="40"></canvas></div>
                                        </div>
                                    </div>
                                    <div class="card mb-4 rounded shadow">
                                        <div class="card-header text-uppercase">
                                            <i class="fas fa-table me-1"></i>
                                            Success Bid List
                                        </div>
                                        <div class="card-body">
                                            <table id="totalSuccessCategoryTable">
                                                <thead>
                                                    <tr>
                                                        <th>Category Name</th>
                                                        <th>Total Success</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($totalSuccessCategory); $i++) { ?>
                                                        <tr>
                                                            <td><?= $totalSuccessCategoryName[$i] ?></td>
                                                            <td><?= $totalSuccessCategory[$i] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="totalSuccessDateTab" class="tab-pane fade">
                                    <div style="width:80%;max-width:1000px;display:block;margin-left:auto;margin-right:auto;">
                                        <div class="card mb-4 rounded shadow">
                                            <div class="card-header text-uppercase">
                                                <i class="fas fa-chart-area me-1"></i>
                                                Total Success
                                            </div>
                                            <div class="card-body"><canvas id="totalSuccessDate" width="100%" height="40"></canvas></div>
                                        </div>
                                    </div>
                                    <div class="card mb-4 rounded shadow">
                                        <div class="card-header text-uppercase">
                                            <i class="fas fa-table me-1"></i>
                                            Success Bid List
                                        </div>
                                        <div class="card-body">
                                            <table id="totalSuccessDateTable">
                                                <thead>
                                                    <tr>
                                                        <th>Category Name</th>
                                                        <th>Total Success</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($totalSuccessDate); $i++) { ?>
                                                        <tr>
                                                            <td><?= $totalSuccessDateName[$i] ?></td>
                                                            <td><?= $totalSuccessDate[$i] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="menu1" class="tab-pane fade">
                            <ul class="nav nav-tabs justify-content-center">
                                <li class="active"><a data-toggle="tab" href="#totalBiddingCategoryTab" class="nav-link active">CATEGORY</a></li>
                                <li><a data-toggle="tab" href="#totalBiddingDateTab" class="nav-link">DATE</a></li>
                            </ul>
                            <div class="tab-content mt-3">
                                <div id="totalBiddingCategoryTab" class="tab-pane fade in active show">
                                    <div style="width:80%;max-width:1000px;display:block;margin-left:auto;margin-right:auto;">
                                        <div class="card mb-4 rounded shadow">
                                            <div class="card-header text-uppercase">
                                                <i class="fas fa-chart-area me-1"></i>
                                                Total Bidding
                                            </div>
                                            <div class="card-body"><canvas id="totalBiddingCategory" width="100%" height="40"></canvas></div>
                                        </div>
                                    </div>
                                    <div class="card mb-4 rounded shadow">
                                        <div class="card-header text-uppercase">
                                            <i class="fas fa-table me-1"></i>
                                            Category List
                                        </div>
                                        <div class="card-body">
                                            <table id="totalBiddingCategoryTable">
                                                <thead>
                                                    <tr>
                                                        <th>Category Name</th>
                                                        <th>Total Bidding</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($totalBiddingCategory); $i++) { ?>
                                                        <tr>
                                                            <td><?= $totalBiddingCategoryName[$i] ?></td>
                                                            <td><?= $totalBiddingCategory[$i] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="totalBiddingDateTab" class="tab-pane fade">
                                    <div style="width:80%;max-width:1000px;display:block;margin-left:auto;margin-right:auto;">
                                        <div class="card mb-4 rounded shadow">
                                            <div class="card-header text-uppercase">
                                                <i class="fas fa-chart-area me-1"></i>
                                                Total Bidding
                                            </div>
                                            <div class="card-body"><canvas id="totalBiddingDate" width="100%" height="40"></canvas></div>
                                        </div>
                                    </div>
                                    <div class="card mb-4 rounded shadow">
                                        <div class="card-header text-uppercase">
                                            <i class="fas fa-table me-1"></i>
                                            Total Bidding
                                        </div>
                                        <div class="card-body">
                                            <table id="totalBiddingDateTable">
                                                <thead>
                                                    <tr>
                                                        <th>Category Name</th>
                                                        <th>Total Bidding</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($totalBiddingDate); $i++) { ?>
                                                        <tr>
                                                            <td><?= $totalBiddingDateName[$i] ?></td>
                                                            <td><?= $totalBiddingDate[$i] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="menu2" class="tab-pane fade">
                            <div class="tab-content mt-3">
                                <div id="totalBiddingCategoryTab" class="tab-pane fade in active show">
                                    <div style="width:80%;max-width:1000px;display:block;margin-left:auto;margin-right:auto;">
                                        <div class="card mb-4 rounded shadow">
                                            <div class="card-header text-uppercase">
                                                <i class="fas fa-chart-area me-1"></i>
                                                Total Favourites
                                            </div>
                                            <div class="card-body"><canvas id="totalFavouriteCategory" width="100%" height="40"></canvas></div>
                                        </div>
                                    </div>
                                    <div class="card mb-4 rounded shadow">
                                        <div class="card-header text-uppercase">
                                            <i class="fas fa-table me-1"></i>
                                            Total Favourites
                                        </div>
                                        <div class="card-body">
                                            <table id="totalFavouriteCategoryTable">
                                                <thead>
                                                    <tr>
                                                        <th>Category Name</th>
                                                        <th>Total Favourites</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($totalFavouriteCategory); $i++) { ?>
                                                        <tr>
                                                            <td><?= $totalFavouriteCategoryName[$i] ?></td>
                                                            <td><?= $totalFavouriteCategory[$i] ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="menu3" class="tab-pane fade">
                            <div class="tab-content mt-3">
                                <div id="totalBiddingCategoryTab" class="tab-pane fade in active show">
                                    <div style="width:80%;max-width:1000px;display:block;margin-left:auto;margin-right:auto;">
                                        <div class="card mb-4 rounded shadow">
                                            <div class="card-header text-uppercase">
                                                <i class="fas fa-chart-area me-1"></i>
                                                Total Items
                                            </div>
                                            <div class="card-body"><canvas id="totalItem" width="100%" height="40"></canvas></div>
                                        </div>
                                    </div>
                                    <div class="card mb-4 rounded shadow text-uppercase">
                                        <div class="card-header">
                                            <i class="fas fa-table me-1"></i>
                                            Total Items
                                        </div>
                                        <div class="card-body">
                                            <table id="totalItemTable">
                                                <thead>
                                                    <tr>
                                                        <th>Category Name</th>
                                                        <th>Total Items</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($i = 0; $i < sizeof($totalItem); $i++) { ?>
                                                        <tr>
                                                            <td><?= $totalItemName[$i] ?></td>
                                                            <td><?= $totalItem[$i] ?></td>
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
            </div>
        </div>
    </div>
    </div>


    <script src="js/serverManager.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Area Chart Example
        var totalSuccessCategoryChart = document.getElementById("totalSuccessCategory");
        var totalSuccessDateChart = document.getElementById("totalSuccessDate");
        var totalBiddingCategoryChart = document.getElementById("totalBiddingCategory");
        var totalBiddingDateChart = document.getElementById("totalBiddingDate");
        var totalFavouriteCategoryChart = document.getElementById("totalFavouriteCategory");
        var totalItemChart = document.getElementById("totalItem");

        var totalSuccessCategory = new Chart(totalSuccessCategoryChart, {
            type: 'bar',
            data: {
                labels: <?= json_encode($totalSuccessCategoryName) ?>,
                datasets: [{
                    label: "Total Bidding",
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?= json_encode($totalSuccessCategory) ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        var totalSuccessDate = new Chart(totalSuccessDateChart, {
            type: 'line',
            data: {
                labels: <?= json_encode($totalSuccessDateName) ?>,
                datasets: [{
                    label: "Total Bidding",
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?= json_encode($totalSuccessDate) ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        var totalBiddingCategory = new Chart(totalBiddingCategoryChart, {
            type: 'bar',
            data: {
                labels: <?= json_encode($totalBiddingCategoryName) ?>,
                datasets: [{
                    label: "Total Bidding",
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?= json_encode($totalBiddingCategory) ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        var totalBiddingDate = new Chart(totalBiddingDateChart, {
            type: 'line',
            data: {
                labels: <?= json_encode($totalBiddingDateName) ?>,
                datasets: [{
                    label: "Total Bidding",
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?= json_encode($totalBiddingDate) ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        var totalFavouriteCategory = new Chart(totalFavouriteCategoryChart, {
            type: 'bar',
            data: {
                labels: <?= json_encode($totalFavouriteCategoryName) ?>,
                datasets: [{
                    label: "Total Bidding",
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?= json_encode($totalFavouriteCategory) ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });

        var totalItem = new Chart(totalItemChart, {
            type: 'bar',
            data: {
                labels: <?= json_encode($totalItemName) ?>,
                datasets: [{
                    label: "Total Item",
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?= json_encode($totalItem) ?>,
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 10
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    </script>
</body>

</html>