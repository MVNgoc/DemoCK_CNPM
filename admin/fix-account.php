<?php
    require_once('./db.php');
 	$id =  $_GET['id'] ;

 	$sql = 'SELECT * FROM user WHERE id = ?';

            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm->bind_param('s', $id);
            if(!$stm->execute()) {
                return "";
            }

            $result = $stm->get_result();

            if($result->num_rows == 0) {
                return "";
            }

            $data = $result->fetch_assoc();
            echo '
                     <form action="" method="POST" class="edit-user-form" enctype="multipart/form-data">
                         <i class="fa fa-close exit-icon exitIconEditUser"></i>
                         <div class="input-form">
                             <label class="user_lable" for="user_name">Họ và tên:</label>
                             <input required="" type="text" class="user_name" name="user_name" placeholder="'.$data["username"].'" value="'.$data["username"].'">

                             <label class="user_lable" for="user_email">Email:</label>
                             <input required="" type="text" class="user_email" name="user_email" placeholder="'.$data["email"].'" value="'.$data["email"].'">

                             <label class="user_lable" for="user_phone">Số điện thoại:</label>
                             <input required="" type="tel" class="user_phone" name="user_phone" placeholder="'.$data["phone_number"].'" value="'.$data["phone_number"].'">

                             <label class="user_lable" for="user_address">Địa chỉ:</label>
                             <input required="" type="text" class="user_address" name="user_address"  placeholder="'.$data["user_address"].'" value="'.$data["user_address"].'">
                         </div>
                         <div>
                             <button class="btn-submit-user" name="btn-edit-user" value="'.$data["id"].'">
                                 Lưu
                             </button>
                         </div>
                 ';
            $conn->close();
?>