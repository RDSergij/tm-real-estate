jQuery( document ).ready( function( $ ) {

	var pageSettingsCustom = function() {

		var psc = this;

		psc.init = function() {
			psc.resetSettingsToDefault();
		};

		psc.resetSettingsToDefault = function() {
			jQuery( '.cherry-settings-page .reset-default-page' ).click( function() {
				if ( ! window.confirm( window.TMPageSettings.confirmResetMessage ) ) {
					return false;
				}
				$.ajax({
					type: 'POST',
					url: window.TMPageSettings.ajaxurl,
					data: { 'action': 'tm_property_settings_reset' },
					success: psc.setFormsValues,
					dataType: 'json'
				});
			});
		};

		psc.gen_page_list = function( pagesList ) {
			var options = '';
			var id;
			for ( id in pagesList ) {
				options = options + '<option value="' + id + '">' + pagesList[ id ] + '</options>';
			}
			return options;
		};

		psc.set_page_list = function( pagesList ) {
			jQuery( 'form#form-tm-properties-main-settings select' ).each( function() {
				var select = $( this );
				var id = select.attr( 'id' );
				var options = psc.gen_page_list( pagesList );
				if ( id.indexOf( '-page' ) >= 0 ) {
					select.html( options );
				}
			});
		};

		psc.setFormsValues = function( data ) {
			var temp			= [];
			var id;
			var key;
			var pagesList		= data.pagesList;
			var defaultOptions	= data.defaultOptions;
			psc.set_page_list( pagesList );
			for ( key in defaultOptions ) {
				temp = defaultOptions[ key ];
				for ( id in temp ) {
					jQuery( '#form-' + key + ' #' + id ).val( temp[ id ] );
				}
			}
			psc.noticeCreate( 'info', window.TMPageSettings.resetMessage );
		};

		psc.noticeCreate = function( type, message ) {
			var
				notice = $( '<div class="notice-box ' + type + '-notice"><span class="dashicons"></span><div class="inner">' + message + '</div></div>' ),
				rightDelta = 0,
				timeoutId;

			jQuery( 'body' ).prepend( notice );
			reposition();
			rightDelta = -1 * ( notice.outerWidth( true ) + 10 );
			notice.css( { 'right': rightDelta } );

			timeoutId = setTimeout( function() {
				notice.css( { 'right': 10 } ).addClass( 'show-state' );
			}, 100 );
			timeoutId = setTimeout( function() {
				rightDelta = -1 * ( notice.outerWidth( true ) + 10 );
				notice.css( { right: rightDelta } ).removeClass( 'show-state' );
			}, 4000 );
			timeoutId = setTimeout( function() {
				notice.remove();
				clearTimeout( timeoutId );
			}, 4500 );

			function reposition() {
				var
					topDelta = 100;
				$( '.notice-box' ).each(function() {
					$( this ).css( { top: topDelta } );
					topDelta += $( this ).outerHeight( true );
				});
			}
		};
	};

	var psc = new pageSettingsCustom();
	psc.init();
} );
