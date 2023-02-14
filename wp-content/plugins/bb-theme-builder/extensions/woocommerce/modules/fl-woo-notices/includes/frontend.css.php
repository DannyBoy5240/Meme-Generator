<?php if ( ! empty( $settings->font_size ) ) : ?>
.woocommerce-page .fl-node-<?php echo $id; ?> .fl-woo-notices .woocommerce-message,
.woocommerce-page .fl-node-<?php echo $id; ?> .fl-woo-notices .woocommerce-message a.button {
	font-size: <?php echo $settings->font_size; ?>px; 
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-woo-notices .woocommerce-message {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->text_color ); ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->woo_notices_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-woo-notices .woocommerce-message {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->woo_notices_bg_color ); ?>;
}
<?php endif; ?>

<?php
FLBuilderCSS::border_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'woo_notices_border',
	'selector'     => ".fl-node-$id .fl-woo-notices .woocommerce-message",
) );

FLBuilderCSS::typography_field_rule( array(
	'settings'     => $settings,
	'setting_name' => 'woo_notices_typography',
	'selector'     => ".fl-node-$id .fl-woo-notices .woocommerce-message",
) );
