<?php

	#  https://www.w3schools.com/php/php_mysql_select.asp
 
    // $host = '127.0.0.1'; // tên mysql server
    // $user = 'root';
    // $pass = '';
    // $db = 'restaurant'; // tên databse
    // $conn = new mysqli($host, $user, $pass, $db);
    // $conn->set_charset("utf8");
    // if ($conn->connect_error) {
    //     die('Không thể kết nối database: ' . $conn->connect_error);
    // }
	// echo "success";

    function open_database() {
        $host = '127.0.0.1'; // tên mysql server
        $user = 'root';
        $pass = '';
        $db = 'restaurant'; // tên databse

        $cont = new mysqli($host, $user, $pass, $db);
        if($cont -> connect_error) {
            die('Connect error: ' . $cont->connect_error);
        }
        return $cont;
    }

	function login($user, $pass) {
		$sql = "SELECT * FROM user WHERE email = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if(!$stm->execute()) {
            return null;
        }

        $result = $stm->get_result();

        if($result->num_rows == 0) {
            return array('code' => 1, 'error' => 'Tài khoản không tồn tại'); // khong co user ton tai
        }

        $data = $result->fetch_assoc();

        $hashed_password = $data['pass'];   
        if(!password_verify($pass, $hashed_password)) {
            return array('code' => 2, 'error' => 'Sai mật khẩu'); 
        }
        else {
            return array('code' => 0, 'error' => '', 'data' => $data);
        }
	}

    function loginAdmin($user, $pass) {
		$sql = "SELECT * FROM admin_account WHERE username = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if(!$stm->execute()) {
            return null;
        }

        $result = $stm->get_result();

        if($result->num_rows == 0) {
            return array('code' => 1, 'error' => 'Tài khoản không tồn tại'); // khong co user ton tai
        }

        $data = $result->fetch_assoc();

        $hashed_password = $data['pass'];   
        if(!password_verify($pass, $hashed_password)) {
            return array('code' => 2, 'error' => 'Sai mật khẩu'); 
        }
        else {
            return array('code' => 0, 'error' => '', 'data' => $data);
        }
	}

    // function changeass($cfpass, $user) {
    //     $hash = password_hash($cfpass, PASSWORD_BCRYPT);
    //     $sql = "UPDATE account SET pass = ? WHERE username = ?";
    //     $conn = open_database();

    //     $stm = $conn->prepare($sql);
    //     $stm->bind_param('ss',$hash , $user);

    //     if(!$stm->execute()) {
    //         return array('code' => 2, 'error' => 'Can not execute command.');
    //     }

    //     return array('code' => 0, 'error' => 'Thay đổi mật khẩu thành công!.');
    // }

    function register($email, $pass, $username, $phone, $address){

        $hash = password_hash($pass, PASSWORD_BCRYPT);

        $sql = 'INSERT INTO user (email, pass, username, phone_number, user_address) values(?,?,?,?,?)';

        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('sssss',$email, $hash, $username, $phone, $address);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Success');
    }

    function addCategory($title, $featured) {
        $sql = 'INSERT INTO category (title, featured) VALUES (?, ?)';

        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$title, $featured);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Success');
    }   

    function selectAllCategory($user) {
        $sql = 'SELECT id, title, img_name, featured FROM category';

        $conn = open_database();
        $result = $conn-> query($sql);

        if($result->num_rows >0){
            foreach($result as $row) {
                    echo '<div class="box-3 float-container">
                            <img src="images/'.$row['img_name'].'" alt="'.$row['featured'].'" class="img-responsive img-curve">
            
                            <h3 class="float-text text-white">'.$row['title'].'</h3>

                            <div  class="btn-list float-text" style="display:flex;">';
                            echo '<form action="foods.php"  method="POST">';
                            echo '<button style="margin-right: 4px;" class="view-icon" name="view-icon" value="'. $row["id"] .'">
                                    <i class="fa fa-eye"></i>
                                </button>';
                                echo '</form>';
                                echo '<form action="categories.php" method="POST">';
                                if($user == 'admin') {
                                echo ' <button class="fix-icon" value="'. $row["id"] .'">
                                            <i class="fa fa-wrench"></i>
                                        </button>
                    
                                        <button class="delete-icon" name="delete-icon" value="'. $row["id"] .'">
                                            <i class="fa fa-trash"></i> 
                                        </button> ';
                                }
                             echo '
                            </div>         
                        </div>';
                    echo '</form>';
            }
        }
        $conn->close();
    }

    