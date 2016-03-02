<?php
/**
 * Load all assets
 *
 * @package photolab
 */

$assets = array(
	'scripts' => array(
		array( 'jquery' ),
		array( 'masonry', Utils::assets_url() . 'js/masonry.min.js', array( 'jquery' ), '1.0.0', true ),
	),
	'styles' => array(
		array( 'superfish-css', Utils::assets_url(). 'css/superfish.css', array() ),
	),
	'localize' => array(
		array(
			'photolab-layout-ie',
			'conditional',
			'lte IE 8',
		),
	),
);

return $assets;
