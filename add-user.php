<?php 
	$title ='Thêm giảng viên mới - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
	include('inc/header.php'); 
	if(isset($_SESSION['fullname'])){
		if($_SESSION['status'] == 3){
			include('inc/menu.php'); 

			$errors = array();
			$msg = array();
			if(isset($_POST['submit_new_user'])){

				$email        = $mysqli->real_escape_string($_POST['email']);
				$fullname     = $mysqli->real_escape_string($_POST['fullname']);
				$password     = md5($mysqli->real_escape_string($_POST['password']));
		        $unit_id  	  = $mysqli->real_escape_string($_POST['unit_id']);
		        $teaching  	  = $mysqli->real_escape_string($_POST['teaching']);
		        $introduced  	  = $mysqli->real_escape_string($_POST['introduced']);
		        if(strlen($_POST['password']) < 6)
					$errors[] = 'Mật khẩu có tối thiểu 6 ký tự.';
		        //kiem tra email da duoc su dung chua
		    	$check_e        = $mysqli->query("SELECT * FROM `account_info` WHERE `email` = '$email'");
				$check_email    = $check_e->fetch_row();
				if($check_email != 0){
					$errors = 'Email '.$email.' đã được sử dụng';
				}else{
					if(!empty($_FILES['avatar'])){
						$file_ext=strtolower(end(explode('.',$_FILES['avatar']['name'])));
						$extensions = array("jpeg","jpg","png"); // dinh dang duoc phep upload
						$max_file_size = 10240000; //5MB
						$path = "images/avatar/"; // Thu muc lưu file
						$file_name = $_FILES['avatar']['name'];
						//lay ra id cua account tiep theo dc them vao
						$sql_id = $mysqli->query("SHOW TABLE STATUS LIKE 'account'");
						$obj_id = $sql_id->fetch_object();
						$id = $obj_id->Auto_increment;
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
								$mysqli->query("INSERT INTO `account`(`email`,`fullname`,`password`,`avatar`,`unit_id`,`teaching`,`introduced`,`status`) 
									VALUES ('$email','$fullname','$password','$name','$unit_id','$teaching','$introduced','2')");
								$msg[] = 'Đã thêm thành công giảng viên mới!';
								
						    }
						}
					}
				}
				
			}
	

	

	
?>

<title><?php echo $title;?></title>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo $base_url;?>" class="default_t_color">Trang chủ<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li class="m_right_10"><a href="#" class="default_t_color">Giảng viên</a><i class="fa fa-angle-right d_inline_middle m_left_10"></i></li>
			<li><a href="<?php echo $base_url;?>add-user" class="default_t_color">Thêm giảng viên mới</a></li>
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			<!--left content column-->
			<section class="col-lg-9 col-md-9 col-sm-9">

				<div class="row">	
				<form role="form" method="POST" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-6">
							
							<div class="form-group has-feedback left-feedback no-label">
								<div class="input-group">
									<span class="input-group-addon danger"><i class="fa fa-user"></i></span>
									<input type="email" name="email" class="form-control" placeholder="Email người dùng" required>
								</div>
							  
							</div>
							<div class="form-group has-feedback left-feedback no-label">
								<div class="input-group">
									<span class="input-group-addon danger"><i class="fa fa-ticket"></i></span>
									<input type="text" name="fullname"  class="form-control" placeholder="Họ và tên" required>
								</div>
							  
							</div>
							<div class="form-group has-feedback left-feedback no-label">
								<div class="input-group">
									<span class="input-group-addon danger"><i class="fa fa-key"></i></span>
									<input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
								</div>
							  
							</div>
							
							<div class="form-group has-feedback left-feedback no-label">
								<div class="input-group">
									<span class="input-group-addon danger"><i class="fa fa-list-alt"></i></span>
									<input type="text" name="teaching"  class="form-control" placeholder="Bộ môn giảng dạy" required>
								</div>
							  
							</div>
							<div class="form-group has-feedback left-feedback no-label">
								<div class="input-group">
									<span class="input-group-addon danger"><i class="fa fa-tag"></i></span>
									<select data-placeholder="Chọn đơn vị..." class="form-control" name="unit_id" tabindex="2" required>
										<option disabled selected>Chọn khoa...</option>
										<?php 

										$sql_unit = $mysqli->query("SELECT * FROM `unit`");
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
									<textarea name="introduced" class="form-control"  rows="9" placeholder="Giới thiệu bản thân" required></textarea>
								</div>
							  
							</div>
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
							 <!-- kết thúc hiển thị tùy chọn -->
						</div><!-- /.col-sm-6 -->
					</div><!-- /.row -->
					<button type="submit" name="submit_new_user" class="btn btn-danger btn-block btn-lg"><i class="fa fa-sign-in"></i> Thêm giảng viên mới</button>
				</form>
				</div>
				<br>
				<div class="row">
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
				
				</div>


			</section>
			<!--right column-->
			
			
			<?php include('inc/sidebar.php'); ?>
		</div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<?php include('inc/footer.php');
	}
}
?>