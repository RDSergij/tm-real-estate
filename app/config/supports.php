<?php
/**
 * Install all supports
 *
 * @package photolab
 */

return array(
	'title-tag',
	'automatic-feed-links',
	'excerpt',
	// Enable support for Post Formats
	'post-formats' => array( 'aside', 'image', 'gallery', 'video', 'quote', 'link', 'audio' ),
	// Setup the WordPress core custom background feature.
	'custom-background' => apply_filters(
		'photolab_custom_background_args',
		array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)
	),
	// Enable support for HTML5 markup.
	'html5' => array(
		'comment-list',
		'search-form',
		'comment-form',
		'gallery',
		'caption',
	),

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	'post-thumbnails',

	/**
	 * Jetpack
	 */
	'infinite-scroll' => array(
		'container' => 'main',
		'footer'    => 'page',
	),

	/**
	 * Custom header setup
	 */
	'custom-header' => array(
		'default-image'          => Utils::assets_url() . '/images/header.jpg',
		'random-default'         => false,
		'width'                  => 1920,
		'height'                 => 585,
		'flex-height'            => true,
		'flex-width'             => true,
		'header-text'            => false,
		'uploads'                => true,
		'wp-head-callback'       => '',
		'admin-head-callback'    => array( 'Custom_Header', 'style' ),
		'admin-preview-callback' => array( 'Custom_Header', 'image' ),
	),
);
