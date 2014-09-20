<?php 
	
	include('inc/header.php'); 
	include('inc/menu.php'); 

	$title = "Hướng dẫn - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics";
?>

<title><?php echo $title;?></title>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="<?php echo $base_url;?>" class="default_t_color">Trang chủ<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li class="m_right_10"><a href="<?php echo $base_url;?>guide.html" class="default_t_color">Hướng dẫn</a><i class="fa fa-angle-right d_inline_middle m_left_10"></i></li>
			
		</ul>
	</div>
</section>
	<!--content-->
	<div class="page_content_offset">
	<div class="container">
	<div class="row clearfix">
		<!--left content column-->
		<section class="col-lg-9 col-md-9 col-sm-9 m_xs_bottom_30">
			
		</section>

			
			<?php include('inc/sidebar.php'); ?>
		</div>
	</div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<?php include('inc/footer.php');
}?>