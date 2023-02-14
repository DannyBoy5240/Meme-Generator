
/* Star Rating Background Color */
<?php if ( ! empty( $settings->bc_star_background ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__rating--bottom {
	color: <?php printf( '#%s', $settings->bc_star_background ); ?>;
}
<?php endif; ?>

/* Star Rating Foreground Color */
<?php if ( ! empty( $settings->bc_star_foreground ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-single-product__rating--top {
	color: <?php printf( '#%s', $settings->bc_star_foreground ); ?>;
}
<?php endif; ?>

/* Review Form Title */
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-review-form__title {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_review_form_title_typography );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		printf( '%s: %s !important;', $key, $value );
	}
}
?>
}

<?php if ( ! empty( $settings->bc_review_form_title_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-review-form__title {
	color: #<?php echo $settings->bc_review_form_title_color; ?>;
}
<?php endif; ?>

/* Review Section Title */
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-reviews__title {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_reviews_title_typography );
foreach ( $props as $key => $value ) {
	if ( ! empty( $value ) ) {
		printf( '%s: %s;', $key, $value );
	}
}
?>
}

<?php if ( ! empty( $settings->bc_reviews_title_color ) ) : ?>
.fl-node-<?php echo $id; ?> .fl-module-content .bc-product-reviews__title {
	<?php printf( 'color: #%s;', $settings->bc_reviews_title_color ); ?>
}
<?php endif; ?>

/* Submit Button */
.fl-node-<?php echo $id; ?> .fl-module-content .bc-btn--review {
<?php
	$props = FLBuilderCSS::typography_field_props( $settings->bc_review_form_submit_button_text );
foreach ( $props as $key => $value ) {
	printf( '%s: %s;', $key, $value );
}

if ( ! empty( $settings->bc_review_form_submit_button_background_color ) ) {
	printf( 'background-color: #%s;', $settings->bc_review_form_submit_button_background_color );
}

if ( ! empty( $settings->bc_review_form_submit_button_text_color ) ) {
	printf( 'color: #%s;', $settings->bc_review_form_submit_button_text_color );
}

	$props = FLBuilderCSS::border_field_props( $settings->bc_review_form_submit_button_border );
foreach ( $props as $key => $value ) {
	printf( '%s: %s;', $key, $value );
}
?>
}
