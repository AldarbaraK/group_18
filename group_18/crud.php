<?php 
      include 'dbConnect.php';
      //一般控制項
      $arr_rated = array('G' => '普通級', 'PG' => '保護級', 'PG-13' => '輔導級', 'R' => '限制級');
      $arr_oper = array("insert" => "新增", "update" => "修改", "delete" => "刪除");
      $arr_type = array("gameTable" => "遊戲", "memberTable" => "會員", "dealTable" => "交易紀錄", "adminTable" => "管理員");
      $arr_lang = array(1 => "繁體中文", 2 => "英文", 3 => "日文");
      $arr_level = array(1 => "黃金會員", 2 => "白金會員", 3 => "鑽石會員");
      $arr_sex = array('M' => "男性", 'F' => "女性");
      $oper = $_POST['oper'];
      $type = $_POST['tableType'];
      //圖片控制項

      if ($oper == "query") {
            if($type == "gameTable"){
                  if ($result = mysqli_query($link, "SELECT * FROM game_info a LEFT JOIN (SELECT game_ID,round(AVG(deal_score),1) avg_score FROM deal_record GROUP BY game_ID) c ON a.game_ID = c.game_ID,game_pic b WHERE a.game_ID = b.game_ID")) {
                              while ($row = mysqli_fetch_assoc($result)) {
                                    if ($langResult = mysqli_query($link, "SELECT * FROM game_language a WHERE a.game_ID = '". $row["game_ID"] ."'")){
                                          $lang_num = mysqli_num_rows($langResult); //查詢結果筆數
                                          $lang_cnt = 0;
                                          $strlang = "";
                                          while ($lang = mysqli_fetch_assoc($langResult)) {
                                                $strlang .= $lang["game_lang"];
                                                if($lang_cnt != $lang_num - 1) $strlang .= '/';
                                                $lang_cnt ++;
                                          }  
                                          mysqli_free_result($langResult); // 釋放佔用的記憶體 
                                    }  
                                    $a['data'][] = array('<div class="image-view">
                                                            <img id="datatable-img'. $row["game_ID"].'" src="img/product/'. $row["game_picture"].'.jpg" alt="">
                                                      </div>',$row["game_ID"],$row["game_name"],$row["game_date"],$strlang,$row["game_rating"],$row["game_price"],$row["game_discount"],$row["avg_score"],$row["game_developer"],$row["game_publisher"],$row["game_story"],'<div class="dropdown">
                                                            <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown" id = "test">
                                                                  <i class="dw dw-more"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                  <a class="dropdown-item view-switch" href="#"><i class="dw dw-eye"></i> 預覽</a>
                                                                  <a class="dropdown-item edit-switch" href="#" id= "game_update"><i class="dw dw-edit2"></i> 編輯</a>
                                                                  <a class="dropdown-item" href="#" id="game_delete"><i class="dw dw-delete-3"></i> 刪除</a>
                                                            </div>
                                                      </div>');    
                              }
                  }            
                  mysqli_free_result($result); // 釋放佔用的記憶體
                  mysqli_close($link); // 關閉資料庫連結
                  echo json_encode($a);
                  exit;
            }
            else if($type == "memberTable"){
                  if ($result = mysqli_query($link, "SELECT * FROM member_info a,member_details b WHERE a.member_account = b.member_account")) {
                              while ($row = mysqli_fetch_assoc($result)) { 
                                    $a['data'][] = array($row["member_account"],$row["member_email"],$row["member_name"],$row["member_nickname"],$arr_level[$row["member_level"]],$row["member_sex"],$row["member_phone"],$row["member_birth"],$row["member_signupDate"],$row["member_password"],$row["bought_count"],$row["member_cost"],$row["login_count"],$row["score_count"],$row["comment_count"],'<div class="dropdown">
                                                                  <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown" id = "test">
                                                                        <i class="dw dw-more"></i>
                                                                  </a>
                                                                  <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                        <a class="dropdown-item edit-switch" href="#" id= "member_update"><i class="dw dw-edit2"></i> 編輯</a>
                                                                        <a class="dropdown-item" href="#" id="member_delete"><i class="dw dw-delete-3"></i> 刪除</a>
                                                                  </div>
                                                            </div>');    
                              }
                  }            
                  mysqli_free_result($result); // 釋放佔用的記憶體
                  mysqli_close($link); // 關閉資料庫連結
                  echo json_encode($a);
                  exit;
            }
            else if($type == "dealTable"){
                  if ($result = mysqli_query($link, "SELECT * FROM game_info a,deal_record b WHERE a.game_ID = b.game_ID")) {
                              while ($row = mysqli_fetch_assoc($result)) { 
                                    $a['data'][] = array($row["member_account"],$row["game_ID"],$row["game_name"],$row["deal_price"],$row["deal_score"],$row["deal_datetime"],'<div class="dropdown">
                                                                                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown" id = "test">
                                                                                                      <i class="dw dw-more"></i>
                                                                                                </a>
                                                                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                                                      <a class="dropdown-item" href="#" id="deal_delete"><i class="dw dw-delete-3"></i> 刪除</a>
                                                                                                </div>
                                                                                          </div>');    
                              }
                  }            
                  mysqli_free_result($result); // 釋放佔用的記憶體
                  mysqli_close($link); // 關閉資料庫連結
                  echo json_encode($a);
                  exit;
            }
            else if($type == "adminTable"){
                  if ($result = mysqli_query($link, "SELECT * FROM admin_info")) {
                              while ($row = mysqli_fetch_assoc($result)) { 
                                    $a['data'][] = array($row["admin_account"],$row["admin_email"],$row["admin_name"],$row["admin_phone"],$row["admin_insertDate"],$row["admin_password"],'<div class="dropdown">
                                                                                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                                                          <i class="dw dw-more"></i>
                                                                                    </a>
                                                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                                                                          <a class="dropdown-item edit-switch" href="#" id= "admin_update"><i class="dw dw-edit2"></i> 編輯</a>
                                                                                          <a class="dropdown-item" href="#" id="admin_delete"><i class="dw dw-delete-3"></i> 刪除</a>
                                                                                    </div>
                                                                              </div>');    
                              }
                  }            
                  mysqli_free_result($result); // 釋放佔用的記憶體
                  mysqli_close($link); // 關閉資料庫連結
                  echo json_encode($a);
                  exit;
            }
      }

      if ($oper == "insert") {
            if($type == "gameTable"){
                  $sql = "insert into game_info(game_name,game_date,game_rating,game_price,game_discount,game_developer,game_publisher,game_story) values ('" . $_POST['edit-game-name'] . "','" . $_POST['edit-game-date'] . "','" . $arr_rated[$_POST['game_rated']] . "','" . $_POST['edit-game-price'] . "','" . $_POST['edit-game-discount'] ."','" . $_POST['edit-game-developer'] ."','" . $_POST['edit-game-publisher'] ."','" . $_POST['edit-game-story'] ."')";
                  if (strlen($sql) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              $new_id = mysqli_insert_id($link);
                              $language = $_POST['game_lang'];
                              for($i = 0;$i < count($language);$i++){
                                    $sql2 = "insert into game_language(game_ID,game_lang) values ('" . $new_id . "','" . $arr_lang[$language[$i]] . "')";

                                    if (strlen($sql2) > 10) {
                                          if ($result2 = mysqli_query($link, $sql2)) {
                                                $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                                                $a["code"] = 0;
                                          } else {
                                                $a["code"] = mysqli_errno($link);
                                                $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                                          }
                                    }
                              }
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  }     
            }
            else if($type == "memberTable") {
                  $password = password_hash($_POST['edit-member-password'], PASSWORD_BCRYPT);
                  $sql = "insert into member_info(member_account,member_password,member_email,member_name,member_nickname,member_birth,member_phone,member_signupDate,member_sex) values ('" . $_POST['edit-member-account'] . "','" . $password . "','" . $_POST['edit-member-email'] . "','" . $_POST['edit-member-name'] . "','" . $_POST['edit-member-nickname'] ."','" . $_POST['edit-member-birth'] ."','" . $_POST['edit-member-phone'] ."', NOW() ,'" . $arr_sex[$_POST['edit-member-sex']] ."')";

                  $sql2 = "replace into member_details values ('" . $_POST['edit-member-account'] . "','" . $_POST['edit-member-level'] . "','" . 0 . "','" . 0 . "','" . 0 ."','" . 0 ."','" . 0 ."')"; 

                  if (strlen($sql) > 10 && strlen($sql2) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                              $a["code"] = 0;
                              
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        if ($result2 = mysqli_query($link, $sql2)) {
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                              $a["code"] = 0; 
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  }      
            }
            else if($type == "adminTable") {
                  $password = password_hash($_POST['edit-admin-password'], PASSWORD_BCRYPT);
                  $sql = "insert into admin_info(admin_account,admin_password,admin_email,admin_name,admin_phone,admin_insertDate) values ('" . $_POST['edit-admin-account'] . "','" . $password . "','" . $_POST['edit-admin-email'] . "','" . $_POST['edit-admin-name'] ."','" . $_POST['edit-admin-phone'] ."', NOW()" . ")";
                  if (strlen($sql) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                              $a["code"] = 0;
                              
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  }      
            }
      }

      if ($oper == "update") {
            if($type == "gameTable"){
                  $sql = "update game_info set game_name='" . $_POST['edit-game-name'] . "',game_date='" . $_POST['edit-game-date'] . "',game_rating='" . $arr_rated[$_POST['game_rated']] . "',game_price='" . $_POST['edit-game-price'] . "',game_discount='" . $_POST['edit-game-discount'] . "',game_developer='" . $_POST['edit-game-developer'] . "',game_publisher='" . $_POST['edit-game-publisher'] . "',game_story='" . $_POST['edit-game-story'] . "' where game_ID='" . $_POST['edit-game_ID'] . "'";
                  if(isset($_POST['game_lang'])){
                        $language = $_POST['game_lang'];
                        $not_lang = false;
                  }
                  else
                        $not_lang = true;

                  for($i = 1;$i <= 3;$i++){
                        $ischeck = false;
                        $checkLang = true;
                        if($not_lang){
                              $sql2 = "delete from game_language where game_ID='" . $_POST['edit-game_ID'] . "' and game_lang='" . $arr_lang[$i] . "'";
                        }
                        else{
                              for($j = 0;$j < count($language);$j++){
                                    if( $language[$j] == $i){
                                          $ischeck = true;
                                          break;
                                    }
                              }
                              if($ischeck){
                                    $sql2 = "replace into game_language VALUE('" . $_POST['edit-game_ID'] . "','" . $arr_lang[$i] . "')";
                              }
                              else{
                                    $sql2 = "delete from game_language where game_ID='" . $_POST['edit-game_ID'] . "' and game_lang='" . $arr_lang[$i] . "'";
                              }
                        }

                        if (strlen($sql2) > 10) {
                              if ($result2 = mysqli_query($link, $sql2)) {
                                    $a["code"] = 0;
                              } else {
                                    $checkLang = false;
                                    $a["code"] = mysqli_errno($link);
                              }
                        }
                  }
                  if (strlen($sql) > 10) {
                        if ($result = mysqli_query($link, $sql) && $checkLang) {
                              $a["code"] = 0;
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }

                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  }
            }
            else if($type == "memberTable") {
                  if($_POST['edit-member-password']!=''){
                        $password = password_hash($_POST['edit-member-password'], PASSWORD_BCRYPT);
                        $sql = "update member_info set member_password='" . $password . "',member_email='" . $_POST['edit-member-email'] . "',member_name='" . $_POST['edit-member-name'] . "',member_nickname='" . $_POST['edit-member-nickname'] . "',member_birth='" . $_POST['edit-member-birth'] . "',member_phone='" . $_POST['edit-member-phone'] . "',member_sex='" . $arr_sex[$_POST['edit-member-sex']] . "' where member_account='" . $_POST['old-member_account'] . "'";  
                  }
                  else{
                        $sql = "update member_info set member_email='" . $_POST['edit-member-email'] . "',member_name='" . $_POST['edit-member-name'] . "',member_nickname='" . $_POST['edit-member-nickname'] . "',member_birth='" . $_POST['edit-member-birth'] . "',member_phone='" . $_POST['edit-member-phone'] . "',member_sex='" . $arr_sex[$_POST['edit-member-sex']] . "' where member_account='" . $_POST['old-member_account'] . "'";
                  }
                  
                  $sql2 = "update member_details set member_level='" . $_POST['edit-member-level'] . "' where member_account='" . $_POST['old-member_account'] . "'";

                  if (strlen($sql) > 10 && strlen($sql2) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                              $a["code"] = 0;
                              
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        if ($result2 = mysqli_query($link, $sql2)) {
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                              $a["code"] = 0;
                              
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  }    
            }  
            else if($type == "adminTable") {
                  if($_POST['edit-admin-password']!=''){
                        $password = password_hash($_POST['edit-admin-password'], PASSWORD_BCRYPT);
                        $sql = "update admin_info set admin_password='" . $password . "',admin_email='" . $_POST['edit-admin-email'] . "',admin_name='" . $_POST['edit-admin-name'] . "',admin_phone='" . $_POST['edit-admin-phone'] . "' where admin_account='" . $_POST['old-admin_account'] . "'";  
                  }
                  else{
                        $sql = "update admin_info set admin_email='" . $_POST['edit-admin-email'] . "',admin_name='" . $_POST['edit-admin-name'] . "',admin_phone='" . $_POST['edit-admin-phone'] . "' where admin_account='" . $_POST['old-admin_account'] . "'";  
                  }

                  if (strlen($sql) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                              $a["code"] = 0;
                              
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  }    
            }          
      }

      if ($oper == "delete") {
            if($type == "gameTable"){
                  $sql = "delete from game_info where game_ID='" . $_POST['edit-game_ID'] . "'";
                  if (strlen($sql) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              if(is_file('./img/product/product_'.$_POST['edit-game_ID'].'.jpg')){
                                    unlink('./img/product/product_'.$_POST['edit-game_ID'].'.jpg');
                                    $a["code"] = 0;
                                    $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "成功!";
                              }
                              else{
                                    $a["code"] = 1;
                                    $a["message"] = "圖片刪除失敗!";
                              }
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = $arr_type[$type] . "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  } 
            }
            else if($type == "memberTable") {
                  $sql = "delete from member_info where member_account='" . $_POST['old-member_account'] . "'";
                  if (strlen($sql) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              $a["code"] = 0;
                              $a["message"] = "資料" . $arr_oper[$oper] . "成功!";
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  } 
            }
            else if($type == "dealTable"){
                  $sql = "delete from deal_record where member_account='" . $_POST['deal_member_account'] . "' and game_ID='" . $_POST['deal_game_ID'] . "'";
                  if (strlen($sql) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              $a["code"] = 0;
                              $a["message"] = "資料" . $arr_oper[$oper] . "成功!";
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  }
            }
            else if($type == "adminTable") {
                  $sql = "delete from admin_info where admin_account='" . $_POST['old-admin_account'] . "'";
                  if (strlen($sql) > 10) {
                        if ($result = mysqli_query($link, $sql)) {
                              $a["code"] = 0;
                              $a["message"] = "資料" . $arr_oper[$oper] . "成功!";
                        } else {
                              $a["code"] = mysqli_errno($link);
                              $a["message"] = "資料" . $arr_oper[$oper] . "失敗! <br> 錯誤訊息: " . mysqli_error($link);
                        }
                        mysqli_close($link); // 關閉資料庫連結
                        echo json_encode($a);
                        exit;
                  } 
            }
                
      }

?>