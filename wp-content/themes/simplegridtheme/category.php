<?php get_header(); ?>



        <div id="load_posts_container">



        <?php

        $x = 0;

        

        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        if($paged > 1) 

          $y = (0 + (($paged-1) * 12));

        else

          $y = 0;

global $wp_query;
$args = array_merge( $wp_query->query, array( 'posts_per_page' => 9 ) );
query_posts( $args );
        while (have_posts()) : the_post(); ?>                                                                      

        

            <?php if($x == 2) { ?>

            <div class="home_post_box home_post_box_last" onmouseover="show_post_desc(<?php echo $y; ?>)" onmouseout="hide_post_desc(<?php echo $y; ?>)">

            <?php } else { ?>

            <div class="home_post_box" onmouseover="show_post_desc(<?php echo $y; ?>)" onmouseout="hide_post_desc(<?php echo $y; ?>)">

            <?php } ?>

            

                <!--<img src="<?php bloginfo('stylesheet_directory'); ?>/images/blog-image.jpg" />-->

                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('home-post',array('alt' => 'post image', 'class' => 'rounded')); ?></a>

                

                <div class="home_post_desc" id="home_post_desc<?php echo $y; ?>">

                    <?php $temp_arr_content = explode(" ",substr(strip_tags(get_the_content()),0,225)); $temp_arr_content[count($temp_arr_content)-1] = ""; $display_arr_content = implode(" ",$temp_arr_content); echo $display_arr_content . '...'; ?>

                </div><!--//home_post_desc-->

                

                <div class="home_post_title_cont">

                    <h3><?php the_title(); ?></h3>

                    <h4><?php the_category(', '); ?></h4>

                </div><!--//home_post_title_cont-->

            </div><!--//home_post_box-->

        

            <?php if($x == 2) { $x = -1; /*echo '<div class="clear"></div>';*/ } ?>

        

        <?php $x++; $y++; ?>

        <?php endwhile; ?>        

        <?php wp_reset_query(); ?>        

        

        <div class="clear"></div>

        

        </div><!--//load_posts_container-->

        

        <div class="load_more_cont">

            <p align="center"><span class="load_more_text"><?php next_posts_link('<img src="' . get_bloginfo('stylesheet_directory') . '/images/load-more-image.png" />') ?></span></p>

        </div><!--//load_more_cont-->

        

        

<script type="text/javascript">

// Ajax-fetching "Load more posts"

$('.load_more_cont a').live('click', function(e) {

	e.preventDefault();

	//$(this).addClass('loading').text('Loading...');

        //$('.load_more_text a').html('Loading...');

	$.ajax({

		type: "GET",

		url: $(this).attr('href') + '#main_container',

		dataType: "html",

		success: function(out) {

			result = $(out).find('#load_posts_container .home_post_box');

			nextlink = $(out).find('.load_more_cont a').attr('href');

                        //alert(nextlink);

			//$('#boxes').append(result).masonry('appended', result);

                    $('#load_posts_container').append(result);

			//$('.fetch a').removeClass('loading').text('Load more posts');

                        //$('.load_more_text a').html('Load More');

                        

                        

			if (nextlink != undefined) {

				$('.load_more_cont a').attr('href', nextlink);

			} else {

				$('.load_more_cont').remove();

                                $('#load_posts_container').append('<div class="clear"></div>');

                              //  $('.load_more_cont').css('visibilty','hidden');

			}



                    if (nextlink != undefined) {

                        $.get(nextlink, function(data) {

                          //alert(nextlink);

                          if($(data + ":contains('home_post_box')") != '') {

                            //alert('not found');

                              //                      $('.load_more_cont').remove();

                                                    $('#load_posts_container').append('<div class="clear"></div>');        

                          }

                        });                        

                    }

                        

		}

	});

});

</script>        

        

<?php get_footer(); ?>            