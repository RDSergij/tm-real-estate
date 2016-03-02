<?php
/**
 * Configuration manus engine class file
 *
 * @package photolab
 */

/**
 * Manus class
 */
class Menus {
	/**
	 * Save the menus list
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Menus class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		add_action( 'init', array( $this, 'install' ) );
	}

	/**
	 * Run by the 'init' hook.
	 * Execute the "register_nav_menus" function from WordPress
	 *
	 * @return void
	 */
	public function install() {
		if ( is_array( $this->data ) && ! empty( $this->data ) ) {
			$locations = array();

			foreach ( $this->data as $slug => $desc ) {
				$locations[ $slug ] = $desc;
			}

			register_nav_menus( $locations );
		}
	}
}
