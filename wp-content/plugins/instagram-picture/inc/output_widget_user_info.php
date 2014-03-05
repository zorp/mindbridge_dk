<?php

// User Info
class instagram_importer_widget_user_info extends WP_Widget 
{
	
	public function __construct() {
		parent::__construct(
			'instagram_picture_user_info',
			'Instagram Picture User Infos',
			array(
				'description' => 'Pictures with User Infos'
			)
	    );
	}
	
function form($config)
{
	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	########################################################################################################################
?>
    <label for="<?php echo $this->get_field_id("title");  ?>">
    <p>Title:<br><input placeholder="Title" type="text"  value="<?php echo $config['title']; ?>" name="<?php  echo $this->get_field_name("title"); ?>" id="<?php  echo $this->get_field_id("title") ?>"></p>
    </label>
    
    <label for="<?php echo $this->get_field_id("update");?>">
    <p>Update:<br>
    	<input type="radio" name="<?php echo  $this->get_field_name("update"); ?>" value="0" <?php if($config['update'] == "0" OR empty($config['update'])) {echo " checked='checked'";} ?>> DB
		<input type="radio" name="<?php echo  $this->get_field_name("update"); ?>" value="1" <?php if($config['update'] == "1") {echo " checked='checked'";} ?>> Live
    </p>
    </label>
    
    <?php
			if($config['user_info_style'] == "301" OR empty($config['user_info_style'])){ $result_style_output="301";$config['user_info_style']="301";}
			if($config['user_info_style'] == "302"){ $result_style_output="302";}
    ?>
    <label for="<?php echo $this->get_field_id("user_info_style");?>">
    <p>Style for User info:<br>
    	<select name="<?php echo  $this->get_field_name("user_info_style"); ?>" size="1">
			<option value="<?php echo $config['user_info_style']; ?>"><?php echo $result_style_output; ?></option>
    		<?php 
    		if($config['user_info_style'] != "301"){echo '<option value="301">301</option>';}
    		if($config['user_info_style'] != "302"){echo '<option value="302">302</option>';}
     		?>
    	</select>
    </p>
    </label>
    
    <label for="<?php echo $this->get_field_id("pictures_style");?>">
    <p>Style ID for pictures:<br><input  placeholder="200 - 231" type="text" value="<?php echo $config['pictures_style'];  ?>" name="<?php echo  $this->get_field_name("pictures_style"); ?>" id="<?php  echo $this->get_field_id("pictures_style") ?>"></p>
    </label>
    
    <?php
   	   if($config['link'] == "0" OR empty($config['link'])){ $result_link_output="Do Nothing"; $config['link']="0";}
			if($config['link'] == "1"){ $result_link_output="Original Page";}
			if($config['link'] == "2"){ $result_link_output="Original Page with hover-effect";}
			if($config['link'] == "3"){ $result_link_output="Direct link";}
			if($config['link'] == "4"){ $result_link_output="Direct link with hover-effect";}
			if($config['link'] == "5"){ $result_link_output="Custom link";}
			if($config['link'] == "6"){ $result_link_output="Custom link with hover-effect";}
    ?>
    <label for="<?php echo $this->get_field_id("link");?>">
    <p>Picture linkable:<br>
    	<select name="<?php echo  $this->get_field_name("link"); ?>" size="1">
			<option value="<?php echo $config['link']; ?>"><?php echo $result_link_output; ?></option>
    		<?php if($config['link'] != "0"){echo '<option value="0">Do Nothing</option>';}
      	if($config['link'] != "1"){echo '<option value="1">Original Page</option>';}
      	if($config['link'] != "2"){echo '<option value="2">Original Page with hover-effect</option>';}
      	if($config['link'] != "3"){echo '<option value="3">Direct link</option>';}
      	if($config['link'] != "4"){echo '<option value="4">Direct link with hover-effect</option>';} 
      	if($config['link'] != "5"){echo '<option value="5">Custom link</option>';}
      	if($config['link'] != "6"){echo '<option value="6">Custom link with hover-effect</option>';} 
     		?>
    	</select>
    </p>
    </label>
    
    <label for="<?php echo $this->get_field_id("follow_me");?>">
    <p>Follow me Button:<br>
    	<select name="<?php echo  $this->get_field_name("follow_me"); ?>" size="1">
    		<?php
    			$set_follow_me = $config['follow_me'];
    			
    			$result = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='9'");
				$array = json_decode($result, true);
    			
    			if($set_follow_me==""){$set_follow_me="leer";}
    			if($set_follow_me == "leer")
    			{
    				echo '<option value="leer">No Button</option>';
    			}
    			else {
    				$file 	= $array[$set_follow_me]["1"];
    				echo '<option value="'.$set_follow_me.'">'.$file.'</option>';
    			}
    			if($set_follow_me != "leer")
    			{
    				echo '<option value="leer">No Button</option>';
    			}
				
				for($i=0; $i < count($array); $i++)
   			{
   				$file 	= $array[$i]["1"];

   				echo '<option value="'.$i.'">'.$file.'</option>';
   			}
     		?>
    	</select>
    </p>
    </label>
    
<?php        
}


function update($newinstance,$oldinstance)
{
    $instance = $oldinstance;

	 $instance = array();
	 $instagram = array();

	 $instagram =  $newinstance['update'];
	 $instagram =  $newinstance['link'];
	 $instagram =  $newinstance['user_info_style'];
	 $instagram =  $newinstance['pictures_style'];
	 $instagram =  $newinstance['follow_me'];
    
    $instance['update'] =  $newinstance['update'];
    $instance['link'] =  $newinstance['link'];
    $instance['title'] =  $newinstance['title'];
    $instance['user_info_style'] =  $newinstance['user_info_style'];
    $instance['pictures_style'] =  $newinstance['pictures_style'];
    $instance['follow_me'] =  $newinstance['follow_me'];

    return $instance;
    return $instagram;
}
	

function widget($instance, $instagram)
{
	
	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	########################################################################################################################
	
     $table_name 					= $wpdb->prefix . "instagram_bilder";	

	  $title 							= $instagram["title"];
     $result_update 				= $instagram['update'];
     $result_link 					= $instagram['link'];
     $result_style_info			= $instagram['user_info_style'];
     $result_pictures_style	= $instagram['pictures_style'];
     $result_follow_me			= $instagram['follow_me'];
     
     $before_widget 				= $instance["before_widget"];
     $after_widget 					= $instance["after_widget"];
     $before_title 					= $instance["before_title"];
     $after_title 					= $instance["after_title"];
     $widget_id 						= $instance["widget_id"];
     
     	###############
		/*
		* include grid
		*/
		require_once("grid.php");
		##############
     
     echo $before_widget;
     
     if(!empty($title))
     {
     	echo $before_title.''.$title.''.$after_title;	
     }
     
     
     	// User Infos DB
		if(empty($result_update) OR $result_update == "0")
		{
		
			// Tabelle
  			$table_user_info = $wpdb->prefix . "instagram_user_info";
  		
  			foreach( $wpdb->get_results("SELECT * FROM $table_user_info WHERE ID ='1'") as $key => $row) 
   		{
   			$username 				= $row->username;
   			$full_name 			= $row->full_name;
   			$media 					= $row->media;
   			$followers				= $row->followed;
   			$following 			= $row->follows;
   			$profil_picture 	= $row->profil_picture;
			}
		
		}
		// User Infos live
		if($result_update == "1")
		{			
			// Tabelle
  			$table_info = $wpdb->prefix . "instagram_info";
	
			// member-id und access-token
			$instagram_id = $wpdb->get_var("SELECT text FROM $table_info WHERE id='1'");
   		$instagram_access = $wpdb->get_var("SELECT text FROM $table_info WHERE id='2'");
		
			$url='https://api.instagram.com/v1/users/'.$instagram_id.'/?access_token='.$instagram_access;
		
			// Get cURL resource
			$curl = curl_init();
			// Options
			curl_setopt_array($curl, array(
  			CURLOPT_RETURNTRANSFER => true,
  			CURLOPT_URL => $url,
  			CURLOPT_CONNECTTIMEOUT => 10,
  			CURLOPT_TIMEOUT => 60,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_HEADER => false
 			));

			$resp = curl_exec($curl);
			curl_close($curl);

			// Wenn daten vorhanden sind
			if($resp)
			{
				// Mit json nun decoden, damit Wir es im Array auslesen können
				$data=json_decode($resp, true);
			
				// Error speicherung in der Variable
				$error = $data["meta"]["code"];	
			
				// Wenn Error 200 ist, dann ist alles ok!
				if($error == "200")
				{

					$username				= $data["data"]["username"];
					$profil_picture 	= $data["data"]["profile_picture"];
					$full_name 			= $data["data"]["full_name"];
					$media					= $data["data"]["counts"]["media"];
					$followers				= $data["data"]["counts"]["followed_by"];
					$following				= $data["data"]["counts"]["follows"];
				
				}
			}		
		
		}
	
			// Number_format
			$media 			= number_format($media);
			$followers 	= number_format($followers);
			$following 	= number_format($following);

		
			// Style review
			if(empty($result_style) OR $result_style == "0"){$result_style="301";}
			
			
			$result_grid_info = grid($result_style_info);
			
			// HTML output
			$output_info=$result_grid_info["0"];
			
			
			// Parser
			$output_info = str_replace("[media]", $media, $output_info);
			$output_info = str_replace("[followers]", $followers, $output_info);
			$output_info = str_replace("[following]", $following, $output_info);
			$output_info = str_replace("[username]", $username, $output_info);
			$output_info = str_replace("[fullname]", $full_name, $output_info);
			
			// Output first box
			echo $output_info;	
			
		// Check whether with images
		if(!empty($result_pictures_style))
		{
			$result_grid = grid($result_pictures_style);
	  		// HTML-Ausgabe
	  		$output_two=$result_grid["0"];
	  		// Wie viele Bilder
	  		$anzahl=$result_grid["1"];
	  
			$limit=$anzahl;
	
			// Tabelle der Bilder
			$table_name_bilder = $wpdb->prefix . "instagram_bilder";	
			
			$i="1";
			foreach( $wpdb->get_results("SELECT * FROM $table_name_bilder WHERE status ='0' ORDER BY id DESC LIMIT $limit") as $key => $row) 
   		{
   			$url 							= $row->low_resolution;
   			$standard_resolution 	= $row->standard_resolution;
				$link 						= $row->link;  
				$title 						= $row->text;  	
				$custom_link 				= $row->custom_link;	
				
				$title = str_replace("\"", "", $title);
			
    	
				if($i < "10")
				{
					$i = "0$i";	
				}
		
				if($result_link == "1")
				{
					$link_anfang = '<a href="'.$link.'" target="_blank">';
					$link_ende = '</a>';
				}
				if($result_link == "2")
				{
					$link_anfang = '<div class="instagram-picture-hover"><a href="'.$link.'" target="_blank">';
					$link_ende = '</a></div>';
				}
				if($result_link == "3")
				{
					$widget_id = str_replace("instagram_picture_individually-", "", $widget_id);
					$link_anfang = '<a href="'.$standard_resolution.'" title="'.$title.'">';
					$link_ende = '</a>';
				}
				if($result_link == "4")
				{
					$widget_id = str_replace("instagram_picture_individually-", "", $widget_id);
					$link_anfang = '<div class="instagram-picture-hover"><a href="'.$standard_resolution.'" title="'.$title.'">';
					$link_ende = '</a></div>';
				}
				if($result_link == "5")
				{
					$widget_id = str_replace("instagram_picture_individually-", "", $widget_id);
					$link_anfang = '<a href="'.$custom_link.'" title="'.$title.'">';
					$link_ende = '</a>';
				}
				if($result_link == "6")
				{
					$widget_id = str_replace("instagram_picture_individually-", "", $widget_id);
					$link_anfang = '<div class="instagram-picture-hover"><a href="'.$custom_link.'" title="'.$title.'">';
					$link_ende = '</a></div>';
				}
				
    	
   			$output_two = str_replace("[$i]", $link_anfang.'<img src="'.$url.'" alt="'.$title.'">'.$link_ende, $output_two);
   			$i++;
  			}

			// Output Two
  			echo $output_two;
		}
		
		// check Follow Me Button
		if($result_follow_me != "leer") 
		{
			$result = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='9'");
			$array = json_decode($result, true);
			
			$folder = $array[$result_follow_me]["0"];
   		$file 	= $array[$result_follow_me]["1"];
   		
			$pfad_url = plugins_url('instagram-picture/button/');
			
			echo '<div style="text-align:center;"><a target="_blank" href="http://instagram.com/'.$username.'"><img src="'.$pfad_url.$folder.'/'.$file.'" alt="Follow me on Instagram"></a></div>';
		}

     

	  echo $after_widget;
     
     echo "\n\n";
     
}	

// ende der class
}


add_action( 'widgets_init', 'load_instagram_importer_widget_user_info' );

function load_instagram_importer_widget_user_info() {
	register_widget( 'instagram_importer_widget_user_info' );
}

?>