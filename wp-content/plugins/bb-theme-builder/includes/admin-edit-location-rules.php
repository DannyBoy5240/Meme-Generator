<table class="fl-theme-builder-locations-form fl-mb-table widefat">
	<tr class="fl-mb-row fl-theme-builder-location-rules">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Location', 'bb-theme-builder' ); ?></label>
			<?php /* translators: %s: singular_name */ ?>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr( sprintf( __( 'Add locations for where this %s should appear.', 'bb-theme-builder' ), $post_type->labels->singular_name ) ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<div class="fl-theme-builder-saved-locations fl-theme-builder-saved-rules"></div>
			<div class="fl-theme-builder-add-location fl-theme-builder-add-rule">
				<a href="javascript:void(0);" class="fl-theme-builder-add-location fl-theme-builder-add-rule button"><?php _e( 'Add Location Rule', 'bb-theme-builder' ); ?></a>
			</div>
			<div class="fl-theme-builder-add-exclusion fl-theme-builder-add-rule">
				<a href="javascript:void(0);" class="fl-theme-builder-add-exclusion fl-theme-builder-add-rule button"><?php _e( 'Add Exclusion Rule', 'bb-theme-builder' ); ?></a>
			</div>
		</td>
	</tr>
	<tr class="fl-mb-row fl-theme-builder-location-rules fl-theme-builder-exclusion-rules">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Exclude', 'bb-theme-builder' ); ?></label>
			<?php /* translators: %s: singular_name */ ?>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr( sprintf( __( 'This %s will not appear at these locations.', 'bb-theme-builder' ), $post_type->labels->singular_name ) ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<div class="fl-theme-builder-saved-locations fl-theme-builder-saved-rules"></div>
			<div class="fl-theme-builder-add-location fl-theme-builder-add-rule">
				<a href="javascript:void(0);" class="fl-theme-builder-add-location fl-theme-builder-add-rule button"><?php _e( 'Add Exclusion Rule', 'bb-theme-builder' ); ?></a>
			</div>
		</td>
	</tr>
</table>

<script type="text/html" id="tmpl-fl-theme-builder-saved-location">
	<div class="fl-theme-builder-saved-location fl-theme-builder-saved-rule">
		<div class="fl-theme-builder-saved-rule-select">
			<select name="fl-theme-builder-{{data.type}}[]" class="fl-theme-builder-location">
				<option value=""><?php esc_html_e( 'Choose...', 'bb-theme-builder' ); ?></option>
				<?php foreach ( $locations['by_post_type'] as $group ) : ?>
				<optgroup label="<?php echo $group['label']; ?>">
					<?php foreach ( $group['locations'] as $location ) : ?>
					<option value='<?php echo json_encode( $location ); ?>' data-type="<?php echo $location['type']; ?>" data-location="<?php echo $location['type'] . ':' . $location['id']; ?>"><?php echo $location['label']; ?></option>
					<?php endforeach; ?>
				</optgroup>
				<?php endforeach; ?>
			</select>
			<select name="fl-theme-builder-{{data.type}}-objects[]" class="fl-theme-builder-location-objects fl-theme-builder-rule-objects">
				<option value=""><?php esc_html_e( 'Choose...', 'bb-theme-builder' ); ?></option>
			</select>
		</div>
		<div class="fl-theme-builder-remove-rule-button">
			<i class="fl-theme-builder-remove-location fl-theme-builder-remove-rule dashicons dashicons-dismiss"></i>
		</div>
	</div>
</script>
