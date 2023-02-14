.fl-node-<?php echo $id; ?> .fl-module-content {

	text-align: <?php echo $settings->align; ?>;

	<?php if ( ! empty( $settings->font_size ) ) : ?>
	font-size: <?php echo $settings->font_size; ?>px;
	<?php endif; ?>
}

<?php if ( ! empty( $settings->text_color ) ) : ?>
.woocommerce div.product .fl-node-<?php echo $id; ?> .fl-module-content p.price {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>
