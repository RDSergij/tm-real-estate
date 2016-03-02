<?php

class Page
{
	/**
	 * The page properties.
	 *
	 * @var DataContainer
	 */
	protected static $datas;

	/**
	 * The page validator object.
	 *
	 * @var \Themosis\Validation\ValidationBuilder
	 */
	protected $validator;

	/**
	 * The page sections.
	 *
	 * @var array
	 */
	protected $sections;

	/**
	 * The settings install action.
	 *
	 * @var static
	 */
	protected $settingsEvent;

	/**
	 * The page settings.
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * @param string $slug The page slug name.
	 * @param string $title The page display title.
	 * @param string $parent The parent's page slug if a subpage.
	 * @param IRenderable $view The page main view file.
	 * @throws PageException
	 * @return \Themosis\Page\PageBuilder
	 */
	public static function make($slug, $title, $parent = null, IRenderable $view = null)
	{
		$params = compact('slug', 'title');

		foreach ($params as $name => $param)
		{
			if (!is_string($param))
			{
				throw new PageException('Invalid page parameter "'.$name.'"');
			}
		}

		// Check the view file.
		if (!is_null($view))
		{
			$this->view = $view;
		}

		// Set the page properties.
		self::$datas['slug'] = $slug;
		self::$datas['title'] = $title;
		self::$datas['parent'] = $parent;
		self::$datas['args'] = [
			'capability'    => 'manage_options',
			'icon'          => '',
			'position'      => null,
			'tabs'          => true,
			'menu'          => $title
		];
		self::$datas['rules'] = [];

		return $this;
	}

	/**
	 * Set the custom page. Allow user to override
	 * the default page properties and add its own
	 * properties.
	 *
	 * @param array $params
	 * @return \Themosis\Page\PageBuilder
	 */
	public function set(array $params = [])
	{
		self::$datas['args'] = array_merge( self::$datas['args'], $params );

		add_action('admin_menu', array( $this, 'build' ) );

		return $this;
	}

	/**
	 * Triggered by the 'admin_menu' action event.
	 * Register/display the custom page in the WordPress admin.
	 *
	 * @return void
	 */
	public function build()
	{
		if (!is_null(self::$datas['parent']))
		{
			add_submenu_page(self::$datas['parent'], self::$datas['title'], self::$datas['args']['menu'], self::$datas['args']['capability'], self::$datas['slug'], [$this, 'displayPage']);
		}
		else
		{
			add_menu_page(self::$datas['title'], self::$datas['args']['menu'], self::$datas['args']['capability'], self::$datas['slug'], [$this, 'displayPage'], self::$datas['args']['icon'], self::$datas['args']['position']);
		}
	}

	/**
	 * Triggered by the 'add_menu_page' or 'add_submenu_page'.
	 *
	 * @return void
	 */
	public function displayPage()
	{
		// Share the page instance to the view.
		$this->with('__page', $this);

		echo($this->view->render());
	}

	/**
	 * Return a page property value.
	 *
	 * @param string $property
	 * @return mixed
	 */
	public function get($property = null)
	{
		 return (isset(self::$datas[$property])) ? self::$datas[$property] : '';
	}

	/**
	 * Allow a user to pass custom datas to
	 * the page view instance.
	 *
	 * @param string|array $key
	 * @param mixed $value
	 * @return \Themosis\Page\PageBuilder
	 */
	public function with($key, $value = null)
	{
		$this->view->with($key, $value);

		return $this;
	}

	/**
	 * Add custom sections for your settings.
	 *
	 * @param array $sections
	 * @return \Themosis\Page\PageBuilder
	 */
	public function addSections(array $sections = [])
	{
		$this->sections = $sections;

		// Pass all registered sections to the page view.
		$this->with('__sections', $this->sections);
	}

	/**
	 * Check if the page has sections.
	 *
	 * @return bool
	 */
	public function hasSections()
	{
		return count($this->sections) ? true : false;
	}

	/**
	 * Add settings to the page. Define settings per section
	 * by setting the 'key' name equal to a registered section and
	 * pass it an array of 'settings' fields.
	 *
	 * @param array $settings The page settings.
	 * @return \Themosis\Page\PageBuilder
	 */
	public function addSettings(array $settings = [])
	{
		$this->settings = $settings;

		add_action('admin_init', array( $this, 'installSettings' ) );

		return $this;
	}

	/**
	 * Triggered by the 'admin_init' action.
	 * Perform the WordPress settings API.
	 *
	 * @return void
	 */
	public function installSettings()
	{
		// The WordPress Settings API make
		// always use of sections and fields.
		// So let's set it up!
		if (self::$datas['args']['tabs'])
		{
			// A - With tabs
			$this->installWithTabs();
		}
		else
		{
			// B - Without tabs
			$this->installWithoutTabs();
		}
	}

	/**
	 * Register sections and settings in order
	 * to work with tabs.
	 *
	 * @return void
	 */
	protected function installWithTabs()
	{
		// 1 - Prepare the DB table.
		foreach ($this->sections as $section)
		{
			$section = $section->getData();

			if (false === get_option($section['slug']))
			{
				add_option($section['slug']);
			}
		}

		// 2 - Display sections
		foreach ($this->sections as $section)
		{
			$section = $section->getData();

			add_settings_section($section['slug'], $section['name'], [$this, 'displaySections'], $section['slug']);
		}

		// 3 - Display settings
		foreach ($this->settings as $section => $settings)
		{
			foreach ($settings as $setting)
			{
				// Add the section to the field.
				$setting['section'] = $section;

				add_settings_field($setting['name'], $setting['features']['title'], [$this, 'displaySettings'], $section, $section, $setting);
			}
		}

		// 4 - Register the settings and define the sanitized callback
		// Group all page settings in one, avoid polluting
		// the wp_options table.
		// When you want to retrieve a setting use the option_group
		// name and the setting id.
		foreach ($this->sections as $section)
		{
			$section = $section->getData();

			register_setting($section['slug'], $section['slug'], [$this, 'validateSettings']);
		}
	}

	/**
	 * Register sections and settings in a page.
	 *
	 * @return void
	 */
	protected function installWithoutTabs()
	{
		// 1 - Prepare the DB table.
		if (false === get_option(self::$datas['slug']))
		{
			add_option(self::$datas['slug']);
		}

		// 2 - Display sections
		foreach ($this->sections as $section)
		{
			$section = $section->getData();

			add_settings_section($section['slug'], $section['name'], [$this, 'displaySections'], self::$datas['slug']);
		}

		// 3 - Display settings
		foreach ($this->settings as $section => $settings)
		{
			foreach ($settings as $setting)
			{
				// Add the section to the field - In this case,
				// it is associated to the page slug.
				$setting['section'] = self::$datas['slug'];

				add_settings_field($setting['name'], $setting['features']['title'], [$this, 'displaySettings'], self::$datas['slug'], $section, $setting);
			}
		}

		// 4 - Register the settings and define the sanitized callback
		// Group all page settings in one, avoid polluting
		// the wp_options table.
		// When you want to retrieve a setting use the option_group
		// name and the setting id.
		register_setting(self::$datas['slug'], self::$datas['slug'], [$this, 'validateSettings']);
	}

	/**
	 * Handle section display of the Settings API.
	 *
	 * @param array $args
	 * @return void
	 */
	public function displaySections(array $args)
	{
	}

	/**
	 * Handle setting display of the Settings API.
	 *
	 * @param mixed $setting
	 * @return void
	 */
	public function displaySettings($setting)
	{
		// Check if a registered value exists.
		$value = get_option($setting['section']);
		$val = isset($value[$setting['name']]) ? $value[$setting['name']] : null;
		$setting['value'] = (!is_null($val) || !empty($val)) ? $val : $this->parseValue($setting, $val);

		// Set the name attribute.
		$setting['name'] = $setting['section'].'['.$setting['name'].']';

		// Display the setting.
		echo($setting->page());
	}

	/**
	 * Validate the defined settings.
	 *
	 * @param mixed $values
	 * @return array
	 */
	public function validateSettings($values)
	{
		// No validation rules
		if (!isset(self::$datas['rules']) || !is_array(self::$datas['rules'])) return $values;

		// Null given
		if (is_null($values)) return [];

		$sanitized = [];

		foreach ($values as $setting => $value)
		{
			$rules = array_keys(self::$datas['rules']);

			// 1 - Check if a rule exists
			if (in_array($setting, $rules))
			{
				// 1.1 - Check for infinite settings.
				if (is_array($value) && $this->isInfinite($setting))
				{
					foreach ($value as $index => $row)
					{
						if ($this->validator->isAssociative($row) && !empty($row))
						{
							foreach ($row as $infiniteSetting => $infiniteValue)
							{
								// 1.1.1 - Check if a rule is defined for the infinite sub fields.
								if (isset(self::$datas['rules'][$setting][$infiniteSetting]))
								{
									$rule = self::$datas['rules'][$setting][$infiniteSetting];

									$sanitized[$setting][$index][$infiniteSetting] = $this->validator->single($infiniteValue, $rule);
								}
								else
								{
									$sanitized[$setting][$index][$infiniteSetting] = $infiniteValue;
								}
							}
						}
					}
				}
				else
				{
					// 1.2 - Apply rule to other settings.
					$sanitized[$setting] = $this->validator->single($value, self::$datas['rules'][$setting]);
				}

			}
			else
			{
				// 2 - No rule, just set the default value.
				$sanitized[$setting] = $value;
			}
		}

		return $sanitized;
	}

	/**
	 * Set validation rules to settings.
	 *
	 * @param array $rules
	 * @return \Themosis\Page\PageBuilder
	 */
	public function validate(array $rules = [])
	{
		self::$datas['rules'] = $rules;

		return $this;
	}

	/**
	 * Check if a field/settings is of type 'infinite'.
	 *
	 * @param string $name The name of the field/setting.
	 * @return bool
	 */
	protected function isInfinite($name)
	{
		foreach ($this->settings as $settings)
		{
			foreach ($settings as $setting)
			{
				if($name === $setting['name']) return true;
			}
		}

		return false;
	}

	/**
	 * Return the active tab slug of the settings page.
	 *
	 * @return string
	 */
	protected function getActiveTab()
	{
		$firstSection = $this->sections[0]->getData();
		return isset($_GET['tab']) ? $_GET['tab'] : $firstSection['slug'];
	}

	/**
	 * Define the tab URI. Check for extra query parameters.
	 *
	 * @param string $default The default URI to check. Mainly look for query parameters.
	 * @return string
	 */
	protected function setTabUri($default)
	{
		// Get the query parameters from the slug if any...
		$params = parse_url($default, PHP_URL_QUERY);

		if (!empty($params))
		{
			return '?'.$params.'&';
		}

		return '?';
	}

	/**
	 * Helper method that output the tab navigation
	 * if available.
	 *
	 * @return void
	 */
	public function renderTabs()
	{
		if ($this->hasSections() && self::$datas['args']['tabs'])
		{
			echo('<h2 class="nav-tab-wrapper">');

				foreach ($this->sections as $section)
				{
					$section = $section->getData();
					$class = ($this->getActiveTab() === $section['slug']) ? 'nav-tab-active' : '';

					printf('<a href="%spage=%s&tab=%s" class="nav-tab %s">%s</a>', $this->setTabUri(self::$datas['parent']), self::$datas['slug'], $section['slug'], $class, $section['name']);
				}

			echo('</h2>');
		}
	}

	/**
	 * Helper method that output the page settings.
	 *
	 * @return void
	 */
	public function renderSettings()
	{
		// Check if there are sections before proceeding.
		if (!$this->hasSections()) return;

		if (self::$datas['args']['tabs'])
		{
			foreach ($this->sections as $section)
			{
				$section = $section->getData();

				// Display settings regarding the active tab.
				if ($this->getActiveTab() === $section['slug'])
				{
					settings_fields($section['slug']);
					do_settings_sections($section['slug']);
				}
			}
		}
		else
		{
			// Do not use the tab navigation.
			// Display all sections in one page.
			settings_fields(self::$datas['slug']);
			do_settings_sections(self::$datas['slug']);
		}
	}

	/**
	 * Enqueue the WordPress media scripts.
	 * Make the 'wp' object available to javascript.
	 *
	 * @return void
	 */
	public function enqueueMediaUploader()
	{
		// If WordPress version > 3.5
		if (get_bloginfo('version') >= 3.5)
		{
			wp_enqueue_media();
		}
	}

}

