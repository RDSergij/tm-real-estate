<?php
/**
 * Contents/Page view
 *
 * @package photolab
 */
?><article id="post-{{ get_the_ID() }}" class="{{ join( ' ', get_post_class() ) }}">

	<div class="entry-content page">
		<?php the_content( __( $read_more, 'blogetti' ) ) ?>
		{{ wp_link_pages( 
			array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'blogetti' ),
				'after'  => '</div>',
				'echo'   => false
			) 
		) }}
		@include( 'blocks/contact-form' )
	</div><!-- .entry-content -->
</article><!-- #post-## -->
