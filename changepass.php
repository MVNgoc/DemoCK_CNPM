<?php
    require_once('./admin/db.php'); 
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    $user = $_SESSION['username'];
    $id_user = $_SESSION['id'];

    $user_newpass = '';
    $user_cfnewpass = '';

    if(isset($_POST['submitButton'])) {
        if(isset($_POST['password']) && isset($_POST['confirmPassword'])) {
            $user_newpass = $_POST['password'];
            $user_cfnewpass = $_POST['confirmPassword'];
           
            if($user_cfnewpass != $user_newpass) {
                $error = 'Mật khẩu xác nhân không đúng';
            }
            else {
                $data = changepass($user_cfnewpass, $id_user);
                if($data['code'] == 0) {
                    $error = $data['error'];
                }
                else {
                    $error = 'Có lỗi xảy ra vui lòng thử lại sau';
                }
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
                                    <a href="login.php">Trang chủ</a>
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

    <div class="mainDiv">
        <div class="cardStyle">
            <form action="" method="post" name="changePassForm" id="changePassForm">          
                
                <h2 class="formTitle">ĐỔI MẬT KHẨU</h2>
                
                <div class="inputDiv">
                    <label class="inputLabel" for="password">Mật khẩu mới</label>
                    <input value="<?=$user_newpass?>" type="password" id="password" name="password" required>
                </div>
                
                <div class="inputDiv">
                    <label class="inputLabel" for="confirmPassword">Xác nhận mật khẩu</label>
                    <input value="<?=$user_cfnewpass?>" type="password" id="confirmPassword" name="confirmPassword">
                </div>

                <?php
                    if(!empty($error)) {
                        echo '<div class="inputDiv">
                                <div class="error">'.$error.'</div>
                            </div>';
                    }
                ?>
                
                <div class="buttonWrapper">
                    <button type="submit" name="submitButton" id="submitButton" class="submitButton pure-button pure-button-primary">
                        <span>Xác nhận</span>
                    </button>
                </div>
                
            </form>
        </div>
    </div>

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