(function() {
	tinymce.create('tinymce.plugins.Diapotext', {
		init : function(ed, url) {
			ed.addButton('diapotext', {
				title : 'Diaporama avec du contenu texte en dessous',
				image : url+'/../../../custom/img/diapo_texte.png',
				onclick : function() {
                                    
                                    var nbSlide = prompt('Combien de slide ?');
                                    
                                    while(nbSlide % 1 !== 0){
                                        nbSlide = prompt('Combien d\'images ?');
                                    }
                                    
                                    var shortcode = "[diaporama type='text']<br />";
                                    
                                    for(var n=1; n <= nbSlide; n++){
                                        
                                        var titreSlide = prompt('Quel est le titre de la slide ?');
                                        
                                        var contentImgSlide = prompt('Quel est le contenu sur l\'image ?');
                                        
                                        shortcode += "[slide titre='"+titreSlide+"']<br />";
                                        shortcode += "[image]<br />";
                                        shortcode += "insérer une image<br />";
                                        
                                        if(contentImgSlide && contentImgSlide != ''){
                                            shortcode += "[content]<br />";
                                            shortcode += contentImgSlide+"<br />";
                                            shortcode += "[/content]<br />"; 
                                        }
                                        
                                        shortcode += "[/image]<br />";
                                        shortcode += "[article]<br />";
                                        shortcode += "Contenu sous l'image<br />";
                                        shortcode += "[/article]<br />";
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
	tinymce.PluginManager.add('diapotext', tinymce.plugins.Diapotext);
})();