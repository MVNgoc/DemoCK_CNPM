<?php
  require_once('./admin/db.php');
  $error = '';
  $username = '';
  $email = '';
  $pass = '';
  $cfpass = '';
  $tel = '';
  $address = '';

  if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pass']) && isset($_POST['cfpass']) &&
  isset($_POST['tel']) && isset($_POST['address'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cfpass = $_POST['cfpass'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];

    if($pass != $cfpass) {
      $error = "Mật khẩu xác nhận không khớp với mật khẩu vừa nhập";
    }
    else {
      $data = register($email, $pass, $username, $tel, $address);
      if($data['code'] == 0) {
        $error = $data['error'];
        header('Location: index.php');
        exit();
      }
      else {
        $error = 'Có lỗi xãy ra vui lòng thử lại sau';
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Đăng ký</title>
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
      <h1>Đăng ký</h1>
      <div>
        <input value="<?= $username ?>" type="text" name="username" placeholder="Họ và tên" required="" id="username" />
      </div>
      <div>
        <input value="<?= $email ?>" type="email" name="email" placeholder="Email" required="" id="email" />
      </div>
      <div>
        <input value="<?= $pass ?>" type="password" name="pass" placeholder="Mật khẩu" required="" id="password" />
      </div>
      <div>
        <input value="<?= $cfpass ?>" type="password" name="cfpass" placeholder="Nhập lại mật khẩu" required="" id="cfpassword" />
      </div>
      <div>
        <input value="<?= $tel ?>" type="tel" name="tel" placeholder="Số điện thoại" required="" id="tel" />
      </div>
      <div>
        <input value="<?= $address ?>" type="text" name="address" placeholder="Địa chỉ" required="" id="address" />
      </div>
      <div id="errorMessage" class="errorMessage my-3">
        <?php 
            if (!empty($error)) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        ?>
      </div>
      <div>
        <input type="submit" value="Sign Up" />
      </div>
    </form><!-- form -->
    
  </section><!-- content -->
</div><!-- container -->
</body>
</html>
