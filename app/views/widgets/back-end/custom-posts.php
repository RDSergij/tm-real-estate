<?php
/**
 * Admin view
 *
 * @package TM_Custom_Posts_Widget
 */
?>

<div class="tm-custom-posts-form-widget">
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
		{{ $title_length_html }}
	</p>

	<p>
		{{ $excerpt_length_html }}
	</p>

	<p>
		{{ $button_text_html }}
	</p>

	<div>
		<label for="show_date">{{ __( 'Show date', 'blogetti' ) }}</label>
		{{ $show_date_html }}
	</div>
	<br/>

	<!--div>
		<label for="show_author">{{ __( 'Show author', 'blogetti' ) }}</label>
		{{ $show_author_html }}
	</div>
	<br/-->

	<div>
		<label for="show_comments">{{ __( 'Show comments', 'blogetti' ) }}</label>
		{{ $show_comments_html }}
	</div>
	<br/>

	<!--div>
		<label for="show_categories">{{ __( 'Show categories', 'blogetti' ) }}</label>
		{{ $show_categories_html }}
	</div>
	<br/>

	<div>
		<label for="show_tags">{{ __( 'Show tags', 'blogetti' ) }}</label>
		{{ $show_tags_html }}
	</div-->

	<p>&nbsp;</p>
</div>
