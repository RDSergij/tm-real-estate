jQuery( document ).ready( function( $ ) {

	var pageAddProperty = function() {

		var pap = this;

		pap.init = function() {
			pap.papFunction();
		};

		pap.papFunction = function() {
			jQuery( '.post-type-property .selectit' ).each(function(){
				jQuery(this).find('input').after('<span></span>');
			});
		};
	};

	var pap = new pageAddProperty();
	pap.init();
} );
