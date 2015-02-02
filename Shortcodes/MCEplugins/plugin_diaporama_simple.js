(function() {
	tinymce.create('tinymce.plugins.Diaposimple', {
		init : function(ed, url) {
			ed.addButton('diaposimple', {
				title : 'Diaporama avec une seule image',
				image : url+'/../../../custom/img/diapo_image.png',
				onclick : function() {
                                    
                                    var shortcode = "[diaporama]<br />";
                                        shortcode += "[slide]<br />";
                                        shortcode += "[content]<br />";
                                        shortcode += "texte sur l'image<br />";
                                        shortcode += "[/content]<br />";
                                        shortcode += "insérer l'image<br />";
                                        shortcode += "[/slide]<br />";
                                        shortcode += "[/diaporama]";
                                        
                                        
					ed.execCommand('mceInsertContent', false, shortcode);
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('diaposimple', tinymce.plugins.Diaposimple);
})();