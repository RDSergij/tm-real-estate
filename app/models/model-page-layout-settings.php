<?php
/**
 * Blog setting model
 *
 * @package photolab
 */

/**
 * Blog settings model class
 */
class Model_Page_Layout_Settings implements I_Model {

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( 'general_site_settings', 'page_layout_settings', $key );
	}

	/**
	 * Layout style
	 *
	 * @return string Boxed, full width etc.
	 */
	public static function get_layout() {
		$layout = self::get_option( 'layout' );
		if ( empty( $layout ) ) {
			$layout = 'boxed';
		}
		return $layout;
	}

	/**
	 * Container width
	 *
	 * @return string Width of container.
	 */
	public static function get_width() {
		$width = self::get_option( 'width' );
		if ( is_numeric( $width ) ) {
			$width.= 'px';
		}
		return $width;
	}

	/**
	 * Sidebar width
	 *
	 * @return string Width of sidebar.
	 */
	public static function get_sidebar_width() {
		$sidebar_width = self::get_option( 'sidebar_width' );
		if ( empty( $sidebar_width ) ) {
			$sidebar_width = '1__3';
		}
		return $sidebar_width;
	}
}
