<?php
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="group_18, GameStore homepage">
    <meta name="keywords" content="game, group_18, shun, xian">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>group_18</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

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
                                <li class="active"><a href="index.php">首頁</a></li>
                                <li><a href="categories.php">類別</a>
                                </li>
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
                            if(isset($_SESSION['member_account'])){
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

    <!-- hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="section-title">
                    <h3>精選商品</h3>
                </div>
            </div>
            <div class="hero__slider owl-carousel">
                <?php 
                    if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID ")) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            if($row["game_ID"] == 1 || $row["game_ID"] == 2 || $row["game_ID"] == 3){
                                echo '<div class="hero__items set-bg" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="hero__text">';
                                                    if ($cateResult = mysqli_query($link, "SELECT * FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID")){
                                                        while ($categories = mysqli_fetch_assoc($cateResult)) {
                                                            if($row["game_ID"] == $categories["game_ID"]) echo '<a href="categories.php"><div class="label">'. $categories["game_type"].'</div></a> ';
                                                        }  
                                                        mysqli_free_result($cateResult); // 釋放佔用的記憶體
                                                    }
                                                    echo '<a href="game-details.php?game_ID='. $row["game_ID"].'"><h2>'. $row["game_name"].'</h2></a>
                                                    <p></p>
                                                    <a href="game-details.php?game_ID='. $row["game_ID"].'"><span>立即查看</span> <i class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        }
                        $num = mysqli_num_rows($result); //查詢結果筆數
                        mysqli_free_result($result); // 釋放佔用的記憶體
                    }
                ?> 
            </div>
        </div>
    </section>
    <!-- hero Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="discount__product"> 
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>特別優惠</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="categories.php" class="primary-btn">更多 <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php 
                                if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID ORDER BY game_discount DESC")) {
                                    $count=0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $commentflag=0;
                                        $boughtflag=0;
                                        if($count>=6)
                                            break;
                                        echo '<div class="col-lg-4 col-md-6 col-sm-6">
                                                <div class="product__item">
                                                    <a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                        <div class="product__item__pic set-bg" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                            <div class="comment"><i class="fa fa-comments"></i>';
                                                                if ($commentResult = mysqli_query($link, "SELECT game_ID,count(*) count FROM member_comment GROUP BY game_ID")){
                                                                    while ($people = mysqli_fetch_assoc($commentResult)) {
                                                                        if($row["game_ID"] == $people["game_ID"]) 
                                                                        {   
                                                                            echo " ". $people["count"];
                                                                            $commentflag = 1;
                                                                        }
                                                                    }  
                                                                    mysqli_free_result($commentResult); // 釋放佔用的記憶體
                                                                }
                                                                if($commentflag == 0)
                                                                    echo " 0";
                                                            echo '</div>
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
                                                    </a>
                                                    <div class="product__item__text">
                                                        <ul>';
                                                            if ($cateResult = mysqli_query($link, "SELECT * FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID")){
                                                                while ($categories = mysqli_fetch_assoc($cateResult)) {
                                                                    if($row["game_ID"] == $categories["game_ID"]) echo '<a href="categories.php"><li>'. $categories["game_type"] .'</li> </a>';
                                                                }  
                                                                mysqli_free_result($cateResult); // 釋放佔用的記憶體
                                                            }
                                                        echo '</ul>
                                                        <h5><a href="game-details.php?game_ID='. $row["game_ID"].'">'. $row["game_name"].'</a></h5>
                                                    </div>
                                                </div>
                                            </div>';
                                        $count++;
                                    }
                                    $num = mysqli_num_rows($result); //查詢結果筆數
                                    mysqli_free_result($result); // 釋放佔用的記憶體
                                }
                            ?> 
                        </div>
                    </div>
                    
                    <div class="recent__product">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8">
                                <div class="section-title">
                                    <h4>最新上市</h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4">
                                <div class="btn__all">
                                    <a href="categories.php" class="primary-btn">更多 <span class="arrow_right"></span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php 
                                if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID ORDER BY game_date DESC")) {
                                    $count=0;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $commentflag=0;
                                        $boughtflag=0;
                                        if($count>=6)
                                            break;
                                        echo '<div class="col-lg-4 col-md-6 col-sm-6">
                                            <div class="product__item">
                                                <a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                    <div class="product__item__pic set-bg" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                        <div class="comment"><i class="fa fa-comments"></i>';
                                                            if ($commentResult = mysqli_query($link, "SELECT game_ID,count(*) count FROM member_comment GROUP BY game_ID")){
                                                                while ($people = mysqli_fetch_assoc($commentResult)) {
                                                                    if($row["game_ID"] == $people["game_ID"]) 
                                                                    {   
                                                                        echo " ". $people["count"];
                                                                        $commentflag = 1;
                                                                    }
                                                                }  
                                                                mysqli_free_result($commentResult); // 釋放佔用的記憶體
                                                            }
                                                            if($commentflag == 0)
                                                                echo " 0";
                                                        echo '</div>
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
                                                </a>
                                                <div class="product__item__text">
                                                    <ul>';
                                                        if ($cateResult = mysqli_query($link, "SELECT * FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID")){
                                                            while ($categories = mysqli_fetch_assoc($cateResult)) {
                                                                if($row["game_ID"] == $categories["game_ID"]) echo '<a href="categories.php"><li>'. $categories["game_type"] .'</li> </a>';
                                                            }  
                                                            mysqli_free_result($cateResult); // 釋放佔用的記憶體
                                                        }
                                                    echo '</ul>
                                                    <h5><a href="game-details.php?game_ID='. $row["game_ID"].'">'. $row["game_name"].'</a></h5>
                                                </div>
                                            </div>
                                        </div>';
                                        $count++;
                                        
                                    }
                                    $num = mysqli_num_rows($result); //查詢結果筆數
                                    mysqli_free_result($result); // 釋放佔用的記憶體
                                }
                            ?> 
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__top">
                        <div class="product__top__view">
                            <div class="section-title">
                                <h5>暢銷商品</h5>
                            </div>
                            <ul class="filter__controls">
                                <li class="active" data-filter="*">日</li>
                                <li data-filter=".week">週</li>
                                <li data-filter=".month">月</li>
                                <li data-filter=".years">年</li>
                            </ul>
                            <div class="filter__gallery">
                                <?php 
                                    if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID")) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $boughtflag=0;
                                            if( $row["game_ID"] == 1){
                                                echo '<a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                        <div class="product__top__view__item set-bg mix day years" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                            <div class="download"><i class="fa fa-download"></i> ';
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
                                                            <h5>'. $row["game_name"].'</h5>
                                                        </div>
                                                    </a>';
                                            }
                                            else if( $row["game_ID"] == 2){
                                                echo '<a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                        <div class="product__top__view__item set-bg mix month week" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                            <div class="download"><i class="fa fa-download"></i> ';
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
                                                            <h5>'. $row["game_name"].'</h5>
                                                        </div>
                                                    </a>';
                                            }
                                            else if( $row["game_ID"] == 9){
                                                echo '<a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                        <div class="product__top__view__item set-bg mix week years" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                            <div class="download"><i class="fa fa-download"></i> ';
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
                                                            <h5>'. $row["game_name"].'</h5>
                                                        </div>
                                                    </a>';
                                            }
                                            else if( $row["game_ID"] == 10){
                                                echo '<a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                        <div class="product__top__view__item set-bg mix month years" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                            <div class="download"><i class="fa fa-download"></i> ';
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
                                                            <h5>'. $row["game_name"].'</h5>
                                                        </div>
                                                    </a>';
                                            }
                                            else if( $row["game_ID"] == 25){
                                                echo '<a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                        <div class="product__top__view__item set-bg mix day " data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                            <div class="download"><i class="fa fa-download"></i> ';
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
                                                            <h5>'. $row["game_name"].'</h5>
                                                        </div>
                                                    </a>';
                                            }
                                        }
                                        $num = mysqli_num_rows($result); //查詢結果筆數
                                        mysqli_free_result($result); // 釋放佔用的記憶體
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="product__recommand__comment">
                            <div class="section-title">
                                <h5>推薦給您</h5>
                            </div>
                            <?php 
                                if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID")) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $boughtflag=0;
                                        if( $row["game_ID"] == 26 || $row["game_ID"] == 27 || $row["game_ID"] == 28 || $row["game_ID"] == 29 ){
                                            echo '<div class="product__recommand__comment__item">
                                                    <div class="product__recommand__comment__item__pic" >
                                                        <a href="game-details.php?game_ID='. $row["game_ID"].'"><img src="img/product/'. $row["game_picture"].'.jpg" alt=""></a>
                                                    </div>
                                                    <div class="product__recommand__comment__item__text">
                                                        <ul>';
                                                            if ($cateResult = mysqli_query($link, "SELECT * FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID")){
                                                                while ($categories = mysqli_fetch_assoc($cateResult)) {
                                                                    if($row["game_ID"] == $categories["game_ID"]) echo '<a href="categories.php"><li>'. $categories["game_type"] .'</li> </a>';
                                                                }  
                                                                mysqli_free_result($cateResult); // 釋放佔用的記憶體
                                                            }
                                                        echo '</ul>
                                                        <h5><a href="game-details.php?game_ID='. $row["game_ID"].'">'. $row["game_name"].'</h5>
                                                        <div class="recommandProduct__item__pic set-bg">
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
                                                    </div>
                                                </div>';
                                        }
                                    }
                                    $num = mysqli_num_rows($result); //查詢結果筆數
                                    mysqli_free_result($result); // 釋放佔用的記憶體
                                }
                            ?> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="all__product">
                    <div class="row">
                        <div class="col-lg-10 col-md-10 col-sm-10">
                            <div class="section-title">
                                <h4>所有遊戲　　</h4>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <div class="btn__all">
                                <a href="categories.php" class="primary-btn">更多 <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php 
                            if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID")) {
                                $count=0;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $commentflag=0;
                                    $boughtflag=0;
                                    if($count>=8)
                                            break;
                                    echo '<div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="product__item">
                                            <a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                <div class="product__item__pic set-bg" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                    <div class="comment"><i class="fa fa-comments"></i>';
                                                        if ($commentResult = mysqli_query($link, "SELECT game_ID,count(*) count FROM member_comment GROUP BY game_ID")){
                                                            while ($people = mysqli_fetch_assoc($commentResult)) {
                                                                if($row["game_ID"] == $people["game_ID"]) 
                                                                {   
                                                                    echo " ". $people["count"];
                                                                    $commentflag = 1;
                                                                }
                                                            }  
                                                            mysqli_free_result($commentResult); // 釋放佔用的記憶體
                                                        }
                                                        if($commentflag == 0)
                                                            echo " 0";
                                                    echo '</div>
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
                                            </a>
                                            <div class="product__item__text">
                                                <ul>';
                                                    if ($cateResult = mysqli_query($link, "SELECT * FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID")){
                                                        while ($categories = mysqli_fetch_assoc($cateResult)) {
                                                            if($row["game_ID"] == $categories["game_ID"]) echo '<a href="categories.php"><li>'. $categories["game_type"] .'</li> </a>';
                                                        }  
                                                        mysqli_free_result($cateResult); // 釋放佔用的記憶體
                                                    }
                                                echo '</ul>
                                                <h5><a href="game-details.php?game_ID='. $row["game_ID"].'">'. $row["game_name"].'</a></h5>
                                            </div>
                                        </div>
                                    </div>';
                                    $count++;
                                    /*if( $row["game_ID"] == 17 || $row["game_ID"] == 18 || $row["game_ID"] == 19 || $row["game_ID"] == 20 || $row["game_ID"] == 21 || $row["game_ID"] == 22 || $row["game_ID"] == 23 || $row["game_ID"] == 24){
                                        echo '<div class="col-lg-3 col-md-6 col-sm-6">
                                                <div class="product__item">
                                                    <a href="game-details.php?game_ID='. $row["game_ID"].'">
                                                        <div class="product__item__pic set-bg" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                            <div class="comment"><i class="fa fa-comments"></i>';
                                                                if ($commentResult = mysqli_query($link, "SELECT game_ID,count(*) count FROM member_comment GROUP BY game_ID")){
                                                                    while ($people = mysqli_fetch_assoc($commentResult)) {
                                                                        if($row["game_ID"] == $people["game_ID"]) 
                                                                        {   
                                                                            echo " ". $people["count"];
                                                                            $commentflag = 1;
                                                                        }
                                                                    }  
                                                                    mysqli_free_result($commentResult); // 釋放佔用的記憶體
                                                                }
                                                                if($commentflag == 0)
                                                                    echo " 0";
                                                            echo '</div>
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
                                                    </a>
                                                    <div class="product__item__text">
                                                        <ul>';
                                                            if ($cateResult = mysqli_query($link, "SELECT * FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID")){
                                                                while ($categories = mysqli_fetch_assoc($cateResult)) {
                                                                    if($row["game_ID"] == $categories["game_ID"]) echo '<a href="categories.php"><li>'. $categories["game_type"] .'</li> </a>';
                                                                }  
                                                                mysqli_free_result($cateResult); // 釋放佔用的記憶體
                                                            }
                                                        echo '</ul>
                                                        <h5><a href="game-details.php?game_ID='. $row["game_ID"].'">'. $row["game_name"].'</a></h5>
                                                    </div>
                                                </div>
                                            </div>';
                                    }*/
                                }
                                $num = mysqli_num_rows($result); //查詢結果筆數
                                mysqli_free_result($result); // 釋放佔用的記憶體
                            }
                        ?> 
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->

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
                            <li><a href="member-center-data.php">會員中心</a></li>
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