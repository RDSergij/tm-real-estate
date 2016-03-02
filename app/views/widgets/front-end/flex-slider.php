<?php
/**
 * Widgets/Front end/Flex slider view
 *
 * @package photolab
 */
?>{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="flexslider">
	@if(count($posts))
	<ul class="slides">
		@foreach($posts as $p)
		<li>
			<a href="{{ get_permalink($p->ID) }}">
				<img src="{{ $p->image }}" alt="{{ esc_attr( $p->post_title ) }}" />
			</a>
		</li>
		@endforeach
	</ul>
	@endif
</div>
{{ $after_widget }}
