<?php

class Color_Field extends Field_Builder implements I_Field
{
	/**
	 * @param array $properties
	 * @param ViewFactory $view
	 */
	public function __construct(array $properties )
	{
		parent::__construct($properties );
		$this->fieldType();
	}

	/**
	 * Override the input type that handles the value.
	 *
	 * @return void
	 */
	protected function fieldType()
	{
		$this->type = 'text';
	}

	/**
	 * Handle the HTML code for metabox output.
	 *
	 * @return string
	 */
	public function metabox()
	{
		return View::make(
			dirname( __FILE__ ).'/views/color.php',
			array( 'field' => $this )
		);
	}

	/**
	 * Handle the HTML code for page/settings output.
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