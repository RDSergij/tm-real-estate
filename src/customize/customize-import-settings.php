<?php
/**
 * Import button module file
 *
 * @package photolab
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

/**
 * Customize_Import_Settings module class
 */
class Customize_Import_Settings extends WP_Customize_Control {
	/**
	 * Render content
	 */
	public function render_content() {
		echo View::make( dirname( __FILE__ ).'/views/import-theme-settings.php' );
	}
}

endif;
