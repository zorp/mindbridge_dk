<?php

function instagram_picture_widget() {
	
	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	########################################################################################################################
	
		###############
		/*
		* include grid
		*/
		require_once("grid.php");
		##############
		
		echo '
		<style>
			.box
			{
				width: 40%;
				float: left;
			}
			.box td
			{
				text-align:center;	
			}
			.box_margin
			{
				margin-right: 100px;
			}
		</style>
		';	
	
		// Check if images are present at all!
		$num_bilder = $wpdb->get_var("SELECT COUNT(*) FROM $instagram_picture_variable[101]");
	
		if($num_bilder != "0")
		{
			echo '
				<div class="instagram-picture-box">
					<h2>Widget Doku</h2>
					<hr />
					<div class="box box_margin">
						<h3>Settings</h3>
						<div class="row-instagram_admin">
							<div class="col-instagram-12_admin instagram-picture-box-in">
							<h4>Instagram Picture individually</h4>
							This widget allows you to highlight a picture<br/>
							<b>Title</b> - The heading<br />
							<b>Picture-ID</b> - Picture ID (IDs can be found here <a href="?page=instagram_picture_alle_bilder">All Pictures</a>)<br />
							<b>Picture linkable</b> - Linking to Instagram Page or Direct link <br />
							<b>Picture title</b> - The title as mouse-over<br />
							<b>Border-Radius</b> - percent indicating whether the image should be round.<br />
							<b>Follow me Button</b> - Select a Button<br />
							</div>
						</div>
						<div class="instagram_clear_admin"></div>
								<hr />
						<div class="row-instagram_admin">
							<div class="col-instagram-12_admin instagram-picture-box-in">
							<h4>Instagram Picture</h4>
							Several images with a style<br />
							<b>Title</b> - The heading<br />
							<b>Style-ID</b> - Style ID (A list is below)<br />
							<b>Picture linkable</b> - Linking to Instagram Page or Direct link <br />
							<b>Picture title</b> - The title as mouse-over<br />
							<b>Border-Radius</b> - percent indicating whether the image should be round.<br />
							<b>Follow me Button</b> - Select a Button<br />
							</div>
						</div>
						<div class="instagram_clear_admin"></div>
								<hr />
						<div class="row-instagram_admin">
							<div class="col-instagram-12_admin instagram-picture-box-in">
							<h4>Instagram Picture with Infos</h3>
							This widget allows you to highlight a picture with Infos<br/>
							<b>Title</b> - The heading<br />
							<b>Picture-ID</b> - Picture ID (IDs can be found here <a href="?page=instagram_picture_alle_bilder">All Pictures</a>)<br />
							<b>Picture linkable</b> - Linking to Direct link <br />
							<b>Width</b> - width of the div box<br>
							<b>Follow me Button</b> - Select a Button<br />
							</div>
						</div>
						<div class="instagram_clear_admin"></div>
								<hr />
						<div class="row-instagram_admin">
							<div class="col-instagram-12_admin instagram-picture-box-in">
							<h4>Instagram Picture User Infos</h4>
							<b>Title</b> - The heading<br />
							<b>Update</b> - DB or live (Standard: DB)<br />
							<b>Style for User info</b> - Select a style (See below examples)<br />
							<b>Style ID for pictures</b> - Select a style (See right)<br />
							<b>Picture linkable</b> - Linking to Instagram Page or Direct link <br />
							<b>Follow me Button</b> - Select a Button<br />
							<img src="'.$instagram_picture_variable["11"].'screenshot-1.png">
							<img src="'.$instagram_picture_variable["11"].'screenshot-3.png">
							</div>
						</div>
						<hr />
					</div>
					<div class="box">
						<div style="margin: 0 auto;">
							<h3>All styles</h3>
							<p>The styles-ids for the widget</p>
						</div>
						<table style="width:300px;margin:0 auto;padding:5px; border:1px solid;">
				';
	
				$style_ende=$instagram_picture_variable[7];
		
				$class_id = '1';
				for ($style = 200; $style < $style_ende; $style++)
				{
					$result_grid = grid($style);
	
					// HTML output
					$output=$result_grid["0"];
					// Number of images in style
					$anzahl=$result_grid["1"];

					$i="1";
					$limit = $anzahl;
					
					// CSS-Class
					$class = ($class_id % 2) ? "#FFFFFF" : "#E0E0E0";
					
					// Compare whether there are enough pictures
					
					if($limit > $num_bilder)
					{
						echo '
						<tr style="background-color:'.$class.';">
							<td>Not enough pictures<hr/></td>
							<td style="width:80px;"></td>
						</tr>
						';
					}
					else 
					{
					
						foreach( $wpdb->get_results("SELECT * FROM $instagram_picture_variable[101] ORDER BY id DESC LIMIT $limit") as $key => $row) 
   					{
   						if($i < "10")
							{
								$i = "0$i";	
							}
		
   						$url = $row->thumbnail;
   	
   						$output = str_replace("[$i]", '<img src="'.$url.'" />', $output);
   						$i++;
  	 					}
						echo '
						<tr style="background-color:'.$class.';">
							<td>'.$output.'<hr/></td>
							<td style="width:80px;">Style-ID:<br><b>'.$style.'</b></td>
						</tr>
						';
			
					}
					$class_id++;
				}
	
			echo '</table></div>';
		}
		else 
		{
			echo '
			<div class="instagram-picture-box">
				<h2>Settings Widget</h2>
				<div class="instagram-picture-alert">
					<p>You need to upgrade your images first.</p><p>Just click on <b>"<a href="?page=instagram_picture_aktualisieren">Update</a>"</b></p>
				</div>
			</div>
			';
		}
	}
?>