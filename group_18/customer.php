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
    <title>客服中心</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
    <!--additional method - for checkbox .. ,require_from_group method ...-->
    <script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
    <!--中文錯誤訊息-->
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/localization/messages_zh_TW.js "></script>

    <!--客服css-->
    <link rel="stylesheet" type="text/css" href="css/core.css">
	<link rel="stylesheet" type="text/css" href="css//icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="css/newCusStyle.css">
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

        $(document).ready(function($) {
            $("#form1").validate({
                submitHandler: function(form) {
                    form.submit();
                },
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    name: {
                        required: true
                    },
                    phone: {
                        required:true,
                        matches: new RegExp('^09\\d{8}$')
                    }
                },
                messages: {
                    email: {
                        required: "請輸入電子郵箱",
                        email: "請輸入正確郵箱格式(customer@example.com)"
                    },
                    phone: {
                        required: "請輸入電話號碼",
                        matches: "請輸入正確的10位手機格式(09-xxxx-xxxx)"
                    }
                }
            });
        });

        $(function () {

            $("#btn_append").on("click", function(){
                $("#div_upload").append('<div class="customer__file__btn"> <button type="button" class="btn btn-danger btn-xs" data-placement="right" title="移除"><i class="fa fa-times" aria-hidden="true"> </i> </button> <input type="file" name="doc_upload[]" style="display: inline-block"> </div>');
            })


            $("#div_upload").on("click", "button.btn-danger", function(){
                $(this).closest("div").remove();
            })

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
                                <li><a href="categories.php">類別 <span class="arrow_carrot-down"></span></a>
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
                                <li class="active"><a href="customer.php">客服中心</a></li>
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
                        <a href="customer.php">客服中心</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->
    

    <!-- Product Section Begin -->
    <section class="customer-page ">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__page__content">
                        <div class="customer__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="customer__section-title">
                                        <h4>客服中心</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Default Basic Forms Start -->
                            <div class="card-box ">
                                <div class="customer__page__form">
                                    <div class="clearfix">
                                        <div class="pull-left">
                                            <h4 class="text-blue h4"><b>客服表單</b></h4>
                                            <p class="mb-30">請填寫相關資訊</p>
                                        </div>
                                    </div>
                                    <form action="#" id="form1">
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-2 col-form-label"><b>名字</b></label>
                                            <div class="col-sm-12 col-md-10 customer__page__form__text">
                                                <input class="form-control" placeholder="請輸入您的名字" type="text" name="name" id="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-2 col-form-label"><b>電話號碼</b></label>
                                            <div class="col-sm-12 col-md-10 customer__page__form__text">
                                                <input class="form-control" placeholder="09-xxxx-xxxx" type="text" name="phone" id="phone"> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-12 col-md-2 col-form-label"><b>電子信箱</b></label>
                                            <div class="col-sm-12 col-md-10 customer__page__form__text">
                                                <input class="form-control" placeholder="請輸入您的電子信箱" type="text" name="email" id="email">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="customer__line__form">
                                                    <br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <b>問題類型<br></b>
                                            <div class="custom-control custom-radio customer__page__form__radio">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio1">儲值相關問題</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio2">帳號相關問題</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="radio" id="customRadio3" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio3">錯誤回報/申訴</label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <input type="radio" id="customRadio4" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio4">連線相關問題</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="radio" id="customRadio5" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio5">檢舉/BUG</label>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <input type="radio" id="customRadio6" name="customRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="customRadio6">其他問題</label>
                                                    </div>
                                                </div>
                                                <br>
                                                <label>問題內容</label><br>
                                                <textarea cols="70" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="customer__file">
                                                <label>上傳檔案　</label>
                                            </div>
                                            <div class="form-group" id="div_upload">
                                                <div class="customer__file__btn">
                                                    <button type="button" class="btn btn-danger btn-xs" data-placement="right"
                                                        title="移除"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                    <input type="file" name="doc_upload[]" style="display: inline-block">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="customer__addFile__btn">
                                                <button type="button" class="btn" name="btn_append" id="btn_append"><i
                                                    class="fa fa-plus"></i> 新增附檔
                                                </button>
                                            </div>
                                            <div class="customer__send__btn">
                                                <button type="submit" class="site-btn">送出</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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