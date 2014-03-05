<?php

// Info einzelnt
class instagram_importer_widget_info extends WP_Widget 
{
	
	public function __construct() {
		parent::__construct(
			'instagram_picture_info',
			'Instagram Picture with Infos',
			array(
				'description' => 'Choose a picture from Instagram with Infos'
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

    <label for="<?php echo $this->get_field_id("instagram_id");  ?>">
    <p>Picture-ID:<br><input placeholder="Instagram->All Pictures" type="text" value="<?php echo $config['instagram_id'];  ?>" name="<?php echo  $this->get_field_name("instagram_id"); ?>" id="<?php  echo $this->get_field_id("instagram_id") ?>"></p>
    </label>
    
	 <label for="<?php echo $this->get_field_id("width");  ?>">
    <p>Width:<br> <input placeholder="e.g. 150px or 100%" type="text"  value="<?php echo $config['width']; ?>" name="<?php  echo $this->get_field_name("width"); ?>" id="<?php  echo $this->get_field_id("width") ?>"></p>
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

    $instagram =  $newinstance['instagram_id'];
    $instagram =  $newinstance['link'];
	 $instagram =  $newinstance['follow_me'];
	 $instagram =  $newinstance['width'];
    
    $instance['instagram_id'] =  $newinstance['instagram_id'];
    $instance['title'] =  $newinstance['title'];
    $instance['link'] =  $newinstance['link'];
	 $instance['follow_me'] =  $newinstance['follow_me'];
	 $instance['width'] =  $newinstance['width'];

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
	
	
     $table_name = $wpdb->prefix . "instagram_bilder";	

     $title = $instagram["title"];
     $id = $instagram["instagram_id"];
     $result_link = $instagram["link"];
     $result_follow_me	= $instagram['follow_me'];
     $result_width = $instagram['width'];
     
     $before_widget = $instance["before_widget"];
     $after_widget = $instance["after_widget"];
     $before_title = $instance["before_title"];
     $after_title = $instance["after_title"];
     $widget_id = $instance["widget_id"];
     
     echo $before_widget;
     
     if(!empty($title))
     {
     	echo $before_title.''.$title.''.$after_title;	
     }

     foreach( $wpdb->get_results("SELECT * FROM $table_name WHERE id='$id'") as $key => $row) 
     {
     	 $url 							= $row->low_resolution;
     	 $standard_resolution 	= $row->standard_resolution;
		 $title 							= $row->text;
		 $link 							= $row->link;
		 $custom_link					= $row->custom_link;
		 
		 $title = str_replace("\"", "", $title);
 	
		 
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
			
			$bild = $link_anfang.'<img src="'.$url.'" alt="'.$title.'" style="max-width:100%;" />'.$link_ende;
			
			// Update
				$bild_like = $wpdb->get_var("SELECT pic_like FROM $table_name WHERE id='$id'");
				$bild_comments = $wpdb->get_var("SELECT pic_comment FROM $table_name WHERE id='$id'");
			
				$bild_like 		= number_format($bild_like);
				$bild_comments	= number_format($bild_comments);
			
			// Bild Pfad fÃ¼r Comment und like
			$file = plugins_url()."/instagram-picture/img/";	
			
			// width
       	if(empty($result_width))
      	{
         	$size="100%";  
      	}
       	else {
          $size = $result_width;  
      	}
			
			$ausgabe = '
		<!-- Instagram Picture -->
	   <!-- http://wordpress.org/plugins/instagram-picture/ -->
		<div style="width:'.$size.';">
			<div style="padding: 10px 5px 10px 5px;text-align:center;background-color:#EDEDED;border:1px groove;">
				<b>'.$title.'</b>
			</div>
			
			<div style="padding:10px;border-left:1px groove;border-right:1px groove;border-bottom:1px groove;background-color: #ffffff;">
				
				<div style="border:2px groove;padding:2px;margin-bottom:10px;">'.$bild.'</div>
				
				<div style="text-align:center;position: relative;display: block;">
				
					<img src="'.$file.'like.png" title="Likes" alt="Likes" style="box-shadow:none;width:29px;" /> 
					<span class="badge">'.$bild_like.'</span>

					<img src="'.$file.'comment.png" title="Comment" alt="Comment" style="box-shadow:none;width:29px;" />
					<span class="badge">'.$bild_comments.'</span>
					
				</div>
				
			</div>
			
		</div>
		<!-- Instagram Picture END -->';
		
		echo $ausgabe;
		
		// check Follow Me Button
		if($result_follow_me != "leer") 
		{
			$result = $wpdb->get_var("SELECT text FROM $instagram_picture_variable[100] WHERE id='9'");
			$array = json_decode($result, true);
			
			$folder = $array[$result_follow_me]["0"];
   		$file 	= $array[$result_follow_me]["1"];
   		
			$pfad_url = plugins_url('instagram-picture/button/');
			
			$username = $wpdb->get_var("SELECT username FROM $instagram_picture_variable[102] WHERE id='1'");
			
			echo '<div style="text-align:center;"><a target="_blank" href="http://instagram.com/'.$username.'"><img src="'.$pfad_url.$folder.'/'.$file.'" alt="Follow me on Instagram"></a></div>';
		}
			
			
     }
     
     echo $after_widget;
     
     echo "\n\n";
     
}	
	
	}


add_action( 'widgets_init', 'load_instagram_importer_widget_info' );

function load_instagram_importer_widget_info() {
	register_widget( 'instagram_importer_widget_info' );
}

?>