<?php
/**
 * Contents/Content view
 *
 * @package photolab
 */
?>

<?php do_action( 'photolab_before_post' ); ?>

<?php $format = get_post_format(); ?>

<article id="post-{{ get_the_ID() }}" class="col-xs-12 {{ join( ' ', get_post_class() ) }}">

	<div class="entry-wrapper {{ Model_Main::sticky_class() }}">
		
		@include( 'blocks/media' )

		{{ the_title( sprintf( ' <h3 class="entry-title"><a href="%s" rel="bookmark"><em>', esc_url( get_permalink() ) ), '</em></a></h3>', false ) }}

		@if ( ! $hide_additional_info_in_loop )
		@include( 'blocks/aditional-post-info' )
		@endif

		<div class="post-content">
			@if (get_post_meta( get_the_ID(), 'social_post_code', true ))
				<div class="social-post-code
								@if( stripos( get_post_meta( get_the_ID(), 'social_post_code', true ), 'fb-root' ) )
								facebook-code
								@endif
								@if( stripos( get_post_meta( get_the_ID(), 'social_post_code', true ), 'twitter-tweet' ) )
								twitter-code
								@endif
								">
				{{ get_post_meta( get_the_ID(), 'social_post_code', true ) }}
				</div>
			@endif
			@if ( 'link' !== $format && 'quote' !== $format && 'audio' !== $format)
				@if ( is_search() )
				<div class="entry-summary">
					@include('blocks/excerpt')
				</div><!-- .entry-summary -->
				@else
				<div class="entry-content">
					@if( 'only_excerpt' == $blog_content )
						@include('blocks/excerpt')
					@else
						<?php the_content( __( $read_more, 'blogetti' ) ) ?>
						{{ wp_link_pages( 
							array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'blogetti' ),
								'after'  => '</div>',
								'echo'   => false
							)
						) }}
					@endif
				</div><!-- .entry-content -->
				@endif
			@endif
		</div>
		<footer class="entry-footer share-post link-post">
			<div class="row vertical-align__center">
				<div class="col-xs-10 col-md-6">
					@if ( $is_show_in_posts )
						@include( 'blocks/social-share' )
					@endif
				</div>
				<div class="col-xs-2 col-md-6 align-right">
					@include( 'blocks/read-more' )
				</div>
			</div>
		</footer>
	</div>
	
</article>
