<?php
/**
 * Plugin Name:  TM Posts Carousel Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Posts carousel widget
 * Version: 1.0.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package Monster_Posts_Widget
 *
 * @since 1.1
 */

/**
 * Adds register_tm_posts_widget widget.
 */
class Monster_Posts_Carousel_Widget extends WP_Widget {

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
			'Monster_Posts_Carousel_Widget', // Base ID
			__( 'Monster Posts Carousel Widget', 'blogetti' ),
			array( 'description' => __( 'Posts carousel widget', 'blogetti' ) )
		);
		// Set default settings
		$this->instance_default = array(
			'title'				=> '',
			'categories'		=> 0,
			'tags'				=> 0,
			'count'				=> 4,
			'slides_per_view'	=> 2,
			'length'			=> 15,
		);
	}

	/**
	 * Include frontend assets
	 *
	 * @since 1.0
	 */
	public function frontend_assets( $instance ) {

		// Carousel
		wp_register_script( 'carousel', Utils::assets_url() . 'js/owl.carousel.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'carousel' );

		// Carousel style
		wp_enqueue_style( 'carousel-custom', Utils::assets_url() . 'css/posts-carousel-widget-frontend.css' );

		// Custom js
		wp_register_script( 'tm-post-carousel-script-frontend', Utils::assets_url() . 'js/posts-carousel-widget-frontend.min.js', '', '', true );
		wp_enqueue_script( 'tm-post-carousel-script-frontend' );

	}

	/**
	 * Get posts by parameter
	 *
	 * @since 1.0
	 */
	private function get_posts( $instance ) {
		$posts = get_posts(
			array(
				'posts_per_page'	=> $instance['count'],
				'cat'				=> $instance['categories'],
				'tag_id'			=> $instance['tags'],
			)
		);

		if ( count( $posts ) ) {
			foreach ( $posts as &$post ) {
				if ( has_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'minisquare' );
					$post->image = $image[0];
				} else {
					$post->image = Utils::assets_url() . '/images/default-image.jpg';
				}

				if ( $instance['length'] < mb_strlen( $post->post_excerpt, 'UTF-8' ) ) {
					$post->post_excerpt = substr( esc_attr( $post->post_excerpt ), 0, $instance['length'] ) . '...';
				}

				$post_categories = wp_get_post_categories( $post->ID );
				$terms = array();
				foreach( $post_categories as $category_item ){
					$cat = get_category( $category_item );
					$terms[] = $cat->name;
				}

				$post_tags = wp_get_post_tags( $post->ID );
				foreach( $post_tags as $tag_item ){
					$tag = get_tag( $tag_item );
					$terms[] = $tag->name;
				}

				$post->terms = array_unique( $terms );

				$time = strtotime( $post->post_date );
				$post->date_atribute = date( 'Y-m-d', $time );
				$post->date_text = get_the_date( get_option('date_format') , $post->ID );
			}
		}
		return $posts;
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
		$this->frontend_assets( $instance );

		echo View::make(
			'/widgets/front-end/posts-carousel',
			array(
				'before_widget'		=> $args['before_widget'],
				'before_title'		=> $args['before_title'],
				'after_title'		=> $args['after_title'],
				'after_widget'		=> $args['after_widget'],
				'title'				=> Utils::array_get( $instance, 'title' ),
				'slides_per_view'	=> Utils::array_get( $instance, 'slides_per_view', 2 ),
				'posts'				=> $this->get_posts( $instance ),
			)
		);
	}

	/**
	 * Include admin assets
	 *
	 * @since 1.0
	 */
	public function admin_assets() {
		// Custom styles
		wp_register_style( 'tm-post-carousel-admin', Utils::assets_url() . '/css/posts-carousel-widget-admin.min.css' );
		wp_enqueue_style( 'tm-post-carousel-admin' );
	}


	/**
	 * Create admin form for widget
	 *
	 * @param type $instance array.
	 */
	public function form( $instance ) {
		foreach ( $this->instance_default as $key => $value ) {
			$instance[ $key ] = ! empty( $instance[ $key ] ) ? $instance[ $key ] : $value;
		}

		$title_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'title' ),
					'class'			=> 'title',
					'name'			=> $this->get_field_name( 'title' ),
					'value'			=> Utils::array_get( $instance, 'title' ),
					'placeholder'	=> __( 'New title', 'blogetti' ),
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

		$count_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'count' ),
					'name'			=> $this->get_field_name( 'count' ),
					'value'			=> Utils::array_get( $instance, 'count' ),
					'placeholder'   => __( 'posts count', 'blogetti' ),
					'label'         => __( 'Count of posts', 'blogetti' ),
				)
		);
		$count_html = $count_field->output();

		$slides_per_view_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'slides_per_view' ),
					'name'			=> $this->get_field_name( 'slides_per_view' ),
					'value'			=> Utils::array_get( $instance, 'slides_per_view' ),
					'placeholder'	=> __( 'slides per view', 'blogetti' ),
					'label'         => __( 'Items per view', 'blogetti' ),
				)
		);
		$slides_per_view_html = $slides_per_view_field->output();

		$length_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'length' ),
					'name'			=> $this->get_field_name( 'length' ),
					'value'			=> Utils::array_get( $instance, 'length' ),
					'placeholder'	=> __( 'number of words', 'blogetti' ),
					'label'			=> __( 'Number of words', 'blogetti' ),
				)
		);
		$length_html = $length_field->output();

		// Show view
		echo View::make(
			'widgets/back-end/posts-carousel',
			array(
				'title_html'			=> $title_html,
				'categories_html'		=> $categories_html,
				'tags_html'				=> $tags_html,
				'count_html'			=> $count_html,
				'slides_per_view_html'	=> $slides_per_view_html,
				'length_html'			=> $length_html,
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
