jQuery( document ).ready( function( $ ) {

	var TMREContactForm = function() {

		var tmrec = this;
		tmrec.captchaArea = null;;

		tmrec.init = function() {
			tmrec.captchaInit();
			tmrec.eventSubmit();
		};
		
		tmrec.captchaInit = function() {
			onloadCallback = function() {
				tmrec.captchaArea = window.grecaptcha.render('tm-re-contact-form-captcha', {
					'sitekey' : window.TMREContactForm.captchaKey,
					'theme' : 'light'
				});
				console.log(tmrec.captchaArea);
			};
		};

		tmrec.checkCaptcha = function() {
			if ( null != tmrec.captchaArea ) {
				return grecaptcha.getResponse( tmrec.captchaArea );
			}
			return true;
		};

		tmrec.resetCaptcha = function() {
			if ( null != tmrec.captchaArea ) {
				grecaptcha.reset(
					tmrec.captchaArea
				);
			}
		};

		tmrec.eventSubmit = function() {
			$( '.tm-re-contact-form form' ).submit( function( e ) {
				e.preventDefault();
				var _form = $( this );
				var _message = _form.children( '.message' );
				if ( ! tmrec.checkCaptcha() ) {
					$( '#tm-re-contact-form-captcha' ).addClass( 'captcha-warning' );
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
						$( '#tm-re-contact-form-captcha' ).removeClass( 'captcha-warning' );
						tmrec.resetCaptcha();
					},
					error: function() {
						tmrec.message( _message, 'failed' );
						$( '#tm-re-contact-form-captcha' ).removeClass( 'captcha-warning' );
						tmrec.resetCaptcha();
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
