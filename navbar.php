<!-- navbar-->

<link rel="stylesheet" href="include/bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet" />


<header class="header bg-white shadow">
    <div class="container px-0 px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0">
            <a class="navbar-brand" href="index.php"><span class="font-weight-bold text-uppercase text-dark">obs</span></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link text-uppercase" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <!-- Link--><a class="nav-link text-uppercase" href="items.php">All items</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-uppercase" id="pagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
                        <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown">
                            <?php
                            $query = "SELECT * FROM `category`";
                            $sql = mysqli_query($conn, $query);
                            while ($categories = mysqli_fetch_array($sql)) {
                            ?>
                                <a class="dropdown-item border-0 transition-link text-uppercase" href="items.php?category=<?= $categories["categoryID"] ?>"><?= $categories["category_name"] ?></a>
                            <?php
                            }
                            ?>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <form action="items.php" method="post">
                            <input type="text" name="searchItem" id="searchItem" class="form-control" maxlength="25" placeholder="Search.." required>
                        </form>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-uppercase" href="login.php">
                            <i class="fas fa-user-alt mr-1 text-gray"></i>Login</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>