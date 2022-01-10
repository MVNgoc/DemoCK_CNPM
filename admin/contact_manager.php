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
    
    if(isset($_POST['btn-delete-contact'])) {
        $id = $_POST['btn-delete-contact'];

        $sql = "DELETE FROM contact WHERE id = '$id'";
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
                                    <a href="../categories">Thực đơn</a>
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
                                    <a href="./account.php">Quản lý tài khoản</a>
                                </li>
                                <li>
                                    <a href="#">Quản lý phản hồi</a>
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
            <h2 class="text-center">Danh sách các phản hồi từ khách hàng</h2>

            <?php
                selectAllContact();
            ?>
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

    <div class="view-contact-user" id="view-contact-user">
        <form action="" class="view-contact-user-form" enctype="multipart/form-data">
            <i class="fa fa-close exit-icon"></i>
            <div class="view-form">
                <div class="form-group">
                    <h4 class="user_lable" for="user_name">Họ và tên</h4>
                    <p>Mai Văn Ngọc</p>
                </div>
                
                <div class="form-group">
                    <h4 class="user_lable" for="user_email">Email</h4>
                    <p>mvngoc@gmail.com</p>
                </div>

                <div class="form-group">
                    <h4 class="user_lable" for="user_phone">Ý kiến đóng góp</h4>
                    <p>ngonnnn</p>
                </div>  
            </div>
        </form>
    </div>

</body>

<script>

    $(document).ready(() => {
        const view_contact_user = $('.view-contact-user');
        const btn_view_contact = $('.btn-view-contact');

        $(document).on("click", '.view-contact-user', function() {
            $('.view-contact-user').removeClass('open');
        });

        $(document).on("click", '.view-contact-user-form', function(event) {
            event.stopPropagation();
        });

        $(document).on("click", '.exit-icon', function() {
            $('.view-contact-user').removeClass('open');
        });

        btn_view_contact.on('click', function() {
        var id = this.value;
            if(id == ""){
                document.getElementById("view-contact-user").innerHTML = "";
            }else{
                var myRequest = new XMLHttpRequest();
                myRequest.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("view-contact-user").innerHTML = this.responseText;
                    }
                };
                myRequest.open("GET","view_contact.php?id="+id,true);
                myRequest.send();
                view_contact_user.addClass('open');
            }
        })
    });

</script>

</html>