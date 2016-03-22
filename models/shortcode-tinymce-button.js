/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function() {
    
//    for( var i = 0; i < TMPageSettings.shortcodes.length; i++ ) {
//        tinymce.PluginManager.add(
//        );
//    }

    tinymce.PluginManager.add('pushortcodes', function( editor )
    {

        jQuery.each(TMPageSettings.shortcodes, function(i)
        {
         console.log(TMPageSettings.shortcodes[i]);
            editor.addButton(TMPageSettings.shortcodes[i], {
                text: TMPageSettings.shortcodes[i],
                onclick: function(e) {
                    //tinyMCE.activeEditor.selection.setContent( '[' + TMPageSettings.shortcodes[i] + ']' );
                                editor.windowManager.open({
                                    id: TMPageSettings.shortcodes[i],
                                    title: 'TinyMCE site',
                                    //url: TMPageSettings.shortcodes_views[i],
                                    body: JSON.parse(TMPageSettings.shortcodes_views['tm-re-properties']),
                                    width: 800,
                                    height: 600,
                                    buttons: [{
                                        text: 'Submit',
                                        onclick: 'submit'
                                     },{
                                        text: 'Cancel',
                                        onclick: 'close'
                                     }],
                                    onsubmit: function(e) {
                                        //find the popup, get the iframe contents and find the HTML form in the iFrame
                                        form = jQuery('#' + TMPageSettings.shortcodes[i] + ' iframe').contents().find('input').val();
                                        console.log(form);
                                        //once you have the form, you can do whatever you like with the data from here
                                     }
                                });


                },

            });
        });
        
    });
})();