<div class="grid group">
    <div class=" grid-2-3">
        <div class="module">
            <h2><?php _e("Dashboard", 'Shirshak'); ?></h2>
            <hr>
            
                <p>Hai <?php echo $current_user->display_name;?></p>
                <p>Welcome to <?php echo bloginfo("name");?> Dashboard.</p>
            <div style="clear:both"></div>
            <p>Avatar are based on your email id. So to change your profile image just go to gravatar.com and sign up with the same email you use with our website.</p>
            <hr>

            <div class="site_links">
            <p>We have some idea. Why don't you start taking our <a href="/entrance">entrance exam</a>?</p>
                
            </div>

        </div>
    </div>
    <?php include("sidebar.php"); ?>
</div>