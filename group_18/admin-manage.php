<?php
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>管理會員</title>

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
    <link rel="stylesheet" href="css/toastr.min.css" type="text/css">
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
                                        echo '<li><a href="member-center-data.php">會員中心</a></li>';
                                    }
                                    else{
                                        echo '<li><a href="login.php">會員中心</a></li>';
                                    }
                                ?>
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
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="container">
                            <div class="row pd-20">
                                <div class="col-lg-10">
                                        <h4 class="text-blue h3">管理管理員</h4>
                                </div>
                                <div class="col-lg-2">
                                    <div class="manage-insert">
                                        <button id="admin_insert" class="site-btn edit-switch">新增資料</button>
                                    </div>
                                </div>
                            </div>
                        </div>
						<table class="table stripe hover nowrap" id="admin_datatable">
							<thead>
								<tr>
									<th>管理員帳號</th>
									<th class="table-plus">電子信箱</th>
									<th>管理員名稱</th>
									<th>聯絡電話</th>
									<th>新增日期</th>
									<th class="table-plus table-nosort">密碼(已加密)</th>
									<th class="table-nosort">動作</th>
								</tr>
							</thead>
							<tbody>
								<?php 
                                if ($result = mysqli_query($link, "SELECT * FROM admin_info")) {
	                                    while ($row = mysqli_fetch_assoc($result)) {                  	
											echo '<tr>
												<td>'. $row["admin_account"].'</td>
												<td class="table-plus">'. $row["admin_email"].'</td>
												<td>'. $row["admin_name"].'</td>
												<td>'. $row["admin_phone"].'</td>
												<td>'. $row["admin_insertDate"].'</td>
												<td class="table-plus table-nosort">'. $row["admin_password"].'</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item edit-switch" href="#" id= "admin_update"><i class="dw dw-edit2"></i> 編輯</a>
															<a class="dropdown-item" href="#" id="admin_delete"><i class="dw dw-delete-3"></i> 刪除</a>
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
	    	<form class="edit-model-form" id="edit-admin-form" method="post">
	    		<input type="hidden" name="tableType" id="tableType" value="adminTable">
        		<input type="hidden" name="oper" id="oper" value="insert">
           		<input type="hidden" name="old-admin_account" id="old-admin_account" value="">
           		<div class="edit-switch-pos">
	        		<button class="edit-close-switch" type="submit" id="admin_save"><i class="icon_check"></i></button>
		    		<div class="edit-close-switch" id="admin_cancel"><i class="icon_close"></i></div>	
		    	</div>
		        <div class="container">
		        	<div class="row pt-5">
		        		<div class="col-lg-6">
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>帳號</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-admin-account" id="edit-admin-account" placeholder="請輸入帳號"><label for="edit-admin-account" class="error"></label><p class="error" id="account_check"></p></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>密碼</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="password" name="edit-admin-password" id="edit-admin-password" placeholder="請輸入密碼"><label for="edit-admin-password" class="error"></label></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>確認密碼</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="password" name="edit-admin-pwd" id="edit-admin-pwd" placeholder="請確認輸入密碼"><label for="edit-admin-pwd" class="error"></label></div>
        						</div>
        					</div>
		        		</div>
		        		<div class="col-lg-6">
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>電子信箱</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-admin-email" id="edit-admin-email" placeholder="請輸入電子信箱"><label for="edit-admin-email" class="error"></label></div>
        						</div>
        					</div>
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>名稱</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-admin-name" id="edit-admin-name" placeholder="請輸入名稱"><label for="edit-admin-name" class="error"></label></div>
        						</div>
        					</div>	
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>聯絡電話</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-admin-phone" id="edit-admin-phone" placeholder="請輸入電話"><label for="edit-admin-phone" class="error"></label></div>
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
	<script src="vendors/scripts/datatable-setting.js"></script>
	 <!--表單驗證-->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/localization/messages_zh_TW.js "></script>
	
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/crud.js"></script>

	</body>
</html>