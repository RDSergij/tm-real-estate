<?php
/**
 * Google plus widget module file
 *
 * @package photolab
 */

/**
 * Google plus class
 */
class Monster_Google_Plus extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'monster_google_plus_widget',
			__( 'Google plus widget', 'blogetti' ),
			array( 'description' => __( 'Google plus Widget', 'blogetti' ) )
		);
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
		echo View::make(
			'widgets/front-end/google-plus',
			array(
				'before_widget' => $args['before_widget'],
				'before_title'  => $args['before_title'],
				'after_title'   => $args['after_title'],
				'after_widget'  => $args['after_widget'],
				'title'         => Utils::array_get( $instance, 'title' ),
				'page_id'       => Utils::array_get( $instance, 'page_id' ),
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

		$page_id_tooltip = new UI_Tooltip_Fox(
				array(
					'direction'			=> 'bottom',
					'title'				=> __( 'Page ID', 'blogetti' ),
					'description'		=> __( 'Look  ', 'blogetti' )
											. '<a href="https://developers.google.com/youtube/v3/getting-started" target="_blank">'
											. __( ' on this page ', 'blogetti' )
											. '</a>',
				)
		);
		$page_id_tooltip_html = $page_id_tooltip->output();

		echo View::make(
			'widgets/back-end/google-plus',
			array(
				'title'					=> Utils::array_get( $instance, 'title' ),
				'page_id'				=> Utils::array_get( $instance, 'page_id' ),
				'page_id_tooltip_html'	=> $page_id_tooltip_html,
				'field_id_title'		=> $this->get_field_id( 'title' ),
				'field_name_title'		=> $this->get_field_name( 'title' ),
				'field_id_page_id'		=> $this->get_field_id( 'page_id' ),
				'field_name_page_id'	=> $this->get_field_name( 'page_id' ),
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
		$instance            = array();
		$instance['title']   = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['page_id'] = $new_instance['page_id'];

		return $instance;
	}
}
