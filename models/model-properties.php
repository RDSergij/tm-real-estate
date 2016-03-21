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
	 * @param  [type] $atts atriibutes.
	 * @return array properties
	 */
	public static function get_properties( $atts = array() ) {
		$args = array(
			'posts_per_page'   => 20,
			'offset'           => 0,
			'tax_query' => array(),
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
		$args = array_merge( $args, $atts );

		if ( $args['offset'] <= 0 ) {
			$args['offset'] = max( 0, get_query_var( 'paged' ) );
		}

		$single_page = Model_Settings::get_search_single_page();

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
				$property->url		 = $single_page . '?id=' . $property->ID;
			}
		}
		return $properties;
	}

	/**
	 * Get total properties count
	 *
	 * @return total properties count.
	 */
	public static function get_total_count( $atts = array() ) {
		unset( $atts['posts_per_page'], $atts['offset'] );

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
		$args = array_merge( $args, $atts );

		return count( get_posts( $args ) );
	}

	/**
	 * Shortcode properties
	 *
	 * @param  [type] $atts attributes.
	 * @return html code.
	 */
	public static function prepare_param_properties( $atts ) {
		if ( is_array( $atts ) ) {
			if ( ! empty( $atts['limit'] ) ) {
				$atts['posts_per_page'] = $atts['limit'];
				unset( $atts['limit'] );
			} else {
				$atts['posts_per_page'] = 5;
			}

			if ( ! empty( $atts['id'] ) ) {
				$atts['include'] = explode( ',', $atts['id'] );
				unset( $atts['id'] );
			}

			if ( ! empty( $atts['keyword'] ) ) {
				$atts['s'] = $atts['keyword'];
				unset( $atts['keyword'] );
			}

			if ( ! empty( $atts['property_type'] ) ) {
				$atts['tax_query'][] = array(
					'taxonomy' => 'property-type',
					'field' => 'term_id',
					'terms' => (int) $atts['property_type'],
				);
				unset( $atts['type'] );
			}

			$atts['meta_query']['relation'] = 'AND';

			if ( ! empty( $atts['type'] ) ) {
				$atts['tax_query'][] = array(
					'taxonomy' => 'property-type',
					'field' => 'slug',
					'terms' => (array) $atts['type'],
				);
				unset( $atts['type'] );
			}

			if ( ! empty( $atts['property_status'] )  ) {
				$atts['meta_query'][] = array(
					'key' => 'status',
					'value' => (string) $atts['property_status'],
					'compare' => '=',
				);
				unset( $atts['property_status'] );
			}

			if ( ! empty( $atts['min_price'] ) ) {
				$atts['meta_query'][] = array(
					'key' => 'price',
					'value' => (int) $atts['min_price'],
					'type' => 'numeric',
					'compare' => '>=',
				);
				unset( $atts['min_price'] );
			}

			if ( ! empty( $atts['max_price'] ) ) {
				$atts['meta_query'][] = array(
					'key' => 'price',
					'value' => (int) $atts['max_price'],
					'type' => 'numeric',
					'compare' => '<=',
				);
				unset( $atts['min_price'] );
			}

			if ( ! empty( $atts['min_bathrooms'] ) ) {
				$atts['meta_query'][] = array(
					'key' => 'bathrooms',
					'value' => (int) $atts['min_bathrooms'],
					'type' => 'numeric',
					'compare' => '>=',
				);
				unset( $atts['min_bathrooms'] );
			}

			if ( ! empty( $atts['status'] ) ) {
				$atts['meta_query'][] = array(
					'key'     => 'status',
					'value'   => esc_attr( $atts['status'] ),
					'compare' => '=',
				);
				unset( $atts['status'] );
			}

			if ( ! empty( $atts['max_bathrooms'] ) ) {
				$atts['meta_query'][] = array(
					'key' => 'bathrooms',
					'value' => (int) $atts['max_bathrooms'],
					'type' => 'numeric',
					'compare' => ' <=',
				);
				unset( $atts['max_bathrooms'] );
			}

			if ( ! empty( $atts['min_bedrooms'] ) ) {
				$atts['meta_query'][] = array(
					'key' => 'bedrooms',
					'value' => (int) $atts['min_bedrooms'],
					'type' => 'numeric',
					'compare' => '>=',
				);
				unset( $atts['min_bedrooms'] );
			}

			if ( ! empty( $atts['max_bedrooms'] ) ) {
				$atts['meta_query'][] = array(
					'key' => 'bedrooms',
					'value' => (int) $atts['max_bedrooms'],
					'type' => 'numeric',
					'compare' => '<=',
				);
				unset( $atts['max_bedrooms'] );
			}

			if ( ! empty( $atts['min_area'] ) ) {
				$atts['meta_query'][] = array(
					'key' => 'area',
					'value' => (int) $atts['min_area'],
					'type' => 'numeric',
					'compare' => '>=',
				);
				unset( $atts['min_area'] );
			}

			if ( ! empty( $atts['max_area'] ) ) {
				$atts['meta_query'][] = array(
					'key' => 'area',
					'value' => (int) $atts['max_area'],
					'type' => 'numeric',
					'compare' => '<=',
				);
				unset( $atts['max_area'] );
			}

			if ( ! empty( $atts['agent'] ) ) {
				$atts['meta_query'][] = array(
					'key'     => 'agent',
					'value'   => (int) $atts['agent'],
					'compare' => '=',
				);
				unset( $atts['agent'] );
			}
		}

		return $atts;
	}

	/**
	 * Shortcode properties
	 *
	 * @return html code.
	 */
	public static function shortcode_search_result() {

		$form		= self::shortcode_search_form( $_GET );
		$properties	= self::shortcode_properties( $_GET );

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/search-result.php',
			array(
				'form'			=> $form,
				'properties'	=> $properties,
			)
		);
	}

	/**
	 * Shortcode properties
	 *
	 * @param  [type] $atts attributes.
	 * @return html code.
	 */
	public static function shortcode_properties( $atts ) {

		$atts = self::prepare_param_properties( $atts );
		$properties = (array) self::get_properties( $atts );

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/properties.php',
			array(
				'properties' => $properties,
				'pagination' => self::get_pagination( $atts, $atts['posts_per_page'] ),
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
	 * Shortcode property item
	 *
	 * @return html code.
	 */
	public static function shortcode_property_single() {
		if ( ! empty( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) {
			$id = $_GET['id'];
			$properties	= (array) self::get_properties( array( 'include' => $id, 'limit' => 1 ) );
			$property	= $properties[0];

			$contact_form = self::agent_contact_form( null, $id );

			return Cherry_Core::render_view(
				TM_REAL_ESTATE_DIR . 'views/property.php',
				array(
					'property'		=> $property,
					'contact_form'		=> $contact_form,
				)
			);
		}
	}

	/**
	 * Shortcode tm-re-search-form
	 *
	 * @return html code.
	 */
	public static function shortcode_search_form() {

		$default_value = array(
			'keyword'			=> '',
			'min_price'			=> '',
			'max_price'			=> '',
			'min_bedrooms'		=> '',
			'max_bedrooms'		=> '',
			'min_bathrooms'		=> '',
			'max_bathrooms'		=> '',
			'min_area'			=> '',
			'max_area'			=> '',
			'property_status'	=> '',
			'property_type'		=> '',
		);
		$values = array_merge( $default_value, $_GET );

		$action_url = Model_Settings::get_search_result_page();

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/search-form.php',
			array(
				'property_statuses'	=> self::get_allowed_property_statuses(),
				'property_types'	=> self::get_all_property_types(),
				'action_url'		=> $action_url,
				'values'			=> $values,
			)
		);
	}

	/**
	 * Agent contact form shortcode
	 *
	 * @return html code.
	 */
	public static function shortcode_contact_form( $atts ) {

		if ( empty( $atts['agent_id'] ) && empty( $atts['property_id'] ) ) {
			return;
		}

		$property_id = null;
		if ( ! empty( $atts['property_id'] ) ) {
			$property_id = $atts['property_id'];
		}

		$agent_id = null;
		if ( ! empty( $atts['agent_id'] ) ) {
			$agent_id = $atts['agent_id'];
		} else {
			$agent_id = get_post_meta( $property_id, 'agent', true );
		}

		return self::agent_contact_form( $agent_id, $property_id );
	}

	/**
	 * Contact form assets
	 */
	public static function contact_form_assets() {

		$contact_form_settings = Model_Settings::get_contact_form_settings();

		wp_enqueue_script(
			'tm-real-state-contact-form',
			plugins_url( 'tm-real-estate' ) . '/assets/js/contact-form.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_localize_script( 'tm-real-state-contact-form', 'TMREContactForm', array(
			'ajaxUrl'				=> admin_url( 'admin-ajax.php' ),
			'successMessage'		=> $contact_form_settings['success-message'],
			'failedMessage'			=> $contact_form_settings['failed-message'],
		) );

	}

	/**
	 * Agent contact form
	 *
	 * @return html code.
	 */
	public static function agent_contact_form( $agent_id, $property_id ) {

		self::contact_form_assets();

		if ( empty( $agent_id ) ) {
			if ( empty( $property_id ) ) {
				return;
			}

			$agent_id = get_post_meta( $property_id, 'agent', true );
		}

		$user_data = get_userdata( $agent_id );

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/contact-form.php',
			array(
				'agent'			=> $user_data->data,
				'property_id'	=> $property_id,
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
	 * @param [type] array   $atts parameters.
	 * @param [type] integer $posts_per_page properties per page.
	 * @return array pagination.
	 */
	public static function get_pagination( $atts = array(), $posts_per_page = 5 ) {
		$big  = 99999;
		$args = array(
			'base'               => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'             => '?page=%#%',
			'total'              => self::get_total_pages( $atts, $posts_per_page ),
			'current'            => max( 1, get_query_var( 'paged' ) ),
			'show_all'           => false,
			'end_size'           => 0,
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
	 * Get total pages count
	 *
	 * @param [type]  array   $atts parameters.
	 * @param [type]  integer $posts_per_page properties per page.
	 * @return total pages.
	 */
	public static function get_total_pages( $atts = array(), $posts_per_page = 5 ) {
		return ceil( self::get_total_count( $atts ) / $posts_per_page );
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
