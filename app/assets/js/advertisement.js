jQuery( document ).on(
	'click',
	'.button-upload',
	function( e ) {
		var sendAttachmentBkp = wp.media.editor.send.attachment;
		var $button = jQuery( this );
		var img_url = '';
		wp.media.editor.send.attachment = function( props, attachment ) {
			var $img = $button.parent().find( 'img' );
			if ( $img.length > 0 ) {
				$img.attr( 'src', attachment.sizes['thumbnail'].url );
			} else {
				$button.parent().prepend( '<img src="' + attachment.sizes['thumbnail'].url + '" alt="Image" class="uploaded-image">' );
			}
			$button.prev( 'input' ).val( attachment.id );
			$button.prev( 'input' ).trigger( 'change' );
			$button.parent().find('.button-remove').show();
			wp.media.editor.send.attachment = sendAttachmentBkp;
		};
		wp.media.editor.open( $button );
		e.preventDefault();
	}
);

jQuery( document ).on(
	'click',
	'.button-remove',
	function( e ) {
		jQuery( this ).parent().find('img').remove();
		jQuery( this ).hide();
		jQuery( this ).parent().find( 'input' ).val('');
		jQuery( this ).parent().find( 'input' ).trigger( 'change' );
		e.preventDefault();
	}
);
