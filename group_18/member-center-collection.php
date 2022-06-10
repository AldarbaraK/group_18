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
    <link rel="stylesheet" href="css/toastr.min.css" type="text/css">
    <link rel="stylesheet" href="css/star-rating.min.css" type="text/css">
    <link rel="stylesheet" href="css//theme.css" media="all" type="text/css"/>
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
						<table class="table hover nowrap" id="collection_datatable">
							<thead>
								<tr>
									<th class="datatable-nosort table-plus">預覽圖</th>
									<th>遊戲名稱</th>
									<th>購買日期</th>
									<th>購買價格</th>
									<th class="table-plus">評分</th>
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
														<td class="table-plus"><input id="deal_rating_view" name="deal_rating_view" data-show-clear="false" data-show-caption="false" data-step="0.1" value="'. $row["deal_score"].'" class="rating" data-readonly="true" data-size="sm"></td>
														<td class="datatable-nosort">
															<div class="dropdown">
																<input type="hidden" name="tbl_game_ID" id="tbl_game_ID" value="'. $row["game_ID"].'">
																<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
																	<i class="dw dw-more"></i>
																</a>
																<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
																	<a class="dropdown-item edit-switch" href="#" id="collection_update"><i class="dw dw-edit"></i> 評分</a>
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

	<!-- Edit model Begin -->
    <div class="edit-model">
        <div class="edit-model-show"> 
	    	<form class="edit-model-form" id="member-collection" method="post">
	    		<input type="hidden" name="tableType" id="tableType" value="collectionTable">
        		<input type="hidden" name="oper" id="oper" value="update">
        		<input type="hidden" name="game_name" id="game_name" value="">
        		<input type="hidden" name="game_ID" id="game_ID" value="">
        		<input type="hidden" name="member_account" id="member_account" value="<?php echo $_SESSION['member_account']; ?>">
           		<div class="edit-switch-pos">
		    		<div class="edit-close-switch" id="collection_cancel"><i class="icon_close"></i></div>	
		    	</div>
		        <div class="container">
		        	<div class="row justify-content-center edit-comment">
		        		<div class="col-lg-8" style="text-align: center;">
		        			<div class="game__details__title">
                                <h3 id="game-name-view"></h3>
                            </div>
                        </div>
		        	</div>
		        	<div class="row justify-content-center edit-comment">
		        		<div class="col-lg-6"><div class="section-title"><h4 id="member-account-view">會員帳號 :</h4></div></div>
                    </div>
                    <div class="row justify-content-center edit-comment">
		        		<div class="col-lg-2"><div class="section-title"><h4>為此遊戲評分</h4></div></div>
		        		<div class="col-lg-4"><input id="deal_rating" name="deal_rating" class="rating" data-min="0" data-max="5" data-step="1"></div>
                    </div>
		        	<div class="row justify-content-center">
		        		<div class="col-lg-6"><div class="section-title"><h4>新增評論</h4></div></div>
		        	</div>
		        	<div class="row justify-content-center edit-comment">
		        		<div class="col-lg-6"><textarea class="form-control edit-comment-text" name = "member_comment" id="member_comment" type="text" placeholder="請輸入評論內容"></textarea></div>
		        	</div>	
		        	<div class="row justify-content-center">
                        <div class="col-lg-2">
                            <div class="section-title">
                                <div class="personal-btn">
                                    <button type="submit" class="site-btn">完成</button>
                                </div>
                            </div>
                        </div>
                    </div>
		        </div>
		    </form>    
        </div>
    </div>
    <!-- Edit model end -->

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

	 <!--表單驗證-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/localization/messages_zh_TW.js "></script>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="js/star-rating.min.js"></script>
    <script src="js/theme.js"></script>
    <script src="js/main.js"></script>	
    <script src="js/member_center.js"></script>	
    <script>
		$(document).ready(function(){
			$('#deal_rating').rating(); 
        	$('#deal_rating_view').rating('refresh');
		});

	</script>
	</body>
</html>