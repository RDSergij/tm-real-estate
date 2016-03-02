<?php
/**
 * Layouts/Footer widgetized view
 *
 * @package photolab
 */
?>

<div class="footer-style-2">
	<div class="footer-widgets footer-widget-bg-color widgets-in-column">
		<div class="container">
			@if ( 2 == $columns )
				<div class="row">
					<div class="col-xs-12 col-md-6"><?php dynamic_sidebar( 'footer-1' ) ?></div>
					<div class="col-xs-12 col-md-6"><?php dynamic_sidebar( 'footer-2' ) ?></div>
				</div>
			@elseif( 3 == $columns )
				<div class="row">
					<div class="col-xs-12 col-md-4"><?php dynamic_sidebar( 'footer-1' ) ?></div>
					<div class="col-xs-12 col-md-4"><?php dynamic_sidebar( 'footer-2' ) ?></div>
					<div class="col-xs-12 col-md-4"><?php dynamic_sidebar( 'footer-3' ) ?></div>
				</div>
			@else
				<div class="row">
					<div class="col-xs-12 col-md-3"><?php dynamic_sidebar( 'footer-1' ) ?></div>
					<div class="col-xs-12 col-md-3"><?php dynamic_sidebar( 'footer-2' ) ?></div>
					<div class="col-xs-12 col-md-3"><?php dynamic_sidebar( 'footer-3' ) ?></div>
					<div class="col-xs-12 col-md-3"><?php dynamic_sidebar( 'footer-4' ) ?></div>
				</div>
			@endif
		</div>
	</div>
	<section class="footer-content-area footer-bg-color">
		<div class="container">
			<div class="hr"></div>
			<div class="row vertical-align__center">
				
				<div class="col-xs-12 align-center">
					@if ( '' != trim( $copyright ) )
						<p class="site-info align-center">
							&#169; <span id="copyright-year"><?php echo date('Y'); ?></span>
							{{ $copyright }}
						</p>
					@endif

					{{ $menu }}
				</div>
				
			</div>
		</div>
	</section>
</div>