/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function() {
    var shortcodeView;
    tinymce.PluginManager.add('tm_shortcodes', function (editor) {
        jQuery.each(TMPageSettings.shortcodes, function (i) {
            editor.addButton(TMPageSettings.shortcodes[i], {
                text: TMPageSettings.shortcodes[i],
                image: (typeof shortcodeView !== 'undefined') ? shortcodeView['image'] : '',
                onclick: function ( e ) {
					shortcodeView = TMPageSettings.shortcodes_views[TMPageSettings.shortcodes[i]];
					console.log( shortcodeView, TMPageSettings.shortcodes[i] );
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
                                attr = e.data
                                shortcode = '[' + TMPageSettings.shortcodes[i];
                                for (var prop in attr) {
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
                     jQuery('[type="number"]').attr('min', '0');
                },
            });
        });
    });

})();