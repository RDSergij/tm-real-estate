<?php
/**
 * Configuration sidebars engine class file
 *
 * @package photolab
 */

/**
 * Sidebars class
 */
class Sidebars {
	/**
	 * Save list of sidebars
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Sidebars class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		add_action( 'init', array( $this, 'install' ) );
	}

	/**
	 * Run by the 'init' hook.
	 * Execute the "register_sidebar" function from WordPress.
	 *
	 * @return void
	 */
	public function install() {
		if ( is_array( $this->data ) && ! empty( $this->data ) ) {
			foreach ( $this->data as $sidebar ) {
				register_sidebar( $sidebar );
			}
		}
	}
}
