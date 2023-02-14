(function($){

	/**
	 * Handles custom logic for the settings forms of the
	 * post modules.
	 *
	 * @class FLThemeBuilderPostModuleSettings
	 * @since 1.0
	 */
	FLThemeBuilderPostModuleSettings = {

		/**
		 * Cached settings used to replace the current settings
		 * if the post layout changes are canceled.
		 *
		 * @since 1.0
		 * @access private
		 * @property {String} _previousSettings
		 */
		_previousSettings: null,

		/**
		 * Initialize.
		 *
		 * @since 1.0
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			FLBuilder.addHook( 'settings-form-init', $.proxy( this._loaded, this ) );
		},

		/**
		 * Fires when the settings form has loaded.
		 *
		 * @since 1.0
		 * @access private
		 * @method _loaded
		 */
		_loaded: function()
		{
			if ( $( '.fl-builder-post-grid-settings:visible' ).length > 0 ) {
				this._bindMainSettings();
			} else if ( $( '[data-type="custom_post_layout"]:visible' ).length > 0 ) {
				this._bindCustomPostLayoutSettings();
			}
		},

		/**
		 * Bind events to the main settings lightbox.
		 *
		 * @since 1.0
		 * @access _bindMainSettings
		 * @method _bind
		 */
		_bindMainSettings: function()
		{
			this._layoutChanged();
			this._postLayoutChanged();

			$( 'select[name=layout]' ).on( 'change', this._layoutChanged );
			$( 'select[name=post_layout]' ).on( 'change', this._postLayoutChanged );
		},

		/**
		 * Bind events to the custom post layout lightbox.
		 *
		 * @since 1.0
		 * @access _bindCustomPostLayoutSettings
		 * @method _bind
		 */
		_bindCustomPostLayoutSettings: function()
		{
			var form   = $( '[data-type="custom_post_layout"]:visible' ),
				html   = form.find( 'textarea[name="html"]' ),
				css    = form.find( 'textarea[name="css"]' ),
				cancel = form.find( '.fl-builder-settings-cancel' );

			html.on( 'change', $.proxy( this._doCustomPostLayoutPreview, this ) );
			css.on( 'change', $.proxy( this._doCustomPostLayoutPreview, this ) );
			cancel.on( 'click', $.proxy( this._cancelClicked, this ) );
		},

		/**
		 * Fires when the layout select changes.
		 *
		 * @since 1.0
		 * @access private
		 * @method _layoutChanged
		 */
		_layoutChanged: function()
		{
			var val      = $( 'select[name=layout]' ).val(),
				settings = $( 'form.fl-builder-settings' );

			settings.removeClass( 'fl-post-grid-layout-columns' );
			settings.removeClass( 'fl-post-grid-layout-grid' );
			settings.removeClass( 'fl-post-grid-layout-gallery' );
			settings.removeClass( 'fl-post-grid-layout-feed' );
			settings.addClass( 'fl-post-grid-layout-' + val );
		},

		/**
		 * Fires when the post layout select changes.
		 *
		 * @since 1.0
		 * @access private
		 * @method _postLayoutChanged
		 */
		_postLayoutChanged: function()
		{
			var val      = $( 'select[name=post_layout]' ).val(),
				settings = $( 'form.fl-builder-settings' );

			if ( 'default' == val ) {
				settings.removeClass( 'fl-post-grid-layout-custom' );
			} else {
				settings.addClass( 'fl-post-grid-layout-custom' );
			}
		},

		/**
		 * Callback for previewing custom post layouts.
		 *
		 * @since 1.0
		 * @access private
		 * @method _doCustomPostLayoutPreview
		 */
		_doCustomPostLayoutPreview: function()
		{
			var moduleForm     = $( '.fl-builder-module-settings' ),
				moduleSettings = FLBuilder._getSettings( moduleForm ),
				postForm       = $( '.fl-builder-settings[data-type="custom_post_layout"]' ),
				postSettings   = FLBuilder._getSettings( postForm ),
				postField      = moduleForm.find( '[name="custom_post_layout"]' ),
				preview        = FLBuilder.preview;

			if ( ! this._previousSettings ) {
				this._previousSettings = moduleSettings.custom_post_layout
			}

			postField.val( JSON.stringify( postSettings ) );
			preview.delay( 2000, $.proxy( preview.preview, preview ) );
		},

		/**
		 * Callback for when the custom post layout settings
		 * lightbox cancel button is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _cancelClicked
		 */
		_cancelClicked: function()
		{
			var postField = $( '.fl-builder-module-settings' ).find( '[name="custom_post_layout"]' );

			if ( this._previousSettings ) {
				postField.val( this._previousSettings ).trigger( 'change' );
				this._previousSettings = null;
			}
		}
	};

	$( function(){ FLThemeBuilderPostModuleSettings._init() } );

})(jQuery);
