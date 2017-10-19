<?php 
add_filter('body_class',function($classes){
            $classes[]="user_additional_information";
            return $classes;
});
$errors=new WP_Error;
if(!empty($_POST)):
    $full_name=trim(esc_attr($_POST["full_name"]));
    $college_name=trim(esc_attr($_POST["college_name"]));
    $address=trim(esc_attr($_POST["address"]));
    $type=trim(esc_attr($_POST["type"]));
    $description=trim(esc_attr($_POST["description"]));
    if(!empty($full_name AND !empty($college_name) AND !empty($college_name) AND !empty($college_name) AND !empty($college_name) ):

        $nameparts = explode(" ", $user_full_name);
        $lastname = array_pop($nameparts);
        $firstname = implode(" ", $nameparts);


        update_user_meta( $user_id,"first_name",  $firstname);
        update_user_meta( $user_id,"last_name",  $lastname);
        update_user_meta( $user_id,"college_name",  $college_name);
        update_user_meta( $user_id,"address",  $address);
        update_user_meta( $user_id,"type",  $type);
        update_user_meta( $user_id,"description",  $description);
        delete_user_meta($user_id,"new_user");
        wp_redirect("/user/dashboard/");
    else:
        $errors->add('empty_fields','Please enter all the inputs before submitting.');
    endif;
endif;
get_header();
?>
<?php   include("navigation.php"); ?>
<div class="grid group">
    <div class=" grid-2-3">
        <div class="module">
            <h2><?php _e("Tell Us about Yourself", 'Shirshak'); ?> at <?php bloginfo('name'); ?></h2>
            <hr>

            <?php if (is_wp_error( $errors) AND !empty( $errors->errors )): ?>
                <div class="important red"> <ul>
                    <?php foreach($errors->get_error_messages() as $error):?>
                    <li><strong>Error</strong>: <?php echo $error;?></li>
                    <?php endforeach;?>
                </ul></div>
            <?php endif; ?>

            <div class="explanation">Before diving into our website please provide your basic information so that we can recognize you in future .</div>

            <form action="" method="post" class="respond">
                <div class="form-input">
                    <div class="form-input">
                        <label for="full_name" class="screen-reader-text"><?php _e('Full Name', 'Shirshak'); ?></label>
                        <input class="full-width" type="text" name="full_name" id="full_name" value="<?php echo !empty($full_name)?esc_html($full_name):""; ?>" placeholder="Enter College Name"/>
                    </div>
                </div>

                <div class="form-input">
                    <div class="form-input">
                        <label for="college_name" class="screen-reader-text"><?php _e('College Name', 'Shirshak'); ?></label>
                        <input class="full-width" type="text" name="college_name" id="college_name" value="<?php echo !empty($college_name)?esc_html($college_name):""; ?>" placeholder="Enter College Name"/>
                    </div>
                </div>
                <div class="form-input">
                    <div class="form-input">
                        <label for="address" class="screen-reader-text"><?php _e('Current Address', 'Shirshak'); ?></label>
                        <input class="full-width" type="text" name="address" id="address" value="<?php echo !empty($address)?esc_html($address):""; ?>" placeholder="Enter your address where you are living"/>
                    </div>
                </div>
                 <div class="form-input">
                    <div class="form-input">
                        <label for="type" class="screen-reader-text"><?php _e('I Am ', 'Shirshak'); ?></label>
                        <?php $types=["Student","Teacher","Parent"] ?>
                        <select name="type" id="type" class="full-width">
                            <?php foreach($types as $type):?>
                                <option value="<?php echo $type ?>" <?php if(!empty($_POST["type"]) AND $_POST["type"]==$type) echo "selected";?>>&nbsp;&nbsp;&nbsp;I am a <?php echo $type;?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-input">
                    <div class="form-input">
                        <label for="description" class="full-width"><?php _e('Say something about yourself?', 'Shirshak'); ?></label>
                        <textarea class="full-width" type="text" name="description" id="description" placeholder="Write anything you want to say about us or leave blank? "/><?php echo !empty($description)?esc_html($description):""; ?></textarea>
                    </div>
                </div>
                <hr>
                <input type="submit" name="submit" class="button" id="submit" value="<?php _e('Submit', 'Shirshak') ?>"/>
            </form>         
        </div>
    </div>
    <?php require_once("sidebar.php") ?>
</div>
<?php get_footer();?>