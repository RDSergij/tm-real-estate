<?php
/**
 * Contact form page
 *
 * @package blogetti
 */
?>{{ Model_Main::header() }}

	<div id="primary" class="site-content">
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
                <div class="content-wrap col-xs-12 col-sm-12 {{ Model_Sidebar_Settings::get_content_class( Model_Page_Layout_Settings::get_sidebar_width() ) }}"> 
					@while ( have_posts() )
						<?php the_post(); ?>
						@include('contents/page-with-contact-form')
						@if ( comments_open() || '0' != get_comments_number() )
							<?php comments_template( '/app/modules/custom/comments.php' ); ?>
						@endif
					@endwhile
					
					{{ Model_Sidebar_Settings::widget_area( 'content_area' ) }}
				</div>
				@if ( Model_Sidebar_Settings::is_show_right() )
                    <!--Right Sidebar-->
                    <div class="right-sidebar-wrap col-xs-12 col-sm-12 {{ Model_Sidebar_Settings::get_sidebar_class( Model_Page_Layout_Settings::get_sidebar_width() ) }}">
                        {{ Model_Sidebar_Settings::widget_area( 'right_sidebar' ) }}
                    </div>
                    <!--END Right Sidebar-->
                @endif
			</div><!-- #main -->
			@if ( is_home() || is_front_page() )
	            <!-- After Content sidebar -->
	            <div class="row">
	                <div class="col-xs-12">
	                    {{ Model_Sidebar_Settings::widget_area( 'after_content' ) }}
	                </div>
	            </div>
	             <!-- End After Content sidebar -->
	        @endif
		</div>
		@if ( is_home() || is_front_page() )
			{{ Model_Sidebar_Settings::widget_area( 'after_content_full_width' ) }}
		@endif
	</div><!-- #primary -->

{{ Model_Main::footer() }}
