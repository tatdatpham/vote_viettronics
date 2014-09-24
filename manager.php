<?php 
	$title ='Trang quản lý - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
	include('inc/header.php');
	include('inc/menu.php');
	$stt=1;


	if(isset($_POST['submit_del']) && $_SESSION['status'] ==3){
		$account_id   = $mysqli->real_escape_string($_POST['account']);
		$sql  = $mysql->query("DELETE FROM `account` WHERE `id` ='$account_id'");
	}
?>

<title><?php echo $title;?></title>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo $base_url;?>" class="default_t_color">Trang chủ<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li class="m_right_10"><a href="#" class="default_t_color">Quản lý</a><i class="fa fa-angle-right d_inline_middle m_left_10"></i></li>
			
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			
			<section class="col-lg-12 col-md-12col-sm-12">
				<!-- hien thi danh sach nguoi dung doi voi nguoi quan ly -->
				<?php if(isset($_SESSION['status']) && $_SESSION['status']==3){
					$sql1 = $mysqli->query("SELECT * FROM `account_info`");
				?>
				<h4 class="small-title">Danh sách người dùng</h4>
					<div class="table-responsive">
						<table id="user" class="table table-th-block table-danger">
							<thead>
								<tr>
									<th style="width: 30px;">No</th>
									<th><center>Họ tên</center></th>
									<th><center>Tài khoản</center></th>
									<th><center>Đơn vị</center></th>
									<th><center>Loại</center></th>
									<th width="12%"><center>Chức năng</center></th>
								</tr>
							</thead>
							<tbody>
							<?php 
								while($obj1 = $sql1->fetch_object()){
								echo '<tr>
									<td>'.$stt.'</td>
									<td><img src="'.$base_url.'images/avatar/'.$obj1->avatar.'" class="avatar img-circle" alt="avatar">'.$obj1->fullname.'</td>
									<td>'.$obj1->account.'</td>
									<td>'.$obj1->unit_name.'</td>';
									if($obj1->status ==1){
										echo '<td>Người dùng</td>';
									}elseif ($obj1->status ==2){echo '<td>Giảng viên</td>';}
									elseif ($obj1->status ==3){echo '<td>Administrator</td>';}
									echo'<td><center><div class="btn-group">
										  	<a href="#"><i class="fa fa-pencil icon-square icon-xs icon-danger"></i></a>
										  	<a href="#" data-toggle="modal" data-target="#myModal'.$obj1->id.'"><i class="fa fa-trash-o icon-square icon-xs icon-danger"></i></a>
											
										</div></center>
										</td>';;
									$stt = $stt +1;
									echo '
									<div class="modal fade" id="myModal'.$obj1->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									  <div class="modal-dialog">
									    <div class="modal-content">
									      <div id="text-popup" class="danger-popup mfp-with-anim mfp-hide">
												<div class="row">
													<center><p>Bạn có chắc chắn muốn xóa tài khoản :<br></p></center>
													<br>
													<form method="POST">
														<div class="col-xs-1"></div>
														<div class="col-xs-7"><img src="'.$base_url.'images/avatar/'.$obj1->avatar.'" class="avatar img-circle" alt="avatar">'.$obj1->fullname.'
														</div>
														<div class="col-xs-3">
															<input type="hidden" value="'.$obj1->id.' name="account">
															<button type="submit" name="submit_del"  class="btn btn-success f_left f_size_medium">Đồng ý</button>
														</div>
														<div class="col-xs-1"></div>
													</form>
												</div>
											</div>
									    </div>
									  </div>
									</div>
									';
								} ?>
								</tr>
							</tbody>
						</table>
					</div><!-- /.table-responsive -->
				<?php }else{
					echo '<h2> Không tìm thấy trang! 
							<a href="'.$base_url.'" class="scheme_color"> 
								<span class="d_inline_middle shop_icon m_mxs_right_0">
									<i class="fa fa-mail-reply"></i>
															
								</span>Trở về 
							</a>
						</h2>
						<br><br><br><br><br><br><br><br><br><br><br><br>';
					}?>

			</section>
			
			
			
			
		</div>
	</div>
</div>
<!-- plugin -->

<script>
	$(document).ready(function() {
	    $('#user').dataTable();
	} );

</script>

<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>
