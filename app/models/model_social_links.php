<?php
/**
 * General Site settings model
 *
 * @package photolab
 */

/**
 * Logo & Favicon MODEL
 */
class Model_Social_Links implements I_Model {
	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( 'general_site_settings', 'social_links', $key );
	}

	/**
	 * Is show social links in header?
	 *
	 * @return boolean Show / Hide.
	 */
	public static function is_show_in_header() {
		return (boolean) self::get_option( 'show_in_header' );
	}

	/**
	 * Is show social links in footer?
	 *
	 * @return boolean Show / Hide.
	 */
	public static function is_show_in_footer() {
		return (boolean) self::get_option( 'show_in_footer' );
	}

	/**
	 * Is will add social sharing to blog posts
	 *
	 * @return boolean Add / No.
	 */
	public static function is_show_in_posts() {
		return (boolean) self::get_option( 'show_in_posts' );
	}

	/**
	 * Is will add social sharing to single blog post
	 *
	 * @return boolean Add / No.
	 */
	public static function is_show_in_post() {
		return (boolean) self::get_option( 'show_in_post' );
	}

	/**
	 * Get all social with URLS
	 *
	 * @return array
	 */
	public static function get_all_socials() {
		$allowed     = self::get_allowed();
		$social_urls = array();

		foreach ( $allowed as $key => $properties ) {
			$option = (string) self::get_option( $key );
			$option = trim( $option );

			if ( '' != $option ) {
				$properties['url']   = $option;
				$social_urls[ $key ] = $properties;
			}
		}
		return $social_urls;
	}

	/**
	 * Get all allowed socials
	 *
	 * @return array
	 */
	public static function get_allowed() {
		return array(
			'rss_feed' => array(
				'label' => __( 'RSS feed', 'blogetti' ),
				'icon'  => 'fa-rss',
			),
			'facebook' => array(
				'label' => __( 'Facebook', 'blogetti' ),
				'icon'  => 'fa-facebook',
			),
			'twitter' => array(
				'label' => __( 'Twitter', 'blogetti' ),
				'icon'  => 'fa-twitter',
			),
			'google_plus' => array(
				'label' => __( 'Google+', 'blogetti' ),
				'icon'  => 'fa-google-plus',
			),
			'instagram' => array(
				'label' => __( 'Instagram', 'blogetti' ),
				'icon'  => 'fa-instagram',
			),
			'linked_in' => array(
				'label' => __( 'LinkedIn', 'blogetti' ),
				'icon'  => 'fa-linkedin',
			),
			'dribbble' => array(
				'label' => __( 'Dribbble', 'blogetti' ),
				'icon'  => 'fa-dribbble',
			),
			'youtube' => array(
				'label' => __( 'YouTube', 'blogetti' ),
				'icon'  => 'fa-youtube',
			),
		);
	}
}
