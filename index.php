<?php
    require_once('./admin/db.php'); 
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    $user = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/4aelogo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
            <?php
                if($user != "admin") {
                    echo '<div class="menu text-right">
                            <ul>
                                <li>
                                    <a href="#">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="categories.php">Thực đơn</a>
                                </li>
                                <li>
                                    <a href="contact.php">Liên hệ</a>
                                </li>
                                <li>
                                    <a  href="logout.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>';
                }
                else {
                    echo '<div class="menu text-right">
                            <ul>
                                <li>
                                    <a href="categories.php">Quản lý thực đơn</a>
                                </li>
                                <li>
                                    <a href="./admin/account.php">Quản lý tài khoản</a>
                                </li>
                                <li>
                                    <a href="logout.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>';
                }
            ?>
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="food-search.html" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Các loại món</h2>

            <?php
                selectAllCategoryHome();
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Danh sách tất cả các món</h2>

            <?php 
                selectAllFoodHome();
            ?>

            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="categories.php">Đến trang thực đơn</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <!-- social Section Starts Here -->
    <section class="social">
        <div class="container text-center">
            <ul>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png"/></a>
                </li>
            </ul>
        </div>
    </section>
    <!-- social Section Ends Here -->

    <!-- footer Section Starts Here -->
    <section class="footer">
        <div class="container text-center">
            <p><a href="#">51900147 51900200 51900145 51900067</a></p>
        </div>
    </section>
    <!-- footer Section Ends Here -->

</body>
</html>