<?php 
	$title ='Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
	
		include('inc/header.php'); 
		include('inc/menu.php'); 
	if(isset($_SESSION['account_id'])){
		$id = $_SESSION['account_id'];
		$errors = array();
		$msg = array();
		$warning = array();
		//ngay tối thiểu để đặt lịch bình chọn
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$current = date('Y-m-d H:i:s', time());
		//cap nhat thong tin nguoi dung( khong phai giang vien)
		if(isset($_POST['submit_update_user2'])){
			$account        = $mysqli->real_escape_string($_POST['account']);
			$fullname     = $mysqli->real_escape_string($_POST['fullname']);
			$check_e        = $mysqli->query("SELECT * FROM `account_info` WHERE `account` = '$account' AND `id` <> '$id'");
			$check_email    = $check_e->fetch_row();
			if($check_email != 0){
				$errors = 'Tài khoản '.$account.' đã được sử dụng';
			}else{
				$sql3 = $mysqli->query("UPDATE `account` SET `fullname` ='$fullname', `account` = '$account' WHERE `id` = '$id'");
				$msg[] = 'Đã cập nhật thông tin thành công!';
			}
		}



		

		//cap nhat thong tin giang vien
		if(isset($_POST['submit_update_user'])){

			$fullname     = $mysqli->real_escape_string($_POST['fullname']);
	        $unit_id  	  = $mysqli->real_escape_string($_POST['unit_id']);
	        $teaching  	  = $mysqli->real_escape_string($_POST['teaching']);
	        $introduced  	  = $mysqli->real_escape_string($_POST['introduced']);	
	        
			if(count($errors) ==0){

				//cap nhat bang account
				$mysqli->query("UPDATE `account` SET `fullname`='$fullname',
					`unit_id`='$unit_id',`teaching`='$teaching',`introduced`='$introduced' WHERE `id` = '$id'");
				$msg[] = 'Đã cập nhật thông tin thành công!';
			}
			
		}
		
		// doi mat khau
		if(isset($_POST['submit_change_pass'])){
			$pass_old     = md5($mysqli->real_escape_string($_POST['pass_old']));
			$pass_new     = md5($mysqli->real_escape_string($_POST['pass_new']));
			$repass_new   = md5($mysqli->real_escape_string($_POST['repass_new']));

			if(strlen($_POST['pass_new']) < 6)
					$errors[] = 'Mật khẩu có tối thiểu 6 ký tự.';
			if ($pass_new != $repass_new) {
				$errors[] = 'Mật khẩu mới không khớp.';	
			}
			//check xem mat khau cu dung khong
			$sql1 = $mysqli->query("SELECT * FROM `account_info` WHERE `id` = '$id' AND `password` = '$pass_old' ");
			$check1 = $sql1->fetch_row();
			if($check1 == 0){
				$errors[] = 'Mật khẩu cũ không đúng!';	
			}else{
				if(count($errors) ==0){
					//cap nhat mat khau
					$sql2 = $mysqli->query("UPDATE `account` SET `password`='$pass_new' WHERE `id` = '$id'");
					$msg[] = 'Đổi mật khẩu thành công!';	
				}
			}
		}

		
		//thay avatar
		if(isset($_POST['submit_avatar']) && $_SESSION['status'] ==2 ){

			if(!empty($_FILES['avatar'])){
				$file_ext=strtolower(end(explode('.',$_FILES['avatar']['name'])));
				$extensions = array("jpeg","jpg","png"); // dinh dang duoc phep upload
				$max_file_size = 10240000; //5MB
				$path = "images/avatar/"; // Thu muc lưu file
				$file_name = $_FILES['avatar']['name'];
				$exten = substr($file_name, -4); //lay phan mo rong cua file
				$name = 'avatar-'.$id.$exten;
				//kiem tra chieu cao, rong cua anh
				$image_info = getimagesize($_FILES["avatar"]["tmp_name"]);
				$image_width = $image_info[0];
				$image_height = $image_info[1];
				if ($_FILES['avatar']['error'] == 0) {	           
					if ($_FILES['avatar']['size'] > $max_file_size) {
						$errors[] = 'File ảnh quá lớn!.';
						//continue; // Bỏ qua nếu file neu kích thước > kich thuoc tối đa cho phep
					}
					else if(in_array($file_ext,$extensions )=== false){
						$errors[] = 'File không đúng định dạng!.';
					}elseif ($image_width < 500 || $image_height < 500) {
						$errors[] = 'Kích thước ảnh tối thiểu là 500x500 (px).';
					}
					else{ // Neu khong tim thay loi thi upload file
							//upload file vao thu muc
							move_uploaded_file($_FILES["avatar"]["tmp_name"], $path.$name);
							//cap nhat bang account
							$mysqli->query("UPDATE `account` SET `avatar` = '$name' WHERE `id` = '$id'");
							$msg[] = 'Đã thay đổi ảnh đại diện thành công!';
						
				    }
				}
			}
		}


		//set thoi gian binh chon
		if(isset($_POST['submit_time']) && $_SESSION['status'] == 3){
			$date_start = $mysqli->real_escape_string($_POST['date_start']);
			$time_start = $mysqli->real_escape_string($_POST['time_start']);
			$date_end   = $mysqli->real_escape_string($_POST['date_end']);
			$time_end   = $mysqli->real_escape_string($_POST['time_end']);

			//xu ly nhap lieu
			$datetime= date('Y-m-d', strtotime($date_start));
			$date_start = date('Y-m-d', strtotime($date_start));
			$time_start = date('H:i:s', strtotime($time_start));
			$date_end   = date('Y-m-d', strtotime($date_end));
			$time_end   = date('H:i:s', strtotime($time_end));

			$datetime_start = date('Y-m-d H:i:s', strtotime("$date_start $time_start"));
			$datetime_end = date('Y-m-d H:i:s', strtotime("$date_end $time_end"));

			if(strtotime($datetime_start) < strtotime($current)){
				$errors[]="Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại.";
			}
			if(strtotime($datetime_start) > strtotime($datetime_end)){
				$errors[]="Ngày bkết thúc phải lớn hơn hoặc bằng ngày hiện tại.";
			}
			if(count($errors) == 0){
				if (!empty($_POST['enable'])) {
					$sql4 = $mysqli->query("UPDATE `vote_time` SET `timestart` = '$datetime_start',`timeend` = '$datetime_end' ,`active` = '1' WHERE `id` = '1'");
					$msg[] = "Đã đặt ngày bình chọn thành công!";
					$msg[] = "Chức năng bình chọn đã bật!";
				}else{
					$sql4 = $mysqli->query("UPDATE `vote_time` SET `timestart` = '$datetime_start',`timeend` = '$datetime_end' ,`active` = '0' WHERE `id` = '1'");
					$msg[] = "Đã đặt ngày bình chọn thành công!";
					$warning[] = "Chức năng bình chọn đã tắt!";
				}
			}
		}




		if(isset($_SESSION['fullname'])){
			//kiem tra nguoi dung co ton tai khong, co thi get info
			$check = $mysqli->query("SELECT * FROM `account_info` WHERE `id` = '$id'");
			$check_id = $check->fetch_row();
			if($check_id == 0){
				$title ='Không tìm thấy trang - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
			}else{
				$sql = $mysqli->query("SELECT * FROM `account_info` WHERE `id` = '$id'");
				$obj = $sql->fetch_object();

				$title =$obj->fullname.' -  Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
			}
		}
		

	

	
?>

<title><?php echo $title;?></title>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo $base_url;?>" class="default_t_color">Trang chủ<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<?php 
			if(isset($_SESSION['fullname'])){
				if($check_id == 0){
					echo '<li><a href="#" class="default_t_color">Không tìm thấy trang</a></li>';
				}else{
					echo '<li><a href="#" class="default_t_color">'.$obj->fullname.'</a></li>';
				}
			}else{
				echo '<li><a href="#" class="default_t_color">Không tìm thấy trang</a></li>';
			}?>	
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9">
			<?php 
			if(isset($_SESSION['account_id'])){
				if($check_id == 0){
					echo '<h2> Không tìm thấy trang! 
							<a href="'.$base_url.'" class="scheme_color"> 
								<span class="d_inline_middle shop_icon m_mxs_right_0">
									<i class="fa fa-mail-reply"></i>
															
								</span>Trở về 
							</a>
						</h2>';
				}else { ?>

				<!-- BEGIN PROFILE HEADING -->
				<div class="the-box transparent full no-margin profile-heading">
					
					<img src="images/cover.jpg" class="bg-cover" alt="Cover" height="399" width="840">
					<img src="images/avatar/<?php echo $obj->avatar;?>" class="avatar" alt="Avatar">
					<div class="profile-info">
						<p class="user-name"><?php echo $obj->fullname;?></p>
						<?php if($obj->status ==2) {
							echo'
							<p class="text-muted">Khoa   : <a href="#fakelink">'.$obj->unit_name.'</a></p>
							<p class="text-muted">Bộ môn :  <a href="#fakelink">'.$obj->teaching.'</a></p>';
						}?>
						<p class="right-button">
						<a href="<?php echo $base_url;?>manager.php" class="btn btn-danger btn-sm">Quản lý tài khoản</a>
						<a href="#panel-friend" data-toggle="tab" class="btn btn-danger btn-sm">Sửa hồ sơ</a>
						<a href="mailto:<?php echo $obj->account;?>" class="btn btn-danger btn-sm"><i class="fa fa-envelope"></i></a>
						</p>
					</div><!-- /.profile-info -->
				</div><!-- /.the-box .transparent .profile-heading -->
				<!-- END PROFILE HEADING -->
				
				<div class="panel with-nav-tabs panel-danger panel-square panel-no-border">
				  <div class="panel-heading">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#panel-about" data-toggle="tab"><i class="fa fa-user"></i></a></li>
						<li><a href="#panel-friend" data-toggle="tab"><i class="fa fa-edit"></i></a></li>
						<li><a href="#panel-pass" data-toggle="tab"><i class="fa fa-key"></i></a></li>
						<li><a href="#panel-avatar" data-toggle="tab"><i class="fa fa-camera"></i></a></li>
						<?php if($_SESSION['status'] ==3 ) echo '<li><a href="#panel-clock" data-toggle="tab"><i class="fa fa-clock-o"></i></a></li>';?>
					</ul>
				  </div>
					<div id="panel-collapse-1" class="collapse in">
						<div class="panel-body">
							<div class="tab-content">
								
								<div class="tab-pane fade in active" id="panel-about">
									<h4 class="small-heading more-margin-bottom">Sơ yếu lý lịch</h4>
									<form class="form-horizontal" role="form">
									<div class="form-group">
										<label class="col-sm-2 control-label">Họ và tên</label>
										<div class="col-sm-10">
										  <p class="form-control-static"><?php echo $obj->fullname;?></p>
										</div>
									</div><!-- /.form-group -->
									<div class="form-group">
										<label class="col-sm-2 control-label">Tài khoản</label>
										<div class="col-sm-10">
										  <p class="form-control-static"><a href="mailto:<?php echo $obj->account;?>"><?php echo $obj->account;?></p></a>
										</div>
									</div><!-- /.form-group -->
									<!-- tuy chon hien thi them thong tin voi nguoi dung la giang vien -->
									<?php if($obj->status ==2) {?>
									<div class="form-group">
										<label class="col-sm-2 control-label">Khoa</label>
										<div class="col-sm-10">
										  <p class="form-control-static"><a href="<?php echo $base_url.'unit-'.$obj->unit_id.'.html';?>"><?php echo $obj->unit_name;?></p></a>
										</div>
									</div><!-- /.form-group -->
									<div class="form-group">
										<label class="col-sm-2 control-label">Bộ môn</label>
										<div class="col-sm-10">
										  <p class="form-control-static"><?php echo $obj->teaching;?></p>
										</div>
									</div><!-- /.form-group -->
									<div class="form-group">
										<label class="col-sm-2 control-label">Giới thiệu</label>
										<div class="col-sm-10">
										  <p class="form-control-static"><?php echo $obj->introduced;?></p>
										</div>
									</div><!-- /.form-group -->
									<?php }?>
									</form>

								<!-- hien thi thong bao khi nhap form doi mat khau, cap nhat profile ... -->

									<?php	//Đưa thông báo gặp lỗi nào
										if(is_array($errors) > 0){
											foreach($errors as $errors){ ?>
												<div class="alert alert-danger alert-bold-border fade in alert-dismissable">
												  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												  	<strong>Lỗi : </strong> <?php echo $errors ?></a>.
												</div>
									<?php	}
											unset($errors);
										}
									?>
									<?php	//Đưa thông báo thành công
										if(count($msg) > 0){
											foreach($msg as $msg){ ?>
												<div class="alert alert-success alert-bold-border fade in alert-dismissable">
												  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												  	<strong>Thông báo : </strong> <?php echo $msg ?></a>.
												</div>
									<?php	}
											unset($msg);
										}
									?>

									<?php	//Đưa thông báo thành công
										if(count($warning) > 0){
											foreach($warning as $warning){ ?>
												<div class="alert alert-warning alert-bold-border fade in alert-dismissable">
												  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
												  	<strong>Cảnh báo : </strong> <?php echo $warning ?></a>.
												</div>
									<?php	}
											unset($msg);
										}
									?>
								<!-- ke thuc hien thi thong bao tu form -->
								</div><!-- /#panel-about -->

								<!-- chinh sua thong tin ca nhan -->
								<div class="tab-pane fade" id="panel-friend">
									<h4 class="small-heading more-margin-bottom">Chỉnh sửa hồ sơ</h4>
									<?php 
									//form chinh sưa thong tin cua giang vien
									if($_SESSION['status'] ==2) {?>
									<form role="form" method="POST" enctype="multipart/form-data">
										<div class="row">
											<div class="col-sm-6">
												
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-ticket"></i></span>
														<input type="text" name="fullname"  class="form-control" placeholder="Họ và tên" value="<?php echo $obj->fullname;?>" required>
													</div>
												  
												</div>
												
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-list-alt"></i></span>
														<input type="text" name="teaching"  class="form-control" placeholder="Bộ môn giảng dạy" value="<?php echo $obj->teaching;?>" required>
													</div>
												  
												</div>
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-tag"></i></span>
														<select data-placeholder="Chọn đơn vị..." class="form-control" name="unit_id" tabindex="2" required>
															<option value="<?php echo $obj->unit_id;?>"><?php echo $obj->unit_name;?></option>
															<?php 
															$id_unit = $obj->unit_id;
															$sql_unit = $mysqli->query("SELECT * FROM `unit` WHERE `id` <> '$id_unit'");
															while ($obj_unit= $sql_unit->fetch_object()) {
																echo '<option value="'.$obj_unit->id.'">'.$obj_unit->unit_name.'</option>';
															}
															?>
														</select>
													</div>
												</div>
												
											</div><!-- /.col-sm-6 -->
											<div class="col-sm-6">
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-bullhorn"></i></span>
														<textarea name="introduced" class="form-control"  rows="7" placeholder="Giới thiệu bản thân" required><?php echo $obj->introduced;?></textarea>
													</div>
												  
												</div>
												
												 <!-- kết thúc hiển thị tùy chọn -->
											</div><!-- /.col-sm-6 -->
										</div><!-- /.row -->
										<button type="submit" name="submit_update_user" class="btn btn-danger btn-block btn-lg"><i class="fa fa-sign-in"></i> Cập nhật thông tin</button>
									</form>
									<?php
									//ket thuc form chinh sua thong tin cua giang vien 
									}else{ //form chinh sua thong tin cua admin va nguoi dung thuong
										if($_SESSION['status'] ==3){
										?>
									<form role="form" method="POST">
										<div class="row">
											<div class="col-sm-6">
												
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-user"></i></span>
														<input type="text" name="account" class="form-control" placeholder="Tài khoản người dùng" value="<?php echo $obj->account;?>" required>
													</div>
												  
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-ticket"></i></span>
														<input type="text" name="fullname"  class="form-control" placeholder="Họ và tên" value="<?php echo $obj->fullname;?>" required>
													</div>
												  
												</div>
											</div>
										</div>
										<button type="submit" name="submit_update_user2" class="btn btn-danger btn-block btn-lg"><i class="fa fa-sign-in"></i> Cập nhật thông tin</button>
									</form>
									<?php }
										if($_SESSION['status'] ==1) {
											echo '<center><h4 class="scheme_color"> Tính năng này chỉ dành cho giảng viên! </h4></center>';
										}
									}?>
								</div>

								<!-- doi mat khau-->

								<div class="tab-pane fade" id="panel-pass">
									<h4 class="small-heading more-margin-bottom">Đổi mật khẩu</h4>
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-6">
											<form method="post">
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-key"></i></span>
														<input type="password" name="pass_old" class="form-control" placeholder="Mật khẩu cũ" required >
													</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-key"></i></span>
														<input type="password" name="pass_new" class="form-control" placeholder="Mật khẩu mới" required >
													</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-check"></i></span>
														<input type="password" name="repass_new" class="form-control" placeholder="Nhập lại mật khẩu"required >
													</div>
												</div>
												<div class="form-group">
												<button type="submit" name="submit_change_pass" class="btn btn-danger btn-block btn-lg"><i class="fa fa-refresh"></i> Đổi mật khẩu</button>
												</div>

											</form>

										</div><!-- /.col-sm-6 -->
										<div class="col-sm-3"></div>
										
									</div><!-- /.row -->
								</div>

								<!-- thay avatar cho giang vienn -->

								<div class="tab-pane fade" id="panel-avatar">
									<h4 class="small-heading more-margin-bottom">Đổi hình đại diện</h4>
									
									<div class="row">
										<div class="col-lg-3"></div>
										<div class="col-lg-6">
										<?php  //hien thi doi avatar neu la giang vien
										if($_SESSION['status'] ==2){?>
											<form role="form" method="POST" enctype="multipart/form-data">
											<div class="form-group has-feedback left-feedback no-label">
												<div class="input-group">
													<span class="input-group-btn">
															<span class="btn btn-danger btn-file">
																<i class="fa fa-plus"></i><input type="file" class="form-control" name="avatar">
															</span>
													</span>
													<input type="text" class="form-control" placeholder="Chọn ảnh đại diện" readonly>
												</div><!-- /.input-group -->
											</div>
											<button type="submit" name="submit_avatar" class="btn btn-danger btn-block btn-lg"><i class="fa fa-refesh"></i>Đổi hình đại diện</button>
											</form>
										<?php }else {
													echo '<center><h4 class="scheme_color"> Tính năng này chỉ dành cho giảng viên! </h4></center>';
										}?>
										</div>

										<div class="col-lg-3"></div>
									</div>
									
								</div>

								<!-- set time de binh chon -->
								<?php 
								if($_SESSION['status'] ==3){
									$sql_t = $mysqli->query("SELECT * FROM `vote_time` WHERE `id` ='1'");
									$obj_t = $sql_t->fetch_object();
									$datetime1 = $obj_t->timestart;
									$datetime2 = $obj_t->timeend;
									$date1 = date('Y-m-d', strtotime($datetime1));
									$time1 = date('H:i:s', strtotime($datetime1));
									$date2 = date('Y-m-d', strtotime($datetime2));
									$time2 = date('H:i:s', strtotime($datetime2));

								?>
								<div class="tab-pane fade" id="panel-clock">
									<h4 class="small-heading more-margin-bottom">Đặt thời gian bình chọn</h4>
									<form method="post">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
												<label> Ngày bắt đầu</label>
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-clock-o"></i></span>
														<input type="date" name="date_start" class="form-control" value="<?php echo $date1 ;?>">
													</div>
												</div>
												<div class="form-group">
												
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-asterisk"></i></span>
														<input type="time" name="time_start" class="form-control" value="<?php echo $time1 ;?>" >
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
												<label> Ngày kết thúc</label>
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-clock-o"></i></span>
														<input type="date" name="date_end" class="form-control" value="<?php echo $date2 ;?>">
													</div>
												</div>
												<div class="form-group">
												
													<div class="input-group">
														<span class="input-group-addon danger"><i class="fa fa-asterisk"></i></span>
														<input type="time" name="time_end" class="form-control" value="<?php echo $time2 ;?>" >
													</div>
												</div>
											</div>
										</div><!-- /.row -->
										<div class="form-group">
											<label>Bật tắt tính năng bình chọn</label>
											<div class="onoffswitch">
												<input type="checkbox" name="enable" class="onoffswitch-checkbox" id="example-switch-4" <?php if($obj_t->active ==1) echo 'checked';?> >
												<label class="onoffswitch-label" for="example-switch-4">
													<span class="onoffswitch-inner"></span>
													<span class="onoffswitch-switch"></span>
												</label>
											</div>
										</div>
										<button type="submit" name="submit_time" class="btn btn-danger btn-block btn-lg"><i class="fa fa-gear"></i> Đặt thời gian</button>
									</form>
								</div>
								<?php } ?>
							</div><!-- /.tab-content -->
						</div><!-- /.panel-body -->
					</div><!-- /.collapse in -->
				</div><!-- /.panel .panel-success -->
				
				<?php
					}
				}else{
						echo '<h2> Không tìm thấy trang! 
							<a href="'.$base_url.'" class="scheme_color"> 
								<span class="d_inline_middle shop_icon m_mxs_right_0"><i class="fa fa-mail-reply"></i></span>Trở về 
							</a>
							</h2>';
					}
				?> <!-- ket thuc if else -->
			</section>
			<!--right column-->
			
			
			<?php include('inc/sidebar.php'); ?>
		</div>
	</div>
</div>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<?php include('inc/footer.php');
}?>