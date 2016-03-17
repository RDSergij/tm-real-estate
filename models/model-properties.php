<?php
/**
 * Properties
 *
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
	 * @param  [type] $posts_per_page count.
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
				$property->meta      = get_metadata( 'post', $property->ID, '', true );
				$property->images    = self::get_all_post_images( $property->ID );
				$property->image     = self::get_image( $property->ID );
				$property->gallery   = self::get_gallery( $property->ID );
				$property->status    = self::get_property_status( $property->ID );
				$property->price     = self::get_price( $property->ID );
				$property->type      = self::get_type( $property->ID );
				$property->bathrooms = self::get_bathrooms( $property->ID );
				$property->bedrooms  = self::get_bedrooms( $property->ID );
				$property->area      = self::get_area( $property->ID );
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
			TM_REAL_ESTATE_DIR . 'views/property.php',
			array(
				'properties' => $properties,
				'pagination' => self::get_pagination( $posts_per_page ),
			)
		);
	}
	/**
	 * Add new properties
	 *
	 * @param  [type] $attr attributes.
	 * @return html code.
	 */
	public static function add_property( $attr ) {
		if ( current_user_can( 'administrator' ) || current_user_can( 're_agent' ) ) {
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
		$property = sanitize_post( $property, 'db' );
		return wp_insert_post( $property );
	}
	/**
	 * Shortcode tm-re-search-form
	 *
	 * @param  [type] $atts attributes.
	 * @return html code.
	 */
	public static function shortcode_search_form( $atts ) {
		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/search-form.php',
			array(
				'property_statuses' => self::get_allowed_property_statuses(),
				'property_types'    => self::get_all_property_types(),
			)
		);
	}

	/**
	 * Get property price
	 *
	 * @param  [type] $post_id id.
	 * @return string property price.
	 */
	public static function get_price( $post_id ) {
		return (float) get_post_meta( $post_id, 'price', true );
	}

	/**
	 * Get property type
	 *
	 * @param  [type] $post_id id.
	 * @return string property type.
	 */
	public static function get_type( $post_id ) {
		return (string) get_post_meta( $post_id, 'type', true );
	}

	/**
	 * Get property bathrooms
	 *
	 * @param  [type] $post_id id.
	 * @return string property bathrooms.
	 */
	public static function get_bathrooms( $post_id ) {
		return (float) get_post_meta( $post_id, 'bathrooms', true );
	}

	/**
	 * Get property bedrooms
	 *
	 * @param  [type] $post_id id.
	 * @return string property bedrooms.
	 */
	public static function get_bedrooms( $post_id ) {
		return (float) get_post_meta( $post_id, 'bedrooms', true );
	}

	/**
	 * Get property area
	 *
	 * @param  [type] $post_id id.
	 * @return string property area.
	 */
	public static function get_area( $post_id ) {
		return (float) get_post_meta( $post_id, 'area', true );
	}

	/**
	 * Get property status
	 *
	 * @param  [type] $post_id id.
	 * @return string property status.
	 */
	public static function get_property_status( $post_id ) {
		$allowed = self::get_allowed_property_statuses();
		$type    = (string) get_post_meta( $post_id, 'status', true );
		if ( array_key_exists( $type, $allowed ) ) {
			return $type;
		}
		return end( $allowed );
	}

	/**
	 * Get allowed property statuses
	 *
	 * @return array property statuses.
	 */
	public static function get_allowed_property_statuses() {
		return array(
			'rent' => __( 'Rent', 'tm-real-estate' ),
			'sale' => __( 'Sale', 'tm-real-estate' ),
		);
	}

	/**
	 * Get all property types
	 *
	 * @return array
	 */
	public static function get_all_property_types() {
		return get_terms(
			array( 'property-type' ),
			array(
				'hide_empty' => false,
				'orderby'    => 'term_group',
			)
		);
	}

	/**
	 * Get gallery
	 *
	 * @param  [type] $post_id id.
	 * @return property gallery.
	 */
	public static function get_gallery( $post_id ) {
		$gallery = get_post_meta( $post_id, 'gallery', true );
		if ( array_key_exists( 'image', (array) $gallery ) ) {
			foreach ( $gallery['image'] as &$image ) {
				$image = self::get_all_images( $image );
			}
		}
		return $gallery;
	}

	/**
	 * Get property image
	 *
	 * @param  [type] $post_id property id.
	 * @return string image.
	 */
	public static function get_image( $post_id ) {
		$images = self::get_all_post_images( $post_id );
		if ( array_key_exists( 'medium', $images ) ) {
			return $images['medium'][0];
		}
		return TM_REAL_ESTATE_URI.'assets/images/placehold.png';
	}

	/**
	 * Get all post images
	 *
	 * @param  [type] $post_id post id.
	 * @return array all post images.
	 */
	public static function get_all_post_images( $post_id ) {
		if ( has_post_thumbnail( $post_id ) ) {

			$attachment_id = get_post_thumbnail_id( $post_id );
			return self::get_all_images( $attachment_id );

		}
		return array();
	}

	/**
	 * Get all images by attachmen id
	 *
	 * @param  [type] $attachment_id id.
	 * @return array size => image
	 */
	public static function get_all_images( $attachment_id ) {
		$result = array();
		$sizes  = get_intermediate_image_sizes();

		if ( is_array( $sizes ) && count( $sizes ) ) {
			foreach ( $sizes as $size ) {
				$result[ $size ] = wp_get_attachment_image_src( $attachment_id, $size );
			}
		}
		return $result;
	}

	/**
	 * Get propeties pagination array
	 *
	 * @param  [type] $posts_per_page properties per page.
	 * @return array pagination.
	 */
	public static function get_pagination( $posts_per_page = 5 ) {
		$args = array(
			'base'               => '%_%',
			'format'             => '?page=%#%',
			'total'              => self::get_total_pages( $posts_per_page ),
			'current'            => max( 1, get_query_var( 'page' ) ),
			'show_all'           => false,
			'end_size'           => 1,
			'mid_size'           => 2,
			'prev_next'          => true,
			'prev_text'          => __( '« Previous' ),
			'next_text'          => __( 'Next »' ),
			'type'               => 'array',
			'add_args'           => false,
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => '',
		);
		return paginate_links( $args );
	}

	/**
	 * Get total properties count
	 *
	 * @return total properties count.
	 */
	public static function get_total_count() {
		$args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'fields'           => 'ids',
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
			'author'           => '',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		);
		return count( get_posts( $args ) );
	}

	/**
	 * Get total pages count
	 *
	 * @param type integer $posts_per_page properties per page.
	 * @return total pages.
	 */
	public static function get_total_pages( $posts_per_page = 5 ) {
		return ceil( self::get_total_count() / $posts_per_page );
	}

	/**
	 * Get Types of properties
	 *
	 * @param type integer $parent ID of parent types.
	 * @return total pages.
	 */
	public function get_types( $parent = 0 ) {
		$terms = get_terms( 'property-type', array( 'parent' => $parent, 'hide_empty' => false ) );
		if ( count( $terms ) > 0 ) {
			foreach ( $terms as $term ) {
				$child = Model_Properties::get_types( $term->term_id );
				$types[] = array(
					'term_id' => $term->term_id,
					'name' => $term->name,
					'child' => $child,
					);
			}
			return $types;
		}
		return false;
	}
}

