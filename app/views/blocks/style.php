<style>
	/* Links */
		@if( ! empty( $color_scheme_regular['accent1'] ) )
			a, a:focus, a:visited, a:active { 
				color: {{ $color_scheme_regular['accent1'] }}; 
			}
		@endif
		@if( ! empty( $color_scheme_regular['link_hover'] ) )
			a:hover { 
				color: {{ $color_scheme_regular['link_hover'] }}; 
			}
		@endif
	/* End links */

	/* Regular color scheme*/
	@if ( ! empty( $color_scheme_regular['text'] ) )
		html,
		body,
		input, 
		select, 
		textarea,
		.text-color,
		.top-panel_container .menu-main_nav a,
		a.btn.btn-link { 
			color: {{ $color_scheme_regular['text'] }};  
		}
		@media (max-width: 767px) {
			.top-panel_container .menu-main_nav > ul.main-navigation li > a[href="#"]:hover,
			.top-panel_container .menu-main_nav > ul.main-navigation li.sfHover > a[href="#"] {
				color: {{ $color_scheme_regular['text'] }}; 
			}
		}
		.text-background {
			background-color: {{ $color_scheme_regular['text'] }};
		}
	@endif

	@if ( ! empty( $color_scheme_regular['heading1'] ) )
		h1, 
		.h1-style {
			color: {{ $color_scheme_regular['heading1'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['heading2'] ) )
		h2, 
		.h2-style {
			color: {{ $color_scheme_regular['heading2'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['heading3'] ) )
		h3, 
		.h3-style,
		h3.entry-title a {
			color: {{ $color_scheme_regular['heading3'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['heading4'] ) )
		h4, 
		.h4-style {
			color: {{ $color_scheme_regular['heading4'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['heading5'] ) )
		h5, 
		.h5-style {
			color: {{ $color_scheme_regular['heading5'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['heading6'] ) )
		h6, 
		.h6-style {
			color: {{ $color_scheme_regular['heading6'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['accent1'] ) ) 
		.accent1-color,
		.search-panel.header-panel .search-submit,
		.top-panel_container .menu-main_nav a:hover,
		h3.entry-title a:hover,
		a.btn.btn-link i,
		a.btn.btn-link:hover,
		.menu-main_nav > ul.main-navigation li.current_page_item > a,
		.menu-main_nav > ul.main-navigation li.sfHover > a,
		.widget_archive ul li a:hover, 
		.widget_categories ul li a:hover,
		.entry-quote.entry-quote blockquote:before,
		.reply a:hover,
		blockquote:before, 
		a.accent2-color:hover,
		q:before,
		.recentcomments .comment-author-link,
		.post-content ul li:before,
		.comment-content ul li:before,
		.entry-content ul li:before, 
		.post-content ol li:before,
		.comment-content ol li:before,
		.entry-content ol li:before,
		.recentcomments a:hover,
		.breadcrumb,
		.breadcrumb a:hover,
		.accordion h3.visible,
		.accordion h3:hover,
		blockquote cite { 
			color: {{ $color_scheme_regular['accent1'] }};
		}
		.accent1-background,
		ul.post-categories a,
		.owl-item-content .category a,
		.btn.btn-primary,
		input[type=submit],
		input[type=reset],
		.calendar_wrap caption,
		ins,
		figure.entry-link.without-image,
		#back-top a,
		.loader-wrapper,
		.invert .calendar_wrap tbody td a:hover { 
			background-color: {{ $color_scheme_regular['accent1'] }}; 
		}
		.accent1-border { 
			border-color: {{ $color_scheme_regular['accent1'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['accent2'] ) ) 
		.accent2-color,
		a.accent2-color,
		.search-panel.header-panel .search-submit:hover,
		.top-panel_container .social-list li a:hover,
		.widget_archive ul li a, 
		.widget_categories ul li a,
		.recentcomments a,
		.breadcrumb a,
		.latest-post .latest-post-meta a:hover { 
			color: {{ $color_scheme_regular['accent2'] }};
		}
		.accent2-background,
		.btn.btn-primary:hover,
		input[type=submit]:hover,
		input[type=reset]:hover,
		figure.entry-quote,
		.format-quote .post-content .quote,
		#back-top a:hover,
		.calendar_wrap tbody td a:hover { 
			background-color: {{ $color_scheme_regular['accent2'] }}; 
		}
		.accent2-border { 
			border-color: {{ $color_scheme_regular['accent2'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['accent3'] ) ) 
		.accent3-color,
		.top-panel_container .social-list li a,
		.reply a { 
			color: {{ $color_scheme_regular['accent3'] }};
		}
		.accent3-background { 
			background-color: {{ $color_scheme_regular['accent3'] }}; 
		}
		.accent3-border { 
			border-color: {{ $color_scheme_regular['accent3'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_regular['link_hover'] ) )
		a:hover,
		.accent1-background.invert a:hover { 
			color: {{ $color_scheme_regular['link_hover'] }}; 
		}
	@endif

	/* End regular color scheme*/
	/* Invert color scheme*/
	@if ( ! empty( $color_scheme_invert['heading1'] ) )
		.invert h1, 
		.invert .h1-style {
			color: {{ $color_scheme_invert['heading1'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['heading2'] ) )
		.invert h2, 
		.invert .h2-style {
			color: {{ $color_scheme_invert['heading2'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['heading3'] ) )
		.invert h3, 
		.invert .h3-style {
			color: {{ $color_scheme_invert['heading3'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['heading4'] ) )
		.invert h4, 
		.invert .h4-style {
			color: {{ $color_scheme_invert['heading4'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['heading5'] ) )
		.invert h5, 
		.invert .h5-style {
			color: {{ $color_scheme_invert['heading5'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['heading6'] ) )
		.invert h6, 
		.invert .h6-style {
			color: {{ $color_scheme_invert['heading6'] }}; 
		}
	@endif
	
	@if ( ! empty( $color_scheme_invert['accent1'] ) )
		.invert .accent1-color,
		.navigation.pagination .nav-links .page-numbers,
		.invert .calendar_wrap a,
		.invert .btn.btn-primary:hover, 
		.invert input[type="submit"]:hover, 
		.invert input[type="reset"]:hover,
		.camera_next:hover:before,
		.camera_prev:hover:before { 
			color: {{ $color_scheme_invert['accent1'] }}; 
		}
		.invert .accent1-background,
		ul.post-categories a:hover,
		.owl-item-content .category a:hover,
		.owl-item-content .category a:hover,
		.navigation.pagination .nav-links .page-numbers.current,
		.featured-post-icon { 
			background-color: {{ $color_scheme_invert['accent1'] }}; 
		}
		.invert .accent1-border { 
			border-color: {{ $color_scheme_invert['accent1'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['accent2'] ) )
		.invert .accent2-color,
		.invert .menu a,
		.invert .latest-post .accent2-color:hover,
		.latest-post .latest-post-meta a,
		.invert .widget_archive ul li a:hover, 
		.invert .widget_categories ul li a:hover,
		.invert .calendar_wrap a:hover { 
			color: {{ $color_scheme_invert['accent2'] }}; 
		}
		.invert .accent2-background,
		.navigation.pagination .nav-links .page-numbers:hover,
		.invert .tagcloud a { 
			background-color: {{ $color_scheme_invert['accent2'] }}; 
		}
		.invert .accent2-border { 
			border-color: {{ $color_scheme_invert['accent2'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['accent3'] ) )
		.invert a,
		.invert .accent3-color,
		.invert .menu a:hover,
		.invert .footer-logo a:hover,
		ul.post-categories a,
		.owl-item-content .category a,
		.btn.btn-primary,
		.invert .btn.btn-primary,
		input[type=submit],
		input[type=reset],
		.calendar_wrap caption,
		.entry-quote.entry-quote blockquote,
		.entry-quote.entry-quote blockquote a:hover,
		.navigation.pagination .nav-links .page-numbers.current,
		.navigation.pagination .nav-links .page-numbers:hover,
		figure.entry-link.without-image a,
		.featured-post-icon,
		.invert.accent1-background,
		.format-quote .post-content blockquote p,
		.format-quote .post-content blockquote p a:hover,
		ins,
		#back-top a,
		.invert .latest-post .accent2-color,
		.invert .latest-post .latest-post-meta a:hover,
		.invert .widget_archive ul li a, 
		.invert .widget_categories ul li a,
		.invert .calendar_wrap tfoot a,
		.calendar_wrap tbody td a:hover { 
			color: {{ $color_scheme_invert['accent3'] }}; 
		}
		@media (min-width: 768px) {
			.menu-main_nav > ul.main-navigation li > a[href="#"]:hover,
			.menu-main_nav > ul.main-navigation li.sfHover > a[href="#"] {
				color: {{ $color_scheme_invert['accent3'] }}; 
			}
		}
		.invert .accent3-background,
		.navigation.pagination .nav-links .page-numbers,
		.invert .btn.btn-primary:hover, 
		.invert input[type="submit"]:hover, 
		.invert input[type="reset"]:hover,
		.camera_next:hover:before,
		.camera_prev:hover:before,
		.invert .tagcloud a:hover { 
			background-color: {{ $color_scheme_invert['accent3'] }}; 
		}
		.invert .accent3-border { 
			border-color: {{ $color_scheme_invert['accent3'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['text'] ) )
		.invert,
		.invert-text { 
			color: {{ $color_scheme_invert['text'] }}; 
		}
		.invert .invert-background { 
			background-color: {{ $color_scheme_invert['text'] }}; 
		}
		.invert .invert-border { 
			border-color: {{ $color_scheme_invert['text'] }}; 
		}
	@endif

	@if ( ! empty( $color_scheme_invert['link_hover'] ) )
		.invert a:hover {
			color: {{ $color_scheme_invert['link_hover'] }}; 
		}
	@endif

	/* End invert color scheme*/

	/* Typography settings */
		@if( ! empty( $typography_settings['body_text'] ) )
		/* Body text */
			html,
			body,
			button,
			input, 
			select, 
			textarea,
			#lang_sel {
				@foreach( $typography_settings['body_text'] as $typography_property => $typography_value )
					@if( ! empty( $typography_value ) )
					{{ $typography_property }}: {{ $typography_value }};
					@endif
				@endforeach
			}
		/* End body text */
		@ENDIF
		/* Layout styles */
		@media (min-width: 1200px) {
			body.page-layout-boxed #site-wrapper,
			body.page-layout-boxed .container,
			body.page-layout-boxed .container-fluid,
			body.page-layout-boxed.menu_fixed .site-header {
				max-width: 1170px;
			}
		}

		@if ( !empty( $page_boxed_width ))
			@media (min-width: 1200px) {
				.site .container,
				body.page-layout-boxed #site-wrapper,
				body.page-layout-boxed .container,
				body.page-layout-boxed .container-fluid,
				body.page-layout-boxed.menu_fixed .site-header {
					max-width: {{ $page_boxed_width }};
				}
				body.page-layout-boxed.menu_fixed .site-header {
					margin-left: -{{ $page_boxed_width/2 }}px;
				}
			}
		@endif 

		body.page-layout-full #content > .container {
			max-width: 100%;
		}

		/* End layout styles */
		@if( ! empty( $typography_settings['breadcrumbs_typography'] ) )
		/* Breadcrumbs */
			.breadcrumb {
				@foreach( $typography_settings['breadcrumbs_typography'] as $typography_property => $typography_value )
					@if( ! empty( $typography_value ) )
					{{ $typography_property }}: {{ $typography_value }};
					@endif
				@endforeach
			}
		/* End breadcrumbs */
		@endif
		/* Headings */
			@for( $heading_index = 1; $heading_index <= 6; $heading_index++ )
				@if( ! empty( $typography_settings['h' . $heading_index . '_heading'] ) )
					h{{ $heading_index }},
					.h{{ $heading_index }}-style {
					@foreach( $typography_settings['h' . $heading_index . '_heading'] as $typography_property => $typography_value )
						@if( ! empty( $typography_value ) )
						{{ $typography_property }}: {{ $typography_value }};
						@endif
					@endforeach
					}
				@endif
			@endfor

			@if(! empty( $typography_settings['h4_heading'] ))
				.entry-quote.entry-quote blockquote,
				.format-quote .post-content blockquote p {
					@foreach( $typography_settings['h4_heading'] as $typography_property => $typography_value )
						@if( ! empty( $typography_value) && $typography_property !== 'font-style' && $typography_property !== 'text-align' )
							{{ $typography_property }}: {{ $typography_value }};
						@endif
					@endforeach
				}
			@endif

			@if(! empty( $typography_settings['h5_heading'] ))
				ul.main-navigation li,
				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.btn,
				.camera-post .btn,
				blockquote,
				q,
				.calendar_wrap caption,
				.entry-thumbnail.entry-link .thumbnail,
				figure.entry-link.without-image {
					@foreach( $typography_settings['h5_heading'] as $typography_property => $typography_value )
						@if( ! empty( $typography_value) && $typography_property !== 'font-style' && $typography_property !== 'text-align' )
							{{ $typography_property }}: {{ $typography_value }};
						@endif
					@endforeach
				}
			@endif

			@if(! empty( $typography_settings['h6_heading'] ))
				ul.post-categories a,
				.owl-item-content .category a,
				.navigation.pagination .nav-links a,
				.navigation.pagination .nav-links span,
				ul.main-navigation li ul li,
				.post-content ol li:before,
				.comment-content ol li:before,
				.entry-content ol li:before,
				.calendar_wrap th,
				.calendar_wrap tbody td,
				.widget_archive ul li, 
				.widget_categories ul li a,
				.entry-quote.entry-quote blockquote a,
				.format-quote .post-content blockquote p a,
				.navigation.pagination .nav-links,
				.search-form .search-field {
					@foreach( $typography_settings['h6_heading'] as $typography_property => $typography_value )
						@if( ! empty( $typography_value ) && $typography_property !== 'font-weight' && $typography_property !== 'font-style' && $typography_property !== 'text-align' )
						{{ $typography_property }}: {{ $typography_value }};
						@endif
					@endforeach
				}
			@endif
		/* End headings */

	/* End typography settings */

	/* Top panel styles */
		@if( ! empty( $top_panel_bg_color ) )
			.top-panel_container {
				background-color: {{ $top_panel_bg_color }};
			}
		@endif
	/* End top panel styles */

	/* Header styles */
		.site-header {
			@if( ! empty( $header_image ) )
				background-image: url('{{ $header_image }}');
			@endif
			@if( ! empty( $image_position ) )
				background-position: {{ $image_position }};
			@endif
			@if( ! empty( $image_repeat ) )
				background-repeat: {{ $image_repeat }};
				background-position: {{ $image_position }};
			@endif
			@if( ! empty( $background_color ) )
				background-color: {{ $background_color }};
				background-position: {{ $image_position }};
			@endif
			@if( $background_scroll )
				background-attachment: fixed;
			@endif
		}
		@if( ! empty( $background_color ) )
			.menu-main_nav ul.main-navigation ul  {
				background-color: {{ $background_color }};
			}
		@endif

	/* End header styles */

	/* Footer styles */
		@if( ! empty( $footer_bg_color ) )
			.site-footer {
				background-color: {{ $footer_bg_color }};
			}
		@endif
		@if( ! empty( $footer_widget_area_bg_color ) )
			.footer-widget-bg-color{
				background-color: {{ $footer_widget_area_bg_color }};
			}
		@endif
	/* End footer styles */
</style>
