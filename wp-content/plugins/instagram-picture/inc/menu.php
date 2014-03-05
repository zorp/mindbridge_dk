<?php

function instagram_picture_menu() 
{
	
  add_menu_page('Instagram', 'Instagram', 'manage_options', __FILE__, 'instagram_picture_instagram', plugins_url( 'instagram-picture/icon.png' ));
  add_submenu_page(__FILE__, 'Update', 'Update', 'manage_options', 'instagram_picture_aktualisieren', 'instagram_picture_aktualisieren');
  add_submenu_page(__FILE__, 'Configuration', 'Configuration', 'manage_options', 'instagram_picture_konfiguration', 'instagram_picture_konfiguration');
  add_submenu_page(__FILE__, 'All Pictures', 'All Pictures', 'manage_options', 'instagram_picture_alle_bilder', 'instagram_picture_alle_bilder');
  add_submenu_page(__FILE__, 'PHP Code', 'PHP Code', 'manage_options', 'instagram_picture_php_code', 'instagram_picture_php_code');
  add_submenu_page(__FILE__, 'Widget', 'Widget', 'manage_options', 'instagram_picture_widget', 'instagram_picture_widget');
  add_submenu_page(__FILE__, 'Shortcode', 'Shortcode', 'manage_options', 'instagram_picture_shortcode_doku', 'instagram_picture_shortcode_doku');
  add_submenu_page(__FILE__, 'Follow Me', 'Follow Me', 'manage_options', 'instagram_picture_follow_me', 'instagram_picture_follow_me');
  add_submenu_page(__FILE__, 'CSS', 'CSS', 'manage_options', 'instagram_picture_css', 'instagram_picture_css');
  add_submenu_page(__FILE__, 'Contact', 'Contact', 'manage_options', 'instagram_picture_contact', 'instagram_picture_contact');
  
}

?>