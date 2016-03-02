<?php
/**
 * Core Utils class file
 *
 * @package photolab
 */

/**
 * Abstract Compiler class
 */
abstract class Compiler {

	/**
	 * View storage path.
	 *
	 * @var string
	 */
	protected $storage;

	/**
	 * Define children compiler constructor.
	 *
	 * @param type $storage storage.
	 */
	public function __construct( $storage = null ) {
		$this->storage = $storage;
	}

	/**
	 * Check if a compiled view is expired or not.
	 *
	 * @param type $path storage path is expired.
	 * @return bool
	 */
	public function is_expired( $path ) {
		$compiled = $this->get_compiled_path( $path );

		// If the compiled view doesn't exists, return.
		if ( ! $this->storage || ! file_exists( $compiled ) || WP_DEBUG ) {
			return true;
		}

		// If the view code has changed, mark it as expired.
		$last_modified = filemtime( $path );

		return $last_modified >= filemtime( $compiled );
	}

	/**
	 * Return the compiled view path.
	 *
	 * @param type $path The original view path.
	 * @return string
	 */
	public function get_compiled_path( $path ) {
		return $this->storage.md5( $path );
	}
}
