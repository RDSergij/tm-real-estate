<?php
/**
 * TM Real Estate Search form Widget
 *
 * @package    TM Real Estate
 * @subpackage Class
 * @author     Cherry Team <cherryframework@gmail.com>, Guriev Eugen.
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Add TM_Real_Estate_Search_Form_Widget widget.
 */
class TM_Real_Estate_Search_Form_Widget extends Cherry_Abstract_Widget {

	/**
	 * Search_Form_Widget class constructor
	 */
	public function __construct() {
		$this->widget_description = __( 'TM Real Estate Search Form Widget', 'tm-real-estate' );
		$this->widget_id          = 'tm-real-estate-search-form-widget';
		$this->widget_name        = __( 'Search Form Widget', 'tm-real-estate' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'value' => esc_html__( '', 'tm-real-estate' ),
				'label' => esc_html__( 'Title', 'tm-real-estate' ),
			),
		);
		parent::__construct();
	}

	/**
	 * Frontend view
	 *
	 * @param type $args array.
	 * @param type $instance array.
	 */
	public function widget( $args, $instance ) {
		$title = '';
		if ( array_key_exists( 'title', $instance ) ) {
			$title = $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo $args['before_widget'];
		echo $title;
		echo do_shortcode( '[tm-re-search-form]' );
		echo $args['after_widget'];
	}
}
