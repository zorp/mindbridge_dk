<?php
function instagram_picture_instagram() 
{

	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	########################################################################################################################	
	
	########################################################################################################################
	/*
	* Check whether user data were entered
	*/
		// User-id query
		$result_id = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='1'");	
	
		// if no data has been entered
		if(empty($result_id))
		{
			echo '
			<div class="instagram-picture-alert">
				<h2>Caution</h2>
					<p>At the first you have to <b>register</b> your <b>Instagram-ID</b> and <b>Access-Token</b>. Ok <b><a href="?page=instagram_picture_konfiguration">Lets go</a></b></p>
			</div>
			';
		}
		
		// After plugin update to Instagram 2.0 update must be performed by
		// Checking whether user-Date is empty
		$user_info = $wpdb->get_var("SELECT username FROM $instagram_picture_variable[102] WHERE id='1'");
		if(empty($user_info) AND !empty($result_id))
		{
			echo '
			<div class="instagram-picture-alert">
				<h2>Caution</h2>
					<p>Please make an picture update.<br />
					Ok <b><a href="?page=instagram_picture_aktualisieren">Lets go</a></b></p>
			</div>
			';
		}	
		
	########################################################################################################################

	
	########################################################################################################################
	/*
	*	remaining content
	*/
	
		
		echo '
			<div class="instagram-picture-box">
			
				<div class="row-instagram_admin">
					<div class="col-instagram-2_admin" style="padding: 10px;">
						<a href="http://ipic.tb-webtec.de"><img src="'.$instagram_picture_variable["11"].'img/instagram-picture_logo.png" alt="Instagram-Picture Logo"></a>
					</div>
					<div class="col-instagram-3_admin">
						<h2>Instagram Picture</h2>
						<p>Applicable version: <b>'.$instagram_picture_variable["0"].'</b></p>
						<a href="http://www.facebook.com/ipicWP" target="_blank"><img src="'.$instagram_picture_variable["11"].'img/facebook.png" title="Facebook Instagram-Picture" /></a>
						<a href="http://twitter.com/iPicWPtau" target="_blank"><img src="'.$instagram_picture_variable["11"].'img/twitter.png" title="Twitter Instagram-Picture" /></a>
						<a href="http://tb-webtec.de/category/instagram-picture/" target="_blank"><img src="'.$instagram_picture_variable["11"].'img/wordpress.png" title="Blog" /></a>
						<a href="https://github.com/TB-WebTec/Instagram-Picture" target="_blank"><img src="'.$instagram_picture_variable["11"].'img/github.png" title="GitHub Instagram-Picture" /></a>
					</div>
				</div>
				<div class="instagram_clear_admin"></div>';
				
			// Version review
				// Wordpress version
				$wp_version = get_bloginfo("version");
				if($wp_version < '3.0')
				{
					echo '<p style="color:#ff0000;"><b>Caution, our plugin has been tested only with Wordpress 3.0</b></p>';	
				}
				
		
		echo '
				<hr />
				<div class="row-instagram_admin">
				
					<div class="col-instagram-3_admin instagram-picture-box-in">
						<h3>Developed by</h3>
							<a href="http://tb-webtec.de"><img src="'.$instagram_picture_variable["11"].'img/tb-webtec_logo.png" title="TB-WebTec" alt="TB-WebTec" /></a>
					</div>
					
					<div class="col-instagram-3_admin instagram-picture-box-in col-instagram-offset-1_admin">
						<h4>Support & Feedback</h4>
							<p>More information: <a href="?page=instagram_picture_contact">here</a></p>
							<p><b>We are also references</b></p>
					</div>
					
					<div class="col-instagram-3_admin instagram-picture-box-in col-instagram-offset-1_admin">
						<h3>Donate</h3>
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
								<input type="hidden" name="cmd" value="_s-xclick">
								<input type="hidden" name="hosted_button_id" value="A8SDCKGAXDHC8">
								<input type="image" src="http://tb-webtec.de/support.png" border="0" name="submit" alt="Support us with coffee-money">
								<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
							</form>

						<p>Support us so we can continue to drive the development.</p>
					</div>
					
				<div class="instagram_clear_admin"></div>
		</div>
		<hr />';
	
		echo '
			<h2>Instagram-Picture functions</h2>
				<div class="row-instagram_admin">
					<div class="col-instagram-3_admin instagram-picture-box-in">
						<h3>PHP-Code</h3>
							<p>If the header doens\'t include the Widget panel, you have to write the PHP-Code into the header.php:<br /> <code>&lt;?php instagram_header(); ?&gt;</code></p>
							<p>Here you will find the settings: <a href="?page=instagram_picture_php_code">PHP-Code</a></p>
					</div>
					<div class="col-instagram-3_admin instagram-picture-box-in col-instagram-offset-1_admin">
						<h3>Widget</h3>
							<p>If your design contain a dynamic Widget area, you can implement the Instagram Picture.</p>
							<p>Of course you can adjust design also in the Widget panel of Wordpress.</p>
							<p>Here you can find the documentation: <a href="?page=instagram_picture_widget">Widget</a></p>
					</div>
					<div class="col-instagram-3_admin instagram-picture-box-in col-instagram-offset-1_admin">
						<h3>Shortcode</h3>
							<p>With the short code easily display the images in an article. To the short code applies some additional features.</p>
							<p>Here you can find the documentation: <a href="?page=instagram_picture_shortcode_doku">Shortcode</a></p>
					</div>
				</div>
			<div class="instagram_clear_admin"></div>
		<hr />
		';
		
echo '		</div>';
	########################################################################################################################
}
?>