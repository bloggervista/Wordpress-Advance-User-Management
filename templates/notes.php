<div class="grid group">
    <div class=" grid-2-3">
        <div class="module">
        	<h2><?php _e("Notes", 'Shirshak'); ?></h2>
            <hr>
            <div class="explanation">Here, We will list all the notes that belongs to you. We will also give you credit for supporting us. If you have any problem in creating note kindly consult us.</div>
            <a href="<?php echo get_bloginfo("url"); ?>/user/new-note" target="_blank" class="button">Write New Note</a>
            <hr>
            <section class="module-home-posts-lists">
            <div class="h3">Your Notes</div>
                <ul>
                    <?php
                        $query=new WP_Query( array ('post_type'=> array( 'note' ),'author' => $user_id));
                        if ( $query->have_posts() ) {
                            while ( $query->have_posts() ) {
                                $query->the_post();
                               ?>
                                <li class="attractive_item">
                                <h2><a href="<?php the_permalink() ?>" target="_blank" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                                <div class="informations"><?php //echo show_no_likes( get_the_ID() );?> | <time datetime="<?php printf(__('%1$s', 'atahualpa') , get_the_date(__('Y-m-d:G:i', 'atahualpa'))) ?>"> <?php echo get_the_date(); ?></time><?php edit_post_link(' | Edit'); ?>  | <?php comments_number('0 comment', 'One comments', '% comments'); ?> </div>
                                </li>
                               <?php
                            }
                        } else {
                            ?>
                         <li class="attractive_item">You don't have posted any notes . Be active and write a creative and good content that matches our <a href="/writing_guideliness">guideliness</a>.</li>
                        <?php
                        }
                        wp_reset_postdata();
                    ?>
                </ul>
            </section>
        </div>
    </div>
    <?php include("sidebar.php"); ?>
</div>