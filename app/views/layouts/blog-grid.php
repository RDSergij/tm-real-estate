<?php
/**
 * Layouts/Blog grid view
 *
 * @package photolab
 */
?>@for ( $i = 0; $i < count( $posts ); $i += $columns_count )
	<div class="row">
	@for( $x = 0; $x < $columns_count; $x++ )
	
		@if ( isset ( $posts[ $i + $x ] ) )
			<?php
			$GLOBALS['post'] = $posts[ $i + $x ];
			setup_postdata( $post );
			?>
			<div class="{{ $column_css_class }}">
				@include( 'contents/'.Model_Blog_Settings::get_content_name() )
				@if( $is_show_in_posts )
					@include( 'blocks/social-share' )
				@endif
			</div>
				
		@endif

	@endfor
	</div>
@endfor
