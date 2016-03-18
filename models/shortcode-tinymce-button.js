/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function() {

    tinymce.PluginManager.add('pushortcodes', function( editor )
    {
        var shortcodeValues = [];
        jQuery.each(shortcodes_button, function(i)
        {
            shortcodeValues.push({text: shortcodes_button[i], value:i});
        });
        editor.addButton('pushortcodes', {
            type: 'listbox',
            text: 'Shortcodes',
            onselect: function(e) {
                var v = e.control.value()

                tinyMCE.activeEditor.selection.setContent( '[' + v + '][/' + v + ']' );
            },
            values: shortcodeValues
        });
    });
})();