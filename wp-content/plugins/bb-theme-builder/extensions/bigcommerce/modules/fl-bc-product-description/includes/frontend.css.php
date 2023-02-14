.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__description {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->description_text );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		printf( '%s: %s;', $key, $value );
	}
}

if ( ! empty( $settings->description_text_color ) ) {
	printf( 'color: #%s;', $settings->description_text_color );
}
?>
}
