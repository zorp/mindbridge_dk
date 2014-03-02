<?php
/*
  Template Name: Blog
*/
?>

<?php get_header(); ?>
        
        <div class="blog_left">
        
            <?php            
            $args = array(
                         'category_name' => 'blog',
                         'post_type' => 'post',
                         'posts_per_page' => 6,
        //                 'cat' => '-' . $category_ID,
                         'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1)
                         );
            query_posts($args);
            $x = 0;
            while (have_posts()) : the_post(); ?>                                    
            
                
                    <?php if($x == 1) { ?>
                    <div class="blog_box_cont home_blog_box_last">
                    <div class="home_post_box blog_box home_post_box_last">
                    <?php } else { ?>
                    <div class="blog_box_cont">
                    <div class="home_post_box blog_box">
                    <?php } ?>
                        <!--<img src="<?php //bloginfo('stylesheet_directory'); ?>/images/blog-image.jpg" />-->
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home-post',array('alt' => 'post image', 'class' => 'rounded')); ?></a>
                        
                        <div class="home_post_title_cont">
                            <h3><?php the_title(); ?></h3>
                        </div><!--//home_post_title_cont-->                    
                    </div><!--//home_post_box-->                                
                    <div class="blog_content">
                        <?php $temp_arr_content = explode(" ",substr(strip_tags(get_the_content()),0,225)); $temp_arr_content[count($temp_arr_content)-1] = ""; $display_arr_content = implode(" ",$temp_arr_content); echo $display_arr_content . '...'; ?>
                    </div><!--//blog_content-->
                </div><!--//blog_box_cont-->
            
            <?php if($x == 1) { echo '<div class="clear"></div>'; $x = -1; } ?>
            
            <?php $x++; ?>
            <?php endwhile; ?>
            
            <div class="clear"></div>
            
            <div class="blog_nav_cont">
                <div class="left"><?php previous_posts_link('&laquo; Previous') ?></div>
                <div class="right"><?php next_posts_link('Next &raquo;') ?></div>
                <div class="clear"></div>
            </div><!--//blog_nav_cont-->
            <?php wp_reset_query(); ?>        
            
        </div><!--//blog_left-->
        
        <?php get_sidebar(); ?>
        
        <div class="clear"></div>
        
<?php get_footer(); ?>            