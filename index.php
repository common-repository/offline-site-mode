<?php
/*
Plugin Name: Offline Site
Plugin URI: https://wordpress.org/plugins/offline-site-mode
Description: Easily activate maintenance mode for your website. Offline site, coming soon, development site.
Author: MoiVui
Author URI: http://photoboxone.com/donate/?developer=moivui
Version: 1.0.7
License: GPL2
*/

defined('ABSPATH') or die();

function offline_site_index() 
{
	return __FILE__; 
}

require( dirname(__FILE__). '/includes/functions.php'); 

if( is_admin() ) {
	
	offline_site_include('setting.php');
	
} else {
	
	offline_site_include('site.php');
	
}