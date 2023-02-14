.fl-node-<?php echo $id; ?> .fl-module-content {
	text-align: <?php echo $settings->align; ?>;
}


/**
Original Price
 */
<?php if ( ! empty( $settings->original_price_typography ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .on_sale .bc-product__original-price,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__price {
	<?php
	$props = FLBuilderCSS::typography_field_props( $settings->original_price_typography );
	foreach ( $props as $key => $value ) {
		printf( '%s: %s;', $key, $value );
	}
	?>
}

<?php endif; ?>


<?php if ( ! empty( $settings->original_price_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .on_sale .bc-product__original-price,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__price {
	color: #<?php echo $settings->original_price_text_color; ?>;
}

<?php endif; ?>

/**
Calculated Price
 */
<?php if ( ! empty( $settings->sale_price_typography ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .on_sale .bc-product__price {
	<?php
	$props = FLBuilderCSS::typography_field_props( $settings->sale_price_typography );
	foreach ( $props as $key => $value ) {
		printf( '%s: %s;', $key, $value );
	}
	?>
}

<?php endif; ?>


<?php if ( ! empty( $settings->sale_price_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .on_sale .bc-product__price {
	color: #<?php echo $settings->sale_price_text_color; ?>;
}

<?php endif; ?>
