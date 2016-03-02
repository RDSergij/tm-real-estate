<?php
/**
 * Blocks/Gallery imgage view
 *
 * @package photolab
 */
?><div class="gall-img-wrap {{ esc_attr( $class ) }}"><a href="{{ esc_url( $fullsize_img ) }}" class="lightbox-gallery">{{ $cropped_image }}<span class="img-mask"></span></a></div>
