( function( $ ) {

	/**
	 * Handles frontend editing UI logic for the builder.
	 *
	 * @class FLThemeBuilderFrontendEdit
	 * @since 1.0
	 */
	var FLThemeBuilderFrontendEdit = {

		/**
		 * Initialize.
		 *
		 * @since 1.0
		 * @access private
		 * @method _init
		 */
		_init: function()
		{
			this._bind();
			this._maybeShowOverrideWarning();
		},

		/**
		 * Bind events.
		 *
		 * @since 1.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			$( '.fl-builder-content:not(.fl-builder-content-primary)' ).on( 'mouseenter', this._partMouseenter );
			$( '.fl-builder-content:not(.fl-builder-content-primary)' ).on( 'mouseleave', this._partMouseleave );

			FLBuilder.addHook( 'showThemerOverrideSettings', this._showOverrideSettingsClicked.bind( this ) );
		},

		/**
		 * Shows a confirmation dialog warning the user if they are about
		 * to override a theme layout with a standard builder layout.
		 *
		 * @since 1.0
		 * @access private
		 * @method _maybeShowOverrideWarning
		 */
		_maybeShowOverrideWarning: function()
		{
			var enabled = FLBuilderConfig.builderEnabled,
				postType = FLBuilderConfig.postType,
				layouts = FLThemeBuilderConfig.layouts,
				strings = FLThemeBuilderConfig.strings,
				editMode = FLThemeBuilderConfig.editMode;

			if ( ! enabled && 'fl-theme-layout' != postType && 'undefined' != typeof layouts.singular && ! editMode ) {
				this._showOverrideSettings( true );
			}
		},

		/**
		 * @since 1.4
		 * @access private
		 * @method _showOverrideSettingsClicked
		 */
		_showOverrideSettingsClicked: function()
		{
			this._showOverrideSettings();
		},

		/**
		 * @since 1.4
		 * @access private
		 * @method _showOverrideSettings
		 */
		_showOverrideSettings: function( goBack )
		{
			var strings = FLThemeBuilderConfig.strings;

			var lightbox = new FLLightbox( {
				className: 'fl-builder-confirm-lightbox fl-builder-alert-lightbox',
				destroyOnClose: true
			} );

			var html = '<div class="fl-lightbox-message">' + strings.overrideWarning + '</div>';
			html += '<div class="fl-lightbox-footer">';
			html += '<span class="fl-builder-override-layout fl-builder-button fl-builder-button-large">' + strings.overrideWarningLayout + '</span>';
			html += '<span class="fl-builder-override-content fl-builder-button fl-builder-button-large">' + strings.overrideWarningContent + '</span>';
			html += '<span class="fl-builder-override-cancel fl-builder-button fl-builder-button-large fl-builder-button-primary">' + strings.overrideWarningCancel + '</span>';
			html += '</div>';

			lightbox.open( html );

			lightbox._node.find( '.fl-builder-override-layout' ).on( 'click', function() {
				FLBuilder.showAjaxLoader();
				FLLightbox.closeParent( this );
				FLBuilder.ajax( {
					action: 'disable_content_building_for_post'
				} );
				window.location.reload();
			} );

			lightbox._node.find( '.fl-builder-override-content' ).on( 'click', function() {
				FLBuilder.showAjaxLoader();
				FLLightbox.closeParent( this );
				FLBuilder.ajax( {
					action: 'enable_content_building_for_post'
				} );
				window.location.reload();
			} );

			lightbox._node.find( '.fl-builder-override-cancel' ).on( 'click', function() {
				FLLightbox.closeParent( this );
				if ( goBack ) {
					FLBuilder.showAjaxLoader();
					window.location.href = FLThemeBuilderConfig.adminEditURL;
				}
			} );

			FLBuilder.MainMenu.hide();
		},

		/**
		 * Shows the edit overlay when the mouse enters a
		 * header, footer or part.
		 *
		 * @since 1.0
		 * @access private
		 * @method _partMouseenter
		 */
		_partMouseenter: function()
		{
			// TODO
		},

		/**
		 * Removes the edit overlay when the mouse leaves a
		 * header, footer or part.
		 *
		 * @since 1.0
		 * @access private
		 * @method _partMouseleave
		 */
		_partMouseleave: function()
		{
			// TODO
		}
	};

	// Initialize
	$( function() { FLThemeBuilderFrontendEdit._init(); } );

} )( jQuery );
