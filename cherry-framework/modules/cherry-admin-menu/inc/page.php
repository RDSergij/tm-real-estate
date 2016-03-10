<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Page_Builder' ) ) {

	class Page_Builder {

		/**
		 * The page properties.
		 *
		 * @var DataContainer
		 */
		protected $datas;

		/**
		 * The page properties.
		 *
		 * @var DataContainer
		 */
		public $views;

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
		public static function make( $slug, $title, $parent = null, $views = null )
		{
			$page = new Page_Builder();
			$params = compact('slug', 'title');

			foreach ( $params as $name => $param ) {
				if ( ! is_string( $param ) ) {
					throw new PageException( 'Invalid page parameter " ' . $name . ' " ' );
				}
			}

			// Check the view file.
			if ( ! is_null( $views ) ) {
				$page->views = $views;
			}

			// Set the page properties.
			$page->data['slug'] = $slug;
			$page->data['title'] = $title;
			$page->data['parent'] = $parent;
			$page->data['args'] = [
				'capability'    => 'manage_options',
				'icon'          => '',
				'position'      => null,
				'tabs'          => true,
				'menu'          => $title
			];
			$page->data['rules'] = [];

			return $page;
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
			$this->data['args'] = array_merge( $this->data['args'], $params );

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
			if (!is_null($this->data['parent']))
			{
				add_submenu_page($this->data['parent'], $this->data['title'], $this->data['args']['menu'], $this->data['args']['capability'], $this->data['slug'], array($this, 'render'));
			}
			else
			{
				add_menu_page($this->data['title'], $this->data['args']['menu'], $this->data['args']['capability'], $this->data['slug'], array($this, 'render'), $this->data['args']['icon'], $this->data['args']['position']);
			}
		}

		/**
		 * Triggered by the 'add_menu_page' or 'add_submenu_page'.
		 *
		 * @return void
		 */
		public function render() {
			$title		= $this->data['title'];
			$page_slug	= $this->data['slug'];
			$sections	= $this->sections;
//			$settings	= $this->settings;
//
//			foreach( $sections as $section_slug => &$section ) {
//				foreach ( $this->settings as &$setting ) {
//					$setting['html'] = $this->display_settings( $setting );
//				}
//			}

			ob_start();
			include( $this->views . 'page.php' );
			$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}

		/**
		 * Return a page property value.
		 *
		 * @param string $property
		 * @return mixed
		 */
		public function get($property = null)
		{
			 return (isset($this->data[$property])) ? $this->data[$property] : '';
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
		 * Check if the page has settings.
		 *
		 * @return bool
		 */
		public function has_settings()
		{
			return count($this->settings) ? true : false;
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

			add_action('admin_init', array( $this, 'install_settings' ) );

			return $this;
		}

		/**
		 * Triggered by the 'admin_init' action.
		 * Perform the WordPress settings API.
		 *
		 * @return void
		 */
		public function install_settings()
		{
			//var_dump( $_POST );
			foreach ( $this->sections as $section ) {
				if ( false === get_option( $section['slug'] ) ) {
					//add_option( $section['slug'] );
				}
				add_settings_section( $section['slug'], $section['name'], array( $this, 'display_sections' ), $section['slug'] );
			}

			if ( $this->has_settings() ) {
				foreach ( $this->settings as $section => $settings ) {
					foreach( $settings as &$setting) {
						$setting['section'] = $section;
						add_settings_field( $setting['slug'], $setting['title'], array( $this, 'display_settings' ), $section, $section, $setting);
						register_setting( $section, $setting['slug'] );
					}
				}
			}
		}

		/**
		 * Save settings
		 *
		 * @param array $args
		 * @return void
		 */
		public function save_settings( $values )
		{
			//var_dump( $values );
			//var_dump( $_POST );
			//die();
			return $values;
		}

		/**
		 * Handle section display of the Settings API.
		 *
		 * @param array $args
		 * @return void
		 */
		public function display_sections( array $args ) {
			$description = '';
			if ( ! empty( $this->sections[ $args['id'] ] ) ) {
				if ( ! empty( $this->sections[ $args['id'] ]['description'] ) ) {
					$description = $this->sections[ $args['id'] ]['description'];
				}
			}
			ob_start();
			include( $this->views . 'section.php' );
			$html = ob_get_contents();
			ob_end_clean();
			echo $html;
		}

		/**
		 * Handle setting display of the Settings API.
		 *
		 * @param mixed $setting
		 * @return void
		 */
		public function display_settings( $setting ) {

			// Check if a registered value exists.
			$value = get_option( $setting['section'] );

			if ( isset( $value[ $setting['slug'] ] ) ) {
				$setting['field']['value'] = $value[ $setting['slug'] ];
			} elseif( isset( $setting['field']['value'] ) ) {
				$setting['field']['value'] = $setting['field']['value'];
			} else {
				$setting['field']['value'] = '';
			}

			// Set the name attribute.
			$setting['field']['name'] = $setting['slug'];//$setting['section'].'['.$setting['field']['slug'].']';

			if ( ! empty( $setting['type'] ) && class_exists( 'UI_' . ucfirst( $setting['type'] ) ) ) {
				$ui_class = 'UI_' . ucfirst( $setting['type'] );
				$ui_element = new $ui_class( $setting['field'] );

				// Display the field.
				echo $ui_element->render();
			}
		}

	}
}