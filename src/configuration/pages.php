<?php
/**
 * Configuration pages engine class file
 *
 * @package photolab
 */

/**
 * Page class
 */
class Pages {

	/**
	 * The image sizes.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Widgets class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		add_action( 'admin_menu', array( $this, 'load' ) );
	}

	/**
	 * Load classes
	 */
	public function load() {
		foreach ( $this->data as $class => $properties ) {
			$class_name = $class;
			$path = $this->path( $class );

			if ( file_exists( $path ) ) {
				require_once( $path );
			}

			if ( 5 == count( $properties ) && is_array( $properties ) ) {
				list( $page_title, $menu_title, $capability, $menu_slug, $function ) = $properties;
				add_theme_page( $page_title, $menu_title, $capability, $menu_slug, $function );
			}
		}
	}

	/**
	 * Get class path
	 *
	 * @param type $class class name.
	 * @return string widget path
	 */
	public function path( $class ) {
		return sprintf(
			'%s%s.php',
			Utils::pages_path(),
			strtolower( $class )
		);
	}
}
