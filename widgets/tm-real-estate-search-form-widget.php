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
	 * Default settings
	 *
	 * @var type array
	 */
	private $instance_default = array();

	/**
	 * Search_Form_Widget class constructor
	 */
	public function __construct() {
		$this->widget_description = __( 'TM Real Estate Search Form Widget', 'tm-real-estate' );
		$this->widget_id          = 'tm-real-estate-search-form-widget';
		$this->widget_name        = __( 'Search Form Widget', 'tm-real-estate' );
		$this->settings           = array(
			'title' => array(
				'type'  => 'text',
				'value' => '',
				'label' => esc_html__( 'Title', 'tm-real-estate' ),
			),
		);

		// Set default settings
		$this->instance_default = array(
			'title'			=> __( 'Search form & map', 'tm-real-estateß' ),
			'first_block'	=> 'form',
			'form_is'		=> 'true',
			'form_title'	=> '',
			'map_is'		=> 'true',
			'map_title'		=> '',
		);

		parent::__construct();
	}

	/**
	 * Frontend view
	 *
	 * @param type $args array.
	 * @param type $instance array.
	 */
	public function form( $instance ) {

		$first_block_field = new UI_Select(
			array(
				'id'		=> $this->get_field_id( 'first_block' ),
				'name'		=> $this->get_field_name( 'first_block' ),
				'value'		=> Cherry_Toolkit::get_arg( $instance, 'first_block' ),
				'label'	=> __( 'Choose first block', 'tm-real-estate' ),
				'options'	=> array(
					'form'	=> 'Search From',
					'map'	=> 'Map',
				),
			)
		);
		$first_block_html = $first_block_field->render();

		$form_is_field = new UI_Switcher(
						array(
							'id'	=> $this->get_field_id( 'form_is' ) . ' form_is',
							'label'	=> __( 'Show search form', 'tm-real-estate' ),
							'name'	=> $this->get_field_name( 'form_is' ),
							'value'	=> Cherry_Toolkit::get_arg( $instance, 'form_is', $this->instance_default['form_is'] ),
						)
				);
		$form_is_html = $form_is_field->render();

		$form_title_field = new UI_Text(
				array(
					'id'			=> $this->get_field_id( 'form_title' ),
					'name'			=> $this->get_field_name( 'form_title' ),
					'value'			=> Cherry_Toolkit::get_arg( $instance, 'form_title', $this->instance_default['form_title'] ),
					'label'			=> __( 'Form title', 'tm-real-estate' ),
				)
		);
		$form_title_html = $form_title_field->render();

		$map_is_field = new UI_Switcher(
						array(
							'id'	=> $this->get_field_id( 'map_is' ) . ' map_is',
							'label'	=> __( 'Show map', 'tm-real-estate' ),
							'name'	=> $this->get_field_name( 'map_is' ),
							'value'	=> Cherry_Toolkit::get_arg( $instance, 'map_is', $this->instance_default['map_is'] ),
						)
				);
		$map_is_html = $map_is_field->render();

		$map_title_field = new UI_Text(
				array(
					'id'			=> $this->get_field_id( 'map_title' ),
					'name'			=> $this->get_field_name( 'map_title' ),
					'value'			=> Cherry_Toolkit::get_arg( $instance, 'map_title', $this->instance_default['map_title'] ),
					'label'			=> __( 'Map title', 'tm-real-estate' ),
				)
		);
		$map_title_html = $map_title_field->render();

		echo Cherry_Toolkit::render_view(
			TM_REAL_ESTATE_DIR . 'views/widgets/search-form-and-map/admin.php',
			array(
				'first_block_html'	=> $first_block_html,
				'form_is_html'		=> $form_is_html,
				'form_title_html'	=> $form_title_html,
				'map_is_html'		=> $map_is_html,
				'map_title_html'	=> $map_title_html,
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
		$title = '';
		if ( array_key_exists( 'title', $instance ) ) {
			$title = $args['before_title'] . sanitize_text_field( $instance['title'] ) . $args['after_title'];
		}

		$form = do_shortcode( '[tm-re-search-form]' );
		$map = do_shortcode( '[tm-re-map]' );

		$blocks = array();
		if ( 'true' == Cherry_Toolkit::get_arg( $instance, 'form_is', $this->instance_default['form_is'] ) ) {
			$blocks['form'] = Cherry_Toolkit::render_view(
				TM_REAL_ESTATE_DIR . 'views/widgets/search-form-and-map/frontend-form.php',
				array(
					'form'			=> $form,
					'form_title'	=> Cherry_Toolkit::get_arg( $instance, 'form_title', $this->instance_default['form_title'] ),
					'before_title'	=> $args['before_title'],
					'after_title'	=> $args['after_title'],
				)
			);
		} else {
			$blocks['form'] = '';
		}

		if ( 'true' == Cherry_Toolkit::get_arg( $instance, 'map_is', $this->instance_default['map_is'] ) ) {
			$blocks['map'] = Cherry_Toolkit::render_view(
				TM_REAL_ESTATE_DIR . 'views/widgets/search-form-and-map/frontend-map.php',
				array(
					'map'			=> $map,
					'map_title'		=> Cherry_Toolkit::get_arg( $instance, 'map_title', $this->instance_default['map_title'] ),
					'before_title'	=> $args['before_title'],
					'after_title'	=> $args['after_title'],
				)
			);
		} else {
			$blocks['map'] = '';
		}

		if ( 'form' == Cherry_Toolkit::get_arg( $instance, 'first_block', $this->instance_default['first_block'] ) ) {
			$first_block = $blocks['form'];
			$second_block = $blocks['map'];
		} else {
			$first_block = $blocks['map'];
			$second_block = $blocks['form'];
		}

		echo Cherry_Toolkit::render_view(
			TM_REAL_ESTATE_DIR . 'views/widgets/search-form-and-map/frontend.php',
			array(
				'first_block'			=> $first_block,
				'second_block'			=> $second_block,
				'before_widget'	=> $args['before_widget'],
				'after_widget'	=> $args['after_widget'],
			)
		);
	}

	/**
	 * Frontend view
	 *
	 * @param type $args array.
	 * @param type $instance array.
	 */
	public function update( $new_instance, $old_instance ) {
		foreach ( $this->instance_default as $key => $value ) {
			$instance[ $key ] = ! empty( $new_instance[ $key ] ) ? $new_instance[ $key ] : $value;
		}
		return $instance;
	}
}
