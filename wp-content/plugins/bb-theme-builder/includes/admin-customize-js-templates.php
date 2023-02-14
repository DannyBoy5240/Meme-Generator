<script type="text/html" id="tmpl-fl-theme-builder-header-footer-message">
	<div id="theme-builder-header-footer-message">
		<strong><?php _e( 'Note:', 'bb-theme-builder' ); ?> </strong>
		<# if ( data.message == 'header-footer' ) { #>
		<?php _e( 'The header and footer for this page were created with a Themer layout. Some of these settings may not apply.', 'bb-theme-builder' ); ?>
		<# } else if ( data.message == 'header' ) { #>
		<?php _e( 'The header for this page was created with a Themer layout. Some of these settings may not apply.', 'bb-theme-builder' ); ?>
		<# } else { #>
		<?php _e( 'The footer for this page was created with a Themer layout. Some of these settings may not apply.', 'bb-theme-builder' ); ?>
		<# } #>
	</div>
</script>
