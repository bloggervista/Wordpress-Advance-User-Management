<?php
$errors=[];
if(!empty($_POST["submit_basic_info"])){
	if(!verify_recaptcha()){
			$errors[]="Are you robot. You must verify captcha before any thing.";
	}
	if (! isset( $_POST['basic_info'] ) || ! wp_verify_nonce( $_POST['basic_info'], 'change_basic_info' )) {
		$errors[]="For security reason we cannot update your information. Please contact admins using contact form if there is an emergency";
	} 
	if(empty($errors)) {
		update_user_meta($user_id, 'description',esc_textarea($_POST['description']) ,0,500);
		update_user_meta($user_id, 'nickname', esc_attr($_POST['user_nickname']));
		update_user_meta($user_id, 'first_name', esc_attr($_POST['user_first_name']));	
		update_user_meta($user_id, 'last_name', esc_attr($_POST['user_last_name']));
		update_user_meta($user_id, 'college_name', esc_attr($_POST['college_name']));
		update_user_meta($user_id, 'type', esc_attr($_POST['type']));
		update_user_meta($user_id, 'address', esc_attr($_POST['address']));
		$sucess=true;
	}
}

if(!empty($_POST["submit_password"])){
	if (! isset( $_POST['password'] ) || ! wp_verify_nonce( $_POST['password'], 'change_password' )) {
		$errors[]="For security reason we cannot update your information. Please contact admins using contact form if there is an emergency";
	} else {
		if(!verify_recaptcha()){
			$errors[]="Are you robot. You must verify captcha before any thing.";
		}
		if(empty($_POST["user_password"]) AND empty($_POST["user_new_password"]) AND empty($_POST["user_re_password"])){
			$errors[]="Please Enter All Required Feilds.";

		}else{
			if(strlen($_POST["user_new_password"])<5){
				$errors[]="Your password is less than 6 character. Think more than 6 character please :D.";
			}else{
				if($_POST["user_new_password"]!=$_POST["user_re_password"]){
					$errors[]="Your New Password And Re Password don't match.";
				}else{
					if($_POST["user_password"]==$_POST["user_new_password"]){
						$errors[]="Your New Password And Current Password are same. Why should we change your password when both are same?";
					}else{
						if(wp_check_password( $_POST["user_password"], $current_user->data->user_pass, $user_id )){
							wp_set_password( $_POST["user_new_password"], $user_id );
							$sucess=true;
							wp_redirect("/login/?password_changed=yes");
						}else{
							$errors[]="Your password don't match with your current password.";
						}	
					}
					
				}
			}
		}
	}
}
if(!empty($_POST["submit_social_profile"])){
	if (! isset( $_POST['social_profile'] ) || ! wp_verify_nonce( $_POST['social_profile'], 'change_social_profile' )) {
		$errors[]="For security reason we cannot update your information. Please contact admins using contact form if there is an emergency";
	} 
	if(!verify_recaptcha()){
			$errors[]="Are you robot. You must verify captcha before any thing.";
	}
	if(empty($errors)){
		update_user_meta($user_id, 'twitter', esc_attr($_POST['user_twitter']));
		update_user_meta($user_id, 'facebook', esc_attr($_POST['user_facebook']));	
		update_user_meta($user_id, 'instagram', esc_attr($_POST['user_instagram']));
		$sucess=true;
	}
}
?>
<div class="grid group">
    <div class=" grid-2-3">
        <div class="module">
        	<h2><?php _e("Settings", 'Shirshak'); ?></h2>
            <hr>
            <?php if(empty($_GET["page"])):?>
	        	<h3>Your Information</h3>
	        	<ul>
	        		<li>Name : <strong> <?php echo $current_user->data->display_name;?></strong></li>
	        		<li>Email Address : <strong> <?php echo $current_user->data->user_email;?></strong></li>
	        		<li>Username : <strong> <?php echo $current_user->data->user_login;?></strong></li>
	        		<li>Website : <strong> <?php echo $current_user->data->user_url;?></strong></li>
	        		<li>Registration Date : <strong><?php echo $current_user->data->user_registered;?></strong></li>
	        		<li>ID : <strong> <?php echo $user_id;?></strong></li>
	        		<li>Your Role : <strong> <?php echo $current_user->roles["0"];?></strong></li>
	        	</ul>
	        	<h3>Change Your Account Settings</h3>
	        	<div class="veiw_all_button">
		        	<a class="button" href="?page=basic-info">Basic Information</a>
		        	<a class="button" href="?page=social-network">Social Networks</a>
		        	<a class="button" href="?page=password">Password</a>
	        	</div>
        	<?php endif;?>
        	<?php if(!empty($_GET["page"])):?>
        		<?php if($_GET["page"]==="basic-info"):?>
        			<?php 
	        			if(isset($sucess)) echo "<div class='explanation'>Your Request has been accepted and your profile has been updated.</div>";
	        			if(count($errors)>0){echo "<div class='explanation red'><ul>";foreach($errors as $error){echo "<li>{$error}</li>";}echo '</ul></div>';}
        			?>
        			<form action="" method="post" class="respond">
		                <?php wp_nonce_field( 'change_basic_info', 'basic_info' ); ?>
		                
		                <div class="form-input">
		                    <label for="user_nickname" class="image-replace signin-username"><?php _e('Nickname', 'Shirshak') ?></label>
		                    <input class="full-width paddingleft50" type="text" class="do_input" name="user_nickname" id="user_nickname" value="<?php echo get_user_meta($user_id, 'nickname', true); ?>" placeholder="Nickname"/>
		                </div>
		                <div class="form-input">
		                    <label for="user_first_name" class="image-replace signin-username"><?php _e('First Name', 'Shirshak'); ?></label>
		                    <input class="full-width paddingleft50" type="text" name="user_first_name" id="user_first_name" value="<?php echo get_user_meta($user_id, 'first_name', true); ?>" placeholder="Enter First Name"/>
		                </div>
		                <div class="form-input">
		                    <label for="user_last_name" class="image-replace signin-username"><?php _e('Last Name', 'Shirshak'); ?></label>
		                    <input  class="full-width paddingleft50" type="text" name="user_last_name" id="user_last_name" value="<?php echo get_user_meta($user_id, 'last_name', true); ?>" placeholder="Enter Last Name"/>
		                </div>
		                <div class="form-input">
		                    <label for="user_description" ><?php _e('Profile Description', 'Shirshak'); ?></label>
		                    <?php wp_editor( get_user_meta($user_id, 'description', true), 'new-post-desc', array('textarea_name' => 'description','textarea_rows' => 5,'media_buttons'=>false,'teeny'=>true) ); ?>
		                </div>
		                <div class="form-input">
		                    <label for="college_name" ><?php _e('College Name', 'Shirshak'); ?></label>
		                    <input  class="full-width" type="text" name="college_name" id="college_name" value="<?php echo get_user_meta($user_id, 'college_name', true); ?>"/>
		                </div>
		                <div class="form-input">
		                    <label for="address" ><?php _e('Address', 'Shirshak'); ?></label>
		                    <input  class="full-width" type="text" name="address" id="address" value="<?php echo get_user_meta($user_id, 'address', true); ?>"/>
		                </div>
		                <div class="form-input">
		                    <label for="type" ><?php _e('Type', 'Shirshak'); ?></label>
	                        <?php $types=["Student","Teacher","Parent"] ?>
	                        <select name="type" id="type" class="full-width">
	                            <?php foreach($types as $type):
	                            $db_type=get_user_meta($user_id, 'type', true);
	                            ?>
	                                <option value="<?php echo $type ?>" <?php if($db_type==$type) echo "selected";?>>&nbsp;&nbsp;&nbsp;<?php echo $type;?></option>
	                            <?php endforeach; ?>
	                        </select>
		                </div>
		                <div class="recaptcha-container">
				                    <div class="g-recaptcha" data-sitekey="<?php echo get_option( 'shirshak_theme_option' )['recaptcha_site_key']; ?>"></div>
				        </div>
		                <input type="submit" name="submit_basic_info" id="submit" value="<?php _e('Update Profile','Shirshak'); ?>" class="button" />
		            </form>   
        		<?php endif; ?>

        		<?php if($_GET["page"]==="social-network"):?>
	        		<?php 
	        			if(isset($sucess)) echo "<div class='explanation'>Your Request has been accepted and your profile has been updated.</div>";
	        			if(count($errors)>0){echo "<div class='explanation red'><ul>";foreach($errors as $error){echo "<li>{$error}</li>";}echo '</ul></div>';}
	        			?>
	        			<form action="" method="post" class="respond">
			                <?php wp_nonce_field( 'change_social_profile', 'social_profile' ); ?>
			                <div class="form-input">
			                    <label for="user_facebook"><?php _e('Facebook', 'Shirshak'); ?></label>
			                    <input class="full-width" type="text" name="user_facebook" id="user_facebook" value="<?php echo get_user_meta($user_id, 'facebook', true); ?>" placeholder="Enter Facebook Username"/>
			                </div>
			                <div class="form-input">
			                    <label for="user_twitter"><?php _e('Twitter', 'Shirshak'); ?></label>
			                    <input class="full-width" type="text" name="user_twitter" id="user_twitter" value="<?php echo get_user_meta($user_id, 'twitter', true); ?>" placeholder="Enter Twitter Username"/>
			                </div>
			                <div class="form-input">
			                    <label for="user_instagram"><?php _e('Instagram', 'Shirshak'); ?></label>
			                    <input class="full-width" type="text" name="user_instagram" id="user_instagram" value="<?php echo get_user_meta($user_id, 'instagram', true); ?>" placeholder="Enter Instagram Username"/>
			                </div>
			                <div class="recaptcha-container">
				                    <div class="g-recaptcha" data-sitekey="<?php echo get_option( 'shirshak_theme_option' )['captcha_site_key']; ?>"></div>
				        	</div>
			                <input type="submit" name="submit_social_profile" id="submit" value="<?php _e('Update Socail Profile','Shirshak'); ?>" class="button" />
			            </form>   
		        <?php endif; ?>

        		<?php if($_GET["page"]==="password"):?>
        			<?php 
        			if(isset($sucess)) echo "<div class='explanation'>Your Request has been accepted and your profile has been updated.</div>";
        			if(count($errors)>0){echo "<div class='explanation red'><ul>";foreach($errors as $error){echo "<li>{$error}</li>";}echo '</ul></div>';}
        			?>
        			<form action="" method="post" class="respond">
		                <?php wp_nonce_field( 'change_password', 'password' ); ?>
		                <div class="form-input">
		                    <label for="user_password" class="image-replace signin-password"><?php _e('Password', 'Shirshak'); ?></label>
		                    <input class="full-width paddingleft50" type="password" name="user_password" id="user_password" placeholder="Enter Current Password"/>
		                </div>
		                <div class="form-input">
		                    <label for="user_new_password" class="image-replace signin-password"><?php _e('New Password', 'Shirshak') ?></label>
		                    <input class="full-width paddingleft50" type="password" class="do_input" name="user_new_password" id="user_new_password"  placeholder="Enter New Password"/>
		                </div>
		                <div class="form-input">
		                    <label for="user_re_password" class="image-replace signin-password"><?php _e('Reenter Password', 'Shirshak'); ?></label>
		                    <input class="full-width paddingleft50" type="password" name="user_re_password" id="user_re_password" placeholder="Reenter New Password"/>
		                </div>
		                <div class="recaptcha-container">
				                    <div class="g-recaptcha" data-sitekey="<?php echo get_option( 'shirshak_theme_option' )['recaptcha_site_key']; ?>"></div>
				        </div>
		                <input type="submit" name="submit_password" id="submit" value="<?php _e('Change Password','Shirshak'); ?>" class="button" />
		            </form>   
        		<?php endif; ?>
        	<?php endif; ?>
        </div>
    </div>
    <?php include("sidebar.php"); ?>
</div>