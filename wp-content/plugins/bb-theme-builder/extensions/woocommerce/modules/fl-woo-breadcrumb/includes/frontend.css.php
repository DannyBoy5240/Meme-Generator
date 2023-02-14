.fl-node-<?php echo $id; ?> .fl-module-content .woocommerce-breadcrumb {

	text-align: <?php echo $settings->align; ?>;

	<?php if ( ! empty( $settings->font_size ) ) : ?>
	font-size: <?php echo $settings->font_size; ?>px;
	<?php endif; ?>
}

<?php if ( ! empty( $settings->text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .woocommerce-breadcrumb {
	color: #<?php echo $settings->text_color; ?>;
}
<?php endif; ?>

<?php if ( ! empty( $settings->link_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .woocommerce-breadcrumb a {
	color: #<?php echo $settings->link_color; ?>;
}
<?php endif; ?>
