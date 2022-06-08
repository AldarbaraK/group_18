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
	<link rel="stylesheet" type="text/css" href="src/plugins/cropperjs/dist/cropper.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/cropperjs/dist/main.css">
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
                <div class="col-lg-10">
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
                                     	<h4 class="text-blue h3">管理商品</h4>
                                </div>
                                <div class="col-lg-2">
                                    <div class="manage-insert">
                                        <button id="game_insert" class="site-btn edit-switch">新增資料</button>
                                    </div>
                                </div>
                            </div>
                        </div>
						<table class="table hover nowrap" id = "game_datatable">
							<thead>
								<tr>
									<th class="datatable-nosort table-plus">預覽圖</th>
									<th>遊戲編號</th>
									<th>遊戲名稱</th>
									<th>發行日期</th>
									<th class="datatable-nosort">支援語言</th>
									<th class="datatable-nosort">遊戲分級</th>
									<th>價格</th>
									<th>折扣</th>
									<th>評分</th>
									<th>開發人員</th>
									<th>發行商</th>
									<th class="table-plus">故事</th>
									<th class="datatable-nosort">動作</th>
								</tr>
							</thead>
							<tbody> 
								<?php 
	                                if ($result = mysqli_query($link, "SELECT * FROM game_info a LEFT JOIN (SELECT game_ID,round(AVG(deal_score),1) avg_score FROM deal_record GROUP BY game_ID) c ON a.game_ID = c.game_ID,game_pic b WHERE a.game_ID = b.game_ID")) {
		                                    while ($row = mysqli_fetch_assoc($result)) {
		                                        	echo '<tr>
														<td>
															<div class="image-view">
																<img id="datatable-img'. $row["game_ID"].'" src="img/product/'. $row["game_picture"].'.jpg" alt="">
															</div>
														</td>
														<td>'. $row["game_ID"].'</td>
														<td>'. $row["game_name"].'</td>
														<td>'. $row["game_date"].'</td>
														<td>';
														if ($langResult = mysqli_query($link, "SELECT * FROM game_language a WHERE a.game_ID = '". $row["game_ID"] ."'")){
															$lang_num = mysqli_num_rows($langResult); //查詢結果筆數
															$lang_cnt = 0;
                                                            while ($lang = mysqli_fetch_assoc($langResult)) {
                                                                	echo $lang["game_lang"];
                                                                	if($lang_cnt != $lang_num - 1) echo'/';
                                                                	$lang_cnt ++;
                                                            }  
                                                            mysqli_free_result($langResult); // 釋放佔用的記憶體 
                                                        } 
														echo'</td>
														<td>'. $row["game_rating"].'</td>
														<td>'. $row["game_price"].'</td>
														<td>'. $row["game_discount"].'%</td>
														<td>'. $row["avg_score"].'</td>
														<td>'. $row["game_developer"].'</td>
														<td>'. $row["game_publisher"].'</td>
														<td class="table-plus">'. $row["game_story"].'</td>
														<td>
															<div class="dropdown">
																<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown" id = "test">
																	<i class="dw dw-more"></i>
																</a>
																<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
																	<a class="dropdown-item view-switch" href="#"><i class="dw dw-eye"></i> 預覽</a>
																	<a class="dropdown-item edit-switch" href="#" id= "game_update"><i class="dw dw-edit2"></i> 編輯</a>
																	<a class="dropdown-item" href="#" id="game_delete"><i class="dw dw-delete-3"></i> 刪除</a>
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
        	<form class="edit-model-form" id = "edit-game-form" method="post">
        		<input type="hidden" name="tableType" id="tableType" value="gameTable">
        		<input type="hidden" name="oper" id="oper" value="insert">
           		<input type="hidden" name="edit-game_ID" id="edit-game_ID" value="">
	        	<div class="edit-switch-pos">
	        		<button class="edit-close-switch" type="submit" id="game_save"><i class="icon_check"></i></button>
		    		<div class="edit-close-switch" id="game_cancel"><i class="icon_close"></i></div>	
		    	</div>  	
		        <div class="container">
		        	<div class="row">
		        		<div class="col-lg-5">
		        			<div class="form-group">
		        				<div class="row">
		        					<div class="col-sm-4 col-md-4 col-lg-4">
			        					<div class="section-title"><h4>預覽圖片</h4></div>
			        				</div>
			        				<div class="col-sm-4 col-md-4 col-lg-4">
			        					<div class="btn-group">
											<button type="button" class="btn btn-color" data-method="setDragMode" data-option="crop" title="Crop">
												<span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
													<span class="fa fa-crop"></span>
												</span>
											</button>
									        <button type="button" class="btn btn-color" data-method="reset" title="Reset">
												<span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
													<span class="fa fa-refresh"></span>
												</span>
											</button>
											<label class="btn btn-upload btn-color" for="inputImage" title="Upload image file">
												<input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
												<span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
													<span class="fa fa-upload"></span>
												</span>
											</label>
										</div>       					
			        				</div>
			        				<div class="col-sm-2 col-md-2 col-lg-2">
			        					<div class="docs-preview clearfix">
								          <div class="img-preview preview-md"></div>
								        </div>
			        				</div>
			        			</div>	
							</div>	
		        			<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12">
									<div class="docs-demo">
										<div class="img-container">
											<img src="img/product/default.png" id="image" alt="Picture">
										</div>
									</div>	
								</div>
							</div>
							<div class="row" id="actions">
								<div class="col-sm-12 col-md-12 col-lg-12 docs-buttons">	
									<div class="btn-group">
										<button type="button" class="btn btn-color" data-method="zoom" data-option="0.1" title="Zoom In">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
												<span class="fa fa-search-plus"></span>
											</span>
										</button>
										<button type="button" class="btn btn-color" data-method="zoom" data-option="-0.1" title="Zoom Out">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
												<span class="fa fa-search-minus"></span>
											</span>
										</button>
									</div>
									<div class="btn-group">
										<button type="button" class="btn btn-color" data-method="rotate" data-option="-45" title="Rotate Left">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
												<span class="fa fa-rotate-left"></span>
											</span>
										</button>
										<button type="button" class="btn btn-color" data-method="rotate" data-option="45" title="Rotate Right">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
												<span class="fa fa-rotate-right"></span>
											</span>
										</button>
									</div>
									<div class="btn-group">
										<button type="button" class="btn btn-color" data-method="scaleX" data-option="-1" title="Flip Horizontal">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
												<span class="fa fa-arrows-h"></span>
											</span>
										</button>
										<button type="button" class="btn btn-color" data-method="scaleY" data-option="-1" title="Flip Vertical">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
												<span class="fa fa-arrows-v"></span>
											</span>
										</button>
									</div>
									<div class="btn-group">
										<button type="button" class="btn btn-color" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
												<span class="fa fa-arrow-left"></span>
											</span>
										</button>
										<button type="button" class="btn btn-color" data-method="move" data-option="10" data-second-option="0" title="Move Right">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
												<span class="fa fa-arrow-right"></span>
											</span>
										</button>
										<button type="button" class="btn btn-color" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
												<span class="fa fa-arrow-up"></span>
											</span>
										</button>
										<button type="button" class="btn btn-color" data-method="move" data-option="0" data-second-option="10" title="Move Down">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
												<span class="fa fa-arrow-down"></span>
											</span>
										</button>
									</div>

									<!-- Show the cropped image in modal -->
									<div class="modal fade docs-cropped" id="getCroppedCanvasModal" role="dialog" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body"></div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
													<a class="btn btn-color" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
												</div>
											</div>
										</div>
									</div><!-- /.modal -->
								</div><!-- /.docs-buttons -->
								<div class="col-sm-12 col-md-12 col-lg-3 docs-toggles">
								</div>
							</div>			             
		        		</div>
		        		<div class="col-lg-7">
	        				<div class="container">
	        					<div class="form-group">
	        						<div class="row">
	        							<div class="col-lg-3">
		        							<div class="section-title"><h4>遊戲名稱</h4></div>
		        						</div>
		        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-game-name" id="edit-game-name" placeholder="請輸入遊戲名稱"><label for="edit-game-name" class="error"></label></div>
	        						</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>發行日期</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control date-picker" data-date-format="yyyy-mm-dd" name = "edit-game-date" id="edit-game-date" placeholder="選擇發行日期" type="text"><label for="edit-game-date" class="error"></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>支援語言</h4></div>
		        						</div>
										<div class="col-lg-3">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="game_lang" name="game_lang[]" value="1">
												<label class="custom-control-label" for="languageCheck1">繁體中文</label>
											</div>
										</div>	
										<div class="col-lg-3">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="game_lang" name="game_lang[]" value="2">
												<label class="custom-control-label" for="languageCheck2">英文</label>
											</div>
										</div>	
										<div class="col-lg-3">	
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="game_lang" name="game_lang[]" value="3">
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
												<input type="radio" id="game_rated" name="game_rated" value = "G" class="custom-control-input edit-form-Zindex">
												<label class="custom-control-label" for="ratedRadio1">普通級</label>
												<label for="game_rated" class="error"></label>
											</div>
										</div>	
										<div class="col-lg-2">
											<div class="custom-control custom-radio">
												<input type="radio" id="game_rated" name="game_rated" value = "PG" class="custom-control-input edit-form-Zindex">
												<label class="custom-control-label" for="ratedRadio2">保護級</label>
											</div>
										</div>	
										<div class="col-lg-2">		
											<div class="custom-control custom-radio">
												<input type="radio" id="game_rated" name="game_rated" value = "PG-13" class="custom-control-input edit-form-Zindex">
												<label class="custom-control-label" for="ratedRadio3">輔導級</label>
											</div>
										</div>
										<div class="col-lg-3">		
											<div class="custom-control custom-radio">
												<input type="radio" id="game_rated" name="game_rated" value = "R" class="custom-control-input edit-form-Zindex">
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
										<div class="col-lg-3 mb-3"><input class="form-control price-input" type="text" name = "edit-game-price" id="edit-game-price" placeholder="請輸入價格"><label for="edit-game-price" class="error"></label></div>	
	        							<div class="col-lg-3">
		        							<div class="section-title"><h4>折扣</h4></div>
		        						</div>
										<div class="col-lg-3 mb-3"><input class="form-control price-input" type="text" name = "edit-game-discount" id="edit-game-discount" placeholder="請輸入折扣"><label for="edit-game-discount" class="error"></label></div>
	        						</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>開發人員</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control" type="text" name = "edit-game-developer" id="edit-game-developer" placeholder="請輸入開發人員"><label for="edit-game-developer" class="error"></label></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
										<div class="col-lg-3">
		        							<div class="section-title"><h4>發行商</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control" type="text" name = "edit-game-publisher" id="edit-game-publisher" placeholder="請輸入發行商"><label for="edit-game-publisher" class="error"></label></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>故事</h4></div>
		        						</div>
										<div class="col-lg-9">
											<textarea class="form-control" name = "edit-game-story" id="edit-game-story" type="text" placeholder="請輸入文字敘述"></textarea>
											<label for="edit-game-story" class="error"></label>
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
	<!-- js插件 -->	
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
  	<script src="src/plugins/cropperjs/dist/bootstrap.bundle.min.js"></script>
	<script src="src/plugins/cropperjs/dist/cropper.js"></script>
	<script src="src/plugins/cropperjs/dist/cropper-init.js"></script>
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