/* Camera
 ========================================================*/

jQuery( document ).ready( function() {
	var slider = jQuery('.slider_widget');
	if ( slider.length > 0 ) {
		slider.each( function() {
			jQuery( this ).camera({
				autoAdvance: JSON.parse( jQuery( this ).attr( 'data-autoplay' ) ),
				height: '48.38541666666667%',
				minHeight: '200px',
				pagination: JSON.parse( jQuery( this ).attr( 'data-bullets_is' ) ),
				thumbnails: JSON.parse( jQuery( this ).attr( 'data-thumbnails_is' ) ),
				playPause: false,
				hover: false,
				loader: 'none',
				navigation: JSON.parse( jQuery( this ).attr( 'data-arrows_is' ) ),
				navigationHover: true,
				mobileNavHover: false,
				fx: 'simpleFade'
			});
		} );
	}
});
