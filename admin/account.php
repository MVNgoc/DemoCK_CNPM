<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: ../login.php');
        exit();
    }

    require_once('db.php'); 

    $user = $_SESSION['username'];
    if ($user != 'admin') {
        header('Location: ../index.php');
        exit();
    }

    if(isset($_POST['btn-delete-user'])) {
        $id = $_POST['btn-delete-user'];

        $sql = "DELETE FROM user WHERE id = '$id'";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->execute();
    }

    if(isset($_POST['btn-submit-user'])) {
        if(isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_pass']) && isset($_POST['user_cfpass'])
        && isset($_POST['user_phone']) && isset($_POST['user_address'])) {
            $user_name = $_POST['user_name'];
            $user_email = $_POST['user_email'];
            $user_pass = $_POST['user_pass'];
            $user_cfpass = $_POST['user_cfpass'];
            $user_phone = $_POST['user_phone'];
            $user_address = $_POST['user_address'];

            if(strlen($user_pass) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 kí tự';
            }
            else if($user_cfpass != $user_pass) {
                $error = 'Mật khẩu xác nhận không đúng';
            }
            else {
                $data = register($user_email, $user_cfpass, $user_name, $user_phone, $user_address);
                if($data['code'] == 0) {
                    //do nothing
                }
                else {
                    $error = 'Có lỗi xảy ra vui lòng thử lại sau';
                }
            }
        }   
    }

    if(isset($_POST['btn-edit-user'])) {
        if(isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_phone']) && isset($_POST['user_address'])) {
            $user_name = $_POST['user_name'];
            $user_email = $_POST['user_email'];
            $user_phone = $_POST['user_phone'];
            $user_address = $_POST['user_address'];
            $user_id = $_POST['btn-edit-user'];

            $data = updateAccount($user_id, $user_email, $user_name, $user_phone, $user_address);
            if($data['code'] == 0) {
                //do nothing
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/categories.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="../index.php" title="Logo">
                    <img src="../images/4aelogo.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <?php
                if($user != "admin") {
                    echo '<div class="menu text-right">
                            <ul>
                                <li>
                                    <a href="../index.php">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="#">Thực đơn</a>
                                </li>
                                <li>
                                    <a href="../contact.php">Liên hệ</a>
                                </li>
                                <li>
                                    <a  href="../changepass.php">Đổi mật khẩu</a>
                                </li>
                                <li>
                                    <a  href="../logout.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>';
                }
                else {
                    echo '<div class="menu text-right">
                            <ul>
                                <li>
                                    <a href="../categories.php">Quản lý thực đơn</a>
                                </li>
                                <li>
                                    <a href="#">Quản lý tài khoản</a>
                                </li>
                                <li>
                                    <a href="./contact_manager.php">Quản lý phản hồi</a>
                                </li>
                                <li>
                                    <a  href="../changepass.php">Đổi mật khẩu</a>
                                </li>
                                <li>
                                    <a href="../logout.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>';
                }
            ?>

            <div class="clearfix"></div>
        </div>
    </section>

    <section class="navbar">
        <div class="container">
            <h2 class="text-center">Danh sách tài khoản người dùng</h2>

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
                    <div class="btn-txt" >Thêm tài khoản</div>
                </button>
            </div>

            <?php
                selectAllUserAccount();
            ?>

            <div class="clearfix"></div>
        </div>
    </section>

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

    <div class="add-user-account">
        <form action="" method="POST" class="add-user-form" enctype="multipart/form-data">
            <i class="fa fa-close exit-icon"></i>
            <div class="input-form">
                <label class="user_lable" for="user_name">Họ và tên:</label>
                <input required="" type="text" class="user_name" name="user_name" placeholder="Họ và tên">

                <label class="user_lable" for="user_email">Email:</label>
                <input required="" type="text" class="user_email" name="user_email" placeholder="Email">

                <label class="user_lable" for="user_pass">Mật khẩu:</label>
                <input required="" type="password" class="user_pass" name="user_pass" placeholder="Mật khẩu (ít nhất 6 kí tự)">

                <label class="user_lable" for="user_cfpass">Nhập lại mật khẩu:</label>
                <input required="" type="password" class="user_cfpass" name="user_cfpass" placeholder="Nhập lại mật khẩu">

                <label class="user_lable" for="user_phone">Số điện thoại:</label>
                <input required="" type="tel" class="user_phone" name="user_phone" placeholder="Số điện thoại">

                <label class="user_lable" for="user_address">Địa chỉ:</label>
                <input required="" type="text" class="user_address" name="user_address" placeholder="Địa chỉ">
            </div>
            <div>
                <button class="btn-submit-user" name="btn-submit-user">
                    Thêm
                </button>
            </div>
        </form>
    </div>

    <div class="edit-user-account" id="edit-user-account">
        <form action="" method="POST" class="edit-user-form" enctype="multipart/form-data">
            <i class="fa fa-close exit-icon"></i>
            <div class="input-form">
                <label class="user_lable" for="user_name">Họ và tên:</label>
                <input required="" type="text" class="user_name" name="user_name" placeholder="Họ và tên">

                <label class="user_lable" for="user_email">Email:</label>
                <input required="" type="text" class="user_email" name="user_email" placeholder="Email">

                <label class="user_lable" for="user_phone">Số điện thoại:</label>
                <input required="" type="tel" class="user_phone" name="user_phone" placeholder="Số điện thoại">

                <label class="user_lable" for="user_address">Địa chỉ:</label>
                <input required="" type="text" class="user_address" name="user_address" placeholder="Địa chỉ">
            </div>
            <div>
                <button class="btn-submit-user" name="btn-edit-user">
                    Lưu
                </button>
            </div>
        </form>
    </div>
</body>

<script>
    $(document).ready(() => {
       const add_btn = $('.add-btn');
       const add_user_account = $('.add-user-account');
       const add_user_form = $('.add-user-form');
       const edit_user_account = $('.edit-user-account');
       const exit_icon = $('.exit-icon');
       const fix_icon = $('.btn-fix-user');

       add_btn.on('click', function() {
            add_user_account.toggleClass('open');
       })

       add_user_account.on('click', function() {
            add_user_account.toggleClass('open');
       })

       add_user_form.on('click', function(event) {
           event.stopPropagation();
       })

       exit_icon.on('click', function() {
            add_user_account.toggleClass('open');
            console.log('clicked');
       })

       $(document).on("click", '.edit-user-account', function() {
            $('.edit-user-account').removeClass('open');
        });

      $(document).on("click", '.edit-user-form', function(event) {
            event.stopPropagation();
      });

      $(document).on("click", '.exitIconEditUser', function(event) {
            $('.edit-user-account').removeClass('open');
      });

       fix_icon.on('click', function() {
        var id = this.value;
            if(id==""){
                document.getElementById("edit-user-account").innerHTML = "";
            }else{
                var myRequest = new XMLHttpRequest();
                myRequest.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("edit-user-account").innerHTML = this.responseText;
                    }
                };
                myRequest.open("GET","fix-account.php?id="+id,true);
                myRequest.send();
                edit_user_account.addClass('open');
            }
        })
    });
</script>

</html>