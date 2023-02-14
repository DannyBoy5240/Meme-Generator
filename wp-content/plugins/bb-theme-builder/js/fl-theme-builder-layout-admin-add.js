( function( $ ) {

	/**
	 * Handles logic for the add new interface for theme layouts.
	 *
	 * @class FLThemeBuilderLayoutAdminAdd
	 * @since 1.0
	 */
	FLThemeBuilderLayoutAdminAdd = {

		/**
		 * Initializes add new interface for theme layouts.
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
		 * Binds events for the add new form.
		 *
		 * @since 1.0
		 * @access private
		 * @method _bind
		 */
		_bind: function()
		{
			$( 'select.fl-template-type' ).on( 'change', this._templateTypeChange );

			this._templateTypeChange();
		},

		/**
		 * Callback for when the template type select changes.
		 *
		 * @since 1.0
		 * @access private
		 * @method _templateTypeChange
		 */
		_templateTypeChange: function()
		{
			var val    = $( 'select.fl-template-type' ).val(),
				layout = $( '.fl-template-theme-layout-row' ),
				add    = $( '.fl-template-add' );

			layout.toggle( 'theme-layout' == val );

			if ( '' == val ) {
				add.val( FLBuilderConfig.strings.addButton.add );
			} else {
				add.val( FLBuilderConfig.strings.addButton[ val ] );
			}
		}
	};

	// Initialize
	$( function() { FLThemeBuilderLayoutAdminAdd._init(); } );

} )( jQuery );
