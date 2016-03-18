jQuery( document ).ready( function( $ ) {

	var TMREContactForm= function() {

		var tmrec = this;

		tmrec.init = function() {
			tmrec.eventSubmit();
		};

		tmrec.eventSubmit = function() {
			$( '.tm-re-contact-form form' ).submit( function() {
				var _form = $( this );
				$.ajax({
					type: "POST",
					url: window.TMREContactForm.ajaxUrl,
					data: _form.serialize(),
					success: function( response ) {
						console.log(response);
					},
					error: function( response ) {
						console.log(response);
					}
				});
			});
		};
	};

	var tmrec = new TMREContactForm();
	tmrec.init();
} );
