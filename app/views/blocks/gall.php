<?php
/**
 * Blocks/Gallery view
 *
 * @package photolab
 */
?><div class="post-featured-gallery" id="featured-gallery-{{ $post_id }}" data-gall-id="featured-gallery-{{ $post_id }}">
	{{ implode('', $rows) }}
</div>
