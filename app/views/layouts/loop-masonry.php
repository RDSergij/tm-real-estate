<?php
/**
 * Layouts/Main loop view
 *
 * @package photolab
 */
?>
<div class="masonry masonry-layout">
	@for($i = 0; $i < count($posts); $i++)
		<?php $GLOBALS['post'] = $posts[ $i ]; ?>
		<?php setup_postdata( $GLOBALS['post'] ); ?>
		<div class="brick brick-{{ $columns_count }}">
			@include( 'contents/content' )
		</div>
	@endfor
</div>

<?php
	the_posts_pagination(
		array(
			'end_size' => 2,
			'mid_size' => 2,
			'prev_text'    => '<i class="material-icons">keyboard_arrow_left</i>',
			'next_text'    => '<i class="material-icons">keyboard_arrow_right</i>',
		)
	);
?>