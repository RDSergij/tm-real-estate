/**
 * Events list
 */
jQuery( document ).on( 'widget-updated widget-added ready', initWidgetSubscribeAndSocial );

/**
 * Renumber list
 * @returns {undefined}
 */
function reNumberSubscribeAndSocial( socials ) {
	socials.find( '.social-area' ).each( function( index ) {
		jQuery( this ).find( 'h4 span' ).html( index + 1 );
	});
}

/**
 * ReInit widget
 * @returns {undefined}
 */
function reInitWidgetSubscribeAndSocial() {
	jQuery( '.tm-subscribe-and-share-widget .social-area .delete-social' ).off( 'click' );
	jQuery( '.tm-subscribe-and-share-widget .socials .add-social' ).off( 'click' );
	initWidgetSubscribeAndSocial();
}

/**
 * Initialization widget js
 *
 * @returns {undefined}
 */
function initWidgetSubscribeAndSocial() {

	// Delete social
	jQuery( '.tm-subscribe-and-share-widget .social-area .delete-social' ).click( function() {
		var _this = jQuery( this );
		var social = _this.parents( '.social-area' );
		var socials = _this.parents( '.tm-subscribe-and-share-widget' ).find( '.socials' );
		var socialsCount = parseInt( socials.attr( 'count' ), 10 ) - 1;
		socials.attr( 'count', socialsCount );
		social.find( 'input' ).trigger( 'change' );
		social.remove();
		reNumberSubscribeAndSocial( socials );
		reInitWidgetSubscribeAndSocial();
	});

	// Add social
	jQuery( '.tm-subscribe-and-share-widget .socials .add-social' ).click( function() {
		var _this = jQuery( this );
		var socials = _this.parents( '.tm-subscribe-and-share-widget' ).find( '.socials' );
		var socialsCount = parseInt( socials.attr( 'count' ), 10 ) + 1;
		var social = _this.parents( '.tm-subscribe-and-share-widget' ).find( '.social-new' );
		var socialNew = social.clone();
		social.before( socialNew );
		socials.attr( 'count', socialsCount );
		socialNew.toggleClass( 'social-area social-new' );

		socialNew.find( 'input' ).each( function() {
			var _inputItem = jQuery( this );
			var name = _inputItem.attr( 'name' );
			name = name.replace( '_new', '' );
			_inputItem.attr( 'name', name );
		});

		socialNew.find( 'h3 span' ).html( socialsCount );
		reNumberSubscribeAndSocial( socials );
		reInitWidgetSubscribeAndSocial();
	});
}
