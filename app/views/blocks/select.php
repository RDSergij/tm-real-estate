<?php
/**
 * Blocks/Select view
 *
 * @package photolab
 */
?><select {{ $attributes }}>
	@foreach ($values as $key => $value) 
		<option value="{{ $key }}" {{ selected($current_value, $key, false) }}>{{ $value }}</option>
	@endforeach
</select>
