<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    require_once('./admin/db.php'); 

    $user = $_SESSION['username'];

    $error = '';
    $categoryfood_name = '';
    $categoryfood_decription = '';
    $categoryfood_picture = '';

    if(isset($_POST['btn-submit-categoty'])) {  
        $categoryfood_name = $_POST['categoryfood_name'];
        $categoryfood_decription = $_POST['categoryfood_decription'];

        if(!empty($categoryfood_name) && !empty($categoryfood_decription)) {
            // echo "<pre>", print_r($_FILES['categoryfood_picture']['name']) ,"</pre>";

            $data = addCategory($categoryfood_name, $categoryfood_decription);
            $profileImageName = time() . '_' . $_FILES['categoryfood_picture']['name'];

            $targer = 'images/' . $profileImageName;
            if(move_uploaded_file($_FILES['categoryfood_picture']['tmp_name'], $targer)) {
                $sql = "UPDATE category SET img_name = '$profileImageName' WHERE title = '$categoryfood_name'";
                $conn = open_database();
                $stm = $conn->prepare($sql);
                $stm->execute();
            } 
            else {
                $error = "Thêm món không thành công.";
            }
            if($data['code'] == 0) {
                
            }
            else {
                $error = 'Có lỗi xảy ra vui lòng thử lại sau';
            }
        }     
    }

    if(isset($_POST['delete-icon'])) {
        $id = $_POST['delete-icon'];

        $sql = "DELETE FROM category WHERE id = '$id'";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->execute();
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
                <a href="index.php" title="Logo">
                    <img src="images/4aelogo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <?php
                if($user != "admin") {
                    echo '<div class="menu text-right">
                            <ul>
                                <li>
                                    <a href="index.php">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="#">Thực đơn</a>
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
                                    <a href="#">Quản lý thực đơn</a>
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
            <?php
                if($user == 'admin') {
                    echo '<div class="addcategori" style="margin-top:5%; margin-left:2%; margin-bottom:2%">
                            <button type="submit" class="icon-btn add-btn" >
                                <div class="add-icon"></div>
                                <div class="btn-txt" >Thêm loại</div>
                            </button>
                        </div>';
                }
            ?>

            <div id="errorMessage" class="errorMessage my-3" style="font-size: 20px;margin-left: 18px;font-weight: bold;color: red;">
                <?php 
                    if (!empty($error)) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                ?>
            </div>

            <?php
                selectAllCategory($user);
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
        
    <div class="add-category-food">
        <form action="" method="POST" class="add-category-food-form" enctype="multipart/form-data">
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
       const fix_icon = $('.fix-icon');

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
       
       fix_icon.on('click', function() {
            // var xhttp = new XMLHttpRequest();

            // xhttp.open("POST", "categories.php", true);
            // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            // xhttp.send("id_categories=phoga");

       })
    })

</script>
</html>