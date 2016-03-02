<?php
/**
 * Blocks/Gallery row view
 *
 * @package photolab
 */
?><div class="gall-row {{ esc_attr( $item_class ) }}">
	{{ implode('', $items) }}
</div>
