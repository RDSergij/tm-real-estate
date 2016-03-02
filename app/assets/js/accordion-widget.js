jQuery( document ).on(
    'click',
	'.accordion h3',
	function( e ) {
		jQuery( '.accordion h3' ).removeClass( 'visible' );
		jQuery( '.accordion div' ).removeClass( 'active' );
		jQuery( this ).next( 'div' ).addClass( 'active' );
		jQuery( '.accordion div:not(".active")' ).hide();
		jQuery( '.accordion div.active' ).slideToggle(
			'fast',
			function() {
				jQuery( '.accordion div:visible' ).prev( 'h3' ).addClass( 'visible' );
			}
	    );
		e.preventDefault();
	}
);
