<?php
/**
 * Blog setting model
 *
 * @package photolab
 */

/**
 * Typography settings model class
 */
class Model_Typography_Settings {

	/**
	 * Received google fonts
	 * @var [type]
	 */
	private static $received_google_fonts = false;

	/**
	 * Default google fonts api
	 */
	const DEFAULT_GOOGLE_FONTS_API_KEY = 'AIzaSyC8ABgdjegQgcxF9zkhmV2gkXM5l0mgFB8';

	/**
	 * Google fonts url
	 */
	const GOOGLE_FONTS_URL = 'https://fonts.googleapis.com/css?';

	/*
	 * List of settings
	 */
	private static $list_typography_settings = array( 'body_text', 'breadcrumbs_typography', 'h1_heading','h2_heading','h3_heading', 'h4_heading', 'h5_heading', 'h5_heading', 'h6_heading' );

	/*
	 * List of settings
	 */
	private static $default_fonts = array(
						'Arial, Helvetica, sans-serif',
						'"Arial Black", Gadget, sans-serif',
						'"Comic Sans MS", cursive',
						'"Courier New", Courier, monospace',
						'Georgia, serif',
						'Impact,Charcoal, sans-serif',
						'"Lucida Console", Monaco, monospace',
						'"Lucida Sans Unicode", "Lucida Grande", sans-serif',
						'"Palatino Linotype", "Book Antiqua", Palatino, serif',
						'Tahoma, Geneva, sans-serif',
						'"Times New Roman", Times, serif',
						'"Trebuchet MS", Helvetica, sans-serif',
						'Verdana, Geneva, sans-serif',
						'Symbol',
						'Webdings',
						'Wingdings, "Zapf Dingbats"',
						'"MS Sans Serif", Geneva, sans-serif',
						'"MS Serif", "New York", serif',
					);


	/**
	 * Get single option by key
	 *
	 * @return mixed --- option type.
	 */
	public static function get_option( $key, $setting ) {
		return Options::get_option( 'typography_settings', $setting, $key );
	}

	/**
	 * Get google api key
	 *
	 * @return string Api key.
	 */
	public static function get_google_api_key() {
		$api_key = self::get_option( 'api_key', 'google_api' );
		if ( empty( $api_key ) ) {
			$api_key = self::DEFAULT_GOOGLE_FONTS_API_KEY;
		}
		return $api_key;
	}

	/**
	 * Get google fonts
	 *
	 * @return array List fonts.
	 */
	public static function get_google_fonts() {
		// Caching received fonts
		if ( self::$received_google_fonts ) {
			return self::$received_google_fonts;
		}
		$api_key = self::get_google_api_key();
		$google_fonts = Utils::get_contents_json( 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $api_key );
		$fonts = self::$default_fonts;
		if ( ! empty( $google_fonts->items ) ) {
			foreach ( $google_fonts->items as $font_item ) {
				$font_variants = implode( ',', $font_item->variants );
				$font_subsets = implode( ',', $font_item->subsets );
				$font_parameters = 'family=' . $font_item->family . ':' . $font_variants . '&subset=' . $font_subsets;
				$fonts[ $font_parameters ] = $font_item->family;
			}
		}
		self::$received_google_fonts = $fonts;
		return $fonts;
	}

	/**
	 * Get all style of all typography settings
	 *
	 * @return array Style property.
	 */
	public static function get_all_typography_settings() {
		$return = array();
		foreach ( self::$list_typography_settings as $setting ) {
			if ( $value = self::get_typography_settings( $setting ) ) {
				$return[ $setting ] = $value;
			}
		}

		return $return;
	}

	/**
	 * Get all style of one item typography setting
	 *
	 * @return array Style property.
	 */
	public static function get_typography_settings( $setting ) {
		$return = array();
		if ( $font_family = self::get_font_family( $setting ) ) {
			$return['font-family'] = $font_family;
		}

		if ( $font_style = self::get_font_style( $setting ) ) {
			$return['font-style'] = $font_style;
		}

		if ( $font_size = self::get_font_size( $setting ) ) {
			$return['font-size'] = $font_size;
		}

		if ( $font_weight = self::get_font_weight( $setting ) ) {
			$return['font-weight'] = $font_weight;
		}

		if ( $line_height = self::get_line_height( $setting ) ) {
			$return['line-height'] = $line_height;
		}

		if ( $letter_space = self::get_letter_space( $setting ) ) {
			$return['letter-spacing'] = $letter_space;
		}

		if ( $text_align = self::get_text_align( $setting ) ) {
			$return['text-align'] = $text_align;
		}

		return $return;
	}

	/**
	 * Get font family
	 *
	 * @return string Style property.
	 */
	public static function get_font_family( $setting ) {
		$font = self::get_font_family_parameters_string( $setting );
		if ( is_numeric( $font ) ) {
			$font_family = self::$default_fonts[ $font ];
		} else {
			$font_family = Utils::get_request_parameter( $font, 'family', '' );
			$font_family_temp = explode( ':', $font_family );
			$font_family = $font_family_temp[0];
		}
		return $font_family;
	}

	/**
	 * Get font family
	 *
	 * @return string Style property.
	 */
	public static function get_font_family_parameters_string( $setting ) {
		return self::get_option( 'font_family', $setting );
	}

	/**
	 * Get font family
	 *
	 * @return string Url of font.
	 */
	public static function get_google_font_url_item( $setting ) {
		return self::get_font_family_parameters_string( $setting );
	}

	/**
	 * Get font family array
	 *
	 * @return string Url of font.
	 */
	public static function get_google_font_url_list() {
		$list = array();
		foreach( self::$list_typography_settings as $font_parameter_item ) {
			$url = trim( self::get_google_font_url_item( $font_parameter_item ) );
			if ( '' != trim( $url ) && ! is_numeric( $url ) ) {
				$list[ self::get_font_family( $font_parameter_item ) ] = self::GOOGLE_FONTS_URL . $url;
			}
		}
		return array_unique( $list );
	}

	/**
	 * Get font assets array
	 *
	 * @return string Url of font.
	 */
	public static function get_google_font_assets_list() {
		$assets = self::get_google_font_url_list();
		$styles_enqueue = array();
		if ( ! empty( $assets ) ) {
			foreach ( $assets as $font_family => $url ) {
				$font_family = str_replace( array( ' ', ',' ), '-', $font_family);
				$styles_enqueue[] = array( $font_family . '-google-fonts', $url, array() );
			}
		}
		return $styles_enqueue;
	}

	/**
	 * Get font style
	 *
	 * @return string Style property.
	 */
	public static function get_font_style( $setting ) {
		return self::get_option( 'font_style', $setting );
	}

	/**
	 * Get font size
	 *
	 * @return string Style property.
	 */
	public static function get_font_size( $setting ) {
		$font_size = self::get_option( 'font_size', $setting );
		if ( is_numeric( $font_size ) ) {
			$font_size.= 'px';
		}
		return $font_size;
	}

	/**
	 * Get font weight
	 *
	 * @return string Style property.
	 */
	public static function get_font_weight( $setting ) {
		return self::get_option( 'font_weight', $setting );
	}

	/**
	 * Get line height
	 *
	 * @return string Style property.
	 */
	public static function get_line_height( $setting ) {
		$line_height = self::get_option( 'line_height', $setting );
		if ( is_numeric( $line_height ) ) {
			$line_height.= 'px';
		}
		return $line_height;
	}

	/**
	 * Get letter space
	 *
	 * @return string Style property.
	 */
	public static function get_letter_space( $setting ) {
		$letter_space = self::get_option( 'letter_space', $setting );
		if ( is_numeric( $letter_space ) ) { 
			$letter_space.= 'px';
		}
		return $letter_space;
	}

	/**
	 * Get text align
	 *
	 * @return string Style property.
	 */
	public static function get_text_align( $setting ) {
		return self::get_option( 'text_align', $setting );
	}
}
