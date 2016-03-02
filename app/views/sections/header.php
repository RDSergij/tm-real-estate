<?php
/**
 * Sections/Header view
 *
 * @package photolab
 */
?><!DOCTYPE html>
<html {{ $language_attributes }}>
<head>
<meta charset="{{ $charset }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<meta http-equiv="Cache-Control" content="max-age=3600, must-revalidate">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="{{ $ping_back_url }}">
@include( 'blocks/favicon' )
@include( 'blocks/touch_icon' )
<?php wp_head(); ?>
<!--[if lt IE 9]>
<div style=' clear: both; text-align:center; position: relative;'>
    <a href="http://windows.microsoft.com/en-US/internet-explorer/..">
        <img src="{{ $TDU }}/images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820"
             alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/>
    </a>
</div>
<script src="{{ $TDU }}/js/html5shiv.js"></script>
<![endif]-->
@include( 'blocks/style' )

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
</head>
{{ $custom_styles }}

<body class="{{ $body_class }}">
	@if ( $is_enabled_preloader )
		@include('blocks/loader')
	@endif

	<div id="site-wrapper" class="site">

		<!--if(has_nav_menu('top'))-->
			@include('blocks/top-menu')
		<!--endif-->

		<header id="header" class="site-header wide">
			@include('layouts/'.$header_layout_view)	
		</header>
		
		@if ( is_home() || is_front_page() )
			<div class="sidebar-container full-width-sidebar">
				{{ Model_Sidebar_Settings::widget_area( 'full_width' ) }}
			</div>
		@endif
