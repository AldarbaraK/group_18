<?php
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>會員中心</title>

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
                                <li class="active"><a href="member-center-data.php">會員中心</a></li>
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
			<div class="container">
				<div class="row mt-5 md-5 pd-2">
					<div class="col-lg-6 mb-3">
						<div class="section-title"><h3>會員等級</h3></div>
						<div class="personal-background">
		                   <p>黃金會員</p>
		                </div>
					</div>
					<div class="col-lg-6 mb-2">
						<div class="section-title"><h3>累計折數</h3></div>
						<div class="personal-background">
		                   <p>50%</p>
		                </div>
					</div>
				</div>
				<div class="row mt-5 md-5">
					<div class="col-lg-10">
						<div class="section-title"><h3>基本資料</h3></div>
					</div>
					<div class="col-lg-2">
						<div class="section-title">
							<div class="personal-btn">
                                <button class="site-btn edit-switch">修改</button>
                            </div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="container">
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>姓名</h5></div>
								</div>
								<div class="col-lg-9">
									<p>莊胖胖</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>暱稱</h5></div>
								</div>
								<div class="col-lg-9">
									<p>洨欠喵OuO</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>電子信箱</h5></div>
								</div>
								<div class="col-lg-9">
									<p>allan96452@gmail.com</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">	
						<div class="container">
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>性別</h5></div>
								</div>
								<div class="col-lg-9">
									<p>男性</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>生日</h5></div>
								</div>
								<div class="col-lg-9">
									<p>29-03-2001</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>電話</h5></div>
								</div>
								<div class="col-lg-9">
									<p>0963111111</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-5 md-5">
					<div class="col-lg-10">
						<div class="section-title"><h3>消費數據</h3></div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="container">
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>註冊日期</h5></div>
								</div>
								<div class="col-lg-9">
									<p>09-04-2021</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>登入次數</h5></div>
								</div>
								<div class="col-lg-9">
									<p>56</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>消費次數</h5></div>
								</div>
								<div class="col-lg-9">
									<p>18</p>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">	
						<div class="container">
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>消費總額</h5></div>
								</div>
								<div class="col-lg-9">
									<p>30521</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>評價次數</h5></div>
								</div>
								<div class="col-lg-9">
									<p>4</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>評論總數</h5></div>
								</div>
								<div class="col-lg-9">
									<p>8</p>
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
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->	

	<!-- Edit model Begin -->
    <div class="edit-model">
        <div class="edit-model-show">
	        <div class="edit-switch-pos">
        		<div class="edit-close-switch"><i class="icon_check"></i></div>
	    		<div class="edit-close-switch"><i class="icon_close"></i></div>	
	    	</div>
	    	<form class="edit-model-form">
		        <div class="container">
		        	<div class="row pt-5">
		        		<div class="col-lg-6">
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>電子信箱</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" id="edit-member-email" placeholder="請輸入電子信箱"></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>密碼</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" id="edit-member-password" placeholder="請輸入密碼"></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>確認</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" id="edit-member-password" placeholder="請重複輸入密碼"></div>
        						</div>
        					</div>
		        		</div>
		        		<div class="col-lg-6">
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>姓名</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" id="edit-member-name" placeholder="請輸入姓名"></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>暱稱</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" id="edit-member-nickname" placeholder="請輸入暱稱"></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">	
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>性別</h4></div>
	        						</div>
									<div class="col-lg-2">
										<div class="custom-control custom-radio">
											<input type="radio" id="edit-member-sex1" name="ratedRadio" class="custom-control-input edit-form-Zindex">
											<label class="custom-control-label" for="sexRadio1">男性</label>
										</div>
									</div>	
									<div class="col-lg-2">
										<div class="custom-control custom-radio">
											<input type="radio" id="edit-member-sex2" name="ratedRadio" class="custom-control-input edit-form-Zindex">
											<label class="custom-control-label" for="sexRadio2">女性</label>
										</div>
									</div>	
								</div>
        					</div>
        					<div class="form-group">
        						<div class="row">	
	        						<div class="col-lg-3">
	        							<div class="section-title"><h4>生日</h4></div>
	        						</div>
									<div class="col-lg-9"><input class="form-control date-picker" id="edit-member-birth" placeholder="選擇生日日期" type="text"></div>
								</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>電話</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" id="edit-member-phone" placeholder="請輸入電話"></div>
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
	<!-- buttons for Export datatable -->
	<script src="src/plugins/datatables/js/dataTables.buttons.min.js"></script>
	<script src="src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/buttons.print.min.js"></script>
	<script src="src/plugins/datatables/js/buttons.html5.min.js"></script>
	<script src="src/plugins/datatables/js/buttons.flash.min.js"></script>
	<script src="src/plugins/datatables/js/vfs_fonts.js"></script>
	<!-- Datatable Setting js -->
	<script src="vendors/scripts/datatable-setting.js"></script></body>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>

</html>