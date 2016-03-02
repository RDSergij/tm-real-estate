jQuery( document ).ready( function() {
	var carousel = jQuery('.tm-posts-carousel-widget.owl-carousel');
	if ( carousel.length > 0 ) {
		carousel.each( function() {
			jQuery( this ).owlCarousel({
				items: parseInt( jQuery( this ).attr( 'data-slides-per-view' ) ),
				margin: 30,
				smartSpeed: 450,
				loop: false,
				dots: false,
				dotsEach: 1,
				nav: true,
				navClass: ['owl-prev fa fa-angle-left', 'owl-next fa fa-angle-right'],
				responsive:{
					0:{
						items:1,
					},
					480:{
						items:2,
						margin: 10
					},
					992: {
						items: parseInt( jQuery( this ).attr( 'data-slides-per-view' ) ),
					}
				},
			});
		});
	}
});