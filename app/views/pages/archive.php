<?php
/**
 * Pages/archive view
 *
 * @package photolab
 */
?>{{ Model_Main::header() }}

	<div id="content" class="site-content">
		<div class="container">
			{{ $breadcrumbs }}
			<div class="row">
				@include('layouts/container-index-'.$sidebar_side_type)
			</div>
		</div>
	</div><!-- #primary -->

{{ Model_Main::footer() }}
