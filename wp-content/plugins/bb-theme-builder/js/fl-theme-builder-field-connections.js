( function( $ ) {

	/**
	 * Handles logic for field connections.
	 *
	 * @class FLThemeBuilderFieldConnections
	 * @since 1.0
	 */
	FLThemeBuilderFieldConnections = {

		/**
		 * Cached data for field connection menus.
		 *
		 * @since 1.0
		 * @access private
		 * @property {Object} _menus
		 */
		_menus : {},

		/**
		 * Initializes field connections.
		 *
		 * @since 1.0
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			this._bind();
		},

		/**
		 * Binds field connection events.
		 *
		 * @since 1.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			FLBuilder.addHook( 'settings-form-init', this._initSettingsForms );

			$( 'body', window.parent.document ).on( 'click', this._closeMenus );
			$( 'body', window.parent.document ).delegate( '.fl-field-connections-toggle .fas', 'click', this._menuToggleClicked );
			$( 'body', window.parent.document ).delegate( '.fl-field-connections-property', 'click', this._menuItemClicked );
			$( 'body', window.parent.document ).delegate( '.fl-field-connections-property-token', 'click', this._menuItemTokenClicked );
			$( 'body', window.parent.document ).delegate( '.fl-field-connections-search', 'keyup', this._menuSearchKeyup );
			$( 'body', window.parent.document ).delegate( '.fl-field-connection-remove', 'click', this._removeConnectionClicked );
			$( 'body', window.parent.document ).delegate( '.fl-field-connection-edit', 'click', this._editConnectionClicked );
			$( 'body', window.parent.document ).delegate( '.fl-field-connection-settings .fl-builder-settings-save', 'click', this._saveSettingsFormClicked );
			$( 'body', window.parent.document ).delegate( '.fl-field-connection-settings .fl-builder-settings-cancel', 'click', this._cancelSettingsFormClicked );
		},

		/**
		 * Callback for initializing settings forms.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initSettingsForms
		 */
		_initSettingsForms: function()
		{
			$( '.fl-field-connection-visible' ).each( function() {
				$( this ).parents( '.fl-field' ).find( 'input, textarea, select' ).addClass( 'fl-ignore-validation' );
			} );
		},

		/**
		 * Callback for when the body is clicked to close
		 * any open connections menus.
		 *
		 * @since 1.0
		 * @access private
		 * @method _closeMenus
		 * @param {Object} e The event object.
		 */
		_closeMenus: function( e )
		{
			var target;

			if ( 'undefined' != typeof e ) {

				target = $( e.target );

				if ( target.closest( '.fl-field-connections-toggle' ).length ) {
					return;
				}
				if ( target.closest( '.fl-field-connections-menu' ).length ) {
					return;
				}
			}

			$( '.fl-field-connections-menu' ).remove();
			$( '.fl-field-connections-toggle-open' ).removeClass( 'fl-field-connections-toggle-open' );
		},

		/**
		 * Callback for when the menu toggle is clicked to
		 * show or hide a connections menu.
		 *
		 * @since 1.0
		 * @access private
		 * @method _menuToggleClicked
		 * @param {Object} e The event object.
		 */
		_menuToggleClicked: function( e )
		{
			var target     = $( this ),
				field      = target.parents( '.fl-field' ),
				fieldId    = field.attr( 'id' ),
				control    = target.parents( '.fl-field-control' ),
				wrapper    = target.parents( '.fl-field-control-wrapper' ),
				toggle     = target.closest( '.fl-field-connections-toggle' ),
				isOpen     = toggle.hasClass( 'fl-field-connections-toggle-open' ),
				connection = control.find( '.fl-field-connection' ),
				menu       = $( '.fl-field-connections-menu[data-field="' + fieldId + '"]' ),
				template   = wp.template( 'fl-field-connections-menu' ),
				menuData   = FLThemeBuilderFieldConnections._menus[ fieldId.replace( 'fl-field-', '' ) ],
				groups     = menu.find( '.fl-field-connections-groups' ),
				search     = menu.find( '.fl-field-connections-search' );

			FLThemeBuilderFieldConnections._closeMenus();

			if ( ! isOpen ) {

				toggle.addClass( 'fl-field-connections-toggle-open' );

				if ( ! menu.length ) {

					$( 'body', window.parent.document ).append( template( {
						fieldId   : fieldId,
						fieldType : field.attr( 'data-type' ),
						menuData  : menuData
					} ) );

					menu   = $( '.fl-field-connections-menu[data-field="' + fieldId + '"]' );
					groups = menu.find( '.fl-field-connections-groups' );
					search = menu.find( '.fl-field-connections-search' );
				}

				new Tether( {
					element          : menu[0],
					target           : wrapper[0],
					attachment       : 'top left',
					targetAttachment : 'top left',
					constraints: [ {
						to  : wrapper[0],
						attachment: 'together',
						pin: ['top']
				    } ]
				} );

				menu.css( 'width', wrapper.width() );
				menu.fadeIn( 200 );

				if ( connection.is( ':visible' ) ) {
					menu.removeClass( 'fl-field-connection-tokens-visible' );
				} else {
					menu.addClass( 'fl-field-connection-tokens-visible' );
				}

				if ( groups.height() > menu.height() ) {
					search.show();
				}
			}
		},

		/**
		 * Callback for when a connection menu item is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _menuItemClicked
		 * @param {Object} e The event object.
		 */
		_menuItemClicked: function( e )
		{
			var item       = $( e.target ).closest( '.fl-field-connections-property' ),
				menu       = item.closest( '.fl-field-connections-menu' ),
				fieldId    = menu.attr( 'data-field' ),
				field      = $( '#' + fieldId ),
				connection = field.find( '.fl-field-connection' ),
				label      = connection.find( '.fl-field-connection-label' ),
				value      = field.find( '.fl-field-connection-value' ),
				formId     = item.attr( 'data-form' ),
				config     = {
					object   : item.attr( 'data-object' ),
					property : item.attr( 'data-property' ),
					field    : field.attr( 'data-type' ),
					settings : null
			};

			field.find( 'input, textarea, select' ).addClass( 'fl-ignore-validation' );
			value.val( JSON.stringify( config ) );
			label.html( item.find( '.fl-field-connections-property-label' ).text() );
			connection.fadeIn( 200 ).addClass( 'fl-field-connection-visible' );

			FLThemeBuilderFieldConnections._closeMenus();

			if ( 'undefined' == typeof formId ) {
				connection.removeAttr( 'data-form' );
				FLThemeBuilderFieldConnections._triggerPreview( { target : field } );
			} else {
				connection.attr( 'data-form', formId );
				connection.addClass( 'fl-field-connection-clear-on-cancel' );
				FLThemeBuilderFieldConnections._showSettingsForm( field, formId, config );
			}
		},

		/**
		 * Callback for when a connection menu item token is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _menuItemTokenClicked
		 * @param {Object} e The event object.
		 */
		_menuItemTokenClicked: function( e )
		{
			var target     = $( e.target ),
				menu       = target.closest( '.fl-field-connections-menu' ),
				fieldId    = menu.attr( 'data-field' ),
				field      = $( '#' + fieldId ),
				connection = field.find( '.fl-field-connection' ),
				item       = target.closest( '.fl-field-connections-property' ),
				formId     = item.attr( 'data-form' ),
				token      = target.closest( '.fl-field-connections-property-token' ).attr( 'data-token' );

			if ( 'undefined' == typeof formId ) {
				token = '[wpbb ' + token + ']';
				FLThemeBuilderFieldConnections._insertMenuItemToken( field, token );
			} else {

				connection.attr( 'data-token', token );

				FLThemeBuilderFieldConnections._showSettingsForm( field, formId, {
					object   : token.split( ':' )[0],
					property : token.split( ':' )[1],
					field    : field.attr( 'data-type' ),
					settings : null
				} );
			}

			FLThemeBuilderFieldConnections._closeMenus();
			e.stopPropagation();
		},

		/**
		 * Inserts a menu item token for a field.
		 *
		 * @since 1.0
		 * @access private
		 * @method _insertMenuItemToken
		 * @param {Object} field
		 * @param {String} token
		 */
		_insertMenuItemToken: function( field, token )
		{
			var type    = field.attr( 'data-type' ),
				input   = null,
				value   = null;

			if ( 'text' == type || 'textarea' == type || ( 'editor' == type && field.find( '.html-active' ).length > 0 ) ) {

				if ( 'text' == type ) {
					input = field.find( 'input[type=text]' );
				} else if ( 'textarea' == type || 'editor' == type ) {
					input = field.find( 'textarea' );
				}

				value = input.val();

				if ( input[0].selectionStart || 0 === input[0].selectionStart ) {
					input.val( value.substring( 0, input[0].selectionStart ) + token + value.substring( input[0].selectionStart ) );
				} else {
					input.val( value + ' ' + token );
				}

				input.trigger( 'keyup' );
			} else if ( 'editor' == type ) {
				window.parent.send_to_editor( token );
			} else if ( 'code' == type ) {
				field.data( 'editor' ).insert( token );
			}
		},

		/**
		 * Callback for when a key is pressed for the
		 * connections menu search.
		 *
		 * @since 1.0
		 * @access private
		 * @method _menuSearchKeyup
		 * @param {Object} e The event object.
		 */
		_menuSearchKeyup: function( e )
		{
			var input = $( e.target ),
				value = input.val().toLowerCase(),
				menu  = input.closest( '.fl-field-connections-menu' );

			menu.find( '.fl-field-connections-group' ).each( function() {

				var group = $( this ),
					label = group.find( '.fl-field-connections-group-label' ),
					props = group.find( '.fl-field-connections-property' );

				if ( label.text().toLowerCase().indexOf( value ) > -1 ) {
					props.attr( 'data-hidden', 0 );
					props.show();
					group.show();
				} else {
					props.each( function() {

						var prop  = $( this ),
							label = prop.find( '.fl-field-connections-property-label' );

						if ( label.text().toLowerCase().indexOf( value ) > -1 ) {
							prop.attr( 'data-hidden', 0 );
							prop.show();
						} else {
							prop.attr( 'data-hidden', 1 );
							prop.hide();
						}
					} );
				}

				if ( group.find( '.fl-field-connections-property[data-hidden=0]' ).length ) {
					group.show();
				} else {
					group.hide();
				}
			} );

			e.preventDefault();
			e.stopPropagation();
		},

		/**
		 * Shows a settings form for a field connection.
		 *
		 * @since 1.0
		 * @access private
		 * @method _showSettingsForm
		 * @param {Object} field The field for this connection.
		 * @param {String} formId The form config.
		 * @param {Object} config The form config.
		 */
		_showSettingsForm: function( field, formId, config )
		{
			formId = undefined === formId ? field.find( '.fl-field-connection' ).attr( 'data-form' ) : formId;
			config = undefined === config ? JSON.parse( field.find( '.fl-field-connection-value' ).val() ) : config;

			var lightbox = FLBuilder._openNestedSettings( {
				className : 'fl-builder-lightbox fl-field-connection-settings'
			} );

			field.addClass( 'fl-field-connection-editing' );

			FLBuilder.ajax( {
				action   : 'render_connection_settings',
				object   : config.object,
				property : config.property,
				type     : formId,
				settings : config.settings
				}, function( response ) {

					var data = JSON.parse( response );

					lightbox._node.find( '.fl-lightbox-content' ).html( data.html );

					FLBuilder._initSettingsForms();
					$( document ).trigger( '_initSettingsFormsComplete' );
				} );
		},

		/**
		 * Saves a connection settings form.
		 *
		 * @since 1.0
		 * @access private
		 * @method _saveSettingsFormClicked
		 * @param {Object} e
		 */
		_saveSettingsFormClicked: function( e )
		{
			var form       = $( '.fl-field-connection-settings form' ),
				settings   = FLBuilder._getSettings( form ),
				field      = $( '.fl-field-connection-editing' ),
				connection = field.find( '.fl-field-connection' ),
				value      = field.find( '.fl-field-connection-value' ),
				val        = value.val(),
				parsed     = null,
				shortcode  = '',
				token      = connection.attr( 'data-token' ),
				prop       = null;

			if ( '' != val ) {
				parsed          = JSON.parse( val );
				parsed.settings = FLThemeBuilderFieldConnections._fixDependency( settings );
				value.val( JSON.stringify( parsed ) );
				FLThemeBuilderFieldConnections._triggerPreview( { target : field } );
			} else {
				shortcode = '[wpbb ' + token;

				for ( prop in settings ) {
					if ( ! form.find( '[name=' + prop + ']:visible' ).length || 'name_custom' === prop ) {
						continue;
					}
					shortcode += ' ' + prop.replace( /([a-z]+)_display/, 'display' ) + "='" + settings[ prop ] + "'";
				}

				shortcode += ']';

				FLThemeBuilderFieldConnections._insertMenuItemToken( field, shortcode );
			}

			field.removeClass( 'fl-field-connection-editing' );
			connection.removeClass( 'fl-field-connection-clear-on-cancel' );
			FLBuilder._closeNestedSettings();
		},

		/**
		 * Fix dependency settings.
		 *
		 * @since TBD
		 * @access private
		 * @method _fixDependency
		 * @param {Object} settings
		 */
		_fixDependency: function( settings ) {
			if ( 'file' == settings.type ) {
				settings.display = settings.file_display;
			}

			return settings;
		},

		/**
		 * Called when the cancel button of a settings
		 * form is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _cancelSettingsFormClicked
		 * @param {Object} e
		 */
		_cancelSettingsFormClicked: function( e )
		{
			var field 	   = $( '.fl-field-connection-editing' ),
				connection = field.find( '.fl-field-connection' ),
				val   	   = field.find( '.fl-field-connection-value' ).val();

			field.removeClass( 'fl-field-connection-editing' );

			if ( connection.hasClass( 'fl-field-connection-clear-on-cancel' ) ) {
				field.find( '.fl-field-connection-remove' ).trigger( 'click' );
			}
			else if ( '' != val ) {
				FLThemeBuilderFieldConnections._triggerPreview( { target: field } );
			}
		},

		/**
		 * Callback for when the remove button for a
		 * connection is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _removeConnectionClicked
		 * @param {Object} e The event object.
		 */
		_removeConnectionClicked: function( e )
		{
			var target     = $( e.target ),
				field      = target.closest( '.fl-field' ),
				connection = target.closest( '.fl-field-connection' ),
				value      = connection.siblings( '.fl-field-connection-value' );

			field.find( '.fl-ignore-validation' ).removeClass( 'fl-ignore-validation' );
			connection.removeAttr( 'data-form' );
			connection.fadeOut( 200 ).removeClass( 'fl-field-connection-visible' );
			value.val( '' );

			FLThemeBuilderFieldConnections._triggerPreview( e );
		},

		/**
		 * Saves a connection settings form when the
		 * edit icon is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _editConnectionClicked
		 * @param {Object} e
		 */
		_editConnectionClicked: function( e )
		{
			var field = $( this ).closest( '.fl-field' );

			FLThemeBuilderFieldConnections._showSettingsForm( field );
		},

		/**
		 * Triggers the preview for a field when a field is
		 * connected or disconnected.
		 *
		 * TODO: Add live preview instead of refresh.
		 *
		 * @since 1.0
		 * @access private
		 * @method _triggerPreview
		 * @param {Object} e The event object.
		 */
		_triggerPreview: function( e )
		{
			if ( $( '.fl-form-field-settings:visible' ).length ) {
				return;
			}
			if( FLBuilder.preview ) {
				FLBuilder.preview.delayPreview( e );
			}
		}
	};

	// Initialize
	$( function() { FLThemeBuilderFieldConnections._init(); } );

} )( jQuery );
