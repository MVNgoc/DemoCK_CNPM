<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }



    require_once('./admin/db.php'); 

    $user = $_SESSION['username'];

    if(isset($_POST['view-icon'])) {
        $category = $_POST['view-icon'];
        $_SESSION['category'] = $category;
    }
    else {
        $category = $_SESSION['category'] ;
    }

    if(isset($_POST['btn-submit-food'])) {  
        $title = $_POST['food_name'];
        $description_food = $_POST['food_decription'];
        $price = $_POST['food_price'];

        if(!empty($title) && !empty($description_food) && !empty($price)) {
            // echo "<pre>", print_r($_FILES['categoryfood_picture']['name']) ,"</pre>";

            $data = addFood($title, $description_food, $price, $category);
            $profileImageName = time() . '_' . $_FILES['food_picture']['name'];

            $targer = 'images/' . $profileImageName;
            if(move_uploaded_file($_FILES['food_picture']['tmp_name'], $targer)) {
                $sql = "UPDATE food SET img_food = '$profileImageName' WHERE title = '$title'";
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

    if(isset($_POST['btn-edit-food'])) {
        $title = $_POST['food_name'];
        $description_food = $_POST['food_decription'];
        $price = $_POST['food_price'];
        $id = $_POST['btn-edit-food'];

        if(!empty($title) && !empty($description_food) && !empty($price)) {
            // echo "<pre>", print_r($_FILES['categoryfood_picture']['name']) ,"</pre>";

            $data = updateFood($id, $title, $description_food, $price);
        }
        if($data['code'] == 2) {

                    }
        if (!$_FILES['food_picture']['size'] == 0)
                        {
            $profileImageName = time() . '_' . $_FILES['food_picture']['name'];

            $targer = 'images/' . $profileImageName;
            if(move_uploaded_file($_FILES['food_picture']['tmp_name'], $targer)) {
                $sql = "UPDATE food SET img_food = '$profileImageName' WHERE id = '$id'";
                $conn = open_database();
                $stm = $conn->prepare($sql);
                $stm->execute();
            }

        }
    }

    if(isset($_POST['delete-food-icon'])) {
        $id = $_POST['delete-food-icon'];

        $sql = "DELETE FROM food WHERE id = '$id'";
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
    <link rel="stylesheet" href="css/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/categories.css">
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
                                    <a  href="changepass.php">Đổi mật khẩu</a>
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
                                    <a  href="changepass.php">Đổi mật khẩu</a>
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



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Thực đơn</h2>

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
                                <div class="btn-txt" >Thêm món</div>
                            </button>
                        </div>';
                }
            ?>

            <?php
                selectAllFood($user, $category)
            ?>

            <div class="clearfix"></div>

            <div class="add-food">
                <form action="" method="POST" class="add-food-form" enctype="multipart/form-data">
                    <i class="fa fa-close exit-icon"></i>
                    <div class="input-form">
                        <label class="food_lable" for="food_name">Tên món:</label>
                        <input required="" type="text" class="food_name" name="food_name" placeholder="Tên món">

                        <label class="food_lable" for="food_decription">Một vài mô tả:</label>
                        <input required="" type="text" class="food_decription" name="food_decription" placeholder="Mô tả">

                        <label class="food_lable" for="food_picture">Chọn hình ảnh:</label>
                        <input required="" type="file" class="food_picture" name="food_picture" style="border:none;">

                        <label class="food_lable" for="food_price">Giá:</label>
                        <input required="" type="number" class="food_price" name="food_price" placeholder="Giá">

                        <label class="food_lable" for="food_category">Kiểu món:</label>
                        <input value="<?= $category ?>" required="" type="text" class="food_category" name="food_category" placeholder="Kiểu món" readonly>
                    </div>
                    <div>
                        <button class="btn-submit-food" name="btn-submit-food">
                            Thêm
                        </button>
                    </div>
                </form>
            </div>

            <div class="edit-food" id="edit-food">
                <script>
                    function updateFilename(){
                        var fileInput = document.getElementById("imgCategoryInput");
                        document.getElementById("labelImgName").innerHTML=fileInput? fileInput.files[0].name  : "";
                    }
                </script>
                <form action="" method="POST" class="edit-food-form" enctype="multipart/form-data">
                    <i class="fa fa-close exit-icon"></i>
                    <div class="input-form">
                        <label class="food_lable" for="food_name">Tên món:</label>
                        <input required="" type="text" class="food_name" name="food_name" placeholder="Tên món">

                        <label class="food_lable" for="food_decription">Một vài mô tả:</label>
                        <input required="" type="text" class="food_decription" name="food_decription" placeholder="Mô tả">

                        <label class="food_lable" for="food_picture">Chọn hình ảnh:</label>
                        <input required="" type="file" class="food_picture" name="food_picture">

                        <label class="food_lable" for="food_price">Giá:</label>
                        <input required="" type="number" class="food_price" name="food_price" placeholder="Giá">

                        <label class="food_lable" for="food_category">Kiểu món:</label>
                        <input value="<?= $category ?>" required="" type="text" class="food_category" name="food_category" placeholder="Kiểu món" readonly>
                    </div>
                    <div>
                        <button class="btn-submit-food" name="btn-edit-food">
                            Lưu
                        </button>
                    </div>
                </form>
            </div>

        </div>

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
<script>
    $(document).ready(() => {
       const add_btn = $('.add-btn');
       const add_food = $('.add-food');
       const edit_food = $('.edit-food');
       const add_food_form = $('.add-food-form');
       const edit_food_form = $('.add-food-form');
       const exit_icon = $('.exit-icon');
       const fix_icon = $('.fix-icon');
        const fix_food_icon = $('.fix-food-icon');

       add_btn.on('click', function() {
            add_food.addClass('open');
       })

       add_food.on('click', function() {
            add_food.removeClass('open');
       })

       edit_food.on('click', function() {
            edit_food.removeClass('open');
       })

       add_food_form.on('click', function(event) {
           event.stopPropagation();
       })

       edit_food_form.on('click', function(event) {
           event.stopPropagation();
       })

       exit_icon.on('click', function() {
            add_food.removeClass('open');
            edit_food.removeClass('open');
       })

       fix_food_icon.on('click', function(event) {
           var id = this.value;
           console.log(this.value);
            if(id==""){
                document.getElementById("edit-food").innerHTML = "";
            }else{
                var myRequest = new XMLHttpRequest();
                myRequest.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("edit-food").innerHTML = this.responseText;
                        console.log(this.responseText);
                    }
                };
                myRequest.open("GET","./admin/fix-food.php?id="+id,true);
                myRequest.send();
                edit_food.addClass('open');
            }
       });
    });
</script>
</html>