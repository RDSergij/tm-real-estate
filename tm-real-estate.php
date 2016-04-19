<?php
/**
 * Plugin Name: TM Real Estate
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
 */

/**
 * TemplateMonster real estate class plugin
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
	 * Default options
	 *
	 * @since 1.0.0
	 * @var   array
	 */
	private static $default_options = array();

	/**
	 * TM_REAL_ESTATE class constructor
	 */
	private function __construct() {

		// Set the constants needed by the plugin.
		$this->constants();

		// Load all models
		$this->load_models();

		// Require cherry core
		if ( ! class_exists( 'Cherry_Core' ) ) {
			require_once( TM_REAL_ESTATE_DIR . '/cherry-framework/cherry-core.php' );
		}

		// Add tm-re-property item shortcode
		add_shortcode( Model_Main::SHORT_CODE_PROPERTY, array( 'Model_Properties', 'shortcode_property_single' ) );

		// Add tm-re-property item shortcode
		add_shortcode( Model_Main::SHORT_CODE_CONTACT_FORM, array( 'Model_Properties', 'shortcode_contact_form' ) );

		// Add tm-re-properties shortcode
		add_shortcode( Model_Main::SHORT_CODE_PROPERTIES, array( 'Model_Properties', 'shortcode_properties' ) );

		// Add tm-submit-form shortcode
		add_shortcode( Model_Main::SHORT_CODE_SUBMISSION_FORM, array( 'Model_Submit_Form', 'shortcode_submit_form' ) );

		// Add tm-re-search-form shortcode
		add_shortcode( Model_Main::SHORT_CODE_SEARCH_FORM, array( 'Model_Properties', 'shortcode_search_form' ) );

		// Add tm-re-properties search result shortcode
		add_shortcode( Model_main::SHORT_CODE_SEARCH_RESULT, array( 'Model_Properties', 'shortcode_search_result' ) );

		// Add tm-re-agent-properties agent info shortcode
		add_shortcode( Model_main::SHORT_CODE_AGENT_PROPERTIES, array( 'Model_Properties', 'shortcode_agent_properties' ) );

		// Add tm-re-properties search result shortcode
		add_shortcode( Model_main::SHORT_CODE_MAP, array( 'Model_Properties', 'shortcode_map' ) );

		// Add tm-re-properties search result shortcode
		add_shortcode( 'TMRE_AgentContactForm', array( 'Model_Properties', 'shortcode_agent_contact_form' ) );

		// Scripts and Styles
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts_and_styles' ) );

		// Launch our plugin.
		add_action( 'after_setup_theme', array( $this, 'launch' ), 10 );

		// Set default data
		add_action( 'init', array( &$this, 'set_defaults' ) );

		// Get lat and lng
		add_action( 'save_post', array( &$this, 'save_meta' ) );

		// Custom assets
		add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );

		// Add ajax action
		add_action( 'wp_ajax_tm_property_settings_reset', array( $this, 'settings_reset' ) );
		add_action( 'wp_ajax_nopriv_tm_property_settings_reset', array( $this, 'settings_reset' ) );

		add_action( 'admin_init', array( 'Shortcode_Tinymce', 'tm_shortcode_button' ) );

		add_action( 'wp_ajax_tm_re_contact_form', array( $this, 'contact_form' ) );
		add_action( 'wp_ajax_nopriv_tm_re_contact_form', array( $this, 'contact_form' ) );

		add_action( 'wp_ajax_nopriv_submit_form', array( 'Model_Submit_Form', 'submit_form_callback' ) );
		add_action( 'wp_ajax_submit_form', array( 'Model_Submit_Form', 'submit_form_callback' ) );

		// Fix "View" link in row actions ( custom post type ) on table
		add_filter( 'post_row_actions', array( &$this, 'override_view' ), 10, 2 );

		// Fix "Preview" link in post edit page
		add_filter( 'preview_post_link', array( &$this, 'override_preview' ), 10, 2 );
	}

	/**
	 * Save additional taxonomy meta on edit or create tax
	 *
	 * @since  1.0.0
	 * @param  int    $post_id The ID of the current post being saved.
	 * @param  object $post    The post object currently being saved.
	 * @return void|int
	 */
	public function save_meta( $post_id, $post = '' ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! isset( $_POST['cherry-meta-nonce'] ) || ! wp_verify_nonce( $_POST['cherry-meta-nonce'], 'cherry-meta-nonce' ) ) {
			return;
		}

		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		if ( ! is_object( $post ) ) {
			$post = get_post();
		}

		if ( array_key_exists( 'address', $_POST ) ) {
			$lat_lng = Model_Properties::get_lat_lng( $_POST['address'] );
			update_post_meta( $post_id, 'lat', (float) $lat_lng[0] );
			update_post_meta( $post_id, 'lng', (float) $lat_lng[1] );
		}
	}

	/**
	 * Fix "view" link in property post type
	 *
	 * @param  [array]  $actions list.
	 * @param  [object] $post   Object.
	 * @return [array] actions list.
	 */
	public function override_view( $actions, $post ) {
		if ( 'property' == $post->post_type ) {
			$actions['view'] = sprintf(
				'<a href="%s?id=%s" title="View “%s”" rel="permalink">View</a>',
				Model_Settings::get_search_single_page(),
				$post->ID,
				esc_attr( $post->post_title )
			);
		}
		return $actions;
	}

	/**
	 * Fix "preview" link in page edit
	 *
	 * @param  [type] $preview_link url.
	 * @param  [type] $post         object.
	 * @return [string] fixes url.
	 */
	public function override_preview( $preview_link, $post ) {
		if ( 'property' == $post->post_type ) {
			$preview_link = sprintf( '%s?id=%s', Model_Settings::get_search_single_page(), $post->ID );
		}
		return $preview_link;
	}

	/**
	 * Add Scripts and Styles
	 */
	public function scripts_and_styles() {
		// Styles
		wp_enqueue_style( 'tm-real-estate', TM_REAL_ESTATE_URI.'assets/css/tm-real-estate.css' );
		wp_enqueue_script(
			'fileupload_process',
			TM_REAL_ESTATE_URI.'assets/js/locations.min.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
		wp_enqueue_script(
			'google_api',
			'https://maps.googleapis.com/maps/api/js?v=3.exp&#038;signed_in=true&#038;ver=1.0'
		);

		wp_enqueue_script(
			'page_items',
			TM_REAL_ESTATE_URI.'assets/js/property_items.js',
			array( 'jquery', 'google_api' ),
			'1.0.0',
			true
		);

		wp_enqueue_script(
			'jquery_ui_widget',
			plugins_url( 'tm-real-estate' ) . '/assets/js/uploader/vendor/jquery.ui.widget.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
		wp_enqueue_script(
			'load_image',
			plugins_url( 'tm-real-estate' ) . '/assets/js/uploader/load-image.all.min.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
		wp_enqueue_script(
			'canvas_to_blob',
			plugins_url( 'tm-real-estate' ) . '/assets/js/uploader/canvas-to-blob.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
		wp_enqueue_script(
			'iframe_transport',
			plugins_url( 'tm-real-estate' ) . '/assets/js/uploader/jquery.iframe-transport.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
		wp_enqueue_script(
			'fileupload',
			plugins_url( 'tm-real-estate' ) . '/assets/js/uploader/jquery.fileupload.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
		wp_enqueue_script(
			'fileupload_process',
			plugins_url( 'tm-real-estate' ) . '/assets/js/uploader/jquery.fileupload-process.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
		wp_enqueue_script(
			'fileupload_image',
			plugins_url( 'tm-real-estate' ) . '/assets/js/uploader/jquery.fileupload-image.js',
			array( 'jquery' ),
			'1.0.0',
			false
		);
		wp_enqueue_style(
			'tm-submit-form',
			plugins_url( 'tm-real-estate' ) . '/assets/css/tm-submit-form.css',
			array(),
			'1.0.0',
			'all'
		);

		wp_localize_script(
			'cherry-js-core',
			'formUrl',
			array(
				'url' => admin_url( 'admin-ajax.php' ),
			)
		);

	}

	/**
	 * Load plugin models
	 */
	public function load_models() {
		$models = array(
			'Model_Main',
			'Model_Properties',
			'Model_Settings',
			'Model_Submit_Form',
			'Model_Shortcode_Tinymce',
		);

		foreach ( $models as $model ) {
			if ( ! class_exists( $model ) ) {
				$path = 'models' . DIRECTORY_SEPARATOR . str_replace( '_', '-', strtolower( $model ) ) . '.php';
				require_once( $path );
			}
		}
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
		if ( null !== $this->core ) {
			return $this->core;
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
					'cherry-utility'	=> array(
						'priority'	=> 999,
						'autoload'	=> true,
					),
					'cherry-page-builder'	=> array(
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
							),
						),
					),
					'cherry-post-meta'	=> array(
						'priority'	=> 999,
						'autoload'	=> true,
						'args'      => array(
							'title' => __( 'Settings', 'cherry' ),
							'page'  => array( 'property' ),
							'fields' => array(
								'price' => array(
									'type'       => 'text',
									'id'         => 'price',
									'name'       => 'property_price',
									'value'      => 0,
									'left_label' => __( 'Price', 'tm-real-estate' ),
								),
								'status' => array(
									'type'       => 'select',
									'id'         => 'status',
									'name'       => 'status',
									'value'      => 'rent',
									'left_label' => __( 'Property status', 'tm-real-estate' ),
									'options'    => array(
										'rent' => __( 'Rent', 'tm-real-estate' ),
										'sale' => __( 'Sale', 'tm-real-estate' ),
									),
								),
								'bathrooms' => array(
									'type'       => 'number',
									'id'         => 'bathrooms',
									'name'       => 'bathrooms',
									'min_value'  => 0,
									'value'      => 0,
									'left_label' => __( 'Bathrooms', 'tm-real-estate' ),
								),
								'bedrooms' => array(
									'type'       => 'number',
									'id'         => 'bedrooms',
									'name'       => 'bedrooms',
									'min_value'  => 0,
									'value'      => 0,
									'left_label' => __( 'Bedrooms', 'tm-real-estate' ),
								),
								'area' => array(
									'type'       => 'number',
									'id'         => 'area',
									'name'       => 'area',
									'min_value'  => 0,
									'value'      => 0,
									'left_label' => __( 'Area', 'tm-real-estate' ),
								),
								'parking_places' => array(
									'type'       => 'number',
									'id'         => 'parking_places',
									'name'       => 'parking_places',
									'min_value'  => 0,
									'value'      => 0,
									'left_label' => __( 'Parking places', 'tm-real-estate' ),
								),
								'gallery' => array(
									'type'	  => 'collection',
									'id'      => 'gallery',
									'name'    => 'gallery',
									'left_label' => __( 'Gallery', 'tm-real-estate' ),
									'controls' => array(
										'UI_Text' => array(
											'type'    => 'text',
											'id'      => 'title',
											'class'   => 'large_text',
											'name'    => 'title',
											'value'   => '',
											'left_label' => __( 'Title', 'tm-real-estate' ),
										),
										'UI_Media' => array(
											'id'           => 'image',
											'name'         => 'image',
											'value'        => '',
											'multi_upload' => false,
											'left_label'   => __( 'Image', 'tm-real-estate' ),
										),
									),
								),
								'agent' => array(
									'type'        => 'select',
									'id'          => 'agent',
									'name'        => 'agent',
									'multiple'	  => false,
									'value'       => '',
									'left_label'  => __( 'Agent', 'tm-real-estate' ),
									'options'     => Model_Main::get_agents_options(),
								),
								'address' => array(
									'type'       => 'text',
									'id'         => 'address',
									'name'       => 'address',
									'value'      => '',
									'left_label' => __( 'Address', 'tm-real-estate' ),
								),
								'phone' => array(
									'type'       => 'text',
									'id'         => 'phone',
									'name'       => 'phone',
									'value'      => '',
									'left_label' => __( 'Phone', 'tm-real-estate' ),
								),
							),
						),
					),
					'cherry-post-types' => array(
						'priority'	=> 999,
						'autoload'	=> true,
					),
					'cherry-taxonomies' => array(
						'priority'	=> 999,
						'autoload'	=> true,
					),
					'cherry-widget-factory' => array(
						'priority'	=> 999,
						'autoload'	=> true,
					),
					'cherry-creator' => array(
						'priority'	=> 999,
						'autoload'	=> true,
					),
				),
			)
		);

		$this->add_admin_menu_page();
		$this->add_post_type();
		$this->add_user_role();
		$this->add_taxonomies();
		$this->add_widgets();
	}

	/**
	 * Contact form
	 */
	public function contact_form() {

		foreach ( $_POST as $key => $value ) {
			$data[ $key ] = sanitize_text_field( $value );
		}

		$data['email']			= sanitize_email( $data['email'] );
		$data['agent_id']		= (int) $data['agent_id'];
		$data['property_id']	= (int) $data['property_id'];

		$agent_data = get_userdata( $data['agent_id'] );

		$property_data = get_post( $data['property_id'] );

		$contact_form_settings = Model_Settings::get_contact_form_settings();

		$headers = 'From: ' . $data['name'] . ' <' . $data['email'] . '>' . "\r\n";
		$headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";

		$html = Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . 'views/mail.php',
			array(
				'message_data'	=> $data,
				'agent_data'	=> $agent_data,
				'property_data'	=> $property_data,
			)
		);

		$send = wp_mail(
			$agent_data->user_email,
			$contact_form_settings['mail-subject'],
			$html,
			$headers
		);
		wp_send_json(
			array(
				'result' => $send,
			)
		);
	}

	/**
	 * Add taxonomies to wp
	 * Add some widgets
	 */
	public function add_widgets() {
		// Require real estate search form widget
		if ( ! class_exists( 'TM_Real_Estate_Search_Form_Widget' ) ) {
			require_once( TM_REAL_ESTATE_DIR . '/widgets/tm-real-estate-search-form-widget.php' );
			register_widget( 'TM_Real_Estate_Search_Form_Widget' );
		}
	}

	/**
	 * Add taxonomies to wp
	 */
	public function add_taxonomies() {
		$this->core->modules['cherry-taxonomies']
				->create(
					'Type',
					'property',
					'Types'
				)
				->set_slug( 'property-type' )
				->init();

		$this->core->modules['cherry-taxonomies']
				->create(
					'Tag',
					'property',
					'Tags'
				)
				->set_arguments( array( 'hierarchical' => false ) )
				->set_slug( 'property-tag' )
				->init();
	}

	/**
	 * Registry terms and posts
	 *
	 * @since 1.0
	 * @return void
	 */
	public function set_defaults() {
		// Publish hidden properties from confirm email
		if ( array_key_exists( 'publish_hidden', $_GET ) ) {
			Model_Properties::publish_hidden( (int) $_GET['publish_hidden'] );
			wp_redirect( get_bloginfo( 'url' ) );
		}

		if ( Model_Settings::is_created() ) {
			return;
		}

		Model_Settings::create_settings();
	}

	/**
	 * Reset settings to default
	 *
	 * @return void
	 */
	public function settings_reset() {
		$this->core->modules['cherry-page-builder']->clear_sections();
		Model_Settings::create_settings();

		wp_send_json(
			array(
				'defaultOptions' => Model_Settings::get_default_options(),
				'pagesList'      => Model_Settings::get_page_list(),
				'debug'          => get_option( Model_Settings::SETTINGS_KEY ),
			)
		);
	}

	/**
	 * Add some admin menu
	 *
	 * @since 1.0
	 */
	public function add_admin_menu_page() {

		$button_reset = new UI_Text(
			array(
				'type'		=> 'button',
				'class'		=> 'button button-warning reset-default-page',
				'value'		=> __( 'Reset all settings', 'tm-real-estate' ),
				'master'	=> 'block-reset',
			)
		);

		$settings['tm-properties-main-settings'][] = array(
			'type'			=> 'select',
			'slug'			=> 'properties-list-page',
			'title'			=> __( 'Properties list page', 'tm-real-estate' ),
			'field'			=> array(
				'id'			=> 'properties-list-page',
				'size'			=> 1,
				'value'			=> '',
				'options'		=> Model_Settings::get_page_list(),
			),
		);

		$settings['tm-properties-main-settings'][] = array(
			'type'			=> 'select',
			'slug'			=> 'property-item-page',
			'title'			=> __( 'Property item page', 'tm-real-estate' ),
			'field'			=> array(
				'id'			=> 'property-item-page',
				'size'			=> 1,
				'value'			=> '',
				'options'		=> Model_Settings::get_page_list(),
			),
		);

		$settings['tm-properties-main-settings'][] = array(
			'type'			=> 'select',
			'slug'			=> 'properties-search-result-page',
			'title'			=> __( 'Search result page', 'tm-real-estate' ),
			'field'			=> array(
				'id'			=> 'properties-search-result',
				'size'			=> 1,
				'value'			=> '',
				'options'		=> Model_Settings::get_page_list(),
			),
		);

		$settings['tm-properties-main-settings'][] = array(
			'type'			=> 'select',
			'slug'			=> 'properties-submission-page',
			'title'			=> __( 'Submission property page', 'tm-real-estate' ),
			'field'			=> array(
				'id'			=> 'properties-submission-page',
				'size'			=> 1,
				'value'			=> '',
				'options'		=> Model_Settings::get_page_list(),
			),
		);

		$settings['tm-properties-main-settings'][] = array(
			'type'			=> 'select',
			'slug'			=> 'agent-properties-page',
			'title'			=> __( 'Agent properties page', 'tm-real-estate' ),
			'field'			=> array(
				'id'			=> 'agent-properties-page',
				'size'			=> 1,
				'value'			=> '',
				'options'		=> Model_Settings::get_page_list(),
			),
		);

		$settings['tm-properties-main-settings'][] = array(
			'type'			=> 'select',
			'slug'			=> 'area-unit',
			'title'			=> __( 'Area unit', 'tm-real-estate' ),
			'field'			=> array(
				'id'			=> 'area-unit',
				'size'			=> 1,
				'value'			=> 'feets',
				'options'		=> Model_Settings::get_area_unit(),
			),
		);

		$settings['tm-properties-main-settings'][] = array(
			'slug'	=> 'сurrency-sign',
			'title'	=> __( 'Currency sign', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'сurrency-sign',
				'value'			=> '$',
				'placeholder'	=> '$',
			),
		);

		$settings['tm-properties-contact-form'][] = array(
			'slug'	=> 'google-captcha-key',
			'title'	=> __( 'Google captcha key', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'google-captcha-key',
				'value'			=> '',
				'placeholder'	=> '',
			),
		);

		$settings['tm-properties-contact-form'][] = array(
			'slug'	=> 'mail-subject',
			'title'	=> __( 'Subject of email', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'mail-subject',
				'value'			=> '',
				'placeholder'	=> 'subject',
			),
		);

		$settings['tm-properties-contact-form'][] = array(
			'slug'	=> 'success-message',
			'title'	=> __( 'Success message', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'success-message',
				'value'			=> '',
				'placeholder'	=> 'successfully',
			),
		);

		$settings['tm-properties-contact-form'][] = array(
			'slug'	=> 'failed-message',
			'title'	=> __( 'Failed message', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'failed-message',
				'value'			=> '',
				'placeholder'	=> 'failed',
			),
		);

		$settings['tm-properties-submission-form'][] = array(
			'slug'	=> 'mail-subject',
			'title'	=> __( 'Subject of email', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'mail-subject',
				'value'			=> '',
				'placeholder'	=> 'subject',
			),
		);

		$settings['tm-properties-submission-form'][] = array(
			'slug'	=> 'success-message',
			'title'	=> __( 'Success message', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'success-message',
				'value'			=> '',
				'placeholder'	=> 'successfully',
			),
		);

		$settings['tm-properties-submission-form'][] = array(
			'slug'	=> 'failed-message',
			'title'	=> __( 'Failed message', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'failed-message',
				'value'			=> '',
				'placeholder'	=> 'failed',
			),
		);

		$settings['tm-properties-submission-form'][] = array(
			'slug'	=> 'confirmation-subject',
			'title'	=> __( 'Confirmation subject', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'confirmation-subject',
				'value'			=> '',
				'placeholder'	=> '',
			),
		);

		$settings['tm-properties-submission-form'][] = array(
			'slug'	=> 'confirmation-message',
			'title'	=> __( 'Confirmation message', 'tm-real-estate' ),
			'type'	=> 'text',
			'field'	=> array(
				'id'			=> 'confirmation-message',
				'value'			=> '',
				'placeholder'	=> '',
			),
		);

		$this->core->modules['cherry-page-builder']->make( 'cherry-property-settings', 'Settings', 'edit.php?post_type=property' )->set(
			array(
				'capability'	=> 'manage_options',
				'position'		=> 22,
				'icon'			=> 'dashicons-admin-site',
				'sections'		=> array(
					'tm-properties-main-settings' => array(
						'slug'			=> 'tm-properties-main-settings',
						'name'			=> __( 'Main', 'tm-real-estate' ),
						'description'	=> '',
					),

					'tm-properties-contact-form' => array(
						'slug'			=> 'tm-properties-contact-form',
						'name'			=> __( 'Contact form', 'tm-real-estate' ),
					),

					'tm-properties-submission-form' => array(
						'slug'			=> 'tm-properties-submission-form',
						'name'			=> __( 'Submission form', 'tm-real-estate' ),
					),
				),
				'settings'		=> $settings,
				'button_after'	=> $button_reset->render(),
			)
		);
	}

	/**
	 * Include assets files
	 *
	 * @since 1.0
	 * @return void
	 */
	public function assets() {

		wp_enqueue_script(
			'tm-real-state-settings-page',
			plugins_url( 'tm-real-estate' ) . '/assets/js/page-settings.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_localize_script( 'tm-real-state-settings-page', 'TMPageSettings', array(
			'ajaxurl'				=> admin_url( 'admin-ajax.php' ),
			'shortcodes'			=> Model_Main::get_shortcodes(),
			'shortcodes_views'		=> Shortcode_Tinymce::tm_shortcode_view(),
			'resetMessage'			=> __( 'Settings have been reseted' ),
			'errorMessage'			=> __( 'Something is wrong!' ),
			'confirmResetMessage'	=> __( 'Are you sure?' ),
		) );

		wp_enqueue_style(
			'tm-real-state-settings-page',
			plugins_url( 'tm-real-estate' ) . '/assets/css/page-settings.min.css',
			array(),
			'3.3.0',
			'all'
		);
	}

	/**
	 * Add property post type
	 */
	public function add_post_type() {
		$this->core->modules['cherry-post-types']->create(
			'property',
			'Properties',
			'Property',
			array(
				'supports' => array(
					'title',
					'editor',
					'author',
					'thumbnail',
					'excerpt',
					'comments',
				),
			)
		)->font_awesome_icon( 'f1ad' );
	}

	/**
	 * Add RE Agent role
	 *
	 * @return  WP_Role / NULL
	 */
	public function add_user_role() {
		return add_role(
			're_agent',
			__( 'RE Agent', 'tm-real-estate' ),
			array(
				'read'              => true, // true allows this capability
				'edit_posts'        => true, // Allows user to edit their own posts
				'edit_pages'        => true, // Allows user to edit pages
				'edit_others_posts' => true, // Allows user to edit others posts not just their own
				'create_posts'      => true, // Allows user to create new posts
				'manage_categories' => true, // Allows user to manage post categories
				'publish_posts'     => true, // Allows the user to publish, otherwise posts stays in draft mode
				'edit_themes'       => false, // false denies this capability. User can’t edit your theme
				'install_plugins'   => false, // User cant add new plugins
				'update_plugin'     => false, // User can’t update any plugins
				'update_core'       => false, // user cant perform core updates
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
