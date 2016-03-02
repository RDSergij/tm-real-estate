var SidebarCreator = {
    /**
     * Get object from input
     * @param  {string} id --- li id
     * @return {object}    --- input json object
     */
    get: function( id ) {
        var val = jQuery( id + ' input' ).val();
        if ( '' === val )
        {
            return {};
        }
        return JSON.parse( val );
    },

    /**
     * Set json object to input value
     * @param  {string} id --- li id
     * @param {string} obj --- json
     */
    set: function( id, obj ) {
        if ( Object === obj.constructor )
        {
            jQuery( id + ' input' ).val( JSON.stringify( obj ) );
        }
    },

    /**
     * Add input
     * @param {string} c --- css class
     */
    addInput: function( c ) {
        jQuery( c ).append(
            SidebarCreator.template( { value: '' } )
        );
    },

    /**
     * Serialize .sidebars-input
     * $obj --- jQuery object
     * @return {array} --- all values
     */
    sertialize: function( $obj ) {
        var result = [];
        $obj.find( '.sidebars-input' ).each(
            function() {
                result.push( jQuery( this ).val() );
            }
        );
        result = _.without( result, '' );
        result = _.uniq( result );
        return result;
    },
    /**
     * Load inputs from array
     */
    load: function() {
        SidebarCreator.template = _.template( jQuery( '#custom-sidebar-input-template' ).html() );
        jQuery( '.sidebar-creator' ).each(
            function() {
                var values = SidebarCreator.get( '#' + jQuery( this ).attr( 'id' ) ),
                    i = 0;
                if ( Array === values.constructor )
                {
                    for ( i = 0; i < values.length; i++ )
                    {

                        jQuery( '.' + jQuery( this ).attr( 'id' ) + '-inputs' ).append(
                            SidebarCreator.template( { value: values[i] } )
                        );
                    }
                }
            }
        );
    },

    /**
     * Change
     */
    change: function( $obj ) {
        var json = JSON.stringify( SidebarCreator.sertialize( $obj ) );
        jQuery( $obj ).find( '.main-input' ).val( json );
        jQuery( $obj ).find( '.main-input' ).trigger( 'change' );
    }
};

jQuery( document ).ready(
    function() {
        SidebarCreator.load();
    }
);

/**
 * Add sidebar
 */
jQuery( document ).on(
    'click',
    '.add-sidebar',
    function( e ) {
        SidebarCreator.addInput( '.' + jQuery( this ).data( 'id' ) + '-inputs' );
        e.preventDefault();
    }
);

/**
 * Change sidebar input
 */
jQuery( document ).on(
    'change',
    '.sidebars-input',
    function() {
        SidebarCreator.change( jQuery( this ).parents( '.sidebar-creator' ) );
    }
);

/**
 * Click to button remove
 */
jQuery( document ).on(
    'click',
    '.custom-sidebars button.remove',
    function( e ) {
        var parent = jQuery( this ).parents( '.sidebar-creator' );
        jQuery( this ).parent().remove();
        SidebarCreator.change( parent );
        e.preventDefault();
    }
);
