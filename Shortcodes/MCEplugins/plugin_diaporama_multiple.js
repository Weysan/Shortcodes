(function() {
	tinymce.create('tinymce.plugins.Diapomultiple', {
		init : function(ed, url) {
			ed.addButton('diapomultiple', {
				title : 'Diaporama avec plusieurs images',
				image : url+'/../../../custom/img/diapo_images.png',
				onclick : function() {
                                    
                                    var titreDiapo = prompt('Quel est le titre du diaporama ?');
                                    var nbSlide = prompt('Combien d\'images ?');
                                    
                                    while(nbSlide % 1 !== 0){
                                        nbSlide = prompt('Combien d\'images ?');
                                    }
                                    
                                    var shortcode = "[diaporama titre='"+titreDiapo+"']<br />";
                                    
                                    for(var n=1; n <= nbSlide; n++){
                                        shortcode += "[slide]<br />";
                                        shortcode += "insérer l'image<br />";
                                        shortcode += "[/slide]<br />";
                                    }
                                        shortcode += "[/diaporama]";
                                        
                                        
					ed.execCommand('mceInsertContent', false, shortcode);
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('diapomultiple', tinymce.plugins.Diapomultiple);
})();