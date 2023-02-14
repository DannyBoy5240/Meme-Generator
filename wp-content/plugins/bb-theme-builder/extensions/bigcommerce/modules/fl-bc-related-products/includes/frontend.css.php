.fl-node-<?php echo $id; ?> .fl-module-content {
	text-align: <?php echo $settings->align; ?>;
}

/* Section Title */
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__section-title--related {
<?php
$props = FLBuilderCSS::typography_field_props( $settings->bc_related_products_section_title );
foreach ( $props as $key => $value ) {
	printf( '%s: %s !important;', $key, $value );
}
?>
}

<?php if ( ! empty( $settings->bc_related_products_section_title_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__section-title--related {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bc_related_products_section_title_color ); ?>;
}

<?php endif; ?>

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

/* Product Title */
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__title-link {
<?php
$props = FLBuilderCSS::typography_field_props( $settings->bc_related_products_title );
foreach ( $props as $key => $value ) {
	printf( '%s: %s;', $key, $value );
}
?>
}

<?php if ( ! empty( $settings->bc_related_products_title_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__title-link {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bc_related_products_title_color ); ?>;
}

<?php endif; ?>

/* Button */

<?php if ( ! empty( $settings->bc_button_background_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--view-product {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bc_button_background_color ); ?>;
}

<?php endif; ?>

<?php if ( ! empty( $settings->bc_button_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--view-product {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bc_button_text_color ); ?>;
}

<?php endif; ?>

.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--view-product  {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_button_typography );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		printf( '%s: %s;', $key, $value );
	}
}
?>
}

.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--view-product  {
<?php
$props = FLBuilderCSS::border_field_props( $settings->bc_button_border );
foreach ( $props as $key => $value ) {
	if ( 'border-color' == $key ) {
		printf( 'border-color: %s;', FLBuilderColor::hex_or_rgb( $value ) );
	} else {
		printf( '%s: %s;', $key, $value );
	}
}
?>
}
