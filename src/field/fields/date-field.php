<?php

class Date_Field extends Field_Builder implements I_Field {
	/**
	 * Define a core TextField.
	 *
	 * @param array $properties The text field properties.
	 * @param ViewFactory $view
	 */
	public function __construct(array $properties )
	{
		parent::__construct($properties );
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
		$this->type = 'date';
	}

	/**
	 * Handle the field HTML code for metabox output.
	 *
	 * @return string
	 */
	public function metabox()
	{
		return View::make(
			dirname( __FILE__ ).'/views/date.php',
			array( 'field' => $this )
		);
	}

	/**
	 * Handle the field HTML code for the Settings API output.
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