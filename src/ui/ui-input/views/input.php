<?php
/**
 * Description: Fox ui-elements
 * Author: Osadchyi Serhii
 * Author URI: https://github.com/RDSergij
 *
 * @package ui_input_fox
 *
 * @since 0.2.1
 */
?>

@if ( ! empty( $label ) )
<label>{{ $label }}</label>
@endif
<input  {{ $attributes }}
	@if( ! empty( $datalist ) )
	list="{{ $datalist_id }}"
	@endif
>

@if( ! empty( $datalist ) )
<datalist id="{{ $datalist_id }}">
	@foreach( $datalist as $dataitem )
	<option>{{ $dataitem }}</option>
	@endforeach
</datalist>
@endif
