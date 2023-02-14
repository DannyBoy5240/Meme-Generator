(function($) {

	/**
	 * Handles logic for the admin bar links.
	 *
	 * @class FLThemeBuilderAdminBar
	 * @since 1.0
	 */
	FLThemeBuilderAdminBar = {

		/**
		 * Initializes the admin bar.
		 *
		 * @since 1.0
		 * @access private
		 * @method _init
		 */
		_init: function() {
			this._bind();
		},

		/**
		 * Binds click events.
		 *
		 * @since 1.0
		 * @access private
		 * @method _bind
		 */
		_bind: function() {
			$('body').delegate('.fl-builder-ab-wrench', 'click', this.clickWrench);

			if ('undefined' !== typeof FLBuilder) {
				FLBuilder.addHook('endEditingSession', this.onPublish);
			}

		},

		onPublish: function() {
			redirect = FLThemeBuilderAdminBar.checkArgs('r');
			if ( 'undefined' !== typeof redirect && '' !== redirect ) {
				window.location.replace( redirect )
			}
		},

		/**
		 * Redirect to wp-admin edit page for layout.
		 *
		 * @since 1.3
		 * @access private
		 * @method clickWrench
		 */
		clickWrench: function(e) {
			e.preventDefault()
			link = $(this).data('edit')
			if (typeof(link) != "undefined") {
				decoded = decodeURIComponent(link).replace('&amp;', '&')
				window.location.replace(decoded);
			}
		},
		checkArgs: function(sParam) {
			var sPageURL = window.location.search.substring(1),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
				}
			}
		}
	};
	//
	// Initialize
	$(function() {
		FLThemeBuilderAdminBar._init();
	});

})(jQuery);
