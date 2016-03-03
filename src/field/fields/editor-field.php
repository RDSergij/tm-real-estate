<?php

class Editor_Field extends Field_Builder implements I_Field
{
	/**
	 * Build an EditorField instance.
	 *
	 * @param array $properties
	 * @param ViewFactory $view
	 */
	public function __construct(array $properties )
	{
		parent::__construct($properties );
		$this->fieldType();
	}

	/**
	 * Set default settings for the WordPress editor.
	 *
	 * @return void
	 */
	protected function setSettings()
	{
		$settings = [
			'textarea_name' => $this['name']
		];

		$this['settings'] = isset($this['settings']) ? array_merge($settings, $this['settings']) : $settings;
	}

	/**
	 * Define input where the value is saved.
	 *
	 * @return void
	 */
	protected function fieldType()
	{
		$this->type = 'textarea';
	}

	/**
	 * Method that handle the field HTML code for
	 * metabox output.
	 *
	 * @return string
	 */
	public function metabox()
	{
		$this->setSettings();
		return View::make(
			dirname( __FILE__ ).'/views/editro.php',
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