<?php
/**
 * Configuration engine class file
 *
 * @package photolab
 */

/**
 * Configuration class
 */
class Configuration {

	/**
	 * Load all configurations
	 */
	public static function load() {
		$allowed_classes = self::get_allowed_config_classes();
		foreach ( $allowed_classes as $class_name ) {
			$path  = self::get_class_path( $class_name );

			if ( file_exists( $path ) ) {
				new $class_name( include( $path ) );
			} else {
				new $class_name();
			}
		}
	}

	/**
	 * Get all allowed config classes
	 *
	 * @return array all allowed config classes
	 */
	public static function get_allowed_config_classes() {
		return array(
			'Models',
			'Images',
			'Menus',
			'Sidebars',
			'Supports',
			'Widgets',
			'Pages',
			'Customs',
			'Options',
			'Assets',
		);
	}

	/**
	 * Make class path from class name
	 *
	 * @param type $class_name class name.
	 * @return string class path
	 */
	public static function get_class_path( $class_name ) {
		return sprintf(
			'%sapp/config/%s.php',
			TM_REAL_ESTATE_PATH,
			strtolower( $class_name )
		);
	}
}
