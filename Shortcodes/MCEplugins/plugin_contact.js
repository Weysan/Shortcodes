(function() {
	tinymce.create('tinymce.plugins.Contact', {
		init : function(ed, url) {
			ed.addButton('contact', {
				title : 'Contact Form',
				image : url+'/../../../custom/img/picto_contact.png',
				onclick : function() {
                                    var subject = prompt('Le sujet du mail ?');
                                    var destinataire = prompt('Le destinataire du mail ?');
                                    
					ed.execCommand('mceInsertContent', false, '[contact to=\''+destinataire+'\' subject=\''+subject+'\']');
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('contact', tinymce.plugins.Contact);
})();