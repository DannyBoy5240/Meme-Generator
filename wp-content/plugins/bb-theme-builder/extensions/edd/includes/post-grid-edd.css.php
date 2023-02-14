<?php if ( ! empty( $settings->edd_price_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-edd-meta {
	color: #<?php echo $settings->edd_price_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->edd_price_font_size ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-edd-meta {
	font-size: <?php echo $settings->edd_price_font_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->edd_button_bg_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-edd-button .edd-add-to-cart {
	background: #<?php echo $settings->edd_button_bg_color; ?>;
	border-color: #<?php echo FLBuilderColor::adjust_brightness( $settings->edd_button_bg_color, 12, 'darken' ); ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->edd_button_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-module-edd-button .edd-add-to-cart {
	color: #<?php echo $settings->edd_button_text_color; ?>;
}
<?php endif; ?>
