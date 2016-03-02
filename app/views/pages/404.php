<?php
/**
 * Pages/404 view
 *
 * @package photolab
 */
?>{{ Model_Main::header() }}

	<div id="content" class="site-content">
		<div class="container">
			{{ $breadcrumbs }}
			<div class="row">
				@if ( Model_Sidebar_Settings::is_show_left() )
                    <!--Left Sidebar-->
                    <div class="left-sidebar-wrap col-xs-12 col-sm-12 {{ Model_Sidebar_Settings::get_sidebar_class( Model_Page_Layout_Settings::get_sidebar_width() ) }}">
                        {{ Model_Sidebar_Settings::widget_area( 'left_sidebar' ) }}
                    </div>
                    <!--END Left Sidebar-->
                @endif
                    <!--Main COL -->
                   <div class="content-wrap col-xs-12 col-sm-12 {{ Model_Sidebar_Settings::get_content_class( Model_Page_Layout_Settings::get_sidebar_width() ) }}"> 
                        <!-- 404 -->
                        <section class="sect-404 bg-white text-center">
                            <div class="img-wr round">
                                <img src="{{ Utils::assets_url() }}/images/404.jpg" alt="{{ __('The page not found', 'blogetti') }}">
                            </div>
                            <p class="h1-style accent1-color text-primary">
                                {{ __('Page 404', 'blogetti') }}
                            </p>
                            <p class="h4-style">{{ __('The page not found', 'blogetti') }}</p>
                            <a href="{{ home_url() }}" class="btn btn-primary btn-visit">{{ __('Visit home page', 'blogetti') }}</a>
                            <hr>
                            <p>{{ __('Unfortunately the page you were looking for could not be found. Maybe search can help.', 'blogetti') }}</p>
							@include('blocks/search-form')
                        </section>
                        <!-- END 404-->


                    </div>
                    <!--END Main COL-->
					@if ( Model_Sidebar_Settings::is_show_right() )
                        <!--Right Sidebar-->
                        <div class="right-sidebar-wrap col-xs-12 col-sm-12 {{ Model_Sidebar_Settings::get_sidebar_class( Model_Page_Layout_Settings::get_sidebar_width() ) }}">
                            {{ Model_Sidebar_Settings::widget_area( 'right_sidebar' ) }}
                        </div>
                        <!--END Right Sidebar-->
                    @endif
			</div><!-- #main -->
		</div>
	</div><!-- #primary -->

{{ Model_Main::footer() }}
