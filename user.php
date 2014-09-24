<?php 
	
	include('inc/header.php'); 
	include('inc/menu.php'); 

	
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current = date('Y-m-d H:i:s', time());
		//check thoi gian binh chon va chuc nang binh chon duoc kich hoat hay khong
		$sql_v = $mysqli->query("SELECT * FROM `vote_time` WHERE `id` = '1'");
		$obj_v = $sql_v->fetch_object();
		$timestart = $obj_v->timestart;
		$timeend = $obj_v->timeend;
		$active = $obj_v->active;
		//kiem tra xem có ton tia nguoi dung nay khong
		$check_id = $mysqli->query("SELECT * FROM `account_info` WHERE `id` = '$id' AND status ='2'");
		
		$check = $check_id->fetch_row();
		if($check != 0){
			//neu ton tia thi lay ra thong tin nguoi dung do
			$results = $mysqli->query("SELECT * FROM `account_info` WHERE `id` = '$id' AND status ='2'");
			$obj = $results->fetch_object();
			$unit_id = $obj->unit_id;
			//lay ra so luot binh chon cua user dang xem
			$results_v = $mysqli->query("SELECT COUNT(*) AS vote FROM `vote` WHERE `account_id` = '$id'");
			$obj_v1 = $results_v->fetch_object();

			// binh chon
			if(isset($_POST['submit_vote'])){
				$voter = $mysqli->real_escape_string($_POST['voter']);
				$account = $mysqli->real_escape_string($_POST['account']);
				$sql_c1 = $mysqli->query("SELECT * FROM `vote` WHERE `account_vote` = '$voter'");
				$row1 = $sql_c1->fetch_row();
				if($row1 == 0){
					$sql_c2 = $mysqli->query("INSERT INTO `vote`(`account_id`,`account_vote`,`time`) VALUES ('$account','$voter',CURRENT_TIMESTAMP)");
				}else{
					exit('<br><div class="row clearfix">
								<div class="col-lg-4 col-md-4 col-sm-3"></div>
								<div class="col-lg-4 col-md-4 col-sm-6">
									<div class="alert_box r_corners error m_bottom_10">
										<i class="fa fa-exclamation-triangle"></i>Rất tiếc, bạn đã vote! Bạn chỉ được Vote 1 lần duy nhất.<p><a href="http://localhost/vote/">Quay lại</a></p>
									</div>
								</div>
						');
				}
			}
			$title =$obj->fullname.' - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
		}else {$title ='Không tim thấy trang - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';}
?>

<title><?php echo $title;?></title>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo $base_url;?>" class="default_t_color">Trang chủ<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li class="m_right_10"><a href="#" class="default_t_color">Giảng viên</a><i class="fa fa-angle-right d_inline_middle m_left_10"></i></li>
			<?php if($check == 0){
				echo '<li><a href="#" class="default_t_color">Không tìm thấy trang</a></li>';
			}else{
				echo '<li><a href="#" class="default_t_color">'.$obj->fullname.'</a></li>';
			}?>	
		</ul>
	</div>
</section>
	<!--content-->
	<div class="page_content_offset">
	<div class="container">
	<div class="row clearfix">
		<!--left content column-->
		<section class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30">
		<?php if($check == 0){
			echo '<h2> Không tìm thấy trang! 
					<a href="'.$base_url.'" class="scheme_color"> 
						<span class="d_inline_middle shop_icon m_mxs_right_0">
							<i class="fa fa-mail-reply"></i>
													
						</span>Trở về 
					</a>
				</h2>';
		}else { ?>
			<div class="clearfix m_bottom_30 t_xs_align_c">
				<div class="photoframe type_2 shadow r_corners f_left f_sm_none d_xs_inline_b product_single_preview relative m_right_30 m_bottom_5 m_sm_bottom_20 m_xs_right_0 w_mxs_full">
			
				<div class="relative d_inline_b m_bottom_10 qv_preview d_xs_block">
					<img id="zoom_image" src="images/avatar/<?php echo $obj->avatar;?>" height="438" width="438" class="tr_all_hover" alt="">
				</div>

			</div>
			<div class="p_top_10 t_xs_align_l">
				<!--description-->
				<h2 class="color_dark fw_medium m_bottom_10">GV. <?php echo $obj->fullname;?></h2>
				<div class="m_bottom_10">
					<!--rating-->
					<ul class="horizontal_list d_inline_middle type_2 clearfix rating_list tr_all_hover">
						
						<li class="active">
							<i class="fa fa-star active tr_all_hover"></i>
						</li>
						<li class="active">
							<i class="fa fa-star active tr_all_hover"></i>
						</li>
					</ul>
					<a href="#" class="d_inline_middle default_t_color f_size_small m_left_5">Top 1 </a>
				</div>
				<hr class="m_bottom_10 divider_type_3">
				<h5 class="fw_medium m_bottom_10">Khoa / Bộ môn giảng dạy</h5>
				<table class="description_table m_bottom_5">
					<tr>
						<td>Khoa:</td>
						<td><span class="scheme_color"><?php echo $obj->unit_name?></span></td>
					</tr>
					<tr>
						<td>Giảng dạy:</td>
						<td class="scheme_color"><?php echo $obj->teaching?></td>
					</tr>
				</table>
				
				
				<hr class="divider_type_3 m_bottom_15">
				<div class="m_bottom_15">
					Lượt bình chọn: <span class="v_align_b f_size_big m_left_5 scheme_color fw_medium"><?php echo $obj_v1->vote;?></span>
				</div>
				
				<?php 
				if(!isset($_SESSION['fullname'])){
					echo '
						<div class="clearfix m_bottom_15">
							<button class="button_type_4 r_corners bg_scheme_color color_light tr_delay_hover f_left f_size_medium" data-popup="#login_popup">
							  Đăng nhập để bình chọn
							</button>
						</div>
				';
					}
		if(isset($_SESSION['fullname'])){
			if($active == 0){
				echo '
				<div class="clearfix m_bottom_15">
					<button class="button_type_4 r_corners bg_scheme_color color_light tr_delay_hover f_left f_size_medium">
					  Chức năng bình chọn đã đóng
					</button>
				</div>';
			}else{
				if(strtotime($current) > strtotime($timestart) && strtotime($current) < strtotime($timeend)) {
					$tk_id = $_SESSION['account_id'];
					$check_vote1 = $mysqli->query("SELECT * FROM `vote` WHERE `account_vote` = $tk_id");
					$check_row1 = $check_vote1->fetch_row();
					if($check_row1 == 0){
				 ?>
				<div class="clearfix m_bottom_15">
					<button class="button_type_4 r_corners bg_scheme_color color_light tr_delay_hover f_left f_size_medium" data-toggle="modal" data-target="#myModal">
					  Bình chọn
					</button>

					<!-- Modal -->
					<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div id="text-popup" class="danger-popup mfp-with-anim mfp-hide">
								<div class="row">
									<center><p>Bạn có chắc chắn muốn bình chọn cho:<br></p></center>
									<br>
									<form method="POST">
										<div class="col-xs-1"></div>
										<div class="col-xs-7"><img src="images/avatar/<?php echo $obj->avatar;?>" class="avatar img-circle" alt="avatar"><?php echo $obj->fullname;?>
										</div>
										<div class="col-xs-3">
											
											<input type="hidden" value="<?php echo $_SESSION['account_id'];?>" name="voter">
											<input type="hidden" value="<?php echo $id ;?>" name="account">
											<button type="submit" name="submit_vote"  class="btn btn-success f_left f_size_medium">Đồng ý</button>
										</div>
										<div class="col-xs-1"></div>
									</form>
								</div>
							</div>
					    </div>
					  </div>
					</div>
					
					
				</div>
				<?php
					}else{
						$check_vote2 = $mysqli->query("SELECT * FROM `vote` WHERE `account_vote` = '$tk_id' AND `account_id` = '$id'");
						$check_row2 = $check_vote2->fetch_row();
						if($check_row2 != 0){
							echo '
							<div class="clearfix m_bottom_15">
								<button class="button_type_4 r_corners bg_scheme_color color_light tr_delay_hover f_left f_size_medium">Đã bình chọn</button>
							</div>';
						}
					}
				}else{
					echo '
						<div class="clearfix m_bottom_15">
							<button class="button_type_4 r_corners bg_scheme_color color_light tr_delay_hover f_left f_size_medium">
							  Không phải thời gian bình chọn
							</button>
						</div>';
				}
			}
			}
			?>
				<hr class="divider_type_3 m_bottom_10">
				<p class="m_bottom_10"><?php echo $obj->introduced;?></p>
				
			</div>
		</div>
		<hr class="m_bottom_10 divider_type_3">
		<div class="clearfix">
			<h2 class="color_dark tt_uppercase f_left m_bottom_15 f_mxs_none">Các giảng viên cùng khoa</h2>
			<div class="f_right clearfix nav_buttons_wrap f_mxs_none m_mxs_bottom_5">
				<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large t_align_c bg_light_color_1 f_left tr_delay_hover r_corners rp_prev"><i class="fa fa-angle-left"></i></button>
				<button class="button_type_7 bg_cs_hover box_s_none f_size_ex_large t_align_c bg_light_color_1 f_left m_left_5 tr_delay_hover r_corners rp_next"><i class="fa fa-angle-right"></i></button>
			</div>
		</div>

		<div class="related_projects m_bottom_15 m_sm_bottom_0 m_xs_bottom_15">
		<?php 
			$sql = $mysqli->query("SELECT * FROM `account_info` WHERE `unit_id` = '$unit_id' AND `id` <> '$id' AND `status`= '2'");
			while ($obj_r = $sql->fetch_object()) {
		?>
			<figure class="r_corners photoframe shadow relative d_xs_inline_b tr_all_hover">
				<!--product preview-->
				<a href="<?php echo $base_url.'user.php?id='.$obj_r->id;?>" class="d_block relative pp_wrap">
					<!--hot product-->
					
					<img src="images/avatar/<?php echo $obj_r->avatar;?>" class="tr_all_hover" height="242" width="242" alt="">
					
				</a>
				<!--description and price of product-->
				<?php 
				$account_id = $obj_r->id;
				$sql_v = $mysqli->query("SELECT COUNT(*) AS vote FROM `vote` WHERE `account_id` = '$account_id'");
				$obj_v = $sql_v->fetch_object();
				?>

				<figcaption><center>
					<h5 class="m_bottom_10"><a href="<?php echo $base_url.'user.php?id='.$obj_r->id;?>" class="scheme_color"><?php echo $obj_r->fullname;?></a></h5>
					<div class="clearfix">
						<span class="scheme_color f_size_large m_bottom_15"><?php echo $obj_v->vote;?></span> phiếu
						
					</div></center>
					
				</figcaption>
			</figure>
		<?php }?>	
		</div>
		<?php }?> <!-- ket thuc if else	-->
		</section>

			
			<?php include('inc/sidebar.php'); ?>
		</div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<?php include('inc/footer.php');
}?>