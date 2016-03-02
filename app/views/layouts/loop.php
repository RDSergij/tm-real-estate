<?php
/**
 * Layouts/Main loop view
 *
 * @package photolab
 */
/*@include( 'contents/'.Model_Blog_Settings::get_content_name() )*/
?>
@for($i = 0; $i < count($posts); $i++)
	<?php $GLOBALS['post'] = $posts[ $i ]; ?>
	<?php setup_postdata( $GLOBALS['post'] ); ?>
	@include( 'contents/content' )
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