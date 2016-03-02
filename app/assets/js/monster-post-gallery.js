jQuery( document ).ready( function() {
	var post_gallery = jQuery('.photolab-gallery.owl-carousel');
	post_gallery.owlCarousel({
		items: 1,
		margin: 0,
		smartSpeed: 450,
		loop: true,
		dots: false,
		dotsEach: 1,
		nav: true,
		navClass: ['owl-prev fa fa-angle-left', 'owl-next fa fa-angle-right']
	});
});