<?php
/**
 * Blog setting model
 *
 * @package photolab
 */

/**
 * Color scheme invert settings model class
 */
class Model_Color_Scheme_Invert implements I_Model {

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( 'color_scheme', 'invert', $key );
	}

	/**
	 * Get all colors
	 *
	 * @return string Hex color code.
	 */
	public static function get_color_scheme() {
		return array(
			'accent1'		=> self::get_accent1(),
			'accent2'		=> self::get_accent2(),
			'accent3'		=> self::get_accent3(),
			'text'			=> self::get_text(),
			'link_hover'	=> self::get_link_hover(),
			'heading1'		=> self::get_heading1(),
			'heading2'		=> self::get_heading2(),
			'heading3'		=> self::get_heading3(),
			'heading4'		=> self::get_heading4(),
			'heading5'		=> self::get_heading5(),
			'heading6'		=> self::get_heading6(),
		);
	}

	/**
	 * Accent color
	 *
	 * @return string Hex color code.
	 */
	public static function get_accent1() {
		return self::get_option( 'accent1' );
	}

	/**
	 * Accent color
	 *
	 * @return string Hex color code.
	 */
	public static function get_accent2() {
		return self::get_option( 'accent2' );
	}

	/**
	 * Accent color
	 *
	 * @return string Hex color code.
	 */
	public static function get_accent3() {
		return self::get_option( 'accent3' );
	}

	/**
	 * Text color
	 *
	 * @return string Hex color code.
	 */
	public static function get_text() {
		return self::get_option( 'text' );
	}

	/**
	 * Link hover color
	 *
	 * @return string Hex color code.
	 */
	public static function get_link_hover() {
		return self::get_option( 'link_hover' );
	}

	/**
	 * Heading color
	 *
	 * @return string Hex color code.
	 */
	public static function get_heading1() {
		return self::get_option( 'heading1' );
	}

	/**
	 * Heading color
	 *
	 * @return string Hex color code.
	 */
	public static function get_heading2() {
		return self::get_option( 'heading2' );
	}

	/**
	 * Heading color
	 *
	 * @return string Hex color code.
	 */
	public static function get_heading3() {
		return self::get_option( 'heading3' );
	}

	/**
	 * Heading color
	 *
	 * @return string Hex color code.
	 */
	public static function get_heading4() {
		return self::get_option( 'heading4' );
	}

	/**
	 * Heading color
	 *
	 * @return string Hex color code.
	 */
	public static function get_heading5() {
		return self::get_option( 'heading5' );
	}

	/**
	 * Heading color
	 *
	 * @return string Hex color code.
	 */
	public static function get_heading6() {
		return self::get_option( 'heading6' );
	}
}
