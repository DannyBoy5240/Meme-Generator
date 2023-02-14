jQuery( document ).ready( function( $ ) {
	$.each( FLBuilderAdminNoticesConfig.notices, function( i, notice ) {
			var id = '.notice-id-' + notice.id;
			$(id + ' button.notice-dismiss').on('click', function(){
					$.post( FLBuilderAdminNoticesConfig.ajaxurl, {
						notice: notice.id,
						action: 'dismiss_fl_notice',
						notice_nonce: FLBuilderAdminNoticesConfig.notice_nonce
					} );
			});
	} );
} );
