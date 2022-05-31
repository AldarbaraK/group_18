<?php 
      include 'dbConnect.php';

      $arr_sex = array('F' => '女', 'M' => '男');
      $arr_oper = array("insert" => "新增", "update" => "修改", "delete" => "刪除");
      $oper = $_POST['oper'];

      if ($oper == "insert") {
            $sql = "insert into students(stud_no,stud_name,stud_sex,stud_addr) values ('" . $_POST['stud_no'] . "','" . $_POST['stud_name'] . "','" . $_POST['stud_sex'] . "','" . $_POST['stud_addr'] . "')";
      }

      if ($oper == "update") {
            $sql = "update students set stud_name='" . $_POST['stud_name'] . "',stud_sex='" . $_POST['stud_sex'] . "',stud_addr='" . $_POST['stud_addr'] . "' where stud_no='" . $_POST['stud_no_old'] . "'";
      }

      if ($oper == "delete") {
            $sql = "delete from students where stud_no='" . $_POST['stud_no_old'] . "'";
      }

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


?>