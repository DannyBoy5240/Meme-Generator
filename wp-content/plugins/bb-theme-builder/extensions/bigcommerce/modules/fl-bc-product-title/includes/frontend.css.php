.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__title {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->title_text );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		printf( '%s: %s;', $key, $value );
	}
}
?>
}

<?php if ( ! empty( $settings->title_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__title {
	color: #<?php echo $settings->title_text_color; ?>;
}

<?php endif; ?>
