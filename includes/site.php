<?php

defined('ABSPATH') or die();

function offline_box_setup()
{
	if( preg_match('/wp-login|wp-admin/i', $_SERVER['REQUEST_URI']) == false ){
		// var_export($_SERVER);
		
		$options = offline_site_options();
		extract($options);

		$file 		= offline_site_path( 'themes/'.$theme.'/index.php' );
		
		$theme_url 	= offline_site_themes_url( $theme.'/' );
		
		$current_user = wp_get_current_user();
		if( $enable == 'yesforguest' ){
			// Yes for Guest
			if( empty($current_user) || intval($current_user->ID) == 0 ){
				$enable = 'yes';
			}
		} else if( $enable == 'yesbutnotadmin' ){
			// Yes for all but exclude Admin
			if ( empty( $current_user->roles ) || !is_array( $current_user->roles ) || !in_array( 'administrator', $current_user->roles ) ) {
				$enable = 'yes';
			}
		}

		if( $enable == 'yes' ){
			
			if( file_exists( $file ) ){
				include $file;				
			} else {
				_e( 'Not Theme !!! Please choose a theme in the Offline Site plugin now.', 'offline-site' );
			}
			
			die();
		}
	}
}
add_action( 'after_setup_theme', 'offline_box_setup' );