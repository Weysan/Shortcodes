(function() {
    console.log('là');
	tinymce.create('tinymce.plugins.Diaposimplenoir', {
		init : function(ed, url) {
			ed.addButton('diaposimplenoir', {
				title : 'Diaporama avec une seule image et fond noir',
				image : url+'/../../../custom/img/diapo_image_inv.png',
				onclick : function() {
                                    
                                    var shortcode = "[diaporama titre='title' texte='Your text']<br />";
                                        shortcode += "[slide]<br />";
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
	tinymce.PluginManager.add('diaposimplenoir', tinymce.plugins.Diaposimplenoir);
})();