<tr class="fl-template-theme-layout-row" style="display: none;">
	<th>
		<label for="fl-template[theme-layout]"><?php _e( 'Layout', 'bb-theme-builder' ); ?></label>
	</th>
	<td>
		<select name="fl-template[theme-layout]">
			<optgroup label="<?php _e( 'Structure', 'bb-theme-builder' ); ?>">
				<option value="header"><?php _e( 'Header', 'bb-theme-builder' ); ?> <?php echo ( ! $headers ) ? __( '(Unsupported)', 'bb-theme-builder' ) : ''; ?></option>
				<option value="footer"><?php _e( 'Footer', 'bb-theme-builder' ); ?> <?php echo ( ! $footers ) ? __( '(Unsupported)', 'bb-theme-builder' ) : ''; ?></option>
			</optgroup>
			<optgroup label="<?php _e( 'Content', 'bb-theme-builder' ); ?>">
				<option value="archive"><?php _e( 'Archive', 'bb-theme-builder' ); ?></option>
				<option value="singular"><?php _e( 'Singular', 'bb-theme-builder' ); ?></option>
				<option value="404"><?php _e( '404', 'bb-theme-builder' ); ?></option>
				<option value="part"><?php _e( 'Part', 'bb-theme-builder' ); ?> <?php echo ( ! $parts || empty( $hooks ) ) ? __( '(Unsupported)', 'bb-theme-builder' ) : ''; ?></option>
			</optgroup>
		</select>
	</td>
</tr>
