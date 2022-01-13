<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }

    require_once('./admin/db.php'); 

    $user = $_SESSION['username'];

    if(isset($_POST['submit'])) {
        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
            $user_name = $_POST['name'];
            $user_email = $_POST['email'];
            $user_message = $_POST['message'];

            $data = addContact($user_name, $user_email, $user_message);
            if($data['code'] == 0) {
                $error = 'Cám ơn phản hồi của bạn';
            }
            else {
                $error = 'Có lỗi xảy ra';
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
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/contact.css">
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
                                    <a href="#">Liên hệ</a>
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
                                    <a href="#">Quản lý thực đơn</a>
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
    
    <header>
        <?php
            if(!empty($error)) {
                echo '<h1>'.$error.'</h1>';
            }
            else {
                echo '<h1>Contact us</h1>';
            }
        ?>
    </header>

    <div id="form">


    <form id="contactform" method="post">

        <div class="formgroup" id="name-form">
            <label for="name">Tên của bạn* </label>
            <input type="text" id="name" name="name" required/>
        </div>

        <div class="formgroup" id="email-form">
            <label for="email">Địa chỉ e-mail*</label>
            <input type="email" id="email" name="email" required/>
        </div>

        <div class="formgroup" id="message-form">
            <label for="message">Ý kiến đóng góp*</label>
            <textarea id="message" name="message" required></textarea>
        </div>

        <input name="submit" type="submit" value="Gửi ý kiến của bạn"/>  
    </form>
    </div>

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
</html>