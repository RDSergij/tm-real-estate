if ( jQuery( '#customize-control-blog_settings_layout select' ).val() != 'default' ) {
	jQuery('#customize-control-blog_settings_columns').show();
} else {
	jQuery('#customize-control-blog_settings_columns').hide();
}

jQuery(document).on(
	'change',
	'#customize-control-blog_settings_layout select',
	function(){
		if ( jQuery(this).val() != 'default' ) {
			jQuery('#customize-control-blog_settings_columns').show();
		} else {
			jQuery('#customize-control-blog_settings_columns').hide();
		}
	}
);
