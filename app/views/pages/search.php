<?php
/**
 * Pages/Search view
 *
 * @package photolab
 */
?>{{ Model_Main::header() }}

	<div id="primary" class="site-content">
		<div class="container">
			{{ $breadcrumbs }}
			<div class="row">
				 <div class="col-xs-12"> 
					@if ( have_posts() )
						@while ( have_posts() )
							<?php the_post(); ?>
							@include('contents/content')
						@endwhile

						<nav class="navigation pagination" role="navigation">
							<div class="nav-links">
								{{ $paginate_links }}
							</div>
						</nav>
					@else
						@include('contents/none')
					@endif
				</div>
			</div>
		</div>
	</div><!-- #primary -->

{{ Model_Main::footer() }}
