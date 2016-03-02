<?php
/**
 * Plugin Name: TM Image Grid Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Image grid widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package Monster_Image_Grid_Widget
 *
 * @since 1.1
 */

/**
 * Adds register_tm_image_grid widget.
 */
class Monster_Image_Grid_Widget extends WP_Widget {

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
			'Monster_Image_Grid_Widget', // Base ID
			__( 'Monster Image Grid Widget', 'blogetti' ),
			array( 'description' => __( 'Image grid widget', 'blogetti' ) )
		);
		// Set default settings
		$this->instance_default = array(
			'title'				=> __( 'List', 'blogetti' ),
			'categories'		=> 0,
			'tags'				=> 0,
			'cols_count'		=> 3,
			'posts_count'		=> 6,
			'posts_offset'		=> 0,
			'title_length'		=> 20,
			'padding'			=> 0,
		);
	}

	/**
	 * Include frontend assets
	 *
	 * @since 1.0
	 */
	public function frontend_assets() {
		// Custom styles
		wp_register_style( 'tm-image-grid-frontend', Utils::assets_url() . 'css/image-grid-widget-frontend.min.css' );
		wp_enqueue_style( 'tm-image-grid-frontend' );
	}

	/**
	 * Frontend view
	 *
	 * @param type $args array.
	 * @param type $instance array.
	 */
	public function widget( $args, $instance ) {

		foreach ( $this->instance_default as $key => $value ) {
			$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
		}

		// Include assets
		$this->frontend_assets();

		echo View::make(
			'/widgets/front-end/image-grid',
			array(
				'before_widget' => $args['before_widget'],
				'before_title'  => $args['before_title'],
				'after_title'   => $args['after_title'],
				'after_widget'  => $args['after_widget'],
				'title'         => Utils::array_get( $instance, 'title' ),
				'cols_count'    => $instance['cols_count'],
				'padding'		=> $instance['padding'],
				'index'			=> 0,
				'posts'			=> $this->get_posts( $instance ),
			)
		);

	}

	/**
	 * Get posts by parameter
	 *
	 * @since 1.0
	 */
	private function get_posts( $instance ) {
		$posts = get_posts(
			array(
				'posts_per_page'	=> $instance['posts_count'],
				'offset'			=> $instance['posts_offset'],
				'cat'				=> $instance['categories'],
				'tag_id'			=> $instance['tags'],
			)
		);

		if ( count( $posts ) ) {
			foreach ( $posts as &$post ) {
				if ( has_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
					$post->image = $image[0];
				} else {
					$post->image = Utils::assets_url() . '/images/default-image.jpg';
				}

				if ( $instance['title_length'] < mb_strlen( $post->post_title, 'UTF-8' ) ) {
					$post->post_title = substr( esc_attr( $post->post_title ), 0, $instance['title_length'] ) . '...';
				}
			}
		}
		return $posts;
	}

	/**
	 * Include admin assets
	 *
	 * @since 1.0
	 */
	public function admin_assets() {
		// Custom styles
		wp_register_style( 'tm-image-grid-admin', Utils::assets_url() . '/css/image-grid-widget-admin.min.css' );
		wp_enqueue_style( 'tm-image-grid-admin' );
	}

	/**
	 * Create admin form for widget
	 *
	 * @param type $instance array.
	 */
	public function form( $instance ) {

		// Include assets
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

		$categories_list = get_categories( array( 'hide_empty' => 0 ) );
		$categories_array = array( '0' => 'not selected' );
		foreach ( $categories_list as $category_item ) {
			$categories_array[ $category_item->term_id ] = $category_item->name;
		}

		$category_field = new UI_Select_Fox(
						array(
							'id'				=> $this->get_field_id( 'categories' ),
							'name'				=> $this->get_field_name( 'categories' ),
							'default'			=> Utils::array_get( $instance, 'categories' ),
							'options'			=> $categories_array,
						)
					);
		$categories_html = $category_field->output();

		$tags_list = get_tags( array( 'hide_empty' => 0 ) );
		$tags_array = array( '0' => 'not selected' );
		foreach ( $tags_list as $tag_item ) {
			$tags_array[ $tag_item->term_id ] = $tag_item->name;
		}

		$tag_field = new UI_Select_Fox(
						array(
							'id'				=> $this->get_field_id( 'tags' ),
							'name'				=> $this->get_field_name( 'tags' ),
							'default'			=> Utils::array_get( $instance, 'tags' ),
							'options'			=> $tags_array,
						)
					);
		$tags_html = $tag_field->output();

		$cols_count_field = new UI_Select_Fox(
						array(
							'id'				=> $this->get_field_id( 'cols_count' ),
							'name'				=> $this->get_field_name( 'cols_count' ),
							'default'			=> Utils::array_get( $instance, 'cols_count' ),
							'options'			=> array( 2 => 2, 3 => 3 ),
						)
					);
		$cols_count_html = $cols_count_field->output();

		$posts_count_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'posts_count' ),
					'name'			=> $this->get_field_name( 'posts_count' ),
					'value'			=> Utils::array_get( $instance, 'posts_count' ),
					'placeholder'	=> __( 'posts count', 'blogetti' ),
					'label'			=> __( 'Count of posts', 'blogetti' ),
				)
		);
		$posts_count_html = $posts_count_field->output();

		$posts_offset_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'posts_offset' ),
					'name'			=> $this->get_field_name( 'posts_offset' ),
					'value'			=> Utils::array_get( $instance, 'posts_offset' ),
					'placeholder'	=> __( 'posts offset', 'blogetti' ),
					'label'			=> __( 'Offset', 'blogetti' ),
				)
		);
		$posts_offset_html = $posts_offset_field->output();

		$title_length_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'title_length' ),
					'name'			=> $this->get_field_name( 'title_length' ),
					'value'			=> Utils::array_get( $instance, 'title_length' ),
					'placeholder'	=> __( 'title length', 'blogetti' ),
					'label'			=> __( 'Title length', 'blogetti' ),
				)
		);
		$title_length_html = $title_length_field->output();

		$padding_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'padding' ),
					'name'			=> $this->get_field_name( 'padding' ),
					'value'			=> Utils::array_get( $instance, 'padding' ),
					'placeholder'	=> __( 'padding', 'blogetti' ),
					'label'			=> __( 'Padding', 'blogetti' ),
				)
		);
		$padding_html = $padding_field->output();

		// Show view
		echo View::make(
			'widgets/back-end/image-grid',
			array(
				'title_html'			=> $title_html,
				'categories_html'		=> $categories_html,
				'tags_html'				=> $tags_html,
				'cols_count_html'		=> $cols_count_html,
				'posts_count_html'		=> $posts_count_html,
				'posts_offset_html'		=> $posts_offset_html,
				'title_length_html'		=> $title_length_html,
				'padding_html'			=> $padding_html,
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
