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
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="../css/style.css">
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

            <?php
                selectAllUserAccount();
            ?>

            <div class="clearfix"></div>
        </div>
    </section>
</html>