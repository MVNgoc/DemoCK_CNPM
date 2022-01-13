<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: ../login.php');
        exit();
    }

    require_once('./admin/db.php'); 
    $user = $_SESSION['username'];

    if(isset($_POST['order-now'])) {
        $id = $_POST['order-now'];
        $_SESSION['id_food'] = $id;
    }
    else {
        $id = $_SESSION['id_food'];
    }

    $sql = "SELECT title, img_food, price FROM food WHERE id = '$id'";
    $conn = open_database();
    $stm = $conn -> prepare($sql);
    $result = $conn-> query($sql);
    $row = $result->fetch_assoc();

    $food_name = $row['title'];
    $food_img = $row['img_food'];
    $food_price = $row['price'];

    if(isset($_POST['submit'])) {
        if(isset($_POST['full-name']) && isset($_POST['qty']) && isset($_POST['contact']) && isset($_POST['email']) &&
        isset($_POST['address'])) {
            $user_name = $_POST['full-name'];
            $number_food = $_POST['qty'];
            $user_contact = $_POST['contact'];
            $user_email = $_POST['email'];
            $user_address = $_POST['address'];
            $total_price = $food_price* $number_food;

            $data = createFoodOder($food_name, $food_img, $number_food, $user_name, $user_contact, $user_email, $user_address, $total_price);

            if($data['code'] == 0) {
                $success = 'Đơn hàng của bạn đã được xác nhận';
            }
            else {
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
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                                    <a href="categories.php">Thực đơn</a>
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
                                    <a href="./admin/contact_manager.php">Quản lý phản hồi</a>
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
    <section class="food-search">
        <div class="container">
            
            <?php
                if(!empty($success)) {
                    echo '<h2 class="text-center text-white">'.$success.'</h2>';
                }
                else {
                    echo '<h2 class="text-center text-white">Điền thông tin để xác nhận đơn đặt hàng của bạn</h2>';
                }
            ?>

            <form action="" class="order" method="post" >
                <fieldset>
                    <legend>Thông tin món ăn</legend>

                    <div class="food-menu-img">
                        <img src="images/<?= $food_img ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?= $food_name ?></h3>
                        <?php 
                            if(!empty($success)) {
                                echo '<p class="food-price" name="food-price" id="food-price">'. $total_price.' VNĐ</p>';
                            }
                            else {
                                echo '<p id="donGia" style="display: none"> '.$food_price.'</p>
                                <p class="food-price" name="food-price" id="food-price">'. $food_price.' VNĐ</p>';
                            }
                        ?>
   
                        <div class="order-label">Số lượng</div>
                        <?php 
                            if(!empty($success)) {
                                echo '<input type="number" id="qty" name="qty" min="1" max="100" class="input-responsive food_number" onchange="calculate()" value="'.$number_food.'" required readonly>';
                            }
                            else {
                                echo '<input type="number" id="qty" name="qty" min="1" max="100" class="input-responsive food_number" onchange="calculate()" value="1" required>';
                            }
                        ?>
                    
                    </input>

                </fieldset>
                
                <fieldset>
                    <legend>Thông tin chi tiết</legend>
                    <?php 
                        if(!empty($success)) {
                            echo '<div class="order-label">Họ và tên</div>
                            <input type="text" value="" name="full-name" placeholder="'.$user_name.'" class="input-responsive" required readonly>
        
                            <div class="order-label">Số điện thoại</div>
                            <input type="tel" value="" name="contact" placeholder="'. $user_contact .'" class="input-responsive" required readonly>
        
                            <div class="order-label">Địa chỉ email</div>
                            <input type="email" value="" name="email" placeholder="'. $user_email .'" class="input-responsive" required readonly>
        
                            <div class="order-label">Địa chỉ nhận hàng</div>
                            <textarea name="address" rows="10" placeholder="'.$user_address.'" class="input-responsive" required readonly></textarea>';
                        }
                        else {
                            echo '<div class="order-label">Họ và tên</div>
                            <input type="text" name="full-name" placeholder="Họ và tên" class="input-responsive" required>
        
                            <div class="order-label">Số điện thoại</div>
                            <input type="tel" name="contact" placeholder="Số điện thoại" class="input-responsive" required>
        
                            <div class="order-label">Địa chỉ email</div>
                            <input type="email" name="email" placeholder="Địa chỉ email" class="input-responsive" required>
        
                            <div class="order-label">Địa chỉ nhận hàng</div>
                            <textarea name="address" rows="10" placeholder="Địa chỉ nhận hàng" class="input-responsive" required></textarea>
        
                            <input type="submit" name="submit" value="Đặt hàng" class="btn btn-primary">';
                        }
                    ?>
                </fieldset>

            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- social Section Starts Here -->
    <section class="social">
        <div class="container text-center">
            
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
    function calculate() {
        var price = document.getElementById('donGia').innerHTML;
        var number = document.getElementById('qty').value;

        var total = price* number;

        document.getElementById('food-price').innerHTML = total + " VNĐ";
        return (total);
    }
</script>
</html>