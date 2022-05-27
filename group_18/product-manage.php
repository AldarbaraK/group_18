<?php
    include 'dbConnect.php';
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>管理商品</title>

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
    <header class="cus__header">
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
                                        <h4 class="text-blue h3">管理商品</h4>
                                </div>
                                <div class="col-lg-2">
                                    <div class="manage-insert">
                                        <button class="site-btn edit-switch">新增資料</button>
                                    </div>
                                </div>
                            </div>
                        </div>
						<table class="data-table table hover nowrap">
							<thead>
								<tr>
									<th class="datatable-nosort">預覽圖</th>
									<th>遊戲名稱</th>
									<th>發行日期</th>
									<th class="datatable-nosort">支援語言</th>
									<th class="datatable-nosort">遊戲分級</th>
									<th>價格</th>
									<th>折扣</th>
									<th>評分</th>
									<th>開發人員</th>
									<th>發行商</th>
									<th>故事</th>
									<th class="datatable-nosort">動作</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="table-plus">
										<div class="image-view">
											<img src="img/product/all/all-1.jpg" alt="">
										</div>
									</td>
									<td>
										<h5 class="font-16">Tales of Arise</h5>
									</td>
									<td>2021 年 9 月 10 日</td>
									<td>中文/英文/日文</td>
									<td>保護級</td>
									<td>1490</td>
									<td>none</td>
									<td>4.2</td>
									<td>BANDAI NAMCO Studios Inc.</td>
									<td>BANDAI NAMCO Entertainment</td>
									<td class="table-plus">３００年的暴政、不明面具、遺失的痛覺與記憶。化身為強大火焰之劍的唯一使用者，與不可碰觸的少女及伙伴們一起挺身對抗壓迫者吧。以新世代技術描繪出表情生動的角色，一個關於解放的戰鬥故事。</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item view-switch" href="#"><i class="dw dw-eye"></i> 預覽</a>
												<a class="dropdown-item edit-switch" href="#"><i class="dw dw-edit2"></i> 編輯</a>
												<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> 刪除</a>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td class="table-plus">
										<div class="image-view">
											<img src="img/product/all/all-2.jpg" alt="">
										</div>
									</td>
									<td>
										<h5 class="font-16">Marvel's Guardians of the Galaxy</h5>
									</td>
									<td>2021 年 10 月 27 日</td>
									<td>中文/英文</td>
									<td>輔導級</td>
									<td>1790</td>
									<td>20%</td>
									<td>3.8</td>
									<td>Eidos-Montréal</td>
									<td>Square Enix</td>
									<td class="table-plus">《漫威星際異攻隊》將帶你踏上盪氣迴腸、驚險萬分的星際之旅，透過令人耳目一新的視角任你馳騁星際、縱橫宇宙。玩家將在這部動作冒險遊戲扮演星爵，率領一言不合就爆走的星際異攻隊，闖過一場又一場昏天暗地的大混戰。你沒問題的。應該啦。</td>
									<td>
										<div class="dropdown">
											<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
												<i class="dw dw-more"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
												<a class="dropdown-item view-switch" href="#"><i class="dw dw-eye"></i> 預覽</a>
												<a class="dropdown-item edit-switch" href="#"><i class="dw dw-edit2"></i> 編輯</a>
												<a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> 刪除</a>
											</div>
										</div>
									</td>
								</tr>
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
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->	

    <!-- View model Begin -->
    <div class="view-model">
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
                <div class="row">
                	<div class="col-lg-12">
                		<div class="game__details__text">
                            <div class="section-title">
                                <h5>故事</h5>
                            </div>
                            <p>《星之卡比 探索發現》是《星之卡比》系列第一款 3D 動作遊戲，除了過往熟悉的複製能力，這回還能透過塞滿嘴獲得新能力。
                                故事背景設定在一個「過去已有文明存在的世界」。卡比為了救出被神祕敵人「野獸軍團」俘虜的瓦豆魯迪們而展開冒險，
                                在各關卡中必須與野獸軍團戰鬥、解開難題，遊戲場景豐富度可說是歷代之最。</p>
		                </div> 
                	</div>
                </div>	  
	        </div>
        </div>
    </div>
    <!-- View model end -->


	<!-- Edit model Begin -->
    <div class="edit-model">
        <div class="edit-model-show">
        	<div class="edit-switch-pos">
        		<div class="edit-close-switch"><i class="icon_check"></i></div>
	    		<div class="edit-close-switch"><i class="icon_close"></i></div>	
	    	</div>
	    	<form class="edit-model-form">
		        <div class="container">
		        	<div class="row">
		        		<div class="col-lg-4">
		        			<div class="game__details__pic set-bg" data-setbg="img/product/discount/discount-2.jpg">
	                            <div class="comment"><i class="fa fa-comments"></i> 11</div>
	                            <div class="view"><i class="fa fa-eye"></i> 9141</div>
	                        </div>
	                        <div class="form-group">
		        				<div class="section-title"><h4>預覽圖片</h4></div>	
								<input type="file" class="form-control-file form-control height-auto image-input">
							</div>	
		        		</div>
		        		<div class="col-lg-8">
	        				<div class="container">
	        					<div class="form-group">
	        						<div class="row">
	        							<div class="col-lg-3">
		        							<div class="section-title"><h4>遊戲名稱</h4></div>
		        						</div>
		        						<div class="col-lg-9"><input class="form-control" type="text" id="edit-game-name" placeholder="請輸入遊戲名稱"></div>
	        						</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>發行日期</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control date-picker" id="edit-game-date" placeholder="選擇發行日期" type="text"></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>開發人員</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control" type="text" id="edit-game-developer" placeholder="請輸入開發人員"></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>發行商</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control" type="text" id="edit-game-publisher" placeholder="請輸入發行商"></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>支援語言</h4></div>
		        						</div>
										<div class="col-lg-3">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="languageCheck1">
												<label class="custom-control-label" for="languageCheck1">中文</label>
											</div>
										</div>	
										<div class="col-lg-3">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="languageCheck2">
												<label class="custom-control-label" for="languageCheck2">英文</label>
											</div>
										</div>	
										<div class="col-lg-3">	
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="languageCheck3">
												<label class="custom-control-label" for="languageCheck3">日文</label>
											</div>
										</div>	
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
	        							<div class="col-lg-3">
		        							<div class="section-title"><h4>遊戲分級</h4></div>
		        						</div>
										<div class="col-lg-2">
											<div class="custom-control custom-radio">
												<input type="radio" id="rated1" name="ratedRadio" class="custom-control-input edit-form-Zindex">
												<label class="custom-control-label" for="ratedRadio1">普遍級</label>
											</div>
										</div>	
										<div class="col-lg-2">
											<div class="custom-control custom-radio">
												<input type="radio" id="rated2" name="ratedRadio" class="custom-control-input edit-form-Zindex">
												<label class="custom-control-label" for="ratedRadio2">保護級</label>
											</div>
										</div>	
										<div class="col-lg-2">		
											<div class="custom-control custom-radio">
												<input type="radio" id="rated3" name="ratedRadio" class="custom-control-input edit-form-Zindex">
												<label class="custom-control-label" for="ratedRadio3">輔導級</label>
											</div>
										</div>
										<div class="col-lg-3">		
											<div class="custom-control custom-radio">
												<input type="radio" id="rated4" name="ratedRadio" class="custom-control-input edit-form-Zindex">
												<label class="custom-control-label" for="ratedRadio4">限制級</label>
											</div>
										</div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>價格</h4></div>
		        						</div>
										<div class="col-lg-3 mb-3"><input class="form-control price-input" type="text" id="edit-game-price" placeholder="請輸入價格"></div>	
	        							<div class="col-lg-3">
		        							<div class="section-title"><h4>折扣</h4></div>
		        						</div>
										<div class="col-lg-3 mb-3"><input class="form-control price-input" type="text" id="edit-game-discount" placeholder="請輸入折扣"></div>
	        						</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>故事</h4></div>
		        						</div>
										<div class="col-lg-9">
											<textarea class="form-control" placeholder="請輸入文字敘述"></textarea>
										</div>
	        						</div>		
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