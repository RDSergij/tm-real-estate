<?php
/**
 * Widgets/Back end/Advertisement view
 *
 * @package photolab
 */
?><p>
	<label for="{{ $field_id_title }}">{{ __( 'Title:', 'blogetti' ) }}</label>
	<input class="widefat" id="{{ $field_id_title }}" name="{{ $field_name_title }}" type="text" value="{{ esc_attr( $title ) }}" />
</p>
<p>
	<label for="{{ $field_id_description }}">{{ __( 'Description:', 'blogetti' ) }}</label>
	<input class="widefat" id="{{ $field_id_description }}" name="{{ $field_name_description }}" type="text" value="{{ esc_attr( $description ) }}" />
</p>
<p>
	<label for="{{ $field_id_url }}">{{ __( 'Url:', 'blogetti' ) }}</label>
	<input class="widefat" id="{{ $field_id_url }}" name="{{ $field_name_url }}" type="text" value="{{ esc_attr( $url ) }}" />
</p>
<div class="wp_media_upload">
	@if ( '' != $image )
		<img src="{{ esc_url( $image ) }}" alt="Image" style="width:98%" class="uploaded-image">
	@endif
	<input name="{{ $field_name_image }}" id="{{ $field_id_image }}" class="widefat uploaded-id" type="hidden" value="{{ $id }}" />
	<button id="button_{{ $field_id_image }}" class="upload_button button button-upload button-primary">{{ __('Upload Image', 'blogetti') }}</button>
	<button id="button_remove_{{ $field_id_image }}" class="button button-remove" style="{{ $remove_show }}">{{ __('Remove', 'blogetti') }}</button>
	<div class="clear"></div>
	<br>
</div>
