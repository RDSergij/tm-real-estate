<?php

class Collection_Field extends Field_Builder implements I_Field
{
	/**
	 * Define a collection field instance.
	 *
	 * @param array $properties
	 * @param ViewFactory $view
	 */
	public function __construct(array $properties )
	{
		parent::__construct($properties );
		$this->setType(); // Set in parent class - setup the type of media to insert.
		$this->setLimit(); // Set in parent class - setup the number of media files to insert.
		$this->fieldType();
	}

	/**
	 * Method to override that defined the input type
	 * that handles the value.
	 *
	 * @return void
	 */
	protected function fieldType()
	{
		$this->type = 'collection';
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
			dirname( __FILE__ ).'/views/collection.php',
			array( 'field' => $this )
		);
	}

	/**
	 * Method that handle the field HTML code for
	 * page settings output.
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