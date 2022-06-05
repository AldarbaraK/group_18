<?php 
	include 'dbConnect.php';

	$tmp_name = $_FILES['uploadImage']['tmp_name'];
	$id = $_POST['game_ID'];
	$oper = $_POST['oper'];

	if ($oper == 'update') {
		$fname = 'product_'.$id;
		$dest = 'img/product/'.$fname.'.jpg';		
	}
	else if($oper == 'insert'){
		$result = mysqli_query($link, "SELECT max(game_ID) FROM game_info");
		$row = mysqli_fetch_row($result);
		$last_ID = $row[0];
		$id = $last_ID;
		$fname = 'product_'.$id;
		$dest = 'img/product/'.$fname.'.jpg';
	}
	else{
		$a["code"] = 1;
        $a["message"] = 'oper錯誤';
        echo json_encode($a);
        exit;
	}	

	move_uploaded_file($tmp_name,$dest);
	$sql = "replace into game_pic VALUE('" . $id . "','" . $fname . "')";

	if (strlen($sql) > 10) {
        if ($result = mysqli_query($link, $sql)) {
              $a["code"] = 0;
              $a["message"] = '圖片上傳成功!';
        } else {
              $a["code"] = mysqli_errno($link);
              $a["message"] = "圖片上傳失敗!" . mysqli_error($link);
        }
        mysqli_close($link); // 關閉資料庫連結
        echo json_encode($a);
        exit;
    }   
?>