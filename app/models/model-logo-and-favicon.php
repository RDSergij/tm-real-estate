<?php
/**
 * General Site settings model
 *
 * @package photolab
 */

/**
 * Logo & Favicon MODEL
 */
class Model_Logo_And_Favicon implements I_Model {
	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( 'general_site_settings', 'logo_and_favicon', $key );
	}

	/**
	 * Get logo URL
	 *
	 * @return string URL.
	 */
	public static function get_logo() {
		return trim( (string) self::get_option( 'logo' ) );
	}

	/**
	 * Get favicon image id
	 *
	 * @return integer id.
	 */
	public static function get_favicon_id() {
		return (int) Utils::attachment_id_from_url( self::get_option( 'favicon' ) );
		return wp_get_attachment_image_src(
			Utils::attachment_id_from_url( self::get_option( 'favicon' ) ),
			'favicon'
		);
	}

	/**
	 * Get favicon URL
	 *
	 * @return string URL.
	 */
	public static function get_favicon() {
		$obj = wp_get_attachment_image_src( self::get_favicon_id(), 'favicon' );
		if ( $obj ) {
			return $obj[0];
		}
		if ( file_exists( get_template_directory() . '/favicon.ico' ) ) {
			return get_template_directory_uri() . '/favicon.ico';
		}
		return '';
	}

	/**
	 * Get touch icon URL
	 *
	 * @return string URL.
	 */
	public static function get_touch_icon() {
		$obj = wp_get_attachment_image_src( self::get_favicon_id(), 'touch-icon' );
		if ( $obj ) {
			return $obj[0];
		}
		return '';
	}

	/**
	 * Is enable retina optimisation ?????
	 *
	 * @return boolean Enable / Disable.
	 */
	public static function is_enable_retina() {
		return (boolean) self::get_option( 'enable_retina' );
	}

	/**
	 * Is enable page preloader ?
	 *
	 * @return boolean Enable / Disable.
	 */
	public static function is_enable_page_preloader() {
		return (boolean) self::get_option( 'show_preloader' );
	}
}
