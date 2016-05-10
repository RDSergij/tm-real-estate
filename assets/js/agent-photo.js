jQuery( document ).ready( function( $ ) {

	// Uploading files
	var file_frame;

	var TMREAgentPhoto = function() {

		var tmrePhoto = this;

		tmrePhoto.init = function() {
			tmrePhoto.clickEvent();
		};

		tmrePhoto.clickEvent = function( selector ) {
			var image_src;
			event.preventDefault();
			$( '.tm_re_agent_photo_wpmu_button' ).on('click', function(){

				// If the media frame already exists, reopen it.
				if ( file_frame ) {
					file_frame.open();
					return;
				}

				// Create the media frame.
				file_frame = wp.media.frames.file_frame = wp.media({
					title: jQuery( this ).data( 'uploader_title' ),
					button: {
						text: jQuery( this ).data( 'uploader_button_text' ),
					},
					multiple: false  // Set to true to allow multiple files to be selected
				});

				// When an image is selected, run a callback.
				file_frame.on( 'select', function() {
					// We set multiple to false so only get one image from the uploader
					attachment = file_frame.state().get('selection').first().toJSON();
					console.log(file_frame.state().get('selection').first().toJSON());

					if ( ! attachment.sizes.medium.url ) {
						image_src = attachment.url;
					} else {
						image_src = attachment.sizes.medium.url;
					}

					// Do something with attachment.id and/or attachment.url here
					// write the selected image url to the value of the #tm_re_agent_photo_meta text field
					$('#tm_re_agent_photo_upload_meta').val(attachment.id);
					$('#tm_re_agent_photo_upload_edit_meta').val('/wp-admin/post.php?post='+attachment.id+'&action=edit&image-editor');
					$('.agent-photo-img').attr('src', image_src).removeClass('placeholder');
				});

				// Finally, open the modal
				file_frame.open();
			});
		};
	};

	var tmrePhoto = new TMREAgentPhoto();
	tmrePhoto.init();
} );


jQuery(document).ready(function($){

 
 

  // Update hidden field meta when external option url is entered
  jQuery('#tm_re_agent_photo_meta').blur(function(event) {
    if( '' !== $(this).val() ) {
      jQuery('#tm_re_agent_photo_upload_meta').val('');
      jQuery('.agent-photo-img').attr('src', $(this).val()).removeClass('placeholder');
    }
  });

// Remove Image Function
  jQuery('.edit_options').hover(function(){
    jQuery(this).stop(true, true).animate({opacity: 1}, 100);
  }, function(){
    jQuery(this).stop(true, true).animate({opacity: 0}, 100);
  });

  jQuery('.remove_img').on('click', function( event ){
    var placeholder = jQuery('#tm_re_agent_photo_placeholder_meta').val();

    jQuery(this).parent().fadeOut('fast', function(){
      jQuery(this).remove();
      jQuery('.agent-photo-img').addClass('placeholder').attr('src', placeholder);
    });
    jQuery('#tm_re_agent_photo_upload_meta, #tm_re_agent_photo_upload_edit_meta, #tm_re_agent_photo_meta').val('');
  });

});