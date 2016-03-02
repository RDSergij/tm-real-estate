<?php
/**
 * Plugin Name: TM Facebook Page Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Show twitter timeline of user
 * Version: 1.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package Monster_Facebook_Page_Widget
 *
 * @since 1.1
 */

/**
 * Adds Monster_Facebook_Page_Widget widget.
 */
class Monster_Facebook_Page_Widget extends WP_Widget{

	/**
	 * App id
	 *
	 * @var type integer
	 */
	var $app_id;

	/**
	 * Default settings
	 *
	 * @var type array
	 */
	private $instance_default = array();

	/**
	 * Tabs list
	 *
	 * @var type array
	 */
	private $tabs = array();

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'monster_facebook_page_widget',
			__( 'Monster Facebook page widget', 'blogetti' ),
			array( 'description' => __( 'Facebook page Widget', 'blogetti' ) )
		);

		// Set default settings
		$this->instance_default = array(
			'title'				=> '',
			'app_id'			=> '',
			'page_title'		=> '',
			'facebook_url'		=> '',
			'tabs'				=> '',
			'width'				=> '',
			'height'			=> '',
			'small_header'		=> 'false',
			'adaptive_width'	=> 'false',
			'hide_cover'		=> 'false',
			'freinds_face'		=> 'true',
		);

		$this->tabs = array( 'none' => 'none', 'timeline' => 'timeline', 'messages' => 'messages', 'events' => 'events' );
	}

	/**
	 * Add facebook sdk to footer
	 *
	 * @since 1.0
	 */
	public function add_facebook_sdk() {
		echo View::make(
			'widgets/front-end/facebook-sdk',
			array(
				'app_id'		=> $this->app_id,
			)
		);
	}

	/**
	 * Frontend view
	 *
	 * @param type $args array.
	 * @param type $instance array.
	 */
	public function widget( $args, $instance ) {

		// Add html to footer
		$this->app_id = Utils::array_get( $instance, 'app_id' );
		add_action( 'wp_footer', array( $this, 'add_facebook_sdk' ), 100 );

		echo View::make(
			'widgets/front-end/facebook-page',
			array(
				'before_widget'		=> $args['before_widget'],
				'before_title'		=> $args['before_title'],
				'after_title'		=> $args['after_title'],
				'after_widget'		=> $args['after_widget'],
				'title'				=> Utils::array_get( $instance, 'title' ),
				'page_title'		=> Utils::array_get( $instance, 'page_title' ),
				'facebook_url'		=> Utils::array_get( $instance, 'facebook_url' ),
				'tabs'				=> Utils::array_get( $instance, 'tabs' ),
				'width'				=> Utils::array_get( $instance, 'width' ),
				'height'			=> Utils::array_get( $instance, 'height' ),
				'small_header'		=> Utils::array_get( $instance, 'small_header' ),
				'adaptive_width'	=> Utils::array_get( $instance, 'adaptive_width' ),
				'hide_cover'		=> Utils::array_get( $instance, 'hide_cover' ),
				'freinds_face'		=> Utils::array_get( $instance, 'freinds_face' ),
			)
		);
	}

	/**
	 * Admin view
	 *
	 * @param type $instance array.
	 */
	public function form( $instance ) {

		$title_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'title' ),
					'name'			=> $this->get_field_name( 'title' ),
					'value'			=> Utils::array_get( $instance, 'title' ),
					'placeholder'	=> __( 'Widget title', 'blogetti' ),
					'label'			=> __( 'Title', 'blogetti' ),
				)
		);
		$title_html = $title_field->output();

		$app_id_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'app_id' ),
					'name'			=> $this->get_field_name( 'app_id' ),
					'value'			=> Utils::array_get( $instance, 'app_id' ),
					'placeholder'	=> __( 'app id', 'blogetti' ),
				)
		);
		$app_id_html = $app_id_field->output();

		$app_id_tooltip = new UI_Tooltip_Fox(
				array(
					'direction'			=> 'bottom',
					'title'				=> __( 'Facebook application ID', 'blogetti' ),
					'description'		=> '<a href="https://developers.facebook.com/quickstarts/?platform=web" target="_blank">'
											. __( 'Link to facebook developers page.', 'blogetti' )
											. '</a>'
											. __( ' You can press  "Skip and Create App ID" ', 'blogetti' ),
				)
		);
		$app_id_tooltip_html = $app_id_tooltip->output();

		$page_title_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'page_title' ),
					'name'			=> $this->get_field_name( 'page_title' ),
					'value'			=> Utils::array_get( $instance, 'page_title' ),
					'placeholder'	=> __( 'page title', 'blogetti' ),
					'label'			=> __( 'Facebook page title', 'blogetti' ),
				)
		);
		$page_title_html = $page_title_field->output();

		$facebook_url_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'facebook_url' ),
					'name'			=> $this->get_field_name( 'facebook_url' ),
					'value'			=> Utils::array_get( $instance, 'facebook_url' ),
					'placeholder'	=> __( 'url', 'blogetti' ),
					'label'			=> __( 'Facebook page url', 'blogetti' ),
				)
		);
		$facebook_url_html = $facebook_url_field->output();

		$tabs_field = new UI_Select_Fox(
				array(
					'id'				=> $this->get_field_id( 'tabs' ),
					'name'				=> $this->get_field_name( 'tabs' ),
					'default'			=> Utils::array_get( $instance, 'tabs' ),
					'options'			=> $this->tabs,
				)
		);
		$tabs_html = $tabs_field->output();

		$width_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'width' ),
					'name'			=> $this->get_field_name( 'width' ),
					'value'			=> Utils::array_get( $instance, 'width' ),
					'placeholder'	=> __( 'width', 'blogetti' ),
					'label'			=> __( 'Width', 'blogetti' ),
				)
		);
		$width_html = $width_field->output();

		$height_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'height' ),
					'name'			=> $this->get_field_name( 'height' ),
					'value'			=> Utils::array_get( $instance, 'height' ),
					'placeholder'	=> __( 'height', 'blogetti' ),
					'label'			=> __( 'Height', 'blogetti' ),
				)
		);
		$height_html = $height_field->output();

		$small_header_field = new UI_Switcher_Fox(
				array(
					'id'        => $this->get_field_id( 'small_header' ),
					'class'     => 'pull-right',
					'name'      => $this->get_field_name( 'small_header' ),
					'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
					'default'   => Utils::array_get( $instance, 'small_header' ),
				)
		);
		$small_header_html = $small_header_field->output();

		$adaptive_width_field = new UI_Switcher_Fox(
				array(
					'id'        => $this->get_field_id( 'adaptive_width' ),
					'class'     => 'pull-right',
					'name'      => $this->get_field_name( 'adaptive_width' ),
					'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
					'default'   => Utils::array_get( $instance, 'adaptive_width' ),
				)
		);
		$adaptive_width_html = $adaptive_width_field->output();

		$hide_cover_field = new UI_Switcher_Fox(
				array(
					'id'        => $this->get_field_id( 'hide_cover' ),
					'class'     => 'pull-right',
					'name'      => $this->get_field_name( 'hide_cover' ),
					'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
					'default'   => Utils::array_get( $instance, 'hide_cover' ),
				)
		);
		$hide_cover_html = $hide_cover_field->output();

		$freinds_face_field = new UI_Switcher_Fox(
				array(
					'id'        => $this->get_field_id( 'freinds_face' ),
					'class'     => 'pull-right',
					'name'      => $this->get_field_name( 'freinds_face' ),
					'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
					'default'   => Utils::array_get( $instance, 'freinds_face' ),
				)
		);
		$freinds_face_html = $freinds_face_field->output();

		echo View::make(
			'widgets/back-end/facebook-page',
			array(
				'title_html'			=> $title_html,
				'app_id_html'			=> $app_id_html,
				'app_id_tooltip_html'	=> $app_id_tooltip_html,
				'page_title_html'		=> $page_title_html,
				'facebook_url_html'		=> $facebook_url_html,
				'tabs_html'				=> $tabs_html,
				'width_html'			=> $width_html,
				'height_html'			=> $height_html,
				'small_header_html'		=> $small_header_html,
				'adaptive_width_html'	=> $adaptive_width_html,
				'hide_cover_html'		=> $hide_cover_html,
				'freinds_face_html'		=> $freinds_face_html,
			)
		);
	}

	/**
	 * Update settings
	 *
	 * @param type $new_instance array.
	 * @param type $old_instance array.
	 * @return type array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		foreach ( $this->instance_default as $key => $value ) {
			$instance[ $key ] = ! empty( $new_instance[ $key ] ) ? $new_instance[ $key ] : $value;
		}

		return $instance;
	}
}
