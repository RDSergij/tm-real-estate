<?php
/**
 * Description: Fox ui-elements
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 *
 * @package ui_tooltip_fox
 *
 * @since 0.3
 */

if ( ! class_exists( 'UI_Tooltip_Fox' ) ) {

	/**
	 * UI-input.
	 */
	class UI_Tooltip_Fox {

		/**
		 * Default settings
		 *
		 * @var type array
		 */
		private $default_settings = array(
			'id'				=> 'tooltip-fox',
			'class'				=> '',
			'direction'			=> 'right',
			'title'				=> 'More Info',
			'description'		=> '',
		);

		/**
		 * Required settings
		 *
		 * @var type array
		 */
		private $required_settings = array(
			'class'				=> 'tooltip-fox',
		);

		/**
		 * Settings
		 *
		 * @var type array
		 */
		public $settings;

		/**
		 * Init base settings
		 */
		public function __construct( $attr = null ) {
			if ( empty( $attr ) || ! is_array( $attr ) ) {
				$attr = $this->default_settings;
			} else {
				foreach ( $this->default_settings as $key => $value ) {
					if ( empty( $attr[ $key ] ) ) {
						$attr[ $key ] = $this->default_settings[ $key ];
					}
				}
			}

			$this->settings = $attr;
		}

		/**
		 * Add styles
		 */
		private function assets() {
			$url = get_template_directory_uri() . '/src/ui/ui-tooltip/assets/css/tooltip.min.css';
			wp_enqueue_style( 'tooltip-fox', $url, array(), '0.1', 'all' );
		}

		/**
		 * Render html
		 *
		 * @return string
		 */
		public function output() {
			$this->assets();
			foreach ( $this->required_settings as $key => $value ) {
				$this->settings[ $key ] = empty( $this->settings[ $key ] ) ? $value : $this->settings[ $key ] . ' ' . $value;
			}

			$title = $description = $direction= '';
			if ( ! empty( $this->settings['title'] ) ) {
				$title = $this->settings['title'];
			}
			if ( ! empty( $this->settings['description'] ) ) {
				$description = $this->settings['description'];
			}
			if ( ! empty( $this->settings['direction'] ) ) {
				$direction = $this->settings['direction'];
			} else {
				$direction = 'right';
			}
			unset( $this->settings['title'], $this->settings['description'], $this->settings['direction'] );

			$attributes = '';
			foreach ( $this->settings as $key => $value ) {
				$attributes .= ' ' . $key . '="' . $value . '"';
			}

			return View::make(
				__DIR__ . '/ui-tooltip/views/tooltip.php',
				array(
					'attributes'	=> $attributes,
					'title'			=> $title,
					'description'	=> $description,
					'direction'		=> $direction,
				)
			);
		}
	}
}
