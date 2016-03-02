<?php
/**
 * Widgets/Front end/Instagram view
 *
 * @package photolab
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
@if(array_key_exists('data', $images) && is_array($images['data']) && count($images['data']) > 0)
	<div class="instagram-widget instagram-widget--mod-1">
		<ul class="instagram-images row">
			@foreach ($images['data'] as $image)
				<li class="col-xs-4 col-lg-2">
					<a class="instagram-img" target="_blank" href="{{ $image['link'] }}">
						<img src="{{ $image['images'][ $size ]['url'] }}" alt="{{ $image['id'] }}">
						<span class="inst-overlay"></span>
					</a>
				</li>
			@endforeach
		</ul>
	</div>
@else
	<span class="none">Photos not found!</span>
@endif
{{ $after_widget }}
