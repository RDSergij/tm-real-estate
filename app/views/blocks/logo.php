<?php
/**
 * Logo view
 *
 * @package photolab
 */
?>
<div class="site-branding">
	@if ( '' == $logo )
		<{{ $htag }} class="site-title h2-style">
			<a href="{{ $home_url }}" rel="home"><em>
				{{ $name }}
			</em></a>
		</{{ $htag }}>
		@if ( $description )
			<div class="site-description h6-style color-invert-accent"><em>{{ $description }}</em></div>
		@endif
	@else
		<img src="{{ $logo }}" alt="Logo" class="logo">
	@endif
</div>
