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

if ( ! class_exists( 'Cherry_Page_Builder' ) ) {

	/**
	 * Post meta management module
	 */
	class Cherry_Page_Builder {

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
		public $module_slug = 'cherry-page-builder';

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
		 * The page properties.
		 *
		 * @var DataContainer
		 */
		public $views;

		/**
		 * The page sections.
		 *
		 * @var array
		 */
		protected $sections;

		/**
		 * The page settings.
		 *
		 * @var array
		 */
		protected $settings;

		/**
		 * Constructor for the module
		 */
		function __construct( $core, $args = array() ) {

			$this->core = $core;
			$this->args = wp_parse_args( $args, array(
				'capability'	=> 'manage_options',
				'position'      => 20,
				'icon'			=> 'dashicons-admin-site',
				'sections'      => array(),
				'settings'      => array(),
			) );

			$this->views = $this->core->get_core_dir() . 'modules/' . $this->module_slug . '/views/';
			add_action('admin_enqueue_scripts', array( $this, 'assets') );
		}

		/*
		 * Add admin menu page
		 */
		function add_admin_page() {
			$page = $this->make( $this->args['slug'], $this->args['title'], $this->args['parent'], $this->args['views'] )->set( array(
					'capability'    => $this->args['capability'],
					'icon'          => $this->args['icon'],
					'position'      => $this->args['position'],
					'tabs'          => $this->args['tabs'],
					'sections'      => $this->args['sections'],
					'settings'      => $this->args['settings'],
				));
			$page->add_sections( $this->args['sections'] );
			$page->add_settings( $this->args['settings'] );
		}

		/**
		 * @param string $slug The page slug name.
		 * @param string $title The page display title.
		 * @param string $parent The parent's page slug if a subpage.
		 * @param IRenderable $view The page main view file.
		 * @throws PageException
		 * @return \Themosis\Page\PageBuilder
		 */
		public function make( $slug, $title, $parent = null ) {
			$page = new Cherry_Page_Builder( $this->core, $this->args );
			$params = compact('slug', 'title');

			foreach ( $params as $name => $param ) {
				if ( ! is_string( $param ) ) {
					throw new PageException( 'Invalid page parameter " ' . $name . ' " ' );
				}
			}

			// Set the page properties.
			$page->data['slug'] = $slug;
			$page->data['title'] = $title;
			$page->data['parent'] = $parent;
			$page->data['args'] = [
				'capability'    => 'manage_options',
				'icon'          => '',
				'position'      => null,
				'tabs'          => true,
				'menu'          => $title
			];
			$page->data['rules'] = [];

			return $page;
		}

		/**
		 * Set the custom page. Allow user to override
		 * the default page properties and add its own
		 * properties.
		 *
		 * @param array $params
		 * @return \Themosis\Page\PageBuilder
		 */
		public function set( array $params = array() ) {
			$this->args = $params;
	
			$this->add_sections( $params['sections'] );
			$this->add_settings( $params['settings'] );

			add_action('admin_menu', array( $this, 'build' ) );

			return $this;
		}

		/**
		 * Triggered by the 'admin_menu' action event.
		 * Register/display the custom page in the WordPress admin.
		 *
		 * @return void
		 */
		public function build() {
			if ( ! is_null( $this->data['parent'] ) ) {
				add_submenu_page( $this->data['parent'], $this->data['title'], $this->data['args']['menu'], $this->data['args']['capability'], $this->data['slug'], array($this, 'render'));
			} else {
				add_menu_page( $this->data['title'], $this->data['args']['menu'], $this->data['args']['capability'], $this->data['slug'], array($this, 'render'), $this->data['args']['icon'], $this->data['args']['position']);
			}
		}

		/**
		 * Triggered by the 'add_menu_page' or 'add_submenu_page'.
		 *
		 * @return void
		 */
		public function render() {
			$title		= $this->data['title'];
			$page_slug	= $this->data['slug'];
			$sections	= $this->sections;

			ob_start();
			include( $this->views . 'page.php' );
			$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}

		/**
		 * Add custom sections for your settings.
		 *
		 * @param array $sections
		 * @return \Themosis\Page\PageBuilder
		 */
		public function add_sections( array $sections = array() ) {
			$this->sections = $sections;
		}

		/**
		 * Check if the page has sections.
		 *
		 * @return bool
		 */
		public function has_sections()
		{
			return count($this->sections) ? true : false;
		}

		/**
		 * Check if the page has settings.
		 *
		 * @return bool
		 */
		public function has_settings()
		{
			return count($this->settings) ? true : false;
		}

		/**
		 * Add settings to the page. Define settings per section
		 * by setting the 'key' name equal to a registered section and
		 * pass it an array of 'settings' fields.
		 *
		 * @param array $settings The page settings.
		 * @return \Themosis\Page\PageBuilder
		 */
		public function add_settings( array $settings = array() )
		{
			$this->settings = $settings;

			add_action('admin_init', array( $this, 'install_settings' ) );

			return $this;
		}

		/**
		 * Triggered by the 'admin_init' action.
		 * Perform the WordPress settings API.
		 *
		 * @return void
		 */
		public function install_settings()
		{
			foreach ( $this->sections as $section ) {
				if ( false === get_option( $section['slug'] ) ) {
					add_option( $section['slug'] );
				}
				add_settings_section( $section['slug'], $section['name'], array( $this, 'display_sections' ), $section['slug'] );
			}

			if ( $this->has_settings() ) {
				foreach ( $this->settings as $section => $settings ) {
					foreach( $settings as &$setting) {
						$setting['section'] = $section;
						add_settings_field( $section . '-' . $setting['slug'], $setting['title'], array( $this, 'display_settings' ), $section, $section, $setting);
						register_setting( $section, $section . '-' . $setting['slug'] );
					}
				}
			}
		}

		/**
		 * Handle section display of the Settings API.
		 *
		 * @param array $args
		 * @return void
		 */
		public function display_sections( array $args ) {
			$description = '';
			if ( ! empty( $this->sections[ $args['id'] ] ) ) {
				if ( ! empty( $this->sections[ $args['id'] ]['description'] ) ) {
					$description = $this->sections[ $args['id'] ]['description'];
				}
			}
			ob_start();
			include( $this->views . 'section.php' );
			$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}

		/**
		 * Handle setting display of the Settings API.
		 *
		 * @param mixed $setting
		 * @return void
		 */
		public function display_settings( $setting ) {

			// Check if a registered value exists.
			$value = get_option( $setting['section'] . '-' . $setting['slug'] );

			if ( isset( $value ) ) {
				$setting['field']['value'] = $value;
			} else {
				$setting['field']['value'] = '';
			}

			// Set the name attribute.
			$setting['field']['name'] = $setting['section'] . '-' . $setting['slug'];

			if ( class_exists( 'UI_' . ucfirst( $setting['type'] ) ) ) {
				$ui_class = 'UI_' . ucfirst( $setting['type'] );
				$ui_element = new $ui_class( $setting['field'] );

				// Display the field.
				echo $ui_element->render();
			}
		}

		/**
		 * Add styles and scripts
		 *
		 * @return void
		 */
		public function assets() {
			wp_enqueue_script( 'jquery-ui-tabs' );
			wp_enqueue_script( 'jquery-form' );

			wp_localize_script( 'cherry-settings-page', 'TMRealEstateMessage', array(
								'success' => __( 'Successfully', 'tm-real-estate' ),
								'failed' => __( 'Failed', 'tm-real-estate' ),
							) );

			wp_enqueue_script(
				'cherry-settings-page',
				$this->core->get_core_url() . 'modules/' . $this->module_slug . '/assets/js/custom.min.js',
				array( 'jquery' ),
				'0.2.0',
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
