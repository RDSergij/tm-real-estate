<?php
/**
 * Frontend view
 *
 * @package TM_About_Author_Widget
 */
?>
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="text-center inset-3">
	<img src="{{ $avatar }}" class="round" alt="{{ $name }}" width="220" height="220">
	<h4>{{ $name }}</h4>
	@if( $description )
		<p>{{ $description }}</p>
	@endif
	@if( ! empty( $url ) && ! empty( $text_link ) )
	<a href="{{ $url }}" class="btn btn-primary h5-style"><em>{{ $text_link }}</em> <i class="material-icons">arrow_forward</i></a>

	@endif
</div>
{{ $after_widget }}
