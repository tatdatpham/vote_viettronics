<?php
	$top = $mysqli->query("SELECT COUNT(*)as vote, account_id_voted, unit_id, unit_name,avatar,id,status FROM vote_info WHERE status = 2 GROUP BY account_id ORDER BY vote DESC LIMIT 10");
?>
<aside class="col-lg-3 col-md-3 col-sm-3">
	<!--widgets-->
	<figure class="widget shadow r_corners wrapper m_bottom_30">
		<figcaption>
			<h3 class="color_light">Khoa và Bộ môn</h3>
		</figcaption>
		<div class="widget_content">
			<!--Categories list-->
			<ul class="categories_list">
				<li>
					<a href="<?php echo $base_url;?>" class="f_size_large color_dark d_block relative">
							Tất cả
							<span class="bg_light_color_1 r_corners f_right color_dark talign_c"></span>
						</a>
					</li>
			<?php 
				$sql_u2 = $mysqli->query("SELECT * FROM `unit`");
				while ($obj_u2 = $sql_u2->fetch_object()) {
					echo '
					<li>
						<a href="'.$base_url.'?filter='.$obj_u2->id.'" class="f_size_large color_dark d_block relative">
							'.$obj_u2->unit_name.'
							<span class="bg_light_color_1 r_corners f_right color_dark talign_c"></span>
						</a>
					</li>';
				}
			?>
				
			</ul>
		</div>
	</figure>
	
	
	<!--Bestsellers-->
	<figure class="widget shadow r_corners wrapper m_bottom_30">
		<figcaption>
			<h3 class="color_light">Top bình chọn</h3>
		</figcaption>
		<div class="widget_content">
			<?php 
			while ($obj_t = $top->fetch_object()) {
				echo '
				<div class="clearfix m_bottom_15">
					<img src="images/avatar/'.$obj_t->avatar.'" height="60" width="60"  class="f_left m_right_10 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0">
					<div style="padding-top: 2px;">
						<p><strong><a href="'.$base_url.'user.php?id='.$obj_t->id.'" class="bt_block bt_link">'.$obj_t->account_id_voted.'</a></strong></p>
						<a href="'.$base_url.'?filter='.$obj_t->unit_id.'" class="color_dark bt_block bt_link">'.$obj_t->unit_name.'</a>
					</div>
					
					<p class="scheme_color">'.$obj_t->vote.' lượt</p>
				</div>
				<hr class="m_bottom_15">';
			}?>
			
			
		</div>
	</figure>
	
</aside>