/**
 * Events list
 */
jQuery( document ).on( 'widget-updated widget-added ready', initWidgetCategoriesTiles );

/**
 * Renumber list
 * @returns {undefined}
 */
function reNumberCategoriesTiles( categories ) {
	categories.find( '.category-area' ).each( function( index ) {
		jQuery( this ).find( 'h3 span' ).html( index + 1 );
	});
}

/**
 * ReInit widget
 * @returns {undefined}
 */
function reInitWidgetCategoriesTiles() {
	jQuery( '.tm-categories-tiles-form-widget select, .tm-categories-tiles-form-widget input[type=text]' ).off( 'change' );
	jQuery( '.tm-categories-tiles-form-widget div.upload-image img' ).off( 'click' );
	jQuery( '.tm-categories-tiles-form-widget .upload-image .delete-image-url' ).off( 'click' );
	jQuery( '.tm-categories-tiles-form-widget .category-area .delete-category' ).off( 'click' );
	jQuery( '.tm-categories-tiles-form-widget .categories .add-category' ).off( 'click' );
	initWidgetCategoriesTiles();
}

/**
 * Initialization widget js
 *
 * @returns {undefined}
 */
function initWidgetCategoriesTiles() {

	jQuery( '.tm-categories-tiles-form-widget select, .tm-categories-tiles-form-widget input[type=text]' ).change( function() {
		jQuery( document ).trigger( 'widget-change' );
	});

	// Upload image
	jQuery( '.tm-categories-tiles-form-widget div.upload-image img' ).click( function( e ) {
		var _this = jQuery( this );
		var inputImage = _this.parents( '.category-area' ).find( '.custom-image-url' );
		var inputAvatar = _this.parents( '.category-area' ).find( '.upload-image img' );
		var customUploader = wp.media( {
			title: 'Upload a Image',
			button: {
				text: 'Select'
			},
			multiple: false
		} );

		customUploader.on( 'select', function() {
			var imgurl = '';
			var imgid = 0;
			if ( 'undefined' != typeof(customUploader.state().get( 'selection' ).first().attributes.sizes.square) ) {
				imgurl = customUploader.state().get( 'selection' ).first().attributes.sizes.square.url
				imgid = customUploader.state().get( 'selection' ).first().attributes.id;
			} else {
				imgurl = customUploader.state().get( 'selection' ).first().attributes.sizes.full.url
				imgid = customUploader.state().get( 'selection' ).first().attributes.id;
			}
			inputImage.val( imgid ).trigger( 'change' );
			inputAvatar.attr( 'src', imgurl );
		});
		customUploader.open();
		e.preventDefault();
	});

	// Delete image
	jQuery( '.tm-categories-tiles-form-widget .upload-image .delete-image-url' ).click( function() {
		var _this = jQuery( this );
		var inputImage = _this.parents( '.category-area' ).find( '.custom-image-url' );
		var inputAvatar = _this.parents( '.category-area' ).find( '.upload-image img' );
		var defaultAvatar = inputAvatar.attr( 'default_image' );
		inputAvatar.attr( 'src', defaultAvatar );
		inputImage.val( '' ).trigger( 'change' );
		return false;
	});

	// Delete category
	jQuery( '.tm-categories-tiles-form-widget .category-area .delete-category' ).click( function() {
		var _this = jQuery( this );
		var category = _this.parents( '.category-area' );
		var categories = _this.parents( '.tm-categories-tiles-form-widget' ).find( '.categories' );
		var categoriesCount = parseInt( categories.attr( 'count' ), 10 ) - 1;
		categories.attr( 'count', categoriesCount );
		category.find( 'input' ).trigger( 'change' );
		category.remove();
		reNumberCategoriesTiles( categories );
		reInitWidgetCategoriesTiles();
	});

	// Add category
	jQuery( '.tm-categories-tiles-form-widget .categories .add-category' ).click( function() {
		var _this = jQuery( this );
		var categories = _this.parents( '.tm-categories-tiles-form-widget' ).find( '.categories' );
		var categoriesCount = parseInt( categories.attr( 'count' ), 10 ) + 1;
		var category = _this.parents( '.tm-categories-tiles-form-widget' ).find( '.category-new' );
		var categoryNew = category.clone();
		var inputImage = categoryNew.find( '.custom-image-url' );
		var inputAvatar = categoryNew.find( '.upload-image img' );
		var defaultAvatar = inputAvatar.attr( 'default_image' );
		var selectCategory = categoryNew.find( 'select' );
		category.before( categoryNew );
		inputAvatar.attr( 'src', defaultAvatar );
		selectCategory.val( '1' );
		inputImage.val( '' );
		categories.attr( 'count', categoriesCount );
		categoryNew.toggleClass( 'category-area category-new' );
		categoryNew.find( 'input' ).each( function() {
			var _inputItem = jQuery( this );
			var name = _inputItem.attr( 'name' );
			name = name.replace( '_new', '' );
			_inputItem.attr( 'name', name );
		});

		categoryNew.find( 'select' ).each( function() {
			var _inputItem = jQuery( this );
			var name = _inputItem.attr( 'name' );
			name = name.replace( '_new', '' );
			_inputItem.attr( 'name', name );
		});

		categoryNew.find( 'h3 span' ).html( categoriesCount );
		categoryNew.find( 'input' ).trigger( 'change' );
		jQuery( document ).trigger( 'widget-change' );
		reNumberCategoriesTiles( categories );
		reInitWidgetCategoriesTiles();
	});
}
