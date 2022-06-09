<?php
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>管理員中心</title>

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
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
</head>
<body>

	<div id="preloder">
        <div class="loader"></div>
    </div>

	<!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
            	<div class="col-lg-1">
					<div class="header-left">
						<div class="menu-icon dw dw-menu"></div>
					</div>
				</div> 		 
                <div class="col-lg-9">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="index.php">首頁</a></li>
                                <li><a href="categories.php">類別</a></li>
                                <li><a href="member-center-data.php">會員中心</a></li>
                                <li><a href="customer.php">客服中心</a></li>
                                <li class="active"><a href="admin.php">管理員中心</a></li>
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
    	<div class="left-side-bar">
            <div class="brand-logo">
                <a href="index.php">
                    <img src="img/logo.svg" alt="">
                </a>
                <div class="close-sidebar" data-toggle="left-sidebar-close">
					<i class="ion-close-round"></i>
				</div>
            </div> 
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul>
						<li class="dropdown">
							<a href="admin.php" class="dropdown-toggle">
								<span class="micon dw dw-house-1"></span><span class="mtext">管理員主頁</span>
							</a>
						</li>
					</ul>
					<ul id="accordion-menu">
						<li class="dropdown">
							<a href="javascript:;" class="dropdown-toggle">
								<span class="micon dw dw-edit2"></span><span class="mtext">管理</span>
							</a>
							<ul class="submenu">
								<li><a href="product-manage.php">管理商品</a></li>
								<li><a href="member-manage.php">管理會員</a></li>
								<li><a href="admin-manage.php">管理管理員</a></li>
								<li><a href="comment-manage.php">管理評論</a></li>
								<li><a href="deal-manage.php">管理交易紀錄</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="row">
						<div class="col-xl-12 mb-30">
							<div class="card-box height-100-p pd-20">
								<h2 class="h2 mb-30">今日焦點</h2>
								<div class="hero__slider owl-carousel">
					                <?php 
					                    if ($result = mysqli_query($link, "SELECT * FROM game_info a LEFT JOIN (SELECT game_ID,COUNT(*) game_count FROM member_comment GROUP BY game_ID) c ON a.game_ID = c.game_ID,game_pic b WHERE a.game_ID = b.game_ID ORDER BY game_count DESC")) {
					                        $count=0;
					                        while ($row = mysqli_fetch_assoc($result)) {
					                            if($count>=3)
					                                break;
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
					                            $count++;
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
						<div class="col-xl-3 mb-30">
							<div class="card-box height-100-p widget-style1">
								<div class="d-flex flex-wrap align-items-center">
									<div class="widget-data">
										<div class="h3 mb-0">
										<?php 
											if ($Result = mysqli_query($link, "SELECT MONTH(NOW()) AS mon, count(*) as mon_comment_count FROM member_comment WHERE MONTH(comment_time) = MONTH(NOW())")){
												while($row = mysqli_fetch_assoc($Result)){
													echo $row['mon_comment_count'];
												}
											}
										?>
										</div>
										<div class="weight-600 font-14">本月評論總數</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 mb-30">
							<div class="card-box height-100-p widget-style1">
								<div class="d-flex flex-wrap align-items-center">
									<div class="widget-data">
										<div class="h3 mb-0">
										<?php 
											if ($Result = mysqli_query($link, "SELECT MONTH(NOW()) AS mon, count(*) as mon_member_count FROM member_info WHERE MONTH(member_signupDate) = MONTH(NOW())")){
												while($row = mysqli_fetch_assoc($Result)){
													echo $row['mon_member_count'];
												}
											}
											
										?>
										</div>
										<div class="weight-600 font-14">本月新增會員</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 mb-30">
							<div class="card-box height-100-p widget-style1">
								<div class="d-flex flex-wrap align-items-center">
									<div class="widget-data">
										<div class="h3 mb-0">
										<?php 
											if ($Result = mysqli_query($link, "SELECT MONTH(NOW()) AS mon, count(*) as mon_deal_count FROM deal_record WHERE MONTH(deal_datetime) = MONTH(NOW())")){
												while($row = mysqli_fetch_assoc($Result)){
													echo $row['mon_deal_count'];
												}
											}			
										?>
										</div>
										<div class="weight-600 font-14">本月購買總數</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 mb-30">
							<div class="card-box height-100-p widget-style1">
								<div class="d-flex flex-wrap align-items-center">
									<div class="widget-data">
										<div class="h3 mb-0">$
										<?php 
											if ($Result = mysqli_query($link, "SELECT MONTH(NOW()) AS mon, sum(deal_price) as mon_deal_price FROM deal_record WHERE MONTH(deal_datetime) = MONTH(NOW())")){
												while($row = mysqli_fetch_assoc($Result)){
													echo $row['mon_deal_price'];
												}
											}
											mysqli_free_result($Result); // 釋放佔用的記憶體
                  							mysqli_close($link); // 關閉資料庫連結
										?>
										</div>
										<div class="weight-600 font-14">本月獲利</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

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

	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/admin.js"></script>

</html>