jQuery( document ).ready( function() {
	var galleryTop = new window.Swiper( '.properties .property-item .gallery-top', {
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		spaceBetween: 10
	});

	var galleryThumbs = new window.Swiper( '.properties .property-item .gallery-thumbs', {
		spaceBetween: 10,
		centeredSlides: false,
		slidesPerView: 6,
		touchRatio: 0.2,
		slideToClickedSlide: true
	});

	galleryTop.params.control		= galleryThumbs;
	galleryThumbs.params.control	= galleryTop;
});