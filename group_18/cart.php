<?php 
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="group_18, cart">
    <meta name="keywords" content="game, group_18, shun, xian">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>購物車</title>

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

    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>您的購物車</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <section class="cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="cart__form">
                    </div>
                </div>
            </div>
            <?php
                $member_account = $_SESSION['member_account'];
                $total =0; $num=0;
                if ($result = mysqli_query($link, "SELECT * FROM game_info a,game_pic b,member_cart c WHERE a.game_ID = b.game_ID and a.game_ID = c.game_ID")) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        if($member_account == $row['member_account']){
                            echo '<div class="row">
                                    <div class="cart__item__background">
                                        <div class="row">
                                            <div class="cart__item__pic set-bg" data-setbg="img/product/'. $row["game_picture"].'.jpg">
                                            </div>
                                            <div class="cart__name__pos">
                                                <p>'.$row['game_name'].'</p>
                                            </div>
                                            <div class="cart__item__text">';
                                                if($row['game_discount']!=0){
                                                    $discount = round($row['game_price']*$row['game_discount']/100);
                                                    $total = $total + $discount; $num++;
                                                    echo '<ul>
                                                        <li><s> NT$ '.$row['game_price'].'</s></li>
                                                        <li><p> NT$ '.$discount.'</p><br></li>
                                                        <form action="function.php?op=removeOneCart&game_ID='. $row["game_ID"].'" method="post" id="addcart_form">';
                                                            echo '<li><button class="cart__itemRemove"><u>移除</u></button></li>
                                                        </form>
                                                    </ul>';
                                                }
                                                else{ 
                                                    $total = $total + $row['game_price']; $num++;
                                                    echo '<ul>
                                                        <li><p>NT$ '.$row['game_price'].'</p><br></li>
                                                        <form action="function.php?op=removeOneCart&game_ID='. $row["game_ID"].'" method="post" id="addcart_form">';
                                                            echo '<li><button class="cart__itemRemove"><u>移除</u></button></li>
                                                        </form>
                                                    </ul>';
                                                } 
                                            echo '</div> 
                                        </div>
                                    </div>
                                </div>
                                <br>';
                        }    
                    }
                    mysqli_free_result($result); // 釋放佔用的記憶體
                }
                
            ?>
           
            <div class="row">
                <div class="cart__totalItem__form">
                    <p>總共 <?php echo $num;?> 件商品</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="cartCost__form">
                        <br>
                        <p>總價:　　NT$ <?php echo $total;?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="cart__selfGift__text">
                    <div class="cart__input__item">
                        <span class="icon_mail"></span>
                        <p>這是您為自己買的商品還是要贈送給其它人的禮物? 請選擇一項並繼續結帳</p>
                    </div>
                </div>
            </div>
            <div class="cart__upbtnSet">
                <div class="cart__self__btn">
                    <button class="self-cart-pay" id="self-show">自用</button>
                </div>
                <div class="cart__gift__btn">
                    <button class="gift-cart-pay" id="gift-show">贈禮</button>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="cartCost__form">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="cart__keepBuy__btn">
                    <a href="categories.php"><button>繼續購物</button></a>
                </div>
                <div class="cart__item__text">
                    <form action="function.php?op=removeAllCart" method="post" id="addcart_form">';
                        <button class="cart__itemRemoveAll"><u>移除所有項目</u></button>
                    </form>
                </div> 
            </div>
            
        </div>
    </section>

   
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

    <!-- Self model Begin -->
    <div class="edit-model self-cart-model">
        <div class="edit-model-show"> 
            <form class="edit-model-form" id="self-pay-form" method="post">
                <div class="edit-switch-pos">
                    <div class="edit-close-switch" id="cart-cancel"><i class="icon_close"></i></div> 
                </div>
                <div class="container">
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-8" style="text-align: center;">
                            <div class="game__details__title">
                                <h3>購買商品</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-5"><div class="section-title"><h4>總價: NT$ <?php echo $total;?> 元</h4></div></div>
                    </div>
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-5"><div class="section-title"><h4>總共 <?php echo $num;?> 件商品</h4></div></div>
                    </div>
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-2">
                            <div class="section-title"><h4>付款資訊</h4></div>
                        </div>
                        <div class="col-lg-3"><input class="form-control" type="text" name="self-credit-card" id="self-credit-card" placeholder="請輸入信用卡卡號"><label for="self-credit-card" class="error" style="display: inline;"></label></div>
                    </div> 
                    <div class="row justify-content-center">
                        <div class="col-lg-2">
                            <div class="section-title">
                                <div class="personal-btn">
                                    <button class="site-btn">完成</button>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </form>    
        </div>
    </div>
    <!-- Self model end -->

    <!-- Gift model Begin -->
    <div class="edit-model gift-cart-model">
        <div class="edit-model-show"> 
            <form class="edit-model-form" id="gift-pay-form" method="post">
                <div class="edit-switch-pos">
                    <div class="edit-close-switch" id="cart-cancel"><i class="icon_close"></i></div> 
                </div>
                <div class="container">
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-8" style="text-align: center;">
                            <div class="game__details__title">
                                <h3>贈送禮物</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-5"><div class="section-title"><h4>總價: NT$ <?php echo $total;?> 元</h4></div></div>
                    </div>
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-5"><div class="section-title"><h4>總共 <?php echo $num;?> 件商品</h4></div></div>
                    </div>
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-2">
                            <div class="section-title"><h4>贈禮對象</h4></div>
                        </div>
                        <div class="col-lg-3"><input class="form-control" type="text" name="gift-target" id="gift-target" placeholder="請輸入贈禮對象帳號"><label for="gift-target" class="error" style="display: inline;"></label><p class="error" id="account_check"></p></div>
                    </div>
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-2">
                            <div class="section-title"><h4>付款資訊</h4></div>
                        </div>
                        <div class="col-lg-3"><input class="form-control" type="text" name="gift-credit-card" id="gift-credit-card" placeholder="請輸入信用卡卡號"><label for="gift-credit-card" class="error" style="display: inline;"></label></div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-5"><div class="section-title"><h4>想說些什麼</h4></div></div>
                    </div>
                    <div class="row justify-content-center edit-comment">
                        <div class="col-lg-5"><textarea class="form-control edit-message-text" name = "gift-message" id="gift-comment" type="text" placeholder="對贈禮對象說些什麼吧"></textarea></div>
                    </div>  
                    <div class="row justify-content-center">
                        <div class="col-lg-2">
                            <div class="section-title">
                                <div class="personal-btn">
                                    <button class="site-btn">完成</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>    
        </div>
    </div>
    <!-- Gift model end -->

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