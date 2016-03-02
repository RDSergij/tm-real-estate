<?php
/**
 * Layouts/Footer default view
 *
 * @package photolab
 */
?>

<div class="footer-style-1">
	<div class="footer-widgets footer-widget-bg-color">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 invert">
					<?php dynamic_sidebar( 'footer' ) ?>
				</div>
			</div>
		</div>
	</div>
	<section class="footer-content-area footer-bg-color">
	    <div class="container">

	    	<div class="hidden-sm-down">
	    		@include( 'blocks/logo-footer' )
	    	</div>
	    	
	    	@if ( $socials_show_footer )
	        	{{ $socials }}
	        @endif

	       <div class="footer-copyright-menu-wrap inline-blocks align-center">
		        @if ( '' != trim( $copyright ) )
		        	<p class="site-info align-center">
		        	    &#169; <span id="copyright-year"><?php echo date('Y'); ?></span>
		        	    {{ $copyright }}
		        	</p>
		        @endif

		        {{ $menu }}
	        </div>
	    </div>
	</section>
</div>