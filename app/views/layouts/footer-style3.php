<?php
/**
 * Layouts/Footer widgetized view
 *
 * @package photolab
 */
?>

<div class="footer-style-3">
	<section class="footer-content-area footer-bg-color">
		<div class="container">

			<div class="row">
				<div class="col-xs-12">
					@if ( '' != trim( $copyright ) )
						<p class="site-info">
							&#169; <span id="copyright-year"><?php echo date('Y'); ?></span>
							{{ $copyright }}
						</p>
					@endif				
				</div>			
			</div>

			<div class="row vertical-align__center">
				<div class="col-xs-12 col-md-6">
					{{ $menu }}
				</div>

				<div class="col-xs-12 col-md-6">
					@if ( $socials_show_footer )
			        	{{ $socials }}
			        @endif
				</div>
			</div>

		</div>
	</section>
</div>