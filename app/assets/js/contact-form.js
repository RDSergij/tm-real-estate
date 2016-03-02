jQuery(document).ready(
	function() {
		jQuery(document).on(
			'submit',
			'#contact-form',
			function(e) {
				var me = jQuery(this);
				jQuery.ajax({
					method: 'POST',
					url: contact_form.request_url + '?action=send_contact',
					data: me.serializeArray(),
					dataType: 'json'
				})
				.done(
					function( result ) {
						if ( result.status == 'ERROR' ) {
							for (var i = 0; i < result.errors.length; i++ ) {
								console.log(result.errors[i])
								me.prepend( '<div class="error">' + result.errors[i] + '</div>' );
							}
						}
					}
				);
				e.preventDefault();
			}
		);
	}
);