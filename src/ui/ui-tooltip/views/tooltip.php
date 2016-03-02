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

<div {{ $attributes }}>{{ $title }}
	@if ( ! empty( $description ) )
	<span class="tooltiptext {{ $direction }}">{{ $description }}</span>
	@endif
</div>
