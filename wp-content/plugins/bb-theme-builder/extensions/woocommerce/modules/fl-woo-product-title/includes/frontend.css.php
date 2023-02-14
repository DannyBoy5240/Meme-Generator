.fl-node-<?php echo $id; ?> .fl-module-content {
	text-align: <?php echo $settings->align; ?>;
}

<?php if ( ! empty( $settings->font ) && 'Default' != $settings->font['family'] ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .product_title {
	<?php FLBuilderFonts::font_css( $settings->font ); ?>
}
<?php endif; ?>

<?php if ( ! empty( $settings->font_size ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .product_title {
font-size: <?php echo $settings->font_size; ?>px;
}
<?php endif; ?>

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .product_title {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>
