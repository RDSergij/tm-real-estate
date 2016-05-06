<?php
/**
 * Agents
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
class Model_Agents {

	/**
	 * Agent contact form shortcode
	 *
	 * @return html code.
	 */
	public static function shortcode_contact_form( $atts ) {

		if ( empty( $atts['agent_id'] ) && empty( $atts['property_id'] ) ) {
			return;
		}

		$property_id = null;
		if ( ! empty( $atts['property_id'] ) ) {
			$property_id = $atts['property_id'];
		}

		$agent_id = null;
		if ( ! empty( $atts['agent_id'] ) ) {
			$agent_id = $atts['agent_id'];
		} else {
			$agent_id = get_post_meta( $property_id, 'agent', true );
		}

		return self::agent_contact_form( $agent_id, $property_id );
	}

	/**
	 * Agent contact form shortcode
	 *
	 * @return html code.
	 */
	public static function shortcode_agent_properties( $atts ) {

		if ( ! is_array( $atts ) ) {
			$atts = array();
		}

		if ( empty( $atts['agent_id'] ) && empty( $atts['property_id'] ) && empty( $_GET['agent_id'] ) && empty( $_GET['property_id'] ) ) {
			return;
		}

		$atts = array_merge( $atts, $_GET );

		$property_id = null;
		if ( ! empty( $atts['property_id'] ) ) {
			$property_id = $atts['property_id'];
		}

		$agent_id = null;
		if ( ! empty( $atts['agent_id'] ) ) {
			$agent_id = $atts['agent_id'];
		} else {
			$agent_id = get_post_meta( $property_id, 'agent', true );
		}

		$args = array( 'agent' => $agent_id );

		$args = array_merge( $atts, $args );

		$contact_form_html = self::agent_contact_form( $agent_id, $property_id );

		$properties_html = self::shortcode_properties( $args );

		return Cherry_Toolkit::render_view(
			TM_REAL_ESTATE_DIR . 'views/agent-properties.php',
			array(
				'contact_form_html'	=> $contact_form_html,
				'properties_html'		=> $properties_html,
			)
		);

	}

	/**
	 * Contact form assets
	 */
	public static function contact_form_assets() {

		$contact_form_settings = Model_Settings::get_contact_form_settings();

		wp_enqueue_script(
			'google-captcha',
			'https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit',
			null,
			'1.0.0',
			false
		);

		wp_enqueue_script(
			'tm-real-state-contact-form',
			plugins_url( 'tm-real-estate' ) . '/assets/js/contact-form.min.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_localize_script( 'tm-real-state-contact-form', 'TMREContactForm', array(
			'ajaxUrl'			=> admin_url( 'admin-ajax.php' ),
			'successMessage'	=> $contact_form_settings['success-message'],
			'failedMessage'		=> $contact_form_settings['failed-message'],
			'captchaKey'		=> ! empty( $contact_form_settings['google-captcha-key'] ) ? $contact_form_settings['google-captcha-key'] : '',
		) );

		wp_enqueue_style(
			'tm-real-contact-form',
			plugins_url( 'tm-real-estate' ) . '/assets/css/contact-form.min.css',
			array(),
			'1.0.0',
			'all'
		);

	}

	/**
	 * Agent contact form
	 *
	 * @return html code.
	 */
	public static function agent_contact_form( $agent_id, $property_id ) {

		self::contact_form_assets();

		if ( empty( $agent_id ) ) {
			if ( empty( $property_id ) ) {
				return;
			}

			$agent_id = get_post_meta( $property_id, 'agent', true );
		}

		$agent_id  = max( (int) $agent_id, 1 );
		$user_data = get_userdata( $agent_id );
		$agent_page = Model_Settings::get_agent_properties_page() . '?agent_id=' . $agent_id;

		return Cherry_Toolkit::render_view(
			TM_REAL_ESTATE_DIR . 'views/contact-form.php',
			array(
				'agent'			=> $user_data->data,
				'property_id'	=> $property_id,
				'agent_page'	=> $agent_page,
				'photo_url'		=> self::get_agent_photo_url( $agent_id ),
			)
		);
	}

	/**
	 * Get agents list
	 *
	 * @return array
	 */
	public static function get_agents_list() {
		$agents = get_users( array( 'role' => 're_agent' ) );

		if ( ! empty( $agents ) && is_array( $agents ) && count( $agents ) > 0 ) {
			foreach ( $agents as &$agent ) {
				$agent->agent_page = esc_url( Model_Settings::get_agent_properties_page() . '?agent_id=' . $agent->ID );
				$agent->photo_url = self::get_agent_photo_url( $agent->ID );
			}
			return $agents;
		}

		return array();
	}

	/**
	 * Shortcode agents list output
	 *
	 * @return string html output.
	 */
	public static function shortcode_agents_list() {
		$agents = self::get_agents_list();
		if ( ! empty( $agents ) ) {
			return Cherry_Toolkit::render_view(
				TM_REAL_ESTATE_DIR . 'views/agents-list.php',
				array(
					'agents'		=> $agents,
				)
			);
		}
	}

	/**
	 * Include photo assets
	 */
	public static function photo_assets() {
		// Register
		wp_register_style( 'tm_agent_photo_admin_css', TM_REAL_ESTATE_URI . 'assets/css/styles.css', false, '1.0.0', 'all' );
		wp_register_script( 'tm_agent_photo_admin_js', TM_REAL_ESTATE_URI . 'assets/js/agent-photo.js', array( 'jquery' ), '1.0.0' );

		// Enqueue
		wp_enqueue_style( 'tm_agent_photo_admin_css' );
		wp_enqueue_script( 'tm_agent_photo_admin_js' );
	}

	/**
	 * Add photo field in profile
	 *
	 * @param object $user
	 * @return html code
	 */
	public static function profile_img_fields( $user ) {
		if ( ! current_user_can( 'upload_files' ) ) {
			return false;
		}

		wp_enqueue_media();

		// vars
		$upload_url = self::get_agent_photo_url( $user->ID );
		$photo_id = self::get_agent_photo_id( $user->ID );

		if ( ! $upload_url ) {
			$btn_text = 'Upload New Image';
			$upload_edit_url = '';
		} else {
			$upload_edit_url = self::get_edit_agent_photo_url( $user->ID );
			$btn_text = 'Change Current Image';
		}

		echo Cherry_Toolkit::render_view(
				TM_REAL_ESTATE_DIR . 'views/agent-profile-photo.php',
				array(
					'upload_url'		=> $upload_url,
					'photo_id'			=> $photo_id,
					'upload_edit_url'	=> $upload_edit_url,
					'btn_text'			=> $btn_text,
					'default_image'		=> TM_REAL_ESTATE_URI . 'assets/images/placehold.png',
				)
			);

	}

	/**
	 * Save image
	 *
	 * @param integer agent
	 */
	public static function save_img_meta( $user_id ) {

		if ( ! current_user_can( 'upload_files', $user_id ) ) {
			return false;
		}

		// If the current user can edit Users, allow this.
		update_user_meta( $user_id, 'tm-re-photo-upload-meta', sanitize_text_field( $_POST['tm_re_agent_photo_upload_meta'] ) );
		update_user_meta( $user_id, 'tm-re-photo-upload-edit-meta', sanitize_text_field( $_POST['tm_re_agent_photo_upload_edit_meta'] ) );
	}

	/**
	 * Photo url
	 *
	 * @param integer agent
	 * @return string
	 */
	public static function get_agent_photo_url( $agent_id ) {
		$attachment_id = get_the_author_meta( 'tm-re-photo-upload-meta', $agent_id );

		if ( empty( $attachment_id ) ) {
			$photo_url = TM_REAL_ESTATE_URI . 'assets/images/placehold.png';
		} else {
			$image = wp_get_attachment_image_src( $attachment_id, 'medium' );
			$photo_url = $image[0];
		}

		return $photo_url;
	}

	/**
	 * Photo id
	 *
	 * @param integer agent
	 * @return integer
	 */
	public static function get_agent_photo_id( $agent_id ) {
		return (int) get_the_author_meta( 'tm-re-photo-upload-meta', $agent_id );
	}

	/**
	 * Agent`s photo url
	 *
	 * @param integer agent
	 * @return string
	 */
	public static function get_edit_agent_photo_url( $agent_id ) {
		return get_the_author_meta( 'tm-re-photo-upload-edit-meta', $agent_id );
	}
}
