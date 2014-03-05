<?php
function instagram_picture_contact() 
{
	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	global $wp_version;
	global $current_user;
	########################################################################################################################

	$home = home_url();	
	
	get_currentuserinfo();
	$user_email = $current_user->user_email;
	
	$version = $instagram_picture_variable["0"];
	
		echo '<div class="instagram-picture-box">';
		
		echo '
		<div class="row-instagram-admin">
			<div class="col-instagram-10_admin instagram-picture-box-in col-instagram-offset-1_admin">
				<h2>We need your support</h2>
					<p>We want our plugin Instagram Picture is getting better. But without your help we do not do it.</p>
					<p>Therefore Join to contact us and tell us your opinion.</p>
					<p>Use this either in the contact form below or look at the other options.</p>
					<p><b>Caution!</b> We are also references to our website and Facebook page.</p>
			</div>
		</div>
		';
		
		echo '
			<div class="row-instagram-admin">
				<div class="col-instagram-4_admin instagram-picture-box-in col-instagram-offset-1_admin">
				';
			
			if(!isset($_POST['message']))
			{

				echo '<form action="" id="instagram" method="post">';
				echo '<h2>Form</h2>';
				
				// EMail
				echo '
				<div class="row-instagram-admin">
					<div class="col-instagram-4_admin">
						<b>E-Mail</b>
					</div>
					<div class="col-instagram-8_admin">
						<input type="text" name="user_email" value="'.$user_email.'" style="width:100%;" />
					</div>
					<div class="instagram_clear_admin"></div>
				</div>
				<hr />
				';
				
				// Domain
				echo '
				<div class="row-instagram-admin">
					<div class="col-instagram-4_admin">
						<b>Domain transmit</b>
						<br />'.$home.'
					</div>
					<div class="col-instagram-8_admin">
						<div class="row-instagram-admin">
							<div class="col-instagram-6_admin">
								<input type="radio" name="url_transmit" value="1" checked="checked">
								<br />Yes
							</div>
							<div class="col-instagram-6_admin">
								<input type="radio" name="url_transmit" value="2">
								<br />No
							</div>
						</div>
					</div>
					<div class="instagram_clear_admin"></div>
				</div>
				<hr />
				';		
				
				// WP-Version
				echo '
				<div class="row-instagram-admin">
					<div class="col-instagram-4_admin">
						<b>WP-Version transmit</b>
						<br />'.$wp_version.'
					</div>
					<div class="col-instagram-8_admin">
						<div class="row-instagram-admin">
							<div class="col-instagram-6_admin">
								<input type="radio" name="wp_transmit" value="1" checked="checked">
								<br />Yes
							</div>
							<div class="col-instagram-6_admin">
								<input type="radio" name="wp_transmit" value="2">
								<br />No
							</div>
						</div>
					</div>
					<div class="instagram_clear_admin"></div>
				</div>
				<hr />
				';			
				
				// Plugin Version
				echo '
				<div class="row-instagram-admin">
					<div class="col-instagram-4_admin">
						<b>Plugin-Version transmit</b>
						<br />'.$version.'
					</div>
					<div class="col-instagram-8_admin">
						<div class="row-instagram-admin">
							<div class="col-instagram-6_admin">
								<input type="radio" name="plugin_transmit" value="1" checked="checked">
								<br />Yes
							</div>
							<div class="col-instagram-6_admin">
								<input type="radio" name="plugin_transmit" value="2">
								<br />No
							</div>
						</div>
					</div>
					<div class="instagram_clear_admin"></div>
				</div>
				<hr />
				';
				
				// Subject
				echo '
				<div class="row-instagram-admin">
					<div class="col-instagram-4_admin">
						<b>Subject</b>
					</div>
					<div class="col-instagram-8_admin">
						<select name="subject" size="1">
   			   		<option>Help</option>
   			  		 	<option>Bug</option>
   			  		 	<option>Idea</option>
   			 		  	<option>Feedback</option>
   			 		  	<option>Reference</option>
   					</select>
					</div>
					<div class="instagram_clear_admin"></div>
				</div>
				<hr />
				';
				
				// Message
				echo '
				<div class="row-instagram-admin">
					<div class="col-instagram-4_admin">
						<b>Message</b>
					</div>
					<div class="col-instagram-8_admin">
						<textarea name="message" style="width:100%; height:100px;"></textarea>
					</div>
					<div class="instagram_clear_admin"></div>
				</div>
				<hr />
				';

				echo '<button type="submit" class="instagram-picture-success-button">Send</button>';
				echo '</form>';
			}
			else {
				
				$user_email = $_POST['user_email'];
				$url_transmit = $_POST['url_transmit'];
				$wp_transmit = $_POST['wp_transmit'];
				$plugin_transmit = $_POST['plugin_transmit'];
				$subject = $_POST['subject'];
				$message = $_POST['message'];
				
				
				$message = htmlentities($message, ENT_QUOTES);
				$user_email = htmlentities($user_email, ENT_QUOTES);
				
				if($url_transmit == "1")
				{
					$url_text = "Website: $home";
				}
				else {
					$url_text = "Website: none";	
				}
				
				if($wp_transmit == "1")
				{
					$wp_text = "WP-Version: $wp_version";
				}
				else {
					$wp_text = "WP-Version: none";	
				}
				
				if($plugin_transmit == "1")
				{
					$plugin_text = "Plugin-Version: $version";
				}
				else {
					$plugin_text = "Plugin-Version: none";	
				}
				
				$email = "$url_text\n$wp_text\n$plugin_text\n\n$message";
				
				$headers = 'From: '.$user_email. "\r\n";
				
				wp_mail('support@tb-webtec.de', $subject.' INSTAGRAM-PICTURE SUPPORT', $email, $headers);
				
				echo '<p>Your email has been sent.</p>';
			}
			
		echo '</div>';
		echo '<div class="col-instagram-4_admin instagram-picture-box-in col-instagram-offset-1_admin">';
		
		echo '<h2>Other options</h2>
			<p>Mail: <b>support@tb-webtec.de</b></p>
			<p>Website: <b><a href="http://tb-webtec.de/instagram_picture/contact.php" target="_blank">www.tb-webtec.de/instagram_picture/contact.php</a></b></p>
			<p>Wordpress: <b><a href="http://wordpress.org/support/plugin/instagram-picture" target="_blank">www.wordpress.org/support/plugin/instagram-picture</a></b></p>
			';
		
		echo '</div>';
		echo '</div>';
		echo '<div class="instagram_clear_admin"></div>';
		echo '</div>';

}
?>