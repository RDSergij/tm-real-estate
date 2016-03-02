<?php
/**
 * Contents/None view
 *
 * @package photolab
 */
?><section class="no-results not-found col-xs-12">
	<div class="not-found_content-wrap">
		<header class="page-header">
			<h4 class="page-title">{{ __( 'Nothing Found', 'blogetti' ) }}</h4>
		</header><!-- .page-header -->

		<div class="page-content">
			@if ( is_home() && current_user_can( 'publish_posts' ) ) 
				<p>{{ sprintf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'blogetti' ), esc_url( admin_url( 'post-new.php' ) ) ) }}</p>

			@elseif ( is_search() )
				<p>{{ __( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'blogetti' ) }} </p>
				{{ $search_form }}
			@else
				<p>{{ __( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'blogetti' ) }}</p>
				{{ $search_form }}
			@endif
		</div><!-- .page-content -->
	</div>
</section><!-- .no-results -->
