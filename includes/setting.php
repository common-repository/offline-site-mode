<?php

defined('ABSPATH') or die();

$pagenow 	= sanitize_text_field( isset($GLOBALS['pagenow'])?$GLOBALS['pagenow']:'' );
if( $pagenow == 'plugins.php' ){
	
	function offline_site_plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
		$url_setting = admin_url('options-general.php?page=offline-site-setting');
		
		array_unshift($actions, '<a href="http://photoboxone.com/donate?plugin=offline-site" target="_blank">'.__("Donate" , 'offline-site')."</a>");
		array_unshift($actions, '<a href="'.offline_site_pbone_url('contact').'" target="_blank">'.__("Support" , 'offline-site')."</a>");
		array_unshift($actions, "<a href=\"$url_setting\">".__("Settings")."</a>");

		return $actions;
	}
	
	add_filter("plugin_action_links_".plugin_basename(offline_site_index()), "offline_site_plugin_actions", 10, 4);
}

/* ADD SETTINGS PAGE
------------------------------------------------------*/
function offline_site_add_options_page() {
	add_options_page(
		'Offline Site Settings',
		'Offline Site',
		'manage_options',
		'offline-site-setting',
		'offline_site_setting_display'
	);
}
add_action('admin_menu','offline_site_add_options_page');

/* SECTIONS - FIELDS
------------------------------------------------------*/
function offline_site_init_theme_option() {
	$pagenow = isset($GLOBALS['pagenow'])?$GLOBALS['pagenow']:'';

	// 
	add_settings_section(
		'offline_site_display_section',
		'Display Options',		
		'offline_site_display_section_display',
		'offline_box-display-section'
	);

	register_setting( 'offline_site_settings','offline_site_display');
	wp_enqueue_style( 'offline-site-style-admin', offline_site_assets_url('admin.css') );
	
	if( $pagenow == 'options-general.php' ) {
		wp_enqueue_media();
		wp_enqueue_script('offline-site-upload', offline_site_assets_url('admin.js'), array('jquery'), '1.0', true);
	}
}
add_action('admin_init', 'offline_site_init_theme_option');

/* CALLBACK
------------------------------------------------------*/
function offline_site_setting_display(){
	
	$options = offline_site_options();
	extract($options);

	$file_setting 		= offline_site_path( 'themes/'.$theme.'/setting.php' );
?>	
	<h2><?php _e( 'Offline Site', 'offline-site' );?></h2>
	<div class="wrap offline_site_settings clearfix">
		<?php // offline_site_links(); ?>
		<div class="offline_site_advanced clearfix">
			<h3><?php _e( 'Settings', 'offline-site' );?></h3>
			<form action="options.php" method="post">
				<?php
					settings_fields( 'offline_site_settings' );
					// submit_button();
				?>
				<h4><?php _e( 'Enable Offline Box', 'offline-site' );?></h4>
				<p>
					<select name="offline_site_display[enable]" id="offline_site_display_enable">
						<option value="yesbutnotadmin" <?php echo $enable=='yesbutnotadmin'?'selected':'';?> ><?php _e( 'Yes for all but exclude Admin', 'offline-site' );?></option>
						<option value="yesforguest" <?php echo $enable=='yesforguest'?'selected':'';?> > <?php _e( 'Yes for Guest', 'offline-site' );?></option>
						<option value="yes" <?php echo $enable=='yes'?'selected':'';?> ><?php _e( 'Yes for All', 'offline-site' );?></option>
						<option value="no" <?php echo $enable=='no'?'selected':'';?> ><?php _e( 'No', 'offline-site' );?></option>
					</select>
				</p>
				<?php 
					// if( function_exists('offline_site_theme_settings') ) offline_site_theme_settings(); 
					if( file_exists($file_setting) )
						include $file_setting;
					
					submit_button(); 					
				?>
			</form>
		</div>
		<div class="offline_site_sidebar clearfix">
			<?php offline_site_links(); ?>
			<?php offline_site_recommend_kite(); ?>
			<?php offline_site_donate_text(); ?>			
		</div>
	</div>
<?php
}

function offline_site_links(){
?>
	<div class="offline_site_sidebar_box clearfix">
		<h4><?php _e( 'Do you need help?', 'offline-site' ); ?></h4>
		<ol>
			<li>
				<a href="<?php echo offline_site_pbone_url('offline-kite-box');?>" target="_blank" rel="help">
					<?php _e( 'Help', 'offline-site' ); ?>
				</a>
			</li>
			<li>
				<a href="<?php echo offline_site_pbone_url('contact');?>" target="_blank" rel="help">			
					<?php _e( 'Support', 'offline-site' ); ?>
				</a>
			</li>
			<li>
				<a href="<?php echo offline_site_pbone_url();?>" target="_blank" rel="author">
					<?php _e( 'About', 'offline-site' ); ?>
				</a>
			</li>
		</ol>
	</div>
<?php
}

function offline_site_recommend_kite(){
?>
	<div class="offline_site_sidebar_box">
		<h4><?php _e( 'The Offline Kite Box plugin', 'offline-site' );?></h4>
		<ol>
			<li><?php _e( 'Custom Color schemes', 'offline-site' );?></li>
			<li><?php _e( 'Custom Background', 'offline-site' );?></li>
			<li><?php _e( 'W3C validate HTML & CSS', 'offline-site' );?></li>
			<li><?php _e( 'Countdown', 'offline-site' );?></li>
			<li><?php _e( 'Full screen', 'offline-site' );?></li>
			<li><?php _e( 'Cross Browser', 'offline-site' );?></li>
			<li><?php _e( 'Built with Bootstrap v3.1.1', 'offline-site' );?></li>
			<li><?php _e( 'Font Awesome', 'offline-site' );?></li>
		</ol>
		<p align=center>
			<a target="_blank" href="<?php echo offline_site_pbone_url('offline-kite-box', $demo = true );?>" class="button button-secondary" rel="support">
				<?php _e( 'View Demo', 'offline-site' );?>
			</a>
			-
			<a target="_blank" href="<?php echo offline_site_pbone_url('offline-kite-box');?>" class="button button-primary" rel="support">
				<?php _e( 'Download Now', 'offline-site' );?>
			</a>
		</p>
	</div>
<?php
}

function offline_site_donate_text()
{
?>
	<div class="offline_site_sidebar_box">
		<h4>
			<?php _e( 'You can donate to us by visiting our website. Thank you for watching.', 'offline-site' ); ?>
		</h4>
		<p>
			<div class="offlinesite-icon-click">
				<div class="dashicons dashicons-arrow-right-alt"></div>
			</div>
			<a href="<?php echo offline_site_pbone_url('offline-kite-box?donate=offline-site');?>" target="_blank" rel="help">
				<?php _e( 'Visiting our website', 'offline-site' ); ?>
			</a>
		</p>
		<p>
			<?php _e( 'You can donate by PayPal.', 'offline-site' ); ?>
		</p>
		<p align=center>
			<a href="<?php echo offline_site_pbone_url('donate');?>" target="_blank" rel="help" class="button button-primary">	
				<?php _e( 'Donate', 'offline-site' ); ?>
			</a>
		</p>
		<p>
			<?php _e( 'Thank you for using Offline Site.', 'offline-site' ); ?>
		</p>
	</div>
<?php
}