<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head> 
  <title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>          
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" title="no title" charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->        
  <?php wp_head(); ?>
<!--  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>-->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="<?php bloginfo('stylesheet_directory'); ?>/js/main.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
  function show_post_desc(desc_num) {
      jQuery('#home_post_desc'+desc_num).css('display','block');
  }
  
  function hide_post_desc(desc_num) {
      jQuery('#home_post_desc'+desc_num).css('display','none');
  }
  </script>
</head>
<body>

<?php $shortname = "simple_grid"; ?>

<div id="main_container">

    <div id="header">
        <?php if(get_option($shortname.'_custom_logo_url','') != "") { ?>
          <a href="<?php bloginfo('url'); ?>"><img src="<?php echo stripslashes(stripslashes(get_option($shortname.'_custom_logo_url',''))); ?>" class="logo" /></a>
        <?php } else { ?>
          <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" class="logo" /></a>
        <?php } ?>                    
        
        <div class="right">
        
            <ul class="social_icons">
              <?php if(get_option($shortname.'_twitter_link','') != "") { ?>
                <li><a href="<?php echo get_option($shortname.'_twitter_link',''); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter-icon.png" /></a></li>
              <?php } ?>
              <?php if(get_option($shortname.'_facebook_link','') != "") { ?>
                <li><a href="<?php echo get_option($shortname.'_facebook_link',''); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/facebook-icon.png" /></a></li>
              <?php } ?>
              <?php if(get_option($shortname.'_google_plus_link','') != "") { ?>
                <li><a href="<?php echo get_option($shortname.'_google_plus_link',''); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/gplus-icon.png" /></a></li>
              <?php } ?>
              <?php if(get_option($shortname.'_dribbble_link','') != "") { ?>
                <li><a href="<?php echo get_option($shortname.'_dribbble_link',''); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/dribbble-icon.png" /></a></li>
              <?php } ?>
              <?php if(get_option($shortname.'_pinterest_link','') != "") { ?>
                <li><a href="<?php echo get_option($shortname.'_pinterest_link',''); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/pinterest-icon.png" /></a></li>
              <?php } ?>
            </ul>
            <div class="clear"></div>
            
            <div class="search_cont">
                <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                  <input type="text" name="s" id="s" />
                  <INPUT TYPE="image" src="<?php bloginfo('stylesheet_directory'); ?>/images/search-icon.png" class="search_icon" BORDER="0" ALT="Submit Form">
                </form>
            </div><!--//search_cont-->
            
            <div class="clear"></div>
        </div><!--//right-->
        
        <div class="clear"></div>
    </div><!--//header-->
    
    <div id="menu_container">
    
    <!--
        <ul class="pages_menu">
          <li><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Contact</a></li>
        </ul>-->
        <?php wp_nav_menu('menu=header_menu&container=false&menu_class=pages_menu'); ?>
        
        <!--
        <ul class="cat_menu">
          <li><a href="#">WebDesign</a></li>
          <li><a href="#">Graphics</a></li>
          <li><a href="#">Print</a></li>
          <li><a href="#">Posters</a></li>
        </ul>-->
        <?php wp_nav_menu('menu=category_menu&container=false&menu_class=cat_menu'); ?>                    
        
        <div class="clear"></div>

    </div><!--//menu_container-->
    
    <div id="content_container">
    
        <div class="featured_banner">
            <div align="center">
            <?php if(get_option($shortname.'_featured_banner_url','') != "") { ?>
              <img src="<?php echo stripslashes(stripslashes(get_option($shortname.'_featured_banner_url',''))); ?>" />
            <?php } else { ?>
              <img src="<?php bloginfo('stylesheet_directory'); ?>/images/banner.png" />
            <?php } ?>                            
            </div>
        </div><!--//featured_banner-->