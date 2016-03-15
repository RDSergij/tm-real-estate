<?php
/**
 * @package    Cherry_Framework
 * @subpackage Class
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Cherry_Admin_Menu' ) ) {

	/**
	 * Post meta management module
	 */
	class Cherry_Admin_Menu {

		/**
		 * Module version
		 *
		 * @var string
		 */
		public $module_version = '1.0.0';

		/**
		 * Module slug
		 *
		 * @var string
		 */
		public $module_slug = 'cherry-admin-menu';

		/**
		 * Module arguments
		 *
		 * @var array
		 */
		public $args = array();

		/**
		 * Core instance
		 *
		 * @var object
		 */
		public $core = null;

		/**
		 * Current nonce name to check
		 * @var null
		 */
		public $nonce = 'cherry-admin-menu-nonce';

		/**
		 * Constructor for the module
		 */
		function __construct( $core, $args ) {

			$this->core = $core;
			$this->args = wp_parse_args( $args, array(
				'slug'          => 'cherry-admin-page',
				'title'         => 'Cherry Admin Page',
				'parent'		=> null,
				'capability'	=> 'manage_options',
				'position'      => 20,
				'icon'			=> 'dashicons-admin-site',
				'callback_view' => false,
				'sections'      => array(),
				'settings'      => array(),
				'tabs'          => true,
				'views'			=> $this->core->get_core_dir() . 'modules/' . $this->module_slug . '/views/',
			) );

			add_action('admin_enqueue_scripts', array( $this, 'assets') );
		}

		/*
		 * Add admin menu page
		 */
		function add_admin_page() {
			//$this->assets();
			$this->includes();
			$page = Page_Builder::make( $this->args['slug'], $this->args['title'], $this->args['parent'], $this->args['views'] )->set( array(
					'capability'    => $this->args['capability'],
					'icon'          => $this->args['icon'],
					'position'      => $this->args['position'],
					'tabs'          => $this->args['tabs'],
				));
			$page->addSections( $this->args['sections'] );
			$page->addSettings( $this->args['settings'] );
		}

		/**
		 * Add styles and scripts
		 *
		 * @return void
		 */
		public function assets() {
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-form' );

			wp_enqueue_script(
				'cherry-settings-page',
				$this->core->get_core_url() . 'modules/' . $this->module_slug . '/assets/js/custom.js',
				array( 'jquery' ),
				'0.1.0',
				true
			);

			wp_enqueue_style(
				'jquery-ui-tabs',
				$this->core->get_core_url() . 'modules/' . $this->module_slug . '/assets/css/jquery-ui.min.css',
				array(),
				'1.11.4',
				'all'
			);

			wp_enqueue_style(
				'cherry-settings-page',
				$this->core->get_core_url() . 'modules/' . $this->module_slug . '/assets/css/custom.min.css',
				array(),
				'0.1.0',
				'all'
			);
		}

		private function includes() {
			$based_dir = $this->core->get_core_dir() . 'modules/' . $this->module_slug;
			require_once $based_dir . '/inc/page.php';
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $core, $args ) {
			return new self( $core, $args );
		}

	}

}
