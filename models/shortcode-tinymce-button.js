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
                    if(TMPageSettings.shortcodes_views[TMPageSettings.shortcodes[i]]) {
                        shortcodeView = TMPageSettings.shortcodes_views['tm-re-properties'];
                        editor.windowManager.open({
                            id: TMPageSettings.shortcodes[i],
                            title: shortcodeView['title'],
                            image: shortcodeView['image'],
                            body: shortcodeView['body'],
                            width: shortcodeView['width'],
                            height: shortcodeView['height'],
                            buttons: [{
                                text: 'Submit',
                                onclick: 'submit'
                             },{
                                text: 'Cancel',
                                onclick: 'close'
                             }],
                            onsubmit: function(e) {
                                attr = e.data
                                shortcode = '[' + TMPageSettings.shortcodes[i];
                                for (var prop in attr) {
                                    console.log("obj." + prop + " = " + attr[prop]);
                                    if ( attr[prop] ) {
                                        shortcode += ' ' + prop +'="'+ attr[prop] + '"';
                                    }
                                }
                                shortcode += ']';
                                 console.log(shortcode);
                                tinyMCE.activeEditor.selection.setContent( shortcode );
                                
                             }
                        });
                   } else {
                        tinyMCE.activeEditor.selection.setContent( '[' + TMPageSettings.shortcodes[i] + ']' );
                   }


                },

            });
        });
        
    });
})();