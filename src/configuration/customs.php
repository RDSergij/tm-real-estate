<?php
/**
 * Configuration customs engine class file
 *
 * @package photolab
 */

/**
 * Customs class
 */
class Customs {
	/**
	 * Customs class constructor
	 */
	public function __construct() {
		$paths = self::get_all_paths();
		if ( count( $paths ) ) {
			foreach ( $paths as $path ) {
				if ( file_exists( $path ) ) {
					require_once( $path );
				}
			}
		}
	}

	/**
	 * Get all paths to classes
	 *
	 * @return array
	 */
	public static function get_all_paths() {
		$pattern = sprintf(
			'%s/app/modules/custom/*.php',
			get_template_directory()
		);
		return (array) glob( $pattern );
	}
}
