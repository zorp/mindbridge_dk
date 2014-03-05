<?php
function instagram_picture_css() {

	########################################################################################################################
	/* 
	*	variable definition
   */
	global $instagram_picture_variable;
	global $wpdb;
	########################################################################################################################

	// File define
	define('INSTAGRAM_PICTURE_DIR', dirname(__FILE__));

	// Select file
	$real_file = INSTAGRAM_PICTURE_DIR . '/css/instagram_style.css';
	
	// Check that post available
	if(isset($_POST['newcontent']))
	{
		$newcontent = wp_unslash( $_POST['newcontent'] );
		
		// File is writable
		if ( is_writeable($real_file) ) 
		{
			// save
			$f = fopen($real_file, 'w+');
			fwrite($f, $newcontent);
			fclose($f);
		}
	}

	$content = file_get_contents( $real_file );

	$content = esc_textarea( $content );

	// Output
	echo '
	<div class="instagram-picture-box">
		<h2>CSS</h2>
		<form name="template" id="template" method="post">
			<textarea cols="70" rows="25" name="newcontent" id="newcontent" aria-describedby="newcontent-description">'.$content.'</textarea>
			<button type="submit" class="instagram-picture-success-button">Save</button>
		</form>
	</div>';
}
?>