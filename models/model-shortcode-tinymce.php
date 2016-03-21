<?php

/**
 * Add shortcode to Tinymce
 *
 * @package    Cherry_Framework
 * @subpackage Model
 * @author     Cherry Team <cherryframework@gmail.com>
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Model Shortcode_Tinymce
 */
class Shortcode_Tinymce {

	public function tm_shortcode_button() {
		if ( current_user_can ('edit_posts') && current_user_can ('edit_pages') ) {
			add_filter ('mce_external_plugins', array( 'Shortcode_Tinymce', 'tm_add_buttons' ));
			add_filter ('mce_buttons', array( 'Shortcode_Tinymce', 'tm_register_buttons' ));
		}
	}

	public function tm_add_buttons($plugin_array) {
		$plugin_array['pushortcodes'] = plugin_dir_url (__FILE__) . 'shortcode-tinymce-button.js';

		return $plugin_array;
	}

	public function tm_register_buttons($buttons) {
		foreach ( Model_Main::get_shortcodes() as $key => $value ) {
			array_push ($buttons, $value);
		}
		
		return $buttons;
	}
	
	public function tm_shortcode_view(){
		$shortcodes_view = array();
		foreach ( Model_Main::get_shortcodes() as $key => $value ) {
			if ( file_exists ( plugin_dir_path (__FILE__) . 'views/' . $value . '.php' ) ) {
				$shortcodes_view[] = plugin_dir_url (__FILE__) . 'views/' . $value . '.php';
			} else {
				$shortcodes_view[] = '';
			}
		}
		return $shortcodes_view;
	}
}
