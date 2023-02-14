<table class="fl-theme-builder-users-form fl-mb-table widefat">
	<tr class="fl-mb-row">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Users', 'bb-theme-builder' ); ?></label>
			<?php /* translators: %s: singular_name */ ?>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php echo esc_attr( sprintf( __( 'Choose which users should be able to view this %1$s. If none are selected, all users will see this %1$s.', 'bb-theme-builder' ), $post_type->labels->singular_name ) ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<div class="fl-theme-builder-saved-user-rules fl-theme-builder-saved-rules"></div>
			<div class="fl-theme-builder-add-user-rule fl-theme-builder-add-rule">
				<a href="javascript:void(0);" class="fl-theme-builder-add-user-rule fl-theme-builder-add-rule button"><?php _e( 'Add User Rule', 'bb-theme-builder' ); ?></a>
			</div>
		</td>
	</tr>
</table>

<script type="text/html" id="tmpl-fl-theme-builder-saved-user-rule">
	<div class="fl-theme-builder-saved-user-rule fl-theme-builder-saved-rule">
		<div class="fl-theme-builder-saved-rule-select">
			<select name="fl-theme-builder-user-rule[]"  class="fl-theme-builder-user-rule">
				<option value=""><?php _e( 'Choose...', 'bb-theme-builder' ); ?></option>
				<?php foreach ( $rules as $group_key => $group_data ) : ?>
				<optgroup label="<?php echo $group_data['label']; ?>">
					<?php foreach ( $group_data['rules'] as $rule_key => $rule_data ) : ?>
					<option value='<?php echo json_encode( $rule_data ); ?>' data-rule="<?php echo $rule_data['type'] . ':' . $rule_data['id']; ?>"><?php echo $rule_data['label']; ?></option>
					<?php endforeach; ?>
				</optgroup>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="fl-theme-builder-remove-rule-button">
			<i class="fl-theme-builder-remove-user-rule fl-theme-builder-remove-rule dashicons dashicons-dismiss"></i>
		</div>
	</div>
</script>
