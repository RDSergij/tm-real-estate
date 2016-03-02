<?php
/**
 * Main Model fiel
 *
 * @package photolab
 */

/**
 * Main model class
 */
class Model_Main {

	/**
	 * Main data for view
	 *
	 * @return array
	 */
	public static function main() {
		return array(
			'TDU'                     => get_template_directory_uri(),
			'search_form'             => View::make( 'blocks/search-form' ),
			'search_form_header'      => View::make( 'blocks/search-form-header' ),
			'sidebar_side_type'       => Model_Sidebar_Settings::get_sidebar_side_type(),
			'wp_query'                => Utils::array_get( $GLOBALS, 'wp_query', null ),
			'post'                    => Utils::array_get( $GLOBALS, 'post', null ),
			'tags'                    => get_tags(),
			'loop_name'               => Model_Blog_Settings::get_loop_name(),
			'blog_content'            => Model_Misc::get_blog_content(),
			'columns_count'           => Model_Blog_Settings::get_columns(),
			'column_css_class'        => Model_Blog_Settings::get_column_css_class(),
			'category_list'           => get_the_category_list( __( ', ', 'blogetti' ) ),
			'tag_list'                => get_the_tag_list( '', __( ', ', 'blogetti' ) ),
			'archive_list'            => wp_get_archives( array( 'type' => 'monthly', 'echo' => false ) ),
			'wp_register'             => wp_register( '<li>', '</li>', false ),
			'wp_loginout'             => wp_loginout( '', false ),
			'wp_meta'                 => Utils::echo_to_var( array( __CLASS__, 'wp_meta' ) ),
			'is_show_in_posts'        => Model_Social_Links::is_show_in_posts(),
			'is_show_in_post'         => Model_Social_Links::is_show_in_post(),
			'breadcrumbs_page_title'  => Model_Breadcrumbs::is_show_page_title(),
			'breadcrumbs_is_full_minifide'   => Model_Breadcrumbs::is_full_minifide(),
			'is_show_breadcrubs'             => Model_BreadCrumbs::is_show_breadcrubs(),
			'read_more'                      => Model_Blog_Settings::get_read_more_button_text(),
			'hide_additional_info_in_single' => Model_Blog_Settings::is_hide_additional_info_in_single(),
			'hide_additional_info_in_loop'   => Model_Blog_Settings::is_hide_additional_info_in_loop(),
			'socials'              => View::make(
				'blocks/socials',
				array(
					'socials' => Model_Social_Links::get_all_socials(),
					'where'   => 'header',
				)
			),
		);
	}

	/**
	 * It's for php 5.2
	 */
	public static function wp_meta() {
		wp_meta();
	}

	/**
	 * Get header
	 *
	 * @return string HTML code header
	 */
	public static function header() {
		return View::make( 'sections/header', Model_Main::header_data() );
	}

	/**
	 * Header data for header section
	 *
	 * @return array
	 */
	public static function header_data() {
		$header_image = Model_Header_Styles::get_header_image(); //get_header_image();
		$page_layout_class = sprintf(
			' page-layout-%s page-layout-sidebar-width-%s %s',
			Model_Page_Layout_Settings::get_layout(),
			Model_Page_Layout_Settings::get_sidebar_width(),
			Model_Sidebar_Settings::show_two_sidebar()
		);
		
		$typography_settings = Model_Typography_Settings::get_all_typography_settings();
		$body_font_family 	= Utils::array_get( $typography_settings['body_text'], 'font_family' );
		$h1_font_family 	= Utils::array_get( $typography_settings['h1_heading'], 'font_family' );
		$h2_font_family 	= Utils::array_get( $typography_settings['h2_heading'], 'font_family' );
		$h3_font_family 	= Utils::array_get( $typography_settings['h3_heading'], 'font_family' );
		$h4_font_family 	= Utils::array_get( $typography_settings['h4_heading'], 'font_family' );
		$h5_font_family 	= Utils::array_get( $typography_settings['h5_heading'], 'font_family' );
		$h6_font_family 	= Utils::array_get( $typography_settings['h6_heading'], 'font_family' );

		$header = array(
			'allowedtags'          => $GLOBALS['allowedtags'],
			'language_attributes'  => get_language_attributes(),
			'body_class'           => implode( ' ', get_body_class() ) . $page_layout_class,
			'page_boxed_width'		=> Model_Page_Layout_Settings::get_width(),
			'charset'              => get_bloginfo( 'charset' ),
			'ping_back_url'        => get_bloginfo( 'pingback_url' ),
			'name'                 => get_bloginfo( 'name' ),
			'home_url'    		   => esc_url( home_url( '/' ) ),
			'description' 		   => get_bloginfo( 'description' ),
			'favicon'              => Model_Logo_And_Favicon::get_favicon(),
			'touch_icon'           => Model_Logo_And_Favicon::get_touch_icon(),
			'custom_styles'        => '',
			'color_scheme_regular' => Model_Color_Scheme_Regular::get_color_scheme(),
			'color_scheme_invert'  => Model_Color_Scheme_Invert::get_color_scheme(),
			'typography_settings'  => $typography_settings,
			'body_font_family' 	   => Utils::array_get( $typography_settings['body_text'], 'font_family' ),
			'h1_font_family' 	   => Utils::array_get( $typography_settings['h1_heading'], 'font_family' ),
			'h2_font_family' 	   => Utils::array_get( $typography_settings['h2_heading'], 'font_family' ),
			'h3_font_family' 	   => Utils::array_get( $typography_settings['h3_heading'], 'font_family' ),
			'h4_font_family' 	   => Utils::array_get( $typography_settings['h4_heading'], 'font_family' ),
			'h5_font_family' 	   => Utils::array_get( $typography_settings['h5_heading'], 'font_family' ),
			'h6_font_family' 	   => Utils::array_get( $typography_settings['h6_heading'], 'font_family' ),
			'is_enabled_preloader' => Model_Logo_And_Favicon::is_enable_page_preloader(),
			'logo'                 => Model_Logo_And_Favicon::get_logo(),
			'socials_show_header'         => Model_Social_Links::is_show_in_header(),
			'header_style_layout'         => Model_Header_Styles::get_layout(),
			'header_layout_view'          => sprintf( 'header-%s', Model_Header_Styles::get_layout() ),
			'header_image'                => $header_image,
			'header_slogan'               => Model_Blog_Settings::get_blog_label(),
			'static_class'                => empty( $header_image ) ? 'static' : 'absolute',
			'term_description'            => term_description(),
			'welcome_message'             => get_option( 'blogetti' ),
			'image_position'              => Model_Header_Styles::get_image_position(),
			'image_repeat'                => Model_Header_Styles::get_image_repeat(),
			'background_color'            => Model_Header_Styles::get_background_color(),
			'background_scroll'           => Model_Header_Styles::get_background_scroll(),
			'top_panel_bg_color'          => Model_Top_Panel_Settings::get_background_color(),
			'top_panel_show_search'       => Model_Top_Panel_Settings::is_show_search(),
			'top_panel_disclimer_text'    => Model_Top_Panel_Settings::get_disclimer_text(),
			'footer_widget_area_bg_color' => Model_Footer_Settings::get_widget_area_bg_color(),
			'footer_bg_color'             => Model_Footer_Settings::get_bg_color(),
			'htag'                        => is_front_page() ? 'h1' : 'h2',
			'main_menu'            => wp_nav_menu(
				array(
					'theme_location'  => 'main',
					'menu_class'      => 'main-navigation sf-menu',
					'container_class' => 'menu-main_nav site-menu',
					'container_id'    => 'main-menu',
					'walker'          => new Photolab_Walker(),
					'echo'            => false,
					'depth'           => 4,
				)
			),
			'top_menu'            => wp_nav_menu(
				array(
					'theme_location'  => 'top',
					'container_class' => 'menu-top_nav site-menu',
					'container_id'    => 'top-menu',
					'walker'          => new Photolab_Walker(),
					'echo'            => false,
					'depth'			  => 1
				)
			),
		);

		$header['alt_mess'] = Utils::array_get( $header['welcome_message'], 'welcome_title', get_bloginfo( 'name' ) );

		return $header;
	}

	/**
	 * Get footer
	 *
	 * @return string HTML code footer
	 */
	public static function footer() {
		return View::make( 'sections/footer', Model_Main::footer_data() );
	}

	/**
	 * Footer data for footer section
	 *
	 * @return array
	 */
	public static function footer_data() {
		return array(
			'copyright'    => Model_Footer_Settings::get_copyright(),
			'logo'         => Model_Footer_Settings::get_logo(),
			'menu'         => wp_nav_menu(
				array(
					'theme_location'  => 'footer',
					'container_class' => 'menu-footer_nav site-menu',
					'container_id'    => 'footer-navigation',
					'echo'            => false,
					'depth'			  => 1
				)
			),
			'socials'              => View::make(
				'blocks/socials',
				array(
					'socials' => Model_Social_Links::get_all_socials(),
					'where'   => 'footer',
				)
			),
			'socials_show_footer'	=> Model_Social_Links::is_show_in_footer(),
			'widgets'               => Model_Footer_Settings::get_all_footer_widgets_html(),
			'css'                   => Model_Footer_Settings::get_columns_css_class(),
			'footer_style'			=> Model_Footer_Settings::get_layout(),
			'columns'				=> Model_Footer_Settings::get_columns(),
			'name'                 => get_bloginfo( 'name' ),
			'home_url'    		   => esc_url( home_url( '/' ) ),
			'description' 		   => get_bloginfo( 'description' ),
		);
	}

	/**
	 * Include Google fonts
	 */
	public static function fonts_url() {
		$fonts_url = '';

		$locale = get_locale();

		$cyrillic_locales = array( 'ru_RU', 'mk_MK', 'ky_KY', 'bg_BG', 'sr_RS', 'uk', 'bel' );

		/**
		* Translators: If there are characters in your language that are not
		* supported by Lora, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$libre = _x( 'on', 'Libre Baskerville font: on or off', 'blogetti' );

		/**
		* Translators: If there are characters in your language that are not
		* supported by Open Sans, translate this to 'off'. Do not translate
		* into your own language.
		*/
		$open_sans = _x( 'on', 'Open Sans font: on or off', 'blogetti' );

		if ( 'off' !== $libre || 'off' !== $open_sans ) {
			$font_families = array();

			if ( 'off' !== $libre ) {
				$font_families[] = 'Libre Baskerville:400,700,400italic';
			}

			if ( 'off' !== $open_sans ) {
				$font_families[] = 'Open Sans:300,400,700,400italic,700italic';
			}

			$query_args = array(
				'family' => urlencode( implode( '|', $font_families ) ),
				'subset' => urlencode( 'latin,latin-ext' ),
			);

			if ( in_array( $locale, $cyrillic_locales ) ) {
				$query_args['subset'] = urlencode( 'latin,latin-ext,cyrillic' );
			}

			$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}

	/**
	 * Get image for image post format
	 */
	public static function image_post() {
		$fullsize_img = '';
		$cropped_image = '';
		if ( has_post_thumbnail() ) {
			$thumb_id      = get_post_thumbnail_id();
			$fullsize_img  = wp_get_attachment_url( $thumb_id );
			$cropped_image = wp_get_attachment_image( $thumb_id , 'fullwidth-thumbnail' );
		} else {
			$attachments = get_children(
				array(
					'post_parent'    => get_the_id(),
					'posts_per_page' => 1,
					'post_status'    => 'inherit',
					'post_type'      => 'attachment',
					'post_mime_type' => 'image',
				)
			);
			if ( $attachments && is_array( $attachments ) ) {
				$attachment = Utils::array_get_first( $attachments );
				$img_id        = $attachment->ID;
				$fullsize_img  = wp_get_attachment_url( $img_id );
				$cropped_image = wp_get_attachment_image( $img_id , 'fullwidth-thumbnail' );
			}
		}
		echo View::make(
			'blocks/image-post',
			array(
				'fullsize_img'  => $fullsize_img,
				'cropped_image' => $cropped_image,
			)
		);
	}

	/**
	 * Get four categories ordered by count
	 *
	 * @return array
	 */
	public static function get_four_categories() {
		$args = array(
			'type'         => 'post',
			'child_of'     => 0,
			'parent'       => '',
			'orderby'      => 'count',
			'order'        => 'DESC',
			'hide_empty'   => 1,
			'hierarchical' => false,
			'exclude'      => '',
			'include'      => '',
			'number'       => 0,
			'taxonomy'     => 'category',
			'pad_counts'   => false,
		);
		return get_categories( $args );
	}

	/**
	 * Return sticky class if post is sticky
	 *
	 * @return string sticky css class.
	 */
	public static function sticky_class() {
		if ( is_sticky() ) {
			return 'featured';
		}
		return '';
	}

	/**
	 * Get post thumbnail url
	 *
	 * @param  [type] $post post with thumbnail.
	 * @param  [type] $size image size.
	 * @return mixed
	 */
	public static function get_post_thumbnail_url( $post = null, $size = 'thumbnail' ) {
		$thumb_id  = get_post_thumbnail_id( $post );
		$thumb_src = wp_get_attachment_image_src( $thumb_id, $size, true );
		if ( is_array( $thumb_src ) ) {
			return $thumb_src[0];
		}
		return false;
	}
}
