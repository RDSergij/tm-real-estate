<?php
/**
 * Plugin Name:  TM About Author Widget
 * Widget URI: https://github.com/RDSergij/tm-about-author-widget
 * Description: About author widget
 * Version: 1.1
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package Monster_About_Author_Widget
 *
 * @since 1.1
 */

/**
 * Adds Monster_About_Author_Widget widget.
 */
class Monster_About_Author_Widget extends WP_Widget {

	/**
	 * Default settings
	 *
	 * @var type array
	 */
	private $instance_default = array();
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'monster_about_author_widget', // Base ID
			__( 'Monster About Author Widget', 'blogetti' ),
			array( 'description' => __( 'About author widget', 'blogetti' ) )
		);
		// Set default settings
		$this->instance_default = array(
			'title'		=> __( '', 'blogetti' ),
			'user_id'	=> 1,
			'image'		=> '',
			'text_link'	=> __( 'Read more', 'blogetti' ),
			'url'		=> '',
		);

		// disable WordPress sanitization to allow more than just $allowedtags from /wp-includes/kses.php
		remove_filter( 'pre_user_description', 'wp_filter_kses' );
		// add sanitization for WordPress posts
		add_filter( 'pre_user_description', 'wp_filter_post_kses' );
	}

	/**
	 * Frontend view
	 *
	 * @param type $args array.
	 * @param type $instance array.
	 *
	 * @since 1.1
	 */
	public function widget( $args, $instance ) {

		foreach ( $this->instance_default as $key => $value ) {
			$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
		}

		$user_info = get_userdata( $instance['user_id'] );

		if ( ! empty( $user_info->user_email ) ) {
			$gravatar_url = get_avatar_url( $user_info->user_email, array( 'size' => 512 ) );

			if ( ! empty( $instance['image'] ) ) {
				$src = wp_get_attachment_image_src ( $instance['image'], 'minisquare' );
				$main_avatar = $src[0];
			} elseif ( ! empty( $gravatar_url ) ) {
				$main_avatar = $gravatar_url;
			}

			echo View::make(
				'widgets/front-end/about-author',
				array(
					'before_widget' => $args['before_widget'],
					'before_title'  => $args['before_title'],
					'after_title'   => $args['after_title'],
					'after_widget'  => $args['after_widget'],
					'title'         => Utils::array_get( $instance, 'title' ),
					'avatar_id'		=> Utils::array_get( $instance, 'image' ),
					'avatar'		=> $main_avatar,
					'name'          => $user_info->display_name,
					'description'   => $user_info->description,
					'url'           => Utils::array_get( $instance, 'url' ),
					'text_link'     => Utils::array_get( $instance, 'text_link' ),
				)
			);
		}
	}

	/**
	 * Include admin assets
	 *
	 * @since 1.0
	 */
	public function admin_assets() {
		wp_enqueue_media();

		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'thickbox' );

		// Custom styles
		wp_register_style( 'tm-about-author-admin', Utils::assets_url() . '/css/about-author-widget-admin.min.css' );
		wp_enqueue_style( 'tm-about-author-admin' );

		// Custom script
		wp_register_script( 'tm-about-author-admin', Utils::assets_url() . '/js/about-author-widget-admin.min.js', array( 'jquery' ) );
		wp_localize_script(
			'tm-about-author-admin',
			'TMAboutAuthorWidgetParam',
			array(
				'image'   => $this->get_field_id( 'image' ),
				'avatar'   => $this->get_field_id( 'avatar' ),
				'site_url' => home_url()
			)
		);
		wp_enqueue_script( 'tm-about-author-admin' );

		wp_enqueue_style( 'thickbox' );
	}

	/**
	 * Create admin form for widget
	 *
	 * @param type $instance array.
	 * @since 1.1
	 */
	public function form( $instance ) {

		$this->admin_assets();

		$title_field = new UI_Input_Fox(
			array(
				'id'			=> $this->get_field_id( 'title' ),
				'name'			=> $this->get_field_name( 'title' ),
				'value'			=> Utils::array_get( $instance, 'title' ),
				'placeholder'	=> __( 'New title', 'blogetti' ),
				'label'			=> __( 'Title widget', 'blogetti' ),
			)
		);
		$title_html = $title_field->output();

		$users_list = get_users();
		foreach ( $users_list as $user ) {
			$users[ $user->ID ] = $user->display_name;
		}

		$users_field = new UI_Select_Fox(
			array(
				'id'				=> $this->get_field_id( 'user_id' ),
				'name'				=> $this->get_field_name( 'user_id' ),
				'default'			=> Utils::array_get( $instance, 'user_id' ),
				'options'			=> $users,
			)
		);
		$users_html = $users_field->output();

		$url_field = new UI_Input_Fox(
			array(
				'id'			=> $this->get_field_id( 'url' ),
				'name'			=> $this->get_field_name( 'url' ),
				'value'			=> Utils::array_get( $instance, 'url' ),
				'placeholder'	=> __( 'detail url', 'blogetti' ),
				'label'			=> __( 'Detail url', 'blogetti' ),
			)
		);
		$url_html = $url_field->output();

		$text_link_field = new UI_Input_Fox(
			array(
				'id'			=> $this->get_field_id( 'text_link' ),
				'name'			=> $this->get_field_name( 'text_link' ),
				'value'			=> Utils::array_get( $instance, 'text_link' ),
				'placeholder'	=> __( 'link text', 'blogetti' ),
				'label'			=> __( 'Link text', 'blogetti' ),
			)
		);
		$text_link_html = $text_link_field->output();

		$upload_file_field = new UI_Input_Fox(
			array(
				'id'			=> $this->get_field_id( 'upload_image_button' ),
				'class'			=> 'upload_avatar_button button-image',
				'type'			=> 'button',
				'name'			=> $this->get_field_name( 'upload_image_button' ),
				'value'			=> __( 'Upload image', 'blogetti' ),
			)
		);
		$upload_html = $upload_file_field->output();

		$image_url_field = new UI_Input_Fox(
			array(
				'id'			=> $this->get_field_id( 'image' ),
				'class'			=> ' custom-image-url',
				'type'			=> 'hidden',
				'name'			=> $this->get_field_name( 'image' ),
				'value'			=> Utils::array_get( $instance, 'image' ),
			)
		);
		$image_html = $image_url_field->output();

		$delete_image_url_field = new UI_Input_Fox(
			array(
				'id'			=> $this->get_field_id( 'delete_image' ),
				'class'			=> 'delete_image_url button-image',
				'type'			=> 'button',
				'name'			=> $this->get_field_name( 'delete_image' ),
				'value'			=> __( 'Delete image', 'blogetti' ),
			)
		);
		$delete_image_html = $delete_image_url_field->output();

		$user_info = get_userdata( Utils::array_get( $instance, 'user_id' ) );

		$default_avatar = Utils::assets_url() . '/images/default-avatar.png';
		$image = Utils::array_get( $instance, 'image', null );
		if ( ! empty( $image ) ) {
			$src = wp_get_attachment_image_src ( $image, 'minisquare' );
			$main_avatar = $src[0];
		} else {
			$main_avatar = $default_avatar;
		}

		echo View::make(
			'widgets/back-end/about-author',
			array(
				'title_html'		=> $title_html,
				'users_html'		=> $users_html,
				'url_html'			=> $url_html,
				'text_link_html'	=> $text_link_html,
				'upload_html'		=> $upload_html,
				'delete_image_html'	=> $delete_image_html,
				'image_html'		=> $image_html,
				'avatar_id'			=> $this->get_field_id( 'avatar' ),
				'default_image'		=> $default_avatar,
				'avatar'			=> $main_avatar,
				'is_avatar'			=> ( (boolean) ! empty( $image ) ),
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
