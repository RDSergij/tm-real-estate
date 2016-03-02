<?php
/**
 * Widgets/Back end/Accordion view
 *
 * @package photolab
 */
?><p>
	<label for="{{ $field_id_title }}">{{ __( 'Title:', 'blogetti' ) }}</label> 
	<input class="widefat" id="{{ $field_id_title }}" name="{{ $field_name_title }}" type="text" value="{{ esc_attr( $title ) }}">
</p>
<p>
	<label for="{{ $field_id_post_ids }}">{{ __( 'Post ids:', 'blogetti' ) }}</label> 
	<input class="widefat" id="{{ $field_id_post_ids }}" name="{{ $field_name_post_ids }}" type="text" value="{{ esc_attr( $post_ids ) }}">
</p>
<p>
	<label for="{{ $field_id_category }}">{{ __( 'Category:', 'blogetti' ) }}</label>
	{{ $dropdown_categories }}
</p>
