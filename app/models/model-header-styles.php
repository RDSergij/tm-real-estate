<?php
/**
 * Header styles model file
 *
 * @package photolab
 */

/**
 * Header styles Model
 */
class Model_Header_Styles implements I_Model {
	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( 'header_settings', 'header_styles', $key );
	}

	/**
	 * Get logo URL
	 *
	 * @return string URL.
	 */
	public static function get_header_image() {
		return trim( (string) self::get_option( 'header_image' ) );
	}

	/**
	 * Image position
	 *
	 * @return string backgound-position.
	 */
	public static function get_image_position() {
		$image_position = trim( (string) self::get_option( 'image_position' ) );
		if ( '' == $image_position ) {
			$image_position = 'top left';
		}
		return $image_position;
	}

	/**
	 * Image repeat
	 *
	 * @return string backgound-repeat.
	 */
	public static function get_image_repeat() {
		$image_repeat = trim( (string) self::get_option( 'image_repeat' ) );
		if ( '' == $image_repeat ) {
			$image_repeat = 'no-repeat';
		}
		if ( self::get_background_scroll() ) {
			$image_repeat = 'no-repeat';
		}
		return $image_repeat;
	}

	/**
	 * Background scroll
	 *
	 * @return string.
	 */
	public static function get_background_scroll() {
		return (boolean) self::get_option( 'background_scroll' );
	}

	/**
	 * Background color
	 *
	 * @return string backgound-color.
	 */
	public static function get_background_color() {
		$background_color = trim( (string) self::get_option( 'background_color' ) );
		return $background_color;
	}

	/**
	 * Header layout
	 *
	 * @return string layout.
	 */
	public static function get_layout() {
		$layout = (string) self::get_option( 'header_layout' );
		if ( '' == $layout ) {
			$layout = 'default';
		}
		return $layout;
	}
}
