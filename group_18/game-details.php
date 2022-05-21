<?php
    include 'dbConnect.php';
    session_start();
?>
<?php
    if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b WHERE a.game_ID = b.game_ID")){
        while($row = mysqli_fetch_assoc($result)){
            if($_GET['game_ID'] == $row['game_ID']){
                $name = $row['game_name'];
                $developer = $row['game_developer'];
                $publisher = $row['game_publisher'];
                $bought = $row['game_bought'];
                $date = $row['game_date'];
                $rate = $row['game_rating'];
                $story = $row['game_story'];
                $price = $row['game_price'];
                $pic = $row['game_picture'];              
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

    <script>
       /* $(function() {
            $("#div__follow__btn").on("click" ,"button.follow-btn",function(){
                $(this).closest("div").remove();
            })

        });*/

        $(document).ready(function(){
            $('#follow__btn1').click(function(){
                $('#follow__btn1').toggleClass('fa').toggleClass('fa-heart');

                if($('#follow__btn1').hasClass("fa-heart") == true)
                    $('#follow__btn1').html("取消追隨");
                else    
                    $('#follow__btn1').html("追隨");
                    
            });
        });
        
    </script>
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
                                <li><a href="categories.php">類別<span class="arrow_carrot-down"></span></a>
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
                                <li><a href="member-center-data.php">會員中心</a></li>
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
                            <div class="game__details__rating">
                                <div class="rating">
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star"></i></a>
                                    <a href="#"><i class="fa fa-star-half-o"></i></a>
                                </div>
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
                                                                if($_GET['game_ID'] == $categories["game_ID"]) echo '<a href="categories.php"><p>'.$categories["game_type"].'</p></a>';
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
                                            <li><span>支援語言:</span> 繁體中文 / 英文 / 日文</li>
                                            <li><span>遊戲分級:</span> <?php echo $rate ?></li>
                                            <li><span>購買人數:</span> <?php echo $bought ?></li>
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
                                <p>價格: <?php if($price == 0) echo "Free!"; else echo '$NT '.$price;?></p>
                                <div class="game__details__btn">
                                    <div class="row">
                                        <button class="follow-btn" id="follow__btn1" name="follow__btn1"><span>追隨</span></button>
                                        <form action="function.php?op=addCart&game_ID=<?php echo $_GET["game_ID"]?>" method="post" id="addcart_form">
                                            <button class="watch-btn"><span>加入購物車</span> <i class="fa fa-angle-right"></i></button>
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
                        <div class="game__review__item">
                            <div class="game__review__item__pic">
                                <img src="img/review/review-1.jpg" alt="">
                            </div>
                            <div class="game__review__item__text">
                                <h6>陳 - <span>1 小時前</span></h6>
                                <p>讚讚</p>
                            </div>
                        </div>
                        <div class="game__review__item">
                            <div class="game__review__item__pic">
                                <img src="img/review/review-2.jpg" alt="">
                            </div>
                            <div class="game__review__item__text">
                                <h6>李 - <span>5 小時前</span></h6>
                                <p>讚讚</p>
                            </div>
                        </div>
                        <div class="game__review__item">
                            <div class="game__review__item__pic">
                                <img src="img/review/review-3.jpg" alt="">
                            </div>
                            <div class="game__review__item__text">
                                <h6>莊 - <span>20 小時前</span></h6>
                                <p>讚讚</p>
                            </div>
                        </div>
                        <div class="game__review__item">
                            <div class="game__review__item__pic">
                                <img src="img/review/review-4.jpg" alt="">
                            </div>
                            <div class="game__review__item__text">
                                <h6>林 - <span>1 小時前</span></h6>
                                <p>讚讚</p>
                            </div>
                        </div>
                        <div class="game__review__item">
                            <div class="game__review__item__pic">
                                <img src="img/review/review-5.jpg" alt="">
                            </div>
                            <div class="game__review__item__text">
                                <h6>楊 - <span>5 小時前</span></h6>
                                <p>讚讚</p>
                            </div>
                        </div>
                        <div class="game__review__item">
                            <div class="game__review__item__pic">
                                <img src="img/review/review-6.jpg" alt="">
                            </div>
                            <div class="game__review__item__text">
                                <h6>高 - <span>20 小時前</span></h6>
                                <p>讚讚</p>
                            </div>
                        </div>
                    </div>
                    <div class="game__details__form">
                        <div class="section-title">
                            <h5>你的評論</h5>
                        </div>
                        <form action="#">
                            <textarea placeholder="你的評論..."></textarea>
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
                                    if( $row["game_ID"] == 1 || $row["game_ID"] == 2 || $row["game_ID"] == 9 || $row["game_ID"] == 10 ){
                                        echo '<a href="game-details.php?game_ID='. $row["game_ID"].'">
                                            <div class="product__mayLike__item set-bg" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                                <div class="view"><i class="fa fa-download"></i> '. $row["game_bought"].'</div>
                                                <h5>'. $row["game_ID"].'</h5>
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