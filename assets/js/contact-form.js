jQuery( document ).ready( function( $ ) {

	var TMREContactForm= function() {

		var tmrec = this;

		tmrec.init = function() {
			tmrec.eventSubmit();
		};

		tmrec.eventSubmit = function() {
			$( '.tm-re-contact-form form' ).submit( function( e ) {
				var _form = $( this );
				var _message = _form.children( '.message' );
				$.ajax({
					type: "POST",
					url: window.TMREContactForm.ajaxUrl,
					data: _form.serialize(),
					success: function( response ) {
						var status = 'success';
						if ( ! response.result ) {
							status = 'failed';
						}
						tmrec.message( _message, status );
					},
					error: function() {
						tmrec.message( _message, 'failed' );
					}
				});
				
				e.preventDefault();
			});
		};

		tmrec.message = function( selector, status ) {
			var message = '';
			message = window.TMREContactForm[ status + 'Message' ];
			selector.removeClass('success failed');
			selector.addClass( status );
			selector.html( message );
			selector.show();
			selector.fadeOut( 3000 );
		};
	};

	var tmrec = new TMREContactForm();
	tmrec.init();
} );
