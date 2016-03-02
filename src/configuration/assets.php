<?php
/**
 * Configuration Assets engine class file
 *
 * @package photolab
 */

/**
 * Assets class
 */
class Assets {
	/**
	 * Save the menus list
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Assets class constructor
	 *
	 * @param array $data assets data.
	 */
	public function __construct( array $data ) {
		$this->data = Utils::array_leave_right_keys(
			$this->get_allowed_keys(),
			$data
		);
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	}

	/**
	 * Get allowed keys to assets config
	 *
	 * @return array
	 */
	public function get_allowed_keys() {
		return array( 'scripts', 'styles', 'localize', 'custom' );
	}

	/**
	 * Run by wp_enqueue_scripts action
	 * Enqueue scripts and styles
	 *
	 * @return void
	 */
	public function enqueue() {
		if ( is_array( $this->data ) && count( $this->data ) ) {
			foreach ( $this->data as $func => $data ) {
				$this->$func( $data );
			}
		}
	}

	/**
	 * Enqueue scripts
	 *
	 * @param  array $scripts parameters.
	 * @return void
	 */
	public function scripts( $scripts ) {
		$defaults = array( '', false, array(), false, false );
		if ( is_array( $scripts ) && count( $scripts ) ) {
			foreach ( $scripts as $script ) {
				list( $handle, $src, $deps, $ver, $in_footer ) = array_merge( $script, $defaults );
				wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer );
			}
		}
	}

	/**
	 * Enqueue styles
	 *
	 * @param  array $styles parameters.
	 * @return void
	 */
	public function styles( $styles ) {
		$defaults = array( '', false, array(), false, 'all' );
		if ( is_array( $styles ) && count( $styles ) ) {
			foreach ( $styles as $style ) {
				list( $handle, $src, $deps, $ver, $media ) = array_merge( $style, $defaults );
				wp_enqueue_style( $handle, $src, $deps, $ver, $media );
			}
		}
	}

	/**
	 * Localize scripts
	 *
	 * @param  array $localizes parameters.
	 * @return void
	 */
	public function localize( $localizes ) {
		if ( is_array( $localizes ) && count( $localizes ) ) {
			foreach ( $localizes as $localize ) {
				if ( is_array( $localize ) && 3 == count( $localize ) ) {
					list( $handle, $object_name, $l10n ) = $localize;
					wp_localize_script( $handle, $object_name, $l10n );
				}
			}
		}
	}

	/**
	 * Run custom functions in wp_enqueue_scripts action
	 *
	 * @param array $functions custom function.
	 * @return void
	 */
	public function custom( $functions ) {
		if ( is_array( $functions ) && count( $functions ) ) {
			foreach ( $functions as $f ) {
				if ( is_callable( $f ) ) {
					$f();
				}
			}
		}
	}
}
