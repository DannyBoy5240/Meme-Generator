( function( $ ) {

	/**
	 * @since 2.6
	 * @class FLBuilderGlobalImportExport
	 */
	FLBuilderGlobalImportExport = {

		_settingsUploader: null,

		/**
		 * Initializes custom exports for the builder.
		 *
		 * @since 1.8
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			$('body').on( 'click', '#fl-import-export-form input.export', FLBuilderGlobalImportExport._exportClicked);
			$('body').on( 'click', '#fl-import-export-form input.import', FLBuilderGlobalImportExport._importClicked);
			$('body').on( 'click', '#fl-import-export-form input.reset', FLBuilderGlobalImportExport._resetClicked);
		},

		_exportClicked: function() {

			nonce = $('#fl-import-export-form').find('#_wpnonce').val();
			// generate data file.
			FLBuilderGlobalImportExport.ajax( {
				action: 'export_global_settings',
				_wpnonce: nonce,
			}, function ( response ) {

				switch( response.success ) {
					case false:
						break;
					case true:
						data = response.data;
						var blob = new Blob([data], { type: "application/octetstream" });

						//Check the Browser type and download the File.
						var isIE = false || !!document.documentMode;
						if (isIE) {
							 window.navigator.msSaveBlob(blob, fileName);
						} else {
							 var url = window.URL || window.webkitURL;
							 link = url.createObjectURL(blob);
							 var a = $("<a />");
							 a.attr("download", 'bb-global.txt');
							 a.attr("href", link);
							 $("body").append(a);
							 a[0].click();
							 $("body").remove(a);
						}
						break;
				}
			});
		},
		_importClicked: function() {
			if(FLBuilderGlobalImportExport._settingsUploader === null) {
				FLBuilderGlobalImportExport._settingsUploader = wp.media({
					title: 'Import Settings',
					button: { text: FLBuilderAdminImportExportConfig.select },
					library : { type : 'text/plain' },
					multiple: false
				});

				_wpPluploadSettings['defaults']['multipart_params']['fl_global_import']= 'json';

				FLBuilderGlobalImportExport._settingsUploader.on( 'select', function() {
					var selection = FLBuilderGlobalImportExport._settingsUploader.state().get('selection');
					var attachment_id = selection.map( function( attachment ) {
						attachment = attachment.toJSON();
						return attachment.id;
					}).join();

					txt = 'Are you sure you want to import settings?';

					if ( confirm( txt ) ) {
						FLBuilderGlobalImportExport._importSettings(attachment_id);
					}
				});
			}
			FLBuilderGlobalImportExport._settingsUploader.open();
		},
		_importSettings: function(attachment_id) {
			nonce = $('#fl-import-export-form').find('#_wpnonce').val();
			FLBuilderGlobalImportExport.ajax( {
				action: 'import_global_settings',
				_wpnonce: nonce,
				importid: attachment_id
			}, function ( response ) {
				switch( response.success ) {
					case false:
						alert( 'There was an error :(')
						break;
					case true:
						alert( 'Success!');
						location.reload();
						break;
				};
			});
		},
		_resetClicked: function() {
			nonce = $('#fl-import-export-form').find('#_wpnonce').val();
			txt = 'Are you sure you want to reset all settings?';
			if ( confirm(txt) ) {
				FLBuilderGlobalImportExport.ajax( {
					action: 'reset_global_settings',
					_wpnonce: nonce,
				}, function ( response ) {
					switch( response.success ) {
						case false:
							alert( 'There was an error :(')
							break;
						case true:
							alert( 'Success!');
							location.reload();
							break;
					};
				});
			}
		},
		/**
		 * Makes an AJAX request.
		 *
		 * @since 1.0
		 * @method ajax
		 * @param {Object} data An object with data to send in the request.
		 * @param {Function} callback A function to call when the request is complete.
		 */
		ajax: function(data, callback) {
			// Send the request.
			$.post(ajaxurl, data, function(response) {
				if(typeof callback !== 'undefined') {
					callback.call(this, response);
				}
			});
		},
	}
	$( FLBuilderGlobalImportExport._init );
} )( jQuery );
