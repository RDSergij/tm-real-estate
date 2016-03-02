<?php
/**
 * Frontend view
 *
 * @package TM_Image_Grid_Widget
 */
?>
<?php 
	$col = '6';
	if ($cols_count == '3') {
		$col = '4';
	}

	$padding_default = '5';
	if ($padding !== 0 && !empty($padding)) {
		$padding_default = $padding;
	}
?>
<!-- Widget area -->
{{ $before_widget }}
@if($title != '')
	{{ $before_title }}{{ apply_filters( 'widget_title', $title ) }}{{ $after_title }}
@endif
<div class="tm-image-grid-widget">
	<!-- Grid area -->
	<div class="grid row invert" style="margin-left: -{{ $padding_default }}px; margin-right: -{{ $padding_default }}px;">
		@foreach( $posts as $post )
			<div class="image-grid_item col-xs-12 col-md-{{ $col }}" style="padding: {{ $padding_default }}px;">
				<a href="{{ get_permalink( $post->ID ) }}" style="{{ ! empty ( $post->image ) ? 'background-image: url(' . $post->image . ');' : '' }}">
					<h6>
						{{ $post->post_title }}
					</h6>
				</a>
			</div>
		@endforeach
	</div>
	<!-- End grid area -->
</div>
{{ $after_widget }}
<!-- End widget area -->
