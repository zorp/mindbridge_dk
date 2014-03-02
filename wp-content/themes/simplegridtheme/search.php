<?php get_header(); ?>
        
        <div class="blog_left">
        
            <?php            
            $x = 0;
            while (have_posts()) : the_post(); ?>                                    
            
                <?php if($x == 1) { ?>
                <div class="home_post_box home_post_box_last">
                <?php } else { ?>
                <div class="home_post_box">
                <?php } ?>
                    <!--<img src="<?php //bloginfo('stylesheet_directory'); ?>/images/blog-image.jpg" />-->
                    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home-post'); ?></a>
                    
                    <div class="home_post_title_cont">
                        <h3><?php the_title(); ?></h3>
                    </div><!--//home_post_title_cont-->                    
                </div><!--//home_post_box-->                                
            
            <?php if($x == 1) { echo '<div class="clear"></div>'; $x = -1; } ?>
            
            <?php $x++; ?>
            <?php endwhile; ?>            
            
            <div class="clear"></div>
            
        </div><!--//blog_left-->
        
        <?php get_sidebar(); ?>
        
        <div class="clear"></div>
        
<?php get_footer(); ?>            