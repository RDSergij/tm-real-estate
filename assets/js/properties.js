jQuery( document ).ready( function( $ ) {

	var pageAddProperty = function() {

		var pap = this;

		pap.init = function() {
			pap.papFunction();
		};

		pap.papFunction = function() {
			jQuery( '.post-type-property .selectit, .check-column' ).each(function(){
				var span = jQuery(this).find('span');
				if ( !span[0] ) {
					jQuery(this).find('input[type="checkbox"]').after('<span></span>');
				}
			});
		};
	};

	var pap = new pageAddProperty();
	pap.init();

	jQuery( document ).ajaxComplete(pap.init);
} );
