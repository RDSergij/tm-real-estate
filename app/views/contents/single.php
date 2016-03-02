<?php
/**
 * Contents/Single view
 *
 * @package photolab
 */
?>
<?php $format = get_post_format(); ?>
<article id="post-{{ get_the_ID() }}" class="{{ join( ' ', get_post_class() ) }} col-xs-12">
	
	<div class="entry-wrapper {{ Model_Main::sticky_class() }}">

		@include( 'blocks/featured' )
		@include( 'blocks/categories' )
		
		{{ the_title( sprintf( ' <h3 class="entry-title"><em>', esc_url( get_permalink() ) ), '</em></h3>', false ) }}

		@if ( ! $hide_additional_info_in_single )
			@include('blocks/aditional-post-info')
		@endif

		@if ( 'link' == $format )

			@if (has_post_thumbnail() && has_excerpt())
				<figure class="entry-thumbnail entry-link">
					<div class="thumbnail">
						<a href="{{ esc_url(get_the_excerpt()) }}" target="_blank">
							{{ get_the_post_thumbnail( get_the_ID(), Model_Misc::get_blog_image() ) }}
									
							<div class="link">{{ esc_url(get_the_excerpt()) }}</div>
						</a>
					</div>
				</figure>
			@elseif (has_excerpt() && !has_post_thumbnail()) 
				<figure class="entry-link without-image">
					<div class="link"><a href="{{ esc_url(get_the_excerpt()) }}" target="_blank">{{ esc_url(get_the_excerpt()) }}</a></div>
				</figure>
			@endif

		@elseif ( !'quote' == $format && ( $quote = Social_Post_Types::get_first_quote( get_the_content() ) ) )

			<figure class="entry-quote">
				<div class="quote">
					{{ $quote }}
				</div>
			</figure>

		@elseif ( has_post_thumbnail() )
			<?php 
				$imageSrc = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID () ), 'full' ); 
				$imageSrc = $imageSrc[0]; 
			?>
			<figure class="entry-thumbnail">
				<div class="thumbnail">
					<a href="{{ $imageSrc }}" class="popup-link">
						{{ get_the_post_thumbnail( get_the_ID(), Model_Misc::get_blog_image() ) }}
					</a>
				</div>
			</figure>
		@endif

		@if (get_post_meta( get_the_ID(), 'social_post_code', true ))
			<div class="social-post-code
				@if( stripos( get_post_meta( get_the_ID(), 'social_post_code', true ), 'fb-root' ) )
				facebook-code
				@endif
				@if( stripos( get_post_meta( get_the_ID(), 'social_post_code', true ), 'twitter-tweet' ) )
				twitter-code
				@endif
				">
				{{ $social_post_code }}
			</div>
		@endif
		
		<div class="post-content">
			<?php the_content( __( $read_more, 'blogetti' ) ) ?>
			{{ wp_link_pages( 
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'blogetti' ),
					'after'  => '</div>',
					'echo'   => false
				)
			) }}
		</div>
		
		@if( $is_show_in_post )
	        @include( 'blocks/social-share' )
	    @endif

	    @include( 'blocks/author' )
	</div>

</article><!-- #post-## -->