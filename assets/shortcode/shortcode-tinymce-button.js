/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function() {

    tinymce.PluginManager.add('tm_shortcodes', function (editor) {
        jQuery.each(TMPageSettings.shortcodes, function (i) {
            if (TMPageSettings.shortcodes_views[TMPageSettings.shortcodes[i]]) {
                shortcodeView = TMPageSettings.shortcodes_views[TMPageSettings.shortcodes[i]];
            }
            editor.addButton(TMPageSettings.shortcodes[i], {
                text: TMPageSettings.shortcodes[i],
                image: (typeof shortcodeView !== 'undefined') ? shortcodeView['image'] : '',
                onclick: function (e) {
                    if (TMPageSettings.shortcodes_views[TMPageSettings.shortcodes[i]]) {
                        editor.windowManager.open({
                            id: TMPageSettings.shortcodes[i],
                            title: shortcodeView['title'],
                            body: shortcodeView['body'],
                            width: shortcodeView['width'],
                            height: shortcodeView['height'],
                            buttons: [{
                                    text: 'Submit',
                                    onclick: 'submit'
                                }, {
                                    text: 'Cancel',
                                    onclick: 'close'
                                }],
                            onsubmit: function (e) {
                                console.log( e );
                                attr = e.data
                                shortcode = '[' + TMPageSettings.shortcodes[i];
                                for (var prop in attr) {
                                    console.log("obj." + prop + " = " + attr[prop]);
                                    if (attr[prop]) {
                                        shortcode += ' ' + prop + '="' + attr[prop] + '"';
                                    }
                                }
                                shortcode += ']';
                                tinyMCE.activeEditor.selection.setContent(shortcode);

                            }
                        });
                    } else {
                        tinyMCE.activeEditor.selection.setContent('[' + TMPageSettings.shortcodes[i] + ']');
                    }
                },
            });
        });
    });

})();