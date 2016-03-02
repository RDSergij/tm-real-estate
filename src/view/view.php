<?php
/**
 * Core View class file
 *
 * @package photolab
 */

/**
 * View class
 */
class View {

	const STORAGE_FOLDER = 'storage';
	const VIEWS_FOLDER   = 'views';

	/**
	 * All global data to insert in view
	 *
	 * @var array
	 */
	protected static $data = array();

	/**
	 * Add $key => $value to global data
	 *
	 * @param array $data data to add.
	 */
	public static function add_data( $data = null ) {
		if ( is_null( $data ) ) {
			return false;
		}

		if ( is_array( $data ) ) {
			self::$data = array_merge( self::$data, $data );
		}
		return count( self::$data );
	}

	/**
	 * Get storage path
	 *
	 * @return string storage folder path
	 */
	public static function get_storage_folder_path() {
		$upload_dir = wp_upload_dir();
		return sprintf(
			'%2$s%1$sapp%1$s%3$s%1$s',
			DIRECTORY_SEPARATOR,
			Utils::array_get( $upload_dir, 'basedir', '' ),
			self::STORAGE_FOLDER
		);
	}

	/**
	 * Get views path
	 *
	 * @return string views folder path
	 */
	public static function get_view_folder_path() {
		return sprintf(
			'%2$s%1$sapp%1$s%3$s%1$s',
			DIRECTORY_SEPARATOR,
			get_template_directory(),
			self::VIEWS_FOLDER
		);
	}

	/**
	 * Get view path
	 *
	 * @param type $filename file name.
	 * @return string view path
	 */
	public static function get_view_path( $filename ) {
		return sprintf(
			'%s%s.php',
			self::get_view_folder_path(),
			$filename
		);
	}

	/**
	 * Build a view instance. This is the 1st method called
	 * when defining a View.
	 *
	 * @param type  $view The view name.
	 * @param  array $__data Passed data to the view.
	 * @return string Compiled view
	 */
	public static function make( $view, $__data = array() ) {
		$__data = array_merge( self::$data, $__data );

		// If find sufix "php", than path is absolute
		if ( strpos( $view, '.php' ) ) {
			$__path = $view;
		} else {
			$__path = self::get_view_path( $view );
		}
		$scout_compiler = new Scout_Compiler( self::get_storage_folder_path() );
		if ( $scout_compiler->is_expired( $__path ) ) {
			$scout_compiler->compile( $__path );
		}
		$storage_view_path = $scout_compiler->get_compiled_path( $__path );

		return self::render_view( $storage_view_path, (array) $__data, $scout_compiler->get_compiled_content() );
	}

	/**
	 * Check view exists
	 *
	 * @return boolean true if exists | false if not
	 */
	public static function exists( $view = '' ) {
		$view_path = self::get_view_path( $view );
		return file_exists( $view_path );
	}

	/**
	 * Render view
	 *
	 * @param type  $__path storage view path.
	 * @param  array $__data include data.
	 * @return rendered html
	 */
	public static function render_view( $__path, $__data, $compiled_content = '' ) {
		ob_start();

		// Extract view datas.
		extract( $__data );
		if ( file_exists( $__path ) ) {
			// Compile the view.
			try {
				// Include the view.
				include( $__path );
			} catch ( Exception $e ) {
				echo $e;
				die();
			}
		}
		// Return the compiled view and terminate the output buffer.
		return ltrim( ob_get_clean() );
	}
}
