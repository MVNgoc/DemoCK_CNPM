<?php
    require_once('./db.php');
    $id =  $_GET['id'] ;

    $sql = 'SELECT * FROM contact WHERE id = ?';

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
                        <form action="" class="view-contact-user-form" enctype="multipart/form-data">
                        <i class="fa fa-close exit-icon"></i>
                        <div class="view-form">
                            <div class="form-group">
                                <h4 class="user_lable" for="user_name">Họ và tên</h4>
                                <p>'.$data['username'].'</p>
                            </div>
                            
                            <div class="form-group">
                                <h4 class="user_lable" for="user_email">Email</h4>
                                <p>'.$data['useremail'].'</p>
                            </div>

                            <div class="form-group">
                                <h4 class="user_lable" for="user_phone">Ý kiến đóng góp</h4>
                                <p>'.$data['contributions'].'</p>
                            </div>  
                        </div>
                    </form>
                ';
           $conn->close();
?>