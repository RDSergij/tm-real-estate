<?php
/**
 * Frontend view
 *
 * @package TM_Custom_Posts_Widget
 */
?>
{{ $before_widget }}
<div class="latest-post-wrap">
	@if($title != '')
		{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
	@endif
	<ul class="latest-post-row">
		@if(count($posts))
		@foreach($posts as $post)
		<li class="latest-post">
			<h5><em><a class="accent2-color" href="{{ get_permalink( $post->ID ) }}">{{ $post->post_title }}</a></em></h5>

			<div class="media">
				@if( ! empty( $post->image ) )
				<div class="media-left">
					<img src="{{ $post->image }}" alt="" width="105" height="70">
				</div>
				@endif
				<div class="media-body">
					<p>{{ $post->post_excerpt }}</p>
				</div>
			</div>

			<div class="latest-post-meta">
				<p>
					@if( 'true' == $show_date )
						<time datatime="{{ $post->date_atribute }}">{{ $post->date_text }}</time>
					@endif
				</p>
				<p>
					@if( 'true' == $show_comments )
					<a href="{{ get_permalink( $post->ID ) }}#comments">
						{{ sprintf( __( 'No comments', 'One Comment', '%1$s Comments', get_comments_number(), '', 'blogetti' ), number_format_i18n( get_comments_number() ) ) }}
					</a>
					@endif
				</p>
			</div>
		</li>
		@endforeach
		@endif
	</ul>
</div>
{{ $after_widget }}
