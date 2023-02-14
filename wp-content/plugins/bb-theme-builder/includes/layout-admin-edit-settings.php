<table class="fl-theme-builder-settings-form fl-mb-table widefat">

	<tr class="fl-mb-row">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Type', 'bb-theme-builder' ); ?></label>
		</td>
		<td class="fl-mb-row-content">
			<?php

			echo ucwords( $type );

			if ( ! FLThemeBuilderLayoutData::is_layout_supported( $post->ID ) ) {
				echo ' <strong style="color:#a00;">(' . __( 'Unsupported', 'bb-theme-builder' ) . ')</strong>';
			}

			?>
			<input name="fl-theme-layout-type" type="hidden" value="<?php echo $type; ?>" />
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-hook-row">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Position', 'bb-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'The position on the page where this layout should appear.', 'bb-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-hook">
				<option value=""><?php _e( 'Choose...', 'bb-theme-builder' ); ?></option>
				<?php foreach ( $hooks as $hook_group ) : ?>
				<optgroup label="<?php echo $hook_group['label']; ?>">
					<?php foreach ( $hook_group['hooks'] as $key => $label ) : ?>
					<option value="<?php echo $key; ?>" <?php selected( $key, $hook ); ?>><?php echo $label; ?></option>
					<?php endforeach; ?>
				</optgroup>
				<?php endforeach; ?>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-order-row">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Order', 'bb-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'The order of this Themer layout when others are present.', 'bb-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<input name="fl-theme-layout-order" type="number" value="<?php echo ( '' == $order ? 0 : $order ); ?>" />
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-sticky">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Sticky', 'bb-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Stick this header to the top of the window as the page is scrolled.', 'bb-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-settings[sticky]">
				<option value="1" <?php selected( $settings['sticky'], '1' ); ?>><?php _e( 'Yes', 'bb-theme-builder' ); ?></option>
				<option value="0" <?php selected( $settings['sticky'], '0' ); ?>><?php _e( 'No', 'bb-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-sticky-on">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Sticky Breakpoint', 'bb-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'The screen size at which the sticky header gets applied.', 'bb-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<?php
				$sticky_on = isset( $settings['sticky-on'] ) ? $settings['sticky-on'] : '';
			?>
			<select name="fl-theme-layout-settings[sticky-on]">
				<option value="" <?php selected( $sticky_on, '' ); ?>><?php _e( 'Default', 'bb-theme-builder' ); ?></option>
				<option value="all" <?php selected( $sticky_on, 'all' ); ?>><?php _e( 'All screen sizes', 'bb-theme-builder' ); ?></option>
				<option value="xl" <?php selected( $sticky_on, 'xl' ); ?>><?php _e( 'Extra Large Devices Only', 'bb-theme-builder' ); ?></option>
				<option value="desktop" <?php selected( $sticky_on, 'desktop' ); ?>><?php _e( 'Extra Large &amp; Large Devices Only', 'bb-theme-builder' ); ?></option>
				<option value="desktop-medium" <?php selected( $sticky_on, 'desktop-medium' ); ?>><?php _e( 'Extra Large, Large &amp; Medium Devices Only', 'bb-theme-builder' ); ?></option>
				<option value="large" <?php selected( $sticky_on, 'large' ); ?>><?php _e( 'Large Devices Only', 'bb-theme-builder' ); ?></option>
				<option value="large-medium" <?php selected( $sticky_on, 'large-medium' ); ?>><?php _e( 'Large &amp; Medium Devices Only', 'bb-theme-builder' ); ?></option>
				<option value="medium" <?php selected( $sticky_on, 'medium' ); ?>><?php _e( 'Medium Devices Only', 'bb-theme-builder' ); ?></option>
				<option value="medium-mobile" <?php selected( $sticky_on, 'medium-mobile' ); ?>><?php _e( 'Medium &amp; Small Devices Only', 'bb-theme-builder' ); ?></option>
				<option value="mobile" <?php selected( $sticky_on, 'mobile' ); ?>><?php _e( 'Small Devices Only', 'bb-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-shrink">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Shrink', 'bb-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Shrink this header when the page is scrolled.', 'bb-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-settings[shrink]">
				<option value="1" <?php selected( $settings['shrink'], '1' ); ?>><?php _e( 'Yes', 'bb-theme-builder' ); ?></option>
				<option value="0" <?php selected( $settings['shrink'], '0' ); ?>><?php _e( 'No', 'bb-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-overlay">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Overlay', 'bb-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Overlay this header on top of the page content with a transparent background.', 'bb-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-settings[overlay]">
				<option value="1" <?php selected( $settings['overlay'], '1' ); ?>><?php _e( 'Yes', 'bb-theme-builder' ); ?></option>
				<option value="0" <?php selected( $settings['overlay'], '0' ); ?>><?php _e( 'No', 'bb-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="fl-mb-row fl-theme-layout-header-overlay-bg">
		<td  class="fl-mb-row-heading">
			<label><?php _e( 'Background', 'bb-theme-builder' ); ?></label>
			<i class="fl-mb-row-heading-help dashicons dashicons-editor-help" title="<?php esc_html_e( 'Use either the default background color or a transparent background color until the page is scrolled.', 'bb-theme-builder' ); ?>"></i>
		</td>
		<td class="fl-mb-row-content">
			<select name="fl-theme-layout-settings[overlay_bg]">
				<option value="default" <?php selected( $settings['overlay_bg'], 'default' ); ?>><?php _e( 'Default', 'bb-theme-builder' ); ?></option>
				<option value="transparent" <?php selected( $settings['overlay_bg'], 'transparent' ); ?>><?php _e( 'Transparent', 'bb-theme-builder' ); ?></option>
			</select>
		</td>
	</tr>

</table>
