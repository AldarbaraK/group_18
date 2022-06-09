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
					<!-- Simple Datatable start -->
					<div class="card-box mb-30">
						<div class="container">
                            <div class="row pd-20">
                                <div class="col-lg-10">
                                        <h4 class="text-blue h3">管理會員</h4>
                                </div>
                                <div class="col-lg-2">
                                    <div class="manage-insert">
                                        <button id="member_insert" class="site-btn edit-switch">新增資料</button>
                                    </div>
                                </div>
                            </div>
                        </div>
						<table class="table stripe hover nowrap" id="member_datatable">
							<thead>
								<tr>
									<th>帳號</th>
									<th>電子信箱</th>
									<th>姓名</th>
									<th>暱稱</th>
									<th>會員等級</th>
									<th>性別</th>
									<th>電話</th>
									<th>生日</th>
									<th>註冊日期</th>
									<th class="datatable-nosort table-plus">密碼(已加密)</th>
									<th>總消費次數</th>
									<th>總消費金額</th>
									<th>登入次數</th>
									<th>評分次數</th>
									<th>評論次數</th>
									<th class="datatable-nosort">動作</th>
								</tr>
							</thead>
							<tbody>
								<?php 
                                if ($result = mysqli_query($link, "SELECT * FROM member_info a,member_details b WHERE a.member_account = b.member_account")) {
	                                    while ($row = mysqli_fetch_assoc($result)) {                  	
											echo '<tr>
												<td>'. $row["member_account"].'</td>
												<td class="table-plus">'. $row["member_email"].'</td>
												<td>'. $row["member_name"].'</td>
												<td>'. $row["member_nickname"].'</td>
												<td>';
												if($row["member_level"] == 1)
													echo '黃金會員';
												else if($row["member_level"] == 2)
													echo '白金會員';
												else if($row["member_level"] == 3)
													echo '鑽石會員';
											echo '</td>
												<td>'. $row["member_sex"].'</td>
												<td>'. $row["member_phone"].'</td>
												<td>'. $row["member_birth"].'</td>
												<td>'. $row["member_signupDate"].'</td>
												<td class="table-plus">'. $row["member_password"].'</td>
												<td>'. $row["bought_count"].'</td>
												<td>'. $row["member_cost"].'</td>
												<td>'. $row["login_count"].'</td>
												<td>'. $row["score_count"].'</td>
												<td>'. $row["comment_count"].'</td>
												<td>
													<div class="dropdown">
														<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown" id = "test">
															<i class="dw dw-more"></i>
														</a>
														<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
															<a class="dropdown-item edit-switch" href="#" id= "member_update"><i class="dw dw-edit2"></i> 編輯</a>
															<a class="dropdown-item" href="#" id="member_delete"><i class="dw dw-delete-3"></i> 刪除</a>
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
	    	<form class="edit-model-form" id="edit-member-form" method="post">
	    		<input type="hidden" name="tableType" id="tableType" value="memberTable">
        		<input type="hidden" name="oper" id="oper" value="insert">
           		<input type="hidden" name="old-member_account" id="old-member_account" value="">
           		<div class="edit-switch-pos">
	        		<button class="edit-close-switch" type="submit" id="member_save"><i class="icon_check"></i></button>
		    		<div class="edit-close-switch" id="member_cancel"><i class="icon_close"></i></div>	
		    	</div>
		        <div class="container">
		        	<div class="row pt-5">
		        		<div class="col-lg-6">
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>帳號</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-account" id="edit-member-account" placeholder="請輸入帳號"><label for="edit-member-account" class="error"></label><p class="error" id="account_check"></p></div>
        						</div>
        					</div>
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>電子信箱</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-email" id="edit-member-email" placeholder="請輸入電子信箱"><label for="edit-member-email" class="error"></label></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>密碼</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="password" name="edit-member-password" id="edit-member-password" placeholder="請輸入密碼"><label for="edit-member-password" class="error"></label></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>確認密碼</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="password" name="edit-member-pwd" id="edit-member-pwd" placeholder="請確認輸入密碼"><label for="edit-member-pwd" class="error"></label></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>會員層級</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-level" id="edit-member-level" placeholder="請輸入會員層級"><label for="edit-member-level" class="error"></label></div>
        						</div>
        					</div>
		        		</div>
		        		<div class="col-lg-6">
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>姓名</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-name" id="edit-member-name" placeholder="請輸入姓名"><label for="edit-member-name" class="error"></label></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>暱稱</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-nickname" id="edit-member-nickname" placeholder="請輸入暱稱"><label for="edit-member-nickname" class="error"></label></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">	
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>性別</h4></div>
	        						</div>
									<div class="col-lg-2">
										<div class="custom-control custom-radio">
											<input type="radio" id="edit-member-sex" name="edit-member-sex" value="M" class="custom-control-input edit-form-Zindex">
											<label class="custom-control-label" for="edit-member-sex">男性</label>
										</div>
									</div>	
									<div class="col-lg-2">
										<div class="custom-control custom-radio">
											<input type="radio" id="edit-member-sex" name="edit-member-sex" value="F" class="custom-control-input edit-form-Zindex">
											<label class="custom-control-label" for="edit-member-sex">女性</label>
										</div>
									</div>
									<label for="edit-member-sex" class="error"></label>	
								</div>
        					</div>
        					<div class="form-group">
        						<div class="row">	
	        						<div class="col-lg-3">
	        							<div class="section-title"><h4>生日</h4></div>
	        						</div>
									<div class="col-lg-9"><input class="form-control date-picker" name="edit-member-birth" id="edit-member-birth" data-date-format="yyyy-mm-dd" placeholder="選擇生日日期" type="text"><label for="edit-member-birth" class="error"></label></div>
								</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>電話</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-phone" id="edit-member-phone" placeholder="請輸入電話"><label for="edit-member-phone" class="error"></label></div>
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