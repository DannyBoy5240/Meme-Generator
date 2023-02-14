<?php if ( ! empty( $settings->bg_color ) ) : ?>
.fl-page .fl-builder-content .fl-node-<?php echo $id; ?> form.cart button.button,
.fl-page .fl-builder-content .fl-node-<?php echo $id; ?> form.cart button.button.alt.disabled {
	background: <?php echo FLBuilderColor::hex_or_rgb( $settings->bg_color ); ?>;
	border-color: <?php echo FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $settings->bg_color, 12, 'darken' ) ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->bg_color_hover ) ) : ?>
.fl-page .fl-builder-content .fl-node-<?php echo $id; ?> form.cart button.button:hover {
	background: <?php echo FLBuilderColor::hex_or_rgb( $settings->bg_color_hover ); ?>;
	border-color: <?php echo FLBuilderColor::hex_or_rgb( FLBuilderColor::adjust_brightness( $settings->bg_color_hover, 12, 'darken' ) ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-page .fl-builder-content .fl-node-<?php echo $id; ?> form.cart button.button,
.fl-page .fl-builder-content .fl-node-<?php echo $id; ?> form.cart button.button.alt.disabled  {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color_hover ) ) : ?>
.fl-page .fl-builder-content .fl-node-<?php echo $id; ?> form.cart button.button:hover {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_color_hover ); ?>;
}
<?php endif; ?>
