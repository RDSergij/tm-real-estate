<?php
/**
 * Layouts/Header minimal view
 *
 * @package photolab
 */
?>
<div class="container invert header-minimal">

	<div class="row vertical-align__center">
		<div class="col-xs-12 col-md-8">
			@include('blocks/logo')
		</div>
		@if ( $socials_show_header )
			<div class="col-xs-12 col-md-4 hidden-sm-down">
				{{ $socials }}
			</div>
		@endif
	</div>
	<div class="row">
		<div class="col-xs-12 col-md-12 hidden-sm-down">
			{{ $main_menu }}
		</div>
	</div>
	
</div>
