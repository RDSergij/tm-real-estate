<?php
/**
 * Posts media view
 *
 * @package photolab
 */
?>
<?php $format = get_post_format(); ?>
<?php // Image post format with thumbnail image ?>
@if ( has_post_thumbnail() && 'image' == $format )

	<figure class="entry-thumbnail">
		<div class="thumbnail">
			<a href="{{ get_permalink() }}">
				{{ get_the_post_thumbnail( get_the_ID(), Model_Misc::get_blog_image() ) }}
			</a>
			@include( 'blocks/categories' )
			@include( 'blocks/featured' )
		</div>
	</figure>

<?php // Audio & Video format ?>
@elseif ( 'video' == $format || 'audio' == $format )

	<?php 
		$media = get_media_embedded_in_content( 
		    apply_filters( 'the_content', get_the_content() ), 
		    array( 'audio', 'video', 'object', 'embed', 'iframe' )
		);
	?>
	@if ( ! empty( $media ) && !has_post_thumbnail() && 'video' == $format )
		<figure class="entry-media">
			<div class="media video">
				{{$media[0]}}
			</div>
			
			@include( 'blocks/categories' )
			@include( 'blocks/featured' )
		</figure>
	@endif

	@if ( ! empty( $media ) && !has_post_thumbnail() && 'audio' == $format )
		@include( 'blocks/categories' )
		@include( 'blocks/featured' )

		<figure class="entry-media">
			<div class="media audio">
				{{$media[0]}}
			</div>
		</figure>
		
	@endif

<?php // Gallery format ?>
@elseif ( 'gallery' == $format )

	<figure class="entry-gallery">
		<div class="gallery">
			{{ get_post_gallery() }}
		</div>
	</figure>

	@include( 'blocks/categories' )
	@include( 'blocks/featured' )

<?php // Link format ?>
@elseif ( 'link' == $format )
	@if (has_post_thumbnail() && has_excerpt())
		<figure class="entry-thumbnail entry-link">
			<div class="thumbnail">
				<a href="{{ esc_url(get_the_excerpt()) }}" target="_blank">
					<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id( $post->ID ), 'post-image'); $image = $image[0]; ?>
					<div class="link-image-background" style="background-image: url({{ $image }})"></div>
					<div class="link">{{ esc_url(get_the_excerpt()) }}</div>
				</a>
				@include( 'blocks/categories' )
				@include( 'blocks/featured' )
			</div>
		</figure>
	@elseif (has_excerpt() && !has_post_thumbnail()) 
		<figure class="entry-link without-image">
			<div class="link"><a href="{{ esc_url(get_the_excerpt()) }}" target="_blank">{{ esc_url(get_the_excerpt()) }}</a></div>
		</figure>
	@endif
<?php // Rest of quote format ?>
@elseif ( 'quote' == $format && ( $quote = Social_Post_Types::get_first_quote( get_the_content() ) ) )

	<figure class="entry-quote">
		<div class="quote">
			{{ $quote }}
			@include( 'blocks/categories' )
			@include( 'blocks/featured' )
		</div>
	</figure>

<?php // Rest of formats with thumbnail ?>
@elseif ( has_post_thumbnail() )

	<figure class="entry-thumbnail">
		<div class="thumbnail">
			<a href="{{ get_permalink() }}">
				{{ get_the_post_thumbnail( get_the_ID(), Model_Misc::get_blog_image() ) }}
			</a>
			@include( 'blocks/categories' )
			@include( 'blocks/featured' )
		</div>
	</figure>

@else

	@include( 'blocks/categories' )
	@include( 'blocks/featured' )

@endif