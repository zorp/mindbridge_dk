<?php
function instagram_picture_alle_bilder() {

	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	########################################################################################################################

	########################################################################################################################
	/*
	*	All Pictures
	*/
		// Picture count
		$num_bilder = $wpdb->get_var("SELECT COUNT(*) FROM $instagram_picture_variable[101]");

		// Check whether any pictures exist	
		if($num_bilder != "0")
		{	
		
			$picid_get = $_GET["picid_get"];
			
			// Update the datas
			if(isset($_POST['status']) OR isset($_POST["custom_link"]))
			{
				$picid_custom		= $_POST['custom_link'];
				$picid_status		= $_POST['status'];
		
				$wpdb->query("UPDATE $instagram_picture_variable[101] Set status = '$picid_status', custom_link='$picid_custom' WHERE id = '$picid_get'");
				
				unset($picid_get);
				unset($_POST['custom_link']);
				unset($_POST['status']);
				
				echo '<div class="instagram-picture-success instagram-admin-fadein">Logged</div>';
			}			
			
			// Singel image
			if(!empty($picid_get))
			{
				foreach( $wpdb->get_results("SELECT * FROM $instagram_picture_variable[101] WHERE id = '$picid_get'") as $key => $row) 
				{
					$url 				= $row->thumbnail;
					$title 			= $row->text;  
					$id 				= $row->id;  				
					$status 			= $row->status;
					$custom_link 	= $row->custom_link;
				}

				echo '<div class="instagram-picture-box">';		
				
				echo '
				<div class="row-instagram-admin instagram-admin-fadein">
					<div class="col-instagram-1_admin">
						<img src="'.$url.'" title="'.$title.'" width="100%" />
					</div>
					<div class="row-instagram-admin">
						<div class="col-instagram-5_admin col-instagram-offset-1_admin">
							<b>'.$id.'</b>
						</div>
					</div>
					<div class="row-instagram-admin">
						<div class="col-instagram-5_admin col-instagram-offset-1_admin" style="';if(isset($_POST['status']) OR isset($_POST["custom_link"])){echo 'background-color:#3d8b3d;';} echo 'padding:5px 10px 5px 10px;">
							<form action="" id="instagram" method="post">
								<input type="text" name="custom_link" value="'.$custom_link.'" placeholder="Custom link" style="width:100%;" />
									<div class="row-instagram-admin">
										<div class="col-instagram-2_admin" style="text-align:center;">
											<input type="radio" name="status" value="0"';if($status == "0"){echo ' checked="checked"';} echo '>
										</div>
										<div class="col-instagram-2_admin" style="text-align:center;">
											<input type="radio" name="status" value="1"';if($status == "1"){echo ' checked="checked"';} echo '>
										</div>
									</div>
									<div class="instagram_clear_admin"></div>
									<div class="row-instagram-admin">
										<div class="col-instagram-2_admin" style="text-align:center;">
											Public
										</div>
										<div class="col-instagram-2_admin" style="text-align:center;">
											not Public
										</div>
									</div>
									<div class="instagram_clear_admin"></div>
								<button type="submit" class="instagram-picture-success-button">Save</button>
							</form>
						</div>
					</div>
				</div>
				<div class="instagram_clear_admin"></div>
				';				
				
				echo '</div>';
			}
			
				echo '<div class="instagram-picture-box"><h2>All Pictures</h2>';
	
				$i=1;		
				// Spend existing images
				foreach( $wpdb->get_results("SELECT * FROM $instagram_picture_variable[101] ORDER BY id DESC") as $key => $row) 
				{
					$url 				= $row->thumbnail;
					$title 			= $row->text;  
					$id 				= $row->id;  				
					$status 			= $row->status;
					$custom_link 	= $row->custom_link;
		
					$class = ($i % 2) ? "FFFFFF" : "E0E0E0";
		
					// output
					echo '
					<table style="float:left;border: 1px solid; margin:5px;background-color:#'.$class.';padding:5px;">
						<tr>
							<td><img src="'.$url.'" title="'.$title.'" width="80px" /></td>
							<td style="text-align:center;"><b>'.$id.'</b><br />
								<a href="?page=instagram_picture_alle_bilder&picid_get='.$id.'" class="instagram-picture-info-button">edit</a>
								<br />
									<div style="margin:0 auto;">';
									
										$plugins_url = plugins_url('instagram-picture/img');
										if(empty($custom_link))
										{
											echo '<img src="'.$plugins_url.'/yellow.png" alt="Not Custom link" title="Not Custom link"> ';
										}
										else {
											echo '<img src="'.$plugins_url.'/green.png" alt="Custom link available" title="Custom link available"> ';
										}
										if($status == "0")
										{
											echo '<img src="'.$plugins_url.'/green.png" alt="Public" title="Public">';
										}
										else {
											echo '<img src="'.$plugins_url.'/red.png" alt="Not Public" title="Not Public">';
										}
									echo '</div>
							</td>
						</tr>
					</table>';
		
					$i++;
				}
	
			// clear
			echo '
				<div class="instagram_clear_admin"></div>
			</div>';
	
		}	
		else 
		{
			echo '
			<div class="instagram-picture-box">
				<h2>All Pictures</h2>
				<div class="instagram-picture-alert">
					<p>You need to upgrade your images first.</p><p>Just click on <b>"<a href="?page=instagram_picture_aktualisieren">Update</a>"</b></p>
				</div>
			</div>
			';
		}	
		
	########################################################################################################################		
		
}
?>