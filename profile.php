<?php 
	$title ='Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
	if(isset($_GET['id'])){
		include('inc/header.php'); 
		include('inc/menu.php'); 
		$id = $_GET['id'];
		$errors = array();
		$msg = array();
		//cap nhat thong tin nguoi dung( khong phai giang vien)
		if(isset($_POST['submit_update_user2'])){
			$email        = $mysqli->real_escape_string($_POST['email']);
			$fullname     = $mysqli->real_escape_string($_POST['fullname']);
			$check_e        = $mysqli->query("SELECT * FROM `account_info` WHERE `email` = '$email' AND `id` <> '$id'");
			$check_email    = $check_e->fetch_row();
			if($check_email != 0){
				$errors = 'Email '.$email.' đã được sử dụng';
			}else{
				$sql3 = $mysqli->query("UPDATE `account` SET `fullname` ='$fullname', `email` = '$email' WHERE `id` = '$id'");
				$msg[] = 'Đã cập nhật thông tin thành công!';
			}
		}



		

		//cap nhat thong tin giang vien
		if(isset($_POST['submit_update_user'])){

			$email        = $mysqli->real_escape_string($_POST['email']);
			$fullname     = $mysqli->real_escape_string($_POST['fullname']);
	        $unit_id  	  = $mysqli->real_escape_string($_POST['unit_id']);
	        $teaching  	  = $mysqli->real_escape_string($_POST['teaching']);
	        $introduced  	  = $mysqli->real_escape_string($_POST['introduced']);	
	        //kiem tra email da duoc su dung chua
	    	$check_e        = $mysqli->query("SELECT * FROM `account_info` WHERE `email` = '$email' AND `id` <> '$id'");
			$check_email    = $check_e->fetch_row();
			if($check_email != 0){
				$errors = 'Email '.$email.' đã được sử dụng';
			}else{
				if(count($errors) ==0){

					//cap nhat bang account
					$mysqli->query("UPDATE `account` SET `email`='$email',`fullname`='$fullname',
						`unit_id`='$unit_id',`teaching`='$teaching',`introduced`='$introduced' WHERE `id` = '$id'");
					$msg[] = 'Đã cập nhật thông tin thành công!';
				}
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
			if(isset($_SESSION['fullname'])){
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
						<a href="#panel-friend" data-toggle="tab" class="btn btn-primary btn-sm">Sửa hồ sơ</a>
						<a href="mailto:<?php echo $obj->email;?>" class="btn btn-danger btn-sm"><i class="fa fa-envelope"></i></a>
						</p>
					</div><!-- /.profile-info -->
				</div><!-- /.the-box .transparent .profile-heading -->
				<!-- END PROFILE HEADING -->
				
				<div class="panel with-nav-tabs panel-primary panel-square panel-no-border">
				  <div class="panel-heading">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#panel-about" data-toggle="tab"><i class="fa fa-user"></i></a></li>
						<li><a href="#panel-friend" data-toggle="tab"><i class="fa fa-edit"></i></a></li>
						<li><a href="#panel-pass" data-toggle="tab"><i class="fa fa-key"></i></a></li>
						<li><a href="#panel-avatar" data-toggle="tab"><i class="fa fa-camera"></i></a></li>
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
										<label class="col-sm-2 control-label">Email</label>
										<div class="col-sm-10">
										  <p class="form-control-static"><a href="mailto:<?php echo $obj->email;?>"><?php echo $obj->email;?></p></a>
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
												  	<strong>Lỗi!</strong> <?php echo $errors ?></a>.
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
												  	<strong>Thông báo!</strong> <?php echo $msg ?></a>.
												</div>
									<?php	}
											unset($msg);
										}
									?>
								<!-- ke thuc hien thi thong bao tu form -->
								</div><!-- /#panel-about -->


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
														<span class="input-group-addon primary"><i class="fa fa-user"></i></span>
														<input type="email" name="email" class="form-control" placeholder="Email người dùng" value="<?php echo $obj->email;?>" required>
													</div>
												  
												</div>
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon primary"><i class="fa fa-ticket"></i></span>
														<input type="text" name="fullname"  class="form-control" placeholder="Họ và tên" value="<?php echo $obj->fullname;?>" required>
													</div>
												  
												</div>
												
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon primary"><i class="fa fa-list-alt"></i></span>
														<input type="text" name="teaching"  class="form-control" placeholder="Bộ môn giảng dạy" value="<?php echo $obj->teaching;?>" required>
													</div>
												  
												</div>
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon primary"><i class="fa fa-tag"></i></span>
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
														<span class="input-group-addon primary"><i class="fa fa-bullhorn"></i></span>
														<textarea name="introduced" class="form-control"  rows="9" placeholder="Giới thiệu bản thân" required><?php echo $obj->introduced;?></textarea>
													</div>
												  
												</div>
												
												 <!-- kết thúc hiển thị tùy chọn -->
											</div><!-- /.col-sm-6 -->
										</div><!-- /.row -->
										<button type="submit" name="submit_update_user" class="btn btn-primary btn-block btn-lg"><i class="fa fa-sign-in"></i> Cập nhật thông tin</button>
									</form>
									<?php
									//ket thuc form chinh sua thong tin cua giang vien 
									}else{ //form chinh sua thong tin cua admin va nguoi dung thuong
										?>
									<form role="form" method="POST" enctype="multipart/form-data">
										<div class="row">
											<div class="col-sm-6">
												
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon primary"><i class="fa fa-user"></i></span>
														<input type="email" name="email" class="form-control" placeholder="Email người dùng" value="<?php echo $obj->email;?>" required>
													</div>
												  
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group has-feedback left-feedback no-label">
													<div class="input-group">
														<span class="input-group-addon primary"><i class="fa fa-ticket"></i></span>
														<input type="text" name="fullname"  class="form-control" placeholder="Họ và tên" value="<?php echo $obj->fullname;?>" required>
													</div>
												  
												</div>
											</div>
										</div>
										<button type="submit" name="submit_update_user2" class="btn btn-primary btn-block btn-lg"><i class="fa fa-sign-in"></i> Cập nhật thông tin</button>
									</form>
									<?php }?>
								</div>
								<div class="tab-pane fade" id="panel-pass">
									<h4 class="small-heading more-margin-bottom">Đổi mật khẩu</h4>
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-6">
											<form method="post">
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon primary"><i class="fa fa-key"></i></span>
														<input type="password" name="pass_old" class="form-control" placeholder="Mật khẩu cũ" required >
													</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon primary"><i class="fa fa-key"></i></span>
														<input type="password" name="pass_new" class="form-control" placeholder="Mật khẩu mới" required >
													</div>
												</div>
												<div class="form-group">
													<div class="input-group">
														<span class="input-group-addon primary"><i class="fa fa-check"></i></span>
														<input type="password" name="repass_new" class="form-control" placeholder="Nhập lại mật khẩu"required >
													</div>
												</div>
												<div class="form-group">
												<button type="submit" name="submit_change_pass" class="btn btn-primary btn-block btn-lg"><i class="fa fa-refresh"></i> Đổi mật khẩu</button>
												</div>

											</form>

										</div><!-- /.col-sm-6 -->
										<div class="col-sm-3"></div>
										
									</div><!-- /.row -->
								</div>

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
															<span class="btn btn-primary btn-file">
																<i class="fa fa-plus"></i><input type="file" class="form-control" name="avatar">
															</span>
													</span>
													<input type="text" class="form-control" placeholder="Chọn ảnh đại diện" readonly>
												</div><!-- /.input-group -->
											</div>
											<button type="submit" name="submit_avatar" class="btn btn-primary btn-block btn-lg"><i class="fa fa-refesh"></i>Đổi hình đại diện</button>
											</form>
										<?php }else {
													echo '<center><h4 class="scheme_color"> Tính năng này chỉ dành cho giảng viên! </h4></center>';
										}?>
										</div>

										<div class="col-lg-3"></div>
									</div>
									
								</div>
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