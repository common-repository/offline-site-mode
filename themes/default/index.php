<?php
extract(shortcode_atts(array(
	'background_id'	=> 0,
	'title'	=> 'Coming soon - Sitename',
	'description'	=> 'Tagline or description',
	'key' => '',
), (array)get_option('offline_site_display')));

$class = '';
if( offline_site_check_key($key) ) {
	$class = ' hide';
}

?><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title><?php echo $title;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" />
<style type="text/css">
/*<![CDATA[*/
	* {
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
		margin: 0;
		padding: 0;
	}
	.clearfix::after{
		display: block;
		content: '';
		clear: both;
		height: 0px;
	}			
	body {
		background: rgba(255,255,255,.6)<?php echo ($background_id>0?" url('".wp_get_attachment_image_url($background_id,'full')."') center center no-repeat; background-size: 100% auto; background-size: cover; ":'');?>;
		color: #000;
		font-size: 0.9em;
		font-family: sans-serif, helvetica;
		margin: 0;
		padding: 0;
		font-size: 14px;
	}
	a{
		text-decoration: none;
		color: #fff;
	}
	h1 {
		margin: 0;
		padding: 0 0 50px;
		color: #f00;
		font-weight: normal;
		font-size: 20px;
	}
	h1 strong {
		font-weight: bold;
	}
	.offline-site{
		text-align: center;
		padding: 30px 20px 10px;
		width: 100%;
		height: 240px;
		max-height: 100%;
		max-width: 560px;
		position: absolute;
		background: #fff;
		background: rgba(255,255,255,.6);
		left: 0;
		right: 0;
		top: 50%;
		transform: translateY(-50%);
		margin: auto;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		-webkit-box-shadow: 0px 1px 5px #999;
		box-shadow: 0px 1px 5px #999;
		line-height: 20px;
	}
	.blogauthor{
		position: absolute;
		bottom: 20px;
		left: 0;
		width: 100%;
		text-align: center;
	}
	.hide{
		display: none !important;
	}
	@media screen and (max-width: 480px)
	{
		.offline-site{
			top: 50%;
			width: calc( 100% - 20px );
			height: auto;
			transform: translateY(-50%);
		}
	}
	/*]]>*/
</style>
</head>
<body>
	<div class="offline-site clearfix">
		<h1><strong><?php echo $title;?></strong></h1>
		<div class="blogdescription"><?php echo $description;?></div>
	</div>
	<div class="blogauthor">
		<a href="<?php echo home_url();?>"><?php bloginfo('name');?></a>
		<span class="<?php echo $class;?>">
			-
			<?php __('Development by', 'Offline Site');?> <a href="http://moivui.com/" target="_blank">MoiVui</a>
		</span>
	</div>
</body>
</html>