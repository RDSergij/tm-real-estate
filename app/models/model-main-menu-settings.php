<?php
/**
 * Main menu settings model file
 *
 * @package photolab
 */

/**
 * Main menu settings Model
 */
class Model_Main_Menu_Settings implements I_Model {
	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( 'header_settings', 'main_menu_settings', $key );
	}

	/**
	 * Sticky menu
	 *
	 * @return string.
	 */
	public static function get_sticky_menu() {
		if ( wp_is_mobile() ) {
			return false;
		}
		return (boolean) self::get_option( 'on_off_sticky_menu' );
	}

	/**
	 * Title attributes
	 *
	 * @return string.
	 */
	public static function get_title_attributes() {
		return (boolean) self::get_option( 'on_off_title_attribute' );
	}
}
