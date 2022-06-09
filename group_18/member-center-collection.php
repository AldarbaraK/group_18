<?php
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>會員遊戲收藏庫</title>

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
    <link rel="stylesheet" href="css/star-rating.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <script src="js/jquery-3.3.1.min.js"></script>

    <script>
		$(document).ready(function(){
		    $("#input-id").rating();
		});
	</script>
</head>


<body>
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
                                        echo '<li class="active"><a href="member-center-data.php">會員中心</a></li>';
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
						<li class="dropdown"><a href="member-center-data.php" class="dropdown-toggle">
							<span class="micon dw dw-id-card"></span><span class="mtext">會員資料</span>
						</a></li>						
						<li class="dropdown"><a href="member-center-collection.php" class="dropdown-toggle">
							<span class="micon dw dw-gamepad"></span><span class="mtext">遊戲收藏</span>
						</a></li>
						<li class="dropdown"><a href="cart.php" class="dropdown-toggle">
							<span class="micon dw dw-shopping-cart"></span><span class="mtext">購物車</span>
						</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="pd-20">
							<h4 class="text-blue h4">收藏庫</h4>
						</div>
						<table class="data-table table hover nowrap">
							<thead>
								<tr>
									<th class="datatable-nosort table-plus">預覽圖</th>
									<th>遊戲名稱</th>
									<th>購買日期</th>
									<th>購買價格</th>
									<th>評分</th>
									<th class="datatable-nosort">動作</th>
								</tr>
							</thead>
							<tbody> 
								<?php 
	                                if ($result = mysqli_query($link, "SELECT * FROM game_info a,member_collection b,deal_record c,game_pic d WHERE a.game_ID = b.game_ID and b.game_ID = c.game_ID and a.game_ID = d.game_ID and b.member_account = c.member_account and b.member_account ='". $_SESSION["member_account"]. "'")) {
		                                    while ($row = mysqli_fetch_assoc($result)) {
		                                        	echo '<tr>
														<td class="datatable-nosort table-plus">
															<div class="image-view">
																<img id="datatable-img'. $row["game_ID"].'" src="img/product/'. $row["game_picture"].'.jpg" alt="">
															</div>
														</td>
														<td>'. $row["game_name"].'</td>
														<td>'. $row["deal_datetime"].'</td>
														<td>'. $row["deal_price"].'</td>
														<td><input id="input-id" type="number" class="rating" min=0 max=5 step=0.5 data-size="xs" ></td>
														<td class="datatable-nosort">
															<div class="dropdown">
																<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
																	<i class="dw dw-more"></i>
																</a>
																<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
																	<a class="dropdown-item edit-switch" href="#"><i class="dw dw-edit"></i> 評分</a>
																</div>
															</div>
														</td>
													</tr>';        
	                                   	 	}
	                                    $num = mysqli_num_rows($result); //查詢結果筆數
	                                    mysqli_free_result($result); // 釋放佔用的記憶體
	                                }
	                            ?>
							</tbody>
						</table>
					</div>
					<!-- Simple Datatable End -->


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

	<!-- View model Begin -->
    <div class="edit-model">
        <div class="view-model-show">
        	<div class="view-close-pos">
        		<div class="view-close-switch"><i class="icon_close"></i></div>
       		</div>
			<div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="game__details__pic set-bg" data-setbg="img/product/discount/discount-2.jpg">
                            <div class="comment"><i class="fa fa-comments"></i> 11</div>
                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="game__details__text">
                            <div class="game__details__title">
                                <h3>星之卡比 探索發現</h3>
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
                                                <li><span>類型:</span><p>休閒</p>　<p>冒險</p></li>
                                            </ul>
                                        </div>
                                        <ul>
                                            <li><span>發行日期:</span>2022 年 3 月 25 日</li>
                                            <li><span>開發人員:</span> HAL研究所</li>
                                            <li><span>發行商:</span> 任天堂</li>
                                            <li><span>支援語言:</span> 繁體中文 / 英文 / 日文</li>
                                            <li><span>遊戲分級:</span> 普通級</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="row ml-5">
                	<div class="col-lg-12">
                		<div class="game__details__text">
                            <div class="section-title">
                                <h5>評論</h5>
                            </div>
	    					<form class="score-model-form ">
								<div class="row">
									<div class="col-lg-9">
										<textarea class="form-control" placeholder="請輸入文字敘述"></textarea>
									</div>
									<div class="col-lg-3">
										<div class="collect__send__btn">
											<button type="submit" class="site-btn">送出</button>
										</div>
									</div>
								</div>
							</form>
							<br><br>
		                </div> 
                	</div>
                </div>	  
	        </div>
        </div>
    </div>
    <!-- View model end -->
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>

	<!-- Datatable Setting js -->
	<script src="vendors/scripts/datatable-setting.js"></script>


    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/star-rating.min.js"></script>
    <script src="js/main.js"></script>
	</body>
</html>