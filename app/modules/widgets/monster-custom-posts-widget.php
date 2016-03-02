<?php
/**
 * Plugin Name: TM Custom Posts Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Show custom posts list
 * Version: 1.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package Monster_Custom_Posts_Widget
 *
 * @since 1.1
 */

/**
 * Adds register_Monster_posts_widget widget.
 */
class Monster_Custom_Posts_Widget extends WP_Widget {

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
			'Monster_Custom_Posts_Widget', // Base ID
			__( 'Monster Custom Posts Widget', 'blogetti' ),
			array( 'description' => __( 'Show custom posts', 'blogetti' ) )
		);
		// Set default settings
		$this->instance_default = array(
			'title'				=> '',
			'categories'		=> 0,
			'tags'				=> 0,
			'count'				=> 4,
			'post_format'		=> 'standard',
			'offset'			=> 0,
			'title_length'		=> 20,
			'excerpt_length'	=> 50,
			'button_text'		=> '',
			'show_date'			=> 'true',
			'show_author'		=> 'true',
			'show_comments'		=> 'true',
			'show_categories'	=> 'true',
			'show_tags'			=> 'true',
		);
	}

	/**
	 * Get posts by parameter
	 *
	 * @since 1.0
	 */
	private function get_posts( $args, $instance ) {
		$posts = get_posts(
			array(
				'posts_per_page'	=> $instance['count'],
				'cat'				=> $instance['categories'],
				'tag_id'			=> $instance['tags'],
			)
		);

		if ( count( $posts ) ) {
			if ( in_array($args['id'], array( 'left-sidebar', 'right-sidebar' ) ) ) {
				$image_size = 'posts-list';
			} else {
				$image_size = 'medium';
			}
			foreach ( $posts as &$post ) {
				if ( has_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $image_size );
					$post->image = $image[0];
				} else {
					$post->image = '';
				}

				if ( empty( $post->post_excerpt ) ) {
					$post->post_excerpt = strip_tags( $post->post_content );
				}

				$post->post_excerpt = strip_shortcodes( $post->post_excerpt );

				if ( $instance['title_length'] < mb_strlen( $post->post_title, 'UTF-8' ) ) {
					$post->post_title = substr( esc_attr( $post->post_title ), 0, $instance['title_length'] ) . '...';
				}

				if ( $instance['excerpt_length'] < mb_strlen( $post->post_excerpt, 'UTF-8' ) ) {
					$post->post_excerpt = substr( esc_attr( $post->post_excerpt ), 0, $instance['excerpt_length'] );
				}

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

		echo View::make(
			'/widgets/front-end/custom-posts',
			array(
				'before_widget'		=> $args['before_widget'],
				'before_title'		=> $args['before_title'],
				'after_title'		=> $args['after_title'],
				'after_widget'		=> $args['after_widget'],
				'title'				=> Utils::array_get( $instance, 'title' ),
				'posts'				=> $this->get_posts( $args, $instance ),
				'button_text'		=> Utils::array_get( $instance, 'button_text' ),
				'show_date'			=> Utils::array_get( $instance, 'show_date' ),
				'show_author'		=> Utils::array_get( $instance, 'show_author' ),
				'show_comments'		=> Utils::array_get( $instance, 'show_comments' ),
				'show_categories'	=> Utils::array_get( $instance, 'show_categories' ),
				'show_tags'			=> Utils::array_get( $instance, 'show_tags' ),
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
		wp_register_style( 'tm-custom-posts-admin', Utils::assets_url() . 'css/custom-posts-widget-admin.min.css' );
		wp_enqueue_style( 'tm-custom-posts-admin' );

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

		$this->admin_assets();

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

		$title_length_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'title_length' ),
					'name'			=> $this->get_field_name( 'title_length' ),
					'value'			=> Utils::array_get( $instance, 'title_length' ),
					'placeholder'	=> __( 'number of words', 'blogetti' ),
					'label'			=> __( 'Title length', 'blogetti' ),
				)
		);
		$title_length_html = $title_length_field->output();

		$excerpt_length_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'excerpt_length' ),
					'name'			=> $this->get_field_name( 'excerpt_length' ),
					'value'			=> Utils::array_get( $instance, 'excerpt_length' ),
					'placeholder'	=> __( 'number of words', 'blogetti' ),
					'label'			=> __( 'Excerpt length', 'blogetti' ),
				)
		);
		$excerpt_length_html = $excerpt_length_field->output();

		$button_text_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'button_text' ),
					'name'			=> $this->get_field_name( 'button_text' ),
					'value'			=> Utils::array_get( $instance, 'button_text' ),
					'placeholder'	=> __( 'read more', 'blogetti' ),
					'label'			=> __( 'Button text', 'blogetti' ),
				)
		);
		$button_text_html = $button_text_field->output();

		$show_date_field = new UI_Switcher_Fox(
						array(
							'id'        => $this->get_field_id( 'show_date' ),
							'class'		=> 'pull-right',
							'name'      => $this->get_field_name( 'show_date' ),
							'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
							'default'   => Utils::array_get( $instance, 'show_date' ),
						)
				);
		$show_date_html = $show_date_field->output();

		$show_author_field = new UI_Switcher_Fox(
						array(
							'id'        => $this->get_field_id( 'show_author' ),
							'class'		=> 'pull-right',
							'name'      => $this->get_field_name( 'show_author' ),
							'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
							'default'   => Utils::array_get( $instance, 'show_author' ),
						)
				);
		$show_author_html = $show_author_field->output();

		$show_comments_field = new UI_Switcher_Fox(
						array(
							'id'        => $this->get_field_id( 'show_comments' ),
							'class'		=> 'pull-right',
							'name'      => $this->get_field_name( 'show_comments' ),
							'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
							'default'   => Utils::array_get( $instance, 'show_comments' ),
						)
				);
		$show_comments_html = $show_comments_field->output();

		$show_categories_field = new UI_Switcher_Fox(
						array(
							'id'        => $this->get_field_id( 'show_categories' ),
							'class'		=> 'pull-right',
							'name'      => $this->get_field_name( 'show_categories' ),
							'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
							'default'   => Utils::array_get( $instance, 'show_categories' ),
						)
				);
		$show_categories_html = $show_categories_field->output();

		$show_tags_field = new UI_Switcher_Fox(
						array(
							'id'        => $this->get_field_id( 'show_tags' ),
							'class'		=> 'pull-right',
							'name'      => $this->get_field_name( 'show_tags' ),
							'values'    => array( 'true' => 'ON', 'false' => 'OFF' ),
							'default'   => Utils::array_get( $instance, 'show_tags' ),
						)
				);
		$show_tags_html = $show_tags_field->output();

		// Show view
		echo View::make(
			'widgets/back-end/custom-posts',
			array(
				'title_html'			=> $title_html,
				'categories_html'		=> $categories_html,
				'tags_html'				=> $tags_html,
				'count_html'			=> $count_html,
				'title_length_html'		=> $title_length_html,
				'excerpt_length_html'	=> $excerpt_length_html,
				'button_text_html'		=> $button_text_html,
				'show_date_html'		=> $show_date_html,
				'show_author_html'		=> $show_author_html,
				'show_comments_html'	=> $show_comments_html,
				'show_categories_html'	=> $show_categories_html,
				'show_tags_html'		=> $show_tags_html,
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
