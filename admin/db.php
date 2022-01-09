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
                            <img src="images/'.$row['img_name'].'" alt="'.$row['featured'].'" class="img-responsive img-curve img-categories">
            
                            <h3 class="float-text text-white">'.$row['title'].'</h3>

                            <div  class="btn-list float-text" style="display:flex;">';
                            echo '<form action="foods.php"  method="POST">';
                            echo '<button style="margin-right: 4px;" class="view-icon" name="view-icon" value="'. $row["title"] .'">
                                    <i class="fa fa-eye"></i>
                                </button>';
                                echo '</form>';
                                if($user == 'admin') {
                                echo ' <button style="margin-right: 4px;" id="fix-icon" class="fix-icon" name="fix-icon" value="'. $row["id"] .'">
                                            <i class="fa fa-wrench"></i>
                                        </button>';
                                        echo '<form action="categories.php" method="POST">';
                                echo      ' <button class="delete-icon" name="delete-icon" value="'. $row["id"] .'">
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

    function selectAllCategoryHome() {
        $sql = 'SELECT id, title, img_name, featured FROM category';

        $conn = open_database();
        $result = $conn-> query($sql);

        if($result->num_rows >0){
            foreach($result as $row) {
                    echo '<div class="box-3 float-container">
                            <img src="images/'.$row['img_name'].'" alt="Pizza" class="img-responsive img-curve">
            
                            <h3 class="float-text text-white">'.$row['title'].'</h3>
                        </div>';
            }
        }
        $conn->close();
    }

    function addFood($title, $description_food, $price, $category_name) {
        $sql = 'INSERT INTO food (title, description_food, price, category_name) VALUES (?, ?, ?, ?)';

        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ssis',$title, $description_food, $price, $category_name);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Can not excute command');
        }
        return array('code' => 0,'error' => 'Success');
    } 

    function selectAllFood($user, $category_name) {
        $sql = 'SELECT id, title, img_food, description_food, price FROM food WHERE category_name = ?';

        $conn = open_database();
        
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$category_name);
        if(!$stm->execute()){
            die('Query error: ' . $stm->error);
        }
        
        $result = $stm->get_result();

        if($result->num_rows >0){
            foreach($result as $row) {
                echo '
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <img src="images/'.$row['img_food'].'" alt="" class="img-responsive img-curve">
                    </div>
    
                    <div class="food-menu-desc">
                        <h4>'.$row['title'].'</h4>
                        <p class="food-price">'.$row['price'].' VND</p>
                        <p class="food-detail">
                            '.$row['description_food'].'
                        </p>
                        <br>';
                        if($user != "admin") {
                            echo '<form action="order.php" method="post">
                                    <button value="'. $row["id"] .'" href="order.php" class="btn btn-primary" name="order-now">Đặt ngay</button>
                                </form>';
                        }
                echo '   </div>';
                if($user == "admin") {
                    echo '<form action="foods.php" method="post">
                        <div class="btn-list">
                        <button value="'. $row["id"] .'" type="submit" style="margin-right: 4px;" id="fix-food-icon" class="fix-food-icon" name="fix-food-icon" >
                            <i class="fa fa-wrench"></i>
                        </button>
                        <button value="'. $row["id"] .'" type="submit" class="delete-food-icon" name="delete-food-icon" >
                            <i class="fa fa-trash"></i> 
                        </button>
                    </div>';
                }   
                    
            echo '</div>
            </form>';
            }
        }
        $conn->close();
    }

    function selectAllFoodHome() {
        $sql = 'SELECT id, title, img_food, description_food, price FROM food';

        $conn = open_database();
        
        $result = $conn-> query($sql);

        if($result->num_rows >0){
            foreach($result as $row) {
                echo '<form action="order.php" method="post">
                        <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <img src="images/'.$row['img_food'].'" alt="" class="img-responsive img-curve">
                                </div>

                                <div class="food-menu-desc">
                                    <h4>'.$row['title'].'</h4>
                                    <p class="food-price">'.$row['price'].' VND</p>
                                    <p class="food-detail">
                                        '.$row['description_food'].'
                                    </p>
                                    <br>
                                    <button type="submit" href="order.php" class="btn btn-primary" value="'. $row["id"] .'" name="order-now">Đặt ngay</button>                              
                                </div>
                            </div>
                    </form>';
            }
        }
        $conn->close();
    }

    function selectAllUserAccount() {
        $sql = 'SELECT id, email, username, phone_number, user_address FROM user';

        $conn = open_database();
        
        $result = $conn-> query($sql);
        $stt = 1;
        if($result->num_rows >0){
            foreach($result as $row) {
                echo '<div class="user_card">
                        <div class="infor_container">
                            <div class="info_user"><span style="font-weight:bold">'.$stt.'</span></div>
                            <div class="info_user"><span style="font-weight:bold">Tên:</span> '.$row['username'].'</div>
                            <div class="info_user"><span style="font-weight:bold">Email:</span> '.$row['email'].'</div>
                            <div class="info_user"> <span style="font-weight:bold">Số điện thoại:</span> '.$row['phone_number'].'</div>
                            <div class="info_user"> <span style="font-weight:bold">Địa chỉ:</span> '.$row['phone_number'].'</div>
                        </div>';
                
                    echo  '<form method="post" action="account.php">
                                <div class="btn_container">
                                    <button value="'. $row["id"] .'" class="btn-fix-user" name="btn-fix-user">
                                        <i class="fa fa-wrench"></i>
                                    </button>
                                    <button value="'. $row["id"] .'" class="btn-delete-user" name="btn-delete-user">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>  
                            </div>
                        </form>';            
                $stt++;
            }
        }
        $conn->close();
    }
?>  