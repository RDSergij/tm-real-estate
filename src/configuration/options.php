<?php
/**
 * Configuration customizer options engine class file
 *
 * @package photolab
 */

/**
 * Customizer Options class
 */
class Options {

	/**
	 *   _________  ____  _____/ /_____ _____  / /______
	 *  / ___/ __ \/ __ \/ ___/ __/ __ `/ __ \/ __/ ___/
	 * / /__/ /_/ / / / (__  ) /_/ /_/ / / / / /_(__  )
	 * \___/\____/_/ /_/____/\__/\__,_/_/ /_/\__/____/
	 */

	const WITHOUT_PANEL   = '__WITHOUT_PANEL__';
	const SECTIONS        = '__SECTIONS__';
	const SETTINGS        = '__SETTINGS__';
	const CONTROLS        = '__CONTROLS__';
	const CUSTOM_CLASS    = '__CLASS__';
	const REMOVE_SECTIONS = '__REMOVE_SECTIONS__';
	const OFF_SMART_NAME  = '__OFF_SMART_NAME__';

	/**
	 * $wp_customize object
	 *
	 * @var null
	 */
	private $customize = null;

	/**
	 * The image sizes.
	 *
	 * @var array
	 */
	public static $data = array();

	/**
	 * Images class constructor
	 *
	 * @param array $data engine data.
	 */
	public function __construct( $data = array() ) {
		self::$data = (array) $data;
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'scripts_and_styles' ) );
		add_action( 'customize_register', array( $this, 'register' ) );
	}

	/**
	 * This function enqueues scripts and styles in the Customizer.
	 */
	public function scripts_and_styles() {
		wp_enqueue_script(
			'my-customizer-script',
			Utils::assets_url() . '/js/customize.js',
			array( 'customize-controls', 'jquery' )
		);
	}

	/**
	 * Front End Customizer.
	 * Load setting tree.
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 * @return void
	 */
	public function register( $wp_customize ) {
		$this->customize = $wp_customize;
		$data = Utils::array_remove_right_keys(
			array(
				self::WITHOUT_PANEL,
				self::REMOVE_SECTIONS,
			),
			self::$data
		);
		$only_sections   = Utils::array_get( self::$data, self::WITHOUT_PANEL, array() );
		$only_sections   = Utils::array_get( $only_sections, self::SECTIONS, array() );
		$remove_sections = Utils::array_get( self::$data, self::REMOVE_SECTIONS, array() );

		// Add with panels
		if ( is_array( $data ) && count( $data ) ) {
			$this->add_panels( $data );
		}

		// Add sections withou panels
		if ( is_array( $only_sections ) && count( $only_sections ) ) {
			$this->add_sections( '', $only_sections );
		}

		// Remove some sections usually this is default sections
		if ( is_array( $remove_sections ) && count( $remove_sections ) ) {
			$this->remove_sections( $remove_sections );
		}

	}

	/**
	 * Add panels to customizer
	 *
	 * @param [type] $panels panels list.
	 */
	private function add_panels( $panels ) {
		if ( is_array( $panels ) && count( $panels ) ) {
			foreach ( $panels as $panel_key => $parameters ) {
				$this->add_panel( $panel_key, $parameters );
				if ( array_key_exists( self::SECTIONS, $parameters ) ) {
					$sections = $parameters[ self::SECTIONS ];
					if ( is_array( $sections ) && count( $sections ) ) {
						$this->add_sections( $panel_key, $sections );
					}
				}
			}
		}
	}

	/**
	 * Add panel to customizer
	 *
	 * @param [type] $panel      panel key.
	 * @param [type] $parameters panel parameters.
	 */
	private function add_panel( $panel, $parameters ) {
		$parameters = Utils::array_remove_right_keys( array( self::SECTIONS ), $parameters );
		$this->customize->add_panel( $panel, $parameters );
	}

	/**
	 * Add sections to customizer
	 *
	 * @param [type] $panel_key  Panel.
	 * @param [type] $sections Panel sections list.
	 */
	private function add_sections( $panel_key, $sections ) {
		foreach ( $sections as $section_key => $parameters ) {
			$parameters['panel'] = $panel_key;
			$this->add_section( $section_key, $parameters );
			if ( array_key_exists( self::CONTROLS, $parameters ) ) {
				$settings = Utils::array_get( $parameters, self::SETTINGS, array() );
				$controls = $parameters[ self::CONTROLS ];

				if ( is_array( $controls ) && count( $controls ) ) {
					$this->add_settings( $settings, $panel_key, $section_key );
					$this->add_controls( $controls, $panel_key, $section_key );
				}
			}
		}
	}

	/**
	 * Add section to customizer
	 *
	 * @param [type] $section_key section key.
	 * @param [type] $parameters  section parameters.
	 */
	private function add_section( $section_key, $parameters ) {
		$parameters = Utils::array_remove_right_keys(
			array(
				self::SETTINGS,
				self::CONTROLS,
			),
			$parameters
		);
		$this->customize->add_section( $section_key, $parameters );
	}

	/**
	 * Remove some sections
	 * usually this is default sections like:
	 * title_tagline, background_image, static_front_page, colors.
	 *
	 * @param  array $sections   section list.
	 */
	private function remove_sections( $sections = array() ) {
		if ( count( $sections ) ) {
			foreach ( $sections as $section ) {
				$this->customize->remove_section( $section );
			}
		}
	}

	/**
	 * Add settings to customizer
	 *
	 * @param [type] $settings settings list.
	 * @param [type] $panel_key panel name.
	 * @param [type] $section_key section name.
	 */
	private function add_settings( $settings, $panel_key = '', $section_key = '' ) {
		$settings = (array) $settings;
		if ( ! count( $settings ) ) {
			return false;
		}
		foreach ( $settings as $key => $value ) {
			if ( is_int( $key ) ) {
				$this->add_setting( $value, array(), $panel_key, $section_key );
			} else {
				$this->add_setting( $key, $value, $panel_key, $section_key );
			}
		}
	}

	/**
	 * Add setting to customizer
	 *
	 * @param [type] $setting_key        setting key.
	 * @param array  $setting_parameters setting parameters.
	 */
	private function add_setting( $setting_key, $setting_parameters = array(), $panel_key, $section_key ) {
		$setting_name = $this->get_setting_name( $panel_key, $section_key, $setting_key );

		$defaults = array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'manage_options',
			'sanitize_callback' => '',
		);
		$setting_parameters = array_merge( $defaults, $setting_parameters );
		$this->customize->add_setting( $setting_name, $setting_parameters );
	}

	/**
	 * Get setting name
	 *
	 * @param  [type] $panel panel name.
	 * @param  [type] $section section name.
	 * @param  [type] $setting setting name.
	 * @return setting name like: $panel[ $section ][ $setting ]
	 */
	private function get_setting_name( $panel = '', $section, $setting ) {
		if ( ! $this->is_off_smart_name( $panel, $section, $setting ) ) {
			if ( '' == $panel ) {
				return sprintf(
					'%s[%s]',
					trim( $section ),
					trim( $setting )
				);
			}
			return sprintf(
				'%s[%s][%s]',
				trim( $panel ),
				trim( $section ),
				trim( $setting )
			);
		}
		return $setting;
	}

	/**
	 * Get control name
	 *
	 * @param  [type] $panel    panel name.
	 * @param  [type] $section section name.
	 * @param  [type] $setting setting name.
	 * @return Control name like: $panel_$section_$setting
	 */
	private function get_control_name( $panel = '', $section, $setting ) {
		if ( '' == $panel ) {
			return sprintf(
				'%s_%s',
				trim( $section ),
				trim( $setting )
			);
		}
		return sprintf(
			'%s_%s_%s',
			trim( $panel ),
			trim( $section ),
			trim( $setting )
		);
	}

	/**
	 * Add controls to customizer
	 *
	 * @param [type] $controls   controls list.
	 * @param [type] $panel_key panel name.
	 * @param [type] $section_key section name.
	 */
	private function add_controls( $controls, $panel_key = '', $section_key = '' ) {
		foreach ( $controls as $key => $parameters ) {
			$setting  = $this->get_setting_name( $panel_key, $section_key, $key );
			$defaults = array(
				'settings' => $setting,
				'section'  => $section_key,
			);
			$control_key = $this->get_control_name( $panel_key, $section_key, $key );
			$control_parameters = array_merge( $defaults, $parameters );

			// If setting not added then add setting
			if ( null === $this->customize->get_setting( $setting ) ) {
				$this->add_setting( $key, array(), $panel_key, $section_key );
			}

			if ( array_key_exists( self::CUSTOM_CLASS, $parameters ) ) {
				$custom_class = $parameters[ self::CUSTOM_CLASS ];
				if ( class_exists( $custom_class ) ) {
					$this->customize->add_control(
						new $custom_class(
							$this->customize,
							$control_key,
							$control_parameters
						)
					);
				}
			} else {
				$this->customize->add_control( $control_key, $control_parameters );
			}
		}
	}

	/**
	 * Is off smart name
	 *
	 * @param  [type] $panel_key   panel name.
	 * @param  [type] $section_key section name.
	 * @param  [type] $setting_key setting name.
	 * @return boolean              true if OFF | false if ON
	 */
	private function is_off_smart_name( $panel_key, $section_key, $setting_key ) {
		if ( array_key_exists( $panel_key, self::$data ) ) {
			$panels = self::$data[ $panel_key ];
			if ( array_key_exists( self::SECTIONS, $panels ) ) {
				$sections = $panels[ self::SECTIONS ];
				if ( array_key_exists( $section_key, $sections ) ) {
					$section = $sections[ $section_key ];
					if ( array_key_exists( self::SETTINGS, $section ) ) {
						$settings = $section[ self::SETTINGS ];
						if ( array_key_exists( $setting_key, $settings ) ) {
							$setting = $settings[ $setting_key ];
							if ( array_key_exists( self::OFF_SMART_NAME, $setting ) ) {
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}

	/**
	 * Get default value
	 * 
	 * @param  [type] $panel_key   panel key.
	 * @param  [type] $section_key section key.
	 * @param  [type] $setting_key setting key.
	 * @param  [type] $default     default value.
	 * @return [type]              default value.
	 */
	public static function get_default( $panel_key, $section_key, $setting_key, $default = '' ) {
		if ( '' === $panel_key ) {
			$panel_key = self::WITHOUT_PANEL;	
		}

		if ( array_key_exists( $panel_key, self::$data ) ) {
			$panel = self::$data[ $panel_key ];
			if ( array_key_exists( self::SECTIONS, $panel ) ) {
				$sections = $panel[ self::SECTIONS ];
				if ( array_key_exists( $section_key, $sections ) ) {
					$section = $sections[ $section_key ];
					if ( array_key_exists( self::SETTINGS, $section ) ) {
						$settings = $section[ self::SETTINGS ];
						if ( array_key_exists( $setting_key, $settings ) ) {
							$setting = $settings[ $setting_key ];
							if ( array_key_exists( 'default', $setting ) ) {
								return $setting['default'];
							}
						}
					}
				}
			}
		}
		return $default;
	}

	/**
	 * Get option from DB
	 * @param  [type] $panel_key   panel key.
	 * @param  [type] $section_key section key.
	 * @param  [type] $setting_key setting key.
	 * @param  string $default     default value.
	 * @return [type]              option from db.
	 */
	public static function get_option( $panel_key, $section_key, $setting_key, $default = '' ) {
		$demo = self::get_demo_option( $panel_key, $section_key, $setting_key );
		if ( null != $demo ) {
			return $demo;
		}
		if ( '' != $panel_key ) {
			$settings = Utils::array_get(
				(array) get_theme_mod( $panel_key ),
				$section_key,
				array()
			);
		} else {
			$settings = (array) get_theme_mod( $section_key );
		}
		return Utils::array_get(
			$settings,
			$setting_key,
			self::get_default( $panel_key, $section_key, $setting_key, $default )
		);
	}

	/**
	 * Get demo option
	 *
	 * @param  [type] $panel_key   Panel key.
	 * @param  [type] $section_key Section key.
	 * @param  [type] $setting_key Setting key.
	 * @return demo option or null.
	 */
	public static function get_demo_option( $panel_key, $section_key, $setting_key ) {
		$demo = self::get_all_demo_options();
		if ( is_array( $demo ) ) {
			if ( '' == $panel_key ) {
				if ( array_key_exists( $section_key, $demo ) ) {
					$section = $demo[ $section_key ];
					if ( array_key_exists( $setting_key, $section ) ) {
						return $section[ $setting_key ];
					}
				}
			} else {
				if ( array_key_exists( $panel_key, $demo ) ) {
					$panel = $demo[ $panel_key ];
					if ( array_key_exists( $section_key, $panel ) ) {
						$section = $panel[ $section_key ];
						if ( array_key_exists( $setting_key, $section ) ) {
							return $section[ $setting_key ];
						}
					}
				}
			}
		}
		return null;
	}

	/**
	 * Get all demo options
	 *
	 * @return array demo.
	 */
	public static function get_all_demo_options() {
		if ( isset( $_GET['demo'] ) ) {
			return $_GET;
		}
		return null;
	}
}
