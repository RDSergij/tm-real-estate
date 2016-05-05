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

	// Properties
	const SHORT_CODE_PROPERTIES      = 'tm-re-properties';

	// Property
	const SHORT_CODE_PROPERTY        = 'tm-re-property';

	// Search form
	const SHORT_CODE_SEARCH_FORM     = 'tm-re-search-form';

	// Search result
	const SHORT_CODE_SEARCH_RESULT   = 'tm-re-search-result';

	// Submission form
	const SHORT_CODE_SUBMISSION_FORM = 'tm-re-submission-form';

	// Agent contact form
	const SHORT_CODE_CONTACT_FORM    = 'tm-re-contact-form';

	// Agent contact form
	const SHORT_CODE_AGENT_PROPERTIES    = 'tm-re-agent-properties';

	// Agents list
	const SHORT_CODE_AGENTS_LIST    = 'tm-re-agents-list';

	// Map with all items
	const SHORT_CODE_MAP             = 'tm-re-map';

	/**
	 * Get tags array
	 *
	 * @return array term_id => name.
	 */
	public static function get_tags() {
		$result     = array();
		$tags_array = get_categories( array( 'taxonomy' => 'property-tag' ) );

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
		$categories = get_categories( array( 'taxonomy' => 'property-type' ) );

		if ( count( $categories ) ) {
			foreach ( $categories as $cat ) {
				$result[ (string) $cat->term_id ] = $cat->name;
			}
		}
		return $result;
	}

	/**
	 * Get all agents
	 *
	 * @return array all agents.
	 */
	public static function get_agents() {
		$agents = get_users(
			array( 'role__in' => array( 'administrator', 're_agent' ) )
		);

		if ( is_array( $agents ) ) {
			foreach ( $agents as $agent ) {
				$result[ $agent->data->ID ] = $agent->data->display_name;
			}
		}

		return $result;
	}

	/**
	 * Get agents for select options
	 *
	 * @return [array] options.
	 */
	public static function get_agents_options() {
		return array( 0 => __( 'Select agent', 'tm-real-estate' ) ) + (array) self::get_agents();
	}

	/**
	 * Get all shortcodes
	 *
	 * @return array all shortcodes.
	 */
	 static function get_shortcodes() {
		$o_class = new ReflectionClass( __CLASS__ );
		$const_array = $o_class->getConstants();
		$tm_shortcodes = array();
		foreach ( $const_array as $key => $value ) {
			if ( 0 == strpos( $key, 'SHORT_CODE_' ) ) {
					$tm_shortcodes[] = $value;
			}
		}

		return $tm_shortcodes;
	 }
	/**
	 * Wrap short code to bracets
	 *
	 * @param  [type] $shortcode_name name.
	 * @return [string] [name].
	 */
	public static function wrap_shortcode( $shortcode_name ) {
		return sprintf( '[%s]', $shortcode_name );

	}
}
