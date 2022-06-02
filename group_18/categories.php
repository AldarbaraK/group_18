<?php
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="group_18, all game & categories">
    <meta name="keywords" content="game, group_18, shun, xian">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>所有遊戲</title>

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
                                <li><a href="index.php">首頁</a></li>
                                <li class="active"><a href="categories.php">類別 <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="categories.php">休閒</a></li>
                                        <li><a href="categories.php">冒險</a></li>
                                        <li><a href="categories.php">動作</a></li>
                                        <li><a href="categories.php">多人</a></li>
                                        <li><a href="categories.php">策略</a></li>
                                        <li><a href="categories.php">競速</a></li>
                                        <li><a href="categories.php">運動</a></li>
                                        <li><a href="categories.php">卡牌</a></li>
                                    </ul>
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

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="index.php"><i class="fa fa-home"></i> 首頁</a>
                        <label style="color:white" id="path">所有遊戲</label>
                        <label style="color:white">&nbsp<i class="fa fa-angle-right"></i>&nbsp</label>
                        <label style="color:white" id="type_path">所有類型</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <form name="select_form" method="post" id="select_form">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="categories__page__filter">
                                    <div class="categories__page__filter__space">
                                        <p>篩選:</p>
                                        <select name="select_price" class="filter__price" id="select_price">
                                            <option value="all">所有遊戲</option>
                                            <option value=".free">免費遊戲</option>
                                            <option value=".pay">付費遊戲</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="categories__page__filter">
                                    <div class="categories__page__filter__space">
                                        <p>排序:</p>
                                        <select class="filter__sort">
                                            <option value="">選擇排序</option>
                                            <option value="name:asc">名字排序</option>
                                            <option value="sell:desc">最熱銷</option>
                                            <option value="date:asc">發行日期</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="categories__page__filter">
                                    <div class="categories__page__filter__space">
                                        <p>類型:</p>
                                        <select name="select_type" class="filter__select" id="select_type">
                                            <option value="all">選擇類型</option>
                                            <option value=".leisure">休閒</option>
                                            <option value=".adventure">冒險</option>
                                            <option value=".action">動作</option>
                                            <option value=".tactic">策略</option>
                                            <option value=".cardType">卡牌</option>
                                            <option value=".car">汽機車模擬</option>
                                            <option value=".terrible">恐怖</option>
                                            <option value=".firstPerson">第一人稱</option>
                                            <option value=".single">單人</option>
                                            <option value=".multiperson">多人</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="categories__item">
                        <!--<p>
                            <?php 
                                /*if ($result = mysqli_query($link, "SELECT * FROM game_info")) 
                                    $num = mysqli_num_rows($result); //查詢結果筆數
                                echo $num */
                            ?> 筆結果
                        </p>-->
                        <p id="show_msg" style="color:white">
                            <?php 
                                if ($result = mysqli_query($link, "SELECT * FROM game_info")) 
                                    $num = mysqli_num_rows($result); //查詢結果筆數
                                echo $num 
                            ?> 筆結果
                        </p>
                        <p id="show_msg2" style="color: white"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Section Begin -->
    <section class="product-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4>所有遊戲</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row filter__game">
                            <?php 
                                if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID")) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $commentflag=0;
                                        $boughtflag=0;  
                                        echo '<div class="col-lg-3 col-md-6 col-sm-6 mix';
                                                if ($typeRes = mysqli_query($link, "SELECT * FROM game_info a,game_categories b WHERE a.game_ID = b.game_ID")){
                                                    while ($type = mysqli_fetch_assoc($typeRes)) {
                                                        if($row["game_ID"] == $type["game_ID"]) {
                                                            if($type["game_type"] == "休閒")
                                                                echo " leisure";
                                                            if($type["game_type"] == "冒險")
                                                                echo " adventure";
                                                            if($type["game_type"] == "動作")
                                                                echo " action";
                                                            if($type["game_type"] == "策略")
                                                                echo " tactic";
                                                            if($type["game_type"] == "卡牌")
                                                                echo " cardType";
                                                            if($type["game_type"] == "汽機車模擬")
                                                                echo " car";
                                                            if($type["game_type"] == "恐怖")
                                                                echo " terrible";
                                                            if($type["game_type"] == "第一人稱")
                                                                echo " firstPerson";
                                                            if($type["game_type"] == "單人")
                                                                echo " single";
                                                            if($type["game_type"] == "多人")
                                                                echo " multiperson";
                                                            
                                                            if($type["game_price"] == "0")
                                                                echo " free";
                                                            else
                                                                echo " pay";
                                                        }
                                                    }  
                                                    mysqli_free_result($typeRes); // 釋放佔用的記憶體
                                                }      
                                            echo '" data-date="'.$row["game_date"].'" data-name="'.$row["game_name"].'" data-sell="';
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
                                            echo '">
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
                                                               if($row["game_ID"] == $categories["game_ID"]) echo '<a href = "categories.php"><li>'. $categories["game_type"].'</li> </a>';
                                                            }  
                                                            mysqli_free_result($cateResult); // 釋放佔用的記憶體
                                                        }      
                                                        echo '</ul>
                                                        <h5><a href="game-details.php?game_ID='. $row["game_ID"].'">'. $row["game_name"].'</a></h5>
                                                    </div>
                                                </div>
                                            </div>';
                                    }
                                    $num = mysqli_num_rows($result); //查詢結果筆數
                                    mysqli_free_result($result); // 釋放佔用的記憶體
                                }
                            ?> 
                        </div>
                    </div>
                    <div class="product__pagination">
                        <a href="#" class="current-page">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#"><i class="fa fa-angle-double-right"></i></a>
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
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
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