	<?php
	/**
	* Model for submite form.
	*
	* @package    Cherry_Framework
	* @subpackage Model
	* @author     Cherry Team <cherryframework@gmail.com>
	* @copyright  Copyright (c) 2012 - 2016, Cherry Team
	* @link       http://www.cherryframework.com/
	* @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
	*/

	/**
	* Model properties
	*/
	class Model_Submit_Form {

	public function register_ajax() {

		add_action( 'wp_ajax_nopriv_submit_form', array( 'Model_Submit_Form', 'submit_form_callback' ) );
		add_action( 'wp_ajax_submit_form', array( 'Model_Submit_Form', 'submit_form_callback' ) );

	}
	/**
	 * Shortcode properties
	 *
	 * @return html code.
	 */
	public function shortcode_submit_form() {
		wp_localize_script( 'cherry-js-core', 'form_url', 
			array(
				'url'   => admin_url('admin-ajax.php'),
			)
		);

		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . '/views/submit-form.php'
		);
	}
	public function submit_form_callback() {
		$property['title'] = $_POST['property']['title'];
		$property['description'] = $_POST['property']['description'];
		$meta = $_POST['property']['meta'];

		$post_id = Model_Properties::add_property( $property );

		foreach ( $meta as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}
		
		$file = $_FILES['thumb'];
 
		$attachment_id = Model_Submit_Form::insert_attacment($file,$post_id);
		
 
		set_post_thumbnail( $post_id, $attachment_id );
		
		wp_die();
	}
	public function insert_attacment($file,$post_id) {
	
		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		$file_return = wp_handle_upload( $file, array('test_form' => false ) );
		if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
			echo 1;
			return false;
		} else {
			$filename = $file_return['file'];
			$attachment = array(
				'post_mime_type' => $file_return['type'],
				'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content' => '',
				'post_status' => 'inherit',
				'guid' => $file_return['url']
			);
			$attachment_id = wp_insert_attachment( $attachment, $file_return['url'], $post_id);
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );

			wp_update_attachment_metadata( $attachment_id, $attachment_data );
			if( 0 < intval( $attachment_id ) ) {
				return $attachment_id;
			}
		}
		return false;
	}
}
	//add_post_meta(68, 'my_key', 47);