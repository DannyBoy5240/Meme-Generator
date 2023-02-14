<?php if ( 'no' === $settings->show_add_to_cart ) : ?>
.fl-node-<?php echo $id; ?> a.add_to_cart_button {
	display: none;
}
<?php endif; ?>

<?php if ( ! empty( $settings->heading_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .related.products > h2 {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->heading_text_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->heading_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .related.products > h2 {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->heading_bg_color ); ?>;
}
<?php endif; ?>
