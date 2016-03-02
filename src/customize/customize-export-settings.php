<?php
/**
 * Export settings module file
 *
 * @package photolab
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

/**
 * Customize_Export_Settings module class
 */
class Customize_Export_Settings extends WP_Customize_Control {
	/**
	 * Render content
	 */
	public function render_content() {
		echo View::make(
			dirname( __FILE__ ).'/views/button.php',
			array(
				'title' => __( 'Export theme settings and content', 'blogetti' ),
				'attributes' => Utils::array_join( $this->get_button_attributes() ),
			)
		);
	}

	/**
	 * Get button attributes
	 *
	 * @return array
	 */
	private function get_button_attributes() {
		return array(
			'class' => 'button button-primary',
			'id'    => 'export_theme_settings',
		);
	}
}

endif;
