<?php
    include 'dbConnect.php';
    session_start();
?>
<?php
    if ($result = mysqli_query($link, "SELECT * FROM game_info a LEFT JOIN (SELECT game_ID,round(AVG(deal_score),1) avg_score FROM deal_record GROUP BY game_ID) c ON a.game_ID = c.game_ID,game_pic b WHERE a.game_ID = b.game_ID")){
        while($row = mysqli_fetch_assoc($result)){
            if($_GET['game_ID'] == $row['game_ID']){
                $name = $row['game_name'];
                $developer = $row['game_developer'];
                $publisher = $row['game_publisher'];
                $date = $row['game_date'];
                $rate = $row['game_rating'];
                $story = $row['game_story'];
                $price = $row['game_price'];
                $pic = $row['game_picture'];    
                $discount = $row['game_discount'];
                $game_ID = $_GET['game_ID'];
                $score = $row['avg_score'];
                if($score=="")
                    $score=0;
            }
        }
    }

    
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="group_18 game deatils">    
    <meta name="keywords" content="game, group_18, shun, xian">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品頁面</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <script src="http://code.jquery.com/jquery-3.4.1.slim.js"></script>
    <!--additional method - for checkbox .. ,require_from_group method ...-->
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <!--中文錯誤訊息-->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/localization/messages_zh_TW.js "></script>

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/plyr.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">

</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="index.php">
                            <img src="img/logo.svg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="index.php">首頁</a></li>
                                <li><a href="categories.php">類別</a>
                                </li>
                                <?php 
                                    if(isset($_SESSION['admin_account'])) 
                                        echo '<li><a href="admin.php">管理員中心</a></li>';
                                    else
                                        echo '<li><a href="member-center-data.php">會員中心</a></li>';
                                ?>
                                <li><a href="customer.php">客服中心</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right">
                        <a href="#" class="search-switch"><span class="icon_search"></span></a>
                        <?php
                            if(isset($_SESSION['member_account'])){
                                echo '<a href="cart.php"><span class="icon_cart"></span>';
                                $TagResult = mysqli_query($link, "SELECT * FROM member_cart WHERE member_account = '". $_SESSION['member_account'] ."'") ;
                                $TagNum = mysqli_num_rows($TagResult); //查詢結果筆數
                                echo '<span class="header__right__cartTag">'.$TagNum.'</span></a>';
                            }
                            else{
                                echo '<a href="login.php"><span class="icon_cart"></span></a>';
                            }
                        ?>
                        <?php
                            if(isset($_SESSION['member_account'])||isset($_SESSION['admin_account'])){
                                echo '<a href="function.php?op=logout"><span class="fa fa-sign-out"></span></a>';
                            }
                            else{
                                echo '<a href="login.php"><span class="icon_profile"></span></a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="index.php"><i class="fa fa-home"></i> 首頁</a>
                        <a href="categories.php">類別</a>
                        <a href="categories.php"><span>休閒</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="game-details spad">
        <div class="container">
            <div class="game__details__content">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="game__details__pic set-bg" data-setbg="img/product/<?php echo $pic?>.jpg"></div>
                    </div>
                    <div class="col-lg-4">
                        <div class="game__details__text">
                            <div class="game__details__title">
                                <h3><?php echo $name ?></h3>
                            </div>
                            <div class="game__details__widget">
                                <div class="row">
                                    <div class="col-lg-12 col-md-6">
                                        <div class="game__item__tag">
                                            <ul>
                                                <li>
                                                    <span>類型:</span>
                                                    <?php 
                                                        if ($cateResult = mysqli_query($link, "SELECT * FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID")){
                                                            while ($categories = mysqli_fetch_assoc($cateResult)) {
                                                                if($_GET['game_ID'] == $categories["game_ID"]) echo '<a href="categories.php"><p>'.$categories["game_type"].'</p> </a>';
                                                            }  
                                                            mysqli_free_result($cateResult); // 釋放佔用的記憶體 
                                                        }       
                                                    ?>                                        
                                                </li>
                                            </ul>
                                        </div>
                                        <ul>
                                            <li><span>發行日期:</span><?php echo $date ?></li>
                                            <li><span>開發人員:</span> <?php echo $developer ?></li>
                                            <li><span>發行商:</span> <?php echo $publisher?></li>
                                            <li><span>支援語言:</span>
                                                <?php
                                                    if ($langResult = mysqli_query($link, "SELECT * FROM game_language a WHERE a.game_ID = '". $game_ID ."'")){
                                                        $lang_num = mysqli_num_rows($langResult); //查詢結果筆數
                                                        $lang_cnt = 0;
                                                        while ($lang = mysqli_fetch_assoc($langResult)) {
                                                                echo $lang["game_lang"];
                                                                if($lang_cnt != $lang_num - 1) echo'/';
                                                                $lang_cnt ++;
                                                        }  
                                                        mysqli_free_result($langResult); // 釋放佔用的記憶體 
                                                    } 
                                                ?>
                                            </li>
                                            <li><span>遊戲分級:</span> <?php echo $rate ?></li>
                                            <li><span>評分:</span><?php echo $score ?></li>
                                            <li><span>購買人數:</span> 
                                                <?php
                                                    $boughtflag=0;
                                                    if ($boughtResult = mysqli_query($link, "SELECT game_ID,count(*) count FROM deal_record GROUP BY game_ID")){
                                                        while ($people = mysqli_fetch_assoc($boughtResult)) {
                                                            if($_GET['game_ID'] == $people["game_ID"]) 
                                                            {    
                                                                echo " ". $people["count"];
                                                                $boughtflag = 1;
                                                            }
                                                        }  
                                                        mysqli_free_result($boughtResult); // 釋放佔用的記憶體
                                                    }
                                                    if($boughtflag == 0)
                                                        echo " 0";
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="game__details__text">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="section-title">
                                <h5>故事</h5>
                            </div>
                            <p><?php echo $story ?></p>
                        </div>
                        <div class="col-lg-4">
                            <div class="gameProduct__details__text">
                                <p>價格: 
                                    <?php 
                                        if($price == 0) echo "Free!"; 
                                        else if($discount!=0){
                                            $discount_price = round($price*$discount/100);
                                            echo '  
                                                <s> NT$ '.$price.'</s>
                                                -> NT$ '.$discount_price.'
                                                ';
                                        }
                                        else{ 
                                            echo '$NT '.$price;
                                        }  
                                    ?>
                                </p>
                                <div class="game__details__btn">
                                    <div class="row">
                                        <form action="function.php?op=followGame&game_ID=<?php echo $_GET["game_ID"]?>" method="post" id="followGame_form">
                                            <?php
                                                if(isset($_SESSION['member_account']))
                                                {
                                                    $follow_flag = false;
                                                    if ($result = mysqli_query($link, "SELECT * FROM member_follow")) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            if($row["member_account"] == $_SESSION['member_account'] && $row["game_ID"] == $_GET['game_ID']){
                                                                echo '<button class="follow-btn" id="follow__btn1" name="follow__btn1"><span>取消追隨</span></button>';
                                                                $follow_flag = true;
                                                            }
                                                        }
                                                        mysqli_free_result($result); // 釋放佔用的記憶體
                                                        if($follow_flag == false)
                                                            echo '<button class="follow-btn" id="follow__btn1" name="follow__btn1"><span>追隨</span></button>';
                                                    }
                                                }
                                                else{
                                                    echo '<button class="follow-btn" id="follow__btn1" name="follow__btn1"><span>追隨</span></button>';
                                                }
                                            ?>
                                        </form>
                                        <form action="function.php?op=addCart&game_ID=<?php echo $_GET["game_ID"]?>" method="post" id="addcart_form">
                                            <?php
                                                if(isset($_SESSION['member_account']))
                                                {
                                                    $addCart_flag = false;
                                                    if ($result = mysqli_query($link, "SELECT * FROM member_cart")) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            if($row["member_account"] == $_SESSION['member_account'] && $row["game_ID"] == $_GET['game_ID']){
                                                                echo '<button class="watch-btn" disabled="disabled" id="addCart_btn"><span>已加入購物車</span> <i class="fa fa-angle-right"></i></button>';
                                                                $addCart_flag = true;
                                                            }
                                                        }
                                                        mysqli_free_result($result); // 釋放佔用的記憶體
                                                    }
                                                    $bought_flag=false;
                                                    if ($result = mysqli_query($link, "SELECT * FROM deal_record")) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            if($row["member_account"] == $_SESSION['member_account'] && $row["game_ID"] == $_GET['game_ID']){
                                                                echo '<button class="watch-btn" disabled="disabled" id="addCart_btn"><span>已購買此遊戲</span> <i class="fa fa-angle-right"></i></button>';
                                                                $bought_flag = true;
                                                            }
                                                        }
                                                        mysqli_free_result($result); // 釋放佔用的記憶體
                                                    }
                                                    if($addCart_flag == false && $bought_flag == false)
                                                        echo '<button type="submit" class="watch-btn" id="addCart_btn"><span>加入購物車</span> <i class="fa fa-angle-right"></i></button>';
                                                }
                                                else{
                                                    echo '<button class="watch-btn" id="addCart_btn"><span>加入購物車</span> <i class="fa fa-angle-right"></i></button>';
                                                }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-8">
                    <div class="game__details__review">
                        <div class="section-title">
                            <h5>評論</h5>
                        </div>
                            <?php
                                $comment_count = 0;
                                $gameID = $_GET['game_ID'];
                                if ($result = mysqli_query($link, "SELECT * FROM member_comment ORDER BY comment_time")){
                                    while($row = mysqli_fetch_assoc($result)){
                                        if($_GET['game_ID'] == $row['game_ID']){
                                            echo ' <div class="game__review__item">
                                                        <div class="game__review__item__pic">
                                                            <img src="img/review/nlnlouo.jpg" alt="">
                                                        </div>
                                                        <div class="game__review__item__text">
                                                            <div class="row">
                                                                <div class="col-lg-10">
                                                                    <h6>'.$row["member_account"].' - <span>'.$row["comment_time"].'</span></h6>
                                                                    <p>'.$row["comment"].'</p>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <form action="function.php?op=deleteComment&game_ID='.$gameID.'" id="delete_form" method="post">
                                                                        <input type="hidden" value="'.$row["member_account"].'" name="account">
                                                                        <input type="hidden" value="'.$row["comment_time"].'" name="time" >
                                                                        <button type="submit" class="fa fa-trash-o" id="delete__btn" name="delete__btn"><span> 刪除</span></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                ';
                                        }
                                        $comment_count++;
                                    }
                                }
                            ?>
                        
                        
                    </div>
                    <div class="game__details__form">
                        <div class="section-title">
                            <h5>你的評論</h5>
                        </div>
                        <form action="function.php?op=addComment&game_ID=<?php echo $_GET["game_ID"]?>" id="addCommment_form" method="post">
                            <textarea id="comment" name="comment" placeholder="你的評論..."></textarea>
                            <button type="submit"><i class="fa fa-location-arrow"></i> 評論</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="game__details__sidebar">
                        <div class="section-title">
                            <h5>您可能會喜歡...</h5>
                        </div>
                        <?php 
                            if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID")) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $boughtflag=0;
                                    if( $row["game_ID"] == 1 || $row["game_ID"] == 2 || $row["game_ID"] == 9 || $row["game_ID"] == 10 ){
                                        echo '<a href="game-details.php?game_ID='. $row["game_ID"].'">
                                            <div class="product__mayLike__item set-bg" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                <div class="view"><i class="fa fa-download"></i> ';
                                                    if ($boughtResult = mysqli_query($link, "SELECT game_ID,count(*) count FROM deal_record GROUP BY game_ID")){
                                                        while ($people = mysqli_fetch_assoc($boughtResult)) {
                                                            if($row["game_ID"] == $people["game_ID"]) 
                                                            {    
                                                                echo " ". $people["count"];
                                                                $boughtflag = 1;
                                                            }
                                                        }  
                                                        mysqli_free_result($boughtResult); // 釋放佔用的記憶體
                                                    }
                                                    if($boughtflag == 0)
                                                        echo " 0";
                                                echo '</div>
                                            </div>
                                        </a>';
                                    }
                                }
                                mysqli_free_result($result); // 釋放佔用的記憶體
                            }
                        ?> 
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="page-up">
            <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="index.php"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="index.php">首頁</a></li>
                            <li><a href="categories.php">類別</a></li>
                            <?php
                                if(isset($_SESSION['member_account'])){
                                    echo '<li><a href="member-center-data.php">會員中心</a></li>';
                                }
                                else{
                                    echo '<li><a href="login.php">會員中心</a></li>';
                                }
                            ?>
                            <li><a href="customer.php">客服中心</a></li>
                            <li><a href="admin.php">管理員中心</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3">
                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>

                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->

     <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form" action="function.php?op=search" method="post">
                <input type="text" id="search-input" name="search-input" placeholder="請在這裡輸入搜尋內容">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>