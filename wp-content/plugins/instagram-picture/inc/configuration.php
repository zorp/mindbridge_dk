<?php
function instagram_picture_konfiguration()
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
	* storing a Instagram-ID and Access-Token
	*/		
		########################################################################################################################
		// Form is transmitted
		if($_POST["submitted"] == "1")
		{
			$instagram_id = $_POST["instagram_id"];
			$instagram_access = $_POST["instagram_access"];
		
			$wpdb->query("UPDATE $instagram_picture_variable[100] Set text = '$instagram_id' WHERE id = '1'");
			$wpdb->query("UPDATE $instagram_picture_variable[100] Set text = '$instagram_access' WHERE id = '2'");
		
			// Ausgabe das es erfolgreich war
			echo '
				<div class="instagram-picture-box">
					<h2>Configuration</h2>
				</div>
				<div class="instagram-picture-success"><p>Profil was set.<br>Push the bottom of "<a href="?page=instagram_picture_aktualisieren">Update</a>" for uploading of the actual pictures</p></div>';
		}
		if($_POST["submitted"] == "2")
		{
			// xx_instagram_user_info
				$wpdb->query("DELETE FROM $instagram_picture_variable[102] WHERE id = '1'");
				$wpdb->query("INSERT INTO $instagram_picture_variable[102] (id) VALUES ('1')");
				
			// xx_instagram_info
				$wpdb->query("UPDATE $instagram_picture_variable[100] Set text = '' WHERE id = '1'");
				$wpdb->query("UPDATE $instagram_picture_variable[100] Set text = '' WHERE id = '2'");
				
			// xx_instagram_bilder
				$wpdb->query("TRUNCATE TABLE $instagram_picture_variable[101]");
		
			// Ausgabe das es erfolgreich war
			echo '
				<div class="instagram-picture-box">
					<h2>Reset</h2>
				</div>
				<div class="instagram-picture-success">Tables have been reset</div>';
		}
		########################################################################################################################
		
		########################################################################################################################
   	// User-id und access-token in Variable speichern
		$result_id = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='1'");
		$result_access = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='2'");
		########################################################################################################################	
		
		########################################################################################################################
			echo '
					<div class="instagram-picture-box">
						<h2>Configuration</h2>
						<hr />
						
						<div class="row-instagram_admin">
							<div class="col-instagram-5_admin instagram-picture-box-in">
								<h2>Connect Instagram account</h2>
									<a href="http://ipic.tb-webtec.de/login.php" target="_blank">Here you will find the information.</a>	
										<form action="" id="instagram" method="post">
											<ul>
												<li>
													<label for="instagram_id"><b>Instagram-ID:</b></label><br />
													<input type="text" name="instagram_id" id="instagram_id" value="'.$result_id.'" style="width:100%;" />
												</li>
												<li>
													<label for="instagram_access"><b>Access-Token:</b></label><br />
													<input type="text" name="instagram_access" id="instagram_access" value="'.$result_access.'" style="width:100%;" />
												</li>
												<li>
													<button type="submit" class="instagram-picture-success-button">Save</button>
												</li>
											</ul>
											<input type="hidden" name="submitted" id="submitted" value="1" />
										</form>
								</div>
								<div class="col-instagram-5_admin instagram-picture-box-in">
									<h2>Instagram-Picture reset</h2>
										<p>It deletes all images and profile information</p>
										<form action="" id="instagram" method="post">
											<button type="submit" class="instagram-picture-danger-button">Reset</button>
											<input type="hidden" name="submitted" id="submitted" value="2" />
										</form>
								</div>
						</div>
						<div class="instagram_clear_admin"></div>
						
					</div>
					<div class="instagram-picture-box">
						<h2>Tutorial</h2>
						<p>A good tutorial can be found here: <a href="http://www.inmotionhosting.com/support/website/wordpress-plugins/instagram-picture-plugin-for-wordpress" target="_blank">
							http://www.inmotionhosting.com/support/website/wordpress-plugins/instagram-picture-plugin-for-wordpress</a></p>
					</div>
				';
		########################################################################################################################
		
}
?>