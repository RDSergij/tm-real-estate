<?php
/**
 * Add theme pages
 *
 * @package photolab
 */

/**
 * It's for php 5.2
 *
 * @return void
 */
// function conf_get_about_photolab() {
// 	echo View::make( 'pages/about-photolab' );
// }
return array(
	'my-page' => array(
			'title'		=> 'Theme options',
			'parent'	=> '',
			'priority'	=> 0,
			'parameters' => array(),
		),
);
