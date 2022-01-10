<?php
    require_once('./admin/db.php');
 	$id =  $_GET['id'] ;

 	$sql = 'SELECT * FROM food WHERE id = ?';

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
                                var fileInput = document.getElementById("imgFoodInput");
                                document.getElementById("labelImgName").innerHTML=fileInput? fileInput.files[0].name  : "";
                               const edit_category_food_form = $(".edit-category-food-form");

                            }
                        </script>
                        <form action="" method="POST" class="edit-food-form" enctype="multipart/form-data">
                              <i class="fa fa-close exit-icon exitIconEdit"></i>
                              <div class="input-form">
                                                      <label class="food_lable" for="food_name">Tên món:</label>
                                                      <input required="" type="text" class="food_name" name="food_name" placeholder="'.$data["title"].'" value="'.$data["title"].'">

                                                      <label class="food_lable" for="food_decription">Một vài mô tả:</label>
                                                      <input required="" type="text" class="food_decription" name="food_decription" placeholder="'.$data["description_food"].'" value="'.$data["description_food"].'">

                                                      <label class="food_lable" for="food_picture">Chọn hình ảnh:</label>
                                                    <input style="display: none" id="imgFoodInput" onchange="updateFilename()"  type="file" class="food_picture" name="food_picture" >
                                                    <label for="imgFoodInput" class="labelButton">Choose File</label><label style=" font-size: 13px; font-family: Arial, Helvetica, sans-serif;" id="labelImgName">'. $data["img_food"] .'</label>
                                                    <br><br>
                                                      <label class="food_lable" for="food_price">Giá:</label>
                                                      <input required="" type="number" class="food_price" name="food_price" placeholder="'.$data["price"].'" value="'.$data["price"].'">

                                                      <label class="food_lable" for="food_category">Kiểu món:</label>
                                                      <input value="'.$data["category_name"].'" required="" type="text" class="food_category" name="food_category" placeholder="Kiểu món" readonly>
                                                  </div>
                              <div>
                                  <button class="btn-submit-food" name="btn-edit-food" value="'.$id.'">
                                      Lưu
                                  </button>
                              </div>
                          </form>';
            $conn->close();
?>