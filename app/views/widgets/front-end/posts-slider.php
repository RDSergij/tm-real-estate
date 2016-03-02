<?php
/**
 * Frontend view
 *
 * @package TM_Posts_Widget
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="camera_container">
	<div id="camera"
		 data-autoplay="{{ $autoplay }}"
		 data-bullets_is="{{ $bullets_is }}"
		 data-thumbnails_is="{{ $thumbnails_is }}"
		 data-arrows_is="{{ $arrows_is }}"
		 class="slider_widget camera_wrap invert">
		@foreach( $posts as $post )
		<div data-src="{{ $post->image }}" data-thumb="{{ $post->thumbnail }}">
			<div class="camera_caption fadeIn">
				<div class="camera-post">
					<h2 class="h1-style">
						{{ $post->post_title }}
					</h2>
					@if( 'true' == $button_is )
					<a href="{{ get_permalink( $post->ID ) }}" class="btn btn-large btn-primary h5-style"><em>{{ $button_text }}</em> <i class="material-icons">arrow_forward</i></a>
					@endif
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
{{ $after_widget }}