<?php
/**
 * Top panel settings model file
 *
 * @package photolab
 */

/**
 * Top panel settings Model
 */
class Model_Top_Panel_Settings implements I_Model {
	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( 'header_settings', 'top_panel_settings', $key );
	}

	/**
	 * Background color
	 *
	 * @return string backgound-color.
	 */
	public static function get_background_color() {
		$background_color = trim( (string) self::get_option( 'background_color' ) );
		if ( '' == $background_color ) {
			$background_color = '#fff';
		}
		return $background_color;
	}

	/**
	 * Show search
	 *
	 * @return string.
	 */
	public static function is_show_search() {
		return (boolean) self::get_option( 'show_search' );
	}

	/**
	 * Disclaimer text
	 *
	 * @return string text.
	 */
	public static function get_disclimer_text() {
		return (string) self::get_option( 'disclaimer_text' );
	}
}
