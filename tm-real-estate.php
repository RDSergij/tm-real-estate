<?php
/**
 * Plugin Name: TM Real Estate
 * Description: 
 * Version: 1.0
 * Author: Guriev Eugen and Serghij Osadchij
 * Author URI: http://www.templatemonster.com/
 * License: GPLv2 or later
 * Text Domain: akismet
 */

/**
 * Plugin path
 */
define( 'TM_REAL_ESTATE_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin text domain
 */
define( 'TM_TEXT_DOMAIN', 'tm-real-estate' );

/**
 * Autoload all classes
 */
require_once 'src/autoload.php';
new Autoload(
	array(
		'ui',
		'configuration',
		'core',
		'field',
		'field/fields',
	)
);
Configuration::load();