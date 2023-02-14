jQuery(document).ready(function() {
                 var fmakey = afm_object.nonce;
				 var fma_locale = afm_object.locale;
				 jQuery('#file_manager_advanced').elfinder(
					// 1st Arg - options
					{
						cssAutoLoad : false, // Disable CSS auto loading
					    url : afm_object.ajaxurl,  // connector URL (REQUIRED)
						customData : {action: 'fma_load_fma_ui',_fmakey: fmakey},
						defaultView : 'list',
						height: 500,
						lang : fma_locale,
                        requestType: 'post',
                        ui: afm_object.ui,
						commandsOptions: {
                                        edit : {

                                                mimes : [],

                                                editors : [{

                                                mimes : ['text/plain', 'text/html', 'text/javascript', 'text/css', 'text/x-php', 'application/x-php'],

                                                load : function(textarea) {
                                                    var mimeType = this.file.mime;
                                                    var filename = this.file.name;                                                  
                                                    editor = CodeMirror.fromTextArea(textarea, {
                                                        mode: mimeType,
                                                        indentUnit: 4,
                                                        lineNumbers: true,
                                                        lineWrapping: true,                                                        
                                                        lint: true
                                                    });
                                                    return editor;
                                                    

                                                },
                                                close : function(textarea, instance) {
                                                this.myCodeMirror = null;
                                                },

                                                save: function(textarea, editor) {
                                                    jQuery(textarea).val(editor.getValue());
                                                    }

                                                } ]
                                                },

                                }
					}		
				);
				 
				
});