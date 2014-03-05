<?php
function ipic_cron() 
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
	*	update data
	*/
	
		// get access
		$instagram_user_id = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='1'");
   	$instagram_access = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='2'");
	
		// If the data is present
		if(!empty($instagram_user_id) AND !empty($instagram_access))
		{
				
			########################################################################################################################
			/*
			* Get user data
			*/

				// URL where the data is
				$url='https://api.instagram.com/v1/users/'.$instagram_user_id.'/?access_token='.$instagram_access;
		
				// Get cURL resource
				$curl = curl_init();
				// Options
				curl_setopt_array($curl, array(
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_URL => $url,
  				CURLOPT_TIMEOUT => 5,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HEADER => false
 				));


				if(curl_exec($curl) === false)
				{
    				echo '<div class="instagram-picture-alert"><h3>cUrl-Error</h3> <p>' . curl_error($curl). '</p></div>';
				}

				$resp = curl_exec($curl);
				curl_close($curl);

				// If data are available
				if($resp)
				{
					// Readable data with json decode
					$data=json_decode($resp, true);
			
					// Save code output
					$code = $data["meta"]["code"];	
			
					// With code is 200, than string is ok
					if($code == "200")
					{
						// variable storage
						$username				= $data["data"]["username"];
						$profil_picture 	= $data["data"]["profile_picture"];
						$full_name 			= $data["data"]["full_name"];
						$media					= $data["data"]["counts"]["media"];
						$follwed				= $data["data"]["counts"]["followed_by"];
						$follows				= $data["data"]["counts"]["follows"];
				
						// Update of the data
						$wpdb->query("UPDATE $instagram_picture_variable[102] Set 
							username = '$username', 
							full_name = '$full_name', 
							media = '$media', 
							followed = '$follwed', 
							follows = '$follows', 
							profil_picture = '$profil_picture' 
							WHERE id = '1'");

					}
				}
			########################################################################################################################
				
			########################################################################################################################
			/*
			* Get user picture
			*/

			
				// URL where the data is
				$url='https://api.instagram.com/v1/users/'.$instagram_user_id.'/media/recent?access_token='.$instagram_access;
		

				// Get cURL resource
				$curl = curl_init();
				// Options
				curl_setopt_array($curl, array(
  				CURLOPT_RETURNTRANSFER => 1,
  				CURLOPT_URL => $url,
  				CURLOPT_TIMEOUT => 5,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HEADER => false
 				));

				$resp = curl_exec($curl);
				curl_close($curl);


				// If data are available
				if($resp)
				{
					// Readable data with json decode
					$data=json_decode($resp, true);
			
					// Save code output
					$code = $data["meta"]["code"];	
					
					// Since Instagram per query returns only 20 pictures, but we want more, we save the first next_url so that we can continue to read later.
					$url = $data["pagination"]["next_url"];
			
					// With code is 200, than string is ok
					if($code == "200")
					{
						// table empty
						$wpdb->query("TRUNCATE TABLE $instagram_picture_variable[101]");
			
						// array count
						$size = sizeof($data["data"]);
				
						// for loop so that everything is stored
						for ($i = 0; $i < $size; $i++)
            		{
            			// variable storage
							$picture_low			= $data["data"]["$i"]['images']['low_resolution']['url'];
							$picture_thumb		= $data["data"]["$i"]['images']['thumbnail']['url'];
							$picture_standard	= $data["data"]["$i"]['images']['standard_resolution']['url'];
							$picture_like			= $data["data"]["$i"]["likes"]["count"];
							$picture_comments	= $data["data"]["$i"]["comments"]["count"];
							$picture_link			= $data["data"]["$i"]['link'];
							$picture_id			= $data["data"]["$i"]["id"];
							$picture_text			= $data["data"]["$i"]["caption"]["text"];
							
							// string escapen					
							$picture_text = mysql_real_escape_string($picture_text);
				
							// The image-id contains the user-id. We therefore removed before storing the user-id
							$id_distance = "_$instagram_user_id";				
							$id = str_replace($id_distance, "", $picture_id);

							// Save
							$wpdb->query("INSERT INTO $instagram_picture_variable[101] (id, link, text, thumbnail, low_resolution, standard_resolution, pic_like, pic_comment) 
							VALUES ('$id', '$picture_link', '$picture_text', '$picture_thumb', '$picture_low', '$picture_standard', '$picture_like', '$picture_comments')");
				
						}

						// while loop. Until the cURL output has no next_url
						while($url != "") 
						{
							// Get cURL resource
							$curl = curl_init();
							// Options
							curl_setopt_array($curl, array(
  							CURLOPT_RETURNTRANSFER => 1,
  							CURLOPT_URL => $url,
  							CURLOPT_TIMEOUT => 5,
							CURLOPT_SSL_VERIFYPEER => false,
							CURLOPT_HEADER => false
 							));

							$resp = curl_exec($curl);
							curl_close($curl);

							// If data are available
							if($resp)
							{
								// Readable data with json decode
								$data=json_decode($resp, true);
			
								// Save code output
								$code = $data["meta"]["code"];	
					
								// Since Instagram per query returns only 20 pictures, but we want more, we save the first next_url so that we can continue to read later.
								$url = $data["pagination"]["next_url"];
			
								// With code is 200, than string is ok
								if($code == "200")
								{
			
									// array count
									$size = sizeof($data["data"]);
				
									// for loop so that everything is stored
									for ($i = 0; $i < $size; $i++)
            					{
            						// variable storage
										$picture_low			= $data["data"]["$i"]['images']['low_resolution']['url'];
										$picture_thumb		= $data["data"]["$i"]['images']['thumbnail']['url'];
										$picture_standard	= $data["data"]["$i"]['images']['standard_resolution']['url'];
										$picture_like			= $data["data"]["$i"]["likes"]["count"];
										$picture_comments	= $data["data"]["$i"]["comments"]["count"];
										$picture_link			= $data["data"]["$i"]['link'];
										$picture_id			= $data["data"]["$i"]["id"];
										$picture_text			= $data["data"]["$i"]["caption"]["text"];
							
										// string escapen					
										$picture_text = mysql_real_escape_string($picture_text);
				
										// The image-id contains the user-id. We therefore removed before storing the user-id
										$id_distance = "_$instagram_user_id";				
										$id = str_replace($id_distance, "", $picture_id);
				
										// SAVE
										$wpdb->query("INSERT INTO $instagram_picture_variable[101] (id, link, text, thumbnail, low_resolution, standard_resolution, pic_like, pic_comment) 
										VALUES ('$id', '$picture_link', '$picture_text', '$picture_thumb', '$picture_low', '$picture_standard', '$picture_like', '$picture_comments')");
				
									// end of for loop
									}
								
								// end of $code 200
								}
				
    						
    						//end of $resp
    						}
						
						// end of while loop next_url ($url)
						}
						
						// Text wenn alles geklappt hat.    
    					echo '
    						<div class="instagram-picture-box">
								<h2>Update Instagram photos</h2>
							</div>
							<div class="instagram-picture-success">
								<p><b>Pictures were updated.</b></p>
							</div>';
		
					// end of $code 200 (first connection)
					}
	
	########################################################################################################################
		
// end of function

			}		
		}
	}

	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	########################################################################################################################
	
	$cron = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='8'");

	if($cron == "1")
	{
		// Cronjob
		if ( !wp_next_scheduled('ipic_cron_update') ) {
			wp_schedule_event( time(), 'daily', 'ipic_cron_update' );
		}

		add_action( 'ipic_cron_update', 'ipic_cron' );
	}
	if($cron == "0")
	{
		wp_clear_scheduled_hook( 'ipic_cron_update' );
	}
?>