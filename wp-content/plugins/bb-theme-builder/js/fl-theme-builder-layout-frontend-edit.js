( function( $ ) {

	/**
	 * Handles frontend editing UI logic for theme layouts.
	 *
	 * @class FLThemeBuilderLayoutFrontendEdit
	 * @since 1.0
	 */
	FLThemeBuilderLayoutFrontendEdit = {

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
			this._initContent();
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
			$( '.fl-theme-builder-preview-select' ).on( 'click', this._togglePreviewSelect );
			$( '.fl-theme-builder-preview-select-item' ).on( 'click', this._togglePreviewSelectItem );
			$( '.fl-theme-builder-preview-select-item' ).delegate( '.fl-theme-builder-preview-select-item-child', 'click', this._previewSelectItemChildClicked );
		},

		/**
		 * Shows or hides the preview select menu.
		 *
		 * @since 1.0
		 * @access private
		 * @method _togglePreviewSelect
		 */
		_togglePreviewSelect: function()
		{
			var select = $( '.fl-theme-builder-preview-select' );

			select.toggleClass( 'fl-theme-builder-preview-select-open' );
		},

		/**
		 * Shows or hides an items children in the preview
		 * select menu. Grabs children via AJAX if needed.
		 *
		 * @since 1.0
		 * @access private
		 * @method _togglePreviewSelectItem
		 */
		_togglePreviewSelectItem: function( e )
		{
			var item     = $( e.target ).closest( '.fl-theme-builder-preview-select-item' );
				children = item.find( '.fl-theme-builder-preview-select-item-children' ),
				loc      = item.attr( 'data-location' ),
				loaded   = item.attr( 'data-children-loaded' );
				loader   = $( '<img src="' + FLBuilderLayoutConfig.paths.pluginUrl + 'img/ajax-loader.svg" />' ),
				title    = $( '.fl-theme-builder-preview-select-title div span' );

			if ( undefined != loc ) {

				loc = loc.split( ':' );

				if ( 'general' == loc[0] ) {

					title.text( item.text() );

					$( '.fl-theme-builder-preview-select' ).removeClass( 'fl-theme-builder-preview-select-open' );

					FLBuilder.showAjaxLoader();

					FLBuilder.ajax( {
						action: 'update_preview_location',
						location: item.attr( 'data-location' )
						}, function() {
							FLBuilder.showAjaxLoader();
							window.parent.location.reload( true );
						} );
				} else if ( '0' == loaded ) {

					children.append( loader );

					if ( 'post' == loc[0] ) {
						FLBuilder.ajax( {
							action: 'get_preview_posts',
							post_type: loc[1]
						}, FLThemeBuilderLayoutFrontendEdit._previewSelectPostsLoaded );
					} else if ( 'taxonomy' == loc[0] ) {
						FLBuilder.ajax( {
							action: 'get_preview_terms',
							taxonomy: loc[1]
						}, FLThemeBuilderLayoutFrontendEdit._previewSelectTermsLoaded );
					}
				}
			}

			$( '.fl-theme-builder-preview-select-item-open' ).removeClass( 'fl-theme-builder-preview-select-item-open' );

			item.addClass( 'fl-theme-builder-preview-select-item-open' );

			e.stopPropagation();
		},

		/**
		 * Callback for when posts have finished loading for
		 * the preview select.
		 *
		 * @since 1.0
		 * @access private
		 * @method _previewSelectPostsLoaded
		 * @param {String} response
		 */
		_previewSelectPostsLoaded: function( response )
		{
			var data     = JSON.parse( response ),
				item     = $( '[data-location="post:' + data.postType + '"]' ),
				children = item.find( '.fl-theme-builder-preview-select-item-children' ),
				i        = 0;

			item.attr( 'data-children-loaded', '1' );
			children.find( 'img' ).remove();

			for ( ; i < data.objects.length; i++ ) {
				children.append( '<div class="fl-theme-builder-preview-select-item-child" data-location="post:' + data.postType + ':' + data.objects[ i ].id + '">' + data.objects[ i ].name + '</div>' );
			}
		},

		/**
		 * Callback for when terms have finished loading for
		 * the preview select.
		 *
		 * @since 1.0
		 * @access private
		 * @method _previewSelectTermsLoaded
		 * @param {String} response
		 */
		_previewSelectTermsLoaded: function( response )
		{
			var data     = JSON.parse( response ),
				item     = $( '[data-location="taxonomy:' + data.taxonomy + '"]' ),
				children = item.find( '.fl-theme-builder-preview-select-item-children' ),
				i        = 0;

			item.attr( 'data-children-loaded', '1' );
			children.find( 'img' ).remove();

			for ( ; i < data.objects.length; i++ ) {
				children.append( '<div class="fl-theme-builder-preview-select-item-child" data-location="taxonomy:' + data.taxonomy + ':' + data.objects[ i ].id + '">' + data.objects[ i ].name + '</div>' );
			}
		},

		/**
		 * Sets the preview context when an item child is clicked.
		 *
		 * @since 1.0
		 * @access private
		 * @method _previewSelectItemChildClicked
		 */
		_previewSelectItemChildClicked: function( e )
		{
			var child = $( e.target ).closest( '.fl-theme-builder-preview-select-item-child' );
				title = $( '.fl-theme-builder-preview-select-title div span' );

			title.text( child.text() );

			$( '.fl-theme-builder-preview-select' ).removeClass( 'fl-theme-builder-preview-select-open' );
			$( '.fl-theme-builder-preview-select-item-open' ).removeClass( 'fl-theme-builder-preview-select-item-open' );

			FLBuilder.showAjaxLoader();

			FLBuilder.ajax( {
				action: 'update_preview_location',
				location: child.attr( 'data-location' )
				}, function() {
					FLBuilder.showAjaxLoader();
					window.parent.location.reload( true );
				} );

			e.stopPropagation();
		},

		/**
		 * When editing a "part" the main builder content area will
		 * be moved to replace the part for editing.
		 *
		 * @since 1.0
		 * @access private
		 * @method _initContent
		 */
		_initContent: function()
		{
			var part   = $( '.fl-builder-content-primary[data-type="part"]' ),
				content = $( '.fl-builder-content-primary:not([data-type="part"])' );

			if ( part.length ) {
				content.after( '<div class="fl-theme-builder-content-placeholder" style="padding: 200px 100px; text-align:center; opacity:0.5;">Content Area</div>' );
				part.after( content );
				part.remove();
			}
		}
	};

	// Initialize
	$( function() { FLThemeBuilderLayoutFrontendEdit._init(); } );

} )( jQuery );
