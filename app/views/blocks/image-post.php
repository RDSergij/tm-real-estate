<?php
/**
 * Blocks/Image post view
 *
 * @package photolab
 */
?>@if(has_post_thumbnail())
	<figure class="lightbox-image"><a href="{{ esc_url( $fullsize_img ) }}" class="lightbox-gallery">{{ $cropped_image }}<span class="img-mask"></span></a></figure>
@else
	<figure class="lightbox-image"><a href="{{ esc_url( $fullsize_img ) }}" class="lightbox-gallery">{{ $cropped_image }}<span class="img-mask"></span></a></figure>
@endif
