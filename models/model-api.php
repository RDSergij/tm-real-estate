<?php
/**
 * Api
 *
 * @package    Cherry_Framework
 * @subpackage Model
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Model Api
 */
class Model_Api {

	private static $instance;

	private $contacts = array();

	private function __construct() {
		;
	}

	public function agents_add_contacts( $contacts ) {
		if ( is_array( $contacts ) && count( $contacts ) > 0 ) {
			$this->contacts = array_merge( $this->contacts, $contacts );
			add_filter( 'user_contactmethods', array( &$this, 'add_contacts' ) );
		}
	}

	public function add_contacts( $user_contactmethods ) {
		// Display each fields
		foreach( $this->contacts as $contact ) {
			if ( !isset( $user_contactmethods[ $contact[0] ] ) )
				$user_contactmethods[ $contact[0] ] = $contact[1];
		}

		// Returns the contact methods
		return $user_contactmethods;
	}

	public function get_agents_custom_contacts() {
		return (array) $this->contacts;
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

}
