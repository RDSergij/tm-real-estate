<?php
/**
 * Configuration Supports engine class file
 *
 * @package photolab
 */

/**
 * Supports class
 */
class Supports {
	/**
	 * List of theme supports
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Supports class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		add_action( 'init', array( $this, 'install' ) );
	}

	/**
	 * Run by the 'init' hook.
	 * Execute the "add_theme_support" function from WordPress.
	 *
	 * @return void
	 */
	public function install() {
		if ( is_array( $this->data ) && ! empty( $this->data ) ) {
			foreach ( $this->data as $feature => $value ) {
				// Allow theme features without options.
				if ( is_int( $feature ) ) {
					add_theme_support( $value );
				} else {
					// Theme features with options.
					add_theme_support( $feature, $value );
				}
			}
		}
	}
}
