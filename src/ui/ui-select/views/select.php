<?php
/**
 * Description: Fox ui-elements
 * Version: 0.1.0
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 *
 * @package ui_input_fox
 *
 * @since 0.1.0
 */
?>

<select {{ $attributes }}>
	@foreach( $options as $value => $title )
	<option value="{{ $value }}"
		@if( $default == $value )
		selected="selected"
		@endif
	>
		{{ $title }}
	</option>
	@endforeach
</select>
