<?php get_header(); ?>
        
        <div class="blog_left">
        
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          
                <h1><?php the_title(); ?></h1>
                
                <div class="left_content">
                
                <?php the_content(); ?>
                
                </div><!--//left_content-->
                
                <br /><br />
                
                <?php comments_template(); ?>
            
            <?php endwhile; else: ?>
            
                <h3>Sorry, no posts matched your criteria.</h3>
            
            <?php endif; ?>    
            
        </div><!--//blog_left-->
        
        <?php get_sidebar(); ?>
        
        <div class="clear"></div>
        
<?php get_footer(); ?>            