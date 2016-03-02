<?php
/**
 * Load all assets
 *
 * @package photolab
 */

/**
 * Enqueue comment reply
 */
function conf_enqueue_comment_reply() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
$assets = array(
	'scripts' => array(
		array( 'jquery' ),
		array( 'superfish', Utils::assets_url() . 'js/superfish.js', array( 'jquery' ), '1.7.4', true ),
		array( 'magnific-popup', Utils::assets_url() . 'js/magnific-popup.min.js', array( 'jquery' ), '1.0.0', true ),
		array( 'stickymenu', Utils::assets_url() . 'js/stickymenu.min.js', array( 'jquery' ), '1.0.0', true ),
		array( 'app', Utils::assets_url() . 'js/app.min.js', array( 'jquery', 'stickymenu' ), '1.0.0', true ),
		array( 'magnific-popup', Utils::assets_url() . 'js/jquery.magnific-popup.min.js', array( 'jquery' ), '1.0.0', true ),
		array( 'masonry', Utils::assets_url() . 'js/masonry.min.js', array( 'jquery' ), '1.0.0', true ),
	),
	'styles' => array(
		array( 'photolab-fonts', Model_Main::fonts_url(), array(), null ),
		array( 'photolab-style', get_stylesheet_uri(), array(), '1.1.0' ),
		array( 'photolab-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), '4.5.0' ),
		array( 'material-icons', Utils::assets_url(). 'css/material-icons.css', array() ),
		array( 'magnific-popup', Utils::assets_url(). 'css/magnific-popup.css', array()  ),
		array( 'superfish-css', Utils::assets_url(). 'css/superfish.css', array() ),
	),
	'localize' => array(
		array(
			'app',
			'app',
			array( 'stickymenu' => Model_Main_Menu_Settings::get_sticky_menu() ),
		),
		array(
			'photolab-layout-ie',
			'conditional',
			'lte IE 8',
		),
	),
	'custom' => array( 'conf_enqueue_comment_reply' ),
);

$assets['styles'] = array_merge( $assets['styles'], Model_Typography_Settings::get_google_font_assets_list() );

return $assets;
