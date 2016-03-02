<?php
/**
 * Advertisement widget module file
 *
 * @package photolab
 */

/**
 * Advertisement widget module class
 */
class Monster_Advertisement extends WP_Widget{

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'monster_advertisement_widget',
			__( 'Monster Advertisement widget', 'blogetti' ),
			array( 'description' => __( 'Advertisement Widget', 'blogetti' ) )
		);

		// ==============================================================
		// Actions
		// ==============================================================
		add_action( 'admin_enqueue_scripts', array( $this, 'uploadScripts' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'uploadScripts' ) );
	}

	/**
	 * Upload some scripts to admin and customize
	 */
	public function uploadScripts() {
		wp_enqueue_media();
		wp_enqueue_script(
			'advertisement',
			Utils::assets_url().'/js/advertisement.js',
			array( 'jquery' )
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
		$id         = Utils::array_get( $instance, 'image', 0 );
		$attachment = (array) wp_get_attachment_image_src( $id, 'advertisement' );

		echo View::make(
			'widgets/front-end/advertisement',
			array(
				'image' => Utils::array_get( $attachment, 0, '' ),
				'id'    => $id,
				'before_widget' => $args['before_widget'],
				'before_title'  => $args['before_title'],
				'after_title'   => $args['after_title'],
				'after_widget'  => $args['after_widget'],
				'title'         => Utils::array_get( $instance, 'title' ),
				'description'   => Utils::array_get( $instance, 'description' ),
				'url'           => Utils::array_get( $instance, 'url', '#' ),
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
		$id          = Utils::array_get( $instance, 'image', 0 );
		$attachment  = (array) wp_get_attachment_image_src( $id, 'thumbnail' );
		$image       = (string) $attachment[0];
		$remove_show = '' == $image ? 'display:none' : '';

		echo View::make(
			'widgets/back-end/advertisement',
			array(
				'remove_show'            => $remove_show,
				'title'                  => Utils::array_get( $instance, 'title', '' ),
				'description'            => Utils::array_get( $instance, 'description', '' ),
				'url'                    => Utils::array_get( $instance, 'url', '' ),
				'id'                     => $id,
				'image'                  => $image,
				'field_id_title'         => $this->get_field_id( 'title' ),
				'field_name_title'       => $this->get_field_name( 'title' ),
				'field_id_description'   => $this->get_field_id( 'description' ),
				'field_name_description' => $this->get_field_name( 'description' ),
				'field_id_url'           => $this->get_field_id( 'url' ),
				'field_name_url'         => $this->get_field_name( 'url' ),
				'field_id_image'         => $this->get_field_id( 'image' ),
				'field_name_image'       => $this->get_field_name( 'image' ),
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
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['image']       = $new_instance['image'];
		$instance['url']         = $new_instance['url'];

		return $instance;
	}
}
