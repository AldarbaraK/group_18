<?php
    include 'dbConnect.php';

    $op ='none';
    if(isset($_GET['op'])) $op = $_GET['op'];

    if($op=='checkLogin')
    {
        checkLogin($_POST['account'],$_POST['pwd']);
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
        selectGameCount($_POST['select_price'],$_POST['select_type']);
    }
    if($op=='headerSelectGame')
    {
        headerSelect();
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
        $memberQ = mysqli_query($link, "SELECT * FROM member_info WHERE member_account='".$account."'");

        $member = mysqli_fetch_assoc($memberQ);

        if($account == $member['member_account'] && password_verify($password,$member['member_password']) )
        {       
            session_start();
            $_SESSION['member_account'] = $account;

            header("Location:index.php");
        }
        else
        {
            header("Location:login.php");
        }
       
    }

    function addCart($account,$game_ID)
    {
        global $link;
        if(isset($account))
        {
            $sql = "insert into member_cart values ('" . $account . "','" . $game_ID ."')";

            if ($result = mysqli_query($link, "SELECT * FROM member_cart")) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if($row["member_account"] == $account && $row["game_ID"] == $game_ID){
                        header("Location:game-details.php?game_ID=".$game_ID);
                    }
                }
                mysqli_query($link, $sql);
                mysqli_free_result($result); // 釋放佔用的記憶體
                echo "已加入購物車";
                //header("Location:game-details.php?game_ID=".$game_ID);
            }
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
        
        if ( $result = mysqli_query($link, $sql) ) {
            if( $row = mysqli_fetch_assoc($result) ) echo "此帳號已存在!";
            mysqli_free_result($result); // 釋放佔用的記憶體
        }

        mysqli_close($link); // 關閉資料庫連結
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
                if ( $result = mysqli_query($link, "SELECT * FROM member_info where member_account='$account'") ) {
                    if(!($row = mysqli_fetch_assoc($result))||!(password_verify($pwd,$row['member_password']))) echo "此帳號不存在或密碼不正確!";
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

    function selectGameCount($selectPrice,$selectType)
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
                if ($result = mysqli_query($link, "SELECT * FROM game_info WHERE game_price='0'")) {
                    $num = mysqli_num_rows($result);
                    echo $num. " 筆結果";
                    mysqli_free_result($result); // 釋放佔用的記憶體
                }
            }
            else
            {
                if ($result = mysqli_query($link, "SELECT a.game_ID FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID and game_price='0' and game_type='".$type."'")) {
                    $num = mysqli_num_rows($result);
                    echo $num. " 筆結果";
                    mysqli_free_result($result); // 釋放佔用的記憶體
                }
            }
            
        }
        else if($selectPrice == ".pay")
        {
            if($selectType == "all")
            {
                if ($result = mysqli_query($link, "SELECT * FROM game_info WHERE game_price!='0'")) {
                    $num = mysqli_num_rows($result);
                    echo $num. " 筆結果";
                    mysqli_free_result($result); // 釋放佔用的記憶體
                }
            }
            else
            {
                if ($result = mysqli_query($link, "SELECT a.game_ID FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID and game_price!='0' and game_type='".$type."'")) {
                    $num = mysqli_num_rows($result);
                    echo $num. " 筆結果";
                    mysqli_free_result($result); // 釋放佔用的記憶體
                }
            }
        }
        else
        {
            if($selectType == "all")
            {
                if ($result = mysqli_query($link, "SELECT * FROM game_info")) {
                    $num = mysqli_num_rows($result);
                    echo $num. " 筆結果";
                    mysqli_free_result($result); // 釋放佔用的記憶體
                }
            }
            else
            {
                if ($result = mysqli_query($link, "SELECT a.game_ID FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID and game_type='".$type."'")) {
                    $num = mysqli_num_rows($result);
                    echo $num. " 筆結果";
                    mysqli_free_result($result); // 釋放佔用的記憶體
                }
            }
        }
    }

    function headerSelect()
    {
        global $link;

        echo "1111"; 
    }


?>