<?php
/**
 * Plugin Name: TM Youtube Subscribe Widget
 * Plugin URI: https://github.com/RDSergij
 * Description: Show twitter timeline of user
 * Version: 1.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 * Text Domain: photolab
 *
 * @package Monster_Youtube_Subscribe_Widget
 *
 * @since 1.1
 */

/**
 * Adds Monster_Youtube_Subscribe_Widget widget.
 */
class Monster_Youtube_Subscribe_Widget extends WP_Widget{

	// Default youtube api key
	const DEFAULT_YOUTUBE_KEY = 'AIzaSyC8ABgdjegQgcxF9zkhmV2gkXM5l0mgFB8';

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'monster_youtube_subscribe_widget',
			__( 'Monster Youtube subscribe widget', 'blogetti' ),
			array( 'description' => __( 'Youtube subscribe Widget', 'blogetti' ) )
		);
	}

	/**
	 * Get data about channel from YoutubeAPI
	 *
	 * @return array
	 */
	private function get_channel_data( $channel, $app_key = '' ) {
		if ( empty( $app_key ) ) {
			$app_key = self::DEFAULT_YOUTUBE_KEY;
		}

		$url = 'https://www.googleapis.com/youtube/v3/channels?part=statistics&forUsername=' . $channel . '&key=' . $app_key;

		$result = Utils::get_contents($url);

		return $result ? json_decode( $result, true ) : false;
	}

	/**
	 * Frontend view
	 *
	 * @param type $args array.
	 * @param type $instance array.
	 */
	public function widget( $args, $instance ) {

		$channel_data = $this->get_channel_data( Utils::array_get( $instance, 'channel_name' ), Utils::array_get( $instance, 'app_key', self::DEFAULT_YOUTUBE_KEY ) );

		if ( empty( $channel_data['items'][0]['statistics']['subscriberCount'] ) ) {
			$subscriber_count = 0;
		} else {
			$subscriber_count = Utils::array_get( $channel_data['items'][0]['statistics'], 'subscriberCount', 0 );
		}

		if ( empty( $channel_data['items'][0]['statistics']['videoCount'] ) ) {
			$video_count = 0;
		} else {
			$video_count = Utils::array_get( $channel_data['items'][0]['statistics'], 'videoCount', 0 );
		}

		echo View::make(
			'widgets/front-end/youtube-subscribe',
			array(
				'before_widget'		=> $args['before_widget'],
				'before_title'		=> $args['before_title'],
				'after_title'		=> $args['after_title'],
				'after_widget'		=> $args['after_widget'],
				'title'				=> Utils::array_get( $instance, 'title' ),
				'channel_name'		=> Utils::array_get( $instance, 'channel_name' ),
				'channel_url'		=> Utils::array_get( $instance, 'channel_url' ),
				'subscriber_count'	=> $subscriber_count,
				'video_count'		=> $video_count,
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

		$app_key_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'app_key' ),
					'name'			=> $this->get_field_name( 'app_key' ),
					'value'			=> Utils::array_get( $instance, 'app_key' ),
					'placeholder'	=> __( 'api key', 'blogetti' ),
				)
		);
		$app_key_html = $app_key_field->output();

		$app_key_tooltip = new UI_Tooltip_Fox(
				array(
					'direction'			=> 'bottom',
					'title'				=> __( 'Youtube API key', 'blogetti' ),
					'description'		=> __( 'More info ', 'blogetti' )
											. '<a href="https://developers.google.com/youtube/v3/getting-started" target="_blank">'
											. __( ' on this page ', 'blogetti' )
											. '</a>',
				)
		);
		$app_key_tooltip_html = $app_key_tooltip->output();

		$channel_name_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'channel_name' ),
					'name'			=> $this->get_field_name( 'channel_name' ),
					'value'			=> Utils::array_get( $instance, 'channel_name' ),
					'placeholder'	=> __( 'channel name', 'blogetti' ),
					'label'			=> __( 'Channel name', 'blogetti' ),
				)
		);
		$channel_name_html = $channel_name_field->output();

		$channel_url_field = new UI_Input_Fox(
				array(
					'id'			=> $this->get_field_id( 'channel_url' ),
					'name'			=> $this->get_field_name( 'channel_url' ),
					'value'			=> Utils::array_get( $instance, 'channel_url' ),
					'placeholder'	=> __( 'channel url', 'blogetti' ),
					'label'			=> __( 'Channel url', 'blogetti' ),
				)
		);
		$channel_url_html = $channel_url_field->output();

		echo View::make(
			'widgets/back-end/youtube-subscribe',
			array(
				'title_html'			=> $title_html,
				'app_key_html'			=> $app_key_html,
				'app_key_tooltip_html'	=> $app_key_tooltip_html,
				'channel_name_html'		=> $channel_name_html,
				'channel_url_html'		=> $channel_url_html,
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
		$instance					= array();
		$instance['title']			= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['app_key']		= esc_attr( $new_instance['app_key'] );
		$instance['channel_name']	= esc_attr( $new_instance['channel_name'] );
		$instance['channel_url']	= esc_attr( $new_instance['channel_url'] );

		return $instance;
	}
}
