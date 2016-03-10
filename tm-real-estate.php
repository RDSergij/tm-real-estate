<?php
/**
 * Plugin Name: TM Real Estate
<<<<<<< HEAD
 * Description: 
 * Version: 1.0
 * Author: Guriev Eugen and Serhii Osadchyi
 * Author URI: http://www.templatemonster.com/
 * License: GPLv2 or later
 * Text Domain: tm-real-estate
=======
 * Plugin URI:  http://www.templatemonster.com/
 * Description: Plugin for adding real estate functionality to the site.
 * Version:     1.0.0
 * Author:      Guriev Eugen & Sergyj Osadchij
 * Author URI:  http://www.templatemonster.com/
 * Text Domain: tm-real-estate
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 *
 * @package  TM Real Estate
 * @author   Guriev Eugen & Sergyj Osadchij
 * @license  GPL-2.0+
>>>>>>> master
 */

class TM_Real_Estate {

	/**
	 * A reference to an instance of this class.
	 * Singleton pattern implementation.
	 * 
	 * @since 1.0.0
	 * @var   object
	 */
	private static $instance = null;

	/**
	 * A reference to an instance of cherry framework core class.
	 *
	 * @since 1.0.0
	 * @var   object
	 */
	private $core = null;

	/**
	 * TM_REAL_ESTATE class constructor
	 */
	private function __construct() {
		// Set the constants needed by the plugin.
		add_action( 'plugins_loaded', array( $this, 'constants' ), 0 );

		// Launch our plugin.
		add_action( 'after_setup_theme', array( $this, 'launch' ), 10 );
	}

	/**
	 * Defines constants for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function constants() {
		/*
		 * Set constant path to the plugin directory.
		 *
		 * @since 1.0.0
		 */
		define( 'TM_REAL_ESTATE_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

		/**
		 * Set constant path to the plugin URI.
		 *
		 * @since 1.0.0
		 */
		define( 'TM_REAL_ESTATE_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
	}

	/**
	 * Loads the core functions. These files are needed before loading anything else in the
	 * theme because they have required functions for use.
	 *
	 * @since  1.0.0
	 */
	public function launch() {
		if ( is_admin() ) {
			if ( null !== $this->core ) {
				return $this->core;
			}

			if ( ! class_exists( 'Cherry_Core' ) ) {
				require_once( TM_REAL_ESTATE_DIR . '/cherry-framework/cherry-core.php' );
			}

			$this->core = new Cherry_Core(
				array(
					'base_dir'	=> TM_REAL_ESTATE_DIR . 'cherry-framework',
					'base_url'	=> TM_REAL_ESTATE_URI . 'cherry-framework',
					'modules'	=> array(
						'cherry-js-core'	=> array(
							'priority'	=> 999,
							'autoload'	=> true,
						),
						'cherry-post-meta'	=> array(
							'priority'	=> 999,
							'autoload'	=> true,
						),
						'cherry-admin-menu'	=> array(
							'priority'	=> 999,
							'autoload'	=> true,
						),
						'cherry-ui-elements' => array(
							'priority'	=> 999,
							'autoload'	=> true,
							'args'		=> array(
								'ui_elements' => array(
									'text',
									'select',
									'switcher',
								),
							),
						),
					),
				)
			);
			$this->add_metaboxes();

			$this->add_admin_menu_page();
		}
	}

	/*
	 * Add some admin menu
	 */
	public function add_admin_menu_page() {

		$sections = array(

			'section-slug-name' => array(
				'slug'			=> 'section-slug-name',
				'name'			=> 'Section Title',
				'description'	=> 'This is description',
			),

			'section-slug-name-2' => array(
				'slug'	=> 'section-slug-name-2',
				'name'	=> 'Section Title 2',
			),

		);

		$settings['section-slug-name'][] = array(
				'slug'	=> 'interest',
				'title'	=> 'Settings Title',
				'type'			=> 'text',
				'field'	=> array(
						'type'			=> 'text',
						'id'			=> 'title',
						'name'			=> 'title',
						'placeholder'	=> 'placeholder text',
					),
			);

		$settings['section-slug-name'][] = array(
				'slug'	=> 'interest-2',
				'title'	=> 'Title',
				'type'	=> 'text',
				'field'	=> array(
						'id'			=> 'about',
						'name'			=> 'about',
						'value'			=> 'about value',
						'placeholder'	=> 'placeholder about',
						'label'			=> 'about',
					),
			);

		$settings['section-slug-name-2'][] = array(
				'slug'	=> 'field-switcher',
				'title'	=> 'Switcher',
				'type'				=> 'switcher',
				'field'	=> array(
						'id'				=> 'test-switcher',
						'name'				=> 'test-switcher',
						'value'				=> 'true',
						'toggle'			=> array(
							'true_toggle'	=> 'On',
							'false_toggle'	=> 'Off',
							'true_slave'	=> '',
							'false_slave'	=> ''
						),
						'style'				=> 'normal',
					),
			);

		$settings['section-slug-name-2'][] = array(
						'type'			=> 'select',
						'slug'			=> 'Select',
						'title'			=> null,
						'field'			=> array(
							'id'			=> 'select',
							'name'			=> 'select',
							'multiple'		=> false,
							'filter'		=> true,
							'size'			=> 1,
							'value'			=> 'select-8',
							'options'		=> array(
								'select-1'	=> 'select 1',
								'select-2'	=> 'select 2',
								'select-3'	=> 'select 3',
								'select-4'	=> 'select 4',
								'select-5'	=> 'select 5',
							),
						),
			);

		$page = new Cherry_Admin_Menu( $this->core, array(
					'slug'          => 'cherry-admin-page',
					'title'         => 'Cherry Admin Page',
					'parent'		=> null,
					'capability'	=> 'manage_options',
					'position'      => 20,
					'icon'			=> 'dashicons-admin-site',
					'callback_view' => false,
					'sections'      => $sections,
					'settings'      => $settings,
					'tabs'          => true,
				)
			);
		$page->add_admin_page();

		$page2 = new Cherry_Admin_Menu( $this->core, array(
					'slug'          => 'cherry-sub-admin-page',
					'title'         => 'Cherry Sub Page',
					'parent'		=> 'cherry-admin-page',
					'capability'	=> 'manage_options',
					'position'      => 20,
					'icon'			=> 'envalve',
					'callback_view' => false,
					'sections'      => array(),
					'tabs'          => true,
				)
			);
		$page2->add_admin_page();
	}

	/**
	 * Add some metaboxes
	 */
	public function add_metaboxes() {
		$meta = new Cherry_Post_Meta(
			$this->core,
			array(
				'title' => 'some title',
				'fields' => array(
					'name_checkbox' => array(
						'type'    => 'select',
						'id'      => 'amaid',
						'name'    => 'theme_sidebar[oh-yeah]',
						'value'   => 1,
						'options' => array( 
							'' => __( 'Sidebar not selected', 'cherry-sidebar-manager' ),
							1 => 'some shit'
						),
					)
				)
			)
		);
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

TM_Real_Estate::get_instance();

