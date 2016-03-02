jQuery(window).load(
	function(){
		if ( jQuery('.loader-wrapper').length > 0 ) {
			jQuery('.loader-wrapper').delay(1000).fadeOut();
		}
	}
);
jQuery(document).ready(
	function(){
		if ( app.stickymenu === '1' ) {
			jQuery('.site-header').StickyMenu();
		}

		/* Hamburger area */
		var hamburgerButton = jQuery('#hamburger-button'),
			hamburgerArea = jQuery('.hamburger-area');

		hamburgerButton.on('click', function(event){
			event.preventDefault();

			if (hamburgerArea.hasClass('opened')) {
				hamburgerButton.removeClass('active');
				hamburgerArea.hide('fast').removeClass('opened');
			} else {
				hamburgerButton.addClass('active');
				hamburgerArea.show('fast').addClass('opened');
			}
		});

		// Magnific links
		jQuery('.popup-link').magnificPopup({
			type:'image',
			mainClass: 'mfp-with-zoom'
		});
		jQuery('.popup-gallery').each(function() {
			jQuery(this).magnificPopup({
				delegate: 'a.popup-gallery-link', 
				type: 'image',
				mainClass: 'mfp-with-zoom',
				gallery: {
					enabled: true
				}				
			});
		});

		// Masonry
		if ( jQuery('.masonry').length > 0 ) {
			jQuery('.masonry').masonry({ itemSelector: '.brick' });
			setTimeout( function() { jQuery('.masonry').masonry( 'layout' ); } , 1000 );
			setTimeout( function() { jQuery('.masonry').masonry( 'layout' ); } , 2000 );
		}

		// Back to Top
		jQuery( window ).scroll(function() {
			if ( jQuery( this ).scrollTop() > 100 ) {
				jQuery( '#back-top' ).addClass( 'show-totop' );
			} else {
				jQuery( '#back-top' ).removeClass( 'show-totop' );
			}
		});

		jQuery( '#back-top a' ).click(function() {
			jQuery( 'body,html' ).stop( false, false ).animate({
				scrollTop: 0
			}, 800 );
			return false;
		});

		jQuery('iframe').each(function(){
	        var url = jQuery(this).attr("src");
	        jQuery(this).attr("src",url+"?wmode=transparent");
	    });
	}
);