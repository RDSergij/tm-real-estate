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
		array_push ($buttons, 'separator', 'pushortcodes');
		return $buttons;
	}

	public function tm_get_shortcodes() {
		global $shortcode_tags;

		echo '<script type="text/javascript">
			var shortcodes_button = new Array();';

		$count = 0;

		foreach ( $shortcode_tags as $tag => $code ) {
			echo "shortcodes_button[{$count}] = '{$tag}';";
			$count++;
		}

		echo '</script>';
	}

}
