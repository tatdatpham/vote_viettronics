<?php 
	$title ='Bảng xếp hạng - Hệ thống bình chọn giảng viên trường Cao đẳng Viettronics';
	include('inc/header.php');
	include('inc/menu.php');
	
	$bxh = $mysqli->query("SELECT COUNT(*)as vote, account_id_voted, unit_id, unit_name,avatar,id FROM vote_info GROUP BY account_id ORDER BY vote DESC");
	
?>

<title><?php echo $title;?></title>
<!--breadcrumbs-->
<section class="breadcrumbs">
	<div class="container">
		<ul class="horizontal_list clearfix bc_list f_size_medium">
			<li class="m_right_10 current"><a href="#" class="default_t_color">Trang chủ<i class="fa fa-angle-right d_inline_middle m_left_10"></i></a></li>
			<li class="m_right_10"><a href="#" class="default_t_color">Bảng xếp hạng</a><i class="fa fa-angle-right d_inline_middle m_left_10"></i></li>
			
		</ul>
	</div>
</section>
<!--content-->
<div class="page_content_offset">
	<div class="container">
		<div class="row clearfix">
			
			<section class="col-lg-12 col-md-12col-sm-12">
				<div class="the-box">
					<h4 class="small-title">Bảng Xếp Hạng Bình Chọn</h4>
					<div id="myfirstchart" style="height: 250px;"></div>
				</div><!-- .the-box -->

			</section>
			
			
			
			
		</div>
	</div>
</div>
<!-- plugin -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="js/plugins/morris-chart/raphael.min.js"></script>
<script src="js/plugins/morris-chart/morris.min.js"></script>
<script type="text/javascript">
	
	new Morris.Bar({
	  // ID of the element in which to draw the chart.
	element: 'myfirstchart',
	barColors: ['#e74c3c'],
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	data: [
	<?php 
		while ($obj = $bxh->fetch_object()) {
			echo '
		    { name: "'.$obj->account_id_voted.'", value: '.$obj->vote.' },';
	    }
	?>
	],
  	// The name of the data record attribute that contains x-values.
  	 xkey: 'name',
  	// A list of names of data record attributes that contain y-values.
  	ykeys: ["value"],
  	// Labels for the ykeys -- will be displayed when you hover over the
  	// chart.
  	labels: ["Số phiếu"]
	});


</script>


<?php include('inc/footer.php');

?>