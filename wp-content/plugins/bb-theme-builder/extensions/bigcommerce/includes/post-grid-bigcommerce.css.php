.fl-node-<?php echo $id; ?> .fl-post-feed-post,
.fl-node-<?php echo $id; ?> .fl-post-grid-post {
	overflow: visible !important;
}

<?php if ( ! empty( $settings->post_align ) ) : ?>
.fl-node-<?php echo $id; ?> .bc-product-form {
	<?php printf( 'text-align: %s', $settings->post_align ); ?>
}

.fl-node-<?php echo $id; ?> .bc-product__pricing--visible {
	<?php
	switch ( $settings->post_align ) {
		case 'center':
			print( 'margin: auto;' );
			break;
		case 'right':
			print( 'margin-left: auto;' );
			break;
		case 'left':
		default:
			break;
	}
	?>
}

.fl-node-<?php echo $id; ?> .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .bc-product-form__option-variants--inline,
.fl-node-<?php echo $id; ?> .bc-product-form__quantity {
	<?php
	switch ( $settings->post_align ) {
		case 'right':
			$align = 'flex-end';
			break;
		case 'center':
			$align = 'center';
			break;
		case 'left':
		default:
			$align = 'flex-start';
			break;
	}

	printf( 'justify-content: %s', $align );
	?>
}

<?php endif; ?>

<?php if ( 'show' === $settings->bc_refinery ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-archive__search-submit {
	<?php
	if ( ! empty( $settings->bc_refinery_search_button_background ) ) {
		printf( 'background-color: #%s;', $settings->bc_refinery_search_button_background );
	}
	if ( ! empty( $settings->bc_refinery_search_button_text_color ) ) {
		printf( 'color: #%s;', $settings->bc_refinery_search_button_text_color );
	}

	$props = FLBuilderCSS::border_field_props( $settings->bc_refinery_search_button_border );
	foreach ( $props as $key => $value ) {
		if ( ! empty( $value ) ) {
			if ( 'border-color' == $key ) {
				$value = '#' . $value;
			}
			printf( '%s: %s;', $key, $value );
		}
	}
	?>
}

<?php endif; ?>

<?php if ( ! empty( $settings->bc_brand_text ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__brand {
	<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_brand_text );
	foreach ( $props as $key => $value ) {
		if ( ! empty( $value ) ) {
			printf( '%s: %s;', $key, $value );
		}
	}
	?>
}

<?php endif; ?>

<?php if ( ! empty( $settings->bc_brand_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product__brand {
	<?php printf( 'color: #%s;', $settings->bc_brand_text_color ); ?>
}

<?php endif; ?>


<?php if ( ! empty( $settings->bc_price_form['original_price_typography'] ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-feed-post .on_sale .bc-product__original-price,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product__price,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .on_sale .bc-product__original-price,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product__price {
	<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_price_form['original_price_typography'] );
	foreach ( $props as $key => $value ) {
		if ( ! empty( $value ) ) {
			printf( '%s: %s;', $key, $value );
		}
	}
	?>
}

<?php endif; ?>


<?php if ( ! empty( $settings->bc_price_form['original_price_text_color'] ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .on_sale .bc-product__original-price,
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product__price,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .on_sale .bc-product__original-price,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product__price,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .on_sale .bc-product__original-price,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product__price {
	<?php printf( 'color: #%s', $settings->bc_price_form['original_price_text_color'] ); ?>;
}

<?php endif; ?>


/**
Calculated Price
 */
<?php if ( ! empty( $settings->bc_price_form['sale_price_typography'] ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .on_sale .bc-product__price,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .on_sale .bc-product__price,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .on_sale .bc-product__price {
	<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_price_form['sale_price_typography'] );
	foreach ( $props as $key => $value ) {
		if ( ! empty( $value ) ) {
			printf( '%s: %s;', $key, $value );
		}
	}
	?>
}

<?php endif; ?>


<?php if ( ! empty( $settings->bc_price_form['sale_price_text_color'] ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .on_sale .bc-product__price,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .on_sale .bc-product__price,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .on_sale .bc-product__price {
	<?php printf( 'color: #%s', $settings->bc_price_form['sale_price_text_color'] ); ?>;
}

<?php endif; ?>

/*
Sale Flash
---------------------------------------------------
 */
/* sale flash background */
<?php if ( ! empty( $settings->bc_sale_background_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product-flag--sale,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product-flag--sale,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product-flag--sale {
	background-color: <?php printf( '#%s', $settings->bc_sale_background_color ); ?>;
}

<?php endif; ?>

/* sale flash color */
<?php if ( ! empty( $settings->bc_sale_text_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product-flag--sale,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product-flag--sale,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product-flag--sale {
	color: <?php printf( '#%s', $settings->bc_sale_text_color ); ?>;
}

<?php endif; ?>

/*
Product Rating
---------------------------------------------------
 */

/* Link Typography */
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-single-product__reviews-anchor,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-single-product__reviews-anchor {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_rating_form->bc_link_typography );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		printf( '%s: %s;', $key, $value );
	}
}
?>
}

/* Link Color */
<?php if ( ! empty( $settings->bc_rating_form->bc_link_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-single-product__reviews-anchor,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-single-product__reviews-anchor {
	color: <?php printf( '#%s', $settings->bc_rating_form->bc_link_color ); ?>;
}

<?php endif; ?>

/* Link Hover Color */
<?php if ( ! empty( $settings->bc_rating_form->bc_link_hover_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-single-product__reviews-anchor:hover,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-single-product__reviews-anchor:hover {
	color: <?php printf( '#%s', $settings->bc_rating_form->bc_link_hover_color ); ?>;
}

<?php endif; ?>

/* Star Rating Background Color */
<?php if ( ! empty( $settings->bc_rating_form->bc_star_background ) ) : ?>
.fl-node-<?php echo $id; ?> .bc-single-product__rating--bottom {
	color: <?php printf( '#%s', $settings->bc_rating_form->bc_star_background ); ?>;
}

<?php endif; ?>

/* Star Rating Foreground Color */
<?php if ( ! empty( $settings->bc_rating_form->bc_star_foreground ) ) : ?>
.fl-node-<?php echo $id; ?> .bc-single-product__rating--top {
	color: <?php printf( '#%s', $settings->bc_rating_form->bc_star_foreground ); ?>;
}
<?php endif; ?>


/*
ADD TO CART FORM
---------------------------------------------------
*/
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product-form__modifiers,
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product-form__quantity-label,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product-form__modifiers,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product-form__quantity-label,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product-form__modifiers,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product-form__quantity-label {
<?php
	$props = FLBuilderCSS::typography_field_props( (array) $settings->bc_cart_form['bc_form_typography'] );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		if ( 'text-align' == $key ) {
			$key = 'justify-content';
			switch ( $value ) {
				case 'center':
					$value = 'center';
					break;
				case 'right':
					$value = 'flex-end';
					break;
				case 'left':
				default:
					$value = 'flex-start';
					break;
			}
		}
		printf( '%s: %s;', $key, $value );
	}
}
?>
}

<?php if ( ! empty( $settings->bc_cart_form['bc_form_text_color'] ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product-form__modifiers,
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-product-form__quantity-label,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product-form__modifiers,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-product-form__quantity-label,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product-form__option-label,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product-form__modifiers,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-product-form__quantity-label {
	color: <?php printf( '#%s', $settings->bc_cart_form['bc_form_text_color'] ); ?>;
}

<?php endif; ?>
.fl-node-<?php echo $id; ?> .fl-post-gallery-text-wrap .bc-btn,
.fl-node-<?php echo $id; ?> .fl-post-feed-post .bc-btn,
.fl-node-<?php echo $id; ?> .fl-post-grid-post .bc-btn {
<?php
$props = FLBuilderCSS::border_field_props( $settings->bc_cart_form['bc_button_border'] );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		printf( '%s: %s;', $key, $value );
	}
}
?>
}

<?php if ( ! empty( $settings->bc_cart_form['bc_button_background_color'] ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--view-product,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart {
	background-color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bc_cart_form['bc_button_background_color'] ); ?>;
}

<?php endif; ?>

<?php if ( ! empty( $settings->bc_cart_form['bc_button_text_color'] ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--view-product,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart {
	color: <?php echo FLBuilderColor::hex_or_rgb( $settings->bc_cart_form['bc_button_text_color'] ); ?>;
}

<?php endif; ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--view-product,
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--add_to_cart {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_cart_form['bc_button_typography'] );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		printf( '%s: %s;', $key, $value );
	}
}
?>
}


