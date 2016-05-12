jQuery( document ).ready( function() {
	var galleryTop = new window.Swiper( '.properties .property-item .gallery-top', {
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		spaceBetween: 10
	});

	var galleryThumbs = new window.Swiper( '.properties .property-item .gallery-thumbs', {
		spaceBetween: 10,
		slidesPerView: 6,
		centeredSlides: false,
		slidesPerView: 'auto',
		touchRatio: 0.2,
		slideToClickedSlide: true
	});

	galleryTop.params.control		= galleryThumbs;
	galleryThumbs.params.control	= galleryTop;
});