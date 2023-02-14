<?php
$settings = FLBuilderAdminAdvanced::get_settings();
$groups   = FLBuilderAdminAdvanced::get_groups();
?>
<div id="fl-advanced-form" class="fl-settings-form">
	<h3 class="fl-settings-form-header"><?php _e( 'Advanced Settings', 'fl-builder' ); ?></h3>
	<?php if ( FLBuilderUserAccess::current_user_can( 'fl_builder_advanced_options' ) ) : ?>
	<form id="advanced-form" action="<?php FLBuilderAdminSettings::render_form_action( 'advanced' ); ?>" method="post">

		<?php
		foreach ( $groups as $group_key => $group ) {
			printf( '<div class="advanced-group"><h3>%s</h3>', $group['label'] );
			foreach ( $settings as $key => $setting ) {
				if ( $setting['group'] != $group_key ) {
					continue;
				}
				$disabled = '';

				if ( isset( $setting['type'] ) && 'text' == $setting['type'] ) {
					if ( isset( $setting['depends'] ) && ! get_option( "_fl_builder_{$setting['depends']}" ) ) {
						continue;
					}
					$description = isset( $setting['description'] ) ? sprintf( '&nbsp;<i class="dashicons dashicons-editor-help" title="%s"></i>', $setting['description'] ) : '';
					$link        = isset( $setting['link'] ) && ! FLBuilderModel::is_white_labeled() ? sprintf( '&nbsp;<a target="_blank" href="%s"><i class="dashicons dashicons-external" title="%s"></i></a>', $setting['link'], __( 'Documentation', 'fl-builder' ) ) : '';
					$value       = get_option( "_fl_builder_{$key}", $setting['default'] );
					printf( '<div class="advanced-option"><span class="title">%s%s%s</span><div class="text-option"><div class="save-button"><button class="button button-small button-primary" data-id="%s">Update</button></div><input class="text" type="text" id="%s" name="%s" value="%s"></div></div>', $setting['label'], $description, $link, $key, $key, $key, $value );
				} else {
					$hasdepend   = isset( $setting['hasdepend'] ) ? ' data-depend="true"' : '';
					$description = isset( $setting['description'] ) ? sprintf( '&nbsp;<i class="dashicons dashicons-editor-help" title="%s"></i>', $setting['description'] ) : '';
					$link        = isset( $setting['link'] ) && ! FLBuilderModel::is_white_labeled() ? sprintf( '&nbsp;<a target="_blank" href="%s"><i class="dashicons dashicons-external" title="%s"></i></a>', $setting['link'], __( 'Documentation', 'fl-builder' ) ) : '';
					$checked     = checked( get_option( "_fl_builder_{$key}", $setting['default'] ), 1, false );
					printf( '<div class="advanced-option"><span class="title">%s%s%s</span><div class="toggleWrapper"><input class="mobileToggle" type="checkbox" id="%s" name="%s" value="%s"%s%s><label for="%s"></label></div></div>', $setting['label'], $description, $link, $key, $key, $setting['default'], $checked, $hasdepend, $key );
				}
			}
			echo '</div>';
		}
		?>
	<p class="submit">
		<?php wp_nonce_field( 'advanced', 'fl-advanced-nonce' ); ?>
	</p>
	</form>
<?php else : ?>
	<?php printf( '<p>%s</p>', __( 'You do not have permission to view this page.', 'fl-builder' ) ); ?>
<?php endif; ?>
</div>
