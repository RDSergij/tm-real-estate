<?php
/**
 * Configuration wigets engine class file
 *
 * @package photolab
 */

/**
 * Widgets class
 */
class Widgets {
	/**
	 * Widgets class constructor
	 */
	public function __construct() {
		$this->data = self::get_all_paths();
		add_action( 'widgets_init', array( $this, 'load' ) );
	}

	/**
	 * Get all paths to classes
	 *
	 * @return array
	 */
	public static function get_all_paths() {
		$pattern = sprintf(
			'%s/app/modules/widgets/*.php',
			get_template_directory()
		);
		return (array) glob( $pattern );
	}

	/**
	 * Load classes
	 */
	public function load() {
		foreach ( $this->data as $path ) {
			$class_name = $this->class_name( $path );
			if ( file_exists( $path ) ) {
				require_once( $path );

				if ( class_exists( $class_name ) ) {
					register_widget( $class_name );
				}
			}
		}
	}

	/**
	 * Get class name from path
	 *
	 * @param  [type] $path class path.
	 * @return string class name.
	 */
	public function class_name( $path ) {
		$file_name = basename( $path, '.php' );
		$class_name_elements = explode( '-', $file_name );
		foreach ( $class_name_elements as $key => &$el ) {
			$el = ucwords( $el );
		}
		return implode( '_', $class_name_elements );
	}
}
