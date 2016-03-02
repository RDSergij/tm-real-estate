<?php
/**
 * Frontend view
 *
 * @package TM_Categories_Tiles_Widget
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-grid-1-5-widget">
	<div class="grid-wrap row">
		@if( ! empty( $categories ) )
			@foreach( $categories as $index => $category )
				<div class="col-xs-6 col-md-4 invert">
					<a href="{{ $category['url'] }}" class="articles">
						@if( ! empty( $category['image'] ) )
							<div class="background-image" style="background-image:url({{ $category['src'] }})"></div>
						@endif

						<div class="article-content">
							<h4>{{ $category['name'] }}</h4>
							@if( 'true' == $show_count )
							<h6><em>{{ sprintf( __( '%d posts', 'blogetti' ), $category['count'] ) }}</em></h6>
							@endif
						</div>
					</a>
				</div>
			@endforeach
		@endif
	</div>
</div>
{{ $after_widget }}
