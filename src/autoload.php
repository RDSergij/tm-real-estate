<?php
/**
 * Core Autoload class file
 *
 * @package photolab
 */

/**
 * Autoload class
 */
class Autoload {
	/**
	 * Index of classes
	 *
	 * @var array
	 */
	private static $classes = array();

	/**
	 * Autoload class constructor
	 *
	 * @param array $folders autoload folders list.
	 */
	public function __construct( $folders = array() ) {
		self::$classes = self::get_all_classes_paths( $folders );
		spl_autoload_register( array( __CLASS__, 'autoload' ) );
	}

	/**
	 * Autoload my classes
	 *
	 * @return void
	 */
	public static function autoload( $class ) {
		$class = strtolower( $class );
		$class = str_replace( '_', '-', $class );
		if ( array_key_exists( $class, self::$classes ) ) {
			require self::$classes[ $class ];
		}
	}

	/**
	 * Get all classes paths
	 *
	 * @return array
	 */
	public static function get_all_classes_paths( $folders ) {
		$result = array();
		$paths  = self::get_all_paths( $folders );

		if ( count( $paths ) ) {
			foreach ( $paths as $file ) {
				$class = substr( basename( $file ), 0, -4 );
				$result[ $class ] = $file;
			}
		}
		return $result;
	}

	/**
	 * Get all paths to classes
	 *
	 * @param  [type] $folders folders list.
	 * @return array
	 */
	public static function get_all_paths( $folders ) {
		$paths  = array();
		if ( is_array( $folders ) && count( $folders ) ) {
			foreach ( $folders as $folder ) {
				$pattern = sprintf(
					'%s/src/%s/*.php',
					get_template_directory(),
					$folder
				);
				$paths = array_merge( $paths, (array) glob( $pattern ) );
			}
		}
		return $paths;
	}
}
