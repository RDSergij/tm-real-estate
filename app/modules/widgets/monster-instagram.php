<?php
/**
 * Instagram widget module file
 *
 * @package photolab
 */

/**
 * Instagram widget class
 */
class Monster_Instagram extends WP_Widget{

	const CLIENT_ID = '1515b124cf42481db64cacfb96132345';
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'monster_instagram_widget',
			__( 'Instagram widget', 'blogetti' ),
			array( 'description' => __( 'Instagram recent photos Widget', 'blogetti' ) )
		);
	}

	/**
	 * Get user id by user name
	 *
	 * @param type $user_name --- user name.
	 * @param type $client_id --- client id.
	 * @return integer --- user id
	 */
	public function getUserID( $user_name, $client_id = '' ) {
		$user_name = trim( $user_name );
		$client_id = $this->sanitize_client_id( $client_id );
		
		if ( '' == $user_name || '' == $client_id ) {
			return 0;
		}
		$result = 0;
		$query  = sprintf(
			'https://api.instagram.com/v1/users/search?q=%s&client_id=%s',
			$user_name,
			$client_id
		);

		$request = (array) json_decode( Utils::get_contents( $query ), true );

		if ( array_key_exists( 'data', $request ) ) {
			if ( is_array( $request['data'] ) ) {
				$result = (int) $request['data'][0]['id'];
			}
		}

		return $result;
	}

	/**
	 * Get posts with thumbnails
	 *
	 * @param  type $id user id.
	 * @param  type $client_id client id api.
	 * @param  type $number_posts number posts.
	 * @return array posts with thumbnails $post->image
	 */
	public function getPostsWithImages( $id = '189003872', $client_id = '', $number_posts = 1, $sidebar_id = null ) {
		$client_id = $this->sanitize_client_id( $client_id );
		if ( 0 == $id ) {
			return array();
		}
		$query   = sprintf(
			'https://api.instagram.com/v1/users/%s/media/recent/?client_id=%s&count=%d',
			$id,
			$client_id,
			$number_posts
		);

		$request = Utils::get_contents( $query );
		$images = json_decode( $request, true );

//		if ( in_array( $args['id'], array( 'left-sidebar', 'right-sidebar' ) ) ) {
//			foreach( $images['data'] as &$image ) {
//				$image['images']['low_resolution']['url'] = str_ireplace('s320x320', $request, $query)
//			}
//		}
//		

		return $images;
	}

	/**
	 * Get number posts from saved options
	 *
	 * @param  mixed $number_posts --- potential number posts.
	 * @return integer --- number posts
	 */
	public function getNumberPosts( $number_posts ) {
		$number_posts = (int) $number_posts;
		return $number_posts > 0 ? $number_posts : 1;
	}

	/**
	 * Sanitize client id
	 *
	 * @param type $client_id client id.
	 * @return string sanitized client id
	 */
	public function sanitize_client_id( $client_id = '' ) {
		$client_id = trim( $client_id );
		if ( '' == $client_id ) {
			$client_id = self::CLIENT_ID;
		}
		return $client_id;
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		$number_posts = $this->getNumberPosts( Utils::array_get( $instance, 'number_posts', 5 ) );
		$user_id      = $this->getUserID(
			Utils::array_get( $instance, 'user' ),
			Utils::array_get( $instance, 'client_id', '1515b124cf42481db64cacfb96132345' )
		);

		if ( in_array( $args['id'], array( 'left-sidebar', 'right-sidebar' ) ) ) {
			$size = 'thumbnail';
		} else {
			$size = 'low_resolution';
		}

		echo View::make(
			'widgets/front-end/instagram',
			array(
				'before_widget' => $args['before_widget'],
				'before_title'  => $args['before_title'],
				'after_title'   => $args['after_title'],
				'after_widget'  => $args['after_widget'],
				'title'         => Utils::array_get( $instance, 'title' ),
				'images'        => $this->getPostsWithImages( $user_id, Utils::array_get( $instance, 'client_id' ), $number_posts, $args['id'] ),
				'size'			=> $size,
			)
		);
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		echo View::make(
			'widgets/back-end/instagram',
			array(
				'title'                   => Utils::array_get( $instance, 'title' ),
				'user'                    => Utils::array_get( $instance, 'user' ),
				'number_posts'            => Utils::array_get( $instance, 'number_posts' ),
				'client_id'               => Utils::array_get( $instance, 'client_id' ),
				'field_id_title'          => $this->get_field_id( 'title' ),
				'field_name_title'        => $this->get_field_name( 'title' ),
				'field_id_user'           => $this->get_field_id( 'user' ),
				'field_name_user'         => $this->get_field_name( 'user' ),
				'field_id_number_posts'   => $this->get_field_id( 'number_posts' ),
				'field_name_number_posts' => $this->get_field_name( 'number_posts' ),
				'field_id_client_id'      => $this->get_field_id( 'client_id' ),
				'field_name_client_id'    => $this->get_field_name( 'client_id' ),
			)
		);
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                 = array();
		$instance['title']        = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['user']         = esc_attr( $new_instance['user'] );
		$instance['number_posts'] = (int) $new_instance['number_posts'];
		$instance['client_id']    = esc_attr( $new_instance['client_id'] );

		return $instance;
	}
}
