<?php
/**
 * I_Model interface file
 *
 * @package photolab
 */

/**
 * I_Model interface
 */
interface I_Model {
	/**
	 * Get single option by key
	 *
	 * @param  [type] $key settging key.
	 * @return mixed
	 */
	public static function get_option( $key );
}
