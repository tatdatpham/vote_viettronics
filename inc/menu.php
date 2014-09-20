<?php
	$errors=array();
	if(isset($_POST['submit_login'])){ 
		$email = $mysqli->real_escape_string($_POST['email']);
		$password = md5($mysqli->real_escape_string($_POST['password']));
		
		$check_user = $mysqli->query("SELECT * FROM account WHERE `email` ='$email' and `password` = '$password'"); 
		//kiem tra username da duoc dung chua
		$check_user_row = $check_user->fetch_row();
		if($check_user_row == 0){
			$errors[] = "Email hoặc mật khẩu bạn nhập không đúng";
		} else{
			
			$info_user = $mysqli->query("SELECT * FROM account WHERE email ='$email' and password = '$password'");
			$row= $info_user->fetch_object();
			$_SESSION['account'] = TRUE;
			$_SESSION['email'] = $row->email;
			$_SESSION['fullname'] = $row->fullname;
			$_SESSION['account_id']   = $row->id;
			$_SESSION['avatar']   = $row->avatar;
			$_SESSION['unit_id'] = $row->unit_id;
			$_SESSION['status'] = $row->status;
			header('location:'.$base_url.'');
		}
	}

	$bxh = $mysqli->query("SELECT COUNT(*)as vote, account_id_voted, unit_id, unit_name,avatar,id FROM vote_info WHERE status = '2' GROUP BY account_id ORDER BY vote DESC LIMIT 5");
	$stt =1;
	//mau sac cua top (vi tri)
	$pos=array("","danger","warning","success","primary","default");

?>
<body>
		<!--wide layout-->
		<div class="wide_layout relative">

			<header role="banner">
				<!--header top part-->
				<section class="h_top_part">
					<div class="container">
						<div class="row clearfix">
							<div class="col-lg-4 col-md-4 col-sm-5 t_xs_align_c">
								<a><p class="f_size_small">Chào mừng tới hệ thống bình chọn giảng viên	</p></a>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-2 t_align_c t_xs_align_c">
								<p class="f_size_small">Cao Đẳng Công Nghệ <b class="color_dark">VIETTRONICS</b></p>
							</div>
							<nav class="col-lg-4 col-md-4 col-sm-5 t_align_r t_xs_align_c">
								<ul class="d_inline_b horizontal_list clearfix f_size_small users_nav scheme_color">
									<?php
									if(!isset($_SESSION['fullname'])){
										echo '<li><a href="#" data-popup="#login_popup">Đăng nhập</a></li>';
										echo '<li><a href="#" data-popup="#login_popup">Đăng ký</a></li>';
									}else{

										echo '<li>Xin chào <a href="'.$base_url.'profile-'.$_SESSION['account_id'].'.html" class="scheme_color"><strong>'.$_SESSION['fullname'].'</strong></a></li>';
										echo '<li><a href="logout" class="scheme_color">Đăng xuất</a></li>';
									}
									?>
									
								</ul>
							</nav>
						</div>
					</div>
				</section>
				<!--header bottom part-->
				<section class="h_bot_part container">
					<div class="clearfix row">
						<div class="col-lg-2 col-md-2 col-sm-3 t_xs_align_c">
							<a href="<?php echo $base_url;?>" class="logo m_xs_bottom_15 d_xs_inline_b">
								<img src="images/logo.png" alt="">
							</a>
						</div>
						<div class="col-lg-7 col-md-7 col-sm-7 t_align_r t_xs_align_c">

								<center><h2 style="padding-top:15px; padding-left: 110px;" class="scheme_color">HỆ THỐNG BÌNH CHỌN GIẢNG VIÊN</h2></center>
							
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 t_align_r t_xs_align_c">
							<ul class="d_inline_b horizontal_list clearfix t_align_l site_settings">
								
								<!--Bang xep hang-->
								<li class="m_left_5 relative container3d" id="shopping_button" style="padding-top:5px;">

									<a  role="button" href="#" class="button_type_3 color_light bg_scheme_color d_block r_corners tr_delay_hover box_s_none">
										<span class="d_inline_middle shop_icon m_mxs_right_0">
											<i class="fa fa-sort-alpha-asc"></i>
											
										</span>
										<b class="d_mxs_none">Bảng Xếp Hạng</b>
									</a>
									<div class="shopping_cart top_arrow tr_all_hover r_corners">
										<div class="f_size_medium sc_header"></div>
										<ul class="products_list">
										<?php 
											while ($obj_bxh = $bxh->fetch_object()) {
											echo'	
												<li>
													<div class="clearfix">
														<!--product image-->
														<img class="f_left m_right_10 img-circle" src="images/avatar/'.$obj_bxh->avatar.'" height="40" width="40" alt="">
														<!--product description-->
														<div class="f_left product_description">
															<a href="'.$base_url.'user-'.$obj_bxh->id.'.html" class="color_dark m_bottom_5 d_block">'.$obj_bxh->account_id_voted.'</a>
															<span class="f_size_medium scheme_color">'.$obj_bxh->vote.' phiếu</span>
														</div>
														<!--product price-->
														<div class="f_right f_size_medium">
															<div class="clearfix" style="padding-top:9px; padding-right:9px;">
																<button class="btn btn-'.$pos[$stt].' btn-xs">TOP '.$stt.'</button>
															</div>
														</div>
													</div>
												</li>';
												$stt = $stt +1;
											} ?>
											
											
										</ul>
										<!--xem bang xep hang-->
										<a href="<?php echo $base_url?>top"><button class="btn btn-danger btn-square btn-block">Xem tất cả</button></a>
									
									</div>
								</li>
							</ul>
						</div>
					</div>
				</section>
				<!--main menu container-->
				<section class="menu_wrap relative">
					<div class="container clearfix">
						<!--button for responsive menu-->
						<button id="menu_button" class="r_corners centered_db d_none tr_all_hover d_xs_block m_bottom_10">
							<span class="centered_db r_corners"></span>
							<span class="centered_db r_corners"></span>
							<span class="centered_db r_corners"></span>
						</button>
						<!--main menu-->
						<nav role="navigation" class="f_left f_xs_none d_xs_none">	
							<ul class="horizontal_list main_menu clearfix">
								<li class="current relative f_xs_none m_xs_bottom_5"><a href="<?php echo $base_url;?>" class="tr_delay_hover color_light tt_uppercase"><b>Trang chủ</b></a></li>
								<li class="relative f_xs_none m_xs_bottom_5"><a href="#" class="tr_delay_hover color_light tt_uppercase"><b>Mục đích - Yêu cầu</b></a></li>
								<li class="relative  f_xs_none m_xs_bottom_5"><a href="category_grid.html" class="tr_delay_hover color_light tt_uppercase"><b>Đối tượng - Tiêu chuẩn</b></a></li>
								<li class="relative f_xs_none m_xs_bottom_5"><a href="blog.html" class="tr_delay_hover color_light tt_uppercase"><b>Hướng dẫn</b></a></li>
								<?php if(isset($_SESSION['status'])){
									if($_SESSION['status'] == 3){
									echo '<li class="relative f_xs_none m_xs_bottom_5"><a href="'.$base_url.'add-user" class="tr_delay_hover color_light tt_uppercase"><b>Thêm giảng viên</b></a></li>';
									}
								}
								?>
							</ul>
						</nav>
						<button class="f_right search_button tr_all_hover f_xs_none d_xs_none">
							<i class="fa fa-search"></i>
						</button>
					</div>
					<!--search form-->
					<div class="searchform_wrap tf_xs_none tr_all_hover">
						<div class="container vc_child h_inherit relative">
							<form role="search" class="d_inline_middle full_width" method="post">
								<input type="text" name="search" id="keyword" placeholder="Type text and hit enter" class="f_size_large">
							</form>
							 <ul id="content"></ul>
							<button class="close_search_form tr_all_hover d_xs_none color_dark">
								<i class="fa fa-times"></i>
							</button>
						</div>
					</div>
				</section>
			</header>

			<!--login popup-->

			<div class="popup_wrap d_none" id="login_popup">
			<section class="popup r_corners shadow">
				<button class="bg_tr color_dark tr_all_hover text_cs_hover close f_size_large"><i class="fa fa-times"></i></button>
				<h3 class="m_bottom_20 color_dark">Đăng nhập</h3>
				<form method="POST">
					<ul>
						<li class="m_bottom_15">
							<label for="username" class="m_bottom_5 d_inline_b">Email</label><br>
							<input type="email" name="email" class="r_corners full_width">
						</li>
						<li class="m_bottom_25">
							<label for="password" class="m_bottom_5 d_inline_b">Mật khẩu</label><br>
							<input type="password" name="password" class="r_corners full_width">
						</li>
						<li class="m_bottom_15">
							<input type="checkbox" class="d_none"><label for="checkbox_10">Ghi nhớ</label>
						</li>
						<li>
							<button type="submit" name="submit_login" class="button_type_4 tr_all_hover r_corners f_left bg_scheme_color color_light f_mxs_none m_mxs_bottom_15">Đăng nhập</button>
							
						</li>
					</ul>
				</form>
				
			</section>
		</div>