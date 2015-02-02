(function() {
	tinymce.create('tinymce.plugins.Article', {
		init : function(ed, url) {
			ed.addButton('article', {
				title : 'Article',
				image : url+'/../../../custom/img/article.png',
				onclick : function() {
					ed.execCommand('mceInsertContent', false, '[article]Content[/article]');
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		}
	});
	tinymce.PluginManager.add('article', tinymce.plugins.Article);
})();