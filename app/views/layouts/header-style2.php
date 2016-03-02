<?php
/**
 * Layouts/Header centerd view
 *
 * @package photolab
 */
?>

<div class="container invert header-centered">

	<div class="row vertical-align__center">
		<div class="col-xs-12 col-md-3 hidden-sm-down"></div>
		<div class="col-xs-12 col-md-6">
			@include('blocks/logo')
		</div>
		@if ( $socials_show_header )
			<div class="col-xs-12 col-md-3 hidden-sm-down">
				{{ $socials }}
			</div>
		@endif
	</div>

	<div class="row">
		<div class="col-xs-12 hidden-sm-down">
			<div class="main-nav-wrap">
				{{ $main_menu }}
			</div>
		</div>
	</div>

</div>