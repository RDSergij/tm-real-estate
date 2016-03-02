<?php
/**
 * Frontend view
 *
 * @package TM_Twitter_Timeline_Widget
 */
?>
{{ $before_widget }}
<div class="tm-twitter-timeline-widget" id="twitter-{{ $widget_id }}-{{ $screen_name }}">
	@if($title != '')
		{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
	@endif
	<a class="twitter-timeline" data-widget-id="{{ $widget_id }}" href="https://twitter.com/{{ $screen_name }}" data-screen-name="{{ $screen_name }}">
	Tweets by @ {{ $screen_name }}
	</a>
</div>
{{ $after_widget }}
