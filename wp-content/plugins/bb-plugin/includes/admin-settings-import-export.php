<div id="fl-import-export-form" class="fl-settings-form">
	<h3 class="fl-settings-form-header"><?php _e( 'Import / Export Settings', 'fl-builder' ); ?></h3>
	<p>
			<input type="button" class="button button-primary export" value="<?php _e( 'Export Settings', 'fl-builder' ); ?>" />
	</p>
	<p>
		<input type="button" class="button button-primary import" value="<?php _e( 'Import Settings', 'fl-builder' ); ?>" />
	</p>
	<p>
		<input style="background:red;border-color:red" type="button" class="button button-primary reset" value="<?php _e( 'Reset Settings', 'fl-builder' ); ?>" />
	</p>
	<?php wp_nonce_field( 'fl_builder_import_export' ); ?>
	<p>
		<?php
		$link = sprintf( '<a target="_blank" href="https://docs.wpbeaverbuilder.com/beaver-builder/management-migration/import-export-settings">%s</a>', esc_attr__( 'documentation', 'fl-builder' ) );
		// translators: %s: Link to documentation
		printf( __( 'See %s for more information.', 'fl-builder' ), $link );
		?>
	</p>
</div>
