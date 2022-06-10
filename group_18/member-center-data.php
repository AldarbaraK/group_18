<?php
    include 'dbConnect.php';
    session_start();
    if(!isset($_SESSION['member_account'])){
        if(isset($_SESSION['admin_account']))
            header("Location:admin.php");
        else
            header("Location:login.php");
    }
?>

<?php
	$account = $_SESSION['member_account'];
    if ($result = mysqli_query($link, "SELECT * FROM member_details a,member_info b WHERE a.member_account = b.member_account")){
        while($row = mysqli_fetch_assoc($result)){
            if($account == $row['member_account']){
                $email = $row['member_email'];
                $name = $row['member_name'];
                $nickname = $row['member_nickname'];
                $birthday = $row['member_birth'];
				$signupDate = $row['member_signupDate'];
                $phone = $row['member_phone'];
                $sex = $row['member_sex'];
                $level = $row['member_level'];    
                $totalCost = $row['member_cost']; 
				$loginCount = $row['login_count'];      
            }
        }
    }
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
    <!--表單驗證-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
	<script src="http://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/localization/messages_zh_TW.js "></script>

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
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

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
			$("#edit_form").validate({
				submitHandler: function(form) {
					$('.edit-model').fadeOut(400);
					form.submit();
				},
				rules: {
					account: {
						minlength: 4,
						maxlength: 24
					},
					email: {
						email: true
					},
					pwd: {
						pwd: true
					},
					pwd2: {
						equalTo: "#edit-member-password"
					},
					phone: {
						matches: new RegExp('^09\\d{8}$')
					}
				},
				messages: {
					email: {
						email: "請輸入正確郵箱格式"
					},
					pwd2: {
						equalTo: "密碼不相符"
					},
					phone: {
						matches: "請輸入正確的10位手機格式"
					}
				}
			});
		});

	</script>

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
                                <?php 
                                    if(isset($_SESSION['admin_account'])) 
                                        echo '<li><a href="admin.php">管理員中心</a></li>';
                                    else
                                        echo '<li class="active"><a href="member-center-data.php">會員中心</a></li>';
                                ?>
                                <li><a href="customer.php">客服中心</a></li>
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
                            if(isset($_SESSION['member_account'])||isset($_SESSION['admin_account'])){
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
							<?php
								if($level == "1")
									echo '<p>黃金會員</p>';
								else if($level == "2")
									echo '<p>白金會員</p>';
								else if($level == "3")
									echo '<p>鑽石會員</p>';
							?>
		                </div>
					</div>
					<div class="col-lg-6 mb-2">
						<div class="section-title"><h3>累計折數</h3></div>
						<div class="personal-background">
		                   <p>
		                   		<?php 
		                   			if($level == 1) 
		                   				echo "0%"; 
		                   			else if($level == 2) 
		                   				echo "8%";
		                   			else if($level == 3) 
		                   				echo "15%";
		                   		?>	
		                   	</p>
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
                                <button class="site-btn edit-switch" id="member_update">修改</button>
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
									<p><?php echo $name?></p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>暱稱</h5></div>
								</div>
								<div class="col-lg-9">
									<p><?php echo $nickname?></p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>電子信箱</h5></div>
								</div>
								<div class="col-lg-9">
									<p><?php echo $email?></p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>帳號</h5></div>
								</div>
								<div class="col-lg-9">
									<p><?php echo $account?></p>
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
									<p><?php echo $sex?></p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>生日</h5></div>
								</div>
								<div class="col-lg-9">
									<p><?php echo $birthday?></p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>電話</h5></div>
								</div>
								<div class="col-lg-9">
									<p><?php echo $phone; ?></p>
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
									<p><?php echo $signupDate ?></p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>登入次數</h5></div>
								</div>
								<div class="col-lg-9">
									<p><?php echo $loginCount?></p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>消費次數</h5></div>
								</div>
								<div class="col-lg-9">
									<p>
										<?php 
											if ($dealResult = mysqli_query($link, "SELECT member_account,count(*) bought_count FROM deal_record GROUP BY member_account")){
												while($dealrow = mysqli_fetch_assoc($dealResult)){
													if($account == $dealrow['member_account']){
														echo $dealrow['bought_count'];
													}
												}
											}
										?>
									</p>
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
									<p>
										<?php 
											$bought_total=0;
											if ($dealResult = mysqli_query($link, "SELECT member_account,deal_price FROM deal_record")){
												while($dealrow = mysqli_fetch_assoc($dealResult)){
													if($account == $dealrow['member_account']){
														$bought_total += $dealrow['deal_price'];
													}
												}
											}
											echo $bought_total;
										?>
									</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>評價次數</h5></div>
								</div>
								<div class="col-lg-9">
									<p>
										<?php 
											$score_count=0;
											if ($dealResult = mysqli_query($link, "SELECT member_account,deal_score FROM deal_record")){
												while($dealrow = mysqli_fetch_assoc($dealResult)){
													if($account == $dealrow['member_account'] && $dealrow['deal_score'] != NULL){
														$score_count++;
													}
												}
											}
											echo $score_count;
										?>
									</p>
								</div>
							</div>
							<div class="row personal-basic">
								<div class="col-lg-3">
									<div class="section-title"><h5>評論總數</h5></div>
								</div>
								<div class="col-lg-9">
									<p>
										<?php 
											if ($dealResult = mysqli_query($link, "SELECT member_account,count(*) comment_count FROM member_comment GROUP BY member_account")){
												while($dealrow = mysqli_fetch_assoc($dealResult)){
													if($account == $dealrow['member_account']){
														$comment_cnt = $dealrow['comment_count'];
													}			
												}
												if(isset($comment_cnt))
													echo $comment_cnt;				
												else
													echo 0;
											}
										?>
									</p>
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

	<!-- Edit model Begin -->
    <div class="edit-model">
        <div class="edit-model-show"> 
	    	<form class="edit-model-form" id="edit-member-form" method="post">
	    		<input type="hidden" name="tableType" id="tableType" value="memberTable">
        		<input type="hidden" name="oper" id="oper" value="update">
           		<input type="hidden" name="old-member_account" id="old-member_account" value="<?php echo $account ?>">
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
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-account" id="edit-member-account" placeholder="請輸入帳號" value="<?php echo $account ?>" readonly="readonly"><label for="edit-member-account" class="error"></label></div>
        						</div>
        					</div>
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>電子信箱</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-email" id="edit-member-email" placeholder="請輸入電子信箱" value="<?php echo $email ?>"><label for="edit-member-email" class="error"></label></div>
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
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-level" id="edit-member-level" placeholder="請輸入會員層級" value="<?php echo $level ?>" readonly="readonly"><label for="edit-member-level" class="error"></label></div>
        						</div>
        					</div>
		        		</div>
		        		<div class="col-lg-6">
		        			<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>姓名</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-name" id="edit-member-name" placeholder="請輸入姓名" value="<?php echo $name ?>"><label for="edit-member-name" class="error"></label></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>暱稱</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-nickname" id="edit-member-nickname" placeholder="請輸入暱稱" value="<?php echo $nickname ?>"><label for="edit-member-nickname" class="error"></label></div>
        						</div>
        					</div>
        					<div class="form-group">
        						<div class="row">	
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>性別</h4></div>
	        						</div>
									<div class="col-lg-2">
										<div class="custom-control custom-radio">
											<input type="radio" id="edit-member-sex" name="edit-member-sex" value="M" class="custom-control-input edit-form-Zindex"<?php if($sex=="男性") echo 'checked'; ?>>
											<label class="custom-control-label" for="edit-member-sex">男性</label>
										</div>
									</div>	
									<div class="col-lg-2">
										<div class="custom-control custom-radio">
											<input type="radio" id="edit-member-sex" name="edit-member-sex" value="F" class="custom-control-input edit-form-Zindex" <?php if($sex=="女性") echo 'checked'; ?>>
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
									<div class="col-lg-9"><input class="form-control date-picker" name="edit-member-birth" id="edit-member-birth" data-date-format="yyyy-mm-dd" placeholder="選擇生日日期" type="text" value="<?php echo $birthday ?>"><label for="edit-member-birth" class="error"></label></div>
								</div>
        					</div>
        					<div class="form-group">
        						<div class="row">
        							<div class="col-lg-3">
	        							<div class="section-title"><h4>電話</h4></div>
	        						</div>
	        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-member-phone" id="edit-member-phone" placeholder="請輸入電話" value="<?php echo $phone ?>"><label for="edit-member-phone" class="error"></label></div>
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

    <script src="js/bootstrap.min.js"></script>
    <script src="js/player.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/member_center.js"></script>
	</body>
</html>