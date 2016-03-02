/**
 * Events list
 */
jQuery( document ).on( 'widget-updated widget-added ready', initWidgetAboutAuthor );


/**
 * ReInit widget
 * @returns {undefined}
 */
function reInitWidgetAboutAuthors() {
	jQuery( '.tm-about-author-form-widget input[type=button].upload_avatar_button' ).off( 'click' );
	jQuery( '.tm-about-author-form-widget .delete_image_url' ).off( 'click' );
	initWidgetAboutAuthor();
}

/**
 * Initialization widget js
 *
 * @returns {undefined}
 */
function initWidgetAboutAuthor() {

	jQuery( '.tm-categories-tiles-form-widget select, .tm-categories-tiles-form-widget input[type=text]' ).change( function() {
		jQuery( document ).trigger( 'widget-change' );
	});

	// Upload image
	jQuery( '.tm-about-author-form-widget input[type=button].upload_avatar_button' ).on( 'click', function( e ) {
		var _this = jQuery( this );
		var inputImage = _this.parents( '.tm-about-author-form-widget' ).find( '.custom-image-url' );
		var inputAvatar = _this.parents( '.tm-about-author-form-widget' ).find( '.avatar img' );
		var delete_avatar_button = _this.parents( '.tm-about-author-form-widget' ).find( '.delete-avatar-button' );
		var customUploaderAboutAuthor = wp.media( {
			title: 'Upload a Image',
			button: {
				text: 'Select'
			},
			multiple: false
		} );

		customUploaderAboutAuthor.on( 'select', function(response) {
			var imgurl = '';
			var imgid = 0;
			console.log(customUploaderAboutAuthor.state().get( 'selection' ).first().attributes.sizes);
			if ( 'undefined' != typeof(customUploaderAboutAuthor.state().get( 'selection' ).first().attributes.sizes.minisquare) ) {
				imgurl = customUploaderAboutAuthor.state().get( 'selection' ).first().attributes.sizes.minisquare.url
				imgid = customUploaderAboutAuthor.state().get( 'selection' ).first().attributes.id;
			} else {
				imgurl = customUploaderAboutAuthor.state().get( 'selection' ).first().attributes.sizes.full.url
				imgid = customUploaderAboutAuthor.state().get( 'selection' ).first().attributes.id;
			}
			inputImage.val( imgid ).trigger( 'change' );
			inputAvatar.attr( 'src', imgurl );//.trigger( 'change' );
			delete_avatar_button.css('display', 'inline');
			//jQuery( document ).trigger( 'widget-change' );
		});
		customUploaderAboutAuthor.open();
		e.preventDefault();
	});

	// Delete image
	jQuery( '.tm-about-author-form-widget .delete_image_url' ).click( function() {
		var _this = jQuery( this );
		var inputImage = _this.parents( '.tm-about-author-form-widget' ).find( '.custom-image-url' );
		var inputAvatar = _this.parents( '.tm-about-author-form-widget' ).find( '.avatar img' );
		var delete_avatar_button = _this.parents( '.tm-about-author-form-widget' ).find( '.delete-avatar-button' );
		var defaultAvatar = inputAvatar.attr( 'default_image' );
		inputAvatar.attr( 'src', defaultAvatar );
		inputImage.val( '' ).trigger( 'change' );
		delete_avatar_button.hide();
	});
}
