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
						<table class="data-table table hover nowrap" id = "product_table">
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
																<img src="img/product/'. $row["game_picture"].'.jpg" alt="">
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
																	<a class="dropdown-item edit-switch" href="#" id = "btn_update"><i class="dw dw-edit2"></i> 編輯</a>
																	<a class="dropdown-item" href="#" id = "btn_delete"><i class="dw dw-delete-3"></i> 刪除</a>
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
        	<form class="edit-model-form" id = "edit-game-form" method="post">
	        	<div class="edit-switch-pos">
	        		<button class="edit-close-switch" type="submit"><i class="icon_check"></i></button>
		    		<div class="edit-close-switch" id="btn_cancel"><i class="icon_close"></i></div>	
		    	</div>  	
	    		<input type="hidden" name="oper" id="oper" value="insert">
                <input type="hidden" name="edit-game_ID" id="edit-game_ID" value="">
		        <div class="container">
		        	<div class="row">
		        		<div class="col-lg-11">
		        			<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-9">
									<!-- <h3>Demo:</h3> -->
									<div class="img-container">
										<img src="img/product/product_3.jpg" id="image" alt="Picture">
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-3">
									<!-- <h3>Preview:</h3> -->
									<div class="docs-preview clearfix">
										<div class="img-preview preview-lg"></div>
										<div class="img-preview preview-md"></div>
										<div class="img-preview preview-sm"></div>
										<div class="img-preview preview-xs"></div>
									</div>
									<div class="docs-data">
										<div class="input-group input-group-sm">
											<span class="input-group-prepend">
												<label class="input-group-text" for="dataX">X</label>
											</span>
											<input type="text" class="form-control" id="dataX" placeholder="x">
											<span class="input-group-append">
												<span class="input-group-text">px</span>
											</span>
										</div>
										<div class="input-group input-group-sm">
											<span class="input-group-prepend">
												<label class="input-group-text" for="dataY">Y</label>
											</span>
											<input type="text" class="form-control" id="dataY" placeholder="y">
											<span class="input-group-append">
												<span class="input-group-text">px</span>
											</span>
										</div>
										<div class="input-group input-group-sm">
											<span class="input-group-prepend">
												<label class="input-group-text" for="dataWidth">Width</label>
											</span>
											<input type="text" class="form-control" id="dataWidth" placeholder="width">
											<span class="input-group-append">
												<span class="input-group-text">px</span>
											</span>
										</div>
										<div class="input-group input-group-sm">
											<span class="input-group-prepend">
												<label class="input-group-text" for="dataHeight">Height</label>
											</span>
											<input type="text" class="form-control" id="dataHeight" placeholder="height">
											<span class="input-group-append">
												<span class="input-group-text">px</span>
											</span>
										</div>
										<div class="input-group input-group-sm">
											<span class="input-group-prepend">
												<label class="input-group-text" for="dataRotate">Rotate</label>
											</span>
											<input type="text" class="form-control" id="dataRotate" placeholder="rotate">
											<span class="input-group-append">
												<span class="input-group-text">deg</span>
											</span>
										</div>
										<div class="input-group input-group-sm">
											<span class="input-group-prepend">
												<label class="input-group-text" for="dataScaleX">ScaleX</label>
											</span>
											<input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
										</div>
										<div class="input-group input-group-sm">
											<span class="input-group-prepend">
												<label class="input-group-text" for="dataScaleY">ScaleY</label>
											</span>
											<input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
										</div>
									</div>
								</div>
							</div>
							<div class="row" id="actions">
								<div class="col-sm-12 col-md-12 col-lg-9 docs-buttons">
									<!-- <h3>Toolbar:</h3> -->
									<div class="btn-group">
										<button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
												<span class="fa fa-arrows"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
												<span class="fa fa-crop"></span>
											</span>
										</button>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
												<span class="fa fa-search-plus"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
												<span class="fa fa-search-minus"></span>
											</span>
										</button>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
												<span class="fa fa-arrow-left"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
												<span class="fa fa-arrow-right"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
												<span class="fa fa-arrow-up"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
												<span class="fa fa-arrow-down"></span>
											</span>
										</button>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
												<span class="fa fa-rotate-left"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
												<span class="fa fa-rotate-right"></span>
											</span>
										</button>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
												<span class="fa fa-arrows-h"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
												<span class="fa fa-arrows-v"></span>
											</span>
										</button>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-primary" data-method="crop" title="Crop">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.crop()">
												<span class="fa fa-check"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="clear" title="Clear">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.clear()">
												<span class="fa fa-remove"></span>
											</span>
										</button>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-primary" data-method="disable" title="Disable">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
												<span class="fa fa-lock"></span>
											</span>
										</button>
										<button type="button" class="btn btn-primary" data-method="enable" title="Enable">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
												<span class="fa fa-unlock"></span>
											</span>
										</button>
									</div>

									<div class="btn-group">
										<button type="button" class="btn btn-primary" data-method="reset" title="Reset">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
												<span class="fa fa-refresh"></span>
											</span>
										</button>
										<label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
											<input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
											<span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
												<span class="fa fa-upload"></span>
											</span>
										</label>
										<button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.destroy()">
												<span class="fa fa-power-off"></span>
											</span>
										</button>
									</div>

									<div class="btn-group btn-group-crop">
										<button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCroppedCanvas({ maxWidth: 4096, maxHeight: 4096 })">
												Get Cropped Canvas
											</span>
										</button>
										<button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCroppedCanvas({ width: 160, height: 90 })">
												160&times;90
											</span>
										</button>
										<button type="button" class="btn btn-success" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
											<span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCroppedCanvas({ width: 320, height: 180 })">
												320&times;180
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
													<a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
												</div>
											</div>
										</div>
									</div><!-- /.modal -->

									<button type="button" class="btn btn-secondary" data-method="getData" data-option data-target="#putData">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.getData()">
											Get Data
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="setData" data-target="#putData">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.setData(data)">
											Set Data
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="getContainerData" data-option data-target="#putData">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.getContainerData()">
											Get Container Data
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="getImageData" data-option data-target="#putData">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.getImageData()">
											Get Image Data
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="getCanvasData" data-option data-target="#putData">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCanvasData()">
											Get Canvas Data
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="setCanvasData" data-target="#putData">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.setCanvasData(data)">
											Set Canvas Data
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="getCropBoxData" data-option data-target="#putData">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.getCropBoxData()">
											Get Crop Box Data
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="setCropBoxData" data-target="#putData">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.setCropBoxData(data)">
											Set Crop Box Data
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="moveTo" data-option="0">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.moveTo(0)">
											Move to [0,0]
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="zoomTo" data-option="1">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoomTo(1)">
											Zoom to 100%
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="rotateTo" data-option="180">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotateTo(180)">
											Rotate 180°
										</span>
									</button>
									<button type="button" class="btn btn-secondary" data-method="scale" data-option="-2" data-second-option="-1">
										<span class="docs-tooltip" data-toggle="tooltip" title="cropper.scale(-2, -1)">
											Scale (-2, -1)
										</span>
									</button>
									<textarea class="form-control" id="putData" rows="1" placeholder="Get data to here or set data with this value"></textarea>

								</div><!-- /.docs-buttons -->

								<div class="col-sm-12 col-md-12 col-lg-3 docs-toggles">
									<!-- <h3>Toggles:</h3> -->
									<div class="btn-group d-flex flex-wrap" data-toggle="buttons">
										<label class="btn btn-primary active">
											<input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
											<span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">
												16:9
											</span>
										</label>
										<label class="btn btn-primary">
											<input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
											<span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">
												4:3
											</span>
										</label>
										<label class="btn btn-primary">
											<input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
											<span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">
												1:1
											</span>
										</label>
										<label class="btn btn-primary">
											<input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
											<span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">
												2:3
											</span>
										</label>
										<label class="btn btn-primary">
											<input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
											<span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">
												Free
											</span>
										</label>
									</div>

									<div class="btn-group d-flex flex-wrap" data-toggle="buttons">
										<label class="btn btn-primary active">
											<input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
											<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
												VM0
											</span>
										</label>
										<label class="btn btn-primary">
											<input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
											<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
												VM1
											</span>
										</label>
										<label class="btn btn-primary">
											<input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
											<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
												VM2
											</span>
										</label>
										<label class="btn btn-primary">
											<input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
											<span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
												VM3
											</span>
										</label>
									</div>

									<div class="dropdown dropup docs-options">
										<button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
											Toggle Options
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu" aria-labelledby="toggleOptions">
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="responsive" type="checkbox" name="responsive" checked>
													<label class="form-check-label" for="responsive">responsive</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="restore" type="checkbox" name="restore" checked>
													<label class="form-check-label" for="restore">restore</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="checkCrossOrigin" type="checkbox" name="checkCrossOrigin" checked>
													<label class="form-check-label" for="checkCrossOrigin">checkCrossOrigin</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="checkOrientation" type="checkbox" name="checkOrientation" checked>
													<label class="form-check-label" for="checkOrientation">checkOrientation</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="modal" type="checkbox" name="modal" checked>
													<label class="form-check-label" for="modal">modal</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="guides" type="checkbox" name="guides" checked>
													<label class="form-check-label" for="guides">guides</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="center" type="checkbox" name="center" checked>
													<label class="form-check-label" for="center">center</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="highlight" type="checkbox" name="highlight" checked>
													<label class="form-check-label" for="highlight">highlight</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="background" type="checkbox" name="background" checked>
													<label class="form-check-label" for="background">background</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="autoCrop" type="checkbox" name="autoCrop" checked>
													<label class="form-check-label" for="autoCrop">autoCrop</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="movable" type="checkbox" name="movable" checked>
													<label class="form-check-label" for="movable">movable</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="rotatable" type="checkbox" name="rotatable" checked>
													<label class="form-check-label" for="rotatable">rotatable</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="scalable" type="checkbox" name="scalable" checked>
													<label class="form-check-label" for="scalable">scalable</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="zoomable" type="checkbox" name="zoomable" checked>
													<label class="form-check-label" for="zoomable">zoomable</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="zoomOnTouch" type="checkbox" name="zoomOnTouch" checked>
													<label class="form-check-label" for="zoomOnTouch">zoomOnTouch</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="zoomOnWheel" type="checkbox" name="zoomOnWheel" checked>
													<label class="form-check-label" for="zoomOnWheel">zoomOnWheel</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="cropBoxMovable" type="checkbox" name="cropBoxMovable" checked>
													<label class="form-check-label" for="cropBoxMovable">cropBoxMovable</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="cropBoxResizable" type="checkbox" name="cropBoxResizable" checked>
													<label class="form-check-label" for="cropBoxResizable">cropBoxResizable</label>
												</div>
											</li>
											<li class="dropdown-item">
												<div class="form-check">
													<input class="form-check-input" id="toggleDragModeOnDblclick" type="checkbox" name="toggleDragModeOnDblclick" checked>
													<label class="form-check-label" for="toggleDragModeOnDblclick">toggleDragModeOnDblclick</label>
												</div>
											</li>
										</ul>
									</div><!-- /.dropdown -->

								</div><!-- /.docs-toggles -->
							</div>		
	                        <div class="form-group">
		        				<div class="section-title"><h4>預覽圖片</h4></div>	
								<input type="file" class="form-control-file form-control height-auto image-input">
							</div>	
		        		</div>
		        		<div class="col-lg-1">
	        				<div class="container">
	        					<div class="form-group">
	        						<div class="row">
	        							<div class="col-lg-3">
		        							<div class="section-title"><h4>遊戲名稱</h4></div>
		        						</div>
		        						<div class="col-lg-9"><input class="form-control" type="text" name="edit-game-name" id="edit-game-name" placeholder="請輸入遊戲名稱"></div>
	        						</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>發行日期</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control date-picker" data-date-format="yyyy-mm-dd" name = "edit-game-date" id="edit-game-date" placeholder="選擇發行日期" type="text"></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>支援語言</h4></div>
		        						</div>
										<div class="col-lg-3">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="game_lang" name="game_lang" value="1">
												<label class="custom-control-label" for="languageCheck1">繁體中文</label>
											</div>
										</div>	
										<div class="col-lg-3">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="game_lang" name="game_lang" value="2">
												<label class="custom-control-label" for="languageCheck2">英文</label>
											</div>
										</div>	
										<div class="col-lg-3">	
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input edit-form-Zindex" id="game_lang" name="game_lang" value="3">
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
										<div class="col-lg-3 mb-3"><input class="form-control price-input" type="text" name = "edit-game-price" id="edit-game-price" placeholder="請輸入價格"></div>	
	        							<div class="col-lg-3">
		        							<div class="section-title"><h4>折扣</h4></div>
		        						</div>
										<div class="col-lg-3 mb-3"><input class="form-control price-input" type="text" name = "edit-game-discount" id="edit-game-discount" placeholder="請輸入折扣"></div>
	        						</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>開發人員</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control" type="text" name = "edit-game-developer" id="edit-game-developer" placeholder="請輸入開發人員"></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
										<div class="col-lg-3">
		        							<div class="section-title"><h4>發行商</h4></div>
		        						</div>
										<div class="col-lg-9"><input class="form-control" type="text" name = "edit-game-publisher" id="edit-game-publisher" placeholder="請輸入發行商"></div>
									</div>
	        					</div>
	        					<div class="form-group">
	        						<div class="row">	
		        						<div class="col-lg-3">
		        							<div class="section-title"><h4>故事</h4></div>
		        						</div>
										<div class="col-lg-9">
											<textarea class="form-control" name = "edit-game-story" id="edit-game-story" type="text" placeholder="請輸入文字敘述"></textarea>
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
	<script src="vendors/scripts/datatable-setting.js"></script>  	
  	<script src="src/plugins/cropperjs/js/bootstrap.bundle.min.js"></script>
	<script src="src/plugins/cropperjs/js/cropper.js"></script>
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
    <script src="js/main.js"></script>
    <script src="js/crud.js"></script>

	</body>
</html>