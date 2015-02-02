(function() {
	tinymce.create('tinymce.plugins.Figure', {
		init : function(ed, url) {
			ed.addButton('figure', {
				title : 'Figure',
				image : url+'/../../../custom/img/figure.png',
				onclick : function() {
                                    var shortcode = "[figure]<br />\n";
                                        shortcode += "Image <br />\n";
                                        shortcode += "[legend]\n";
                                        shortcode += "<h3>Title</h3>\n";
                                        shortcode += "Content<br />\n";
                                        shortcode += "[/legend]<br />\n";
                                        shortcode += "[/figure]\n";
                                        
                                        
					ed.execCommand('mceInsertContent', false, shortcode);
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('figure', tinymce.plugins.Figure);
})();