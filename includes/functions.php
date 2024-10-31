<?php
defined('ABSPATH') or die();

function offline_site_url( $path = '' )
{
	return plugins_url( $path, offline_site_index());
}

function offline_site_assets_url( $path = '' )
{
	return offline_site_url( '/media/'.$path );
}

function offline_site_themes_url( $path = '' )
{
	return offline_site_url( '/themes/'.$path );
}

function offline_site_ver()
{
	// since '2018.12.24.10.20';
	return '2021.06.14.08.50';
}

function offline_site_path( $path = '' )
{
	return dirname(offline_site_index()) . ( substr($path,0,1) !== '/' ? '/' : '' ) . $path;
}

function offline_site_include( $path_file = '' )
{
	if( $path_file!='' && file_exists( $p = offline_site_path('includes/'.$path_file ) ) ) {
		require $p;
		return true;
	}
	return false;
}

function offline_site_pbone_url( $path = '', $demo = false )
{
	$site = 'http://'.( $demo ? 'demo.' : '' ).'photoboxone.com/';

	$utm = 'utm_term=offline-site&utm_medium=offline-site&utm_source=' . urlencode( $_SERVER['HTTP_HOST'] );

	if( strpos( $path, '?' ) > -1 ) {
		$path .= '&';
	} else {
		$path .= '?';
	}
	
	return $site . $path . $utm;
}

// Offline Site options [default]
function offline_site_options( $key = '' )
{	
	$options = shortcode_atts(array(
		'enable' 	=> 'no',
		'theme'		=> 'default',
	), (array)get_option('offline_site_display'));
	
	if( $key!='' && isset($options[$key]) ) {
		return $options[$key];
	}

	return $options;
}

function offline_site_update_option( $key = '', $value = '' )
{
	$options = offline_site_options();

	if( $key!='' && isset($options[$key]) ) {
		$options[$key] = $value;
		update_option( 'offline_site_options', $options );
	}
	
}

function offline_site_check_key( $key = '' )
{
	if( empty($key) || $key == '' ) return false;

	$h = strtolower( $_SERVER['HTTP_HOST'] );

	$y = gmdate('Y');

	$a = strtoupper( $h ) . '-' . ( $y - 1 ). '+before';

	$b = $h .'='. $y . '-here';

	$c = ucwords( $h ) . '+' . ( $y + 1 ). '=after';

	$t = md5( $a ) . md5( $b ) . md5( $c );

	$n = strlen($t);

	$p = intval($n/2);

	$t = substr($t,0,$p).':'.substr($t,$p,$n);

	if( $key ==  $t ) {
		return true;
	}

	return false;
}