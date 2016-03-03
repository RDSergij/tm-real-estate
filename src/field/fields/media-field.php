<?php

class Media_Field extends Field_Builder implements I_Field
{
	/**
	 * Build a MediaField instance.
	 *
	 * @param array $properties
	 * @param ViewFactory $view
	 */
	public function __construct( array $properties )
	{
		parent::__construct( $properties );
		$this->fieldType();
		$this->setType(); // Set in parent class - setup the type of media to insert.
	}

	/**
	 * Define the input type that handle the data.
	 *
	 * @return void
	 */
	protected function fieldType()
	{
		$this->type = 'hidden';
	}

	/**
	 * Method that handle the field HTML code for
	 * metabox output.
	 *
	 * @return string
	 */
	public function metabox()
	{
		return View::make(
			dirname( __FILE__ ).'/views/media.php',
			array( 'field' => $this )
		);
	}

	/**
	 * Handle the field HTML code for the
	 * Settings API output.
	 *
	 * @return string
	 */
	public function page()
	{
		return $this->metabox();
	}

	/**
	 * Handle the HTML code for user output.
	 *
	 * @return string
	 */
	public function user()
	{
		return $this->metabox();
	}
}
