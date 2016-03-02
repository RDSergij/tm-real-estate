<?php
/**
 * Sections/Footer view
 *
 * @package photolab
 */
?>

	<footer id="footer" class="site-footer invert">
		@include( 'layouts/footer-'.$footer_style )
	</footer>

	@include( 'blocks/totop' )

</div>

<?php wp_footer(); ?>

</body>
</html>