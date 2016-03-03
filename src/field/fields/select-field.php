<?php

class Select_Field extends Field_Builder implements I_Field
{
	/**
	 * Define a core select field.
	 *
	 * @param array $properties
	 * @param ViewFactory $view
	 */
	public function __construct( array $properties )
	{
		parent::__construct( $properties );
		$this->fieldType();
	}

	/**
	 * Method to override to define the input type
	 * that handles the value.
	 *
	 * @return void
	 */
	protected function fieldType()
	{
		$this->type = 'select';
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
			dirname( __FILE__ ).'/views/select.php',
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