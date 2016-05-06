jQuery( document ).ready( function( $ ) {

	// Uploading files
	var file_frame;

	var TMREAgentPhoto = function() {

		var tmrePhoto = this;

		tmrePhoto.init = function() {
			tmrePhoto.events();
		};

		tmrePhoto.events = function() {

			// Open upload dialog
			$( '.tm_re_agent_photo_wpmu_button' ).on( 'click', function( event ) {
				event.preventDefault();
				tmrePhoto.uploadIframe();
			});

			// Remove Image Function
			$( '.edit_options' ).hover( function() {
				$( this ).stop( true, true ).animate({opacity: 1}, 100);
			}, function(){
				$( this ).stop( true, true ).animate({opacity: 0}, 100);
			});

			$( '.remove_img' ).on( 'click', function( event ) {
				event.preventDefault();
				var placeholder = $( '#tm_re_agent_photo_placeholder_meta' ).val();

				$( this ).parent().fadeOut( 'fast', function() {
					$( this ).remove();
					$( '.agent-photo-img' ).addClass( 'placeholder' ).attr( 'src', placeholder );
				});
				$( '#tm_re_agent_photo_upload_meta, #tm_re_agent_photo_upload_edit_meta, #tm_re_agent_photo_meta' ).val( '' );
			});
		};

		tmrePhoto.uploadIframe = function() {
			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: false  // Set to true to allow multiple files to be selected
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				attachment = file_frame.state().get( 'selection' ).first().toJSON();

				// Set photo
				tmrePhoto.setPhoto( attachment );
			});

			// Finally, open the modal
			file_frame.open();
		};

		tmrePhoto.setPhoto = function( attachment ) {
			var imageSrc;
			if ( undefined === attachment.sizes ||  undefined === attachment.sizes.medium ) {
				imageSrc = attachment.url;
			} else {
				imageSrc = attachment.sizes.medium.url;
			}

			// Do something with attachment.id and/or attachment.url here
			// write the selected image url to the value of the #tm_re_agent_photo_meta text field
			$( '#tm_re_agent_photo_upload_meta' ).val( attachment.id );
			$( '#tm_re_agent_photo_upload_edit_meta' ).val( './post.php?post=' + attachment.id + '&action=edit&image-editor' );
			$( '.agent-photo-img' ).attr('src', imageSrc).removeClass( 'placeholder' );
		};
	};

	var tmrePhoto = new TMREAgentPhoto();
	tmrePhoto.init();
} );
