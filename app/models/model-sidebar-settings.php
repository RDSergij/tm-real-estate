<?php
/**
 * General Sidebar settings model
 *
 * @package photolab
 */

/**
 * Logo & Favicon MODEL
 */
class Model_Sidebar_Settings implements I_Model {

	const SIDEBAR_WIDTH_1__3 = '1__3';
	const SIDEBAR_WIDTH_1__4 = '1__4';

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( '', 'sidebar_settings', $key );
	}

	/**
	 * Get sidebars type
	 *
	 * @return string sidebars type.
	 */
	public static function get_sidebar_side_type() {
		$key = sprintf(
			'l%sr%s',
			self::is_show_left(),
			self::is_show_right()
		);
		if ( empty( $key ) ) {
			$key = 'lr';
		}
		$values = array(
			'lr'   => 'hide',
			'l1r'  => 'left',
			'lr1'  => 'right',
			'l1r1' => 'leftright',
		);
		return $values[ $key ];
	}

	/**
	 * Get layout type
	 *
	 * @return string layout type.
	 */
	public static function get_layout_type() {
		return sprintf(
			'l%sr%s',
			self::is_show_left(),
			self::is_show_right()
		);
	}

	/**
	 * Get content classe
	 *
	 * @return string content css class.
	 */
	public static function get_content_class( $sidebar_width = '') {
		if ( '' == $sidebar_width ) {
			$sidebar_width = '1__3';
		}
		$sidebar_width_types = array(
			self::SIDEBAR_WIDTH_1__3 => array(
				'lr' => 'col-lg-12',
				'l1r' => 'col-lg-8',
				'l1r1' => 'col-lg-4',
				'lr1' => 'col-lg-8',
			),
			self::SIDEBAR_WIDTH_1__4 => array(
				'lr' => 'col-lg-12',
				'l1r' => 'col-lg-9',
				'l1r1' => 'col-lg-6',
				'lr1' => 'col-lg-9',
			),
		);
		$classes = $sidebar_width_types[ $sidebar_width ];
		return $classes[ self::get_layout_type() ];
	}

	/**
	 * Get bootstrap grid class for sidebar
	 * @param  string $sidebar_width sidebar width option.
	 * @return bootstrap css class.
	 */
	public static function get_sidebar_class( $sidebar_width = '' ) {
		if ( '' == $sidebar_width ) {
			$sidebar_width = '1__3';
		}
		$classes = array(
			self::SIDEBAR_WIDTH_1__3 => 'col-lg-4',
			self::SIDEBAR_WIDTH_1__4 => 'col-lg-3',
		);
		return $classes[ $sidebar_width ];
	}

	/**
	 * Get mode left
	 *
	 * @return string --- mode left
	 */
	public static function is_show_left() {
		if ( is_page() || is_single() ) {
			global $post;
			return ( 
				(boolean) self::get_option( 'show_left' ) && 
				is_active_sidebar( 'left-sidebar' ) && 
				'none' != (string) get_post_meta( $post->ID, 'left_sidebar', true )
			);	
		}
		return ( (boolean) self::get_option( 'show_left' ) && is_active_sidebar( 'left-sidebar' ) );
	}

	/**
	 * Get mode right
	 *
	 * @return string --- mode right
	 */
	public static function is_show_right() {
		if ( is_page() || is_single() ) {
			global $post;
			return ( 
				(boolean) self::get_option( 'show_right' ) && 
				is_active_sidebar( 'right-sidebar' ) && 
				'none' != (string) get_post_meta( $post->ID, 'right_sidebar', true )
			);	
		}
		return ( (boolean) self::get_option( 'show_right' ) && is_active_sidebar( 'right-sidebar' ) );
	}

	/**
	 * Get mode right
	 *
	 * @return string --- mode right
	 */
	public static function show_two_sidebar() {
		if ( self::is_show_left() && self::is_show_right() ) {
			return 'two-sidebars';
		}
		return '';
	}

	/**
	 * Get registered sidebars for select control.
	 *
	 * @return array registered sidebars.
	 */
	public static function get_sidebars_for_select() {
		$result   = array(
			''     => 'Inherit',
			'none' => 'None',
		);
		$sidebars = (array) $GLOBALS['wp_registered_sidebars'];
		if ( count( $sidebars ) ) {
			foreach ( $sidebars as $sidebar ) {
				$result[ $sidebar['id'] ] = $sidebar['name'];
			}
		}
		return $result;
	}

	/**
	 * Get sidebars
	 *
	 * @return string --- json string or empty
	 */
	public static function get_sidebars() {
		return (string) self::get_option( 'add_widget_area' );
	}

	/**
	 * Get sidebars in array
	 *
	 * @return array --- sidebars array
	 */
	public static function get_sidebars_array() {
		return (array) json_decode( self::get_sidebars() );
	}

	/**
	 * Get sidebars with options
	 *
	 * @return array --- sidebars with options
	 */
	public static function get_sidebars_options() {
		$res = array();
		$arr = self::get_sidebars_array();
		if ( count( $arr ) ) {
			foreach ( $arr as $key => $value ) {
				array_push(
					$res,
					array(
						'name'          => $value,
						'id'            => self::get_sidebar_id( $value ),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					)
				);
			}
		}
		return $res;
	}

	/**
	 * Get sidebar id from name
	 *
	 * @param type $name sidebar name.
	 * @return string sidebar id.
	 */
	public static function get_sidebar_id( $name ) {
		return str_replace( ' ', '_', strtolower( $name ) );
	}

	/**
	 * Render widget area
	 *
	 * @param  [type] $widget_area widget area name.
	 * @return string widget area HTML code.
	 */
	public static function widget_area( $widget_area ) {

		$default = self::get_default_sidebar( $widget_area );
		$sidebar = self::get_widget_area( $widget_area );
		$class   = implode(' ', array_unique( array( $default, $sidebar) ) );

		return View::make(
			'blocks/widget_area',
			array(
				'sidebar_name'      => $sidebar,
				'widget_area_class' => $class,
			)
		);
	}

	/**
	 * Get sidebar to widget area
	 * @param  [type] $widget_area widget area name.
	 * @return string sidebar name.
	 */
	public static function get_widget_area( $widget_area ) {
		global $post;

		$widget_area = trim( $widget_area );
		$default = self::get_default_sidebar( $widget_area );
		if ( ! is_null( $post ) ) {
			if ( in_array( $post->post_type, array( 'post', 'page' ) ) ) {
				$sidebar = (string) get_post_meta( $post->ID, $widget_area, true );
				// Inherit 
				if ( $sidebar == '' ) {
					$sidebar = $default;
				}
				return $sidebar;
			} else {
				return $default;
			}
		}

		if( is_404() ) {
			return $default;
		}
		return 'none';
	}

	/**
	 * Get default sidebar by widget area
	 *
	 * @param  [type] $widget_area widget area name.
	 * @return default sidebar.
	 */
	public static function get_default_sidebar( $widget_area ) {
		$defaults = array(
			'full_width'               => 'full-width',
			'before_content'           => 'main',
			'before_loop'              => 'before-loop-widget-area',
			'content_area'        	   => 'content-sidebar-0',
			'after_content'            => 'content-sidebar',
			'after_content_full_width' => 'after-content-full-width-widget-area',
			'left_sidebar'             => 'left-sidebar',
			'right_sidebar'            => 'right-sidebar',
			'footer'                   => 'footer',
			'footer_first_column'      => 'footer-1',
			'footer_second_column'     => 'footer-2',
			'footer_third_column'      => 'footer-3',
			'footer_fourth_column'     => 'footer-4',
		);
		if( array_key_exists( $widget_area, $defaults ) ) {
			return $defaults[ $widget_area ];
		}
		return 'none';
	}
}
