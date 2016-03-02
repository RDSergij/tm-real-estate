<?php
/**
 * Pages/Index view
 *
 * @package photolab
 */
?>{{ Model_Main::header() }}
<!--========================================================
                          CONTENT
=========================================================-->

<div id="content" class="site-content">
    <div class="container">
        <!--Main ROW-->
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
                {{ Model_Sidebar_Settings::widget_area( 'before_content' ) }}
                <div class="clear"></div>        
                @include( 'layouts/'.$loop_name )
                {{ Model_Sidebar_Settings::widget_area( 'content_area' ) }}
            </div>
            @if ( Model_Sidebar_Settings::is_show_right() )
                <!--Right Sidebar-->
                <div class="right-sidebar-wrap col-xs-12 col-sm-12 {{ Model_Sidebar_Settings::get_sidebar_class( Model_Page_Layout_Settings::get_sidebar_width() ) }}">
                    {{ Model_Sidebar_Settings::widget_area( 'right_sidebar' ) }}
                </div>
                <!--END Right Sidebar-->
            @endif
            <!--END Main COL-->
           
        </div>
        <!--End of Main ROW-->
        
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
    <!--End of Container-->
    @if ( is_home() || is_front_page() )
        {{ Model_Sidebar_Settings::widget_area( 'after_content_full_width' ) }}
    @endif
</div>
{{ Model_Main::footer() }}
