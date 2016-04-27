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
				$property->tags      = self::get_property_tags( $property->ID );
				$property->types     = self::get_property_types( $property->ID );
				$property->url       = $single_page . '?id=' . $property->ID;
				$property->address   = self::get_address( $property->ID );
				$property->lat       = self::get_lat( $property->ID );
				$property->lng       = self::get_lng( $property->ID );
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
			if ( ! empty( $atts['orderby'] ) ) {
				$atts['orderby'] = $atts['orderby'];
			} else {
				$atts['orderby'] = 'date';
			}

			if ( ! empty( $atts['order'] ) ) {
				$atts['order'] = $atts['order'];
			} else {
				$atts['order'] = 'desc';
			}

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

			if ( ! empty( $atts['type'] ) ) {
				$atts['tax_query'][] = array(
					'taxonomy' => 'property-type',
					'field' => 'term_id',
					'terms' => (int) $atts['type'],
				);
				unset( $atts['property_type'] );
			}

			if ( ! empty( $atts['location'] ) ) {

				$atts['tax_query'][] = array(
					'taxonomy' => 'location',
					'field'    => 'term_id',
					'terms'    => (int) $atts['location'],
				);
				unset( $atts['location'] );

			}

			if ( ! empty( $atts['tag'] ) ) {
				$atts['tax_query'][] = array(
					'taxonomy' => 'property-tag',
					'field' => 'term_id',
					'terms' => (int) $atts['tag'],
				);
				unset( $atts['tag'] );
			}

			$atts['meta_query']['relation'] = 'AND';

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
		} else {
			$atts = array(
				'posts_per_page'	=> 5,
			);
		}

		return $atts;
	}

	/**
	 * Shortcode properties
	 *
	 * @return html code.
	 */
	public static function shortcode_search_result( $atts ) {
		$atts = shortcode_atts(
			array(
				'show_sorting'	=> 'no',
				'order'			=> 'desc',
			),
			$atts
		);
		$atts = array_merge( $atts, $_GET );

		$form		= self::shortcode_search_form( $atts );
		$properties	= self::shortcode_properties( $atts );

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/search-result.php',
			array(
				'form'			=> $form,
				'properties'	=> $properties,
				'area_unit'		=> Model_Settings::get_area_unit_title(),
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
		$atts = shortcode_atts(
			array(
				'show_sorting'	=> 'no',
				'orderby'		=> 'date',
				'order'			=> 'desc',
			),
			$atts
		);
		$atts = array_merge( $atts, $_GET );

		$atts = self::prepare_param_properties( $atts );
		$properties = (array) self::get_properties( $atts );

		$show_sorting = 'no';
		$order_html = '';
		if ( ! empty( $atts['show_sorting'] ) ) {
			$show_sorting = $atts['show_sorting'];
			if ( 'yes' == $atts['show_sorting'] ) {
				$order_html = self::properties_order();
			}
		}

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/properties.php',
			array(
				'properties'		=> $properties,
				'show_sorting'		=> $show_sorting,
				'order_html'		=> $order_html,
				'pagination'		=> self::get_pagination( $atts, $atts['posts_per_page'] ),
				'area_unit'			=> Model_Settings::get_area_unit_title(),
				'currency_symbol'	=> Model_Settings::get_currency_symbol(),
			)
		);
	}

	/**
	 * Get html of order links
	 *
	 * @return string html
	 */
	private static function properties_order() {

		$orderby	= ! empty( $_GET['orderby'] ) ? $_GET['orderby'] : 'date';
		$order		= ! empty( $_GET['order'] ) ? $_GET['order'] : 'desc';

		unset( $_GET['orderby'], $_GET['order'] );
		$query_string = '?' . build_query( $_GET );

		$reverse = 'desc';
		if ( 'desc' == $order ) {
			$reverse = 'asc';
		}

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/order.php',
				array(
					'query_string'			=> $query_string,
					'orderby'				=> $orderby,
					'order'					=> $order,
					'reverse'				=> $reverse,
				)
			);
	}

	/**
	 * Get all addresses
	 *
	 * @return [array] properties address.
	 */
	public static function get_addresses() {
		$result     = array();
		$properties = (array) self::get_properties(
			array(
				'meta_query' => array(
					array(
						'key'     => 'address',
						'value'   => '',
						'compare' => '!=',
					),
				),
			)
		);

		if ( count( $properties ) ) {
			foreach ( $properties as &$p ) {
				array_push(
					$result,
					array(
						'id'      => $p->ID,
						'address' => $p->address,
						'lat'     => $p->lat,
						'lng'     => $p->lng,
					)
				);
			}
		}
		return $result;
	}

	/**
	 * Shortcode google map
	 * with all property items.
	 *
	 * @return [string] map view.
	 */
	public static function shortcode_map() {
		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/map.php',
			array(
				'addresses'         => self::get_addresses(),
				'addresses_json'    => json_encode( self::get_addresses() ),
				'property_settings' => json_encode(
					array(
						'base_url' => sprintf( '%s?id=', Model_Settings::get_search_single_page() ),
					)
				),
			)
		);
	}

	/**
	 * Publish hidden
	 *
	 * @param  [int] $id post.
	 */
	public static function publish_hidden( $id ) {
		$id   = (int) $id;
		$post = get_post( $id );
		if ( $post ) {
			$post->post_status = 'publish';
			wp_update_post( $post );
		}
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
			$property_status = 'draft';
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
	 * Contact form assets
	 */
	public static function property_single_assets() {

		wp_enqueue_script(
			'swipe',
			plugins_url( 'tm-real-estate' ) . '/assets/js/swiper.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_enqueue_script(
			'tm-re-property-gallery',
			plugins_url( 'tm-real-estate' ) . '/assets/js/property-gallery.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_enqueue_style(
			'swiper',
			plugins_url( 'tm-real-estate' ) . '/assets/css/swiper.min.css',
			array(),
			'3.3.0',
			'all'
		);

		wp_enqueue_style(
			'tm-re-property-gallery',
			plugins_url( 'tm-real-estate' ) . '/assets/css/property-gallery.min.css',
			array(),
			'1.0.0',
			'all'
		);

	}

	/**
	 * Shortcode property item
	 *
	 * @return html code.
	 */
	public static function shortcode_property_single() {
		if ( ! empty( $_GET['id'] ) && is_numeric( $_GET['id'] ) ) {
			self::property_single_assets();

			$id = $_GET['id'];
			$properties	= (array) self::get_properties( array( 'include' => $id, 'limit' => 1 ) );
			$property	= $properties[0];

			$contact_form = self::agent_contact_form( null, $id );

			return Cherry_Core::render_view(
				TM_REAL_ESTATE_DIR . 'views/property.php',
				array(
					'property'			=> $property,
					'contact_form'		=> $contact_form,
					'area_unit'			=> Model_Settings::get_area_unit_title(),
					'currency_symbol'	=> Model_Settings::get_currency_symbol(),
				)
			);
		}
	}

	/**
	 * Shortcode tm-re-search-form
	 *
	 * @return html code.
	 */
	public static function shortcode_search_form( $atts ) {

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
			'show_sorting'		=> 'no',
			'orderby'			=> 'date',
		);
		$values = array_merge( $default_value, $_GET, $atts );

		$action_url = Model_Settings::get_search_result_page();

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/search-form.php',
			array(
				'property_statuses'	=> self::get_allowed_property_statuses(),
				'property_types'	=> self::get_all_property_types(),
				'action_url'		=> $action_url,
				'values'			=> $values,
				'locations'         => Model_Submit_Form::get_locations(),
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
	 * Agent contact form shortcode
	 *
	 * @return html code.
	 */
	public static function shortcode_agent_properties( $atts ) {

		if ( ! is_array( $atts ) ) {
			$atts = array();
		}

		if ( empty( $atts['agent_id'] ) && empty( $atts['property_id'] ) && empty( $_GET['agent_id'] ) && empty( $_GET['property_id'] ) ) {
			return;
		}

		$atts = array_merge( $atts, $_GET );

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

		$args = array( 'agent' => $agent_id );

		$args = array_merge( $atts, $args );

		$contact_form_html = self::agent_contact_form( $agent_id, $property_id );

		$properties_html = self::shortcode_properties( $args );

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/agent-properties.php',
			array(
				'contact_form_html'	=> $contact_form_html,
				'properties_html'		=> $properties_html,
			)
		);

	}

	/**
	 * Contact form assets
	 */
	public static function contact_form_assets() {

		$contact_form_settings = Model_Settings::get_contact_form_settings();

		wp_enqueue_script(
			'google-captcha',
			'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit',
			null,
			'1.0.0',
			false
		);

		wp_enqueue_script(
			'tm-real-state-contact-form',
			plugins_url( 'tm-real-estate' ) . '/assets/js/contact-form.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_localize_script( 'tm-real-state-contact-form', 'TMREContactForm', array(
			'ajaxUrl'			=> admin_url( 'admin-ajax.php' ),
			'successMessage'	=> $contact_form_settings['success-message'],
			'failedMessage'		=> $contact_form_settings['failed-message'],
			'captchaKey'		=> ! empty( $contact_form_settings['google-captcha-key'] ) ? $contact_form_settings['google-captcha-key'] : '',
		) );

		wp_enqueue_style(
			'tm-real-contact-form',
			plugins_url( 'tm-real-estate' ) . '/assets/css/contact-form.min.css',
			array(),
			'1.0.0',
			'all'
		);

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

		$agent_id  = max( (int) $agent_id, 1 );
		$user_data = get_userdata( $agent_id );
		$agent_page = Model_Settings::get_agent_properties_page() . '?agent_id=' . $agent_id;

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/contact-form.php',
			array(
				'agent'			=> $user_data->data,
				'property_id'	=> $property_id,
				'agent_page'	=> $agent_page,
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
	 * Get property address
	 *
	 * @param  [integer] $post_id id.
	 * @return string property address.
	 */
	public static function get_address( $post_id ) {
		return (string) get_post_meta( $post_id, 'address', true );
	}

	/**
	 * Get property lat
	 *
	 * @param  [integer] $post_id id.
	 * @return string property lat.
	 */
	public static function get_lat( $post_id ) {
		return (float) get_post_meta( $post_id, 'lat', true );
	}

	/**
	 * Get property lng
	 *
	 * @param  [integer] $post_id id.
	 * @return string property lng.
	 */
	public static function get_lng( $post_id ) {
		return (float) get_post_meta( $post_id, 'lng', true );
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
	 * Get type list of property
	 *
	 * @param  [type] $post_id property id.
	 * @return array list
	 */
	public static function get_property_types( $post_id ) {
		$types = wp_get_post_terms( $post_id, 'property-type' );
		$list = array();
		if ( ! empty( $types ) && is_array( $types ) ) {
			foreach ( $types as $type ) {
				$list[] = $type->name;
			}
		}
		return $list;
	}

	/**
	 * Get tags list of property
	 *
	 * @param  [type] $post_id property id.
	 * @return array list
	 */
	public static function get_property_tags( $post_id ) {
		$tags = wp_get_post_terms( $post_id, 'property-tag' );
		$list = array();
		if ( ! empty( $tags ) && is_array( $tags ) ) {
			foreach ( $tags as $tag ) {
				$list[] = $tag->name;
			}
		}
		return $list;
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
	public static function get_types( $parent = 0 ) {
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

	/**
	 * Get latitude and longitude from address.
	 *
	 * @param  [string] $address item.
	 * @return [array]           array( $lat, $lng )
	 */
	public static function get_lat_lng( $address ) {
		$url      = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode( $address );
		$body     = false;
		$lat      = 0;
		$lng      = 0;
		$response = wp_remote_request( $url );

		if ( array_key_exists( 'body', $response ) ) {
			$body = json_decode( $response['body'], true );
			$lat  = $body['results'][0]['geometry']['location']['lat'];
			$lng  = $body['results'][0]['geometry']['location']['lng'];
		}

		return array( $lat, $lng );
	}
}
