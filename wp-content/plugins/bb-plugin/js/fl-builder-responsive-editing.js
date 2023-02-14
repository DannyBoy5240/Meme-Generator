( function( $ ) {

	/**
	 * Helper for handling responsive editing logic.
	 *
	 * @since 1.9
	 * @class FLBuilderResponsiveEditing
	 */
	FLBuilderResponsiveEditing = {

		/**
		 * The current editing mode we're in.
		 *
		 * @since 1.9
		 * @private
		 * @property {String} _mode
		 */
		_mode: 'default',

		/**
		 * Refreshes the media queries for the responsive preview
		 * if necessary.
		 *
		 * @since 1.9
		 * @method refreshPreview
		 * @param {Function} callback
		 */
		refreshPreview: function( callback )
		{
			var width;

			if ( $( '.fl-responsive-preview' ).length && 'default' !== this._mode ) {

				if ( 'responsive' == this._mode ) {
					width = FLBuilderConfig.global.responsive_breakpoint >= 320 ? 320 : FLBuilderConfig.global.responsive_breakpoint;
					FLBuilderSimulateMediaQuery.update( width, callback );
				}
				else if ( 'medium' == this._mode ) {
					width = FLBuilderConfig.global.medium_breakpoint >= 769 ? 769 : FLBuilderConfig.global.medium_breakpoint;
					FLBuilderSimulateMediaQuery.update( width, callback );
				}
				else if ( 'large' == this._mode ) {
					width = FLBuilderConfig.global.large_breakpoint >= 1200 ? 1200 : FLBuilderConfig.global.large_breakpoint;
					FLBuilderSimulateMediaQuery.update( width, callback );
				}

				FLBuilder._resizeLayout();

			} else if ( callback ) {
				callback();
			}
		},

		/**
		 * Initializes responsive editing.
		 *
		 * @since 1.9
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			this._bind();
			this._initMediaQueries();
		},

		/**
		 * Bind events.
		 *
		 * @since 1.9
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			FLBuilder.addHook( 'endEditingSession', this._clearPreview );
			FLBuilder.addHook( 'didEnterRevisionPreview', this._clearPreview );
			FLBuilder.addHook( 'responsiveEditing', this._menuToggleClicked );
			FLBuilder.addHook( 'preview-init', this._switchAllSettingsToCurrentMode );
			FLBuilder.addHook( 'responsive-editing-switched', this._showSize );

			$( 'body' ).on( 'click', '.fl-field-responsive-toggle', this._settingToggleClicked );
			$( 'body' ).on( 'click', '.fl-responsive-preview-message button', this._previewToggleClicked );
		},

		/**
		 * Initializes faux media queries.
		 *
		 * @since 1.10
		 * @access private
		 * @method _initMediaQueries
		 */
		_initMediaQueries: function()
		{
			// Don't simulate media queries for stylesheets that match these paths.
			FLBuilderSimulateMediaQuery.ignore(
				[
					FLBuilderConfig.pluginUrl,
					FLBuilderConfig.relativePluginUrl
				]
			);

			var ignorelist = $.map( FLBuilderConfig.responsiveIgnore, function( value, index ) {
				return [ value ];
			} );

			FLBuilderSimulateMediaQuery.ignore( ignorelist );

			// Reparse stylesheets that match these paths on each update.
			FLBuilderSimulateMediaQuery.reparse( [
				FLBuilderConfig.postId + '-layout-draft.css',
				FLBuilderConfig.postId + '-layout-draft-partial.css',
				FLBuilderConfig.postId + '-layout-preview.css',
				FLBuilderConfig.postId + '-layout-preview-partial.css',
				FLBuilderConfig.postId + '-inline-css',
				'fl-builder-global-css',
				'fl-builder-layout-css'
			] );
		},

		_showSize: function() {
				var show_size = $('.fl-responsive-preview-message .size' ),
				large = ( '1' === FLBuilderConfig.global.responsive_preview ) ? FLBuilderConfig.global.large_breakpoint : 1200,
				medium = ( '1' === FLBuilderConfig.global.responsive_preview ) ? FLBuilderConfig.global.medium_breakpoint : 769,
				responsive = ( '1' === FLBuilderConfig.global.responsive_preview ) ? FLBuilderConfig.global.responsive_breakpoint : 360,
				size_text = '';

			if ( $('.fl-responsive-preview').hasClass('fl-preview-responsive') ) {
				size_text = FLBuilderStrings.mobile + ' ' + responsive + 'px';
			} else if ( $('.fl-responsive-preview').hasClass('fl-preview-medium') ) {
				size_text = FLBuilderStrings.medium + ' ' + medium + 'px';
			} else if ( $('.fl-responsive-preview').hasClass('fl-preview-large') ) {
				size_text = FLBuilderStrings.large + ' ' + large + 'px';
			}

			show_size.html('').html(size_text)
		},

		/**
		 * Switches to either mobile, tablet or desktop editing.
		 *
		 * @since 1.9
		 * @access private
		 * @method _switchTo
		 */
		_switchTo: function( mode, callback )
		{
			var html		= $( 'html' ),
				body        = $( 'body' ),
				content     = $( FLBuilder._contentClass ),
				preview     = $( '.fl-responsive-preview' ),
				mask        = $( '.fl-responsive-preview-mask' ),
				placeholder = $( '.fl-content-placeholder' ),
				width       = null;

			// Save the new mode.
			FLBuilderResponsiveEditing._mode = mode;

			// Setup the preview.
			if ( 'default' == mode ) {

				if ( 0 === placeholder.length ) {
					return;
				}

				html.removeClass( 'fl-responsive-preview-enabled' );
				placeholder.after( content );
				placeholder.remove();
				preview.remove();
				mask.remove();
			}
			else if ( 0 === preview.length ) {
				html.addClass( 'fl-responsive-preview-enabled' );
				content.after( '<div class="fl-content-placeholder"></div>' );
				body.prepend( wp.template( 'fl-responsive-preview' )() );
				$( '.fl-responsive-preview' ).addClass( 'fl-preview-' + mode );
				$( '.fl-responsive-preview-content' ).append( content );
			}
			else {
				preview.removeClass( 'fl-preview-responsive fl-preview-medium' );
				preview.addClass( 'fl-preview-' + mode  );
			}

			// Set the content width and apply media queries.
			if ( 'responsive' == mode ) {
				width = ( '1' !== FLBuilderConfig.global.responsive_preview && FLBuilderConfig.global.responsive_breakpoint >= 360 ) ? 360 : FLBuilderConfig.global.responsive_breakpoint;
				content.width( width );
				FLBuilderSimulateMediaQuery.update( width, callback );
				FLBuilderResponsiveEditing._setMarginPaddingPlaceholders();
			}
			else if ( 'medium' == mode ) {
				width = ( '1' !== FLBuilderConfig.global.responsive_preview && FLBuilderConfig.global.medium_breakpoint >= 769 ) ? 769 : FLBuilderConfig.global.medium_breakpoint;
				content.width( width );
				FLBuilderSimulateMediaQuery.update( width, callback );
				FLBuilderResponsiveEditing._setMarginPaddingPlaceholders();
			}
			else if ( 'large' == mode ) {
				width = ( '1' !== FLBuilderConfig.global.responsive_preview && FLBuilderConfig.global.large_breakpoint >= 1200 ) ? 1200 : FLBuilderConfig.global.large_breakpoint;
				content.width( width );
				FLBuilderSimulateMediaQuery.update( width, callback );
				FLBuilderResponsiveEditing._setMarginPaddingPlaceholders();
			}
			else {
				content.width( '' );
				FLBuilderSimulateMediaQuery.update( null, callback );
			}

			// Set the content background color.
			this._setContentBackgroundColor();

			// Resize the layout.
			FLBuilder._resizeLayout();

			// Preview all responsive settings.
			this._previewFields();

			// Broadcast the switch.
			FLBuilder.triggerHook( 'responsive-editing-switched', mode );
		},

		/**
		 * Sets the background color for the builder content
		 * in a responsive preview.
		 *
		 * @since 1.9
		 * @access private
		 * @method _setContentBackgroundColor
		 */
		_setContentBackgroundColor: function()
		{
			var content     = $( FLBuilder._contentClass ),
				preview     = $( '.fl-responsive-preview' ),
				placeholder = $( '.fl-content-placeholder' ),
				parents     = placeholder.parents(),
				parent      = null,
				color       = '#fff',
				i           = 0;

			if ( 0 === preview.length ) {
				content.css( 'background-color', '' );
			}
			else {

				for( ; i < parents.length; i++ ) {

					color = parents.eq( i ).css( 'background-color' );

					if ( color != 'rgba(0, 0, 0, 0)' ) {
						break;
					}
				}

				content.css( 'background-color', color );
			}
		},

		/**
		 * Switches to the given mode and scrolls to an
		 * active node if one is present.
		 *
		 * @since 1.9
		 * @access private
		 * @method _switchToAndScroll
		 */
		_switchToAndScroll: function( mode )
		{
			var nodeId  = $( '.fl-builder-settings' ).data( 'node' ),
				element = undefined === nodeId ? undefined : $( '.fl-node-' + nodeId );

			FLBuilderResponsiveEditing._switchTo( mode, function() {

				if ( undefined !== element && element ) {

						var win     = $( window ),
							content = $( '.fl-responsive-preview-content' );

						if ( content.length ) {
							content.scrollTop( 0 );
							content.scrollTop( element.offset().top - 150 );
						} else {
							$( 'html, body' ).scrollTop( element.offset().top - 100 );
						}
				}

				$('.fl-row-bg-parallax').each(function(){
					var row = $(this),
						content = row.find('> .fl-row-content-wrap'),
						rowImages = {
							'default': row.data('parallax-image'),
							'medium': row.data('parallax-image-medium'),
							'responsive': row.data('parallax-image-responsive'),
						};

					if ( undefined !== rowImages[mode] ) {
						content.css('background-image', 'url(' + rowImages[mode] + ')');
					}

				});

			} );
		},

		/**
		 * Switches all responsive settings in a settings form
		 * to the given mode.
		 *
		 * @since 1.9
		 * @access private
		 * @method _switchAllSettingsTo
		 * @param {String} mode
		 */
		_switchAllSettingsTo: function( mode )
		{
			var className = 'dashicons-desktop dashicons-laptop dashicons-tablet dashicons-smartphone';

			$( '.fl-field-responsive-toggle' ).removeClass( className );
			$( '.fl-field-responsive-setting' ).hide();

			if ( 'default' == mode ) {
				className = 'dashicons-desktop';
			}
			else if ( 'large' == mode ) {
				className = 'dashicons-laptop';
			}
			else if ( 'medium' == mode ) {
				className = 'dashicons-tablet';
			}
			else {
				className = 'dashicons-smartphone';
			}

			$( '.fl-field-responsive-toggle' ).addClass( className ).data( 'mode', mode );
			$( '.fl-field-responsive-setting-' + mode ).css( 'display', 'inline-block' );
		},

		/**
		 * Switches all responsive settings in a settings form
		 * to the current mode.
		 *
		 * @since 2.2
		 * @access private
		 * @method _switchAllSettingsToCurrentMode
		 */
		_switchAllSettingsToCurrentMode: function()
		{
			var self = FLBuilderResponsiveEditing;

			self._switchAllSettingsTo( self._mode );
			if( 'default' != self._mode ) {
				self._setMarginPaddingPlaceholders();
			}
			FLBuilder.triggerHook( 'responsive-editing-switched', self._mode );
		},

		/**
		 * Set Placeholders for Padding and Margin
		 *
		 * @since 2.4
		 * @access private
		 * @method _setMarginPaddingPlaceholders
		 */
		_setMarginPaddingPlaceholders: function()
		{
			var self = FLBuilderResponsiveEditing;
			var sizes = [ 'default', 'large', 'medium', 'responsive' ];
			var sides = ['top', 'left', 'bottom', 'right'];
			var inputs = {
				padding: {},
				margin: {}
			};

			sizes.forEach( function ( size ) {
				inputs.padding[ size ] = {};
				inputs.margin[ size ] = {};

				sides.forEach( function ( side ) {
					var name = 'default' === size ? side : side + '_' + size;
					inputs.padding[ size ][ side ] = $( '#fl-field-padding .fl-field-responsive-setting-' + size + ' input[name="padding_' + name + '"]' );
					inputs.margin[ size ][ side ] = $( '#fl-field-margin .fl-field-responsive-setting-' + size + ' input[name="margin_' + name + '"]' );
				} );
			} );

			sides.forEach( function( side ) {
				self._setSpacingInputPlaceholder( inputs, 'padding', 'large', 'default', side )
				self._setSpacingInputPlaceholder( inputs, 'padding', 'medium', 'large', side )
				self._setSpacingInputPlaceholder( inputs, 'padding', 'responsive', 'medium', side )
				self._setSpacingInputPlaceholder( inputs, 'margin', 'large', 'default', side )
				self._setSpacingInputPlaceholder( inputs, 'margin', 'medium', 'large', side )
				self._setSpacingInputPlaceholder( inputs, 'margin', 'responsive', 'medium', side )
			} );

			var isAuto = '1' === FLBuilderConfig.global.auto_spacing;
			var isRow = !! $( '.fl-builder-row-settings' ).length;
			var isCol = !! $( '.fl-builder-col-settings' ).length;

			if ( isAuto && ( isRow || isCol ) ) {
				inputs.margin.responsive.top.attr( 'placeholder', '0' );
				inputs.margin.responsive.right.attr( 'placeholder', '0' );
				inputs.margin.responsive.bottom.attr( 'placeholder', '0' );
				inputs.margin.responsive.left.attr( 'placeholder', '0' );
				inputs.padding.responsive.right.attr( 'placeholder', '0' );
				inputs.padding.responsive.left.attr( 'placeholder', '0' );
			}
		},

		/**
		 * Sets the placeholder for a single spacing input.
		 *
		 * @since 2.6
		 * @access private
		 * @method _setSpacingInputPlaceholder
		 */
		_setSpacingInputPlaceholder: function( inputs, property, size, fallbackSize, side )
		{
			var input = inputs[ property ][ size ][ side ];
			var fallback = inputs[ property ][ fallbackSize ][ side ];

			if ( ! input.attr( 'placeholder' ) || input.data( 'has-custom-placeholder' ) ) {
				input.data( 'has-custom-placeholder', true );

				if ( '' !== fallback.val() ) {
					input.attr( 'placeholder', fallback.val() );
				} else if ( fallback.attr( 'placeholder' ) ) {
					input.attr( 'placeholder', fallback.attr( 'placeholder' ) );
				}
			}
		},

		/**
		 * Callback for when the responsive toggle of a setting
		 * is clicked.
		 *
		 * @since 1.9
		 * @access private
		 * @method _settingToggleClicked
		 */
		_settingToggleClicked: function()
		{
			var toggle  = $( this ),
				mode    = toggle.data( 'mode' );

			if ( 'default' == mode ) {
				mode  = 'large';
			}
			else if ( 'large' == mode ) {
				mode  = 'medium';
			}
			else if ( 'medium' == mode ) {
				mode  = 'responsive';
			}
			else {
				mode  = 'default';
			}

			FLBuilderResponsiveEditing._switchAllSettingsTo( mode );
			FLBuilderResponsiveEditing._switchToAndScroll( mode );

			toggle.siblings( '.fl-field-responsive-setting:visible' ).find( 'input' ).focus();
		},

		/**
		 * Callback for when the main menu item is clicked.
		 *
		 * @since 2.2
		 * @access private
		 * @method _menuToggleClicked
		 */
		_menuToggleClicked: function()
		{
			var mode = FLBuilderResponsiveEditing._mode;

			if ( 'default' == mode ) {
				mode = 'large';
			} else if ( 'large' == mode ) {
				mode = 'medium';
			} else if ( 'medium' == mode ) {
				mode = 'responsive';
			} else {
				mode = 'default';
			}

			FLBuilder.MainMenu.hide();
			FLBuilderResponsiveEditing._switchAllSettingsTo( mode );
			FLBuilderResponsiveEditing._switchToAndScroll( mode );
		},

		/**
		 * Callback for when the switch buttons of the responsive
		 * preview header are clicked.
		 *
		 * @since 2.2
		 * @access private
		 * @method _previewToggleClicked
		 */
		_previewToggleClicked: function()
		{
			var mode = $( this ).data( 'mode' );
			FLBuilderResponsiveEditing._switchAllSettingsTo( mode );
			FLBuilderResponsiveEditing._switchToAndScroll( mode );
		},

		/**
		 * Clears the responsive editing preview and reverts
		 * to the default view.
		 *
		 * @since 1.9
		 * @access private
		 * @method _clearPreview
		 */
		_clearPreview: function()
		{
			FLBuilderResponsiveEditing._switchToAndScroll( 'default' );
		},

		/**
		 * Callback for when the responsive preview changes
		 * to live preview CSS for responsive fields.
		 *
		 * @since 1.9
		 * @access private
		 * @method _previewFields
		 */
		_previewFields: function()
		{
			var mode = FLBuilderResponsiveEditing._mode,
				form = $( '.fl-builder-settings:visible' );

			if ( 0 === form.length || undefined === form.attr( 'data-node' ) ) {
				return;
			}

			FLBuilder.triggerHook( 'responsive-editing-before-preview-fields', mode );

			form.find( '.fl-builder-settings-tab' ).each( function() {

				var tab = $( this );
				tab.css( 'display', 'block' );

				tab.find( '.fl-field-responsive-setting-' + mode + ':visible' ).each( function() {

					var field = $( this ),
						parent = field.closest( '.fl-field' ),
						type = parent.data( 'type' ),
						preview = parent.data( 'preview' ),
						hasConnection = parent.find( '.fl-field-connection-visible' ).length;

					if ( 'refresh' == preview.type ) {
						return;
					}

					if ( hasConnection ) {
						if ( 'photo' === type && 'default' !== mode ) {
							field.find( '.fl-photo-remove' ).trigger( 'click' );
						}
					} else{
						field.find( 'input' ).trigger( 'keyup' );
						field.find( 'select' ).trigger( 'change' );
					}
				} );

				tab.css( 'display', '' );
			} );

			FLBuilder.triggerHook( 'responsive-editing-after-preview-fields', mode );
		},
	};

	$( function() { FLBuilderResponsiveEditing._init() } );

} )( jQuery );
