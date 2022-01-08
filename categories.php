<?php
    require_once('./admin/db.php'); 
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    $user = $_SESSION['username'];

    $error = '';
    $categoryfood_name = '';
    $categoryfood_decription = '';
    $categoryfood_picture = '';

    if(isset($_POST['btn-submit-categoty'])) {
        $categoryfood_name = $_POST['categoryfood_name'];
        $categoryfood_decription = $_POST['categoryfood_decription'];
        $categoryfood_picture = $_POST['categoryfood_picture'];
        if(!empty($categoryfood_name) && !empty($categoryfood_decription) && !empty($categoryfood_picture)) {
            $_POST['categoryfood_name'] = '';
            $_POST['categoryfood_decription'] = '';
            $_POST['categoryfood_picture'] = '';
            $data = addCategory($categoryfood_name, $categoryfood_picture, $categoryfood_decription);
            if($data['code'] != 0) {
                $error = 'Có lỗi xảy ra vui lòng thử lại sau';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/categories.css">
    <link rel="stylesheet" href="./css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/3aelogo.png" alt="Restaurant Logo" class="img-responsive">
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
                                    <a href="#">Thực đơn</a>
                                </li>
                                <li>
                                    <a href="#">Liên hệ</a>
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
                                    <a href="#">Quản lý thực đơn</a>
                                </li>
                                <li>
                                    <a href="#">Quản lý tài khoản</a>
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



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">CÁC LOẠI MÓN</h2>

            <div id="errorMessage" class="errorMessage my-3">
                <?php 
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                ?>
            </div>
            <div class="addcategori" style="margin-top:5%; margin-left:2%; margin-bottom:2%">
                <button type="submit" class="icon-btn add-btn" >
                    <div class="add-icon"></div>
                    <div class="btn-txt" >Thêm loại</div>
                </button>
            </div>

            <div id="errorMessage" class="errorMessage my-3" style="font-size: 20px;margin-left: 18px;font-weight: bold;color: red;">
                <?php 
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                ?>
            </div>

            <?php
                selectAllCategory();
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


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
            <p><a href="#">51900147 51900200 51900145</a></p>
        </div>
    </section>
    <!-- footer Section Ends Here -->

    <div class='add-category-food'>
        <form action="" method="POST" class='add-category-food-form'>
            <i class="fa fa-close exit-icon"></i>
            <div class="input-form">
                <label class="categoryfood_lable" for="categoryfood_name">Tên loại món:</label>
                <input required="" type="text" class="categoryfood_name" name="categoryfood_name" placeholder="Tên loại món">

                <label class="categoryfood_lable" for="categoryfood_decription">Một vài mô tả:</label>
                <input required="" type="text" class="categoryfood_decription" name="categoryfood_decription" placeholder="Mô tả">

                <label class="categoryfood_lable" for="categoryfood_picture">Chọn hình ảnh:</label>
                <input required="" type="file" class="categoryfood_picture" name="categoryfood_picture">
            </div>
            <div>
                <button class="btn-submit-categoty" name="btn-submit-categoty">
                    Thêm
                </button>
            </div>
        </form>
    </div>

</body>
<script>
    $(document).ready(() => {
       const add_btn = $('.add-btn');
       const add_category_food = $('.add-category-food');
       const add_category_food_form = $('.add-category-food-form');
       const exit_icon = $('.exit-icon');

       add_btn.on('click', function() {
        add_category_food.toggleClass('open');
       })

       add_category_food.on('click', function() {
        add_category_food.toggleClass('open');
       })

       add_category_food_form.on('click', function(event) {
           event.stopPropagation();
       })

       exit_icon.on('click', function() {
        add_category_food.toggleClass('open');
       })
    })

</script>
</html>