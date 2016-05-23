jQuery( document ).ready( function( $ ) {

	var TMREContactForm = function() {

		var tmrec = this;
		tmrec.captchaArea = [];

		tmrec.init = function() {
			tmrec.captchaInit();
			tmrec.eventSubmit();
		};

		tmrec.captchaInit = function() {
			window.onloadCallback = function() {
				$( '.tm-re-contact-form form' ).each( function( index, element ) {
					tmrec.captchaArea[ $( element ).attr( 'data-captcha' ) ] = window.grecaptcha.render( $( element ).attr( 'data-captcha' ), {
						'sitekey': window.TMREContactForm.captchaKey,
						'theme': 'light'
					});
				});
			};
		};

		tmrec.checkCaptcha = function( captha_id ) {
			if ( null != tmrec.captchaArea[ captha_id ] ) {
				return window.grecaptcha.getResponse( tmrec.captchaArea[ captha_id ] );
			}
			return true;
		};

		tmrec.resetCaptcha = function( captha_id ) {
			if ( null != tmrec.captchaArea[ captha_id ] ) {
				window.grecaptcha.reset(
					tmrec.captchaArea[ captha_id ]
				);
			}
		};

		tmrec.eventSubmit = function() {
			$( '.tm-re-contact-form form' ).submit( function( e ) {
				var _form = $( this );
				var _message = _form.children( '.message' );
				var captha_id = _form.attr( 'data-captcha' );

				e.preventDefault();

				if ( ! tmrec.checkCaptcha( captha_id ) ) {
					$( '#' + captha_id ).addClass( 'captcha-warning' );
					return false;
				}

				$.ajax({
					type: 'POST',
					url: window.TMREContactForm.ajaxUrl,
					data: _form.serialize(),
					success: function( response ) {
						var status = 'success';
						if ( ! response.result ) {
							status = 'failed';
						}
						tmrec.message( _message, status );
						$( '#' + captha_id ).removeClass( 'captcha-warning' );
						tmrec.resetCaptcha( captha_id );
						_form.trigger('reset');
					},
					error: function() {
						tmrec.message( _message, 'failed' );
						$( '#' + captha_id ).removeClass( 'captcha-warning' );
						tmrec.resetCaptcha( captha_id );
					}
				});
			});
		};

		tmrec.message = function( selector, status ) {
			var message = '';
			message = window.TMREContactForm[ status + 'Message' ];
			selector.removeClass( 'success failed' );
			selector.addClass( status );
			selector.html( message );
			selector.show();
			selector.fadeOut( 3000 );
		};
	};

	var tmrec = new TMREContactForm();
	tmrec.init();
} );
