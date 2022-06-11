<?php
    include 'dbConnect.php';

    $op ='none';
    if(isset($_GET['op'])) $op = $_GET['op'];

    if($op=='checkLogin')
    {
        checkLogin($_POST['account'],$_POST['pwd']);
    }
    if($op=='checkGiftAccount')
    {
        checkGiftAccount($_POST['account'],$_POST['gift-target']);
    }

    if($op=='logout')
    {
        logout();
    }
    if($op=='addCart')
    {
        session_start();
        addCart($_SESSION['member_account'],$_GET['game_ID']);
    }
    if($op=='removeOneCart')
    {
        session_start();
        removeOneCart($_SESSION['member_account'],$_GET['game_ID']);
    }
    if($op=='removeAllCart')
    {
        session_start();
        removeAllCart($_SESSION['member_account'],$_GET['game_ID']);
    }
    if($op=='signUp')
    {
        SingUp($_POST['account'],$_POST['pwd'],$_POST['email'],$_POST['name'],$_POST['nickname'],$_POST['birthday'],$_POST['phone'],$_POST['sexRadio']);
    }
    if($op=='forget')
    {
        forgetCheck($_POST['account'], $_POST['email'],$_POST['phone'],$_POST['pwd']);
    }
    if($op=='forgetAccountEmailPhoneCheck')
    {
        forgetAEPCheck($_POST['account'],$_POST['email'],$_POST['phone']);
    }
    if($op=='addComment')
    {
        session_start();
        writeComment($_SESSION['member_account'],$_GET['game_ID'],$_POST['comment']);
    }
    if($op=='signupCheckAjax')
    {
        signupCheck($_POST['account']);
    }
    if($op=='accountCheckAjax')
    {
        accountCheck($_POST['account'],$_POST['pwd']);
    }
    if($op=='loginAccountAjax')
    {
        loginAccount();
    }
    if($op=='memberDataEdit')
    {
        session_start();
        memberDataEdit($_SESSION['member_account'],$_POST['email'],$_POST['pwd'],$_POST['name'],$_POST['nickname'],$_POST['ratedRadio'],$_POST['birth'],$_POST['phone']);
    }
    if($op=='selectGame')
    {
        session_start();
        if(isset($_POST['search_data'])){
            if(isset($_SESSION['member_account']))
                selectGameCount($_POST['select_price'],$_POST['select_type'],$_SESSION['member_account'],$_POST['search_data']);
            else
                selectGameCount($_POST['select_price'],$_POST['select_type'],"",$_POST['search_data']);
        }
        else{
            if(isset($_SESSION['member_account']))
                selectGameCount($_POST['select_price'],$_POST['select_type'],$_SESSION['member_account'],"");
            else
                selectGameCount($_POST['select_price'],$_POST['select_type'],"","");
        }
    }
    if($op=='followGame')
    {
        session_start();
        followGame($_SESSION['member_account'],$_GET['game_ID']);
    }
    if($op=='deleteComment')
    {
        deleteComment($_POST['account'],$_POST['time'],$_GET['game_ID']);
    }
    if($op=='search')
    {
        search($_POST['search-input']);
    }
    if($op=='addSelfProduct')
    {
        addSelfProduct($_POST['account']);
    }
    if($op=='addGiftProduct')
    {
        addGiftProduct($_POST['account'],$_POST['gift-target']);
    }

    function isStaff()
    {
        return isset($_SESSION['account']);
    }
    function logout()
    {
        session_start();
        session_destroy();
        header("Location:login.php");
    }
    function checkLogin($account, $password)
    {
        global $link;
        $memberQ = mysqli_query($link, "SELECT * FROM member_info WHERE member_account='$account'");

        $num = mysqli_num_rows($memberQ);

        if($num > 0){
            $member = mysqli_fetch_assoc($memberQ);
            if($account == $member['member_account'] && password_verify($password,$member['member_password']) )
            {       
                session_start();
                $_SESSION['member_account'] = $account;
                mysqli_query($link, "UPDATE member_details SET login_count=login_count+1 WHERE member_account='$account'");

                $bought_total=0;
                if ($dealResult = mysqli_query($link, "SELECT member_account,deal_price FROM deal_record")){
                    while($dealrow = mysqli_fetch_assoc($dealResult)){
                        if($account == $dealrow['member_account']){
                            $bought_total += $dealrow['deal_price'];
                        }
                    }
                }

                if ($Result = mysqli_query($link, "SELECT * FROM member_details WHERE member_account='$account'")){
                    while($row = mysqli_fetch_assoc($Result)){
                        if($bought_total > 12000 && $row['member_level'] == 2 || $row['member_level'] == 1){
                            mysqli_query($link, "UPDATE member_details SET member_level= 3 WHERE member_account='$account'");
                        }
                        else if($bought_total > 5000 && $row['member_level'] == 1){
                            mysqli_query($link, "UPDATE member_details SET member_level= 2 WHERE member_account='$account'");
                        }
                        else if($bought_total <= 5000 && $row['member_level'] == 1){
                            mysqli_query($link, "UPDATE member_details SET member_level= 1 WHERE member_account='$account'");
                        }
                    }
                }
                
                header("Location:index.php");
            }
            else
            {
                header("Location:login.php");
            }
        }


        $adminQ = mysqli_query($link, "SELECT * FROM admin_info WHERE admin_account='$account'");

        $num = mysqli_num_rows($adminQ);

        if($num > 0){
            $admin = mysqli_fetch_assoc($adminQ);
            if($account == $admin['admin_account'] && password_verify($password,$admin['admin_password']) )
            {       
                session_start();
                $_SESSION['admin_account'] = $account;

                header("Location:admin.php");
            }
            else
            {
                header("Location:login.php");
            }
        }

    }

    function addCart($account,$game_ID)
    {
        global $link;
        if(isset($account))
        {
            $sql = "insert into member_cart values ('" . $account . "','" . $game_ID ."')";
            mysqli_query($link, $sql);
            header("Location:game-details.php?game_ID=".$game_ID);
        }
        else{
            header("Location:login.php");
        }
    }

    function removeOneCart($account,$game_ID)
    {
        global $link;
        $sql = "delete from member_cart where game_ID = '". $game_ID ."' and member_account = '" . $account . "'";

        mysqli_query($link, $sql);

        header("Location:cart.php");
    }

    function removeAllCart($account,$game_ID)
    {
        global $link;
        $sql = "delete from member_cart where member_account = '" . $account . "'";

        mysqli_query($link, $sql);

        header("Location:cart.php");
    }

    function SingUp($account,$pwd,$email,$name,$nickname,$birthday,$phone,$sexRadio)
    {
        global $link;

        if ($result = mysqli_query($link, "SELECT member_account FROM member_info")) {
            while ($row = mysqli_fetch_assoc($result)) {
                if($row["member_account"] == $account){
                    header("Location:signup.php");
                }
            }
            mysqli_free_result($result); // 釋放佔用的記憶體
        }

        $today = date("Y-n-j");     //今天日期
        if( $sexRadio == "1")      //選radio button
            $sex = "男性";
        else    
            $sex = "女性";
        
        $password = password_hash($pwd, PASSWORD_BCRYPT);   //加密

        $sql = "insert into member_info values ('" . $account . "','" . $password ."','" . $email ."','" . $name ."','" . $nickname ."','" . $birthday ."','" . $phone ."','" . $today ."','" . $sex ."')";
        mysqli_query($link, $sql);
        header("Location:login.php");
    }

    function forgetCheck($account, $email, $phone, $pwd)
    {
        global $link;

        $flag = 0;

        $password = password_hash($pwd, PASSWORD_BCRYPT);   //加密

        if ($result = mysqli_query($link, "SELECT member_account,member_email,member_phone FROM member_info")) {
            while ($row = mysqli_fetch_assoc($result)) {
                if($row["member_account"] == $account && $row["member_email"] == $email && $row["member_phone"] == $phone){
                    $sql = "update member_info set member_password='" .$password. "' where member_account = '" . $account . "'";
                    $flag = 1;
                    mysqli_query($link, $sql);
                    header("Location:login.php");
                }
            }
            mysqli_free_result($result); // 釋放佔用的記憶體
        }

        if($flag == 0)
            header("Location:forget.php");
    }

    function writeComment($account,$game_ID,$comment)
    {
        global $link;

        if(isset($account))
        {
            $sql = "insert into member_comment values ('" . $game_ID . "','" . $account . "', NOW() ,'" . $comment ."')";

            mysqli_query($link, $sql);

            header("Location:game-details.php?game_ID=".$game_ID);
            
        }
        else{
            header("Location:login.php");
        }
    }

    function signupCheck($account)
    {
        global $link;
        
        $sql = "SELECT * FROM member_info where member_account='$account' ";
        $sql2 = "SELECT * FROM admin_info where admin_account='$account' ";

        if($account!="")
        {
            if(strlen($account)>=4 && strlen($account)<=24)
            {
                $isExist = false;
                if ( $result = mysqli_query($link, $sql) ) {
                    if($row = mysqli_fetch_assoc($result)) $isExist = true;           
                }
                if(!$isExist){
                    if ( $result = mysqli_query($link, $sql2) ) {
                        if($row = mysqli_fetch_assoc($result)) $isExist = true;          
                    }
                }
                if($isExist)
                    echo "此帳號已存在!";

                mysqli_free_result($result); // 釋放佔用的記憶體
                mysqli_close($link); // 關閉資料庫連結
            }
            else
                echo "";
        }
        else
            echo "";
    }

    function accountCheck($account,$pwd)
    {
        global $link;

        if($account!="")
        {
            if($pwd == "" || strlen($pwd) > 20 || strlen($pwd) < 8 )
                echo "";
            else if(strlen($account)>=4 && strlen($account)<=24)
            {
                $valid = true;
                if ( $result = mysqli_query($link, "SELECT * FROM member_info where member_account='$account'") ) {
                    if(!($row = mysqli_fetch_assoc($result))||!(password_verify($pwd,$row['member_password'])))
                        $valid = false;
                }
                if(!$valid){
                    if ( $result = mysqli_query($link, "SELECT * FROM admin_info where admin_account='$account'") ) {
                        if(!($row = mysqli_fetch_assoc($result))||!(password_verify($pwd,$row['admin_password'])))
                            $valid = false;
                        else
                            $valid = true;       
                    }
                }
                if(!$valid)
                    echo "此帳號不存在或密碼不正確!";
                
                mysqli_free_result($result); // 釋放佔用的記憶體
                mysqli_close($link); // 關閉資料庫連結
            }
            else
                echo "";
        }
        else
            echo "";

    }

    function loginAccount()
    {
        echo "";
    }

    function memberDataEdit($account,$email,$pwd,$name,$nickname,$ratedRadio,$birth,$phone)
    {
        global $link;
        
        if ($result = mysqli_query($link, "SELECT * FROM member_info")) {
            while($row = mysqli_fetch_assoc($result)) {
                if($row["member_account"] == $account){
                    if($email!="")
                    {
                        $sql = "update member_info set member_email='" .$email. "' where member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                    if($pwd!="")
                    {
                        $password = password_hash($pwd, PASSWORD_BCRYPT);   //加密
                        $sql = "update member_info set member_password='" .$password. "' where member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                    if($name!="")
                    {
                        $sql = "update member_info set member_name='" .$name. "' where member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                    if($nickname!="")
                    {
                        $sql = "update member_info set member_nickname='" .$nickname. "' where member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                    if($birth!="")
                    {
                        $sql = "update member_info set member_birth='" .$birth. "' where member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                    if($phone!="")
                    {
                        $sql = "update member_info set member_phone='" .$phone. "' where member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                    if($ratedRadio!="")
                    {
                        if($ratedRadio == "1")
                            $sex = "男性";
                        else if($ratedRadio == "2")
                            $sex = "女性";
                        $sql = "update member_info set member_sex='" .$sex. "' where member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                    
                }
            }
            mysqli_free_result($result); // 釋放佔用的記憶體
        }

        header("Location:member-center-data.php");

    }

    function selectGameCount($selectPrice,$selectType,$account,$search_data)
    {
        global $link;

        if($selectType != "all")
        {
            if($selectType == ".leisure")
                $type = "休閒";
            if($selectType == ".adventure")
                $type = "冒險";
            if($selectType == ".action")
                $type = "動作";
            if($selectType == ".tactic")
                $type = "策略";
            if($selectType == ".cardType")
                $type = "卡牌";
            if($selectType == ".car")
                $type = "汽機車模擬";
            if($selectType == ".terrible")
                $type = "恐怖";
            if($selectType == ".firstPerson")
                $type = "第一人稱";
            if($selectType == ".single")
                $type = "單人";
            if($selectType == ".multiperson")
                $type = "多人";
        }
        else
        {
            $type = "";
        }
        

        if($selectPrice == ".free")
        {
            if($selectType == "all")
            {
                if($search_data == "")
                    $sql = "select * from game_info where game_price='0'";
                else
                    $sql = "select * from game_info where game_price='0' and game_name like '%". $search_data ."%'";             
            }
            else
            {
                if($search_data == "")
                    $sql = "select a.game_ID from game_info a,game_categories b where a.game_ID = b.game_ID and game_price='0' and game_type='".$type."'";
                else
                    $sql = "select a.game_ID from game_info a,game_categories b where a.game_ID = b.game_ID and game_price='0' and game_type='".$type."' and game_name like '%". $search_data ."%'";
            }
            
        }
        else if($selectPrice == ".pay")
        {
            if($selectType == "all")
            {
                if($search_data == "")
                    $sql = "select * from game_info where game_price!='0'";
                else
                    $sql = "select * from game_info where game_price!='0' and game_name like '%". $search_data ."%'";
            }
            else
            {
                if($search_data == "")
                    $sql = "select a.game_ID from game_info a,game_categories b where a.game_ID = b.game_ID and game_price!='0' and game_type='".$type."'";
                else
                    $sql = "select a.game_ID from game_info a,game_categories b where a.game_ID = b.game_ID and game_price!='0' and game_type='".$type."' and game_name like '%". $search_data ."%'";
            }
        }
        else if($selectPrice == "all")
        {
            if($selectType == "all")
            {
                if($search_data == "")
                    $sql = "select * from game_info";
                else
                    $sql = "select * from game_info where game_name like '%". $search_data ."%'";
            }
            else
            {
                if($search_data == "")
                    $sql = "select a.game_ID from game_info a,game_categories b where a.game_ID = b.game_ID and game_type='".$type."'";
                else
                    $sql = "select a.game_ID from game_info a,game_categories b where a.game_ID = b.game_ID and game_type='".$type."' and game_name like '%". $search_data ."%'";
            }
        }
        else if($selectPrice == ".like")
        {
            if($selectType == "all")
            {
                if($search_data == "")
                    $sql = "select * from game_info a,member_follow b where a.game_ID = b.game_ID and member_account='".$account."'";
                else
                    $sql = "select * from game_info a,member_follow b where a.game_ID = b.game_ID and member_account='".$account."' and game_name like '%". $search_data ."%'";
            }
            else
            {
                if($search_data == ""){
                    "select * from game_info a,game_categories b,member_follow c where a.game_ID = b.game_ID and b.game_ID=c.game_ID and game_type='".$type."' and member_account='".$account."'";
                }
                else{
                    "select * from game_info a,game_categories b,member_follow c where a.game_ID = b.game_ID and b.game_ID=c.game_ID and game_type='".$type."' and member_account='".$account."' and game_name like '%". $search_data ."%'";
                }
            }
        }
        if(isset($sql)){
            if ($result = mysqli_query($link, $sql)) {
                $num = mysqli_num_rows($result);
                echo $num. " 筆結果";
                mysqli_free_result($result); // 釋放佔用的記憶體
            }
        }
    }

    function followGame($account, $game_ID)
    {
        global $link;

        if(isset($account))
        {
            $follow_flag=false;

            if ($result = mysqli_query($link, "SELECT * FROM member_follow")) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if($row["member_account"] == $account && $row["game_ID"] == $game_ID){
                        $follow_flag = true;
                    }
                }

                if($follow_flag == true)
                {
                    $sql = "delete from member_follow where member_account = '" . $account . "' and game_ID = '". $game_ID ."' ";
                    mysqli_query($link, $sql);
                }
                else
                {
                    $sql = "insert into member_follow values ('" . $account . "','" . $game_ID ."')";
                    mysqli_query($link, $sql);
                }

                mysqli_free_result($result); // 釋放佔用的記憶體
                header("Location:game-details.php?game_ID=".$game_ID);
            }
        }
        else{
            header("Location:login.php");
        }
        
    }

    function forgetAEPCheck($account, $email, $phone)
    {
        global $link;

        if($account!="")
        {
            if(strlen($account)>=4 && strlen($account)<=24)
            {
                if ( $result = mysqli_query($link, "SELECT * FROM member_info where member_account='$account'") ) {
                    if(!($row = mysqli_fetch_assoc($result))) echo "此帳號、電子信箱或電話不存在!";
                    else if($row['member_email'] != $email || $row['member_phone'] != $phone){
                        echo "此帳號、電子信箱或電話不存在!";
                    }
                    mysqli_free_result($result); // 釋放佔用的記憶體
                }
    
                mysqli_close($link); // 關閉資料庫連結
            }
            else
                echo "";
        }
        else
            echo "";
    }

    function deleteComment($account, $time, $game_ID)
    {
        global $link;

        if ($result = mysqli_query($link, "SELECT * FROM member_comment")) {
            while ($row = mysqli_fetch_assoc($result)) {
                if($row["member_account"] == $account && $row['game_ID'] == $game_ID && $row['comment_time'] == $time){
                    $sql = "delete from member_comment where game_ID = '". $game_ID ."' and member_account = '" . $account . "' and comment_time = '".$time."'";
                    mysqli_query($link, $sql);
                    header("Location:game-details.php?game_ID=".$game_ID);
                }
            }
            mysqli_free_result($result); // 釋放佔用的記憶體
        }

    }
    function search($input)
    {
        header("Location:categories.php?search=".$input);
    }

    function addSelfProduct($account)
    {
        global $link; 

        if($account!="")
        {
            if ($result = mysqli_query($link, "SELECT * FROM member_cart a,game_info b,member_details c WHERE a.game_ID = b.game_ID and a.member_account = c.member_account")) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if($row['member_account'] == $account)
                    {
                        if($row['game_discount']!=0){
                            $money = round($row['game_price']*$row['game_discount']/100);
                        }
                        else{ 
                            $money = $row['game_price'];
                        } 
                        if($row['member_level'] == 2)
                            $money = round($money*0.8);
                        else if($row['member_level'] == 3)
                            $money = round($money*0.85);

                        $sql = "insert into deal_record values ('" . $account . "','" . $row['game_ID'] ."','". NULL ."','". $money ."', NOW() )";
                        mysqli_query($link, $sql);
                        $sql = "update deal_record set deal_score=NULL where member_account='$account' and game_ID='".$row['game_ID']."'";
                        mysqli_query($link, $sql);
                        $sql = "insert into member_collection values ('" . $account . "','" . $row['game_ID'] ."')";
                        mysqli_query($link, $sql);
                        $sql = "delete from member_cart where game_ID = '". $row['game_ID'] ."' and member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                }
                mysqli_free_result($result); // 釋放佔用的記憶體
            }
            header("Location:categories.php");
        }
        else{
            header("Location:login.php");
        }

    }

    function addGiftProduct($account,$target)
    {
        global $link;
        
        if($target!="")
        {
            if ($result = mysqli_query($link, "SELECT * FROM member_cart a,game_info b,member_details c WHERE a.game_ID = b.game_ID and a.member_account = c.member_account")) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if($row['member_account'] == $account)
                    {
                        if($row['game_discount']!=0){
                            $money = round($row['game_price']*$row['game_discount']/100);
                        }
                        else{ 
                            $money = $row['game_price'];
                        } 
                        if($row['member_level'] == 2)
                            $money = round($money*0.8);
                        else if($row['member_level'] == 3)
                            $money = round($money*0.85);

                        $sql = "insert into deal_record values ('" . $target . "','" . $row['game_ID'] ."','". NULL ."','". $money ."', NOW() )";
                        mysqli_query($link, $sql);
                        $sql = "update deal_record set deal_score=NULL where member_account='$target' and game_ID='".$row['game_ID']."'";
                        mysqli_query($link, $sql);
                        $sql = "insert into member_collection values ('" . $target . "','" . $row['game_ID'] ."')";
                        mysqli_query($link, $sql);
                        $sql = "delete from member_cart where game_ID = '". $row['game_ID'] ."' and member_account = '" . $account . "'";
                        mysqli_query($link, $sql);
                    }
                }
                mysqli_free_result($result); // 釋放佔用的記憶體
            }
            header("Location:categories.php");
        }

    }

    function checkGiftAccount($account,$target)
    {
        global $link;
        if($target!="")
        {
            if(strlen($target)>=4 && strlen($target)<=24)
            {
                if ( $result = mysqli_query($link, "SELECT * FROM member_info where member_account='$target'") ) {
                    $num = mysqli_num_rows($result); //查詢結果筆數
                }
                if($num <= 0)
                    echo "贈送對象帳號不存在!";
                else{
                    if ( $result = mysqli_query($link, "SELECT * FROM member_collection a,member_cart b where a.member_account='$target' and b.member_account='$account' and a.game_ID=b.game_ID") ) {
                        $num2 = mysqli_num_rows($result); //查詢結果筆數
                    }
                    if($num2 > 0)
                        echo "贈送對象帳號已擁有!";
                }
                
                mysqli_free_result($result); // 釋放佔用的記憶體
                mysqli_close($link); // 關閉資料庫連結
            }
            else
                echo "";
        }
        else
            echo "";

    }

?>