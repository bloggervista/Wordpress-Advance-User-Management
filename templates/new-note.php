<?php
$errors=[];
if (!empty($_POST['submit'])) {
	if (! isset( $_POST['user_content_post'] ) || ! wp_verify_nonce( $_POST['user_content_post'], 'user_write_content' )) {
			$errors[]="For security reason we cannot update your information. Please contact admins using contact form if there is an emergency";
		} else {
				if(!verify_recaptcha()){
					//$errors[]="Are you robot. You must verify captcha before any thing.";
				}
				if(empty($_POST["title"]) ){
					$errors[]="You forget to write a title.";
				}else{
					if(strlen($_POST["title"])<10){
						$errors[]="Post title must be at least 10 character.";
					}
				}
				if(empty($_POST["content"]) ){
					$errors[]="You forget to write content. Content is king man . So don't leave it :D";
				}
				if(empty($_POST["class"]) AND ($_POST["class"]=="class-11" OR $_POST["class"]=="class-12")){
					$errors[]="You forget to select class or selected invalid class.";
				}
				if(file_exists($_FILES['thumbnail']['tmp_name']) || is_uploaded_file($_FILES['thumbnail']['tmp_name'])) {
					if(!empty(parse_file_errors($_FILES['thumbnail'])['error'])){
							$errors[]=parse_file_errors($_FILES['thumbnail'])['error'];
					}   
				}
				
				if(!count($errors)>0){
					$my_post = array(
					  'post_status'           => 'pending', 
					  'post_type'             => $_POST["class"],
					  'post_author'           => $user_id,
					  'post_title'            =>  wp_strip_all_tags( $_POST["title"]),
					  'post_content'          =>  $_POST["content"],
					  );
					$post_id=wp_insert_post( $my_post );
					if(file_exists($_FILES['thumbnail']['tmp_name']) || is_uploaded_file($_FILES['thumbnail']['tmp_name'])){
						$attch_id=process_image('thumbnail', $post_id, $_POST["title"]);
						if(empty($attch_id))$errors[]="Problem with Thumnail.";
					}
					if($post_id==true){
						update_post_meta($post_id, "enable_mathjax", !empty($_POST['enable_math'])?"Yes":"No");
						update_post_meta($post_id, "things_to_know", !empty($_POST['things_to_know'])?$_POST['things_to_know']:"No Important Notes are given");
						$sucess=true;
					}else{
						$errors[]="Something went wrong. We also even don't know.";
					}
					
				}
	}
}
?>
<div class="grid group">
    <div class=" grid-2-3">
        <div class="module" style="background:#F0F9F7">
        	<h2><?php _e("New Note ", 'Shirshak'); ?></h2>
        	<?php if(!empty(get_option( 'shirshak_theme_option' )['notes_submission'])):?>
        		<?php 
        			if(count($errors)>0){echo "<div class='explanation red'><ul>";foreach($errors as $error){echo "<li>{$error}</li>";}echo '</ul></div>';}
        			if(isset($sucess)):
        				echo "<div class='explanation'>Your post has been successfully added to our blog. Your post will be visible after the admin approves it.  Thank you so much for your contribution. Add more notes if you want to been in our top contributor list. <a href='/top-contributors'>See more</a></div>";
        			echo '<hr>';
        			echo '<a href="button" class="button">Write New Note</a>';
        			echo '<a href="button" class="button">Top Contributors List</a>'
        			else:
		        ?>
		        	<form action="" method="post" enctype="multipart/form-data">
			        			
				                <?php wp_nonce_field( 'user_write_content', 'user_content_post' ); ?>
								
				                <div class="form-input">
				                    <label for="title" class="screen-reader-text"><?php _e('Title', 'Shirshak'); ?>: </label>
				                    <input type="text" name="title" id="title" class="full-width" placeholder="Enter The Apropriate Title For Your Post" value="<?php echo !empty($_POST["title"])?$_POST["title"]:'';?>"/>
				                </div>
				                <hr>
				                <div class="form-input">
				                    <label for="class" class="screen-reader-text"><?php _e('Class', 'Shirshak'); ?>: </label>
				                    <?php $types=["Class-11","Class-12"] ?>
			                        <select name="class" id="class" class="full-width">
			                            <?php foreach($types as $type):?>
			                                <option value="<?php echo $type ?>" <?php if(!empty($_POST["type"]) AND $_POST["type"]==$type) echo "selected";?>>&nbsp;&nbsp;&nbsp;<?php echo $type;?></option>
			                            <?php endforeach; ?>
			                        </select>
				                </div>
				                <hr>

				                <div class="form-input">
				                    <label for="content"><?php _e('Content', 'Shirshak'); ?>: </label>
				                	<?php wp_editor(isset($_POST["content"])?$_POST["content"]:"Start writing main contents here:)", 'new-post-desc', array('textarea_name' => 'content','textarea_rows' => 10,'media_buttons'=>true,'teeny' => false) ); ?>
				                </div>
				                <hr>

				                <div class="form-input">
				                    <label for="things_to_know"><?php _e('Things To Know', 'Shirshak'); ?>: </label>
				                	<?php wp_editor(isset($_POST["things_to_know"])?$_POST["things_to_know"]:"Some tips imporant things etc from this topics  :)", 'new-post-desc', array('textarea_name' => 'things_to_know','textarea_rows' => 5,'media_buttons'=>false,'teeny' => true) ); ?>
				                </div>
				                <hr>


				                <div class="form-input">
				                    <label for="math"><?php _e('Mathematics | Chemistry mode', 'Shirshak'); ?>: </label>
				                    <input type="checkbox" name="enable_math" <?php echo !empty($_POST["enable_math"])?"checked":'';?> vaue="enable-mathjax">
				                    <p>Tick if you have chemical reactions,mathematics etc in your content.</p>
				                </div>
				                <hr>

				                <div class="form-input">
				                    <label for="thumbnail" class="screen-reader-text"><?php _e('Thumbnail', 'Shirshak'); ?>: </label>
				                    <input type="file" name="thumbnail" id="thumbnail"  class="full-width"/>
				                    <p>Insert thumbnail for this note if you like.</p>
				                </div>
				                <hr>
								<div class="recaptcha-container">
				                    <div class="g-recaptcha" data-sitekey="<?php echo get_option( 'shirshak_theme_option' )['recaptcha_site_key']; ?>"></div>
				                </div>
				                
				                <input type="submit" name="submit" id="submit" value="<?php _e('Submit Note','Shirshak'); ?>" class="button" />
				    </form> 
				<?php endif;?>
		    <?php else:echo "Due to spamming and security reason we have disabled notes submission. For more contact admins."; endif;?>  
        </div>
    </div>
    <?php include("sidebar.php"); ?>
</div>