( function( $ ) {

	FLBuilderSettingsCopyPaste = {

		init: function() {
			// window.addEventListener( 'storage', this._storageListener );
			FLBuilder.addHook( 'settings-form-init', this.initExportButton );
			FLBuilder.addHook( 'settings-form-init', this.initImportButton );
		},

		_getClipboard: function () {
			return window.localStorage.getItem('clipboard') || '';
		},

		_getClipboardType: function(e) {
			const clipboard = this._getClipboard();
			const type = clipboard.match(/{type:([_a-z0-9-]+)}/);

			if (null !== type && 'undefined' !== type[1]) {
				return type[1];
			}
			
			return '';
		},
		
		_setClipboard: function (data, win = false) {
			// set to localStorage.
			window.localStorage.setItem('clipboard', data);

			// set to clipboard.
			if (win) {
				this._copyToClipboard(data);
			}
		},

		_copyToClipboard: function (data) {
			if (0 === data.length) {
				return;
			}

			if ('undefined' === typeof navigator.clipboard) {
				// create temp el
				const tempEl = document.createElement('textarea');
	
				// hide temp el
				tempEl.style.position = 'absolute';
				tempEl.style.left = '-100%';
	
				// set content of temp el
				tempEl.value = data;
	
				// insert temp el in page
				document.body.appendChild(tempEl);
	
				// select temp el
				tempEl.select();
	
				// copy temp el content
				document.execCommand('copy');
	
				// remove temp el
				document.body.removeChild(tempEl);
			} else {
				navigator.clipboard.writeText(data);
			}
		},

		_copySettings: function (type, nodeId, win = false, filterStyle = false) {
			let settings   = {};
			let selector   = type;
			const form     = $('.fl-builder-settings[data-node=' + nodeId + ']');
			const date     = new Date().toDateString();
			const wrap     = '/// {type:' + type + '} ' + date + ' ///';

			if ('row' !== selector) {
				if ('column' === selector) {
					selector = 'col';
				} else {
					selector = 'module';
				}
			}

			if (form.length > 0) {
				// settings panel is open
				settings = FLBuilder._getSettings(form)
			} else {
				// settings panel is closed
				settings = FLBuilderSettingsConfig.nodes[nodeId];
			}

			// filter style
			if (form.length > 0 && filterStyle) {
				for (let key in settings) {
					let isStyle = false;
					const singleInput = form.find('[name="' + key + '"]');
					const arrayInput = form.find('[name*="' + key + '["]');

					if (singleInput.length) {
						isStyle = singleInput.closest('.fl-field').data('is-style');
					} else if (arrayInput.length) {
						isStyle = arrayInput.closest('.fl-field').data('is-style');
					}

					if (!isStyle) {
						delete settings[key];
					}
				}
			}

			// copy data to fl-builder clipboard
			this._setClipboard(wrap + "\n" + JSON.stringify(settings), win);

			// set body attr
			$('body').attr('data-clipboard', type);

			// remove active class
			$('.fl-quick-paste-active').removeClass('fl-quick-paste-active');

			// add active class
			$('[data-node="' + nodeId + '"]')
				.find('.fl-' + selector + '-quick-paste')
				.addClass('fl-quick-paste-active');

			return this._getClipboard();
		},

		_importSettings: function (type, nodeId, data) {
			const dataType = data.match(/{type:([_a-z0-9-]+)}/);

			if ('undefined' !== dataType[1] && type === dataType[1]) {
				try {
					const jsonData = JSON.parse(data.replace(/\/\/\/.+\/\/\//, ''));

					// remove width settings from column
					if ('column' === type) {
						if ('size' in jsonData) {
							delete jsonData.size;
						}
						if ('size_large' in jsonData) {
							delete jsonData.size_large;
						}
						if ('size_medium' in jsonData) {
							delete jsonData.size_medium;
						}
						if ('size_responsive' in jsonData) {
							delete jsonData.size_responsive;
						}
					}

					// merge copied data with existing node
					const mergedData = $.extend({}, FLBuilderSettingsConfig.nodes[nodeId], jsonData);

					// set node data
					FLBuilderSettingsConfig.nodes[nodeId] = mergedData;

					// dispatch to store
					FL.Builder.data
						.getLayoutActions()
						.updateNodeSettings(
							nodeId,
							mergedData,
							FLBuilder._saveSettingsComplete.bind(this, true)
						);

					// trigger hook
					FLBuilder.triggerHook('didSaveNodeSettings', {
						nodeId: nodeId,
						settings: mergedData
					});

					// close panel
					FLBuilder._lightbox.close();

					return true;
				} catch {
					return false;
				}
			}

			return false;
		},

		_importFromClipboard: function (type, nodeId) {
			if (0 < this._getClipboard().length) {
				return FLBuilderSettingsCopyPaste._importSettings(type, nodeId, this._getClipboard());
			}

			return false;
		},

		_importFromJSON: function (type, nodeId, data) {
			if ('undefined' !== typeof data && null !== data && 0 < data.length) {
				return FLBuilderSettingsCopyPaste._importSettings(type, nodeId, data);
			}

			return false;
		},

		_bindCopyToElement: function ($el, type, nodeId, win = false, filterStyle = false) {
			const text = $el.text();

			// copy data to clipboard
			FLBuilderSettingsCopyPaste._copySettings(type, nodeId, win, filterStyle);

			// set button text
			$el.text(FLBuilderStrings.module_import.copied);

			// restore button text
			setTimeout(() => {
				$el.text(text);
			}, 1000);
		},

		initExportButton: function() {
			// row - all
			$('button.row-export-all').on('click', function () {
				const nodeId = $('.fl-builder-row-settings').data('node');

				// bind copy to the el
				FLBuilderSettingsCopyPaste._bindCopyToElement($(this), 'row', nodeId, true);
			});

			// row - style
			$('button.row-export-style').on('click', function () {
				const nodeId = $('.fl-builder-row-settings').data('node');

				// bind copy to the el
				FLBuilderSettingsCopyPaste._bindCopyToElement($(this), 'row', nodeId, true, true);
			});

			// col - all
			$('button.col-export-all').on('click', function () {
				const nodeId = $('.fl-builder-col-settings').data('node');

				// bind copy to the el
				FLBuilderSettingsCopyPaste._bindCopyToElement($(this), 'column', nodeId, true);
			});

			// col - style
			$('button.col-export-style').on('click', function () {
				const nodeId = $('.fl-builder-col-settings').data('node');

				// bind copy to the el
				FLBuilderSettingsCopyPaste._bindCopyToElement($(this), 'column', nodeId, true, true);
			});

			// module - all
			$('button.module-export-all').on('click', function () {
				const nodeId = $('.fl-builder-module-settings').data('node');
				const type   = $('.fl-builder-module-settings').data('type');

				// bind copy to the el
				FLBuilderSettingsCopyPaste._bindCopyToElement($(this), type, nodeId, true);
			});

			// module - style
			$('button.module-export-style').on('click', function () {
				const nodeId = $('.fl-builder-module-settings').data('node');
				const type   = $('.fl-builder-module-settings').data('type');

				// bind copy to the el
				FLBuilderSettingsCopyPaste._bindCopyToElement($(this), type, nodeId, true, true);
			});
		},

		initImportButton: function() {
			// row
			$('button.row-import-apply').on('click', function () {
				const nodeId  = $('.fl-builder-row-settings').data('node');
				const data    = $('.row-import-input').val();
				const success = FLBuilderSettingsCopyPaste._importFromJSON('row', nodeId, data);

				if (!success) {
					$('.row-import-error').html(FLBuilderStrings.module_import.error).show();
				}
			});

			// col
			$('button.col-import-apply').on('click', function () {
				const nodeId  = $('.fl-builder-col-settings').data('node');
				const data    = $('.col-import-input').val();
				const success = FLBuilderSettingsCopyPaste._importFromJSON('column', nodeId, data);

				if (!success) {
					$('.col-import-error').html(FLBuilderStrings.module_import.error).show();
				}
			});

			// module
			$('button.module-import-apply').on('click', function () {
				const type    = $('.fl-builder-module-settings').data('type');
				const nodeId  = $('.fl-builder-module-settings').data('node');
				const data    = $('.module-import-input').val();
				const success = FLBuilderSettingsCopyPaste._importFromJSON(type, nodeId, data);

				if (!success) {
					$('.module-import-error').html(FLBuilderStrings.module_import.error).show();
				}
			});
		},
	};

	$( function() {
		FLBuilderSettingsCopyPaste.init();
	} );

} )( jQuery );
