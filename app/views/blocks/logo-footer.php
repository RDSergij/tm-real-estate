<?php
/**
 * Logo footer view
 *
 * @package photolab
 */
?>

<div class="footer-panel_logo footer-logo_wrap text-center">
	@if ( '' == trim( $logo ) )
		<div class="footer-logo">
			<a class="h2-style" href="{{ $home_url }}"><em>
				{{ $name }}
			</em></a>
			@if ( $description )
				<div class="site-description h6-style"><em>{{ $description }}</em></div>
			@endif
		</div>
	@else
    	<a href="{{ get_bloginfo( 'site' ) }}"><img src="{{ $logo }}" width="200" alt="Footer logo"></a>
    @endif
</div>