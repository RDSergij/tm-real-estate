<?php
/**
 * Core Utils class file
 *
 * @package photolab
 */

/**
 * Utils class
 */
class Utils {

	/**
	 * Print and die a value - Used for debugging.
	 *
	 * @param mixed $value Any PHP value.
	 * @return void
	 */
	public static function pd( $value ) {
		echo '<pre>';
		print_r( $value );
		echo '</pre>';
		wp_die();
	}

	/**
	 * Print a value.
	 *
	 * @param mixed $value Any PHP value.
	 * @return void
	 */
	public static function p( $value ) {
		echo '<pre>';
		print_r( $value );
		echo '</pre>';
	}

	/**
	 * Try get value by key from array
	 *
	 * @param  array $array values list.
	 * @param  type  $key value key.
	 * @param  type  $default default value.
	 * @return mixed value by key
	 */
	public static function array_get( $array, $key, $default = '' ) {
		$array = (array) $array;
		if ( is_null( $key ) ) {
			return $array;
		}
		if ( array_key_exists( $key, $array ) ) {
			return $array[ $key ];
		}
		return $default;
	}

	/**
	 * Join array to string
	 *
	 * @param  array $arr --- array like 'key' => 'value'.
	 * @return string --- joined string
	 */
	public static function array_join( $arr = array() ) {
		$arr    = self::array_remove_empty( $arr );
		$result = array();
		foreach ( $arr as $key => $value ) {
			$result[] = sprintf( '%s="%s"', $key, $value );
		}
		return implode( ' ', $result );
	}

	/**
	 * Get all of the given array except for a specified array of items.
	 *
	 * @param array $array to except.
	 * @param array $keys keys.
	 * @return array
	 */
	public static function array_except( $array, $keys ) {
		return array_diff_key( $array, array_flip( (array) $keys ) );
	}

	/**
	 * Remove empty elements
	 *
	 * @param  array $arr --- array with empty elements.
	 * @return array --- array without empty elements
	 */
	public static function array_remove_empty( $arr ) {
		return array_filter( $arr, array( __CLASS__, 'array_remove_empty_check' ) );
	}

	/**
	 * Check if empty.
	 * It's need for PHP 5.2.4 version
	 *
	 * @param  [type] $var variable.
	 * @return boolean
	 */
	public static function array_remove_empty_check( $var ) {
		return '' != $var;
	}

	/**
	 * Lave just right keys in array
	 *
	 * @param  array $right_keys right keys to leave.
	 * @param  array $array list.
	 * @return array
	 */
	public static function array_leave_right_keys( $right_keys, $array ) {
		$right_keys = (array) $right_keys;
		$array      = (array) $array;

		if ( count( $array ) ) {
			foreach ( $array as $key => $value ) {
				if ( ! in_array( $key, $right_keys ) ) {
					unset( $array[ $key ] );
				}
			}
		}
		return $array;
	}

	/**
	 * Remove some keys form array
	 *
	 * @param  [type] $right_keys keys to remove.
	 * @param  [type] $array      where we want remove this keys.
	 * @return array without keys
	 */
	public static function array_remove_right_keys( $right_keys, $array ) {
		$right_keys = (array) $right_keys;
		$array      = (array) $array;

		if ( count( $right_keys ) ) {
			foreach ( $right_keys as $key ) {
				if ( array_key_exists( $key, $array ) ) {
					unset( $array[ $key ] );
				}
			}
		}
		return $array;
	}

	/**
	 * Push some values in to end of the array
	 *
	 * @param  [type] $array list where we want push.
	 * @param  [type] $values values to push.
	 * @return array with new values
	 */
	public static function array_push_values( &$array, $values ) {
		$array  = (array) $array;
		$values = (array) $values;

		if ( count( $values ) ) {
			foreach ( $values as $value ) {
				$array[] = $value;
			}
		}
		return $array;
	}

	/**
	 * Get first item
	 *
	 * @param  [type] $array where we want get first element.
	 * @return mixed first element.
	 */
	public static function array_get_first( $array ) {
		reset( $array );
		return current( $array );
	}

	/**
	 * Determine if a given string starts with a given substring.
	 *
	 * @param type       $haystack haystack.
	 * @param type|array $needles some needles.
	 * @return bool
	 */
	public static function starts_with( $haystack, $needles ) {
		foreach ( (array) $needles as $needle ) {
			if ( '' != $needle && 0 === strpos( $haystack, $needle ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get string from echo buffer and return in variable
	 *
	 * @param  mixed $func function name.
	 * @return string
	 */
	public static function echo_to_var( $func ) {
		$result = '';
		if ( is_callable( $func ) ) {
			ob_start();
			call_user_func( $func );
			$result = ob_get_clean();
		}
		return $result;
	}

	/**
	 * Models path
	 *
	 * @return  string
	 */
	public static function models_path() {
		return sprintf(
			'%s/app/models/',
			get_template_directory()
		);
	}

	/**
	 * Widgets path
	 *
	 * @return string
	 */
	public static function widgets_path() {
		return sprintf(
			'%s/app/modules/widgets/',
			get_template_directory()
		);
	}

	/**
	 * Api path
	 *
	 * @return string
	 */
	public static function api_path() {
		return sprintf(
			'%s/src/api/',
			get_template_directory()
		);
	}

	/**
	 * tgm plugins path
	 *
	 * @return string
	 */
	public static function tgm_path() {
		return sprintf(
			'%s/src/tgm/',
			get_template_directory()
		);
	}

	/**
	 * Pages path
	 *
	 * @return string
	 */
	public static function pages_path() {
		return sprintf(
			'%s/app/modules/pages/',
			get_template_directory()
		);
	}

	/**
	 * Assets URL
	 *
	 * @return string
	 */
	public static function assets_url() {
		return sprintf(
			'%s/app/assets/',
			get_template_directory_uri()
		);
	}

	/**
	 * Core URL
	 *
	 * @return string
	 */
	public static function core_url() {
		return sprintf(
			'%s/src/',
			get_template_directory_uri()
		);
	}

	/**
	 * Instead $GLOBALS['wp_filesystem']->get_contents( $file )
	 *
	 * @param type $url host url.
	 * @return string requres data
	 */
	public static function get_contents( $url ) {

		$cache_key = md5( $url );
		$result = self::get_cache( $cache_key );
		if ( ! $result ) {
			$response = wp_remote_get( $url );
			if( is_array( $response ) ) {
				self::set_cache( $cache_key, $response['body'] );
				return $response['body'];
			}
		}

		return $result;
	}

	/**
	 * Set Cache
	 * @param string  $key
	 * @param string  $val    
	 * @param integer $time   
	 * @param string  $prefix 
	 */
	public static function set_cache($key, $val, $time = 3600)
	{
		set_transient( $key, $val, $time );
	}
	/**
	 * Get Cache
	 * @param  string $key    
	 * @param  string $prefix 
	 * @return mixed
	 */
	public static function get_cache( $key ) { 
		$cached   = get_transient( $key );
		if ( false !== $cached ) return $cached;
		return false;
	}

	/**
	 * Get wp_filesystem
	 *
	 * @return Object
	 */
	public static function get_wp_filesystem() {
		global $wp_filesystem;

		if ( ! defined( 'FS_CHMOD_FILE' ) ) {
			define( 'FS_CHMOD_FILE', ( fileperms( ABSPATH . 'index.php' ) & 0777 | 0644 ) );
		}

		if ( empty( $wp_filesystem ) ) {
			include_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php' );
			include_once( ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php' );
		}

		return new WP_Filesystem_Direct( null );
	}

	/**
	 * A function that returns the 'attachment_id' of a
	 * media file by giving its URL.
	 *
	 * @param string $url The media/image URL - Works only for images uploaded from within WordPress.
	 * @return int|boolean The image/attachment_id if it exists, false if not.
	 */
	public static function attachment_id_from_url( $url = null ) {
		// Load the DB class
		global $wpdb;

		// Set attachment_id
		$id = false;

		// If there is no url, return.
		if (null === $url) {
			return;
		}

		// Get the upload directory paths
		$upload_dir_paths = wp_upload_dir();

		/**
		 * Make sure the upload path base directory exists in the attachment URL,
		 * to verify that we're working with a media library image
		 */
		if ( false !== strpos( $url, $upload_dir_paths['baseurl'] ) ) {
			/**
			 * If this is the URL of an auto-generated thumbnail,
			 * get the URL of the original image
			 */
			$url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $url );

			// Remove the upload path base directory from the attachment URL
			$url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $url );

			// Grab the database prefix
			$prefix = $wpdb->prefix;

			/**
			 * Finally, run a custom database query to get the attachment ID
			 * from the modified attachment URL
			 */
			$id = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT {$prefix}posts.ID FROM $wpdb->posts {$prefix}posts, $wpdb->postmeta {$prefix}postmeta WHERE {$prefix}posts.ID = {$prefix}postmeta.post_id AND {$prefix}postmeta.meta_key = '_wp_attached_file' AND {$prefix}postmeta.meta_value = '%s' AND {$prefix}posts.post_type = 'attachment'",
					$url
				)
			);
		}
		return $id;
	}

	/**
	 * Get decode json data from curls_data
	 *
	 * @return array
	 */
	public static function get_contents_json( $url ) {

		$result = self::get_contents( $url );

		return json_decode( $result );
	}

	/**
	 * Get parameter from string requests
	 *
	 * @return array
	 */
	public static function get_request_parameter( $get_request, $key, $default = '' ) {

		parse_str( $get_request, $parameters );

		return self::array_get( $parameters, $key, $default );
	}
}
