<?php
/**
 * Customizer options config file
 * List structure:
 * PANEL -> SECTION -> CONROLS
 *
 * @package photolab
 */
return array(
	'general_site_settings' => array(
		'title'       => __( 'General site settings', 'blogetti' ),
		'description' => __( 'This is general site settings.', 'blogetti' ),
		'priority'    => 10,
		'__SECTIONS__'    => array(

			// Site title & Tagline SECTION
			'site_title_and_tageline' => array(
				'title'       => __( 'Site title & Tagline', 'blogetti' ),
				'description' => __( 'This is a Site Title & Tagline section.', 'blogetti' ),
				'__SETTINGS__'    => array(
					'blogname' => array(
						'default'            => get_option( 'blogname' ),
						'__OFF_SMART_NAME__' => true,
						'type'               => 'option',
					),
					'blogdescription' => array(
						'default'            => get_option( 'blogdescription' ),
						'__OFF_SMART_NAME__' => true,
						'type'               => 'option',
					),
				),
				'__CONTROLS__'    => array(
					'blogname' => array( 'label' => __( 'Site Title', 'blogetti'  ) ),
					'blogdescription' => array( 'label' => __( 'Tagline', 'blogetti' ) ),
				),
			),

			// Logo & Favicon SECTION
			'logo_and_favicon' => array(
				'title' => __( 'Logo & Favicon', 'blogetti' ),
				'__SETTINGS__' => array(
					'logo'           => array( 'default' => '' ),
					'favicon'        => array( 'default' => get_template_directory_uri().'/favicon.png' ),
					'show_preloader' => array( 'default' => '1' ),
				),
				'__CONTROLS__' => array(
					'logo' => array(
						'label'     => __( 'Upload a logo', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Image_Control',
					),
					'favicon' => array(
						'label'     => __( 'Upload a favicon', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Image_Control',
					),
					'show_preloader' => array(
						'label' => __( 'Enable / Disable page preloader', 'blogetti' ),
						'type'  => 'checkbox',
					),
				),
			),

			// Breadcrumbs SECTION
			'breadcrumbs' => array(
				'title' => __( 'Breadcrumbs', 'blogetti' ),
				'__SETTINGS__' => array(
					'show_page_title' => array( 'default' => '' ),
					'show_breadcrubs' => array( 'default' => '1' ),
					'full_minifide' => array( 'default' => '1' ),
				),
				'__CONTROLS__' => array(
					'show_page_title' => array(
						'label'    => __( 'Enable / Disable page title in breadcrumbs area', 'blogetti' ),
						'type'     => 'checkbox',
					),
					'show_breadcrubs' => array(
						'label'    => __( 'Enable / Disable breadcrumbs', 'blogetti' ),
						'type'     => 'checkbox',
					),
					'full_minifide' => array(
						'label'    => __( 'Show full / Minified breadcrumbs path', 'blogetti' ),
						'type'     => 'checkbox',
					),
				),
			),

			// Social links SECTION
			'social_links' => array(
				'title' => __( 'Social links', 'blogetti' ),
				'__SETTINGS__' => array(
					'show_in_header' => array( 'default' => '1' ),
					'show_in_footer' => array( 'default' => '1' ),
					'show_in_posts'  => array( 'default' => '1' ),
					'show_in_post'   => array( 'default' => '1' ),
					'rss_feed'       => array( 'default' => '' ),
					'facebook'       => array( 'default' => '#' ),
					'twitter'        => array( 'default' => '#' ),
					'google_plus'    => array( 'default' => '#' ),
					'instagram'      => array( 'default' => '#' ),
					'linked_in'      => array( 'default' => '#' ),
					'dribbble'       => array( 'default' => '#' ),
					'youtube'        => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'show_in_header' => array(
						'label' => __( 'Show social links in header', 'blogetti' ),
						'type'  => 'checkbox',
					),
					'show_in_footer' => array(
						'label' => __( 'Show social links in footer', 'blogetti' ),
						'type'  => 'checkbox',
					),
					'show_in_posts' => array(
						'label' => __( 'Add social sharing to blog posts', 'blogetti' ),
						'type'  => 'checkbox',
					),
					'show_in_post' => array(
						'label' => __( 'Add social sharing to single blog post', 'blogetti' ),
						'type'  => 'checkbox',
					),
					'rss_feed' => array( 'label' => __( 'RSS Feed link', 'blogetti' ) ),
					'facebook' => array( 'label' => __( 'Facebook URL', 'blogetti' ) ),
					'twitter' => array( 'label' => __( 'Twitter URL', 'blogetti' ) ),
					'google_plus' => array( 'label' => __( 'Google+ URL', 'blogetti' ) ),
					'instagram' => array( 'label' => __( 'Instagram URL', 'blogetti' ) ),
					'linked_in' => array( 'label' => __( 'LinkedIn URL', 'blogetti' ) ),
					'dribbble' => array( 'label' => __( 'Dribbble URL', 'blogetti' ) ),
					'youtube' => array( 'label' => __( 'Youtube URL', 'blogetti' ) ),
				),
			),

			// Page layout settings SECTION
			'page_layout_settings' => array(
				'title' => __( 'Page layout settings', 'blogetti' ),
				'__SETTINGS__' => array(
					'layout'        => array( 'default' => 'default' ),
					'width'         => array( 'default' => '1200' ),
					'sidebar_width' => array( 'default' => '1__3' ),
				),
				'__CONTROLS__' => array(
					'layout' => array(
						'label'    => __( 'Layout style', 'blogetti' ),
						'type'     => 'select',
						'choices'  => array(
							'default'	=> __( 'Default', 'blogetti' ),
							'boxed'		=> __( 'Boxed', 'blogetti' ),
							'full'		=> __( 'Full width', 'blogetti' ),
						),
					),
					'width' => array( 'label' => __( 'Container width', 'blogetti' ) ),
					'sidebar_width'  => array(
						'label'    => __( 'Sidebar width', 'blogetti' ),
						'type'     => 'select',
						'choices'  => array(
							'1__3' => '⅓',
							'1__4' => '¼',
						),
					),
				),
			),
		),
	),
	'color_scheme' => array(
		'priority'    => 11,
		'title'       => __( 'Color scheme', 'blogetti' ),
		'description' => '',
		'__SECTIONS__'    => array(

			// Regular SECTION
			'regular' => array(
				'title' => __( 'Regular', 'blogetti' ),
				'__SETTINGS__' => array(
					'accent1'     => array( 'default' => '#fe7545' ),
					'accent2'     => array( 'default' => '#303043' ),
					'accent3'     => array( 'default' => '#aeaebe' ),
					'text'       => array( 'default' => '#303043' ),
					'link_hover' => array( 'default' => '#303043' ),
					'heading1'    => array( 'default' => '#303043' ),
					'heading2'    => array( 'default' => '#303043' ),
					'heading3'    => array( 'default' => '#303043' ),
					'heading4'    => array( 'default' => '#303043' ),
					'heading5'    => array( 'default' => '#303043' ),
					'heading6'    => array( 'default' => '#303043' ),
				),
				'__CONTROLS__' => array(
					'accent1' => array(
						'label' => __( 'Accent 1', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'accent2' => array(
						'label' => __( 'Accent 2', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'accent3' => array(
						'label' => __( 'Accent 3', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'text' => array(
						'label' => __( 'Text', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'link_hover' => array(
						'label' => __( 'Link hover', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading1' => array(
						'label' => __( 'Heading 1', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading2' => array(
						'label' => __( 'Heading 2', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading3' => array(
						'label' => __( 'Heading 3', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading4' => array(
						'label' => __( 'Heading 4', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading5' => array(
						'label' => __( 'Heading 5', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading6' => array(
						'label' => __( 'Heading 6', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
				),
			),

			// Invert SECTION
			'invert' => array(
				'title' => __( 'Invert', 'blogetti' ),
				'__SETTINGS__' => array(
					'accent1'     => array( 'default' => '#303043' ),
					'accent2'     => array( 'default' => '#fe7545' ),
					'accent3'     => array( 'default' => '#ffffff' ),
					'text'       => array( 'default' => '#8f8fb0' ),
					'link_hover' => array( 'default' => '#fe7545' ),
					'heading1'    => array( 'default' => '#ffffff' ),
					'heading2'    => array( 'default' => '#ffffff' ),
					'heading3'    => array( 'default' => '#ffffff' ),
					'heading4'    => array( 'default' => '#ffffff' ),
					'heading5'    => array( 'default' => '#ffffff' ),
					'heading6'    => array( 'default' => '#ffffff' ),
				),
				'__CONTROLS__' => array(
					'accent1' => array(
						'label' => __( 'Accent 1', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'accent2' => array(
						'label' => __( 'Accent 2', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'accent3' => array(
						'label' => __( 'Accent 3', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'text' => array(
						'label' => __( 'Text', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'link_hover' => array(
						'label' => __( 'Link hover', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading1' => array(
						'label' => __( 'Heading 1', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading2' => array(
						'label' => __( 'Heading 2', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading3' => array(
						'label' => __( 'Heading 3', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading4' => array(
						'label' => __( 'Heading 4', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading5' => array(
						'label' => __( 'Heading 5', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'heading6' => array(
						'label' => __( 'Heading 6', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
				),
			),
		),
	),
	'typography_settings' => array(
		'priority'    => 12,
		'title'       => __( 'Typography settings', 'blogetti' ),
		'description' => '',
		'__SECTIONS__'    => array(
			'google_api' => array(
				'title' => __( 'Google API', 'blogetti' ),
				'__SETTINGS__' => array(
					'api_key' => array( 'default' => 'AIzaSyC8ABgdjegQgcxF9zkhmV2gkXM5l0mgFB8' ),
				),
				'__CONTROLS__' => array(
					'api_key' => array( 'label' => __( 'API key', 'blogetti' ) ),
				),
			),
			'body_text' => array(
				'title' => __( 'Body text', 'blogetti' ),
				'__SETTINGS__' => array(
					'font_family'  => array( 'default' => 'family=Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic&amp;subset=greek-ext,cyrillic,greek,latin-ext,vietnamese,latin,cyrillic-ext' ),
					'font_style'   => array( 'default' => '' ),
					'font_size'    => array( 'default' => '16px' ),
					'font_weight'  => array( 'default' => '300' ),
					'line_height'  => array( 'default' => '1.375em' ),
					'letter_space' => array( 'default' => '' ),
					'text_align'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'font_family' => array(
						'label' => __( 'Font family', 'blogetti' ),
						'type'  => 'select',
						'choices' => Model_Typography_Settings::get_google_fonts(),
					),
					'font_style'    => array(
						'label' => __( 'Font style', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'normal'  => 'normal',
							'italic'  => 'italic',
							'oblique' => 'oblique',
							'inherit' => 'inherit',
						),
					),
					'font_size'     => array( 'label' => __( 'Font size', 'blogetti' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'blogetti' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'blogetti' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'blogetti' ) ),
					'text_align'    => array(
						'label' => __( 'Text align', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'inherit' => 'inherit',
							'center'  => 'center',
							'justify' => 'justify',
							'left'    => 'left',
							'right'   => 'right',
						),
					),
				),
			),
			'breadcrumbs_typography' => array(
				'title' => __( 'Breadcrumbs typography', 'blogetti' ),
				'__SETTINGS__' => array(
					'font_family'  => array( 'default' => 'family=Roboto:100,100italic,300,300italic,regular,italic,500,500italic,700,700italic,900,900italic&amp;subset=greek-ext,cyrillic,greek,latin-ext,vietnamese,latin,cyrillic-ext' ),
					'font_style'   => array( 'default' => '' ),
					'font_size'    => array( 'default' => '16px' ),
					'font_weight'  => array( 'default' => '300' ),
					'line_height'  => array( 'default' => '1.375em' ),
					'letter_space' => array( 'default' => '' ),
					'text_align'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'font_family' => array(
						'label' => __( 'Font family', 'blogetti' ),
						'type'  => 'select',
						'choices' => Model_Typography_Settings::get_google_fonts(),
					),
					'font_style'    => array(
						'label' => __( 'Font style', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'normal'  => 'normal',
							'italic'  => 'italic',
							'oblique' => 'oblique',
							'inherit' => 'inherit',
						),
					),
					'font_size'     => array( 'label' => __( 'Font size', 'blogetti' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'blogetti' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'blogetti' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'blogetti' ) ),
					'text_align'    => array(
						'label' => __( 'Text align', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'inherit' => 'inherit',
							'center'  => 'center',
							'justify' => 'justify',
							'left'    => 'left',
							'right'   => 'right',
						),
					),
				),
			),
			'h1_heading' => array(
				'title' => __( 'H1 heading', 'blogetti' ),
				'__SETTINGS__' => array(
					'font_family'  => array( 'default' => 'family=Noto Serif:regular,italic,700,700italic&amp;subset=greek-ext,cyrillic,greek,latin-ext,vietnamese,latin,cyrillic-ext' ),
					'font_style'   => array( 'default' => '' ),
					'font_size'    => array( 'default' => '60px' ),
					'font_weight'  => array( 'default' => '700' ),
					'line_height'  => array( 'default' => '1.3em' ),
					'letter_space' => array( 'default' => '0.1px' ),
					'text_align'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'font_family' => array(
						'label' => __( 'Font family', 'blogetti' ),
						'type'  => 'select',
						'choices' => Model_Typography_Settings::get_google_fonts(),
					),
					'font_style'    => array(
						'label' => __( 'Font style', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'normal'  => 'normal',
							'italic'  => 'italic',
							'oblique' => 'oblique',
							'inherit' => 'inherit',
						),
					),
					'font_size'     => array( 'label' => __( 'Font size', 'blogetti' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'blogetti' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'blogetti' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'blogetti' ) ),
					'text_align'    => array(
						'label' => __( 'Text align', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'inherit' => 'inherit',
							'center'  => 'center',
							'justify' => 'justify',
							'left'    => 'left',
							'right'   => 'right',
						),
					),
				),
			),
			'h2_heading' => array(
				'title' => __( 'H2 heading', 'blogetti' ),
				'__SETTINGS__' => array(
					'font_family'  => array( 'default' => 'family=Noto Serif:regular,italic,700,700italic&amp;subset=greek-ext,cyrillic,greek,latin-ext,vietnamese,latin,cyrillic-ext' ),
					'font_style'   => array( 'default' => '' ),
					'font_size'    => array( 'default' => '40' ),
					'font_weight'  => array( 'default' => '700' ),
					'line_height'  => array( 'default' => '1.25em' ),
					'letter_space' => array( 'default' => '0.1px' ),
					'text_align'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'font_family' => array(
						'label' => __( 'Font family', 'blogetti' ),
						'type'  => 'select',
						'choices' => Model_Typography_Settings::get_google_fonts(),
					),
					'font_style'    => array(
						'label' => __( 'Font style', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'normal'  => 'normal',
							'italic'  => 'italic',
							'oblique' => 'oblique',
							'inherit' => 'inherit',
						),
					),
					'font_size'     => array( 'label' => __( 'Font size', 'blogetti' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'blogetti' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'blogetti' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'blogetti' ) ),
					'text_align'    => array(
						'label' => __( 'Text align', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'inherit' => 'inherit',
							'center'  => 'center',
							'justify' => 'justify',
							'left'    => 'left',
							'right'   => 'right',
						),
					),
				),
			),
			'h3_heading' => array(
				'title' => __( 'H3 heading', 'blogetti' ),
				'__SETTINGS__' => array(
					'font_family'  => array( 'default' => 'family=Noto Serif:regular,italic,700,700italic&amp;subset=greek-ext,cyrillic,greek,latin-ext,vietnamese,latin,cyrillic-ext' ),
					'font_style'   => array( 'default' => '' ),
					'font_size'    => array( 'default' => '30px' ),
					'font_weight'  => array( 'default' => '700' ),
					'line_height'  => array( 'default' => '1.2em' ),
					'letter_space' => array( 'default' => '' ),
					'text_align'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'font_family' => array(
						'label' => __( 'Font family', 'blogetti' ),
						'type'  => 'select',
						'choices' => Model_Typography_Settings::get_google_fonts(),
					),
					'font_style'    => array(
						'label' => __( 'Font style', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'normal'  => 'normal',
							'italic'  => 'italic',
							'oblique' => 'oblique',
							'inherit' => 'inherit',
						),
					),
					'font_size'     => array( 'label' => __( 'Font size', 'blogetti' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'blogetti' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'blogetti' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'blogetti' ) ),
					'text_align'    => array(
						'label' => __( 'Text align', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'inherit' => 'inherit',
							'center'  => 'center',
							'justify' => 'justify',
							'left'    => 'left',
							'right'   => 'right',
						),
					),
				),
			),
			'h4_heading' => array(
				'title' => __( 'H4 heading', 'blogetti' ),
				'__SETTINGS__' => array(
					'font_family'  => array( 'default' => 'family=Noto Serif:regular,italic,700,700italic&amp;subset=greek-ext,cyrillic,greek,latin-ext,vietnamese,latin,cyrillic-ext' ),
					'font_style'   => array( 'default' => '' ),
					'font_size'    => array( 'default' => '24px' ),
					'font_weight'  => array( 'default' => '700' ),
					'line_height'  => array( 'default' => '1.2em' ),
					'letter_space' => array( 'default' => '' ),
					'text_align'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'font_family' => array(
						'label' => __( 'Font family', 'blogetti' ),
						'type'  => 'select',
						'choices' => Model_Typography_Settings::get_google_fonts(),
					),
					'font_style'    => array(
						'label' => __( 'Font style', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'normal'  => 'normal',
							'italic'  => 'italic',
							'oblique' => 'oblique',
							'inherit' => 'inherit',
						),
					),
					'font_size'     => array( 'label' => __( 'Font size', 'blogetti' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'blogetti' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'blogetti' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'blogetti' ) ),
					'text_align'    => array(
						'label' => __( 'Text align', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'inherit' => 'inherit',
							'center'  => 'center',
							'justify' => 'justify',
							'left'    => 'left',
							'right'   => 'right',
						),
					),
				),
			),
			'h5_heading' => array(
				'title' => __( 'H5 heading', 'blogetti' ),
				'__SETTINGS__' => array(
					'font_family'  => array( 'default' => 'family=Noto Serif:regular,italic,700,700italic&amp;subset=greek-ext,cyrillic,greek,latin-ext,vietnamese,latin,cyrillic-ext' ),
					'font_style'   => array( 'default' => '' ),
					'font_size'    => array( 'default' => '18px' ),
					'font_weight'  => array( 'default' => '700' ),
					'line_height'  => array( 'default' => '1.28em' ),
					'letter_space' => array( 'default' => '' ),
					'text_align'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'font_family' => array(
						'label' => __( 'Font family', 'blogetti' ),
						'type'  => 'select',
						'choices' => Model_Typography_Settings::get_google_fonts(),
					),
					'font_style'    => array(
						'label' => __( 'Font style', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'normal'  => 'normal',
							'italic'  => 'italic',
							'oblique' => 'oblique',
							'inherit' => 'inherit',
						),
					),
					'font_size'     => array( 'label' => __( 'Font size', 'blogetti' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'blogetti' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'blogetti' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'blogetti' ) ),
					'text_align'    => array(
						'label' => __( 'Text align', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'inherit' => 'inherit',
							'center'  => 'center',
							'justify' => 'justify',
							'left'    => 'left',
							'right'   => 'right',
						),
					),
				),
			),
			'h6_heading' => array(
				'title' => __( 'H6 heading', 'blogetti' ),
				'__SETTINGS__' => array(
					'font_family'  => array( 'default' => 'family=Noto Serif:regular,italic,700,700italic&amp;subset=greek-ext,cyrillic,greek,latin-ext,vietnamese,latin,cyrillic-ext' ),
					'font_style'   => array( 'default' => '' ),
					'font_size'    => array( 'default' => '16px' ),
					'font_weight'  => array( 'default' => '700' ),
					'line_height'  => array( 'default' => '1.375em' ),
					'letter_space' => array( 'default' => '' ),
					'text_align'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'font_family' => array(
						'label' => __( 'Font family', 'blogetti' ),
						'type'  => 'select',
						'choices' => Model_Typography_Settings::get_google_fonts(),
					),
					'font_style'    => array(
						'label' => __( 'Font style', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'normal'  => 'normal',
							'italic'  => 'italic',
							'oblique' => 'oblique',
							'inherit' => 'inherit',
						),
					),
					'font_size'     => array( 'label' => __( 'Font size', 'blogetti' ) ),
					'font_weight'   => array( 'label' => __( 'Font weight', 'blogetti' ) ),
					'line_height'   => array( 'label' => __( 'Line height', 'blogetti' ) ),
					'letter_space'  => array( 'label' => __( 'Letter space', 'blogetti' ) ),
					'text_align'    => array(
						'label' => __( 'Text align', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'inherit' => 'inherit',
							'center'  => 'center',
							'justify' => 'justify',
							'left'    => 'left',
							'right'   => 'right',
						),
					),
				),
			),
		),
	),
	'header_settings' => array(
		'priority'    => 13,
		'title'       => __( 'Header settings', 'blogetti' ),
		'description' => __( 'This is header settings panel.', 'blogetti' ),
		'__SECTIONS__'    => array(
			'header_styles' => array(
				'title' => __( 'Header styles', 'blogetti' ),
				'__SETTINGS__' => array(
					'header_image'		=> array( 'default' => '' ),
					'image_position'    => array( 'default' => '' ),
					'image_repeat'      => array( 'default' => 'no-repeat' ),
					'background_scroll' => array( 'default' => '' ),
					'background_color'  => array( 'default' => '#303043' ),
					'header_layout'     => array( 'default' => 'style1' ),
				),
				'__CONTROLS__' => array(
					'header_image' => array(
						'label'     => __( 'Upload a header background image', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Image_Control',
					),
					'image_position' => array(
						'label' => __( 'Image position', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							''              => 'inherit',
							'top_left'      => 'top left',
							'top_center'    => 'top center',
							'top_right'     => 'top right',
							'left_center'   => 'left center',
							'center_center' => 'center center',
							'right_center'  => 'right center',
							'bottom_left'   => 'bottom left',
							'bottom_center' => 'bottom center',
							'bottom_right'  => 'bottom right',
						)
					),
					'image_repeat' => array(
						'label' => __( 'Image repeat', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'no-repeat' => 'no-repeat',
							'repeat'    => 'repeat',
							'repeat-x'  => 'repeat-x',
							'repeat-y'  => 'repeat-y',
							'inherit'   => 'inherit',
						),
					),
					'background_scroll' => array(
						'label' => __( 'Background scroll', 'blogetti' ),
						'type'  => 'checkbox',
					),
					'background_color' => array(
						'label' => __( 'Background color', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'header_layout' => array(
						'label' => __( 'Header layout', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'style1'	=> 'Style 1',
							'style2'	=> 'Style 2',
							'style3'	=> 'Style 3',
						),
					),
				),
			),
			'top_panel_settings' => array(
				'title' => __( 'Top panel settings', 'blogetti' ),
				'__SETTINGS__' => array(
					'background_color' => array( 'default' => '#fff' ),
					'disclaimer_text'  => array( 'default' => '' ),
					'show_search'      => array( 'default' => '1' ),
				),
				'__CONTROLS__' => array(
					'background_color' => array(
						'label' => __( 'Background color', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'disclaimer_text' => array(
						'label' => __( 'Disclaimer text', 'blogetti' ),
						'type'  => 'textarea',
					),
					'show_search' => array(
						'label' => __( 'Show search block', 'blogetti' ),
						'type'  => 'checkbox',
					),
				),
			),
			'main_menu_settings' => array(
				'title' => __( 'Main menu settings', 'blogetti' ),
				'__SETTINGS__' => array(
					'on_off_sticky_menu' => array( 'default' => '1' ),
					'on_off_title_attribute' => array( 'default' => '1' ),
				),
				'__CONTROLS__' => array(
					'on_off_sticky_menu' => array(
						'label' => __( 'Enable / Disable sticky menu', 'blogetti' ),
						'type'  => 'checkbox',
					),
					'on_off_title_attribute' => array(
						'label' => __( 'Enable / Disable title attributes', 'blogetti' ),
						'type'  => 'checkbox',
					),
				),
			),
		),
	),
	'__WITHOUT_PANEL__' => array(
		'__SECTIONS__' => array(
			'sidebar_settings' => array(
				'priority'    => 100,
				'title' => __( 'Sidebar settings', 'blogetti' ),
				'__SETTINGS__' => array(
					'show_left' => array( 'default' => '' ),
					'show_right' => array( 'default' => '1' ),
				),
				'__CONTROLS__' => array(
					'add_widget_area' => array(
						'label' => __( 'Add widget area', 'blogetti' ),
						'__CLASS__' => 'Customize_Sidebar_Creator',
					),
					'show_left' => array(
						'label' => __( 'Show / Hide on left side', 'blogetti' ),
						'type'  => 'checkbox',
					),
					'show_right' => array(
						'label' => __( 'Show / Hide on right side', 'blogetti' ),
						'type'  => 'checkbox',
					),
				),
			),
			'footer_settings' => array(
				'priority'    => 101,
				'title' => __( 'Footer settings', 'blogetti' ),
				'__SETTINGS__' => array(
					'logo'                 => array( 'default' => '' ),
					'copyright_text'       => array( 'default' => 'Blogetti recipes notes. All Rights reservered' ),
					'widget_area_columns'  => array( 'default' => 2 ),
					'layout'               => array( 'default' => 'style1' ),
					'widget_area_bg_color' => array( 'default' => '#303043' ),
					'bg_color'             => array( 'default' => '#303043' ),
				),
				'__CONTROLS__' => array(
					'logo' => array(
						'label'     => __( 'Upload a footer logo', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Image_Control',
					),
					'copyright_text' => array(
						'label' => __( 'Copyright text', 'blogetti' ),
						'type'  => 'textarea',
					),
					'widget_area_columns' => array(
						'label' => __( 'Widget area columns', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							2 => 2,
							3 => 3,
							4 => 4,
						),
					),
					'layout' => array(
						'label' => __( 'Layout', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'style1'	=> 'Style 1',
							'style2'	=> 'Style 2',
							'style3'	=> 'Style 3',
						),
					),
					'widget_area_bg_color' => array(
						'label' => __( 'Widget area background color', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
					'bg_color' => array(
						'label' => __( 'Background color', 'blogetti' ),
						'__CLASS__' => 'WP_Customize_Color_Control',
					),
				),
			),
			'blog_settings' => array(
				'priority'    => 102,
				'title' => __( 'Blog settings', 'blogetti' ),
				'__SETTINGS__' => array(
					'layout'                         => array( 'default' => 'default' ),
					'columns'                        => array( 'default' => 2 ),
					'exclude_categories_from_blog'   => array( 'default' => '' ),
					'blog_label'                     => array( 'default' => '' ),
					'read_more_button_text'          => array( 'default' => 'Read more' ),
					'hide_additional_info_in_single' => array( 'default' => '' ),
					'hide_additional_info_in_loop'   => array( 'default' => '' ),
				),
				'__CONTROLS__' => array(
					'layout' => array(
						'label' => __( 'Layout', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'default' => 'Default',
							'grid'    => 'Grid',
							'masonry' => 'Masonry',
						),
					),
					'columns' => array(
						'label' => 'Columns count',
						'type'  => 'select',
						'choices' => array(
							2 => 2,
							3 => 3,
						),
					),
					'exclude_categories_from_blog' => array( 'label' => __( 'Exclude categories from blog', 'blogetti' ) ),
					'blog_label' => array( 'label' => __( 'Blog label', 'blogetti' ) ),
					'read_more_button_text' => array( 'label' => __( 'Read more button text', 'blogetti' ) ),
					'hide_additional_info_in_single' => array(
						'label' => __( 'Hide additional info ( post author, publish date, category, tags) in single post', 'blogetti' ),
						'type' => 'checkbox',
					),
					'hide_additional_info_in_loop' => array(
						'label' => __( 'Hide additional info ( post author, publish date, category, tags) in loop posts', 'blogetti' ),
						'type' => 'checkbox',
					),
				),
			),
			'misc' => array(
				'title' => __( 'Misc', 'blogetti' ),
				'__SETTINGS__' => array(
					//'featured_post_label' => array( 'default' => '' ),
					'post_content_on_blog_page' => array( 'default' => 'only_excerpt' ),
					'featured_image_on_blog_page' => array( 'default' => 'post-image' ),
				),
				'__CONTROLS__' => array(
					//'featured_post_label' => array( 'label' => __( 'Featured post label', 'blogetti' ) ),
					'post_content_on_blog_page' => array(
						'label' => __( 'Post content on blog page', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'only_excerpt' => 'Only excerpt',
							'full_content' => 'Full content',
						),
					),
					'featured_image_on_blog_page' => array(
						'label' => __( 'Featured image on blog page', 'blogetti' ),
						'type'  => 'select',
						'choices' => array(
							'post-thumbnail'	=> 'Small',
							'post-image'		=> 'Full width',
						),
					),
					// 'export' => array(
					// 	'label' => __( 'Featured post label', 'blogetti' ),
					// 	'__CLASS__' => 'Customize_Export_Settings',
					// ),
					// 'import' => array(
					// 	'label' => __( 'Import', 'blogetti' ),
					// 	'__CLASS__' => 'Customize_Import_Settings',
					// ),
				),
			),
		),
	),
	'__REMOVE_SECTIONS__' => array(
		'title_tagline',
		'colors',
		'header_image',
		'background_image',
	),
);
