<?php
/**
 * To top button
 *
 * @package photolab
 */
?>
<?php  
	$mobile_class = '';

	if ( wp_is_mobile() ) {
		$mobile_class = 'mobile-back-top';
	}

	printf( '<div id="back-top" class="%s"><a href="#top"><i class="material-icons">keyboard_arrow_up</i></a></div>', $mobile_class );
?>