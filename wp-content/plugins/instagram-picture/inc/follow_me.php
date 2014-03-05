<?php
function instagram_picture_follow_me() 
{

	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	########################################################################################################################
	
	echo '<div class="instagram-picture-box">';
	
	########################################################################################################################
	/* Update function */

		echo '			
				<div class="row-instagram_admin">
					<div class="col-instagram-5_admin instagram-picture-box-in">
						<h2>Follow Me Button Update</h2>
							<form action="" id="instagram" method="post">
								<button type="submit" class="instagram-picture-success-button">Update</button>
								<input type="hidden" name="submitted" id="submitted" value="1" />
							</form>';
			if($_POST["submitted"] == "1")
			{
				echo '<div class="instagram-picture-success">Process was finished</div>';
			}
		echo '
					</div>';
					
			if($_POST["submitted"] == "1")
			{
				echo '<div class="col-instagram-5_admin instagram-picture-box-in instagram-picture-success">';
				
					$dir = $instagram_picture_variable["10"]."/button/";
					
					$filearray = array();

					if (is_dir($dir)) 
					{
    					if ($dh_folder = opendir($dir)) 
    					{
        					while (($folder = readdir($dh_folder)) !== false) 
        					{
        						$foldertyp = filetype($dir . $folder);
        		
        						// exclusion
            				if($foldertyp == "dir" AND $folder != "." AND $folder != "..")
            				{
            					$folder_name = $folder;
            					echo 'Folder found (<b>'.$folder.'</b>)<br>';
            	
            					// order to open
            					$filedir = $dir.$folder.'/';
            	
            					if (is_dir($filedir)) 
            					{
    									if ($dh_file = opendir($filedir)) 
    									{
        									while (($file = readdir($dh_file)) !== false) 
        									{
        										$filedirtyp = $filedir.$file;
        										$filetyp = mime_content_type($filedirtyp);

        										// exclusion
            								if($filetyp == "image/png")
            								{
            									echo ' - file found (<b>'.$file.'</b>)<br>';
            									$filearray[] = array($folder_name, $file);
            								}
        									}
        									closedir($dh_file);
    									}
									}
					
            					echo "<hr>";
            				}
        					}
        					closedir($dh_folder);
    					}
					}

				echo '</div>';
				
				// Follow Me Buttons in db save
				$string = json_encode($filearray);
				
				$wpdb->query("UPDATE $instagram_picture_variable[100] Set text = '$string' WHERE id = '9'");

			}
		echo '
				</div>
				<div class="instagram_clear_admin"></div>';
										
	########################################################################################################################
	
	
	########################################################################################################################
	/* All Follow Me Buttons */
	
	// DB query
	$result = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='9'");
	
	if($result != "0")
	{
	
		$array = json_decode($result, true);
	
		echo '
		<div class="row-instagram_admin">
			<div class="col-instagram-12_admin">';
	
		for($i=0; $i < count($array); $i++)
   	{
   		$folder = $array[$i]["0"];
   		$file 	= $array[$i]["1"];
   	
   		$pfad_url = plugins_url('instagram-picture/button/');
   	
   		echo '
						<table style="float:left;margin:0px 5px 10px 0px;padding:5px;width:200px;height:120px;">
							<tr>
								<td style="text-align:center;">
									<div style="margin:0 auto;">
										<img src="'.$pfad_url.$folder.'/'.$file.'"><br>
										'.$file.'
									</div>
								</td>
							</tr>
						</table>';
   	}
   
  	 echo '
			</div>
		<div class="instagram_clear_admin"></div>';
	
	}
	
	
	########################################################################################################################
	
	
	########################################################################################################################
	/* Tutorial */
	echo '
	<div class="row-instagram_admin">
		<div class="col-instagram-6_admin instagram-picture-box-in">
			<h3>Tutorial</h3>
			<ul>
				<li>1. Here download "Follow me" buttons: <strong><a href="http://ipic.tb-webtec.de/additive_follow_me_button.php" target="_blank">http://ipic.tb-webtec.de/additive_follow_me_button.php</a> (free)</strong></li>
				<li>2. <strong>Unzip zip file</strong></li>
				<li>3, Upload main folder with the images via FTP to the folder <strong>/wp-content/plugins/instagram-picture/button</strong></li>
				<li>4. Click above to <strong>Update</strong></li>
			</ul>
		</div>
	</div>
	<div class="instagram_clear_admin"></div>';
	
	########################################################################################################################
	
	echo '</div>';

}
?>