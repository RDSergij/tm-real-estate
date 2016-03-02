<?php
/**
 * Configuration images engine class file
 *
 * @package photolab
 */

/**
 * Images class
 */
class Images {
	/**
	 * The image sizes.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Images class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( array $data ) {
		$this->data = $data;
		$this->make();
	}

	/**
	 * Add custom image sizes.
	 *
	 * @return \Themosis\Configuration\Images
	 */
	public function make() {
		// Add registered image sizes.
		$this->add_images();

		// Add sizes to the media attachment settings dropdown list.
		add_filter( 'image_size_names_choose', array( $this, 'add_images_to_drop_down_list' ) );

		return $this;
	}

	/**
	 * Loop through the registered image sizes and add them.
	 *
	 * @return void
	 */
	protected function add_images() {
		foreach ( $this->data as $slug => $properties ) {
			list( $width, $height, $crop ) = $properties;
			add_image_size( $slug, $width, $height, $crop );
		}
	}

	/**
	 * Add image sizes to the media size dropdown list.
	 *
	 * @param array $sizes The existing sizes.
	 * @return array
	 */
	public function add_images_to_drop_down_list( array $sizes ) {
		$new = array();

		foreach ( $this->data as $slug => $properties ) {
			// If no 4th option, stop the loop.
			if ( 4 !== count( $properties ) ) {
				continue;
			}

			// Grab last property
			$show = array_pop( $properties );

			// Allow true or string value.
			// If string, use it as display name.
			if ( $show ) {
				if ( is_string( $show ) ) {
					$new[ $slug ] = $show;
				} else {
					$new[ $slug ] = $this->label( $slug );
				}
			}
		}

		return array_merge( $sizes, $new );
	}

	/**
	 * Clean the image slug for display.
	 * Remove '-', '_' and set first character to uppercase.
	 *
	 * @param type $text The text to clean.
	 * @return string
	 */
	protected function label( $text ) {
		return ucwords( str_replace( array( '-', '_' ), ' ', $text ) );
	}
}
