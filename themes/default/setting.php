<?php
extract(shortcode_atts(array(
	'background_id'	=> 0,
	'title'	=> 'Coming soon - Sitename',
	'description'	=> 'Tagline or description',
	'key' => '',
), (array)get_option('offline_site_display')));

$check = offline_site_check_key($key);

?>
<h4><?php _e( 'Default Theme Setting', 'offline-site' );?></h4>
<h4><?php _e( 'Background', 'offline-site' );?></h4>
<p id="offline_site_display_background_thumb"><?php echo ($background_id>0?wp_get_attachment_image($background_id,'thumbnail','',array('height' => 150) ):'');?></p>
<p>
	<input value="<?php echo $background_id;?>" type="hidden" name="offline_site_display[background_id]" id="offline_site_display_background_id" />
	<button id="offline_site_upload_background_button"><?php _e( 'Choose Image', 'offline-site' );?></button>
	<button id="offline_site_remove_background_button"><?php _e( 'Remove Image', 'offline-site' );?></button>
</p>
<h4><?php _e( 'Title', 'offline-site' );?></h4>
<p><input value="<?php echo $title;?>" name="offline_site_display[title]" style="width: 80%; max-width: 90%; " /></p>
<h4><?php _e( 'Description', 'offline-site' );?></h4>
<p><textarea name="offline_site_display[description]" style="width: 80%; max-width: 90%; height: 70px;"><?php echo $description;?></textarea></p>
<h4><?php _e( 'Key ( use to hide footer )', 'offline-site' );?></h4>
<p><input value="<?php echo $key;?>" name="offline_site_display[key]" style="width: 80%; max-width: 90%; " /></p>
<?php
if( $check == false ) :
	if( $key!='' ) :
		echo '<p style="color: red;">'. __( 'This key has expired or is incorrect. Please get another key to use.', 'offline-site' ) .'</p>';	
	endif;
?>
<p><a href="<?php echo offline_site_pbone_url('register-domain-to-get-free-key');?>" target="_blank"><?php echo __( 'Get free keys for', 'offline-site' ) . ' ' . gmdate('Y') ;?></a></p>
<?php
endif;