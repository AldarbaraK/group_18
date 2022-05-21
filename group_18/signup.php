<?php
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="group_18, signup">
    <meta name="keywords" content="game, group_18, shun, xian">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>註冊新帳號</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <!--additional method - for checkbox .. ,require_from_group method ...-->
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <!--中文錯誤訊息-->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/localization/messages_zh_TW.js "></script>

    <link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
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
        jQuery.validator.methods.matches = function( value, element, params ) {
            var re = new RegExp(params);
            return this.optional( element ) || re.test( value );
        }

        $.validator.addMethod("pwd",function(value,element,params){
            var pwd = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,20}$/;
            return (pwd.test(value));
        },"請填寫長度在8-20之間,需包含一個字母和一個數字!");

        $(document).ready(function($) {
            $("#form1").validate({
                submitHandler: function(form) {
                    form.submit();
                },
                rules: {
                    account: {
                        required: true,
                        minlength: 4,
                        maxlength: 24
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    name: {
                        required: true
                    },
                    nickname: {
                        required: true
                    },
                    pwd: {
                        required: true,
                        pwd: true
                    },
                    pwd2: {
                        required: true,
                        equalTo: "#pwd"
                    },
                    phone: {
                        required:true,
                        matches: new RegExp('^09\\d{8}$')
                    },
                    birthday: {
                        required: true
                    },
                    sexRadio: {
                        required: true
                    }
                },
                messages: {
                    account:{
                        required: "請輸入4到24位英數字組合帳號"
                    },
                    email: {
                        required: "請輸入電子郵箱",
                        email: "請輸入正確郵箱格式"
                    },
                    pwd: {
                        required: "請輸入密碼"
                    },
                    pwd2: {
                        required: "請輸入確認密碼",
                        equalTo: "密碼不相符"
                    },
                    phone: {
                        required: "請輸入電話號碼",
                        matches: "請輸入正確的10位手機格式"
                    }
                }
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
    <header class="cus__header">
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
                                echo '<a href="cart.php"><span class="icon_cart"></span></a>';
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
                        <h2>歡迎加入</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <section class="signup spad">
        <div class="container">
            <div class="row">
                <div class="signup__form">
                    <h3>註冊</h3>
                    <form action="#" id="form1">
                        <div class="input__item">
                            <input type="text" name="account" id="account" placeholder="請輸入帳號">
                            <span class="icon_profile"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" name="email" id="email" placeholder="輸入郵箱(...@xxx.xxx)">
                            <span class="icon_mail"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" name="name" id="name" placeholder="輸入您的名字">
                            <span class="icon_profile"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" name="nickname" id="nickname" placeholder="輸入您的暱稱">
                            <span class="icon_profile"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" name="phone" id="phone" placeholder="輸入您的電話號碼">
                            <span class="icon_phone"></span>
                        </div>
                        <div class="input__item">
                            <input type="password" name="pwd" id = "pwd" placeholder="輸入密碼">
                            <span class="icon_lock"></span>
                        </div>
                        <div class="input__item">
                            <input type="password" name="pwd2" id = "pwd2" placeholder="確認密碼">
                            <span class="icon_lock"></span>
                        </div>
                        <div class="input__item">
                            <input class="form-control date-picker" data-date-format="yyyy-mm-dd" type="text" name="birthday" id="birthday" placeholder="請選擇生日日期">
                            <span class="fa fa-user-circle"></span>
                        </div>
                        <div class="input__item">	
                            <div class="radio__bg">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="radio__pos">請選擇性別</label>
                                    </div>	
                                    <div class="col-lg-3">
                                        <div class="custom-control custom-radio radio__pos">
                                            <input type="radio" id="sexRadio1" name="sexRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="sexRadio1">男性　</label>
                                        </div>
                                    </div>	
                                    <div class="col-lg-3">
                                        <div class="custom-control custom-radio radio__pos">
                                            <input type="radio" id="sexRadio2" name="sexRadio" class="custom-control-input">
                                            <label class="custom-control-label" for="sexRadio2">女性　</label>
                                        </div>
                                    </div>	
                                </div>     
                            </div>
                            <label for="sexRadio"  class="error"></label>
                            <span class="fa fa-user-circle"></span>
                        </div>
                        <button type="submit" class="site-btn">立刻註冊</button>
                    </form>
                    <h5>已經有帳號了?　 <a href="login.php">登入!</a></h5>
                </div>
            </div>
        </div>
    </section>
    <!-- Signup Section End -->

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

    <script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>

</body>

</html>