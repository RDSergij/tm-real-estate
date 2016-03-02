<?php
/**
 * Blocks/Sidebar creator view
 *
 * @package photolab
 */
?><li id="{{ esc_attr( $id ) }}" class="{{ esc_attr( $class ) }} sidebar-creator">
	<label>
		<span class="customize-control-title">{{ $label }}</span>
		<input type="hidden" class="main-input" value="{{ $value }}" {{ $link }}>
	</label>
	<div class="custom-sidebars">
		<div class="custom-sidebars-inputs {{ esc_attr( $id ) }}-inputs"></div>
		<button class="button button-primary add-sidebar" data-id="{{ esc_attr( $id ) }}">{{ __('Add new sidebar', 'blogetti') }}</button>
	</div>
	<script type="text/template" id="custom-sidebar-input-template">
		<div class="custom-sidebar-row">
			<input type="text" class="sidebars-input" value="<%= value %>">
			<button type="button" class="remove button">-</button>
		</div>
	</script>
</li>
