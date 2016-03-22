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

	/**
	 * Shortcode submit form
	 *
	 * @return html code.
	 */
	public function shortcode_submit_form() {
		$terms = Model_Properties::get_types();
		return Cherry_Core::render_view(
			TM_REAL_ESTATE_DIR . '/views/submit-form.php',
			$terms
		);
	}

	/**
	 * Callback of shortcode submit form
	 */
	public function submit_form_callback() {
		$messages = Model_Settings::get_submission_form_settings();
		$tm_json_request = array();
		if ( empty( $_POST ) ) {
			wp_send_json_error( $messages['failed-message'] );
			wp_die();
		}
		if ( empty( $_POST['property']['title'] ) ) {
			wp_send_json_error( $messages['failed-message'] );
			wp_die();
		}

		$property['title']       = $_POST['property']['title'];
		$property['description'] = ! empty( $_POST['property']['description'] ) ? $_POST['property']['description'] : '';
		$property_meta           = $_POST['property']['meta'];

		$post_id = Model_Properties::add_property( $property );

		if ( ! $post_id ) {
			wp_send_json_error( $messages['failed-message'] );
			wp_die();
		}
		if ( ! empty( $_POST['property']['type'] ) ) {
			wp_set_post_terms( $post_id, sanitize_key( $_POST['property']['type'] ), 'property-type' );
		}

		if ( !empty ( $_FILES['thumb'] ) ) {
			$attachment_id = Model_Submit_Form::insert_attacment( $_FILES['thumb'], $post_id );
			if ( ! $attachment_id ) {
				wp_send_json_error( $messages['failed-message'] );
				wp_die();
			}
			set_post_thumbnail( $post_id, $attachment_id );
		}

		if ( ! empty( $_FILES['gallery'] ) ) {
			if ( is_array( $_FILES['gallery']['name'] ) ) {
				$files = Model_Submit_Form::re_array_files( $_FILES['gallery'] );
				foreach ( $files as $key => $file ) {
					$property_meta['gallery']['image'][ $key ] = Model_Submit_Form::insert_attacment( $file, $post_id );
				}
			} else {
				$file = $_FILES['gallery'];
				$property_meta['gallery']['image'][ $key ] = Model_Submit_Form::insert_attacment( $file, $post_id );
			}
		}

		if ( current_user_can( 'administrator' ) || current_user_can( 're_agent' ) ) {
			$property_meta['agent'] = get_current_user_id();
		}

		foreach ( $property_meta as $key => $value ) {
			update_post_meta( $post_id, sanitize_text_field( $key ), $value );
		}

		wp_send_json_success( $messages['success-message'] );
		wp_die();
	}

	/**
	 * Add new  attacment
	 *
	 * @param  [type] $file file of attachment.
	 * @param  [type] $post_id  ID of post.
	 *
	 * @return [type] code.
	 */
	public function insert_attacment( $file, $post_id ) {

		require_once( ABSPATH . 'wp-admin/includes/admin.php' );
		$file_return = wp_handle_upload( $file, array( 'test_form' => false ) );
		if ( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
			return false;
		} else {
			$filename = $file_return['file'];
			$attachment = array(
				'post_mime_type' => $file_return['type'],
				'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content'   => '',
				'post_status'    => 'inherit',
				'guid'           => $file_return['url'],
			);
			$attachment_id = wp_insert_attachment( $attachment, $file_return['url'], $post_id );
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			$attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
			wp_update_attachment_metadata( $attachment_id, $attachment_data );
			if ( 0 < intval( $attachment_id ) ) {
				return $attachment_id;
			}
		}
		return false;
	}

	/**
	 * Reformate files array
	 *
	 * @param  [type] $file_post array of files.
	 *
	 * @return mixed file_array.
	 */
	public function re_array_files( &$file_post ) {
		$file_array = array();
		$file_count = count( $file_post['name'] );
		$file_keys  = array_keys( $file_post );

		for ( $i = 0; $i < $file_count; $i ++ ) {
			foreach ( $file_keys as $key ) {
				$file_array[ $i ][ $key ] = $file_post[ $key ][ $i ];
			}
		}
		return $file_array;
	}
}
