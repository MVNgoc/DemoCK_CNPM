<?php
    require_once('./admin/db.php');
 	$id =  $_GET['id'] ;

 	$sql = 'SELECT title, img_name, featured FROM category WHERE id = ?';

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
                        <script>
                            function updateFilename(){
                                var fileInput = document.getElementById("imgCategoryInput");
                                document.getElementById("labelImgName").innerHTML=fileInput? fileInput.files[0].name  : "";
                            }
                        </script>
                        <form action="" method="POST" class="edit-category-food-form" enctype="multipart/form-data" id="formEdit">
                              <i class="fa fa-close exit-icon exitIconEdit"></i>
                              <div class="input-form">
                                  <label class="categoryfood_lable" for="categoryfood_name">Tên loại món:</label>
                                  <input required="" type="text" class="categoryfood_name" name="categoryfood_name" placeholder="'. $data["title"] .'" value="'. $data["title"] .'">

                                  <label class="categoryfood_lable" for="categoryfood_decription">Một vài mô tả:</label>
                                  <input required="" type="text" class="categoryfood_decription" name="categoryfood_decription" placeholder="'. $data["featured"] .'" value="'. $data["featured"] .'">

                                  <label class="categoryfood_lable" for="categoryfood_picture">Chọn hình ảnh:</label>
                                  <input style="display: none" id="imgCategoryInput" onchange="updateFilename()"  type="file" class="categoryfood_picture" name="categoryfood_picture" >
                                  <label for="imgCategoryInput" class="labelButton">Choose File</label><label style=" font-size: 13px; font-family: Arial, Helvetica, sans-serif;" id="labelImgName">'. $data["img_name"] .'</label>
                              </div>
                              <div>
                                  <button type="submit" form="formEdit" class="btn-submit-categoty" name="btn-edit-categoty" value="'.$id.'">
                                      Lưu
                                  </button>
                              </div>
                          </form>';
            $conn->close();
?>