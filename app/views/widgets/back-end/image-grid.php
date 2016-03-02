<?php
/**
 * Admin view
 *
 * @package TM_Posts_Widget
 */
?>

<div class="tm-image-grid-form-widget">
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
		<label for="cols_count">{{ __( 'Count of columns', 'blogetti' ) }}</label>
		{{ $cols_count_html }}
	</p>

	<p>
		{{ $posts_count_html }}
	</p>

	<p>
		{{ $posts_offset_html }}
	</p>

	<p>
		{{ $title_length_html }}
	</p>

	<p>
		{{ $padding_html }}
	</p>

	<p>&nbsp;</p>
</div>
