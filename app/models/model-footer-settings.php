<?php
/**
 * Footer settings model
 *
 * @package photolab
 */

/**
 * Footer settings model class
 */
class Model_Footer_Settings implements I_Model{

	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key ) {
		return Options::get_option( '', 'footer_settings', $key );
	}

	/**
	 * Get site logo HTML code
	 *
	 * @return string --- site logo HTML code
	 */
	public static function get_logo() {
		return trim( self::get_option( 'logo' ) );
	}

	/**
	 * Get copyright text
	 *
	 * @return string --- copyright HTML code
	 */
	public static function get_copyright() {
		return (string) self::get_option( 'copyright_text' );
	}

	/**
	 * Get columns number
	 *
	 * @return integer --- columns number
	 */
	public static function get_columns() {
		$columns = ( int ) self::get_option( 'widget_area_columns' );
		$columns = max( 2, $columns );
		$columns = min( 4, $columns );
		return $columns;
	}

	/**
	 * Get columns css class
	 *
	 * @return string --- css class
	 */
	public static function get_columns_css_class() {
		$columns_number = self::get_columns();
		$classes = array(
			2 => 'col-md-6',
			3 => 'col-md-4',
			4 => 'col-md-3',
		);
		return $classes[ $columns_number ];
	}


	/**
	 * Get layout
	 *
	 * @return string layout name
	 */
	public static function get_layout() {
		$layout = (string) self::get_option( 'layout' );
		if ( '' == $layout ) {
			$layout = 'default';
		}
		return $layout;
	}

	/**
	 * Get widget background
	 *
	 * @return string hec code
	 */
	public static function get_widget_area_bg_color() {
		return (string) self::get_option( 'widget_area_bg_color' );
	}

	/**
	 * Get footer background
	 *
	 * @return string hec code
	 */
	public static function get_bg_color() {
		return (string) self::get_option( 'bg_color' );
	}

	/**
	 * Get all footer widgets id
	 *
	 * @return array --- all footer widgets id
	 */
	public static function get_all_footer_widgets_id() {
		global $_wp_sidebars_widgets;
		$result = array();
		if ( array_key_exists( 'footer', $_wp_sidebars_widgets ) ) {
			$result = $_wp_sidebars_widgets['footer'];
		}
		return $result;
	}

	/**
	 * Get all footer widgets
	 *
	 * @return array --- widgets
	 */
	public static function get_all_footer_widgets() {
		global $wp_registered_widgets;
		$widget_keys = array_keys( $wp_registered_widgets );
		$ids         = self::get_all_footer_widgets_id();
		$result 	 = array();
		if ( count( $ids ) ) {
			foreach ( $ids as $id ) {
				if ( in_array( $id, $widget_keys ) ) {
					array_push( $result, $wp_registered_widgets[ $id ] );
				}
			}
		}
		return $result;
	}

	/**
	 * Get all footer widgets HTML in on array
	 *
	 * @return array --- all footer widgets HTML in on array
	 */
	public static function get_all_footer_widgets_html() {
		$widgets 		= array();
		$footer_widgets = self::get_all_footer_widgets();
		if ( count( $footer_widgets ) ) {
			foreach ( $footer_widgets as $widget ) {
				$option   = get_option( $widget['callback'][0]->option_name );
				$instance = array();
				if ( array_key_exists( $widget['callback'][0]->number, $option ) ) {
					$instance = $option[ $widget['callback'][0]->number ];
				}

				ob_start();
				the_widget(
					get_class( $widget['callback'][0] ),
					$instance,
					array(
						'before_widget' => '<aside class="widget footer-widget">',
						'after_widget'  => '</aside>',
						'before_title'  => '<h3 class="widget-title">',
						'after_title'   => '</h3>',
					)
				);
				$widget = ob_get_clean();
				array_push( $widgets, $widget );
				$widget = ''; // Yeah i'm a paranoic :D
			}
		}
		return $widgets;
	}
}
