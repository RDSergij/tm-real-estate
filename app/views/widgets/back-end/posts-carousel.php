<?php
/**
 * Admin view
 *
 * @package TM_Posts_Widget
 */
?>

<div class="tm-post-slider-form-widget">
	<p>
		{{ $title_html }}
	</p>

	<p>
		<label for="categories">{{ __( 'Category', 'blogetti' ) }}</label>
		{{ $categories_html }}
	</p>

	<p>
		<label for="tags">{{ __( 'Tag', 'blogetti' ) }}</label>
		{{ $tags_html }}
	</p>

	<p>
		{{ $count_html }}
	</p>

	<p>
		{{ $slides_per_view_html }}
	</p>

	<p>
		{{ $length_html }}
	</p>

	<p>&nbsp;</p>
</div>
