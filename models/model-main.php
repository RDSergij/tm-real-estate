<?php
/**
 * Model main class file.
 *
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <support@cherryframework.com>
 * @copyright  Copyright (c) 2012 - 2015, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Model main class
 */
class Model_Main {

	/**
	 * Get tags array
	 *
	 * @return array term_id => name.
	 */
	public static function get_tags() {
		$result     = array();
		$tags_array = get_tags();

		if ( count( $tags_array ) ) {
			foreach ( $tags_array as $tag ) {
				$result[ $tag->term_id ] = $tag->name;
			}
		}
		return $result;
	}

	/**
	 * Get categoreis array
	 *
	 * @return array term_id => name.
	 */
	public static function get_categories() {
		$result     = array();
		$categories = get_categories();

		if ( count( $categories ) ) {
			foreach ( $categories as $cat ) {
				$result[ $cat->term_id ] = $cat->name;
			}
		}
		return $result;
	}
}