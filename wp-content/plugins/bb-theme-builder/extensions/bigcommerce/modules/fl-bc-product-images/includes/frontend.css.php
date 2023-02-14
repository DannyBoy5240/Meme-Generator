/*
	Sale Flash
	---------------------------------------------------
 */
/* sale flash background */
<?php if ( ! empty( $settings->bc_sale_background_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-flag--sale {
	background-color: <?php printf( '#%s', $settings->bc_sale_background_color ); ?>;
}

<?php endif; ?>

/* sale flash color */
<?php if ( ! empty( $settings->bc_sale_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-flag--sale {
	color: <?php printf( '#%s', $settings->bc_sale_text_color ); ?>;
}
<?php endif; ?>
