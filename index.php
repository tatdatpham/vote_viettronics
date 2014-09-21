<?php 
	$title ='Trang chủ - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
	include('inc/header.php'); 
	include('inc/menu.php'); 

	if(isset($_GET['filter'])){
		$id = $_GET['filter'];
		$results = $mysqli->query("SELECT * FROM `account_info` WHERE `unit_id` = '$id' AND `status` ='2'");
	}elseif(isset($_POST['filter_unit'])){
		$unit_id = $_POST['filter_unit'];
		$results = $mysqli->query("SELECT * FROM `account_info` WHERE `unit_id` = '$unit_id' AND `status` ='2'");
	}
	else{ 
		$results = $mysqli->query("SELECT * FROM `account_info` WHERE `status` ='2'");
	}

	

	
?>

<title><?php echo $title;?></title>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo $base_url;?>" class="default_t_color">Trang chủ<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9">
				<img class="r_corners m_bottom_40" src="images/category_img_1.jpg" alt="">
				<!--categories nav-->

				
				<!--sort-->
				<div class="row clearfix m_bottom_10">
					<div class="col-lg-7 col-md-8 col-sm-12 m_sm_bottom_10">
						<p class="d_inline_middle f_size_medium">Tất cả giảng viên:</p>
						<div class="clearfix d_inline_middle m_left_10">
						
							<a href="<?php echo $base_url;?>"><button class="button_type_7 bg_light_color_1 color_dark tr_all_hover r_corners mw_0 box_s_none bg_cs_hover f_left m_left_5"><i class="fa fa-sitemap m_left_0 m_right_0"></i></button></a>
						</div>
						<!--manufacturer select-->
						<div class="custom_select f_size_medium relative d_inline_middle m_left_15 m_xs_left_5 m_mxs_left_0 m_mxs_top_10">
							<div class="select_title r_corners relative color_dark">Tất cả giảng viên</div>
							<ul class="select_list d_none"></ul>
							<form class="select_list d_none">
							<select>
								<?php 
								$sql_u2 = $mysqli->query("SELECT * FROM `unit`");
								while ($obj_u2 = $sql_u2->fetch_object()) {
									echo '<option>'.$obj_u2->unit_name.'</option>';
								}
								?>
							</select>
							<form>
						</div>
					</div>
					<div class="col-lg-5 col-md-4 col-sm-12 t_align_r t_sm_align_l">
						<!--grid view or list view-->
						<p class="d_inline_middle f_size_medium m_right_5">Xem với:</p>
						<div class="clearfix d_inline_middle">
							<button class="button_type_7 bg_scheme_color color_light tr_delay_hover r_corners mw_0 box_s_none bg_cs_hover f_left"><i class="fa fa-th m_left_0 m_right_0"></i></button>
							<button class="button_type_7 bg_light_color_1 color_dark tr_delay_hover r_corners mw_0 box_s_none bg_cs_hover f_left m_left_5"><i class="fa fa-th-list m_left_0 m_right_0"></i></button>
						</div>
					</div>
				</div>
				<hr class="m_bottom_10 divider_type_3">
				
				<!--products-->
				<section class="products_container category_grid clearfix m_bottom_15">
					<?php 
					
					while($obj = $results->fetch_object()){
					echo '
						<div class="product_item hit w_xs_full">
							<figure class="r_corners photoframe type_2 t_align_c tr_all_hover shadow relative">
								<!--product preview-->
								<a href="#" class="d_block relative wrapper pp_wrap m_bottom_15">
									<img src="images/avatar/'.$obj->avatar.'" height="187" width="187" class="tr_all_hover" alt="">
									<span role="button" data-popup="#quick_view_product_'.$obj->id.'" class="button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">Xem</span>
								</a>
								<!--description and price of product-->
								<figcaption>';
									$account_id = $obj->id;
									$sql_v = $mysqli->query("SELECT COUNT(*) AS vote FROM `vote` WHERE `account_id` = '$account_id'");
									$obj_v = $sql_v->fetch_object();

									echo '
									<h5 class="m_bottom_10"><a href="'.$base_url.'user-'.$obj->id.'.html" class="color_dark">GV. '.$obj->fullname.' </a></h5>
									<p><span class="scheme_color"> '.$obj_v->vote.' phiếu</span></p>';
									echo'
								</figcaption>
							</figure>
						</div>';

						//Custom popup
					echo'
					<!--custom popup-->
						<div class="popup_wrap d_none" id="quick_view_product_'.$obj->id.'">
							<section class="popup r_corners shadow">
								<button class="bg_tr color_dark tr_all_hover text_cs_hover close f_size_large"><i class="fa fa-times"></i></button>
								<div class="clearfix">
									<div class="custom_scrollbar">
										<!--left popup column-->
										<div class="f_left half_column">
											<div class="relative d_inline_b m_bottom_10 qv_preview">
												
												<img src="images/avatar/'.$obj->avatar.'" height="360" width="360" class="tr_all_hover" alt="">
											</div>
											
											
										</div>
										<!--right popup column-->
										<div class="f_right half_column">
											<!--description-->
											<h2 class="m_bottom_10"><a href="#" class="scheme_color fw_medium">GV. '.$obj->fullname.'</a></h2>
											
											<hr class="m_bottom_10 divider_type_3">
											
											<h5 class="scheme_color fw_medium m_bottom_10">Khoa / Bộ môn giảng dạy</h5>
											<table class="description_table m_bottom_5">
												<tr>
													<td>Khoa:</td>
													<td><span class="scheme_color">'.$obj->unit_name.'</span></td>
												</tr>
												<tr>
													<td>Giảng dạy:</td>
													<td class="scheme_color">'.$obj->teaching.'</td>
												</tr>
											</table>
											<hr class="divider_type_3 m_bottom_10">
											<p class="m_bottom_10">'.mb_substr($obj->introduced,0,225).'...... <a href="'.$base_url.'user-'.$obj->id.'.html" class="scheme_color">(Xem tiếp)</a></p>
											<hr class="divider_type_3 m_bottom_15">
											<div class="m_bottom_15">';
											echo 	'Lượt bình chọn: <span class="v_align_b f_size_big m_left_5 scheme_color fw_medium">'.$obj_v->vote.'</span>
											</div>
											
										</div>
									</div>
								</div>
							</section>
						</div>';
					}
					?>
				</section>

			</section>
			<!--right column-->
			
			
			<?php include('inc/sidebar.php'); ?>
		</div>
	</div>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<?php include('inc/footer.php');