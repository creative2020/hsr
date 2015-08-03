(function() {
    tinymce.create('tinymce.plugins.Premiumpress', {



        init : function(ed, url) {
   
        },



        createControl : function(n, cm) {
	 
             if(n == 'premiumpress'){

				var mlb = cm.createListBox('PremiumPressShortcodes', {
                     title : 'Shortcodes',
                     onselect : function(v) { //Option value as parameter
                         //if(tinyMCE.activeEditor.selection.getContent() != ''){
                        //     tinyMCE.activeEditor.selection.setContent('[' + v + ']' + tinyMCE.activeEditor.selection.getContent() + '[/' + v + ']');
                        //}
                       // else{
                            tinyMCE.activeEditor.selection.setContent('[' + v + ']');
                       // }
                     }
                });
 
                // Add some values to the list box
                mlb.add('LISTINGS', 'LISTINGS query="" show="3" cat="" orderby="post_title" order="desc" grid="yes" featuredonly="no"');
      			 
				mlb.add('ADVANCEDSEARCH', 'ADVANCEDSEARCH');
				mlb.add('MEMBERS', 'MEMBERS show="5" showuid="" hideuid=""');
 				mlb.add('TAXONOMY', 'TAXONOMY name="store" count="yes" icon="yes" perrow="3"');
				mlb.add('CATEGORIES', 'CATEGORIES show="" hide="" count="yes"'); 
				
                // Return the new listbox instance
                return mlb;
				
			} 				 
     
            return null;  
        },
 
        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Premiumpress Buttons',
                author : 'Mark Fail',
                authorurl : 'http://www.premiumpress.com',
                infourl : 'http://www.premiumpress.com',
                version : "1.0"
            };
        }
    });
 
    // Register plugin
    tinymce.PluginManager.add( 'premiumpresseditor', tinymce.plugins.Premiumpress );
})();
 