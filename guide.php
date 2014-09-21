
<?php 
	
	include('inc/header.php'); 
	include('inc/menu.php'); 
	
	//them huong dan
	$msg = array();
	if(isset($_GET['action']) && $_GET['action'] == 'add' && isset($_SESSION['status']) && $_SESSION['status'] == 3 && isset($_POST['submit_question'])){
		$title    = $mysqli->real_escape_string($_POST['title']);
		$content  = $mysqli->real_escape_string($_POST['content']);
		$sql = $mysqli->query("INSERT INTO `guide`(`title`,`content`) VALUES ('$title','$content')");
		$msg = 'Đã thêm thành công hướng dẫn mới';
		//header('Location:'.$base_url.'add-guide.html');
	}
	$title = "Hướng dẫn - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics";
?>

<title><?php echo $title;?></title>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo $base_url;?>" class="default_t_color">Trang chủ<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li class="m_right_10"><a href="<?php echo $base_url;?>guide.html" class="default_t_color">Hướng dẫn</a><i class="fa fa-angle-right d_inline_middle m_left_10"></i></li>
			<?php if(isset($_GET['action']) && isset($_SESSION['status']) && $_SESSION['status'] ==3){
				echo '<li class="m_right_10"><a href="'.$base_url.'add-guide.html" class="default_t_color">Thêm hướng dẫn mới</a></li>';
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
			<!-- them moi guilde -->

			

			<?php if(isset($_GET['action']) && $_GET['action'] == 'add' && isset($_SESSION['status']) && $_SESSION['status'] == 3){?>
				<div class="row">
					<div class="col-lg-12">
					<form role="form" method="post">
						<div class="form-group has-feedback left-feedback no-label">
							<div class="input-group">
								<span class="input-group-addon danger"><i class="fa fa-question"></i></span>
								<input type="text" name="title" class="form-control" placeholder="Tiêu đề" required>
							</div>
						  
						</div>
						<textarea name="content" id="summernote" placeholde="Nội dung hướng dẫn"></textarea><br>
						<button type="submit" name="submit_question" class="btn btn-danger btn-block btn-lg"><i class="fa fa-sign-in"></i> Thêm hướng dẫn mới mới</button>
					</form>
					</div>
					<?php	//Đưa thông báo thành công
						if(is_array($msg) > 0){
							foreach($msg as $msg){ ?>
								<div class="alert alert-success alert-bold-border fade in alert-dismissable">
								  	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								  	<strong>Thông báo!</strong> <?php echo $msg ?></a>.
								</div>
					<?php	}
							unset($msg);
						}
					?>
				</div><!-- /.div.row -->



			<?php 
			} elseif(empty($_GET['action'])){
				$sql2 = $mysqli->query("SELECT * FROM `guide`");
			?>
			<div class="row">
				
				<div class="col-lg-12 col-sm-12">
					<div class="tab-content">
						
						<div class="tab-pane fade in active" id="example-faq-2">
							<div class="panel-group" id="faq-accordion-2">
								<?php
								  	while ($obj2=$sql2->fetch_object()) {
								  	echo '
								<div class="panel panel-danger">
								  <div class="panel-heading">
									<h3 class="panel-title">
										<a class="block-collapse" data-parent="#faq-accordion-2" data-toggle="collapse" href="#faq-accordion-2-child-'.$obj2->id.'">
										<strong>Q :</strong> '.$obj2->title.'?
										<span class="right-content">
											<span class="right-icon">
												<i class="glyphicon glyphicon-minus icon-collapse"></i>
											</span>
										</span>
										</a>
									</h3>
								  </div>
									<div id="faq-accordion-2-child-'.$obj2->id.'" class="collapse';if($obj2->id ==1){echo 'in';} echo ' ">
									  <div class="panel-body">
										'.$obj2->content.'.
									  </div><!-- /.panel-body -->
									  <div class="panel-footer">Bạn thấy có có hữu ích không? <a href="#">Có</a> / <a href="#">Không</a></div>
									</div><!-- /.collapse in -->
								</div>';}?>
								
							</div><!-- /.panel-group -->
						</div>
						
					</div><!-- /.tab-content -->
					<?php  if( isset($_SESSION['status']) && $_SESSION['status'] ==3){
						echo '<a href="'.$base_url.'add-guide.html" class="f_right btn btn-danger btn-lg"><i class="fa fa-plus"></i>Thêm hướng dẫn</a>';
					}?>
				</div><!-- /.col-sm-9 col-sm-8 -->
			</div><!-- /.row -->

			<?php } ?>
		</section>

			
			<?php include('inc/sidebar.php'); ?>
		</div>
	</div>
</div>


	<button class="t_align_c r_corners tr_all_hover type_2 animate_ftl" id="go_to_top"><i class="fa fa-angle-up"></i></button>
	<footer>
				
				<!--copyright part-->
			<div class="footer_bottom_part">
				<div class="container clearfix t_mxs_align_c">
					<center><p class="f_center f_mxs_none m_mxs_bottom_10">Copyright &copy; 2014 Trung tâm mạng trường Cao đẳng Công nghệ Viettronics.</p></center>
					
				</div>
			</div>
		</footer>
	</div>

<script src="//code.jquery.com/jquery-1.9.1.min.js"></script> 

<script src="js/plugins/summernote/summernote.min.js"></script>
<script src="js/jquery-2.1.0.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/retina.js"></script>
<script src="js/waypoints.min.js"></script>
<script src="js/jquery.isotope.min.js"></script>
<script src="js/jquery.tweet.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.custom-scrollbar.js"></script>


<script type="text/javascript">
$(document).ready(function() {
  	$('#summernote').summernote({
	  	height: 300,                 // set editor height
	  	minHeight: null,             // set minimum height of editor
	  	maxHeight: null,             // set maximum height of editor
	  	focus: true,                 // set focus to editable area after initializing summernote
	});
});
$('#shopping_button').on('mouseenter',function(){
  $(this).css('z-index','300');
 }).on('mouseleave',function(){
  $(this).css('z-index','189');
 });
</script>
	</body>
</html>