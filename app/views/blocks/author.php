<?php
/**
 * Author on view
 *
 * @package photolab
 */
?>
<?php  
	$author_description_format = apply_filters(
		'author_description_format',
		'<div class="author-description accent1-background invert">
			<div class="author-description_container">
				<div class="author-description_avatar alignleft">
					%5$s
				</div>
				<div class="author-description_content color-invert-accent">
					<h4>
						%1$s
						<a href="%2$s">%3$s</a>
					</h4>
					<p>%4$s</p>
				</div>
			</div>
			<div class="clear"></div>
		</div>'
	);

	printf(
		$author_description_format,
		__( 'Written by', 'blogetti' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() ),
		esc_html( get_the_author_meta( 'description' ) ),
		get_avatar( get_the_author_meta( 'ID' ), 113 )
	);
?>
