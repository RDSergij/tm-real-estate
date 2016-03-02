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
 * Autoload all classes
 */
define( 'TM_REAL_ESTATE_PATH', plugin_dir_path( __FILE__ ) );
require_once 'src/autoload.php';
new Autoload(
	array(
		'ui',
		'configuration',
		'core',
	)
);
Configuration::load();