<?php
/**
 * Layouts/Main loop view
 *
 * @package photolab
 */
?>
@for($i = 0; $i < count($posts); $i+=$columns_count)
	<div class="row grid-layout">
	@for ( $x = 0; $x < $columns_count; $x++ )
		@if ( isset ( $posts[ $i + $x ] ) )
			<?php $GLOBALS['post'] = $posts[ $i + $x ]; ?>
			<?php setup_postdata( $GLOBALS['post'] ); ?>
			<div class="{{ $column_css_class }}">
				@include( 'contents/content' )
			</div>
		@endif
	@endfor
	</div>
@endfor

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