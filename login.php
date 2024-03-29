<?php
    // kiểm tra nếu đã đăng nhập thì không thể truy cập lại trang login
	session_start();
    if (isset($_SESSION['username'])) {
        header('Location: index.php');
        exit();
    }

	if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
		$user = $_COOKIE['username'];
    $pass = $_COOKIE['password'];
	}
	else {
		$user = '';
		$pass = '';
	}
    $error = '';
    require_once('./admin/db.php'); 
    if(isset($_POST['username']) && isset($_POST['password'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $data = login($user, $pass);
        if($data['code'] == 0) {
            if(isset($_POST['remember'])) {
                //set cookie for 1 day
                setcookie('username', $user, time() + 3600 * 24);
                setcookie('password', $pass, time() + 3600 * 24);
            }
            $_SESSION['username'] = $user;
            $_SESSION['id'] = $data['id_user'];
            header('Location: index.php');
			exit();
        }
        else {
            $admin_data = loginAdmin($user, $pass);
            if($admin_data['code'] == 0) {
                if(isset($_POST['remember'])) {
                  //set cookie for 1 day
                  setcookie('username', $user, time() + 3600 * 24);
                  setcookie('password', $pass, time() + 3600 * 24);
                }
                $_SESSION['username'] = $user;
                $_SESSION['id'] = $data['id_user'];
                header('Location: index.php');
                exit();
            }
            else {
                $error = $data['error'];
            }
        }      
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Đăng nhập</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="container">
  <section id="content">
    <form action="" method="post">
      <h1>Đăng nhập</h1>
      <div>
        <input value="<?= $user ?>" type="text" name="username" placeholder="Email" required="" id="username" />
      </div>
      <div>
        <input value="<?= $pass ?>" type="password" name="password" placeholder="Mật khẩu" required="" id="password" />
      </div>
      <div class="row align-items-center remember" style="margin-top:10px; margin-left:36px; font-size: 14px;">
        <input id="remember" name="remember" type="checkbox">Ghi nhớ đăng nhập
    </div>
      <div>
        <input type="submit" value="Log in" />
        <a href="signup.php">Register</a>
      </div>
    </form><!-- form -->
    <div id="errorMessage" class="errorMessage my-3">
        <?php 
            if (!empty($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        ?>
    </div>
  </section><!-- content -->
</div><!-- container -->
</body>
</html>
