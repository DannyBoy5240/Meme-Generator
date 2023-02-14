( function( $ ) {

	/**
	 * Handles logic for the togglesfor theme templates.
	 *
	 * @class FLThemeBuilderTemplatesAdminList
	 * @since 1.3
	 */
	FLThemeBuilderTemplatesAdminList = {

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
			$( document ).on( 'change', '.column-fl_enabled input', this._templateChangeState );
			this._UpdateText()
		},

		_UpdateText: function() {
			$( '.column-fl_enabled input' ).each(function(i){
				var status = $(this).is( ':checked' );
				if ( 'true' === status ) {
					$(this).attr('title', window.fl_builder_templates_status.change_to_draft)
				} else {
					$(this).attr('title', window.fl_builder_templates_status.change_to_publish)
				}
			})
		},

		/**
		 * Callback for when the template type select changes.
		 *
		 * @since 1.0
		 * @access private
		 * @method _templateTypeChange
		 */
		_templateChangeState: function()
		{
			var checkbox = $(this),
				id = checkbox.data('id'),
				status = checkbox.is( ':checked' ) ? 'publish' : 'draft';

			var data = {
				action: 'fl_template_switch',
				status: status,
				id: id,
				_wpnonce: window.fl_builder_templates_status.nonce
			}

			$.post(window.ajaxurl, data, function(response) {
				window.location.reload( true );
			});
		}
	};

	// Initialize
	$( function() { FLThemeBuilderTemplatesAdminList._init(); } );

} )( jQuery );
