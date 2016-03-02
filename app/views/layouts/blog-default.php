<?php
/**
 * Layouts/Blog default view
 *
 * @package photolab
 */
?>@for($i = 0; $i < count($posts); $i++)
	<?php $GLOBALS['post'] = $posts[ $i ]; ?>
	<?php setup_postdata( $GLOBALS['post'] ); ?>
	@include( 'contents/'.Model_Blog_Settings::get_content_name() )
@endfor
