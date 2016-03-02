<?php
/**
 * Layouts/Header default view
 *
 * @package photolab
 */
?>
<div class="container-fluid invert">
	<div class="row vertical-align__center">

		<div class="col-xs-12 col-lg-12 col-xl-3">
			@include('blocks/logo')
		</div>

		<div class="col-xs-12 col-lg-12 col-xl-6 hidden-sm-down">
			{{ $main_menu }}
		</div>

		<div class="col-xs-12 col-lg-12 col-xl-3 hidden-sm-down">
			@if ( $socials_show_header )
				{{ $socials }}
			@endif
		</div>

	</div>
</div>
