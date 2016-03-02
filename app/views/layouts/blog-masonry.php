<?php
/**
 * Layouts/Blog masonry view
 *
 * @package photolab
 */
?><div id="masonry" class="masonry">
@for ( $i = 0; $i < count( $posts ); $i++ )
	<?php
	$GLOBALS['post'] = $posts[ $i ];
	setup_postdata( $post );
	?>
	<div class="brick brick-{{ $columns_count }}">
		@include( 'contents/'.Model_Blog_Settings::get_content_name() )
		@if( $is_show_in_posts )
			@include( 'blocks/social-share' )
		@endif
	</div>
@endfor
</div>
