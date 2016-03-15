<?php
/**
 * Properties
 * @package    Cherry_Framework
 * @subpackage Model
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Model properties
 */
class Model_Properties {
	/**
	 * Get all properties
	 *
	 * @param  integer $posts_per_page count.
	 * @return array properties
	 */
	public static function get_properties( $posts_per_page = 5 ) {
		 $args = array(
			'posts_per_page'   => $posts_per_page,
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'date',
			'order'            => 'DESC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'property',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'author'	       => '',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		);
		$properties = (array) get_posts( $args );
		if ( count( $properties ) ) {
			foreach ( $properties as &$property ) {
				$property->test = 'some test';
				$property->meta = get_metadata( 'post', $property->ID, '', true );
			}
		}
		return $properties;
	}

	/**
	 * Shortcode properties
	 *
	 * @param  [type] $atts attributes.
	 * @return html code.
	 */
	public static function shortcode_properties( $atts ) {
		$posts_per_page = 5;
		if ( is_array( $atts ) && array_key_exists( 'posts_per_page', $atts ) ) {
			$posts_per_page = $atts['posts_per_page'];
		}

		$properties = (array) self::get_properties( $posts_per_page );

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . '/views/property.php',
			array( 'properties' => $properties )
		);
	}
		/**
	 * Add new properties
	 *
	 * @param  [type] $atts attributes.
	 * @return html code.
	 */
	public static function add_property( $attr ) {
		
		if ( current_user_can('administrator') || current_user_can('re_agent') ) {
			$property_status = 'publish';
		} else {
			$property_status = 'pending';
		}
		$property = array(
			'post_title'     => $attr['title'],
			'post_author'    => get_current_user_id(),
			'post_content'   => $attr['description'],
			'post_status'    => $property_status,
			'post_type'      => 'property',
			);
		$property = sanitize_post($property, 'db');
		return wp_insert_post($property);
	}
}