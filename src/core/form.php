<?php
/**
 * Form builder class file
 */

/**
 * Form builder class
 */
class Form {

	/**
	 * Charset
	 */
	const ENCODING = 'UTF-8';

	/**
	 * Build a list of HTML attributes from an array.
	 *
	 * @param  array $attributes An array of html tag attributes.
	 * @return string The html attributes output.
	 */
	public static function attributes( array $attributes ) {
		$html = array();

		foreach ((array) $attributes as $key => $value)
		{
			// For numeric keys, we will assume that the key and the value are the
			// same, as this will convert HTML attributes such as "required" that
			// may be specified as required="required", etc.
			if (is_numeric($key)) $key = $value;

			if (!is_null($value))
			{
				$html[] = $key.'="'.self::entities($value).'"';
			}
		}

		return (count($html) > 0) ? ' '.implode(' ', $html) : '';
	}

	/**
	 * Convert HTML characters to entities.
	 * The encoding specified in the application configuration file will be used.
	 *
	 * @param string $value A character to encode.
	 * @return string The encoded character.
	 */
	public static function entities($value)
	{
		return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
	}

	/**
	 * Build a label tag <label></label>.
	 *
	 * @param string $for The 'for' attribute.
	 * @param string $display The text to display.
	 * @param array $attributes Extra attributes.
	 * @return string
	 */
	public static function label($for, $display, array $attributes = array())
	{
		$merge = compact('for');

		$attributes = array_merge($attributes, $merge);

		return '<label'.self::attributes($attributes).'>'.$display.'</label>';
	}

	/**
	 * Build an input tag.
	 *
	 * @param string $type The input type attribute.
	 * @param string $name The input name attribute.
	 * @param null $value The input value attribute.
	 * @param array $attributes Extra attributes to populate.
	 * @return string An input html tag.
	 */
	public static function input($type, $name, $value = null, array $attributes = array())
	{
		$merge = compact('type', 'name', 'value');

		$attributes = array_merge($attributes, $merge);

		return '<input '.self::attributes($attributes).'>';
	}

	/**
	 * Build a text input <input type="text" />
	 *
	 * @param string $name The name attribute.
	 * @param null $value The value to display.
	 * @param array $attributes The extras attributes to add.
	 * @return string
	 */
	public static function text($name, $value = null, array $attributes = array())
	{
		return self::input('text', $name, $value, $attributes);
	}
	
	/**
	 * Build a password input <input type="password" />
	 *
	 * @param string $name The name attribute.
	 * @param string $value The value attribute.
	 * @param array $attributes The extras attributes to add.
	 * @return string
	 */
	public static function password($name, $value = null, array $attributes = array())
	{
		return self::input('password', $name, $value, $attributes);
	}

	/**
	 * Build a single email input <input type="email" />
	 *
	 * @param string $name The name attribute.
	 * @param string $value The value attribute.
	 * @param array $attributes
	 * @return string
	 */
	public static function email($name, $value = null, array $attributes = array())
	{
		if (!isset($attributes['placeholder']))
		{
			$attributes[ 'placeholder' ] = __( 'Please enter your email...', TM_TEXT_DOMAIN );
		}

		return self::input('email', $name, $value, $attributes);
	}

	/**
	 * Build a number input <input type="number" />
	 *
	 * @param string $name The name attribute.
	 * @param string $value The input value.
	 * @param array $attributes
	 * @return string
	 */
	public static function number($name, $value = null, array $attributes = array())
	{
		return self::input('number', $name, $value, $attributes);
	}

	/**
	 * Build a date input <input type="date" />
	 *
	 * @param string $name The name attribute.
	 * @param string $value The input value.
	 * @param array $attributes
	 * @return string
	 */
	public static function date($name, $value = null, array $attributes = array())
	{
		return self::input('date', $name, $value, $attributes);
	}

	/**
	 * Build a single hidden input <input type="hidden" />
	 *
	 * @param string $name The name attribute.
	 * @param null $value The value attribute.
	 * @param array $attributes
	 * @return string
	 */
	public static function hidden($name, $value = null, array $attributes = array())
	{
		return self::input('hidden', $name, $value, $attributes);
	}

	/**
	 * Build a single or multiple checkbox input <input type="checkbox" />
	 *
	 * @param string $name The input name attribute.
	 * @param string|array $choices The available choices/acceptable values.
	 * @param string|array $value String value if single, array value if multiple.
	 * @param array $attributes Input extra attributes.
	 * @return string
	 */
	public static function checkbox($name, $choices, $value = '', array $attributes = array())
	{
		return self::makeGroupCheckableField('checkbox', $name, (array) $choices, (array) $value, $attributes);
	}

	/**
	 * Build a group of checkbox.
	 *
	 * @deprecated
	 * @param string $name The group name attribute.
	 * @param array $choices The available choices.
	 * @param array $value The checked values.
	 * @param array $attributes
	 * @return string
	 */
	public static function checkboxes($name, array $choices, array $value = array(), array $attributes = array())
	{
		return self::makeGroupCheckableField('checkbox', $name, $choices, $value, $attributes);
	}

	/**
	 * Build a group of radio input <input type="radio">
	 *
	 * @param string $name The input name attribute.
	 * @param string|array $choices The radio field options.
	 * @param string|array $value The input value. Muse be an array!
	 * @param array $attributes
	 * @return string
	 */
	public static function radio($name, $choices, $value = '', array $attributes = array())
	{
		return self::makeGroupCheckableField('radio', $name, (array) $choices, (array) $value, $attributes);
	}

	/**
	 * Helper method to build checkbox or radio tag.
	 *
	 * @param string $type The type of the input.
	 * @param string $name Name of the group.
	 * @param array $choices The tag choice.
	 * @param array $value The values of the group
	 * @param array $attributes
	 * @return string
	 */
	private function makeGroupCheckableField($type, $name, array $choices, array $value, array $attributes)
	{
		$field = '';

		foreach($choices as $choice)
		{
			// Check the value.
			// If checked, add the attribute.
			if (in_array($choice, $value))
			{
				$attributes['checked'] = 'checked';
			}

			// Build html output
			$field.= '<label>'.self::input($type, $name.'[]', $choice, $attributes).ucfirst($choice).'</label>';

			// Reset 'checked' attributes.
			unset($attributes['checked']);
		}

		return $field;
	}

	/**
	 * Build a textarea tag <textarea></textarea>
	 *
	 * @param string $name The name attribute.
	 * @param null|string $value The content of the textarea.
	 * @param array $attributes
	 * @return string
	 */
	public static function textarea($name, $value = null, array $attributes = array())
	{
		$merge = compact('name');

		$attributes = array_merge($attributes, $merge);

		return '<textarea name="'.$name.'" '.self::attributes($attributes).'>'.$value.'</textarea>';
	}

	/**
	 * Build a select open tag <select>
	 *
	 * @param string $name The name attribute of the field.
	 * @param array $options The options of the select tag.
	 * @param null $value string if single, array if multiple enabled.
	 * @param array $attributes
	 * @return string
	 */
	public static function select($name, array $options = array(), $value = null, array $attributes = array())
	{
		$merge = compact('name');

		$attributes = array_merge($attributes, $merge);

		// Check if multiple is defined.
		// If defined, change the name attribute.
		if (isset($attributes['multiple']) && 'multiple' === $attributes['multiple'])
		{
			$attributes['name'] = $attributes['name'].'[]';
		}
		else
		{
			unset($attributes['multiple']);
		}

		// Build the options of the select tag.
		$options = self::makeOptionTags($options, $value);

		return '<select'.self::attributes($attributes).'>'.$options.'</select>';
	}

	/**
	 * Define inner option tags for the select tag.
	 *
	 * @param array $options The option fields to output.
	 * @param mixed $value Array if multiple, string if single.
	 * @return string
	 */
	private function makeOptionTags(array $options, $value)
	{
		$output = '';

		$options = self::parseSelectOptions($options);

		// Start looping through the options.
		foreach ($options as $key => $option)
		{
			// Check the $key. If $key is a string, then we are dealing
			// with <optgroup> tags.
			if (is_string($key))
			{
				$output.= self::buildOptgroupTags($key, $option, $value);
			}
			else
			{
				// No <optgroup> tags, $key is int.
				$output.= self::parseOptionTags($option, $value);
			}
		}
		// End options loop.

		return $output;
	}

	/**
	 * Parse the options and re-order optgroup options if no custom keys defined.
	 *
	 * @param array $options The select tag options.
	 * @throws Exception
	 * @return array The parsed options.
	 */
	private function parseSelectOptions(array $options)
	{
		$parsedOptions = array();

		foreach($options as $key => $option)
		{
			// Check $option is array in order to continue.
			if (!is_array($option)) throw new Exception("In order to build the select tag, the parameter must be an array of arrays.");

			// Re-order <optgroup> options
			if (is_string($key))
			{
				$parsedOptions[$key] = self::organizeOptions($options, $option);
			}
			else
			{
				$parsedOptions[$key] = $option;
			}
		}

		return $parsedOptions;
	}

	/**
	 * Re-order/re-index <optgroup> options.
	 *
	 * @param array $options The select tag options(all).
	 * @param array $subOptions The optgroup options.
	 * @return array
	 */
	private function organizeOptions(array $options, array $subOptions)
	{
		$indexedOptions = array();
		$convertedOptions = array();

		// Build the re-indexed options array.
		foreach ($options as $group)
		{
			foreach ($group as $i => $value)
			{
				// Custom values - No need to change something.
				if (is_string($i))
				{
					$indexedOptions[$i] = $value;
				}
				else
				{
					// Int values - Reorder options so there are
					// no duplicates.
					array_push($indexedOptions, $value);
				}
			}
		}

		// Grab the converted values and return them.
		foreach ($indexedOptions as $index => $option)
		{
			if (in_array($option, $subOptions))
			{
				$convertedOptions[$index] = $option;
			}
		}

		return $convertedOptions;
	}

	/**
	 * Build the option group tag <optgroup></optgroup>
	 *
	 * @param string $label The tag label attribute.
	 * @param array $options The options to add to the group.
	 * @param mixed $value See makeOptionTags method.
	 * @return string
	 */
	private function buildOptgroupTags($label, array $options, $value)
	{
		$options = self::parseOptionTags($options, $value);

		return '<optgroup label="'.ucfirst($label).'">'.$options.'</optgroup>';
	}

	/**
	 * Prepare select tag options for output.
	 *
	 * @param array $options The option values.
	 * @param mixed $value Array if multiple, string if single.
	 * @return string
	 */
	private function parseOptionTags(array $options, $value)
	{
		$output = '';

		foreach ($options as $key => $option)
		{
			$selected = self::setSelectable($key, $value);
			$output.= self::makeOptionTag($key, $option, $selected);
		}

		return $output;
	}

	/**
	 * Build an option tag <option></option>
	 *
	 * @param mixed $key String if custom "value", otherwise int.
	 * @param string $option Option name to display.
	 * @param string $selected The selected attribute.
	 * @return string
	 */
	private function makeOptionTag($key, $option, $selected = null)
	{
		return '<option value="'.$key.'" '.$selected.'>'.ucfirst($option).'</option>';
	}

	/**
	 * Define the selected attribute of an option tag.
	 *
	 * @param string $key The option tag value.
	 * @param mixed $value The retrieved value. Array if multiple, string if single.
	 * @return string
	 */
	private function setSelectable($key, $value)
	{
		$selected = 'selected="selected"';
		// Deal if multiple selection.
		if (is_array($value) && in_array($key, $value))
		{
			return $selected;
		}

		// Deal single selection.
		// $key might be an int or a string
		if (is_string($value) && $key == $value)
		{
			return $selected;
		}

		return '';
	}

	/**
	 * Output a <button type="button"> tag.
	 *
	 * @param string $name The tag name attribute.
	 * @param string $display The button display text.
	 * @param array $attributes Other tag attributes.
	 * @return string
	 */
	public static function button($name, $display = null, array $attributes = array())
	{
		return self::makeButton('button', $name, $display, $attributes);
	}

	/**
	 * @param string $name The tag name attribute.
	 * @param null $display The button display text.
	 * @param array $attributes Other tag attributes.
	 * @return string
	 */
	public static function submit($name, $display = null, array $attributes = array())
	{
		return self::makeButton('submit', $name, $display, $attributes);
	}

	/**
	 * Build a <button> tag.
	 *
	 * @param string $type The button type attribute.
	 * @param string $name The button name attribute.
	 * @param string $display The button display text.
	 * @param array $attributes Other tag attributes.
	 * @return string
	 */
	private function makeButton($type, $name, $display = null, array $attributes = array())
	{
		$merge = compact('type', 'name');

		$attributes = array_merge($attributes, $merge);

		return '<button '.self::attributes($attributes).'>'.$display.'</button>';
	}

}
