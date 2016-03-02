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

<!-- Owl Carousel -->
<div class="tm-posts-carousel-widget owl-carousel" data-slides-per-view="{{ $slides_per_view }}">
	@foreach( $posts as $post )
	@if( ! empty( $post->image ) )

	<?php 
		$category = get_the_category($post->ID);
	?>
	<div class="owl-item invert">
		<a href="{{ get_permalink( $post->ID ) }}"><img src="{{ $post->image }}" alt="{{ esc_attr($post->post_title) }}" width="300" height="300" /></a>

		<div class="owl-item-content">
			<div class="category"><a href="{{ get_category_link( $category[0]->cat_ID ) }}"><em>{{ $category[0]->cat_name }}</em></a></div>
			<h5><a href="{{ get_permalink( $post->ID ) }}"><em>{{ $post->post_title }}</em></a></h5>
			<time class="h6-style accent2-color" datetime="{{ $post->date_atribute }}"><em>{{ $post->date_text }}</em></time>
		</div>
	</div>
	@endif
	@endforeach
</div>
<!-- END Owl Carousel -->
{{ $after_widget }}
