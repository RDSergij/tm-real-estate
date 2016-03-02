jQuery( document ).ready( function() {
	jQuery( '.tm-subscribe-and-share-widget form' ).submit( function( e ) {
		var _this = jQuery( this );
		var emailInput = _this.find( 'input[type=email]' );
		var _messages = _this.find( '.message' );
		_messages.removeClass('warning_message failed_message success_message');
		_messages.html('');
		var data = _this.serialize();
		_messages.removeClass( 'success failed' );
		jQuery.post( window.TMSubscribeAndShareWidgetParam.ajaxurl, data, function( response ) {
			_messages.addClass( response.status +'_message' );
			_messages.html( response.message );
			_messages.show( 'slow' ).delay( 3000 ).fadeOut( function() {
				emailInput.val( '' );
			});
		 } )
		.fail( function() {
			_messages.addClass( 'failed_message' );
			_messages.html( TMSubscribeAndShareWidgetParam.failed_message );
			_messages.show( 'slow' ).delay( 3000 ).fadeOut( function() {
				emailInput.val( '' );
			});
		} );

		e.preventDefault();
	});
});
