<?php
/**
 * Frontend view
 *
 * @package TM_Youtube_Channel_Widget
 */
?>
{{ $before_widget }}
	<div class="bg-white inset-3">
		<div class="youtube">
			@if($title != '')
			{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
			@endif

			<div class="channel-name">
				<h5 class="txt-heading text-primary">{{ $channel_name }}</h5>
				<p>{{ sprintf( __( '%d Videos', 'blogetti' ), $video_count ) }}</p>
				<a href="{{ $channel_url }}" target="_blank" class="icon icon-lg icon-secondary fa fa-3x fa-youtube"></a>
			</div>

			<div class="button-cnt">
				<a href="{{ $channel_url }}"  target="_blank" class="btn btn-primary"><i class="material-icons">play_circle_outline</i> <em>{{ __( 'Subscribe', 'blogetti' ) }}</em></a>

				<div class="youtube-cnt">
					<p>{{ $subscriber_count }}</p>
				</div>
			</div>
		</div>
	</div>
{{ $after_widget }}
