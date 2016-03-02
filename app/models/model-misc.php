<?php
/**
 * Misc model file
 *
 * @package photolab
 */

/**
 * Misc model class
 */
class Model_Misc implements I_Model {

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( '', 'misc', $key );
	}

	/**
	 * Get featured label
	 *
	 * @return string
	 */
	public static function get_featured_label() {
		return (string) self::get_option( 'featured_post_label' );
	}

	/**
	 * Get blog content
	 *
	 * @return string
	 */
	public static function get_blog_content() {
		$allowed = array( 'only_excerpt', 'full_content' );
		$content = (string) self::get_option( 'post_content_on_blog_page' );
		if ( in_array( $content, $allowed ) ) {
			return $content;
		}
		return $allowed[0];
	}

	/**
	 * Get blog image
	 *
	 * @return string
	 */
	public static function get_blog_image() {
		$blog_image = (string) self::get_option( 'featured_image_on_blog_page' );
		if ( ( Model_Sidebar_Settings::is_show_left() || Model_Sidebar_Settings::is_show_right() ) && 'default' == Model_Page_Layout_Settings::get_layout() && 'post-image' == $blog_image ) {
			return 'post-image-half';
		}
		return '' != $blog_image ? $blog_image : 'thumbnail';
	}
}
