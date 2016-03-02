<?php
/**
 * Blocks/Excerpt view
 *
 * @package photolab
 */
?>@if ( has_excerpt() )
	{{ apply_filters( 'the_excerpt', get_the_excerpt() ) }}
@else 
	{{ wp_trim_words( strip_shortcodes( apply_filters( 'the_excerpt', get_the_content( ' ' ) ) ), 110 ) }}
@endif