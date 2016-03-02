<?php
/**
 * Breadcrumbs model
 *
 * @package photolab
 */

/**
 * Breadcrumbs Model
 */
class Model_Breadcrumbs implements I_Model {
	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option('general_site_settings', 'breadcrumbs', $key );
	}

	/**
	 * Is show page title in breadcrumbs?
	 *
	 * @return boolean Show / Hide.
	 */
	public static function is_show_page_title() {
		return (boolean) self::get_option( 'show_page_title' );
	}

	/**
	 * Is show breadcrubs?
	 *
	 * @return boolean Show / Hide.
	 */
	public static function is_show_breadcrubs() {
		return (boolean) self::get_option( 'show_breadcrubs' );
	}

	/**
	 * Is show full or minifide?
	 *
	 * @return boolean Full / Minifide.
	 */
	public static function is_full_minifide() {
		return (boolean) self::get_option( 'full_minifide' );
	}

	/**
	 * Breadcrumbs HTLM block
	 *
	 * @return string
	 */
	public static function breadcrumbs() {
		if ( ! self::is_show_breadcrubs() ) {
			return '';
		}
		$items = Model_Breadcrumb_Trail::get_items();

		if ( ! self::is_full_minifide() && count( $items ) > 2 ) {
			// Minifide version
			$items = array(
				array_shift( $items ),
				array_pop( $items ),
			);
		}
		$last  = array_pop( $items );
		
		return View::make(
			'blocks/breadcrumbs',
			array(
				'items'         => $items,
				'last'          => $last,
				'is_show_title' => self::is_show_page_title(),
			)
		);
	}
}
