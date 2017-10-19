<div class="grid group">
    <div class=" grid-2-3">
        <div class="module">
        	<h2><?php _e("Entrance Results", 'Shirshak'); ?></h2>
            <hr>
    		<p>Check your results and improve :) . We hope you do best in our examination </p>
    		<section class="module-home-posts-lists">
    			<?php
				global $wpdb,$current_user;
				$sql = $wpdb->prepare("SELECT * FROM {$wpdb->entrance_result}  WHERE user_id=%d ORDER BY end_time", $user_id); 
				$results=$wpdb->get_results($sql,ARRAY_A);
				if(!empty($results)):
					echo "<ul>";
					foreach($results as $result):
					?><li class="attractive_item">
	                    <h2><a href="<?php echo home_url()."/result/".$result["result_id"];?>" target="_blank" rel="bookmark" title="Permanent Link to <?php echo get_the_title($result["post_id"]);?>"><?php echo get_the_title($result["post_id"]);?></a></h2>
	                    <div class="informations"><time datetime="<?php echo date('Y-m-d:G:i', $result["started_time"]);?>"><?php echo date('m/d/Y', $result["started_time"]);?></time> | <?php echo $result["percentage"];?>% | <?php echo $result["no_attempted_question"];?> questions attempted</div>
	                </li>
					<?php endforeach; 
					echo "</ul>";
				endif;?>
    		</section>
        </div>
    </div>
    <?php include("sidebar.php"); ?>
</div>